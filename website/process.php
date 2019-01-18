<?php

require_once 'database/Model_Core.php';
require_once 'database/Model_Project.php';
require_once 'database/Model_Question.php';
require_once 'database/Model_Keyword.php';
require_once 'database/Model_Parliament.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['files'])) {
        $errors = [];
        $path = 'uploads/';
        $extensions = ['pdf','docx'];

        $all_files = count($_FILES['files']['tmp_name']);

        for ($i = 0; $i < $all_files; $i++) {  
            #$file_name = $_FILES['files']['name'][$i];
            $file_name = 'tmp.pdf';
            $file_tmp = $_FILES['files']['tmp_name'][$i];
            $file_type = $_FILES['files']['type'][$i];
            $file_size = $_FILES['files']['size'][$i];
            $exploded = explode('.', $_FILES['files']['name'][$i]);
            $file_ext = strtolower(end($exploded));

            $file = $path . $file_name;

            if (!in_array($file_ext, $extensions)) {
                $errors[] = 'Extension not allowed: ' . $file_name . ' ' . $file_type;
            }

            if ($file_size > 2097152) {
                $errors[] = 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
            }

            if (empty($errors)) {
                $move_file = move_uploaded_file($file_tmp, $file);
                if (!$move_file){
                	// Moving file went wrong
	                echo 'Error uploading, moving file';
                }

            }
        }

        if ($errors) print_r($errors);
    }
}

parseLetter();

function parseLetter()
{
    // TODO make this dynamic with the upload script!
    $file_path = htmlentities('uploads/tmp.pdf');
    $python_path = htmlentities('read_qf.py');
    $file_name = basename($file_path);

    // Execute python script for parsing the letter
    exec("python " . $python_path . " " . $file_path . "", $output, $ret_code);

    $output_data = end($output);

    if ($output_data === false) {
        $output_data = null;
        echo 'Error: Python returned no output';
    } else {
        $json = json_decode($output_data);
        prepareDataforDB($json);
    }
}

function prepareDataforDB($data)
{
    // Transform JSON object elements to workable strings to save to DB
   # echo '<h1> Preparing data for db for Project Code: ' . $data->metadata->id . '</h1>';

    $id = $data->metadata->id;
    $indiener = getIndiener($data->metadata->indiener);
    $party = getParty($data->metadata->indiener);
    $title = ucfirst($data->metadata->topic);

    // TODO redo this... this is ugly
    $date_english = dutch_strtotime($data->metadata->date);
    $date_int = (int)$date_english;
    $date = date("Y-m-d", $date_int);

    $questions = getQuestions($data->questions);

    $keywords = $data->keywords;

    // Insert project in the DB!
    saveProjectandQuestions($id, $indiener, $title, $date, $questions, $keywords);

}

function saveProjectandQuestions($project_code, $project_indiener, $project_title, $project_date_letter,
                                 $questions, $keywords){

    // First save the project and return the project ID
    $project_id = saveProject($project_code, $project_indiener, $project_date_letter, $project_title);

    // Now we have the project_id we can save all questions with reference to the project
    $questions_ids = saveQuestionArray($questions, $project_id);

    // Also insert the keywords we have extracted into the DB
    $keywords_ids = saveKeywordArray($keywords, $project_id);

    //Now build html
    returnHTMLResponse($project_id, $questions, $keywords, $project_indiener, $project_date_letter);
}

function returnHTMLResponse($project_id, $questions, $keywords, $project_indiener, $project_date_letter){

    // Convert dates to dutch format and deadline fixed 3 weeks later
    $project_date_letter = date('d-m-Y', strtotime($project_date_letter));
    $deadline_date = date('d-m-Y', strtotime($project_date_letter . "+3 week"));

    $html = '';

    //Get indiener full name by ID
    $indiener_fullname = getPMemberFullNameByName($project_indiener);

    // With project, get the following data:
    /// - project_title
    /// - party_name

    $results = DB::query("SELECT p.*, parliamentmember_firstname, parliamentmember_lastname_prefix, parliamentmember_lastname, party_name 
							FROM `project` p 
							INNER JOIN `parliamentmember` on project_submitter = parliamentmember_id 
							INNER JOIN `party` on parliamentmember_party_id = party_id 
							WHERE project_id = " . $project_id . " ");

    $html_keywords = '';
    foreach($keywords as $keyword) {
        $html_keywords .= '<span class="badge badge-pill badge-secondary">' . ucfirst($keyword) . '</span>';
    }

    $html_questions = '';
    $i = 1;
    foreach($questions as $question) {
        $html_questions .= '<tr class="bg-app-light">
                                <td class="text-nowrap text-right"> Vraag ' . $i . ':</td>
                                <td class="text-left">' . $question . '</td>
                            </tr>';
        $i++;
    }


    // Add it all together
    $html .= '
            <!-- title -->
            <div class="title mt-2 mx-2">
                <h4>Controleer het nieuwe project</h4>
                <hr class="color-app">
            </div>

            <!-- row-info -->
            <div class="project-info">
                <div>

                    <div class="mb-0">
                        <label>Project Titel</label>
                    </div>
                    <div id="projectTitleID">
                        <p><Strong>'. $results[0]["project_title"] .'</Strong></p>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm d-flex flex-row-reverse">
                    		<p style="margin-bottom: 0;">Ingediend op: </p>
                        </div>
                        <div class="col-sm d-flex flex-row">
                            <p><strong>'. $project_date_letter .'</strong></p>
                        </div>
                    </div>
    				<div class="row">
                        <div class="col-sm d-flex flex-row-reverse">
                    		<p>Voorlopige deadline: </p>
                        </div>
    					<div class="col-sm d-flex flex-row">
                            <p><strong>'. $deadline_date .'</strong></p>
    					</div>
                    </div>
                    
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-sm col-md-6 col-lg-4">

                        <div class="mb-0">
                            <label>Keywords</label>
                        </div>
                        <div>
                            ' . $html_keywords . '
                        </div>
                    </div>
                    <div class="col-sm col-md-6 col-lg-4">
                        <div class="mb-0">
                            <label>Indiener</label>
                        </div>
                        <p><Strong>'. $indiener_fullname .'</Strong></br>'. $results[0]["party_name"] .'</p>
                    </div>
                </div>
            </div>

            <!-- row-table -->
            <div class="project-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="2">Vragen</th>
                        </tr>
                    </thead>
                    <tbody>
                        ' . $html_questions . '
                    </tbody>
                </table>
            </div>
        ';

    echo $html;


}

function getIndiener($string)
{
    // TODO add support for strings with 'leden'
    // Need to set substring so it only contains indiener name
    if (strpos($string, '(') != false) {
        $string = trim(substr($string, 0, (strpos($string, '('))));
    }
    return $string;
}

function getParty($string)
{
    // TODO fix this
    // Need to set substring so it only contains indiener name
    $strpos_start = strpos($string, '(') +1;
    $strpos_end = strpos($string, ')' ) ;

    $str = substr($string, $strpos_start, $strpos_end-$strpos_start);

    return $str;
}

function getQuestions($questions){

    // Strip 'vraag 1; vraag 2; etc from question
    $questions_stripped = array();

    $i = 1;
    foreach ($questions as $question) {

        // Get position of question number
        $strpos_number = strpos($question, ''.$i.'') + 2; // Add 2 to include the number and space after it
        array_push($questions_stripped, (substr($question, $strpos_number)));

        $i++;
    }

    return $questions_stripped;
}

