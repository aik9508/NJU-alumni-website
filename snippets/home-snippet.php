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
    <div id="home-right-column" class="side-menu">
        <div id="information" class="block-tile fix-block">
            <div id="information-title" class="block-title">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span><?php echo $langIszh ? "南大新闻" : "Nouvelle de NJU";?></span>
            </div>
            <div class='bighr'></div>

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
            echo "<div class='bighr'></div>";
            ?>

        </div><!--End of information block-->
        <div id="statistic" class="block-tile fix-block">
            <?php
            $alumnis = 2000 + $_SESSION["alumni_number"];
            $visitors =2000 + $_SESSION["val_visited"];
            $nbrOfAlumnis = number_format($alumnis, 0, ',', ' ');
            $nbrOfVisitors = number_format($visitors, 0, ',', ' '); 
            ?>
            <table>
                <tbody>
                    <tr>
                        <td><strong id='alumni-number' class='count-number' data-count=<?php echo $alumnis ?>><?php echo $nbrOfAlumnis ?></strong></td>
                        <td><span class='count-name'><?php echo (!isset($_GET["lang"]) || $_GET["lang"] == "zh") ? "注册校友" : "Alumni"; ?></span></td>
                    </tr>
                    <tr>
                        <td><strong id='visitor-number' class='count-number' data-count='<?php echo $visitors ?>'><?php echo $nbrOfVisitors?></strong></td>
                        <td><span class='count-name'><?php echo (!isset($_GET["lang"]) || $_GET["lang"] == "zh") ? "访问人次" : "Visiteurs"; ?></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div id="activities" class="block-tile flex-block">
        <div id="activity-title" class="block-title">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span><?php echo $langIszh ? "近期活动" : "Nouvelle de l'AAENF";?></span>
        </div>
        <div class='bighr'></div>
<?php require "snippets/event-snippet.php";
?>

        <div class='bighr'></div>

    </div><!--End of activities block-->
</div><!--End of home snippet-->
<script src="js/countnumber.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/BBS.js"></script>