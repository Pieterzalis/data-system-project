<?php

// Load core model
// This will also load DB config
require_once 'Model_Core.php';

//
// Handle any ajax post requests to this file here
//
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_REQUEST['func'])) {

        if ($_REQUEST['func'] === 'removeFromKnowledgeBase' && $_REQUEST['id'] != '') {
            removeFromKnowledgeBase($_REQUEST['id']);
        }

		if ($_REQUEST['func'] === 'addToKnowledgeBase' && $_REQUEST['question_id'] != '') {
            addToKnowledgeBase($_REQUEST['question_id'], $_REQUEST['url'], $_REQUEST['publish_date'], $_REQUEST['title'], $_REQUEST['snippet'], $_REQUEST['type'], $_REQUEST['outlet']);
        }
    }

}

function addToKnowledgeBase($question_id, $url, $publish_date, $title, $snippet, $type, $outlet){
	DB::insert('source', array(
		'source_question_id' => $question_id,
		'source_url' => $url,
		'source_date_published' => $publish_date,
		'source_title' => $title,
		'source_snippet' => $snippet,
		'source_type' => $type,
		'source_outlet' => $outlet
	));	
}

// Set given source_id as inactive
function removeFromKnowledgeBase($source_id_string) {
    $i=1;

    $str_explode = explode("-", $source_id_string);
    $source_id = (int)end($str_explode);

    $i=1;

    $query = makeSourceInactive($source_id);

    if ($query != 1) {
        // Error removing source from the database..

        echo 'Error removing source from question knowledge base';

    } else {
        echo 'success';
    }


}

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

function makeSourceInactive($source_id){
    DB::update('source', array(
        'source_active' => 0), "source_id=%i", $source_id);

    $counter = DB::affectedRows();
    $i =1;

    return $counter;
}