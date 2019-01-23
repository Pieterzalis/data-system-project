<?php


// Load core model
// This will also load DB config
require_once 'Model_Core.php';
require_once 'Model_User.php';

//
// Save Methods
//

/*
 * Function to insert a project in to the database, should check the project code first.
 * Function returns the created project ID
*/
function saveQuestionArray($questions, $project_id) {

	// Loop through questions array, do Insert query for each
	$questions_ids = array();

	$i = 0;
	foreach($questions as $question) {
		$i++;

		DB::insert('question', array(
			'question_project_id' => $project_id,
			'question_title' => $question,
			'question_number' => $i
		));

        // Get the inserted question ID, needed to insert questions
        $question_id = DB::insertId();

        // Get the inserted question_id and add to return array
        array_push($questions_ids, DB::insertId());

	}

	// Return the project ID
	return $questions_ids;
}


//
//
// Get Methods
//
//

// Function to return a html list of projects
// TODO this will simply get all projects, no html is build yet.
// TODO NOTE !!!!! All untested!!
function getQuestionListByProject($project_id) {
	$html = "";
	$results = DB::query("SELECT * FROM question WHERE question_project_id = " . $project_id . " ");


	// TODO build HTML according to screens
	foreach ($results as $row) {
		$question_title = $row["question_title"];
		$html .= "<p>" . $question_title . "</p>";
	}
	echo $html;
}

// Function that will return html code for presenting questions assigned for the given user
function getQuestionListByAssignedExpert($user_id) {
	$html = "";

	if (isUserExpert($user_id)){
		// User is expert, do query

		// We have to check the question_has_experts table contains this user_id
		$assigned_questions = getAssignedQuestions($user_id);

		// TODO Next step is to look up the project_ids for
		// every corresponding question in the assigned question list
		// Should return associative array with
		// TODO This is going to take time to make

	} else{
		// User is not an expert, return false or something.
		exit();
	}

	return $html;

}

// Function looking up question IDs in question_has_experts table
function getAssignedQuestions($user_id){

	$results = DB::query("SELECT question_id 
							FROM question_has_experts 
							WHERE user_id = " . $user_id . " ");


	if (DB::count() === 0){
		echo 'Query returned no results';
	}

	return $results;


}

function getUnansweredQuestionList() {

    $query = "SELECT 
                p.project_id,
                p.project_date_letter,
                p.project_code,
                p.project_title,
                REPLACE(CONCAT(pm.parliamentmember_firstname, ' ', pm.parliamentmember_lastname_prefix, ' ', pm.parliamentmember_lastname), '  ', ' ') AS indiener_fullname, 
                pa.party_name,
                q.question_id, 
                q.question_project_id 
                FROM question q
                INNER JOIN project p ON q.question_project_id = p.project_id
                INNER JOIN parliamentmember pm on p.project_submitter = pm.parliamentmember_id
                INNER JOIN party pa ON pm.parliamentmember_party_id = pa.party_id
                WHERE NOT EXISTS (
                    SELECT qhe.question_id 
                    FROM question_has_experts qhe
                    WHERE q.question_id = qhe.question_id					
                ) ";

    $results = DB::query($query);

    return $results;

}

function getDistributionProjectCardsHtml() {
    // Create html project cards for every unanswered question.
    $html = "";
    $unanswered_questions = getUnansweredQuestionList();

    // Now build a project card for every unique project
    $projectID = 0;

    if (empty($unanswered_questions)) {

        // No results present card that nothing is found.
        $html .= "";

    } else {

        // Loop through unique projects
        foreach ($unanswered_questions as $row) {

            // Dutch date format
            $date_letter_dutch = date('d-m-Y', strtotime($row['project_date_letter']));
            $date_deadline = date('d-m-Y', strtotime($date_letter_dutch . "+3 week"));

            // Check for new project ID compared to previous question
            if ($projectID != $row['project_id']) {

                // Set project ID in this loop iteration
                $projectID = $row['project_id'];

                // Get amount of toegewezen vragen
                $amount_assigned = getAmountAssignedInProject($projectID);

                // Now build the card
                $html .= "
                        <div class=\"col-xl-6 col-md-12\">
                            <div class=\"toewijzencard\">
                                <div class=\"card text-center\">
                                    <p>Kamervragen #".$row['project_code']."</p>
                                    <h4>".$row['project_title']."</h4>
                                    <span>Deadline: <strong>".$date_deadline."</strong></span>
                                    <p>Indiener: <strong>" . $row['indiener_fullname'] . " - " . $row['party_name'] . "</strong></p>
                                    <h5>Toegewezen vragen: ".$amount_assigned['assigned']."/".$amount_assigned['total']."</h5>
                                    <div class=\"toewijzenbutton\"><button type=\"button\" class=\"btn btn-primary shadow bluebutton toewijzenbutton\" onclick=\"location.href = 'distribution-detail?id=".$projectID."'\">Toewijzen</button></div>
                                </div>
                            </div>
                        </div>";

            }
        }

    }

    echo $html;

}

function getAmountAssignedInProject($project_id) {

    $question_count = DB::queryFirstRow(" SELECT COUNT(`question_id`) as amountQ
                                     FROM `question`
                                     WHERE `question_project_id`='$project_id' ");

    $amount_questions = (int)$question_count['amountQ'];

    DB::query("SELECT * FROM question_has_experts qhe INNER JOIN question q ON q.question_id = qhe.question_id WHERE q.question_project_id = '$project_id' ");
    $assigned_count = DB::count();
    // Build return array

    $returnarray = [
        "assigned" => $assigned_count,
        "total" => $amount_questions
    ];

    return $returnarray;

}


