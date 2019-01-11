<?php

require_once 'meekrodb.2.3.class.php';

// Database configuration
DB::$user = 'root';
DB::$password = '';
DB::$dbName = 'datasystems';
DB::$encoding = 'utf8'; // defaults to latin1 if omitted


// Function to return a option list of all political parties in the DB
function getParties() {
    $html = "";
    $results = DB::query("SELECT * FROM Party");

    foreach ($results as $row) {
        $party_name = $row["party_name"];
        $html .= "<option>" . $party_name . "</option>";
    }
    echo $html;
}

function populateParliamentarianList() {
    $html = "";
    $results = DB::query("SELECT `parliamentmember_firstname`, `parliamentmember_lastname_prefix`, `parliamentmember_lastname`, `party_name` 
                          FROM `parliamentmember` 
                          INNER JOIN party ON `parliamentmember_party_id` = `party_id`
                          ORDER BY `parliamentmember_lastname` ASC");

    $i = 0;
    foreach ($results as $row) {
        $i++;
        $ParliamentMember_name = $row["parliamentmember_firstname"] . " " . $row["parliamentmember_lastname_prefix"] . " " . $row["parliamentmember_lastname"];
        $Party_name = $row["party_name"];
        $html .= "

        <div class=\"card mb-3\">
            <div class=\"card-body container\">
                <div class=\"row\">
                    <div class=\"col-md\">
                        <div class=\"container\">
                            <div class=\"row\">
                                <div class=\"col-md parlementarian title\">
                                    <h4>#". $i . " " . $ParliamentMember_name ."</h4>
                                </div>
                            </div>
                            <div class=\"row\">
                                <div class=\"col-sm party\">
                                    <p class=\"lead mb-0\">
                                        <span class=\"text-secondary\">" . $Party_name . "</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        ";
    }

    echo $html;
}


