<ul>

    <?php
    if (!class_exists("Database")) {
        require __DIR__ . '/../utils/register_database.php';
        $dbh = Database::connect();
    } else if (!$dbh) {
        $dbh = Database::connect();
    }
    $articles = array_reverse(ActivityList::getArticleActivities($dbh));

    foreach ($articles as $article) {
        ?>
        <li class='activity-tile'>
            <img src='images/activity<?php echo $article->num; ?>/m0.jpg' alt='photo of activity'>
            <div>
                <p class='activity-tag glyphicon glyphicon-tag'><?php echo $article->tag; ?></p>
                <p class='activity-title'><?php echo $article->title; ?></p>
                <div class='autherdate'>
                    <span class='auther glyphicon glyphicon-user'> <?php echo $article->author; ?></span>
                    <span class='date glyphicon glyphicon-time'> <?php echo $article->date; ?></span>
                </div>
                <div class='hr'></div>
                <span class='activity-description'><?php echo $article->caption; ?></span>
                <span class='activity-modal-link' data-num=<?php echo $article->num; ?>>Read More</span>
            </div>
        </li>  
    <?php } $dbh = null ?>
</ul>

<div class="modal-box">
    <div class="modal-content">
    </div>
</div>