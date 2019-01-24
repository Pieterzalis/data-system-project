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
        <script>
        // Load jquery calls after page load.
        $(document).ready(function () {
            /*//#?????,?????????
            $(".jq-loadall-projcards").click(function () {
                $(".jq-question-assigned-content").fadeOut(400);
                $.post( "database/Model_Project.php", { func: "getAssignedQuestionsHtml" })
                    .done(function( data ) {
                        // Change contents of div
                        $(".jq-question-assigned-content").html(data).fadeIn(400);
                    })
                });*/
            });
        var lastClick = $('select-all-nav-item');
        function changePage(node, { pageId }) {
            lastClick.removeClass("actived");
            lastClick = $(node);
            lastClick.addClass("actived");
            console.log(pageId);//???ID
            jump(pageId);//??
        }
        
 
      
        function search() {
            back();
        }
        function jump(pageId) {
            console.log('testblablabla');
            //$('.page-title')[0].innerText='Kamervraag';
            // indexPage
            var indexNavPage = $('#indexPage');
            // childPage
            var childNavPage = $('#childPage');
            indexNavPage.hide();
            childNavPage.show();
            // ????
            // childNavPage.attr('src', 'https://www.baidu.com/s?ie=utf-8&f=8&rsv_bp=1&tn=baidu&wd=' + pageId); 
            // ????
            childNavPage.attr('src', 'distribution-detail.php?id=' + pageId);//#????php??
        }
        function back() {
            lastClick.removeClass("actived");
            // indexPage
            var indexNavPage = $('#indexPage');
            // childPage
            var childNavPage = $('#childPage');
            childNavPage.hide();
            indexNavPage.show();
            // ????
            childNavPage.attr('src', '');
        }
    </script>
    </head>
    
<body class="distribution-page">
    <div class="container-fluid my-layout d-flex flex-column" id="leftMenu">
        <div class="" id="indexPage">
            <div class="row justify-content-md-left m-3">
             <button type="button" class="btn btn-primary shadow bluebutton" onclick="window.location='upload.php'">
                 <i class="fa fa-plus" aria-hidden="true"></i>Nieuwe Kamervragen</button>
            </div>
            <div class="row m-3" style="font-size:25px">
                <p>Nog toe te wijzen kamervragen</p>
            </div>

            <div class="row m-3" id="">
                <?php getDistributionProjectCardsHtml(); ?>
            </div>

            <div class="row m-3" style="font-size: 25px">
                <p>Toegewezen kamervragen</p>
            </div>
          
        </div>
        <iframe id="childPage"
                        src=""
                        name="listReload"
                        class="iframe-child-page"
                        frameborder="0"
                        style=" min-height:800px; width:100%; margin:0;"><!--#?????style,????????-->
                </iframe>

    </div>
            <!-- layout_content -->    
    

</body>
</html>