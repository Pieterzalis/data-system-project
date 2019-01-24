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
?>
<?php
    require_once 'database/Model_Project.php';
?>


<!DOCTYPE html>
<html>

<head>
    <title>Nieuwe Kamervragen</title>
    <?php
    include_once("templates/template_head.php");
    ?>

    <script>
        $(document).ready(function () {
            var fileUploader1 = document.getElementById('FileUploader1');
            var fileUploader2 = document.getElementById('FileUploader2');
            var fileUploader3 = document.getElementById('FileUploader3');
            var pathDisplayer = document.getElementById('file-name-text');
            var step1 = $("#step-1-form");
            var file_init = $("#file-init");
            var file_name = $("#file-name");
            var file_error = $("#file-error");
            file_name.hide();
            file_error.hide();
            
			
			
			// 查找到 id=step-1的控件
            var dragWidget=document.getElementById("step-1");
            // 给控件添加 拖拽进入的事件
            dragWidget.ondragenter=function(){
                // this.innerHTML="可以释放了";
            }
            // 给控件添加 拖拽 悬浮的事件（鼠标没有释放）
            dragWidget.ondragover=function(ev){
                ev.preventDefault();
            }
            // 给控件添加 拖拽 离开的事件
            dragWidget.ondragleave=function(){
                // this.innerHTML="将文件拖拽到此区域";
            }
            // 给控件添加 拖拽 鼠标释放的 事件
            dragWidget.ondrop=function(ev){
                ev.preventDefault();
                // 触发上传文件的功能
                fileDragChangeHandler(ev)
            }
            // 拖拽上传文件的方法，这个方法与fileUploaderChangeHandler一模一样，只是事件对象获取文件的方式不一样，后面的逻辑就跟手动选择文件上传是一致的了
            function fileDragChangeHandler(e, a, b, c) {
                step1.removeClass('alert alert-danger');
                var strFileName = '';
                if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length) {
                    strFileName = e.dataTransfer.files["0"].name;
                    if (strFileName && strFileName.length) {
                        if (strFileName.endsWith('.pdf')) {
                            //
                            file_init.hide();
                            file_name.show();
                            file_error.hide();
                            // alert('文件符合要求');
                            saveFile(e.dataTransfer.files["0"]);
                            // 完成上传文件的功能，这里面就是step步骤的切换，
                            upload(e.dataTransfer.files);
                        } else {
                            step1.addClass('alert alert-danger');
                            // alert('文件不符合要求');
                            file_init.hide();
                            file_name.hide();
                            file_error.show();
                            strFileName = '';
                        }
                    } else {
                        strFileName = '';
                    }
                }
                pathDisplayer.innerText = strFileName;
            }
			
			
			
			
			if (fileUploader1.addEventListener) {
                fileUploader1.addEventListener('change', fileUploaderChangeHandler, false);
            } else if (fileUploader1.attachEvent) {
                fileUploader1.attachEvent('onclick', fileUploaderClickHandler);
            } else {
                fileUploader1.onchange = fileUploaderChangeHandler;
            }
            if (fileUploader2.addEventListener) {
                fileUploader2.addEventListener('change', fileUploaderChangeHandler, false);
            } else if (fileUploader2.attachEvent) {
                fileUploader2.attachEvent('onclick', fileUploaderClickHandler);
            } else {
                fileUploader2.onchange = fileUploaderChangeHandler;
            }
            if (fileUploader3.addEventListener) {
                fileUploader3.addEventListener('change', fileUploaderChangeHandler, false);
            } else if (fileUploader3.attachEvent) {
                fileUploader3.attachEvent('onclick', fileUploaderClickHandler);
            } else {
                fileUploader3.onchange = fileUploaderChangeHandler;
            }
            function fileUploaderClickHandler(e, a, p, d) {
                setTimeout(function () {
                    fileUploaderChangeHandler(e, a, p, d);
                }, 0);
            }
            function fileUploaderChangeHandler(e, a, b, c) {
                step1.removeClass('alert alert-danger');
                var strFileName = '';
                if (e.currentTarget && e.currentTarget.files && e.currentTarget.files.length) {
                    strFileName = e.currentTarget.files["0"].name;
                    if (strFileName && strFileName.length) {
                        if (strFileName.endsWith('.doc') || strFileName.endsWith('.docx') || strFileName.endsWith('.txt') || strFileName.endsWith('.pdf')) {
                            //
                            file_init.hide();
                            file_name.show();
                            file_error.hide();
                            // alert('文件符合要求');
                            saveFile(e.currentTarget.files["0"]);
                            // TODO Should be moved to onclick of button
                            upload(e.currentTarget.files);
                        } else {
                            step1.addClass('alert alert-danger');
                            // alert('文件不符合要求');
                            file_init.hide();
                            file_name.hide();
                            file_error.show();
                            strFileName = '';
                        }
                    } else {
                        strFileName = '';
                    }
                }
                pathDisplayer.innerText = strFileName;
            }

            var currentFile;
            function saveFile(file) {
                currentFile = file;
            }
            function upload(files) {
                var form = new FormData();
                for (let i = 0; i < files.length; i++) {
                    let file = files[i];
                    form.append('files[]', file);
                }

                // Change parsing status to step-2
                $("#progress-step2").addClass("activated");
                $("#progress-step1").removeClass("current");
                $('#progress-step2').addClass('current');
                $('#progress-label1').html('<i class="fa fa-check white"></i>')
                $("#step-1").hide();
                $("#step-2").show();


                fetch('process.php', {
                    method: 'POST',
                    body: form
                }).then(response => {
                    console.log(response);

                    response.text().then(function (text) {

                        // text will contain the html response!!!
                        // Set the step-3 div with response content
                        $('#jq-step3-div').html(text);

                        // Set progress in top of screen
                        $("#progress-step3").addClass("activated");
                        $("#progress-step2").removeClass("current");
                        $("#progress-step3").addClass("current");
                        $('#progress-label2').html('<i class="fa fa-check white"></i>')

                        // First hide the div step 1
                        $("#step-2").hide();
                        $("#step-3").show();
						
						let txt = $("#projectTitleID strong").html();
						
						$("#cardText").html(txt);

                    });

                });
            }
        });
    </script>
    <script>

       
        function gotoStep1() {
            var step_1 = $('#step-1');
            var step_2 = $('#step-2');
            var step_3 = $('#step-3');
            step_1.show();
            step_2.hide();
            step_3.hide();
			
			var file_init = $("#file-init");
            var file_name = $("#file-name");
            var file_error = $("#file-error");

            file_init.show();
            file_name.hide();
            file_error.hide();
            
            $("#progress-step2").removeClass("current");
            $("#progress-step2").removeClass("activated");
            $("#progress-step3").removeClass("current");
            $("#progress-step3").removeClass("activated");
            $('#progress-label2').html('2')
            $('#progress-label1').html('1')



        }

        
        /*unction gotoStep2() {
            var step_1 = $('#step-1');
            var step_2 = $('#step-2');
            var step_3 = $('#step-3');
            step_1.show();
            step_2.hide();
            step_3.hide();

            setTimeout(() => {
                // 第二部等待5秒跳到第三步
                gotoStep3();
            }, 5000);

        }*/

        //进入第3步
        /*function gotoStep3() {
            var step_1 = $('#step-1');
            var step_2 = $('#step-2');
            var step_3 = $('#step-3');
            step_1.hide();
            step_2.hide();
            step_3.show();
            
            $('#progress-step2').removeClass('current');
            $('#progress-step3').addClass('current');
        }*/

        //When the page loads, execute GoToStep1();
        $(document).ready(function () {
            gotoStep1();
        })

    </script>
    <script>

        $(document).ready(function () {
            let myAlert = $("#alert-modal");

            window.showAlert = function () {
                myAlert.addClass('d-flex');
                myAlert.show();
            }
            window.hideAlert = function () {
                myAlert.hide();
                myAlert.removeClass('d-flex');
            }
            hideAlert();
        });
    </script>
    
    <script>
        $(document).ready(function () {
            function goToDistribution(){
                window.location = "distribution.php";
            }
        });
    </script>
    
    
    <style>
        .a_choose_click{
            position: relative;
        }
         .file-uploader{
            position:absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            z-index: 9;
            cursor: pointer;
        }
    </style>

</head>

<body class="page_search_engine">
    <!-- 此处显示demo图作为参考-->
    <div class="container-fluid my-layout d-flex flex-column">
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
                            <h3 class="page-title">Nieuwe Kamervragen</h3>
                        </div>
                        <div class="col-sm-4 d-flex align-items-center justify-content-end">
                            <div class="options">
                                <!-- UserName -->
                                    <div class="avatar">
                                        <img class="rounded-circle"
                                             src="assets/img/girl.png"
                                             alt="">
                                    </div>
                                <span class="profilename">Laura Zuidensteijn</span>
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
            <!-- layout_content -->
            <div class="col-sm layout_content container-fluid">
                <div class="row justify-content-md-center mt-md-3 mt-2">

                    <div class="col-sm-12 col-md-10 col-lg-8">

                        <div class="card">
                            <div class="card-body p-0">
                                <!-- step-line -->
                                <div class="container step-container">
                                    <div class="row step-line m-3 justify-content-md-center">
                                        <div class="col step">
                                            <div class="step-icon">
                                                <i class="fa fa-file fa-2x d-block d-md-none"></i>
                                                <i class="fa fa-file fa-3x d-none d-md-block"></i>
                                            </div>
                                            <div class="step-text">
                                                <p>Upload</p>
                                            </div>
                                            <div class="step-num activated current" id="progress-step1">
                                                <label id="progress-label1">1</label>
                                            </div>
                                        </div>
                                        <div class="col step p-0">
                                            <div class="step-hr">
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="col step">
                                            <div class="step-icon">
                                                <i class="fa fa-cog fa-2x d-block d-md-none"></i>
                                                <i class="fa fa-cog fa-3x d-none d-md-block"></i>
                                            </div>
                                            <div class="step-text">
                                                <p>Verwerk</p>
                                            </div>
                                            <div class="step-num" id="progress-step2">
                                                <label id="progress-label2">2</label>
                                            </div>
                                        </div>
                                        <div class="col step p-0">
                                            <div class="step-hr">
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="col step">
                                            <div class="step-icon">
                                                <i class="fa fa-check-square fa-2x d-block d-md-none"></i>
                                                <i class="fa fa-check-square fa-3x d-none d-md-block"></i>
                                            </div>
                                            <div class="step-text">
                                                <p>Controleer</p>
                                            </div>
                                            <div class="step-num" id="progress-step3">
                                                <label id="progress-label3">3</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- step-content -->
                                <!-- step-1 -->
                                <div id="step-1"
                                     class="step-content step-1 text-center p-3">
                                    <div class="card m-3">
                                        <div class="title mt-2 mx-2">
                                            <h4>Upload hier de kamervragen</h4>
                                        </div>
                                        <div class="options mt-2 mx-2">
                                            <div class="step-1-block"
                                                 id="step-1-form">
                                                <form id="UploadForm"
                                                      method="post"
                                                      enctype="multipart/form-data">

                                                    <!-- file-init -->
                                                    <div id="file-init">
                                                        <p>Sleep het bestand hier naar toe of
                                                            <a id="Choose_click_1" class="a_choose_click" style="cursor: pointer;" href=""
                                                               title="Choose file">klik<input style="cursor: pointer;" type="file" class="file-uploader" name="uploadDataField" id="FileUploader1" /></a>
                                                             hier om te zoeken op uw computer</p>
                                                    </div>

                                                    <!-- file-name -->
                                                    <div id="file-name"
                                                         style="display:none"
                                                         class="file-name container p-md-5">
                                                        <div class="row align-items-center">
                                                            <div class="col-sm-12 col-md-auto text-center text-md-right p-md-3 mb-3 mb-md-0">
                                                                <i class="mx-1 fa fa-3x fa-file-o"></i>
                                                            </div>
                                                            <div class="col-sm-12 col-md-auto text-center text-md-left p-md-3 mb-3 mb-md-0">
                                                                <p id="file-name-text"></p>
                                                            </div>
                                                            <div class="col-sm-12 col-md  text-center text-md-right p-md-3">
                                                                <button type="button" class="btn btn-success upload-file-btn">
                                                                    Volgende
                                                                    <i class="mx-1 fa fa-angle-right"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <!-- 点击这里在你的电脑上找另一个文件 -->
                                                        <p class="mt-3">Klik <a id="Choose_click_2" class="a_choose_click" href="" title="Choose file">hier<input type="file" class="file-uploader"
                                                        name="uploadDataField" id="FileUploader2"/></a> om een ander bestand te zoeken op uw computer</p>
                                                    </div>

                                                    <!-- file-error -->
                                                    <div id="file-error"
                                                         style="display:none"
                                                         class="file-error">
                                                       

                                                        <!-- 数据文件格式不支持 -->
                                                        <!-- 点击这里选择另一个文件 -->
                                                        <p>Bestandsformaat niet ondersteund
                                                            <a id="Choose_click_3"
                                                               class="a_choose_click"
                                                               href=""
                                                               title="Choose file">Klik<input type="file"
                                                                       class="file-uploader"
                                                                       name="uploadDataField"
                                                                       id="FileUploader3" />
                                                            </a>
                                                            hier om een ander bestand te kiezen</p>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                        <div class="notice m-2">
                                            <h4>Geaccepteerde bestandsformaten</h4>
                                            <div style="font-size:10px">
                                                <i class="fa m-sm-2 my-icon-file">
                                                    <span class="bg-danger text-white">pdf</span>
                                                    <hr>
                                                    <hr>
                                                    <hr>
                                                </i>
                                                <i class="fa m-sm-2 my-icon-file">
                                                    <span class="bg-darkblue text-white">docx</span>
                                                    <hr>
                                                    <hr>
                                                    <hr>
                                                </i>
                                            </div>
                                        </div>
                                    </div>

                                    <button onclick="window.location='distribution.php'" class="btn btn-danger">ANNULEER</button>
                                </div>


                                <!-- step-2 -->
                                <div id="step-2"
                                     class="step-content step-2 text-center p-3"
                                     style="display:none">
                                    <div class="card m-3">
                                        <div class="title mt-2 mx-2">
                                            <h4>System verwerkt de kamervragen</h4>
                                        </div>
                                        <div class="notice m-2">
                                            <div class="file-analysing">
                                                <span class="d-flex align-items-center justify-content-center">
                                                    <i class="fa my-icon-file bg-app loading">
                                                        <hr class="color-white">
                                                        <hr class="color-white">
                                                        <hr class="color-white">
                                                    </i>
                                                    <!-- <i class="fa fa-file color-app fa-5x"></i> -->
                                                    <i class="fa fa-circle-o-notch fa-spin fa-3x m-3 color-app"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <p class="mt-3">Een moment geduld alstublieft...</p>
                                    </div>

                                    <a><button class="btn btn-danger" onclick="window.location='distribution.php'">ANNULEER</button></a>
                                </div>

                                <!-- step-content -->
                                <div id="step-3"
                                     class="step-content step-3 text-center p-3"
                                     style="display:none">
                                    <div class="card m-3 p-md-3 p-lg-4" id="jq-step3-div">
                                        <!-- title -->
                                        <div class="title mt-2 mx-2">
                                            <h4>Upload</h4>
                                            <hr class="color-app">
                                        </div>

                                        <!-- row-info -->
                                        <div class="project-info">
                                            <div>

                                                <div class="mb-0">
                                                    <label>Indiener</label>
                                                </div>
                                                <div id="projectTitleID">
                                                    <p><Strong>XX XXXXX XXXXXXX XXXXX XXXXXXX XXXXX XXXXXX</Strong></p>
                                                </div>
                                                <p>xxxxxxx:<Strong>4352-32423</Strong></p>
                                            </div>
                                            <div class="row justify-content-md-center">
                                                <div class="col-sm col-md-6 col-lg-4">

                                                    <div class="mb-0">
                                                        <label>Keyword</label>
                                                    </div>
                                                    <div>
                                                        <span class="badge badge-pill badge-secondary">keyword</span>
                                                        <span class="badge badge-pill badge-secondary">keyword</span>
                                                        <span class="badge badge-pill badge-secondary">keyword</span>
                                                        <span class="badge badge-pill badge-secondary">keyword</span>
                                                        <span class="badge badge-pill badge-secondary">keyword</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm col-md-6 col-lg-4">
                                                    <div class="mb-0">
                                                        <label>Indiener</label>
                                                    </div>
                                                    <p><Strong>XX XXXXX XXXXXXX XXXXX XXXXXXX XXXXX XXXXXX</Strong></p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- row-table -->
                                        <div class="project-table">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2">Vragen</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <a><button class="btn btn-danger" onclick="window.location='distribution.php'">ANNULEER </button></a>
                                    <a><button class="btn btn-success mx-3"  onclick="showAlert()">VOEG TOE</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="alert-modal"
         class="position-fixed sticky-top w-100 h-100 bg-shadow align-items-center justify-content-center d-none"
         onclick="hideAlert()">
        <div class="card"
             style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title text-center">Project opgeslagen</h5>
				
                <p class="card-text" id="cardText"></p>

                <div class="text-right">
                    <?php if (isUserExpert($user_id)) { ?>
                        <a href="overzicht.php" class="card-link text-secondary"><strong>OK</strong></a>
                    <?php } else { ?>
                        <a href="distribution.php" class="card-link text-secondary"><strong>OK</strong></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

</body>

</html>