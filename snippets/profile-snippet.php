<!-- This is the profile page snippet to insert in the #main-content div of index.php -->
<?php
/**
 * Created by PhpStorm.
 * User: shiwen
 * Date: 2/21/2017
 * Time: 1:05
 */
?>

<div class="head-picture">
    <img src="images/introduction_jumbotron.jpg" alt="Picture">
</div>

<div class="container">
    <div id="profile-menu" class="block-tile">
        <div id="profile-title" class="block-title">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span>PROFILES</span>
        </div>
        <div class='bighr'></div>

        <ul>
            <?php
            $items = array("NJU", "Asso", "Chairmen", "Council", "Cert");
            $i = 0;
            $names = (!isset($_GET["lang"]) || $_GET["lang"] == "zh") ? array("南大简介", "校友会简介", "主席团成员", "理事会成员", "注册文件") : array("À propos de NJU", "À propos de l'AAENF", "Direction", "Conceil", "Déclaration");
            foreach ($items as $item) {
                $greyBgd = ($i % 2 == 1) ? '' : 'greybgd';
                echo <<<EOT
                <li class="profile-menu-tile $greyBgd">
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
    <div id="profile-content-container">
        <div class="profile-content-title block-title">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <?php
            $item_title = (!isset($_GET["lang"]) || $_GET["lang"] == "zh") ? "南大简介":"À propos de NJU";
            echo "<span>$item_title</span>";
            ?>
        </div>
        <div class='bighr'></div>
        <div id="profile-content">
            <?php require 'snippets/NJU-snippet.php';
            ?>
        </div>
        <div class='bighr'></div>
    </div>
</div>

