
<?php
for ($i=1;$i<=5;$i++) {
    $path = "images/activity1/m".$i.".jpg";
    echo "<img src=$path data-image=$path>";
}

for ($i=1;$i<=0;$i++) {
    $path = "images/activity1/v".$i.".mp4";
    echo "<img data-image='images/activity1/m1.jpg' data-type='html5video' data-videomp4=$path>";
}
?>