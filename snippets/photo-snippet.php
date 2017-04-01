
<div id="gallery" style="display:none;">
  <img src="images/activity20160625/m01.jpg" data-image="images/activity20160625/m01.jpg">
  <?php
for ($i=1;$i<=20;$i++) {
    $num = ($i<10)?("0".$i):($i);
    $path = "images/activity20160625/m".$num.".jpg";
    echo "<img src=$path data-image=$path>";
}
?>

</div>

