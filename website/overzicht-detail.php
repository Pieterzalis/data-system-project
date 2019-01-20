<?php
require_once 'database/Model_Project.php';
$id = intval($_GET['id']);
if($id <= 0) exit('Parameter Error');//#如果id不对提示错误
$a = DB::queryOneRow("select a.question_id,a.question_title,a.question_project_id,b.project_title from question a left join project b on b.project_id=a.question_project_id where a.question_id=$id");//#查询问题和对应的project
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible"
          content="IE=edge">
    <title>Nieuw Project</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
          type="text/css"
          media="screen"
          href="assets/style.css" />
    <link rel="stylesheet"
          type="text/css"
          media="screen"
          href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet"
          href="assets/icon-font/css/font-awesome.min.css">

    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>

    <script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>

    <script src="assets/js/index.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
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
                    <a href="overzicht-detail-keyword.html"
                       class="w-100 text-dark a-hover-none">
                        <div class="card">
                            <div class="card-body">
                                <p><strong><?=$a['project_title']?></strong></p>
                                <div class="mb-0">
                                    <strong class="text-secondary">Keyword</strong>
                                    <i class="fa fa-angle-right text-dark"
                                       style="
                                       float:
                                       right"
                                       aria-hidden="true"></i>
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
                    </a>
                </div>
                <div class="col-sm col-md-6 col-lg-4">

                    <h6 class="text-secondary">Indiener</h6>
                    <div class="card">
                        <div class="card-body">
                            <a href="#"
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
                    <h6 class="text-secondary mt-3">Experts</h6>
                    <div class="avatar avatar-md">
                        <img class="rounded-circle"
                             src="assets/img/man.jpg"
                             alt="">
                        <p class="text-mini">name</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- row-table -->
        <div class="project-table mt-3">
            <button type="button"
                    class="btn btn-primary">
                <i class="fa fa-search"
                   aria-hidden="true"></i>
                Naar zeek
            </button>
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