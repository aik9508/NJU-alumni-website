<div id="gallery" style="display:none;">
  <?php
for ($i=0;$i<36;$i++) {
    $path = "images/activity2/m".$i.".jpg";
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