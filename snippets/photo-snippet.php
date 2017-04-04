<div style="overflow:hidden">

 <?php
    if (!isset($dbh)) {
        require __DIR__ . '/../utils/register_database.php';
        $dbh = Database::connect();
    } else if (!$dbh) {
        $dbh = Database::connect();
    }
    $galleries = array_reverse(ActivityList::getGalleryActivities($dbh));

    foreach ($galleries as $gallery) {
        ?>
        <div data-num=<?php echo $gallery->num;?> class='photo-modal-link col-md-6 col-sm-6 col-xm-12'>
            <img src='images/activity<?php echo $gallery->num;?>/m0.jpg' alt='photo of activity'>
            <p class='gallery-title'><?php echo $gallery->title;?></p>
        </div>
    <?php } $dbh = null ?>

</div>

<div class="modal-box">
    <div class="modal-content" id="gallery-container">
    </div>
</div>
