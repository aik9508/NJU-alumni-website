<div id="gallery" style="display:none;">
  <?php
for ($i=0;$i<11;$i++) {
    $path = "images/activity3/m".$i.".jpg";
    echo "<img src=$path data-image=$path>";
}

?>
</div>
<script>
  $("#gallery").unitegallery({
    theme_enable_text_panel: false
  });
  $(".modal-box").css('display', 'block');
</script>