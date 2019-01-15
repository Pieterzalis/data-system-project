<?php
#$command = escapeshellcmd("python C:\\Users\\flori\\OneDrive\\Documenten\\hello.py");
#$output = shell_exec($command);
require_once '../website/database/Model_Core.php';

parseLetter();

function parseLetter()
{
    // TODO make this dynamic with the upload script!
    $file_path = htmlentities('C:\\xampp\htdocs\\datasystems.test\\Backend\\letter2.pdf');
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
        echo '<p>Topic of projet: ' . $json->metadata->topic . '</p>';
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
    $date = date("Y-m-d", dutch_strtotime($data->metadata->date));

    $questions = getQuestions($data->questions);

    $keywords = $data->keywords;

    // When done, call save to database function.

    // Echo results
    echo '<p>Project Code: ' . $id . '</p>';
    echo '<p>Indiener: ' . $indiener . '</p>';
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

}

function getIndiener($string)
{
    // TODO add support for strings with 'leden'
    // Need to set substring so it only contains indiener name
    $str = substr($string, 4, (strpos($string, '(')-1)-4);

    return $str;
}

function getParty($string)
{
    // TODO fix this
    // Need to set substring so it only contains indiener name
    $strpos_start = strpos($string, '(') +1;
    $strpos_end = strpos($string, ')' ) ;

    $str = substr($string, $strpos_start);

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




