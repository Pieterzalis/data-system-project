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
    </head>
    
<body class="distribution-page">
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
        <div class="">
            <div class="row justify-content-md-left m-3">
             <button type="button" class="btn btn-primary shadow bluebutton" onclick="window.location='upload.php'">
                 <i class="fa fa-plus" aria-hidden="true"></i>Nieuwe Kamervragen</button>
            </div>
            <div class="row m-3" style="font-size:25px">
                <p>Nog toe te wijzen kamervragen</p>
            </div>
            <div class="row m-3">
                <div class="col-sm card-left">
                    <div class="toewijzencard">
                        <div class="card text-center">
                            <p>kamervragen #: 23457245</p>
                            <h4>Kamervragen titel komt hier dan</h4>
                            <span>Deadline: <Strong>?= $date_deadline ?</Strong></span>
                            <p>Indiener: <strong>Corrie van Brenk - 50 Plus</strong></p>
                            <h5>Toegewezen vragen: 0/8</h5>
                            <button type="button" class="btn btn-primary shadow bluebutton toewijzenbutton" onclick="">Toewijzen</button>
                        </div>
                    </div>
                </div>
                 <div class="col-sm card-left">
                    <div class="toewijzencard">
                        <div class="card text-center">
                            <p>kamervragen #: 23457245</p>
                            <h4>Kamervragen titel komt hier dan</h4>
                            <span>Deadline: <Strong>?= $date_deadline ?</Strong></span>
                            <p>Indiener: <strong>Corrie van Brenk - 50 Plus</strong></p>
                            <h5>Toegewezen vragen: 0/8</h5>
                            <button type="button" class="btn btn-primary shadow bluebutton toewijzenbutton" onclick="">Toewijzen</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-3" style="font-size: 25px">
                <p>Toegewezen kamervragen</p>
            </div>
            <div class="row m-3">
                <div class="col-sm card-left">
                    <div class="toewijzencard">
                        <div class="card text-center">
                            <p>kamervragen #: 23457245</p>
                            <h4>Kamervragen titel komt hier dan</h4>
                            <span>Deadline: <Strong>?= $date_deadline ?</Strong></span>
                            <p>Indiener: <strong>Corrie van Brenk - 50 Plus</strong></p>
                            <h5>Toegewezen vragen: 0/8</h5>
                            <button type="button" class="btn btn-primary shadow bluebutton toewijzenbutton" onclick="">Toewijzen</button>
                        </div>
                    </div>
                </div>
                 <div class="col-sm card-left">
                    <div class="toewijzencard">
                        <div class="card text-center">
                            <p>kamervragen #: 23457245</p>
                            <h4>Kamervragen titel komt hier dan</h4>
                            <span>Deadline: <Strong>?= $date_deadline ?</Strong></span>
                            <p>Indiener: <strong>Corrie van Brenk - 50 Plus</strong></p>
                            <h5>Toegewezen vragen: 0/8</h5>
                            <button type="button" class="btn btn-primary shadow bluebutton toewijzenbutton" onclick="">Toewijzen</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
            <!-- layout_content -->    
    

</body>
</html>