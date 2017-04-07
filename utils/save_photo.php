<?php

session_start();
if (isset($_SESSION["currentUser"])) {
    if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == 'POST') {
        $path = "../photoDataBase/";
        $newname = $_SESSION["currentUser"]["prenom"] . $_SESSION["currentUser"]["nom"] . $_SESSION["currentUser"]["id"];
        $img = $_POST['imageData'];
        if ($_POST["type"] == "image/png") {
            $newname = $newname . ".png";
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
        } else {
            $newname = $newname . ".jpeg";
            $img = str_replace('data:image/jpeg;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
        }
        //$cwd=$_SERVER['DOCUMENT_ROOT']."/NJU-alumni-website/";
        $data = base64_decode($img);
        file_put_contents($path . $newname, $data);
//        $file = $_FILES['photoFile']['name'];
//        $info = pathinfo($file);
//        $ext = $info['extension'];
//        $newname = $newname . ".".$ext;
//        $tmp = $_FILES['photoFile']['tmp_name'];
//        move_uploaded_file($tmp, $path.$newname);
        require "register_database.php";
        $dbh = Database::connect();
        Photo::setPhoto($dbh, $_SESSION["currentUser"]["id"], $newname);
    }
}
