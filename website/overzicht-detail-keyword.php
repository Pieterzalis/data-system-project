<?php
require_once 'database/Model_Project.php';
?>

<!DOCTYPE html>
<html>

<head>
    <?php
    include_once("templates/template_head.php");
    ?>
</head>

<body class="page_search_engine">

    <div class="card m-3 p-md-3 p-lg-4 text-center">
        <!-- row-info -->
        <div class="project-info">

            <h6 class="m-3"><?= $a['project_code'] ?></h6>
            <div>
                <p><Strong>XX XXXXX XXXXXXX XXXXX XXXXXXX XXXXX XXXXXX</Strong></p>
                <p>xxxxxxx: <Strong>4352-32423</Strong></p>
            </div>
            <div class="row justify-content-md-center">
                <div class="col-sm col-md-6 col-lg-4">

                    <h6 class="text-secondary">Keyword</h6>
                    <div>
                        <span class="badge badge-pill badge-secondary">keyword</span>
                        <span class="badge badge-pill badge-secondary">keyword</span>
                        <span class="badge badge-pill badge-secondary">keyword</span>
                        <span class="badge badge-pill badge-secondary">keyword</span>
                        <span class="badge badge-pill badge-secondary">keyword</span>
                    </div>
                </div>
                <div class="col-sm col-md-6 col-lg-4">

                    <h6 class="text-secondary">Indiener</h6>
                    <div class="card">
                        <div class="card-body">
                            <a href="login.html"
                               class="w-100 d-flex align-items-center">
                                <div class="flex-none avatar avatar-md">
                                    <img class="rounded-circle"
                                         src="assets/img/man.jpg"
                                         alt="">
                                </div>
                                <div class="flex-auto text-dark text-left">
                                    <p class="mb-0 pl-3">Keyword</p>
                                </div>
                                <div class="flex-none">
                                    <i class="fa fa-angle-right text-dark"
                                       style="float:right"
                                       aria-hidden="true"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <h6 class="text-secondary mt-3">Experts</h6>
                <div class="d-flex justify-content-center">
                    <div class="avatar avatar-md mx-3">
                        <img class="rounded-circle"
                             src="assets/img/man.jpg"
                             alt="">
                        <p class="text-mini">name</p>
                    </div>
                    <div class="avatar avatar-md mx-3">
                        <img class="rounded-circle"
                             src="assets/img/man.jpg"
                             alt="">
                        <p class="text-mini">name</p>
                    </div>
                    <div class="avatar avatar-md mx-3">
                        <img class="rounded-circle"
                             src="assets/img/man.jpg"
                             alt="">
                        <p class="text-mini">name</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- row-table -->
        <div class="card mt-3 shadow">
            <div class="card-body">
                <h4>Kennisbank</h4>

                <ul class="my-list-group container-fluid">
                        <li class="my-list-group-item py-2 py-md-3 mb-2 mb-md-3 rounded bg-app text-white row align-items-center">
                            <div class="col-3 col-md-auto pr-sm-2 pr-md-3">#1</div>
                            <div class="col-9 col-md px-sm-2 px-md-3">XXXX XXXX XXXX XXXXX XXXX XXXX XXXX XXXXX</div>
                            <div class="col-9 col-md-auto px-sm-2 px-md-5">
                                <div class="avatar avatar-md mx-3">
                                    <img class="rounded-circle"
                                         src="assets/img/man.jpg"
                                         alt="">
                                    <p class="text-mini mb-0">name</p>
                                </div>
                            </div>
                        </li>
                        <li class="my-list-group-item py-2 py-md-3 mb-2 mb-md-3 rounded bg-app text-white row align-items-center">
                            <div class="col-3 col-md-auto pr-sm-2 pr-md-3">#1</div>
                            <div class="col-9 col-md px-sm-2 px-md-3">XXXX XXXX XXXX XXXXX XXXX XXXX XXXX XXXXX</div>
                            <div class="col-9 col-md-auto px-sm-2 px-md-5">
                                <div class="avatar avatar-md mx-3">
                                    <img class="rounded-circle"
                                         src="assets/img/man.jpg"
                                         alt="">
                                    <p class="text-mini mb-0">name</p>
                                </div>
                            </div>
                        </li>
                        <li class="my-list-group-item py-2 py-md-3 mb-2 mb-md-3 rounded bg-app text-white row align-items-center">
                            <div class="col-3 col-md-auto pr-sm-2 pr-md-3">#1</div>
                            <div class="col-9 col-md px-sm-2 px-md-3">XXXX XXXX XXXX XXXXX XXXX XXXX XXXX XXXXX</div>
                            <div class="col-9 col-md-auto px-sm-2 px-md-5">
                                <div class="avatar avatar-md mx-3">
                                    <img class="rounded-circle"
                                         src="assets/img/man.jpg"
                                         alt="">
                                    <p class="text-mini mb-0">name</p>
                                </div>
                            </div>
                        </li>
                        <li class="my-list-group-item py-2 py-md-3 mb-2 mb-md-3 rounded bg-app text-white row align-items-center">
                            <div class="col-3 col-md-auto pr-sm-2 pr-md-3">#1</div>
                            <div class="col-9 col-md px-sm-2 px-md-3">XXXX XXXX XXXX XXXXX XXXX XXXX XXXX XXXXX</div>
                            <div class="col-9 col-md-auto px-sm-2 px-md-5">
                                <div class="avatar avatar-md mx-3">
                                    <img class="rounded-circle"
                                         src="assets/img/man.jpg"
                                         alt="">
                                    <p class="text-mini mb-0">name</p>
                                </div>
                            </div>
                        </li>
                        <li class="my-list-group-item py-2 py-md-3 mb-2 mb-md-3 rounded bg-app text-white row align-items-center">
                            <div class="col-3 col-md-auto pr-sm-2 pr-md-3">#1</div>
                            <div class="col-9 col-md px-sm-2 px-md-3">XXXX XXXX XXXX XXXXX XXXX XXXX XXXX XXXXX</div>
                            <div class="col-9 col-md-auto px-sm-2 px-md-5">
                                <div class="avatar avatar-md mx-3">
                                    <img class="rounded-circle"
                                         src="assets/img/man.jpg"
                                         alt="">
                                    <p class="text-mini mb-0">name</p>
                                </div>
                            </div>
                        </li>
                </ul>
            </div>
        </div>
    </div>

</body>

</html>