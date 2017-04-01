<div style="overflow:hidden">
  <?php
$numOfGaalleries = 3; // need to be changed according to number of events
for ($i=1;$i<=$numOfGaalleries;$i++) {
    $activity_name = "activity-name";
    echo "<div id='gallery-trigger".$i."' class='photo-modal-link col-md-6 col-sm-6 col-xm-12'>
    <img src='images/activity".$i."/m1.jpg'>"."<p>".$activity_name."</p></div>";
}
?>

</div>

<div class="modal-box">
  <div class="modal-content">
    <div id="gallery" style="display:none;">
      <!--<?php require "snippets/photo/1.php"; ?>-->
    </div>
  </div>
</div>
