<?php
/* 
 * When a user signs up, check if the email entered is already used by another person. 
 * When a user signs in, check if the email and the password entered are correct. 
 */
if (isset($_POST['email'])) {
    require 'register_database.php';
    $dbh = Database::connect();
    if (!isset($_POST['psw'])) {
        $existed = User::getUserByEmail($dbh, $_POST['email']);
        if ($existed != null) {
            echo 'existed';
        } else {
            echo '';
        }
    } else {
        if(User::checkPassword($dbh, $_POST['email'], $_POST['psw'])){
            echo true;
        }else{
            echo false;
        }
    }
}

