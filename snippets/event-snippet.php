<ul>

  <?php
require __DIR__.'/../utils/register_database.php';
$dbh = Database::connect();
$totalnum = ActivityList::getActivityNumber($dbh);

for ($i=$totalnum;$i>=1;$i--) {
  $act = ActivityList::getActivityInfo($dbh,$i);
  ?>
<li class='activity-tile'>
      <img src='images/activity<?php echo $i; ?>/m0.jpg'>
      <div>
        <p class='activity-tag glyphicon glyphicon-tag'><?php echo $act->tag; ?></p>
        <p class='activity-title'><?php echo $act->title; ?></p>
        <div class='autherdate'>
          <span class='auther glyphicon glyphicon-user'> <?php echo $act->author; ?></span>
          <span class='date glyphicon glyphicon-time'> <?php echo $act->date; ?></span>
        </div>
        <div class='hr'></div>
        <span class='activity-description'><?php echo $act->caption; ?></span>
        <span class='activity-modal-link' num=<?php echo $i; ?>>Read More</span>
      </div>
    </li>  
<?php } ?>
</ul>

<div class="modal-box">
  <div class="modal-content">
  </div>
</div>