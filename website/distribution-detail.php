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
require_once 'database/Model_User.php';

if (isset($_GET['id'])) {
    $project_id = (int)($_GET['id']);
} else {
    //exit('Parameter error');
}

// Query questions
$question_list = DB::query("SELECT q.question_id, 
            q.question_title,
            q.question_number, 
            q.question_project_id, 
            p.project_title, 
            p.project_code,
            p.project_date_letter
            FROM question q 
            INNER JOIN project p ON p.project_id=q.question_project_id
            WHERE p.project_id = '$project_id'");

$all_experts = DB::query("SELECT * FROM `user` WHERE `user_role_id`=2");

$i=1;

if(isset($_GET['uid'])&& isset($_GET['qid'])){
	$uid =$_GET['uid'];
	$qid = $_GET['qid'];
	if(!empty($uid) && !empty($qid)){
		DB::query("delete from question_has_experts where question_id=".$qid." and user_id=".$uid);	
		$uid = "";
		$qid = "";
}
}

//

?>

<!DOCTYPE html>
<html>
    <head>
        <?php include_once("templates/template_head.php"); ?>
        
        <script>
			
			function deleteUser(questionid,userid,projectid){
				var id = "#"+questionid+"user"+userid;
//				alert(id);
				$(id).remove();
				window.location= "?qid="+questionid+"&uid="+userid+"&id="+projectid;
		
			}
			
            var globalQuestionID;

            $(document).ready(function () {
                $('#toewijzen2').hide();
                
                $('.toewijzen').click(function(){
                    $('#toewijzen1').hide();
                    $('#toewijzen2').show();

                    let QuestionID = $(this).parents("li").attr('id');
                    globalQuestionID = QuestionID;

                });
                
                $('.toewijzenbutton').click(function(){
                    $('#toewijzen1').show();
                    $('#toewijzen2').hide();
                });

                // Add assigning ajax request query stuff
                $('.jq-expert').click(function(){

                    $.post( "database/Model_User.php", {
                        func: "assignExpertToQuestion",
                        id: this.id,
                        question_id: globalQuestionID
                    })
                        .done(function( data ) {
                            // Change contents of div
                            if (!(data === 'success')){
                                alert(data)
                            } else {
                                // TODO do stuff here
                                //Do page refresh
                                location.reload();
                            }
                        })

                });
                
            });
            var lastClick = $('select-all-nav-item');
        function changePage(node, { pageId }) {
            lastClick.removeClass("actived");
            lastClick = $(node);
            lastClick.addClass("actived");
            console.log(pageId);//???ID
            jump(pageId);//??
        }
        
         function changePage2(node, { pageId }) {
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
            location='distribution-detail.php?id='+pageId;
            //indexNavPage.hide();
            //childNavPage.show();
            // ????
            // childNavPage.attr('src', 'https://www.baidu.com/s?ie=utf-8&f=8&rsv_bp=1&tn=baidu&wd=' + pageId); 
            // ????
            //childNavPage.attr('src', '');
            //childNavPage.attr('src', 'distribution-detail.php?id=' + pageId);//#????php??
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
    
<body class="page_project_overview2">
    <!-- ????demo?????-->
    <div class="demopage hidden">
        <img src="assets/demo/overzicht.jpg">
    </div>
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
        <div class="row flex-1">
            <!-- layout_left -->
            <div class="col-md-4 p-0 col-lg-3 col-xl-3 layout_left d-flex">
                <div class="container-fluid layout_left_form bg-app-dark">
                    <div class="row"
                         style="height: 100%;">
                        <div class="col-sm p-0 d-flex flex-column">
                            <!-- nav-tabs -->
                            <ul class="nav nav-tabs flex-none d-none bg-white"
                                id="myTab"
                                role="tablist">
                                <li class="nav-item flex-1">
                                    <a class="nav-link active"
                                       id="tab1-tab"
                                       data-toggle="tab"
                                       href="#tab1"
                                       role="tab"
                                       aria-controls="tab1"
                                       aria-selected="true">
                                        <i class="fa fa-file"
                                           aria-hidden="true"></i>
                                        Zoek een project
                                    </a>
                                </li>
                                <li class="nav-item flex-1">
                                    <a class="nav-link"
                                       id="tab2-tab"
                                       data-toggle="tab"
                                       href="#tab2"
                                       role="tab"
                                       aria-controls="tab2"
                                       aria-selected="false">
                                        <i class="fa fa-search"
                                           aria-hidden="true"></i>
                                        tab2
                                    </a>
                                </li>
                            </ul>
                            <!-- tab-content -->
                            <div class="tab-content flex-1 p-2"
                                 style="overflow-y:auto"
                                 id="myTabContent">

                                <div class="tab-pane fade show active"
                                     id="tab1"
                                     role="tabpanel"
                                     aria-labelledby="tab1-tab">
                                    <form class="p-2" method="post" action="">

                                        <div class="form-group mb-0">
                                            <label for="exampleInputEmail1"> Zoek een project</label>
                                            <div class="input-group bg-trans-dark">
                                                <div class="input-group-prepend clear">
                                                    <div class="input-group-text">
                                                        <i class="fa fa-search"
                                                           aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                                <input type="text"
                                                       class="form-control"
                                                       id="Search" name="Search" value=""
                                                       placeholder="Zoek op projectnaam">
                                            </div>
                                        </div>
                                        <div class="text-center py-3 px-2">
                                            <button type="button"
                                                    class="btn btn-primary shadow bluebutton"
                                                    onclick="location='distribution-main.php'">
                                                <i class="fa fa-home"
                                                   aria-hidden="true"></i>Overzicht
                                            </button>
                                            
                                        </div>
                                    </form>
                                    <div id="accordion">
                                        <!-- card -->
                                        <?php
                                        //#????????project
                                        $sql = "SELECT  project_id,project_title 
                                                FROM project
                                                ORDER BY project_id DESC";


                                        if(isset($_POST['Search']))//#?????????sql??project
                                            $sql = "SELECT  project_id,project_title 
                                                    FROM question
                                                    and project_title like '%{$_POST['Search']}%' 
                                                    order by project_id desc";
                                        $projects = DB::query($sql);

                                        foreach($projects as $project){//#??project??
                                        ?>
                                        <div class="card m-2">
                                            <div class="card-header collapsed"
                                                 id="headingOne<?=$project['project_id']?>"
                                                 onclick="changePage(this, {pageId:<?=$project['project_id']?>})"
                                                 data-toggle="collapse"
                                                 data-target="#collapseOne<?=$project['project_id']?>"
                                                 aria-expanded="false"
                                                 aria-controls="collapseOne<?=$project['project_id']?>">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-none mr-2">
                                                        <i class="fa fa-file fa-fw"
                                                           aria-hidden="true"></i>
                                                    </div>
                                                    <div class="flex-1"><?=$project['project_title']?></div>
                                                    <div class="flex-none  ml-2">
                                                        <i class="fa fa-angle-right"
                                                           aria-hidden="true"></i>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="tab-pane fade"
                                     id="tab2"
                                     role="tabpanel"
                                     aria-labelledby="tab2-tab">
                                    <!-- 222222 -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- layout_content -->
            <div class="col-sm p-0 layout_content py-md-3 justify-content-center positon-relative">
        <div id="indexPage"
             class="container-fluid py-3 py-md-0 text-center">
            <div class="row justify-content-md-left removeleftmargin">
                <button type="button" class="btn btn-primary shadow bluebutton" onclick="location='distribution-main.php'">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>Terug naar overzicht</button>
            </div>
            <h4><Strong><?=$question_list[0]['project_title']?></Strong></h4>
            <h6 class="text-secondary">Keywords</h6>
            <div><?php $ak = DB::query('select keyword_name from keyword where keyword_project_id='.$project_id);
                foreach($ak as $v){
				echo '<span class="badge badge-pill badge-secondary">'.$v['keyword_name'].'</span>';
				}?>
            </div>
        <!-- row-table -->
        <div class="card mt-3 shadow">
            <div class="card-body" id="toewijzen1">
                <h4>Vragen</h4>
                <ul class="my-list-group container-fluid">

                    <?php foreach ($question_list as $question) {

                         $experts = getExpertsByQuestion($question['question_id'])
                        ?>
                        <li id="<?= $question['question_id']?>"
                            class="my-list-group-item py-2 py-md-3 mb-2 mb-md-3 rounded bg-app text-white row align-items-center">
                            <div class="col-3 col-md-auto pr-sm-2 pr-md-3">#<?= $question['question_number'] ?></div>
                            <div class="col-9 col-md px-sm-2 px-md-3"><?= $question['question_title'] ?></div>

                            <?php
                            if (count($experts) >= 1) {
                                foreach ($experts as $expert) { ?>
                                    <div class="col-9 col-md-auto px-sm-2 px-md-5" id="<?= $question['question_id']."user".$expert['user_id']?>">
                                        <div class="avatar avatar-md mx-3 justify-content-center">
                                            <img class="rounded-circle"
                                                 src="assets/img/<?= $expert['user_username'] ?>.jpg"
                                                 alt="">
                                            <p class="text-mini mb-0"><?= $expert['user_firstname'] . " " .  $expert['user_lastname_prefix'] . " " .  $expert['user_lastname'] ?></p>
                                            <i class="fa fa-trash" aria-hidden="true" onclick ="deleteUser(<?=$question['question_id']?>,<?=$expert['user_id']?>,<?= $project_id?>) "></i>
                                        </div>
										<div>
										
					                    </div>
                                    </div>
                                <?php }
                            } else { ?>
                                <!-- no experts, show wijs expert toe code -->
                                <div class="col-9 col-md-auto px-sm-2 px-md-5 toewijzen">
                                    <div class="avatar avatar-md mx-3 cursor-pointer">
                                        <i class="fa fa-user-plus text-center"></i>
                                        <p class="text-mini mb-0">Wijs expert toe</p>
                                    </div>
                                </div>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="card-body" id="toewijzen2">
                <h4>Expert toewijzen</h4>
                <div class="row">
                    <?php foreach($all_experts as $exp) { ?>
                        <div class="col-xl-2 col-lg-3 col-md-4 bluehover jq-expert" id="<?= $exp['user_id']?>">
                            <img src="assets/img/<?= $exp['user_username'] ?>.jpg">
                            <p><?php echo $exp['user_firstname'] . " " .  $exp['user_lastname_prefix'] . " " .  $exp['user_lastname'] ?></p>
                        </div>
                    <?php } ?>

                </div>
                <div class="row">
                    <button type="button" class="btn btn-primary shadow bluebutton toewijzenbutton" onclick="">Annuleer</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    
</body>
</html>