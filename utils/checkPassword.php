<?php
/* Check the old password on database, and then update password. */
session_start();
if (!isset($_POST['pwd'])) {
    echo FALSE;
} else if (!isset($_SESSION["currentUser"])) {
    echo "Not Login";
} else {
    require "register_database.php";
    $dbh = Database::connect();
    if (User::checkPasswordByID($dbh, $_SESSION["currentUser"]["id"], $_POST['pwd'])) {
        User::changePassword($dbh, $_SESSION["currentUser"]["id"], $_POST['new_pwd']);
        echo TRUE;
    }
}
