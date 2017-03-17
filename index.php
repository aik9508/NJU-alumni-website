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
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/ajax-utils.js"></script>

    </head>
    <body>
        <header>
            <div class="container">
                <div class="row">
                    <div id="logo" class="col-lg-3">
                        <a href="index.php"><img src="images/logo.png"></a>
                    </div>
                    <div id="association" class="col-lg-3">
                        <span>法国校友会</span>
                    </div>
                    <div class="header-right col-lg-2">
                        <a href="utils/register.php"><div id="button-inscription" class="glyphicon glyphicon-user"></div></a>
                        <div id="button-language" class="glyphicon glyphicon-globe"></div>
                    </div>
                </div>
            </div>
        </header>
        <div id="menu" class="collapse navbar-collapse">
            <div class="container">
                <ul class="nav navbar-nav">
                    <li id="button-accueil" class="menu-item">ACCUEIL</li>
                    <li id="button-profile" class="menu-item">NOTRE PROFIL</li>
                    <li id="button-activity" class="menu-item">ACTIVITÉS</li>
                    <li id="button-community" class="menu-item">COMMUNAUTÉ</li>
                    <li id="button-contact" class="menu-item">CONTACTEZ-NOUS</li>
                </ul>
            </div>
        </div>

        <!-- Here insert main contents of each page -->
        <div id="main-content">
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
                                <img src="images/jumbotron1.png" alt="picture 1" class="img-responsive">
                            </div>

                            <div class="item">
                                <img src="images/jumbotron2.png" alt="picture 2" class="img-responsive">
                            </div>

                            <div class="item">
                                <img src="images/jumbotron3.png" alt="picture 3" class="img-responsive">
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

            <div class="container">
                <div id="right-column">
                    <div id="information" class="block-tile fix-block">
                        <div id="information-title">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                            <span>INFORMATIONS</span>
                        </div>
                        <div class='hr bighr'></div>

                        <?php
                        $nbrOfExp = 10;
                        echo "<ul>";
                        for ($i = 1; $i <= $nbrOfExp; $i++) {
                            $greyBgd = ($i % 2 == 0) ? '' : 'greybgd';
                            echo <<<EOT
                    <li class="information-tile $greyBgd">
                        <span  class="glyphicon glyphicon-paperclip"></span>
                        <span id="news$i">
                        </span>
                    </li>
EOT;
                        }
                        echo "</ul>";
                        echo "<div class='hr bighr'></div>";
                        ?>

                    </div><!--End of information block-->
                    <div id="statistic" class="block-tile fix-block">
                        <?php
                        $alumnis = 2043;
                        $visitors = 2625;
                        $nbrOfAlumnis = number_format($alumnis, 0, ',', ' ');
                        $nbrOfVisitors = number_format($visitors, 0, ',', ' ');
                        echo "<div><strong id='alumni-number' class='count-number' count='$alumnis'>$nbrOfAlumnis</strong><span class='count-name'>&nbsp;&nbsp;Alumnis</span></div>";
                        echo "<div><strong id='visitor-number' class='count-number' count='$visitors'>$nbrOfVisitors</strong><span class='count-name'>&nbsp;&nbsp;Visiteurs</span></div>";
                        ?>
                    </div>
                </div>

                <div id="activities" class="block-tile flex-block">
                    <div id="activity-title">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span>ACTIVITÉS</span>
                    </div>
                    <div class='hr bighr'></div>

                    <?php
                    $nbrOfExp = 4;
                    echo "<div><ul>";
                    for ($i = 1; $i <= $nbrOfExp; $i++) {
                        $greyBgd = ($i % 2 == 0) ? '' : 'greybgd';
                        $date = '[01-10-2016]';
                        echo <<<EOT
                    <li class="activity-tile $greyBgd">
                       
                            <div class="activity-thumnail">
                                <img class="img-responsive" src="images/homeface1_tn.jpg" alt="activity thumnail">
                            </div>
                            <div class="activity-description">
                                <p>
                                    BlablabalabalablabalbalablabalbaklablabalalkdkgkahgjdajflkjwoirhfgoahdkafakljfklajflBlablabalabalablabalbalablabalbaklablabalalkdkgkahgjdajflkjwoirhfgoahdkafakljfklajflBlablabalabalablabalbalablabalbaklablabalalkdkgkahgjdajflkjwoi
                                </p>
                                <p>$date</p>
                            </div>
                       
                    </li>
EOT;
                    }
                    echo "</ul></div>";
                    echo "<div class='hr bighr'></div>";
                    ?>

                </div><!--End of activities block-->
            </div><!--End of home snippet-->
            <script src="js/countnumber.js"></script>
        </div><!--Here ends the main contents-->
        <div id="gotop"><img src="images/gotop.png"></div>
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
                            <img src="images/foot_logo.png">
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
        <script src="js/script.js"></script>
        <script src='js/BBS.js'></script>
    </body>
</html>
