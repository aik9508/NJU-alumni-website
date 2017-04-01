<?php
/**
 * Created by PhpStorm.
 * User: shiwen
 * Date: 2/21/2017
 * Time: 1:06
 */
?>

<div class="head-picture">
    <img src="images/activity_jumbotron.jpg" alt="Picture">
</div>

<div class="container">
    <div id="activity-menu" class="block-tile">
        <div id="activity-title" class="block-title">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span>ACTIVITES</span>
        </div>
        <div class='bighr'></div>

        <ul>
            <?php
            $items = array("event", "photo");
            $i = 0;
            $names = (!isset($_GET["lang"]) || $_GET["lang"] == "zh") ? array("活动交流", "相册影集") : array("Activités", "Photos & Vidéos");
            foreach ($items as $item) {
                $greyBgd = ($i % 2 == 1) ? '' : 'greybgd';
                echo <<<EOT
                <li class="activity-menu-tile $greyBgd">
                    <span class="glyphicon glyphicon-paperclip"></span>
                    <span name=$items[$i]>$names[$i]</span>
                </li>
EOT;
                $i++;
            }
            ?>
        </ul>

        <div class='bighr'></div>
    </div>
    <div id="activity-content-container">
        <div class="activity-content-title block-title">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <?php
            $item_title = (!isset($_GET["lang"]) || $_GET["lang"] == "zh") ? "联谊活动" : "Loisirs";
            echo "<span>$item_title</span>";
            ?>
        </div>
        <div class='bighr'></div>
        <div id="activity-content">
            <?php
            require 'snippets/event-snippet.php';
            ?>

        </div>
        <div class='bighr'></div>
    </div>
</div>

