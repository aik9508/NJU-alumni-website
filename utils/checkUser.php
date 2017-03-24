<?php

if (isset($_POST['email'])) {
    require 'register_database.php';
    $dbh= Database::connect();
    $existed=User::getUserByEmail($dbh, $_POST['email']);
    if($existed!=null){
        echo 'existed';
    }else{
        echo '';
    }
}

