<?php

session_start();
if (!isset($_POST)) {
    exit(0);
}
require 'register_database.php';
$dbh = Database::connect();
$licence = ($_POST['promo_licence'] != "");
$master = $_POST['promo_master'] != "";
$doctorat = $_POST['promo_doctorat'] != "";
$sexe = 2;
if ($_POST['sexe'] == "Homme") {
    $sexe = 0;
} else if ($_POST['sexe'] == "Femme") {
    $sexe = 1;
}
User::insertUser($dbh, $_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['mdp'], $_POST['num'], $sexe);
$id = User::getIDByEmail($dbh, $_POST['email']);
if ($licence) {
    Diploma::insertDiplomas($dbh, $id, 0, $_POST['promo_licence'], array_search($_POST['dept_licence'], $_SESSION["DEPARTEMENT_ARRAY"]));
}
if ($master) {
    Diploma::insertDiplomas($dbh, $id, 1, $_POST['promo_master'], array_search($_POST['dept_master'], $_SESSION["DEPARTEMENT_ARRAY"]));
}
if ($doctorat) {
    Diploma::insertDiplomas($dbh, $id, 2, $_POST['promo_doctorat'], array_search($_POST['dept_doctorat'], $_SESSION["DEPARTEMENT_ARRAY"]));
}
echo User::countResults($dbh, "WHERE 1", null);
$dbh = null;



