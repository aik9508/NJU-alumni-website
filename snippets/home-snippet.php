<!-- This is the snippet of home page to insert into the #main-content div of index.php -->

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
    <div id="home-right-column">
        <div id="information" class="block-tile fix-block">
            <div id="information-title" class="block-title">
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
        <div id="activity-title" class="block-title">
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
<script src="js/BBS.js"></script>