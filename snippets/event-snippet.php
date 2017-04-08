<ul>

  <?php
if (!class_exists("Database")) {
    require __DIR__ . '/../utils/register_database.php';
    $dbh = Database::connect();
} else if (!$dbh) {
    $dbh = Database::connect();
}
$articles = array_reverse(ActivityList::getArticleActivities($dbh));
$langIszh = (!isset($_POST["lang"]) || $_POST["lang"] == "zh") && (!isset($_GET["lang"]) || $_GET["lang"] == "zh");
foreach ($articles as $article) {
  $num = $article->num;
  $tag = ($langIszh) ? $article->tag:$article->tag_fr;
  $title = ($langIszh) ? $article->title:$article->title_fr;
  $author = $article->author;
  $date = $article->date;
  $caption = ($langIszh) ? $article->caption:$article->caption_fr;
  $readmore = ($langIszh) ? "<nobr>阅读更多</nobr>":"<nobr>Lire la suite</nobr>";
    ?>
    <li class='activity-tile'>
      <img src='images/activity<?php echo $num; ?>/m0.jpg' alt='photo of activity'>
      <div>
        <p class='activity-tag glyphicon glyphicon-tag'>
          <?php echo $tag; ?>
        </p>
        <p class='activity-title'>
          <?php echo $title; ?>
        </p>
        <div class='autherdate'>
          <span class='auther glyphicon glyphicon-user'> <?php echo $author; ?></span>
          <span class='date glyphicon glyphicon-time'> <?php echo $date; ?></span>
        </div>
        <div class='hr'></div>
        <span class='activity-description'><?php echo $caption; ?></span>
        <span class='activity-modal-link' data-num=<?php echo $num.'>'.$readmore;?></span>
        <div class='hr'></div>
      </div>
    </li>
    <?php } $dbh = null ?>
</ul>

<div class="modal-box">
  <div class="modal-content">
  </div>
</div>