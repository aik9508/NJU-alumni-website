<?php
session_start();
if (isset($_SESSION["currentUser"])) {
    if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == 'POST') {
        $path = "../photoDataBase/";
        $newname = $_SESSION["currentUser"]["prenom"] . $_SESSION["currentUser"]["nom"] . $_SESSION["currentUser"]["id"];
        $file = $_FILES['photoFile']['name'];
        $info = pathinfo($file);
        $ext = $info['extension'];
        $newname = $newname . ".".$ext;
        $tmp = $_FILES['photoFile']['tmp_name'];
        move_uploaded_file($tmp, $path.$newname);
        require "register_database.php";
        $dbh= Database::connect();
        Photo::setPhoto($dbh, $_SESSION["currentUser"]["id"], $newname);
    }
}
