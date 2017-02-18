<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/personal.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script src="js/BBS.js"></script>
    <title>Bienvenues</title>
</head>
<body>
<header>
    <div class="container">
        <div class="row">
            <div id="logo" class="col-lg-3">
                <a href="index.php"><img src="sources/logo.png"></a>
            </div>
            <div id="association" class="col-lg-3">
                <span>法国校友会</span>
            </div>
            <div class="header-right col-lg-2">
                <div class="glyphicon glyphicon-user"></div>
                <div class="glyphicon glyphicon-globe"></div>
            </div>
        </div>
    </div>
</header>
<div id="menu" class="collapse navbar-collapse">
    <div class="container">
        <ul class="nav navbar-nav">
            <li class="menu-item">ACCUEIL</li>
            <li class="menu-item">NOTRE PROFIL</li>
            <li class="menu-item">ACTIVITÉS</li>
            <li class="menu-item">COMMUNAUTÉ</li>
            <li class="menu-item">CONTACTEZ-NOUS</li>
        </ul>
    </div>
</div>

<!--start home snippet-->
<!--最好写一个函数generateJumbotron来生成-->
<div class="jumbotron">
    <div class="container">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img src="sources/jumbotron1.png" alt="picture 1" class="img-responsive">
                </div>

                <div class="item">
                    <img src="sources/jumbotron2.png" alt="picture 2" class="img-responsive">
                </div>

                <div class="item">
                    <img src="sources/jumbotron3.png" alt="picture 3" class="img-responsive">
                </div>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>

<!--Here comes the main contents-->
<div id="main-content" class="container">
    <div class="row">
        <div id="activities" class="block-tile col-lg-8 col-md-8 col-sm-7 col-xs-12">
            <div id="activity-title">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>ACTIVITÉS</span>
            </div>
            <div class='hr bighr'></div>

            <?php
            $nbrOfExp = 5;
            for ($i = 1; $i <= $nbrOfExp; $i++) {
                $greyBgd = ($i % 2 == 0) ? '' : 'greybgd';
                $date = '[01-10-2016]';
                echo <<<EOT
                    <div class="$greyBgd">
                        <div class="row">
                            <div class="activity-thumnail col-md-3 col-sm-3">
                                <img class="img-responsive" src="sources/homeface1_tn.jpg" alt="activity thumnail">
                            </div>
                            <div class="activity-description col-md-9 col-sm-9">
                                <p>
                                    BlablabalabalablabalbalablabalbaklablabalalkdkgkahgjdajflkjwoirhfgoahdkafakljfklajflBlablabalabalablabalbalablabalbaklablabalalkdkgkahgjdajflkjwoirhfgoahdkafakljfklajflBlablabalabalablabalbalablabalbaklablabalalkdkgkahgjdajflkjwoi
                                </p>
                                <p>$date</p>
                            </div>
                        </div>
                    </div>
EOT;
            }
            echo "<div class='hr bighr'></div>";
            ?>

        </div><!--End of activities block-->

        <div id="information" class="block-tile col-lg-4 col-md-4 col-sm-5 col-xs-12">
            <div id="information-title">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span>INFORMATIONS</span>
            </div>
            <div class='hr bighr'></div>

            <?php
            $nbrOfExp = 10;
            for ($i = 1; $i <= $nbrOfExp; $i++) {
                $greyBgd = ($i % 2 == 0) ? '' : 'greybgd';
                echo <<<EOT
                    <div class="information-tile $greyBgd">
                        <span  class="glyphicon glyphicon-paperclip"></span>
                        <span>
                            Une phrase de titre d'information
                        </span>
                    </div>
EOT;
            }
            echo "<div class='hr bighr'></div>";
            ?>

        </div><!--End of information block-->

        <div id="statistic" class="block-tile col-lg-4 col-md-4 col-sm-5 col-xs-12">
            <?php
            $alumnis = 1043;
            $visitors = 2625;
            $nbrOfAlumnis = number_format($alumnis,0,',',' ');
            $nbrOfVisitors = number_format($visitors,0,',',' ');
            echo "<div id='alumni-number'><strong class='count-number'>$nbrOfAlumnis</strong><span class='count-name'>&nbsp;&nbsp;Alumnis</span></div>";
            echo "<div id='visitor-number'><strong class='count-number'>$nbrOfVisitors</strong><span class='count-name'>&nbsp;&nbsp;Visiteurs</span></div>";
            ?>
        </div>
    </div>
    <!--End of home snippet-->
</div>
<!--Here ends the main contents-->

<footer>
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <!--start friendly links-->
                <div class="friendly-links col-sm-4 col-md-5 vertical-center">
                    <a class="icon-href" href="http://www.nju.edu.cn/" target="_blank">
                        <span class="icon icon1"></span>
                        <p>NJU</p>
                    </a>
                    <a class="icon-href" href="http://bbs.nju.edu.cn/" target="_blank">
                        <span class="icon icon2"></span>
                        <p>BBS</p>
                    </a>
                    <a class="icon-href" href="http://www.nju.org.cn/" target="_blank">
                        <span class="icon icon3"></span>
                        <p>AN</p>
                    </a>
                    <a class="icon-href" href="http://njuedf.nju.edu.cn" target="_blank">
                        <span class="icon icon4"></span>
                        <p>FN</p>
                    </a>
                    <!--<img src="sources/icon.png">-->
                </div>
                <!--end friendly links-->

                <!--start foot logo-->
                <div class="foot-logo col-sm-4 col-md-2 vertical-center">
                    <img src="sources/foot_logo.png">
                </div>
                <!--end foot logo-->

                <!--start follow links-->
                <div class="follow-links col-sm-4 col-md-5 vertical-center">
                    <a class="icon-href" href="#">
                        <span class="icon icon1"></span>
                    </a>
                    <a class="icon-href" href="#">
                        <span class="icon icon2"></span>
                    </a>
                    <a class="icon-href" href="#">
                        <span class="icon icon3"></span>
                    </a>
                    <a class="icon-href" href="#">
                        <span class="icon icon4"></span>
                    </a>
                    <!-- <img src="sources/shares.png"> -->
                </div>
                <!--end follow links-->
            </div> <!--end footer-top row-->
        </div><!--end footer-top container-->
    </div><!--end footer-top-->

    <!--start footer-botton-->
    <div class="footer-bottom">
        <span>Copyright@Ke WANG & Shiwen XIA</span>
    </div>
    <!--end footer-bottom-->
</footer>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>