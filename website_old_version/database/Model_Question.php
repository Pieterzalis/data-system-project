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

	foreach($questions as $question) {

		DB::insert('question', array(
			'question_project_id' => $project_id,
			'question_title' => $question
		));

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


