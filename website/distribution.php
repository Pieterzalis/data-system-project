<?php
    session_start();

    if(!isset($_SESSION['login_id'])) {
    header("location: login.php");
    exit();
    }

    $user_check = $_SESSION['login_username'];
    $user_fullname = $_SESSION['login_fullname'];
    $user_id = $_SESSION['login_id'];

    require_once 'database/Model_Project.php';
    require_once 'database/Model_Question.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Distribution</title>
        <?php include_once("templates/template_head.php"); ?>
    </head>
    
<body class="distribution-page">
    <div class="container-fluid my-layout d-flex flex-column" id="leftMenu">
        <div class="">
            <div class="row justify-content-md-left m-3">
             <button type="button" class="btn btn-primary shadow bluebutton" onclick="window.location='upload.php'">
                 <i class="fa fa-plus" aria-hidden="true"></i>Nieuwe Kamervragen</button>
            </div>
            <div class="row m-3" style="font-size:25px">
                <p>Nog toe te wijzen kamervragen</p>
            </div>

            <div class="row m-3">
                <?php getDistributionProjectCardsHtml(); ?>
            </div>

            <div class="row m-3" style="font-size: 25px">
                <p>Toegewezen kamervragen</p>
            </div>
          
        </div>
    </div>
            <!-- layout_content -->    
    

</body>
</html>