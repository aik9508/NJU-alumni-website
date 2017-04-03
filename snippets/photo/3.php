<div id="gallery" style="display:none;">
  <?php
for ($i=0;$i<45;$i++) {
    $path = "images/activity3/m".$i.".jpg";
    echo "<img src=$path data-image=$path>";
}

for ($i=1;$i<=4;$i++) {
    $path = "images/activity3/v".$i.".mp4";
    echo "<img data-image='images/activity3/v".$i.".jpg' data-type='html5video' data-videomp4=$path>";
}
?>
</div>
<script>
  $("#gallery").unitegallery({
    theme_enable_text_panel: false
  });
  $(".modal-box").css('display', 'block');
</script>