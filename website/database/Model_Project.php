<?php


// Load core model
// This will also load DB config
require_once 'Model_Core.php';

//
// Save Methods
//

/*
 * Function to insert a project in to the database, should check the project code first.
 * Function returns the created project ID
*/
function saveProject($project_code, $project_submitter_string, $date_letter, $project_title) {

    // TODO also check if the project_code exists, if it does, we cannot insert.
    // Right now it will give error when trying to inset duplicate unique key

    // Fake the project_submitter until we have full authentication system
    // TODO create real authentication
    $project_upload_user_id = 1;                           // id 1 has role 'bestuursondersteuning'
    $project_date_upload = date("Y-m-d H:i:s");     // Gets current date and time

    // TODO Translate project submitter (lastname) to a parliamentarian ID
    // We don't need to insert the party since it is linked to the parliamentarian record
    $project_submitter = getPMemberIDByLastname($project_submitter_string);
    if (is_null($project_submitter)) {
        exit("No such submitter found, please check if the last name is correct.");
    }

    // TODO convert date letter to mysql letter for query
    $date_letter_mysql = date("Y-m-d", dutch_strtotime($date_letter));


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

// Function to return a option list of all political parties in the DB
function getProject() {
    $html = "";
    $results = DB::query("SELECT * FROM Party");

    foreach ($results as $row) {
        $party_name = $row["party_name"];
        $html .= "<option>" . $party_name . "</option>";
    }
    echo $html;
}