<?php
require_once 'database/Model_Project.php';
$question_id = intval($_GET['qid']);
$project_id = DB::queryFirstRow("SELECT question_project_id FROM question WHERE question_id = '$question_id'");
$project_id = $project_id['question_project_id'];
$keywords = DB::query("select keyword_name from keyword where keyword_project_id= '$project_id' ");

?>

<!DOCTYPE html>
<html>

<head>
    <title>Zoeken</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible"
          content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
          type="text/css"
          media="screen"
          href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet"
          href="assets/icon-font/css/font-awesome.min.css">
    <link rel="stylesheet"
      type="text/css"
      media="screen"
      href="assets/style.css" />

    <script src="assets/js/jquery-3.3.1.js"></script>

    <script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>

    <script src="assets/js/index.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
	<script>
        $(document).ready(function () {

            $(".do_search").click(function () {

                    $("#sourcecontainer").html("Searching for relevant sources...");
                    var use_news_articles = $('#gridCheck1:checked').val();
                    if (use_news_articles == undefined){
                        use_news_articles = 'off';
                    }
                    var use_old_answers = $('#gridCheck2:checked').val();
                    if (use_old_answers == undefined){
                        use_old_answers = 'off';
                    }
                    var fromdate = $("#datefrom").val();
                    if (fromdate == ''){
                        fromdate = 'nobound';
                    }
                    var todate = $("#dateto").val();
                    if (todate == ''){
                        todate = 'nobound';
                    }
                    console.log(use_news_articles);
                    console.log(use_old_answers);
                    var userkeywords = $("#Searchfield").val().split(',');
                    var autokeywords = [];
                    $(".keywordtags").children('span').each(function(index){
                        autokeywords.push($(this).text());
                    });
                    keywords = userkeywords.concat(autokeywords);
                    console.log(keywords);
                    console.log($("#datefrom").val());
                    var form = new FormData();
                    form.append('question_id','1');
                    form.append('keywords',JSON.stringify(keywords));
                    form.append('fromdate',fromdate);
                    form.append('todate',todate);
                    form.append('search_news',use_news_articles);
                    form.append('search_prev_answers',use_old_answers);
                    fetch('process_search.php', {
                            method: 'POST',
                            body: form
                        }).then(response => {
                            response.text().then(function (text) {
                                $("#sourcecontainer").html(text);
                            });
                        });

            });

            $(".jq-addtokb").click(function () {
                alert('test');
            });

            function store_source(button, url, publish_date, title, snippet, type, outlet){
                alert(title);
                $.post( "database/Model_Source.php", { func: "addToKnowledgeBase", question_id : '1', url : url, publish_date : publish_date, title: title, snippet : snippet, type : type, outlet : outlet })
                    .done(function( data ) {
                        if (!(data === 'success')){
                            alert('Error adding source to knowledge base.')
                        }
                    })
            }
        });

	</script>
</head>

<body class="page_search_engine">
    <!-- 此处显示demo图作为参考-->
    <div class="demopage hidden">
        <img src="assets/demo/search_engine.png">
    </div>

    <div class="container-fluid my-layout d-flex flex-column">
        <div class="row flex-1">
            <!-- layout_content -->
            <div class="col-sm p-0 layout_content d-flex justify-content-center ">
                <div class="container-fluid">
                    <div class="row justify-content-md-center">
                        <div class="col-sm-12 col-md-10">
                            <!-- search input -->
                            <form class="mt-3">
                                <div class="form-group row justify-content-center">
                                    <div class="input-group col-sm-12 col-md-8 col-lg-6">
                                        <div class="input-group-prepend clear">
                                            <div class="input-group-text">
                                                <i class="fa fa-search"
                                                   aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <input type="text"
                                               class="form-control"
                                               id="Searchfield"
                                               placeholder="voer hier uw zoekwoord in...">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="container">
                                        <div class="row justify-content-md-center">
                                            <div class="col-lg-3 text-center">
                                                <div class="form-group mb-0"><!--  -->
                                                    <label><strong>Sleutelwoorden</strong></label>
                                                </div>
                                                <div class="keywordtags"><?php
								                //#列出该project的所有keyword
								                foreach($keywords as $v){
                                                    echo '<span class="badge badge-pill badge-secondary">'.$v['keyword_name'].'</span>';
								                }
								                	?>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 text-center">
                                                <div class="form-group mb-0">
                                                    <label><strong>Zoek in deze periode (kamervragen)</strong></label>
                                                </div>
                                                <div class="row">
                                                    <span class="datumtitle">van:</span>
                                                </div>
                                                <div class="form-group row justify-content-center">
                                                    <div class="input-group col-sm-12">
                                                        <div class="input-group-prepend clear">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar-o"
                                                                   aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                        <input type="text"
                                                               class="form-control"
                                                               id="datefrom"
                                                               placeholder="dd-mm-yyyy">
                                                        <!-- 预留 placeholder="yyy/mm/dd" -->
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <span class="datumtitle">tot:</span>
                                                </div>
                                                <div class="form-group row justify-content-center">
                                                    <div class="input-group col-sm-12">
                                                        <div class="input-group-prepend clear">
                                                            <div class="input-group-text">
                                                                <i class="fa fa-calendar-o"
                                                                   aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                        <input type="text"
                                                               class="form-control"
                                                               id="dateto"
                                                               placeholder="dd-mm-yyyy">
                                                        <!-- 预留 placeholder="yyy/mm/dd" -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group mb-0 text-center">
                                                    <label><strong>Zoek in deze bronnen</strong></label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input"
                                                           type="checkbox"
                                                           id="gridCheck1">
                                                    <label class="form-check-label"
                                                           for="gridCheck1">
                                                        Media bronnen van afgelopen maand
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input"
                                                           type="checkbox"
                                                           id="gridCheck2">
                                                    <label class="form-check-label"
                                                           for="gridCheck2">
                                                        Oude kamervragen
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-sm col-md-12 text-center">
                                        <button type="button" class="btn btn-primary bluebutton do_search"><i class="fa fa-search"
                                               aria-hidden="true"></i>
                                            Zoek informatie
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr class="col-md-9">
					<div class="sourcecontainer" id="sourcecontainer">
                    </div>
            <nav aria-label="Page navigation example ">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item"><a class="page-link"
                                               href="#">Previous</a></li>
                                        <li class="page-item"><a class="page-link"
                                               href="#">1</a></li>
                                        <li class="page-item"><a class="page-link"
                                               href="#">2</a></li>
                                        <li class="page-item"><a class="page-link"
                                               href="#">3</a></li>
                                        <li class="page-item"><a class="page-link"
                                               href="#">4</a></li>
                                        <li class="page-item"><a class="page-link"
                                               href="#">5</a></li>
                                        <li class="page-item"><a class="page-link"
                                               href="#">6</a></li>
                                        <li class="page-item"><a class="page-link"
                                               href="#">Next</a></li>
                                    </ul>
                                </nav>
                </div>
            </div>
        </div>
    </div>

</body>

</html>