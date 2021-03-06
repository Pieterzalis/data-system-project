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
?>
<!DOCTYPE html>
<html>

<head>
    <title>Overzicht</title>
    <?php
    include_once("templates/template_head.php");
    ?>
    <style>
        .btn-outline-light-trans{
        border-color: #ffffff55;
    }
        .btn-outline-light-trans:hover,
        .btn-outline-light-trans:focus{
        border-color: #ffffff55 !important;
        background: #ffffff22 !important;
        color: #fff !important
    }
        .btn-outline-light-trans:active{
        border-color: #ffffff77 !important;
        background: #ffffff11 !important;
        color: #fff !important
    }
    </style>
    <script>
        // Load jquery calls after page load.
        $(document).ready(function () {
			/*//#注释掉这里，为了使搜索按钮生效
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
            console.log(pageId);//选中的ID
            jump(pageId);//跳转
        }
        function search() {
            back();
        }
        function jump(pageId) {
             $('.page-title')[0].innerText='Project';
			// indexPage
            var indexNavPage = $('#indexPage');
            // childPage
            var childNavPage = $('#childPage');
            indexNavPage.hide();
            childNavPage.show();
            // 测试百度
            // childNavPage.attr('src', 'https://www.baidu.com/s?ie=utf-8&f=8&rsv_bp=1&tn=baidu&wd=' + pageId); 
            // 真实请求
            childNavPage.attr('src', 'overzicht-detail.php?id=' + pageId);//#这里换成php文件
        }
        function back() {
            lastClick.removeClass("actived");
            // indexPage
            var indexNavPage = $('#indexPage');
            // childPage
            var childNavPage = $('#childPage');
            childNavPage.hide();
            indexNavPage.show();
            // 请求清空
            childNavPage.attr('src', '');
        }
    </script>

</head>

<body class="page_project_overview2">
    <!-- 此处显示demo图作为参考-->
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
                            <h3 class="page-title">Overzicht</h3>
                        </div>
                        <div class="col-sm-4 d-flex align-items-center justify-content-end">
                            <div class="options">
                                <!-- UserName -->
                                <a href="">
                                    <div class="avatar">
                                        <img class="rounded-circle"
                                             src="assets/img/woman.jpg"
                                             alt="">
                                    </div>
                                    Francine ten Noord
                                </a>
                                <!-- sign-out -->
                                <a href="login.php"
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
                                                       placeholder="Search Keyword">
                                            </div>
                                        </div>
                                        <div class="text-center py-3 px-2">
                                            <button type="button"
                                                    class="btn btn-outline-light btn-outline-light-trans shadow"
                                                    onclick="search()">
                                                <i class="fa fa-home"
                                                   aria-hidden="true"></i>

                                                Jouw Kamervragen
                                            </button>
                                            
                                        </div>
                                    </form>
                                    <div id="accordion">
                                        <!-- card -->
										<?php
										//#从数据库取出所有project
										$sql = "SELECT DISTINCT project_id,project_title 
                                                FROM question 
                                                INNER JOIN project ON question_project_id = project_id 
                                                WHERE question_id IN ( 
                                                    SELECT question_id 
                                                    FROM question_has_experts 
                                                    WHERE user_id = '$user_id' 
                                                )
                                                ORDER BY project_id DESC";


										if(isset($_POST['Search']))//#如果有搜索就用这个sql来查project
											$sql = "SELECT DISTINCT project_id,project_title 
                                                    FROM question 
                                                    INNER JOIN project ON question_project_id = project_id 
                                                    WHERE question_id IN ( 
                                                        SELECT question_id 
                                                        FROM question_has_experts 
                                                        WHERE user_id = '$user_id' 
                                                    )
                                                    and project_title like '%{$_POST['Search']}%' 
                                                    order by project_id desc";
										$a = DB::query($sql);

										foreach($a as $v){//#显示project列表
										?>
                                        <div class="card m-2">
                                            <div class="card-header collapsed"
                                                 id="headingOne<?=$v['project_id']?>"
                                                 data-toggle="collapse"
                                                 data-target="#collapseOne<?=$v['project_id']?>"
                                                 aria-expanded="false"
                                                 aria-controls="collapseOne<?=$v['project_id']?>">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-none mr-2">
                                                        <i class="fa fa-file fa-fw"
                                                           aria-hidden="true"></i>
                                                    </div>
                                                    <div class="flex-1"><?=$v['project_title']?></div>
                                                    <div class="flex-none  ml-2">
                                                        <i class="fa fa-angle-down"
                                                           aria-hidden="true"></i>
                                                    </div>
                                                </div>

                                            </div>

                                            <div id="collapseOne<?=$v['project_id']?>"
                                                 class="collapse"
                                                 aria-labelledby="headingOne<?=$v['project_id']?>"
                                                 data-parent="#accordion">
                                                <!-- card-body -->
                                                <div class="card-body">
													<?php
													//#project下的各个问题
													$aa = DB::query("SELECT * FROM question 
                                                                     WHERE question_id IN ( 
                                                                         SELECT question_id 
                                                                         FROM question_has_experts 
                                                                         WHERE user_id = '$user_id'  
                                                                     ) 
                                                                     AND question_project_id={$v['project_id']} 
                                                                     ORDER BY question_id DESC ");
													foreach($aa as $kk=>$vv){
													?>
                                                    <!-- child-item -->
                                                    <a class="child-item"
                                                       onclick="changePage(this,{pageId:<?=$vv['question_id']?>})">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-none mr-2">
                                                                <i class="fa fa-fw"
                                                                   aria-hidden="true"></i><p>#<?=$kk+1?></p>
                                                            </div>
                                                            <div class="flex-1"><?=$vv['question_title']?></div>
                                                            <div class="flex-none ml-2">
                                                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </a>
													<?php
													}
													?>
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
                <!-- content -->

                <!-- index Page -->
                <div id="indexPage"
                     class="container-fluid py-3 py-md-0">
                    <div class="row">
                        <div class="col-sm mx-md-3 mx-ld-5">
                            <div class="jq-question-assigned-content">
                            <?php
                                getAssignedQuestionsHtml(2)
									
                            ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- iframe child Page 通过左侧点击访问子页面（overzicht-detail.html），同时传递相应的页面ID进入，后端根据ID渲染overzicht-detail.html页面 -->
                <iframe id="childPage"
                        src=""
                        name="listReload"
                        class="iframe-child-page"
						frameborder="0"
                        style="display: none; min-height:800px; width:100%; margin:0;"><!--#这里改了下style，让子框架全部显示-->
                </iframe>

                <!-- 此处显示demo图作为参考-->
                <div class="hidden">
                    <img class="hidden"
                         style="position: absolute;width: 100%;"
                         src="assets/demo/overzicht-index.png">
                    <img class="hidden"
                         style="position: absolute;width: 100%;"
                         src="assets/demo/overzicht-detail.png">
                    <img class=""
                         style="position: absolute;width: 100%;"
                         src="assets/demo/overzicht-detail-keyword.png">
                </div>

            </div>
        </div>
    </div>

</body>

</html>