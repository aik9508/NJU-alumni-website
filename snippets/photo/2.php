<div id="gallery" style="display:none;">
  <?php
for ($i=0;$i<11;$i++) {
    $path = "images/activity2/m".$i.".jpg";
    echo "<img src=$path data-image=$path>";
}

for ($i=1;$i<=1;$i++) {
    $path = "images/activity2/v".$i.".mp4";
    echo "<img data-image='images/activity2/v".$i.".jpg' data-type='html5video' data-videomp4=$path>";
}
?>
</div>
<script>
  $("#gallery").unitegallery({
    theme_enable_text_panel: false
  });
  $(".modal-box").css('display', 'block');
</script>