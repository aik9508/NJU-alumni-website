
<?php
for ($i=1;$i<=45;$i++) {
    $path = "images/activity3/m".$i.".jpg";
    echo "<img src=$path data-image=$path>";
}

for ($i=1;$i<=4;$i++) {
    $path = "images/activity3/v".$i.".mp4";
    echo "<img data-image='images/activity3/m1.jpg' data-type='html5video' data-videomp4=$path>";
}
?>