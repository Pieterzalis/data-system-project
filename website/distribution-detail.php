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
        <div class="m-3 p-md-3 p-lg-4 text-center">
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
                    <div class="col-xl-2 col-lg-3 col-md-4 bluehover">
                        <img src="assets/img/Amersfoort.png">
                        <p>M. Amersfoort</p>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 bluehover">
                        <img src="assets/img/Amersfoort.png">
                        <p>M. Amersfoort</p>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 bluehover">
                        <img src="assets/img/Amersfoort.png">
                        <p>M. Amersfoort</p>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 bluehover">
                        <img src="assets/img/Amersfoort.png">
                        <p>M. Amersfoort</p>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 bluehover">
                        <img src="assets/img/Amersfoort.png">
                        <p>M. Amersfoort</p>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 bluehover">
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