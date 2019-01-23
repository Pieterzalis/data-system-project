<?php
require_once 'database/Model_Project.php';
$id = intval($_GET['id']);
if($id <= 0) exit('Parameter Error');//#如果id不对提示错误

$a = DB::queryOneRow("SELECT a.question_id, 
            a.question_title, 
            a.question_project_id, 
            b.project_title, 
            b.project_code,
            b.project_date_letter,
            REPLACE(CONCAT(pm.parliamentmember_firstname, ' ', pm.parliamentmember_lastname_prefix, ' ', pm.parliamentmember_lastname), '  ', ' ') as indiener_fullname,
            pa.party_name
              FROM question a 
              LEFT JOIN project b ON b.project_id=a.question_project_id 
              LEFT JOIN parliamentmember pm ON b.project_submitter = pm.parliamentmember_id
              LEFT JOIN party pa ON pm.parliamentmember_party_id = pa.party_id
              WHERE a.question_project_id=".$id." ");
$assigned_experts = DB::query("SELECT exp.user_id, u.user_firstname, u.user_lastname_prefix, u.user_lastname, u.user_username 
                              FROM question_has_experts exp 
                              INNER JOIN `user` u ON exp.user_id = u.user_id 
                              WHERE exp.question_id = ".$id." ");
$expert_fullnames = array();
foreach ($assigned_experts as $expert){
	if (is_null($expert["user_lastname_prefix"])) {
		array_push($expert_fullnames, array(
		        "name" => $expert["user_firstname"] . ' ' . $expert["user_lastname"],
                "username" => $expert["user_username"]));
	} else {
		array_push($expert_fullnames, array(
		        "name" => $expert["user_firstname"] . ' ' . $expert["user_lastname_prefix"] . ' ' . $expert["user_lastname"],
                "username" => $expert["user_username"]));
	}
}
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

            <h6 class="m-3">#<?= $a['project_code']?></h6>
            <div>
                <p><Strong><?=$a['project_title']?></Strong></p>
                <p>Deadline: <Strong><?=$a['project_date_letter']?></Strong></p>
            </div>
            <div class="row justify-content-md-center">
                <div class="col-sm col-md-6 col-lg-4">

                    <h6 class="text-secondary">Keyword</h6>
                    <div><?php
						//#列出该project的所有keyword
						$ak = DB::query('select keyword_name from keyword where keyword_project_id='.$id);
						foreach($ak as $v){
							echo '<span class="badge badge-pill badge-secondary">'.$v['keyword_name'].'</span>';
						}
						?>
                    </div>
                </div>
                <div class="col-sm col-md-6 col-lg-4">

                    <h6 class="text-secondary">Indiener</h6>
                    <div class="card customcardbody">
                        <div class="card-body w-100 d-flex align-items-center">
                                <div class="flex-none avatar avatar-md">
                                    <h5 style="display:flex; align-items: center; margin-bottom: 0;"><?php echo $a['party_name'] ?></h5>
                                </div>
                                <div class="flex-auto text-dark text-left">
                                    <p class="mb-0 pl-3"><?php echo $a['indiener_fullname'] ?></p>
                                </div>
                                <div class="flex-none">
                                </div>

                        </div>
                    </div>
                </div>
            </div>
            <div>
                <h6 class="text-secondary mt-3">Experts</h6>
                <div class="d-flex justify-content-center" id="expertsAll">
                    <div class="avatar avatar-md mx-3">
                        <img class="rounded-circle"
                             src="assets/img/woman.jpg"
                             alt="">
                        <p class="text-mini">name</p>
                    </div>
                    <div class="avatar avatar-md mx-3">
                        <img class="rounded-circle"
                             src="assets/img/woman.jpg"
                             alt="">
                        <p class="text-mini">name</p>
                    </div>
                    <div class="avatar avatar-md mx-3">
                        <img class="rounded-circle"
                             src="assets/img/woman.jpg"
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

                <ul class="my-list-group container-fluid"><?php
						$aq = DB::query("select question_id,question_title from question where question_project_id=$id order by question_id desc");
						foreach($aq as $k=>$v){
						?>
                        <li class="my-list-group-item py-2 py-md-3 mb-2 mb-md-3 rounded bg-app text-white row align-items-center">
                            <div class="col-3 col-md-auto pr-sm-2 pr-md-3">#<?=$k+1?></div>
                            <div class="col-9 col-md px-sm-2 px-md-3"><?=$v['question_title']?></div>
                            <div class="col-9 col-md-auto px-sm-2 px-md-5"><?php
								$ae = DB::query("select t.user_id, a.user_firstname,a.user_lastname,a.user_username from question_has_experts t left join user a on a.user_id=t.user_id where t.question_id={$v['question_id']}");
								foreach($ae as $vv){
								?>
                                <div class="avatar avatar-md mx-3 expertSingle" style="float:left">
                                    <img class="rounded-circle"
                                         src="assets/img/<?=$vv['user_username']?>.jpg"
                                         alt="">
                                    <p class="text-mini mb-0"><?=$vv['user_firstname']?> <?=$vv['user_lastname']?></p>
                                </div><?php
								}
								?>
                            </div>

                        </li><?php
						}
						?>
                </ul>
            </div>
        </div>
    </div>
<script type="text/javascript">
let experts = '';
$('.expertSingle').each(function(i,n){
	if(experts.indexOf(n.outerHTML) == -1)
		experts += n.outerHTML;
});
$('#expertsAll').html(experts);
</script>
</body>

</html>