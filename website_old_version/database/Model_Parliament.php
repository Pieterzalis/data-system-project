<?php

// Load core model
// This will also load DB config
require_once 'Model_Core.php';

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

function populateParliamentarianListWithFilter($last_name, $party_names = null) {
    $html = "";

    // Alter query according to filters used.
    if (is_null($party_names)) {
        //Do query with only name filter
        $results = DB::query("SELECT `parliamentmember_firstname`, `parliamentmember_lastname_prefix`, `parliamentmember_lastname`, `party_name` 
                          FROM `parliamentmember`
                          INNER JOIN party ON `parliamentmember_party_id` = `party_id`
                          WHERE CONCAT(parliamentmember_firstname, ' ', parliamentmember_lastname_prefix, ' ', parliamentmember_lastname) LIKE '%". $last_name ."%'
                          ORDER BY `parliamentmember_lastname` ASC");

    } else {
        // Do query with filter on both
        $results = DB::query("SELECT `parliamentmember_firstname`, `parliamentmember_lastname_prefix`, `parliamentmember_lastname`, `party_name` 
                          FROM `parliamentmember`
                          INNER JOIN party ON `parliamentmember_party_id` = `party_id`
                          WHERE CONCAT(parliamentmember_firstname, ' ', parliamentmember_lastname_prefix, ' ', parliamentmember_lastname) LIKE '%". $last_name ."%'
                          AND party_name = 'PVV'
                          ORDER BY `parliamentmember_lastname` ASC");
    }

//    $results = DB::query("SELECT `parliamentmember_firstname`, `parliamentmember_lastname_prefix`, `parliamentmember_lastname`, `party_name`
//                          FROM `parliamentmember`
//                          INNER JOIN party ON `parliamentmember_party_id` = `party_id`
//                          WHERE CONCAT(parliamentmember_firstname, ' ', parliamentmember_lastname_prefix, ' ', parliamentmember_lastname) LIKE '%". $last_name ."%'
//                          ORDER BY `parliamentmember_lastname` ASC");

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

// Translate given last name to an parliament member ID and return it.
function getPMemberIDByLastname($last_name) {

    // Do code
    $query = "SELECT parliamentmember_id 
              FROM parliamentmember
              WHERE CONCAT(parliamentmember_lastname_prefix, ' ', parliamentmember_lastname) LIKE '%". $last_name ."%'";

    $id = DB::queryFirstRow($query);

    return $id['parliamentmember_id'];


}


