<?php


// Load core model
// This will also load DB config
require_once 'Model_Core.php';


//
// Handle any ajax post requests to this file here
//
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_REQUEST['func'])) {

        if ($_REQUEST['func'] === 'assignExpertToQuestion' && $_REQUEST['id'] != '' && $_REQUEST['question_id'] != '') {
            assignExpertToQuestion($_REQUEST['question_id'], $_REQUEST['id']);
        }

    }

}


//
// Check function for experts
//
//
function isUserExpert($user_id) {

	// Check if the given user is an expert.
	$role = DB::query("SELECT role_name FROM `user` 
								INNER JOIN role ON user_role_id = role_id 
								WHERE user_id= " . $user_id . " ");

	if ($role[0]["role_name"] === "Expert") {
		// User is expert
		return true;
	} else {
		// User is not an expert
		return false;
	}
}

function getExpertsByQuestion($question_id) {
    $results = DB::query("SELECT qhe.question_id, 
                                  u1.user_username,
                                  u1.user_firstname,
                                  u1.user_lastname_prefix,
                                  u1.user_lastname 
                          from question_has_experts qhe 
                          INNER JOIN question q ON q.question_id = qhe.question_id 
                          INNER JOIN `user` u1 ON u1.user_id = qhe.user_id
                          WHERE q.question_id = '$question_id'");

    return $results;
}

function assignExpertToQuestion($question_id, $user_id) {
    $i=1;

    //$question_id = (int)$question_id;
    //$user_id = (int)$question_id;

    // Check if combination already exists
    $exists = DB::query("SELECT * FROM `question_has_experts` WHERE question_id = '$question_id' AND user_id = '$user_id' ");

    if (count($exists) === 0) {
        // Now do the fucking query
        DB::insert('question_has_experts', array(
            'user_id' => $user_id,
            'question_id' => $question_id
        ));

        // Check again if combination already exists
        $exists = DB::query("SELECT * FROM `question_has_experts` WHERE question_id = '$question_id' AND user_id = '$user_id' ");

        if (count($exists) === 1){
            // Query succesfull
            echo 'success';
        } else {
            echo 'Error assigning expert to question';
        }
    } else {
        // Is already assigned
        echo 'Error assigning, expert is already assigned to this question...';
    }



}