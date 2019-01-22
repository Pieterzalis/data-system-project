<?php


// Load core model
// This will also load DB config
require_once 'Model_Core.php';


//Method to save source data to database
function saveSourceArray($sources, $question_id) {

	// Loop through questions array, do Insert query for each
	$source_ids = array();

	foreach($sources as $source) {

		DB::insert('source', array(
			'source_question_id' => $question_id,
			'source_url' => $source->url,
			'source_date_published' => $source->publish_date,
			'source_title' => $source->title,
			'source_snippet' => $source->snippet,
			'source_type' => $source->type,
			'source_outlet' => $source->outlet
		));

        // Get the inserted source_id and add to return array
        array_push($source_ids, DB::insertId());
	}

	// Return the source IDs
	return $source_ids;
}