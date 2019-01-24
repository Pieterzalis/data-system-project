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
			$('.badge-secondary').click(function(){
				$(this).toggleClass('active-keyword');
				$(this).toggleClass('nonactive-keyword');
			});
            $(".do_search").click(function () {
                    $("#sourcecontainer").html("<div class=\"row justify-content-md-center source-card\">\n" +
                        "\t<div class=\"col-sm-12 col-md-11\">\n" +
                        "\t\t<div class=\"card mb-3\">\n" +
                        "\t\t\t<div class=\"card-body\">\n" +
                        "\t\t\t\t<div class=\"row justify-content-center\">\n" +
                        "\t\t\t\t\t\t<img src=\"assets/img/load-gif.gif\" height=\"60\" width=\"60\">\n" +
                        "</div>\n" +
                        "<div class=\"row justify-content-center\">\n" +
                        "\t\t    <p>Zoeken...</p>\n" +
                        "\t\t\t\t</div>\n" +
                        "\t\t\t</div>\n" +
                        "\t\t</div>\n" +
                        "\t</div>\n" +
                        "</div>");
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
                    $(".keywordtags").children('.active-keyword').each(function(index){
                        autokeywords.push($(this).text());
                    });
                    keywords = userkeywords.concat(autokeywords);
					if((keywords.length < 3 && userkeywords == "") || keywords.length < 2){
						$("#sourcecontainer").html("<div class=\"row justify-content-md-center source-card\">\n" +
                            "\t<div class=\"col-sm-12 col-md-11\">\n" +
                            "\t\t<div class=\"card mb-3\">\n" +
                            "\t\t\t<div class=\"card-body\">\n" +
                            "\t\t\t\t<div class=\"row justify-content-center\">\n" +
                            "\t\t\t\t\t<p>Te weinig keywords. Gebruik minimaal twee keywords voor een zoekopdracht.</p>\n" +
                            "\t\t\t\t</div>\n" +
                            "\t\t\t</div>\n" +
                            "\t\t</div>\n" +
                            "\t</div>\n" +
                            "</div>");
					} else {
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
					}

            });


        });

        function store_source(button, url, publish_date, title, snippet, type, outlet){

            let questionID = $('.do_search').attr('id');
            let parentDiv = $(button).parents(".jq-addsource");

            $.post( "database/Model_Source.php", { func: "addToKnowledgeBase", question_id : questionID, url : url, publish_date : publish_date, title: title, snippet : snippet, type : type, outlet : outlet })
                .done(function( data ) {
                    if (!(data === 'success')){
                        alert(data)

                    } else {
                        // Successfull adding

                        $(parentDiv).html("<button class='btn btn-success jq-addtokb'><i class=\"fa fa-check-circle\" style='font-size:28px;'></i></button>");

                    }
                })
        }

	</script>
    <script>
        $(document).ready(function () {
            
            $("#help").on("click", function(){
                alert("De keywords worden gebruikt door de zoekmachine om relevante informatie te vinden. U kunt keywords uitschakelen door deze aan te klikken.");
            }); 
        });
        
    </script>
</head>

<body class="page_search_engine">
    <!-- 此处显示demo图作为参考-->
    <div class="demopage hidden">
        <img src="assets/demo/search_engine.png">
    </div>

    <div class="container-fluid my-layout d-flex flex-column">
        <div class="row justify-content-md-left removeleftmargin">
                <button type="button" class="btn btn-primary shadow bluebutton" onclick="window.location='distribution.php'">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>Terug naar vraag</button>
            </div>
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
                                                <div class="form-group mb-0">
                                                    <label>
                                                        <strong>Keywords </strong>
                                                        <i class="fa fa-question-circle cursor-pointer" id="help" title="Klik op een keyword om deze uit te sluiten in de zoekresultaten"></i>
                                                    </label>
                                                </div>
                                                <div class="keywordtags"><?php
								                //#列出该project的所有keyword
								                foreach($keywords as $v){
                                                    echo '<span class="badge badge-pill badge-secondary active-keyword cursor-pointer">'.$v['keyword_name'].'</span>';
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
                                                           id="gridCheck1" checked>
                                                    <label class="form-check-label"
                                                           for="gridCheck1">
                                                        Media bronnen van afgelopen maand
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input"
                                                           type="checkbox"
                                                           id="gridCheck2" checked>
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
                                        <button id="<?= $question_id ?>" type="button" class="btn btn-primary bluebutton do_search"><i class="fa fa-search"
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
                </div>
            </div>
        </div>
    </div>

</body>

</html>