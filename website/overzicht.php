<!DOCTYPE html>
<html>

<head>
    <title>Overzicht</title>
    <?php
    include_once("templates/template_head.php");
    ?>
    <script>

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
            // indexPage
            var indexNavPage = $('#indexPage');
            // childPage
            var childNavPage = $('#childPage');

            indexNavPage.hide();
            childNavPage.show();

            // 测试百度
            // childNavPage.attr('src', 'https://www.baidu.com/s?ie=utf-8&f=8&rsv_bp=1&tn=baidu&wd=' + pageId); 

            // 真实请求
            childNavPage.attr('src', 'overzicht-detail.html?id=' + pageId);
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
                                <a href="login.html"
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
                                    <form class="p-2">

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
                                                       id="Search"
                                                       placeholder="">
                                            </div>
                                        </div>
                                        <div class="text-center py-3 px-2">
                                            <button type="button"
                                                    class="btn btn-outline-light"
                                                    onclick="search()">Alle toegewezen kamervragen</button>
                                        </div>
                                    </form>
                                    <div id="accordion">
                                        <!-- card -->
                                        <div class="card m-2">
                                            <div class="card-header"
                                                 id="headingOne"
                                                 data-toggle="collapse"
                                                 data-target="#collapseOne"
                                                 aria-expanded="true"
                                                 aria-controls="collapseOne">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-none mr-2">
                                                        <i class="fa fa-file fa-fw"
                                                           aria-hidden="true"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        het artikel "Kinderen kunnen voortaan – zonder medisch dossier – slecht rijgedrag van ouders melden"</div>
                                                    <div class="flex-none  ml-2">
                                                        <i class="fa fa-angle-down"
                                                           aria-hidden="true"></i>
                                                    </div>
                                                </div>

                                            </div>

                                            <div id="collapseOne"
                                                 class="collapse show"
                                                 aria-labelledby="headingOne"
                                                 data-parent="#accordion">
                                                <!-- card-body -->
                                                <div class="card-body">
                                                    <!-- child-item -->
                                                    <a class="child-item"
                                                       onclick="changePage(this,{pageId:1})">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-none mr-2">
                                                                <i class="fa fa-fw"
                                                                   aria-hidden="true"></i><p>#1</p>
                                                            </div>
                                                            <div class="flex-1">Bent u bekend met het artikel "Kinderen kunnen voortaan – zonder medisch dossier – slecht rijgedrag van ouders melden"?
                                                            </div>
                                                            <div class="flex-none ml-2">
                                                                <i class="fa fa-angle-right"
                                                                   aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <!-- child-item -->
                                                    <a class="child-item"
                                                       onclick="changePage(this,{pageId:2})">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-none mr-2">
                                                                <i class="fa fa-fw"
                                                                   aria-hidden="true"></i><p>#2</p>
                                                            </div>
                                                            <div class="flex-1">Waarom is het mogelijk dat een geloofwaardige melding van slecht rijgedrag zonder bewijsvoering in behandeling wordt genomen en de rijbevoegdheid wordt opgeschort? Hoe wenselijk acht u deze situatie? Kunt u uw antwoord toelichten?
                                                            </div>
                                                            <div class="flex-none ml-2">
                                                                <i class="fa fa-angle-right"
                                                                   aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <!-- child-item -->
                                                    <a class="child-item"
                                                       onclick="changePage(this,{pageId:3})">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-none mr-2">
                                                                <i class="fa fa-fw"
                                                                   aria-hidden="true"></i><p>#4</p>
                                                            </div>
                                                            <div class="flex-1">Bent u het eens met de stelling dat dit kan leiden tot willekeur en misbruik van deze regeling? Kunt u uw antwoord toelichten?
                                                            </div>
                                                            <div class="flex-none ml-2">
                                                                <i class="fa fa-angle-right"
                                                                   aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <!-- child-item -->
                                                    <a class="child-item"
                                                       onclick="changePage(this,{pageId:'unknow'})">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-none mr-2">
                                                                <i class="fa fa-fw"
                                                                   aria-hidden="true"></i><p>#6</p>
                                                            </div>
                                                            <div class="flex-1">Kunt u aangeven welke overige criteria gelden bij het beoordelen van de geloofwaardigheid van de melding van slecht rijgedrag? Wie heeft deze criteria vastgesteld?
                                                            </div>
                                                            <div class="flex-none ml-2">
                                                                <i class="fa fa-angle-right"
                                                                   aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- card -->
                                        <div class="card m-2">
                                            <div class="card-header collapsed"
                                                 id="headingTwo"
                                                 data-toggle="collapse"
                                                 data-target="#collapseTwo"
                                                 aria-expanded="false"
                                                 aria-controls="collapseTwo">

                                                <div class="d-flex align-items-center">
                                                    <div class="flex-none mr-2">
                                                        <i class="fa fa-file fa-fw"
                                                           aria-hidden="true"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        het bericht "De overheid is de regie kwijt in het bestrijden van overlast van ratten"</div>
                                                    <div class="flex-none  ml-2">
                                                        <i class="fa fa-angle-down"
                                                           aria-hidden="true"></i>
                                                    </div>
                                                </div>

                                            </div>
                                            <div id="collapseTwo"
                                                 class="collapse"
                                                 aria-labelledby="headingTwo"
                                                 data-parent="#accordion">
                                                <!-- card-body -->
                                                <div class="card-body">
                                                    <!-- child-item -->
                                                    <a class="child-item"
                                                       onclick="changePage(this,{pageId:'unknow'})">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-none mr-2">
                                                                <i class="fa fa-fw"
                                                                   aria-hidden="true"></i><p>#1</p>
                                                            </div>
                                                            <div class="flex-1">Bent u bekend met bericht "Steeds meer overlast in steden en buitengebie-den. Rattenbestrijding strandt"?
                                                            </div>
                                                            <div class="flex-none ml-2">
                                                                <i class="fa fa-angle-right"
                                                                   aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <!-- child-item -->
                                                    <a class="child-item"
                                                       onclick="changePage(this,{pageId:'unknow'})">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-none mr-2">
                                                                <i class="fa fa-fw"
                                                                   aria-hidden="true"></i><p>#2</p>
                                                            </div>
                                                            <div class="flex-1">Kunt u bevestigen dat er een groot risico is voor de volksgezondheid als de overlast van ratten verder toeneemt omdat ratten ziektes (waaronder dierziektes) kunnen verspreiden en ratten drager zijn van verschillende bacteriën?
                                                            </div>
                                                            <div class="flex-none ml-2">
                                                                <i class="fa fa-angle-right"
                                                                   aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <!-- child-item -->
                                                    <a class="child-item"
                                                       onclick="changePage(this,{pageId:'unknow'})">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-none mr-2">
                                                                <i class="fa fa-fw"
                                                                   aria-hidden="true"></i><p>#3</p>
                                                            </div>
                                                            <div class="flex-1">Deelt u de mening van het Kennis- en Adviescentrum Dierplagen dat de preventie niet goed geregeld is? Deelt u de mening van ongediertebestrijders die waarschuwen voor »middeleeuwse taferelen met veel ziektes»? Zo nee waarom niet?
                                                            </div>
                                                            <div class="flex-none ml-2">
                                                                <i class="fa fa-angle-right"
                                                                   aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <!-- child-item -->
                                                    <a class="child-item"
                                                       onclick="changePage(this,{pageId:'unknow'})">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-none mr-2">
                                                                <i class="fa fa-fw"
                                                                   aria-hidden="true"></i><p>#4</p>
                                                            </div>
                                                            <div class="flex-1">Deelt u de mening van het Kennis- en Adviescentrum Dierplagen dat de preventie niet goed geregeld is? Deelt u de mening van ongediertebestrijders die waarschuwen voor »middeleeuwse taferelen met veel ziektes»? Zo nee waarom niet?
                                                            </div>
                                                            <div class="flex-none ml-2">
                                                                <i class="fa fa-angle-right"
                                                                   aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- card -->
                                        <div class="card m-2">
                                            <div class="card-header collapsed"
                                                 data-toggle="collapse"
                                                 data-target="#collapseThree"
                                                 aria-expanded="false"
                                                 aria-controls="collapseThree"
                                                 id="headingThree">

                                                <div class="d-flex align-items-center">
                                                    <div class="flex-none mr-2">
                                                        <i class="fa fa-file fa-fw"
                                                           aria-hidden="true"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                    het uitstempelen van zeevarenden in de haven van Rotterdam</div>
                                                    <div class="flex-none  ml-2">
                                                        <i class="fa fa-angle-down"
                                                           aria-hidden="true"></i>
                                                    </div>
                                                </div>

                                            </div>
                                            <div id="collapseThree"
                                                 class="collapse"
                                                 aria-labelledby="headingThree"
                                                 data-parent="#accordion">
                                                <!-- card-body -->
                                                <div class="card-body">
                                                    <!-- child-item -->
                                                    <a class="child-item"
                                                       onclick="changePage(this,{pageId:'unknow'})">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-none mr-2">
                                                                <i class="fa fa-fw"
                                                                   aria-hidden="true"></i><p>#1</p>
                                                            </div>
                                                            <div class="flex-1">Bent u bekend met het bericht «Oude dieselauto’s niet meer welkom in Arnhemse binnenstad (met kaartje)»?
                                                            </div>
                                                            <div class="flex-none ml-2">
                                                                <i class="fa fa-angle-right"
                                                                   aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <!-- child-item -->
                                                    <a class="child-item"
                                                       onclick="changePage(this,{pageId:'unknow'})">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-none mr-2">
                                                                <i class="fa fa-fw"
                                                                   aria-hidden="true"></i><p>#2</p>
                                                            </div>
                                                            <div class="flex-1">Wat valt er te zeggen over de data waarop het Arnhemse gemeentebestuur zich beroept? In hoeverre zijn de Arnhemse metingen van een regionale Gemeentelijke Gezondheidsdienst (GGD) of metingen van Milieudefensie gelet op het feit dat in Amsterdam afwijkingen in meetmethoden zijn geconstateerd representatief en conform de richtlijnen van het Rijksinstituut voor Volksgezondheid en Milieu (RIVM)?
                                                            </div>
                                                            <div class="flex-none ml-2">
                                                                <i class="fa fa-angle-right"
                                                                   aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <!-- child-item -->
                                                    <a class="child-item"
                                                       onclick="changePage(this,{pageId:'unknow'})">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-none mr-2">
                                                                <i class="fa fa-fw"
                                                                   aria-hidden="true"></i><p>#3</p>
                                                            </div>
                                                            <div class="flex-1">Wat is de planning van Arnhem? Wat zijn de gevolgen voor mensen met een oudere diesel die hun stad niet meer in kunnen? Hoe worden mensen die de binnenstad bezoeken bijvoorbeeld met een youngtimer gecompenseerd voor de schade? Wat doet de gemeente Arnhem voor deze mensen?
                                                            </div>
                                                            <div class="flex-none ml-2">
                                                                <i class="fa fa-angle-right"
                                                                   aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <!-- child-item -->
                                                    <a class="child-item"
                                                       onclick="changePage(this,{pageId:'unknow'})">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-none mr-2">
                                                                <i class="fa fa-fw"
                                                                   aria-hidden="true"></i><p>#4</p>
                                                            </div>
                                                            <div class="flex-1">Hoe voorkomen we een wirwar van bebording voor milieuzones? Zijn er al ideeën hoe de gewenste eenduidigheid in te vullen is gezien het feit dat er nu sprake is van willekeur aan de hand van jaartallen van voertuigen die eigenlijk niets zeggen over de echte uitstoot (zo kan een kleine oudere diesel een stuk schoner zijn dan een grotere nieuwere auto)? Hoe denkt u daarover? Wanneer valt duidelijkheid te verwachten en welke norm per voertuig wordt dan geldend?
                                                            </div>
                                                            <div class="flex-none ml-2">
                                                                <i class="fa fa-angle-right"
                                                                   aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
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

                            <!-- Start of project card including questions -->
                            <!-- TODO Insert this dynamically on page load. -->
                            <div class="card project-card" id="project-card-1">
                                <div class="card-body">

                                    <table class="table table-sm mb-0">
                                        <tbody>
                                            <tr>
                                                <td class="no-border"
                                                    scope="row">Project:</td>
                                                <th class="no-border"
                                                    scope="row">Het artikel "Kinderen kunnen voortaan – zonder medisch dossier – slecht rijgedrag van ouders melden" </th>
                                            </tr>
                                            <tr>
                                                <td class="no-border"
                                                    scope="row">Deadline:</td>
                                                <th class="no-border"
                                                    scope="row">31-01-2019 </th>
                                            </tr>
                                            <tr>
                                                <td class="no-border"
                                                    scope="row">Indiener:</td>
                                                <th class="no-border"
                                                    scope="row">Corrie van der Brink - 50 Plus </th>
                                            </tr>
                                            <tr>
                                                <td class="no-border pt-4"
                                                    scope="row">Vragen:</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <ul class="my-list-group container-fluid">
                                        <a class="child-item" onclick="changePage(this,{pageId:1})">
                                        <li class="my-list-group-item py-2 py-md-3 mb-2 mb-md-3 rounded bg-app text-white row align-items-center questions">
                                            <div class="col-3 col-md-auto pr-sm-2 pr-md-3"></div>
                                            <div class="col-9 col-md px-sm-2 px-md-3 border-md-right">Bent u het eens met de stelling dat dit kan leiden tot willekeur en misbruik van deze regeling? Kunt u uw antwoord toelichten?</div>
                                            <div class="col-9 col-md-auto px-sm-2 px-md-3">
                                                <span class="fa-stack">
                                                    <i class="fa fa-floppy-o fa-stack-2x"
                                                       aria-hidden="true"></i>
                                                </span>
                                                <span class="fa-stack">
                                                    <i class="fa fa-circle fa-stack-2x"></i>
                                                    <i class="fa fa-stack-1x fa-inverse text-dark">0</i>
                                                </span>
                                                <span>opgeslagen bronnen</span>
                                            </div>
                                            <div class="col-3 col-md-auto pl-sm-4 pl-md-3">
                                                <i class="fa fa-angle-right"
                                                   aria-hidden="true"></i>
                                            </div>
                                            </li></a>
                                        <a class="child-item" onclick="changePage(this,{pageId:1})">
                                        <li class="my-list-group-item py-2 py-md-3 mb-2 mb-md-3 rounded bg-app text-white row align-items-center">
                                            <div class="col-3 col-md-auto pr-sm-2 pr-md-3"></div>
                                            <div class="col-9 col-md px-sm-2 px-md-3 border-md-right">Waarom is het mogelijk dat een geloofwaardige melding van slecht rijgedrag zonder bewijsvoering in behandeling wordt genomen en de rijbevoegdheid wordt opgeschort? Hoe wenselijk acht u deze situatie? Kunt u uw antwoord toelichten?</div>
                                            <div class="col-9 col-md-auto px-sm-2 px-md-3">
                                                <span class="fa-stack">
                                                    <i class="fa fa-floppy-o fa-stack-2x"
                                                       aria-hidden="true"></i>
                                                </span>
                                                <span class="fa-stack">
                                                    <i class="fa fa-circle fa-stack-2x"></i>
                                                    <i class="fa fa-stack-1x fa-inverse text-dark">8</i>
                                                </span>
                                                <span>opgeslagen bronnen</span>
                                            </div>
                                            <div class="col-3 col-md-auto pl-sm-4 pl-md-3">
                                                <i class="fa fa-angle-right"
                                                   aria-hidden="true"></i>
                                            </div>
                                            </li></a>
                                        <a class="child-item" onclick="changePage(this,{pageId:1})">
                                        <li class="my-list-group-item py-2 py-md-3 mb-2 mb-md-3 rounded bg-app text-white row align-items-center">
                                            <div class="col-3 col-md-auto pr-sm-2 pr-md-3"></div>
                                            <div class="col-9 col-md px-sm-2 px-md-3 border-md-right">Bent u het eens met de stelling dat dit kan leiden tot willekeur en misbruik van deze regeling? Kunt u uw antwoord toelichten?</div>
                                            <div class="col-9 col-md-auto px-sm-2 px-md-3">
                                                <span class="fa-stack">
                                                    <i class="fa fa-floppy-o fa-stack-2x"
                                                       aria-hidden="true"></i>
                                                </span>
                                                <span class="fa-stack">
                                                    <i class="fa fa-circle fa-stack-2x"></i>
                                                    <i class="fa fa-stack-1x fa-inverse text-dark">10</i>
                                                </span>
                                                <span>opgeslagen bronnen</span>
                                            </div>
                                            <div class="col-3 col-md-auto pl-sm-4 pl-md-3">
                                                <i class="fa fa-angle-right"
                                                   aria-hidden="true"></i>
                                            </div>
                                            </li></a>
                                        <a class="child-item" onclick="changePage(this,{pageId:1})">
                                        <li class="my-list-group-item py-2 py-md-3 mb-2 mb-md-3 rounded bg-app text-white row align-items-center">
                                            <div class="col-3 col-md-auto pr-sm-2 pr-md-3"> </div>
                                            <div class="col-9 col-md px-sm-2 px-md-3 border-md-right">Kunt u aangeven welke overige criteria gelden bij het beoordelen van de geloofwaardigheid van de melding van slecht rijgedrag? Wie heeft deze criteria vastgesteld?</div>
                                            <div class="col-9 col-md-auto px-sm-2 px-md-3">
                                                <span class="fa-stack">
                                                    <i class="fa fa-floppy-o fa-stack-2x"
                                                       aria-hidden="true"></i>
                                                </span>
                                                <span class="fa-stack">
                                                    <i class="fa fa-circle fa-stack-2x"></i>
                                                    <i class="fa fa-stack-1x fa-inverse text-dark">2</i>
                                                </span>
                                                <span>opgeslagen bronnen</span>
                                            </div>
                                            <div class="col-3 col-md-auto pl-sm-4 pl-md-3">
                                                <i class="fa fa-angle-right"
                                                   aria-hidden="true"></i>
                                            </div>
                                            </li></a>
                                    </ul>

                                </div>
                            </div>
                            <!-- End project card -->

                        </div>
                    </div>
                </div>

                <!-- iframe child Page 通过左侧点击访问子页面（overzicht-detail.html），同时传递相应的页面ID进入，后端根据ID渲染overzicht-detail.html页面 -->
                <iframe id="childPage"
                        src=""
                        name="listReload"
                        class="iframe-child-page"
                        style="display: none">
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