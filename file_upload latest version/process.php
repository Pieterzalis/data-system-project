<?php

require_once '../website/database/Model_Core.php';
require_once '../website/database/Model_Project.php';
require_once '../website/database/Model_Question.php';
require_once '../website/database/Model_Keyword.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['files'])) {
        $errors = [];
        $path = '../uploads/';
        $extensions = ['pdf','docx'];

        $all_files = count($_FILES['files']['tmp_name']);

        for ($i = 0; $i < $all_files; $i++) {  
            $file_name = $_FILES['files']['name'][$i];
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

                // Call function to save data to the database
	            prepareDataforDB();


                if (!$move_file){
                	// Moving file went wrong
	                echo 'Error uploading, moving file';
                }

            }
        }

        if ($errors) print_r($errors);
    }
}


function prepareDataforDB()
{

	// TODO replace dummy data with Python script data !!! using the uploaded letter.
	// TODO, for that also pass the pdf path in the function parameters..

	// Dummy data here
	$id = '2019Z103944' . rand(100, 999);
	$indiener = 'Dijkhoff';
	$topic = file_get_contents('https://loripsum.net/api/1/short/plaintext'); // <- this will generate some random latin text; for testing purposes.
	$date = "14 januari 2019";
	$questions = array();
	array_push($questions, 'Vraag 1 Heeft u kennisgenomen van het bericht x?');
	array_push($questions, 'Vraag 2 Heeft u kennisgenomen van het bericht x?');
	array_push($questions, 'Vraag 3 Bent u geschokt over het feit dat dit rapport laat zien blabla?');
	array_push($questions, 'Vraag 4 Bent u geschokt over het feit dat dit rapport laat zien blabla?');
	$keywords = array();
	array_push($keywords, 'omstandigheden');
	array_push($keywords, 'rapport');
	array_push($keywords, 'contact');
	array_push($keywords, 'gehad');


	// End dummy data

	//$id = $data->metadata->id;
	$indiener = getIndiener($indiener);

	// We don't need the party, name is enough.
	//$party = getParty($data->metadata->indiener);
	$title = ucfirst($topic);

	// TODO redo this... this is ugly
	$date_english = dutch_strtotime($date);
	$date_int = (int)$date_english;
	$date = date("Y-m-d", $date_int);

	$questions = getQuestions($questions);

	//$keywords = $data->keywords;

	// When done, call save to database function.

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

	$html = '';

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
                                                <p>Ingediend op: <Strong>'. $project_date_letter .'</Strong></p>
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
                                                        <label>Indieners</label>
                                                    </div>
                                                    <p><Strong>XX XXXXX XXXXXXX XXXXX XXXXXXX XXXXX XXXXXX</Strong></p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- row-table -->
                                        <div class="project-table">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2"> Title</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="bg-app-light">
                                                        <td class="text-right"> content：</td>
                                                        <td class="text-left"> XX XXXXX XXXXXXX XXXXX XXXXXXX XXXXX XXXXXXXX XXXXX XXXXXXX XXXXX XXXXXXX XXXXX XXXXXXXX XX XXXXXXXX XXXXX XXXXXXX XXXXX XXXXXXX XXXXX XXX</td>
                                                    </tr>
                                                    <tr class="bg-app-light">
                                                        <td class="text-right"> content：</td>
                                                        <td class="text-left"> XX XXXXX XXXXXXX XXXXX XXXXXXX XXXXX XXXXXXXX XXXXX XXXXXXX XXXXX XXXXXXX XXXXX XXXXXXXX XX XXXXXXXX XXXXX XXXXXXX XXXXX XXXXXXX XXXXX XXX</td>
                                                    </tr>
                                                    <tr class="bg-app-light">
                                                        <td class="text-right"> content：</td>
                                                        <td class="text-left"> XX XXXXX XXXXXXX XXXXX XXXXXXX XXXXX XXXXXXXX XXXXX XXXXXXX XXXXX XXXXXXX XXXXX XXXXXXXX XX XXXXXXXX XXXXX XXXXXXX XXXXX XXXXXXX XXXXX XXX</td>
                                                    </tr>
                                                    <tr class="bg-app-light">
                                                        <td class="text-right"> content：</td>
                                                        <td class="text-left"> XX XXXXX XXXXXXX XXXXX XXXXXXX XXXXX XXXXXXXX XXXXX XXXXXXX XXXXX XXXXXXX XXXXX XXXXXXXX XX XXXXXXXX XXXXX XXXXXXX XXXXX XXXXXXX XXXXX XXX</td>
                                                    </tr>
                                                    <tr class="bg-app-light">
                                                        <td class="text-right"> content：</td>
                                                        <td class="text-left"> XX XXXXX XXXXXXX XXXXX XXXXXXX XXXXX XXXXXXXX XXXXX XXXXXXX XXXXX XXXXXXX XXXXX XXXXXXXX XX XXXXXXXX XXXXX XXXXXXX XXXXX XXXXXXX XXXXX XXX</td>
                                                    </tr>
                                                    <tr class="bg-app-light">
                                                        <td class="text-right"> content：</td>
                                                        <td class="text-left"> XX XXXXX XXXXXXX XXXXX XXXXXXX XXXXX XXXXXXXX XXXXX XXXXXXX XXXXX XXXXXXX XXXXX XXXXXXXX XX XXXXXXXX XXXXX XXXXXXX XXXXX XXXXXXX XXXXX XXX</td>
                                                    </tr>
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
	if (strpos($string, '(') != false){
		$string = trim(substr($string, 0, (strpos($string, '('))));
	}

	return $string;
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
