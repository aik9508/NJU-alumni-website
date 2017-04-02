
<?php
for ($i=1;$i<=48;$i++) {
    $path = "images/activity1/m".$i.".jpg";
    echo "<img src=$path data-image=$path>";
}

for ($i=1;$i<=3;$i++) {
    $path = "images/activity1/v".$i.".mp4";
    echo "<img data-image='images/activity1/m1.jpg' data-type='html5video' data-videomp4=$path>";
}
?>