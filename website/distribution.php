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
             <button type="button" class="btn btn-primary shadow bluebutton" onclick="search()">
                 <i class="fa fa-plus" aria-hidden="true"></i>Jouw Kamervragen</button>
            </div>
        </div>
    </div>
            <!-- layout_content -->    
    

</body>
</html>