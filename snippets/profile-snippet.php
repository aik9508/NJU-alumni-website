<!-- This is the profile page snippet to insert in the #main-content div of index.php -->
<?php
/**
* Created by PhpStorm.
* User: shiwen
* Date: 2/21/2017
* Time: 1:05
*/
$pageTitle = $langIszh ? "关于我们" : "NOTRE PROFILE";
$items = array("NJU", "Asso", "Chairmen", "Council", "Cert");
$names = $langIszh ? array("南大简介", "校友会简介", "主席团成员", "理事会成员", "注册文件") : array("À propos de NJU", "À propos de l'AAENF", "Direction", "Conceil", "Déclaration");
?>

  <div class="head-picture">
    <img src="images/introduction_jumbotron.jpg" alt="Picture">
  </div>


  <div class="head-menu">
    <div class="head-menu-titlebar accordion">
      <span class="head-menu-title"><?php echo $pageTitle; ?></span>
      <span class="glyphicon glyphicon-menu-hamburger"></span>
    </div>
    <div class="accordion-menu">
      <ul class="accordion-list">
        <?php
$i = 0;
foreach ($items as $item) {?>
          <li class="profile-head-menu">
            <span class="glyphicon glyphicon-paperclip"></span>
            <span data-name=<?php echo "'".$items[$i]. "'>".$names[$i]; ?></span>
          </li>
          <?php $i++;
}
?>
      </ul>
    </div>
  </div>

  <div class="container">
    <div id="profile-menu" class="block-tile side-menu">
      <div id="profile-title" class="block-title">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span><?php echo $pageTitle; ?></span>
      </div>
      <div class='bighr'></div>

      <ul>
        <?php
$i = 0;
foreach ($items as $item) {?>
          <li class="profile-menu-tile">
            <span class="glyphicon glyphicon-paperclip"></span>
            <span data-name=<?php echo "'".$items[$i]. "'>".$names[$i]; ?></span>
          </li>
          <?php $i++;
}
?>
      </ul>

      <div class='bighr'></div>
    </div>

    <div id="profile-content-container" class="content-container">









      <div class="profile-content-title block-title">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <?php
$item_title = $langIszh ? "南大简介":"À propos de NJU";
echo "<span>$item_title</span>";
?>

      </div>
      <div class='bighr'></div>
      <div id="profile-content">
        <?php
$lang = (isset($_GET["lang"]))?$_GET["lang"]:"zh";
require 'snippets/NJU-snippet-'.$lang.'.php';
?>
      </div>
      <div class='bighr'></div>
    </div>
  </div>