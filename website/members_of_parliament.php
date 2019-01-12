<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible"
          content="IE=edge">
    <title>Parlementariërs</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
          type="text/css"
          media="screen"
          href="assets/style.css" />
    <link rel="stylesheet"
          type="text/css"
          media="screen"
          href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet"
          href="assets/icon-font/css/font-awesome.min.css">

    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>

    <script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>

    <script src="assets/js/index.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

</head>

<?php
require_once 'database/querytest.php';
?>

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
                                <input type="email"
                                       name="text-filter"
                                       class="form-control"
                                       id="text_filter"
                                       aria-describedby="emailHelp">
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

                            <!-- Start card population -->
                            <?php populateParliamentarianList() ?>
                            <!-- End card -->

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