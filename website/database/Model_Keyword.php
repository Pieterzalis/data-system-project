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
function saveKeywordArray($keywords, $project_id) {

	// Loop through questions array, do Insert query for each
	$keywords_ids = array();

	foreach($keywords as $keyword) {

		DB::insert('keyword', array(
			'keyword_project_id' => $project_id,
			'keyword_name' => $keyword
		));

		// Get the inserted question_id and add to return array
		array_push($keywords_ids, DB::insertId());

	}

	// Return the project ID
	return $keywords_ids;
}


//
//
// Get Methods
//
//
