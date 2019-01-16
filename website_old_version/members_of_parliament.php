<?php
require_once 'database/Model_Parliament.php';

 //Decode Ajax call (post values)
if (isset($_POST['text-filter']) && !empty($_POST['text-filter'])) {

    // Also check if the party filter has been used
    if (isset($_POST['party-filter']) && !empty($_POST['party-filter'])) {
        // Populate list with text-filter and party-filter
        populateParliamentarianListWithFilter($_POST['text-filter'], $_POST['party-filter']);
    }
    else {
        // Populate list only with text-filter
        populateParliamentarianListWithFilter($_POST['text-filter']);
    }

    // Exit the page, otherwise will load entire page again.
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Parlementariërs</title>
    <?php
        include_once("templates/template_head.php");
    ?>
</head>



<body class="page_search_engine">

<div class="container-fluid my-layout d-flex flex-column">
    <div class="row flex-none">
        <!-- layout_nav -->
        <div class="col-sm p-0 layout_nav d-flex flex-row justify-content-between align-items-center">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-4 pl-0">
                        <div class="logo">
                            <img src="assets/img/logo.png"></div>
                    </div>
                    <div class="col-sm-4 d-flex align-items-center justify-content-center">
                        <h3 class="page-title">Overzicht Parlementariërs</h3>
                    </div>
                    <div class="col-sm-4 d-flex align-items-center justify-content-end">
                        <div class="options">
                            <!-- UserName -->
                            <a href="">
                                <i class="fa fa-user-circle"
                                   aria-hidden="true"></i>
                                UserName
                            </a>
                            <!-- sign-out -->
                            <a href="login"
                               class="ml-3 mr-3">
                                <i class="fa fa-sign-out"
                                   aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row flex-1">
        <!-- layout_left -->
        <div class="col-md-3 p-0 col-lg-2 col-xl-2 layout_left d-flex">
            <div class="container-fluid layout_left_form">
                <div class="row">
                    <div class="col-sm">
                        <form id="postData">
                            <div class="form-group text-center pt-4">
                                <span>Filter opties</span>
                            </div>
                            <div class="form-group">
                                <label for="text_filter">Filter op parlementariër</label>
                                <input type="text"
                                       name="text-filter"
                                       class="form-control"
                                       id="text_filter">
                            </div>
                            <div class="form-group">
                                <label for="filterParty">Filter op partij</label>
                                <select multiple class="form-control" id="filterParty" name="party-filter">
                                    <?php getParties(); ?>
                                </select>
                            </div>

                            <button type="submit" value="SendPost" class="btn btn-primary">Filter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- layout_content -->
        <div class="col-sm p-0 layout_content d-flex justify-content-center ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm pt-md-2">
                        <div class="border rounded p-2">
                            <div class="jumbotron mb-3 p-0 bg-white">
                                <h4>Overzicht Parlementariërs</h4>
                            </div>

                            <div class="jq-pmember"">
                            <!-- Start card population -->
                                <?php populateParliamentarianList() ?>
                            <!-- End card -->
                            </div>

                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item"><a class="page-link"
                                                             href="#">Previous</a></li>
                                    <li class="page-item"><a class="page-link"
                                                             href="#">1</a></li>
                                    <li class="page-item"><a class="page-link"
                                                             href="#">2</a></li>
                                    <li class="page-item"><a class="page-link"
                                                             href="#">3</a></li>
                                    <li class="page-item"><a class="page-link"
                                                             href="#">Next</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>