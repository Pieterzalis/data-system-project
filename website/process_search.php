<?php

require_once 'database/Model_Core.php';
require_once 'database/Model_Source.php';

#example data from front-end:
#$question_id = "23";
#$keywords = array("grond", "hergebruik", "betrokken", "handen", "inzichtelijk");
#$fromdate = '14-11-2010';
#$todate = '17-05-2012';
#$question_id = "23";
#$search_news = "on";
#$search_prev_answers = "undefined";

$question_id = null;
$keywords = null;
$fromdate = null;
$todate = null;
$search_news = null;
$search_prev_answers = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['question_id'])) {
		$question_id = $_POST['question_id'];
	} 
	if (isset($_POST['keywords'])) {
		$keywords = json_decode($_POST['keywords']);
	}
	if (isset($_POST['fromdate'])) {
		$fromdate = $_POST['fromdate'];
	}
	if (isset($_POST['todate'])) {
		$todate = $_POST['todate'];
	}
	if (isset($_POST['search_news'])) {
		$search_news = $_POST['search_news'];
	}
	if (isset($_POST['search_prev_answers'])) {
		$search_prev_answers = $_POST['search_prev_answers'];
	}
	gatherInfo($question_id, $keywords, $fromdate, $todate, $search_news, $search_prev_answers);
}

function gatherInfo($question_id, $keywords, $fromdate, $todate, $search_news, $search_prev_answers){
	$keywordstring = "";
	foreach ($keywords as $keyword){
		$keywordstring = $keywordstring . $keyword . ",";
	}
    $data = $keywordstring . " " . $fromdate . " " . $todate . " " . $search_news . " " . $search_prev_answers;
    $python_path = htmlentities('info_gathering.py');

    // Execute python script for retrieving relevant information
    exec("python " . $python_path . " " . $data . "", $output, $ret_code);
	
    $output_data = end($output);
	//$output_data = "Just for testing. Not actually searching to save time and news api requests";
    if ($output_data === false) {
        $output_data = null;
        echo 'Error: Python returned no output';
    } else {
		$data = json_decode($output_data);
        //saveSources($data, $question_id);
		returnHTMLResponse($data);
    } 
}

function saveSources($data, $question_id){
    $source_ids = saveSourceArray($data, $question_id);
}

function returnHTMLResponse($data){
	$html = "";
	foreach($data as $source){
		$title = str_replace('"', "'", $source->title);
		$outlet = $source->outlet;
		$publish_date = $source->publish_date;
		$snippet = preg_replace("/\r|\n/", " ", $source->snippet);
		$snippet = str_replace('"', "'", $snippet);
		$url = $source->url;
		$type = $source->type;
		$html .= '<div class="row justify-content-md-center source-card">
					<div class="col-sm-12 col-md-11">
						<div class="card mb-3">
							<div class="card-body">
								<div class="row">
									<div class="col-md">
										<div class="container">
											<div class="row">
												<div class="col-md title">
													<p>
														<strong>' . $title. '</strong>
													</p>
												</div>
											</div>
										</div>
										<div class="container">
											<div class="row">
												<div class="col-md-3 info">
													Bron: <a href="'.$url.'" target="_blank"><strong><u>' . $outlet. '</u></strong></a>
													<br>
													Datum: <strong>' . $publish_date . '</strong>
												</div>
												<div class="col-md content">' . $snippet . '<br>
												<br>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-12 mt-2 mt-md-0 col-md-3 options justify-content-center d-flex  align-items-center">
										<div class="jq-addsource">
											<button onclick="store_source(this, &quot;' . $url . '&quot;, &quot;' . $publish_date . '&quot;, &quot;' . $title . '&quot;, &quot;' . $snippet . '&quot;, &quot;' . $type . '&quot;, &quot;' . $outlet . '&quot;)" class="btn btn-secondary btn-block jq-addtokb">
												Toevoegen aan kennisbank
										    </button>
									    </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>';
	}
	echo $html;
}