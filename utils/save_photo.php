<?php
$path="photos/";
if(isset($_POST) and $_SERVER['REQUEST_METHOD']=='POST'){
    $name=$_FILES['photoFile']['name'];
    $tmp=$_FILES['photoFile']['tmp_name'];
    if(strlen($name)){
        echo $name.' '.$tmp;
    }
}
