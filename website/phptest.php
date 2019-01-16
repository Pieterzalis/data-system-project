<?php
#$command = escapeshellcmd("python C:\\Users\\flori\\OneDrive\\Documenten\\hello.py");
#$output = shell_exec($command);
require_once 'database/Model_Core.php';
require_once 'database/Model_Project.php';

parseLetter();

function parseLetter()
{
    // TODO make this dynamic with the upload script!
    $file_path = htmlentities('uploads/2019Z00318.pdf');
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

        echo '<h2>Raw parse results of letter: ' . $file_name . '</h2>';
        echo '<p>Project Code: ' . $json->metadata->id . '</p>';
        echo '<p>Indiener: ' . $json->metadata->indiener . '</p>';
        echo '<p>Topic of project: ' . $json->metadata->topic . '</p>';
        echo '<p>Date of letter: ' . $json->metadata->date . '</p>';

        echo '<h3>Questions in letter:</h3>';
        foreach ($json->questions as $question) {
            echo '<p>' . $question . '</p>';
        }

        echo '<h3>Keywords extracted from letter:</h3>';
        foreach ($json->keywords as $keyword) {
            echo '<p>' . $keyword . '</p>';
        }

        prepareDataforDB($json);

    }
}

function prepareDataforDB($data)
{
    // Transform JSON object elements to workable strings to save to DB
    echo '<h1> Preparing data for db for Project Code: ' . $data->metadata->id . '</h1>';

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

    // When done, call save to database function.

    // Echo results
    echo '<p>Project Code: ' . $id . '</p>';
    echo '<p>Indiener: ' . $indiener . '</p>';
    echo '<p>Party: ' . $party . '</p>';
    echo '<p>Topic of project: ' . $title . '</p>';
    echo '<p>Date of letter: ' . $date . '</p>';

    echo '<h3>Questions in letter:</h3>';
    foreach ($questions as $question) {
        echo '<p>' . $question . '</p>';
    }

    echo '<h3>Keywords extracted from letter:</h3>';
    foreach ($keywords as $keyword) {
        echo '<p>' . $keyword . '</p>';
    }

    // Insert project in the DB!


}

function saveProjectandQuestions($project_code, $project_indiener, $project_party, $project_title, $project_date_letter,
                                 $questions, $keywords){

	// First save the project and return the project ID
	$project_id = saveProject($project_code, $project_indiener, $project_party, $project_date_letter, $project_title);

	// Now we have the project_id we can save all questions with reference to the project
	$questions = saveQuestionArray($questions, $project_id);

	// Also insert the keywords we have extracted into the DB
	$keywords = saveKeywordArray($keywords, $project_id);
}

function getIndiener($string)
{
    // TODO add support for strings with 'leden'
    // Need to set substring so it only contains indiener name
    $str = trim(substr($string, 0, (strpos($string, '('))));

    return $str;
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




