<?php


// Load core model
// This will also load DB config
require_once 'Model_Core.php';
require_once 'Model_Parliament.php';

//
// Handle any ajax post requests to this file here
//
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	if (isset($_REQUEST['func'])) {

		if ($_REQUEST['func'] === 'getAssignedQuestionsHtml' && $_REQUEST['id'] != '') {
			getAssignedQuestionsHtml($_REQUEST['id']);
		}
	}

}
//
// Save Methods
//

/*
 * Function to insert a project in to the database, should check the project code first.
 * Function returns the created project ID
*/
function saveProject($project_code, $project_submitter_name, $date_letter_mysql, $project_title) {

    // TODO also check if the project_code exists, if it does, we cannot insert.
    // Right now it will give error when trying to inset duplicate unique key

    // Fake the project_submitter until we have full authentication system
    // TODO create real authentication
    $project_upload_user_id = 1;                           // id 1 has role 'bestuursondersteuning'
    $project_date_upload = date("Y-m-d H:i:s");     // Gets current date and time

    // TODO Translate project submitter (lastname) to a parliamentarian ID
    // We don't need to insert the party since it is linked to the parliamentarian record
    $project_submitter = getPMemberIDByLastname($project_submitter_name);
    if (is_null($project_submitter)) {
        exit("No such submitter found, please check if the last name is correct.");
    }

    DB::insert('project', array(
        'project_code' => $project_code,
        'project_date_upload' => $project_date_upload,
        'project_upload_user_id' => $project_upload_user_id,
        'project_submitter' => $project_submitter,
        'project_date_letter' => $date_letter_mysql,
        'project_title' => $project_title
    ));

    // Get the inserted project ID, needed to insert questions
    $project_id = DB::insertId();

    // Return the project ID
    return $project_id;
}


//
//
// Get Methods
//
//

// Function to return a html display of a project card on the kamervragen overzicht page
// Based on the user_id of the expert.

function getAssignedQuestionsHtml($user_id) {
    $html = "";
    $res_proj_questions = DB::query("SELECT project_id, 
                        project_title, 
                        project_date_letter,
                        REPLACE(CONCAT(parliamentmember_firstname, ' ', parliamentmember_lastname_prefix, ' ', parliamentmember_lastname), '  ', ' ') AS indiener_fullname, 
                        party_name,
                        question_title,
                        question_id,
                        question_number
                        FROM question 
                        INNER JOIN project ON question_project_id = project_id
                        INNER JOIN parliamentmember on project_submitter = parliamentmember_id
                        INNER JOIN party ON parliamentmember_party_id = party_id
                        WHERE question_id IN (
                                SELECT question_id FROM question_has_experts
                                WHERE user_id = $user_id
                        )
                        ORDER BY project_id DESC
    "); // End Query

    // Now build a project card for every unique project

    $projectID = 0;

    if (empty($res_proj_questions)) {
        $html .= "
            <div class=\"card project-card\" id=\"project-card-1\">
                                <div class=\"card-body\">
                                    <table class=\"table table-sm mb-0\">
                                        <p>Geen kamervragen gevonden.</p>
                                    </table>           
                                        </div>
                          </div>
        
        ";
    } else {
        // TODO build HTML according to screens
        foreach ($res_proj_questions as $row) {
            if ($projectID != $row['project_id']) {

                // Dutch format
                $date_letter_dutch = date('d-m-Y', strtotime($row['project_date_letter']));
                $date_deadline = date('d-m-Y', strtotime($date_letter_dutch . "+3 week"));

                // Set project ID in this loop iteration
                $projectID = $row['project_id'];

                // Build the project card here
                $html .= "
                            <div class=\"card project-card\" id=\"project-card-1\">
                                <div class=\"card-body\">
                                    <table class=\"table table-sm mb-0\">
                                        <tbody>
                                            <tr>
                                                <td class=\"no-border max-width-table\"
                                                    scope=\"row\">Project:</td>
                                                <th class=\"no-border\"
                                                    scope=\"row\">" . $row['project_title'] . "</th>
                                            </tr>
                                            <tr>
                                                <td class=\"no-border max-width-table\"
                                                    scope=\"row\">Indiener:</td>
                                                <th class=\"no-border\"
                                                    scope=\"row\">" . $row['indiener_fullname'] . " - " . $row['party_name'] . " </th>
                                            </tr>
                                            <tr>
                                                <td class=\"no-border max-width-table\"
                                                    scope=\"row\">Ingediend op:</td>
                                                <th class=\"no-border\"
                                                    scope=\"row\">" . $date_letter_dutch . "</th>
                                            </tr>
                                            <tr>
                                                <td class=\"no-border max-width-table\"
                                                    scope=\"row\">Current deadline:</td>
                                                <th class=\"no-border\"
                                                    scope=\"row\">" . $date_deadline . "</th>
                                            </tr>
                                            <tr>
                                                <td class=\"no-border pt-4\"
                                                    scope=\"row\">Vragen:</td>
                                            </tr>
                                        </tbody>
                                    </table>";

                // TODO add database field for question_number and show them here
                // Right now ill just count them
                $i = 0;
                foreach ($res_proj_questions as $q_item) {
                    if ($q_item['project_id'] === $projectID) {

                        $source_result = DB::queryFirstRow(" SELECT COUNT(`source_id`) AS amount_sources 
                                     FROM `source`
                                     WHERE `source_active`=1 
                                     AND `source_question_id` = " . $q_item["question_id"] . " ");
                        $amount_sources = $source_result['amount_sources'];


                        $i++;
                        $html .= "           <!-- begin questions!!! -->
                                    <ul class=\"my-list-group container-fluid\">
                                        <a class=\"child-item\" \">
                                        <li onclick=\"changePage(this,{pageId:" . $q_item['question_id'] . "})\" class=\"my-list-group-item py-2 py-md-3 mb-2 mb-md-3 rounded bg-app text-white row align-items-center questions\">
                                            <div class=\"col-3 col-md-auto pr-sm-2 pr-md-3\">#" . $q_item['question_number'] . "</div>
                                            <div class=\"col-9 col-md px-sm-2 px-md-3 border-md-right\">" . $q_item['question_title'] . "</div>
                                            <div class=\"col-9 col-md-auto px-sm-2 px-md-3\">
                                                <span class=\"fa-stack\">
                                                    <i class=\"fa fa-floppy-o fa-stack-2x\"
                                                       aria-hidden=\"true\"></i>
                                                </span>
                                                <span class=\"fa-stack\">
                                                    <i class=\"fa fa-circle fa-stack-2x\"></i>
                                                    <i class=\"fa fa-stack-1x fa-inverse text-dark\">" . $amount_sources . "</i>
                                                </span>
                                                <span>opgeslagen bronnen</span>
                                            </div>
                                            <div class=\"col-3 col-md-auto pl-sm-4 pl-md-3\">
                                                <i class=\"fa fa-angle-right\"
                                                   aria-hidden=\"true\"></i>
                                            </div>
                                        </li></a>
                                    </ul>";

                    }
                }

                // Close the card divs
                $html .= "    </div>
                          </div>";
                // End creating html
            }

        }

    }


    echo $html;
}





