<?php

require_once 'database/Model_Core.php';
require_once 'database/Model_Source.php';

#data from front-end:
$keywords = array("grond", "hergebruik", "betrokken", "handen", "inzichtelijk");
$fromdate = '2010';
$todate = '2012';
$question_id = "2";

gatherInfo($question_id, $keywords, $fromdate, $todate);

function gatherInfo($question_id, $keywords, $fromdate, $todate){
	$keywordstring = "";
	foreach ($keywords as $keyword){
		$keywordstring = $keywordstring . $keyword . ",";
	}
    $data = $keywordstring;// + " " + $fromdate + " " + $todate

    $python_path = htmlentities('info_gathering.py');

    // Execute python script for retrieving relevant information
    exec("python " . $python_path . " " . $data . "", $output, $ret_code);
	
    $output_data = end($output);
    if ($output_data === false) {
        $output_data = null;
        echo 'Error: Python returned no output';
    } else {
        $data = json_decode($output_data);
        saveSources($data, $question_id);
		returnHTMLResponse($data);
    } 
}

function saveSources($data, $question_id){
    $source_ids = saveSourceArray($data, $question_id);
}

function returnHTMLResponse($data){
	$html = "";
	foreach($data as $source){
		$title = $source->title;
		$outlet = $source->outlet;
		$publish_date = $source->publish_date;
		$snippet = $source->snippet;
		$html .= '<div class="row justify-content-md-center">
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
													Bron: <strong><u>' . $outlet. '</u></strong>
													<br>
													Datum: <strong>' . $publish_date . '</strong>
												</div>
												<div class="col-md content">What comes here?<br></br>
												<br></br>
												' . $snippet . '</div>
											</div>
										</div>
									</div>
									<div class="col-sm-12 mt-2 mt-md-0 col-md-3 options justify-content-center d-flex  align-items-center">
										<button class="btn btn-secondary btn-block">
											Toevoegen aan kennisbank
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>';
	}
	echo $html;
}