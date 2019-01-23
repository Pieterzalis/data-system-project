<?php
session_start();

if(!isset($_SESSION['login_id'])) {
header("location: login.php");
exit();
}

$user_check = $_SESSION['login_username'];
$user_fullname = $_SESSION['login_fullname'];
$user_id = $_SESSION['login_id'];
?>

<!DOCTYPE html>
<html>
    <head>
        <?php include_once("templates/template_head.php"); ?>
        
        <script>
            $(document).ready(function () {
                $('#toewijzen2').hide();
                
                $('.toewijzen').click(function(){
                    $('#toewijzen1').hide();
                    $('#toewijzen2').show();
                });
                
                $('.toewijzenbutton').click(function(){
                    $('#toewijzen1').show();
                    $('#toewijzen2').hide();
                });
                
            });

        </script>
    </head>
    
<body class="distribution-detail-page">
    <div class="container-fluid my-layout d-flex flex-column" id="leftMenu">
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
                            <h3 class="page-title">Jouw Kamervragen</h3>
                        </div>
                        <div class="col-sm-4 d-flex align-items-center justify-content-end">
                            <div class="options">
                                <!-- UserName -->
                                    <div class="avatar">
                                        <img class="rounded-circle"
                                             src="assets/img/<?=$user_check?>.jpg"
                                             alt="">
                                    </div>
                                    <?= $user_fullname ?>
                                <!-- sign-out -->
                                <a href="logout.php"
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
        <div class="m-3 p-md-3 p-lg-4 text-center">
        <!-- row-info -->
        <div class="project-info">

            <h6 class="m-3">#234235345</h6>
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
            <div class="card-body" id="toewijzen1">
                <h4>Vragen</h4>
                <ul class="my-list-group container-fluid">
                        <li class="my-list-group-item py-2 py-md-3 mb-2 mb-md-3 rounded bg-app text-white row align-items-center">
                            <div class="col-3 col-md-auto pr-sm-2 pr-md-3">#1</div>
                            <div class="col-9 col-md px-sm-2 px-md-3">Question comes here</div>
                            <div class="col-9 col-md-auto px-sm-2 px-md-5 toewijzen">
                                <div class="avatar avatar-md mx-3 cursor-pointer">
                                        <i class="fa fa-user-plus text-center"></i>
                                        <p class="text-mini mb-0">Wijs expert toe</p>
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
            <div class="card-body" id="toewijzen2">
                <h4>Expert toewijzen</h4>
                <div class="row">
                    <div class="col-3">
                        <img src="assets/img/Amersfoort.png">
                        <p>M. Amersfoort</p>
                    </div>
                    <div class="col-3">
                        <img src="assets/img/Amersfoort.png">
                        <p>M. Amersfoort</p>
                    </div>
                    <div class="col-3">
                        <img src="assets/img/Amersfoort.png">
                        <p>M. Amersfoort</p>
                    </div>
                    <div class="col-3">
                        <img src="assets/img/Amersfoort.png">
                        <p>M. Amersfoort</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <img src="assets/img/Amersfoort.png">
                        <p>M. Amersfoort</p>
                    </div>
                    <div class="col-3">
                        <img src="assets/img/Amersfoort.png">
                        <p>M. Amersfoort</p>
                    </div>
                </div>
                <div class="row">
                    <button type="button" class="btn btn-primary shadow bluebutton toewijzenbutton" onclick="">Annuleer</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    
    
</body>
</html>