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

        </script>
    </head>
    
<body class="distribution-detail-page">

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

    <div class="container-fluid my-layout d-flex flex-column" id="leftMenu">
        <div class="m-3 p-md-3 p-lg-4 text-center">
            <div class="row justify-content-md-left">
                <button type="button" class="btn btn-primary shadow bluebutton" onclick="window.location='distribution.php'">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>Terug naar overzicht</button>
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
                                        <div class="avatar avatar-md mx-3">
                                            <img class="rounded-circle"
                                                 src="assets/img/<?= $expert['user_username'] ?>.jpg"
                                                 alt="">
                                            <p class="text-mini mb-0"><?= $expert['user_firstname'] . " " .  $expert['user_lastname_prefix'] . " " .  $expert['user_lastname'] ?></p>
                                        </div>
										<div>
										<i class="fa fa-trash" aria-hidden="true" onclick ="deleteUser(<?=$question['question_id']?>,<?=$expert['user_id']?>,<?= $project_id?>) "></i>
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
    
    
</body>
</html>