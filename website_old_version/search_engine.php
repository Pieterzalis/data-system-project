<!DOCTYPE html>
<html>

<head>
    <title>Zoeken</title>
    <?php include_once("templates/template_head.php") ?>
</head>

<body class="page_search_engine">
    <!-- 此处显示demo图作为参考-->
    <div class="demopage hidden">
        <img src="assets/demo/search_engine.png">
    </div>

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
                            <h3 class="page-title">Zoeken</h3>
                        </div>
                        <div class="col-sm-4 d-flex align-items-center justify-content-end">
                            <div class="options">
                                <!-- UserName -->
                                <a href="">
                                    <i class="fa fa-user-circle"
                                       aria-hidden="true"></i>
                                    F.Ten Noord
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
            <!-- layout_content -->
            <div class="col-sm p-0 layout_content d-flex justify-content-center ">
                <div class="container-fluid">
                    <div class="row justify-content-md-center">
                        <div class="col-sm-12 col-md-10">
                            <!-- search input -->
                            <form class="mt-3">
                                <div class="form-group row justify-content-center">
                                    <div class="input-group col-sm-12 col-md-8 col-lg-6">
                                        <div class="input-group-prepend clear">
                                            <div class="input-group-text">
                                                <i class="fa fa-search"
                                                   aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <input type="text"
                                               class="form-control"
                                               id="Search"
                                               placeholder="voer hier uw zoekwoord in...">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="container">
                                        <div class="row justify-content-md-center">
                                            <div class="col-md-3">

                                                <div class="form-group mb-0"><!--  -->
                                                    <label>Sleutelwoorden</label>
                                                </div>
                                                <div>
                                                    <span class="badge badge-pill badge-primary">Rijgedrag</span>
                                                    <span class="badge badge-pill badge-secondary">Geloofwaardig</span>
                                                    <span class="badge badge-pill badge-success">Melding</span>
                                                    <span class="badge badge-pill badge-danger">Slecht</span>
                                                    <span class="badge badge-pill badge-warning">Opschorten</span>
                                                    <span class="badge badge-pill badge-info">Info</span>
                                                    <span class="badge badge-pill badge-light">Light</span>
                                                    <span class="badge badge-pill badge-dark">Dark</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <label>Zoek in deze periode</label>
                                                </div>
                                                <div class="form-group row justify-content-center">
                                                    <div class="input-group col-sm-12">
                                                        <div class="input-group-prepend clear">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar-o"
                                                                   aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                        <input type="text"
                                                               class="form-control"
                                                               id="Search"
                                                               placeholder="van dd-mm-yyyy">
                                                        <!-- 预留 placeholder="yyy/mm/dd" -->
                                                    </div>
                                                </div>
                                                <div class="form-group row justify-content-center">
                                                    <div class="input-group col-sm-12">
                                                        <div class="input-group-prepend clear">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar-o"
                                                                   aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                        <input type="text"
                                                               class="form-control"
                                                               id="Search"
                                                               placeholder="tot dd-mm-yyyy">
                                                        <!-- 预留 placeholder="yyy/mm/dd" -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <label>Zoek in deze bronnen</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input"
                                                           type="checkbox"
                                                           id="gridCheck1">
                                                    <label class="form-check-label"
                                                           for="gridCheck1">
                                                        Wetenschappelijke bronnen
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input"
                                                           type="checkbox"
                                                           id="gridCheck1">
                                                    <label class="form-check-label"
                                                           for="gridCheck1">
                                                        Media bronnen
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input"
                                                           type="checkbox"
                                                           id="gridCheck1">
                                                    <label class="form-check-label"
                                                           for="gridCheck1">
                                                        Oude kamervragen
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <div class="input-group col-xs-12 col-sm-8 col-md-6 col-lg-4">
                                        <a href="project_overview"
                                           class="btn btn-lg btn-block btn-outline-dark">Zoek</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr class="col-md-9">
                    <div class="row justify-content-md-center">
                        <div class="col-sm-12 col-md-11">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md title">
                                                        <p>
                                                            <strong>Kinderen kunnen voortaan - zonder medisch dossier - slecht rijgedrag van ouders melden</strong>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-3 info">
                                                        Bron: <strong><u>Volkskrant</u></strong>
                                                        <br>
                                                        Datum: <strong>24 oktober 2017</strong>
                                                    </div>
                                                    <div class="col-md content">Rechter stemt in met richtlijn rijbewijsverstrekker<br></br>
                                                    <br></br>
                                                     Bezorgde kinderen kunnen ook zonder medisch dossier slecht rijgedrag van een ouder melden bij het CBR. De rijvaardigheidsinstantie kan vervolgens besluiten de ouder te herkeuren en autorijden tot deze keuring te verbieden. </div>
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
                    </div>
            <nav aria-label="Page navigation example ">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item"><a class="page-link"
                                               href="#">Previous</a></li>
                                        <li class="page-item"><a class="page-link"
                                               href="#">1</a></li>
                                        <li class="page-item"><a class="page-link"
                                               href="#">2</a></li>
                                        <li class="page-item"><a class="page-link"
                                               href="#">3</a></li>
                                        <li class="page-item"><a class="page-link"
                                               href="#">4</a></li>
                                        <li class="page-item"><a class="page-link"
                                               href="#">5</a></li>
                                        <li class="page-item"><a class="page-link"
                                               href="#">6</a></li>
                                        <li class="page-item"><a class="page-link"
                                               href="#">Next</a></li>
                                    </ul>
                                </nav>
                </div>
            </div>
        </div>
    </div>

</body>

</html>