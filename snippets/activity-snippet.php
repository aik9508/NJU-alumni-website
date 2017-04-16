<?php
/**
* Created by PhpStorm.
* User: shiwen
* Date: 2/21/2017
* Time: 1:06
*/
$pageTitle = $langIszh ? "活动" : "ACTIVITES";
$items = array("event", "photo");
$names = $langIszh ? array("活动交流", "相册影集") : array("Activités", "Photos & Vidéos");
?>

  <div class="head-picture">
    <img src="images/activity_jumbotron.jpg" alt="Picture">
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
          <li class="activity-head-menu">
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
    <div id="activity-menu" class="block-tile side-menu">
      <div id="activity-title" class="block-title">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span><?php echo $pageTitle; ?></span>
      </div>
      <div class='bighr'></div>

      <ul>
        <?php
$i = 0;
foreach ($items as $item) {
  $active = ($i==0)?"active":"";
?>
            <li class="activity-menu-tile <?php echo $active; ?>">
                <span class="glyphicon glyphicon-paperclip"></span>
                <span data-name='<?php echo $items[$i];?>'><?php echo $names[$i] ;?></span>
            </li>
            <?php
    $i++;
}
?>
      </ul>

      <div class='bighr'></div>
    </div>



    <div id="activity-content-container" class="content-container">





      <div class="activity-content-title block-title">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <?php
$subpage = (isset($_GET["subpage"]))?$_GET["subpage"]:"0";
$item_title = $names[$subpage];
echo "<span>$item_title</span>";
?>
      </div>
      <div class='bighr'></div>
      <div id="activity-content">
        <?php
require "snippets/$items[$subpage]-snippet.php";
?>

      </div>
      <div class='bighr'></div>
    </div>
  </div>