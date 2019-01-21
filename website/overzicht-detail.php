<?php
require_once 'database/Model_Project.php';
$id = intval($_GET['id']);
if($id <= 0) exit('Parameter Error');//#如果id不对提示错误
$a = DB::queryOneRow("SELECT a.question_id, 
            a.question_title, 
            a.question_project_id, b.project_title, 
            REPLACE(CONCAT(pm.parliamentmember_firstname, ' ', pm.parliamentmember_lastname_prefix, ' ', pm.parliamentmember_lastname), '  ', ' ') as indiener_fullname,
            pa.party_name
              FROM question a 
              LEFT JOIN project b ON b.project_id=a.question_project_id 
              LEFT JOIN parliamentmember pm ON b.project_submitter = pm.parliamentmember_id
              LEFT JOIN party pa ON pm.parliamentmember_party_id = pa.party_id
              WHERE a.question_id=".$id." ");

$indiener_name = $a['indiener_fullname'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Project overzicht</title>
    <?php
    include_once("templates/template_head.php");
    ?>
</head>


<body class="page_search_engine">

	<div class="card m-3 p-md-3 p-lg-4 text-center">
        <!-- row-info -->
        <div class="project-info">
            <div>
                <p><Strong><?=$a['question_title']?></Strong></p>
                <p>xxxxxxx: <Strong>4352-32423</Strong></p>
            </div>
           <div class="row justify-content-md-center">
                <div class="col-sm col-md-6 col-lg-4">

                    <h6 class="text-secondary">Project</h6>
                        <div class="card">
                            <div class="card-body">
                                <a href="overzicht-detail-keyword.html"
                                   class="w-100 text-dark a-hover-none">
                                    <p><strong><?= $a['project_title']?></strong></p>
                                    <i class="fa fa-angle-right text-dark"
                                       style="
                                       float:
                                       right"
                                       aria-hidden="true"></i>
                                </a>
                                <div class="mb-0">
                                    <strong class="text-secondary">Keywords</strong>

                                </div>
                                <div><?php
								//#列出该project的所有keyword
								$ak = DB::query('select keyword_name from keyword where keyword_project_id='.$a['question_project_id']);
								foreach($ak as $v){
                                    echo '<span class="badge badge-pill badge-secondary">'.$v['keyword_name'].'</span>';
								}
									?>
                                </div>
                            </div>
                        </div>

                </div>
                <div class="col-sm col-md-6 col-lg-4">

                    <h6 class="text-secondary">Indiener</h6>
                    <div class="card">
                        <div class="card-body w-100 d-flex align-items-center">
<!--                            <a href="#"-->
<!--                               class="w-100 d-flex align-items-center">-->
                                <div class="flex-none avatar avatar-md">
                                    <h5 style="display:flex; align-items: center; margin-bottom: 0;"><?php echo $a['party_name'] ?></h5>
                                </div>
                                <div class="flex-auto text-dark text-left">
                                    <p class="mb-0 pl-3"><?php echo $a['indiener_fullname'] ?></p>
                                </div>
                                <div class="flex-none">
                                    <i class="fa fa-angle-right text-dark"
                                       style="float:right"
                                       aria-hidden="true"></i>
                                </div>
<!--                            </a>-->
                        </div>
                    </div>
                    <h6 class="text-secondary mt-3">Experts</h6>
                    <div class="avatar avatar-md">
                        <img class="rounded-circle"
                             src="assets/img/man.jpg"
                             alt="">
                        <p class="text-mini">name</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm col-md-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-search"
                           aria-hidden="true"></i>
                        Informatie zoeken
                    </button>
                </div>
            </div>
        </div>

        <!-- row-table -->
        <div class="project-table mt-3">
            <h6 class="m-3">Kennisbank</h6>
            <div class="card-list">

                <div class="card mb-3 text-left">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-1 title">
                                <p>
                                    <strong>Title xxxx xxxx xxxxxxx</strong>
                                </p>
                            </div>
                            <div class="flex-none">
                                <a href=""
                                   class="card-close-btn text-secondary">
                                    <!-- close -->
                                    <i class="fa fa-close"
                                       aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-auto info">
                                Bron: <strong><u>xxxxx</u></strong>
                                <br>
                                Datum: <strong>xxxxxx</strong>
                            </div>
                            <div class="col-md content">content content content content content content content content content content </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3 text-left">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-1 title">
                                <p>
                                    <strong>Title xxxx xxxx xxxxxxx</strong>
                                </p>
                            </div>
                            <div class="flex-none">
                                <a href=""
                                   class="card-close-btn text-secondary">
                                    <!-- close -->
                                    <i class="fa fa-close"
                                       aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-auto info">
                                Bron: <strong><u>xxxxx</u></strong>
                                <br>
                                Datum: <strong>xxxxxx</strong>
                            </div>
                            <div class="col-md content">content content content content content content content content content content </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>