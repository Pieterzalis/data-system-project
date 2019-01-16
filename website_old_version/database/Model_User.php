<?php


// Load core model
// This will also load DB config
require_once 'Model_Core.php';

//
// Check function for experts
//
//
function isUserExpert($user_id) {

	// Check if the given user is an expert.
	$role = DB::query("SELECT role_name FROM `user` 
								INNER JOIN role ON user_role_id = role_id 
								WHERE user_id= " . $user_id . " ");

	if ($role["role_name"] === "Expert") {
		// User is expert
		return true;
	} else {
		// User is not an expert
		return false;
	}
}