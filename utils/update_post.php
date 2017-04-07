<?php

session_start();
if (!isset($_POST) || !isset($_SESSION["currentUser"])) {
    exit(0);
}
var_dump($_POST);
require 'register_database.php';
$dbh = Database::connect();
$update_user_query = "UPDATE `NJUers` SET";
$update_user_array = [];
if (isset($_POST["nom"])) {
    $update_user_query = $update_user_query . " `nom`= ? ";
    array_push($update_user_array, $_POST["nom"]);
}
if (isset($_POST["prenom"])) {
    if (count($update_user_array) > 0) {
        $update_user_query = $update_user_query . ",";
    }
    $update_user_query = $update_user_query . " `prenom` = ?";
    array_push($update_user_array, $_POST["prenom"]);
}
if (isset($_POST["num"])) {
    if (count($update_user_array) > 0) {
        $update_user_query = $update_user_query . ",";
    }
    $update_user_query = $update_user_query . " `numero` = ?";
    array_push($update_user_array, $_POST["num"]);
}
if (count($update_user_array) > 0) {
    $update_user_query = $update_user_query . " WHERE `id`=?";
    array_push($update_user_array, $_POST["id"]);
    User::update($dbh, $update_user_query, $update_user_array);
}

$diplomas = ["licence", "master", "doctorat"];
for ($i = 0; $i < count($diplomas); $i++) {
    $promo = "";
    $dpt = "";
    if (isset($_POST["promo-" . $diplomas[$i]])) {
        $promo = $_POST["promo-" . $diplomas[$i]];
    }
    if (isset($_POST["dpt-" . $diplomas[$i]])) {
        if (!$_POST["dpt-" . $diplomas[$i]] && isset($_POST["promo-" . $diplomas[$i]]) && !$promo) {
            Diploma::delete($dbh, $_POST["id"], $i);
            continue;
        }
        $dpt = array_search($_POST["dpt-" . $diplomas[$i]], $_SESSION["DEPARTEMENT_ARRAY"]);
    }
    $update_study_query = "";
    $update_study_array = [];
    if ($dpt || $dpt === 0) {
        if (Diploma::getDiploma($dbh, $_POST["id"], $i)) {
            $update_study_query = "UPDATE `diplomas` SET";
            if ($promo) {
                $update_study_query = $update_study_query . " `promotion`=? ,";
                array_push($update_study_array, $promo);
            }
            $update_study_query = $update_study_query . " `departement`=? WHERE id=? AND diplome=?";
            array_push($update_study_array, $dpt);
            array_push($update_study_array, $_POST["id"]);
            array_push($update_study_array, $i);
            Diploma::update($dbh, $update_study_query, $update_study_array);
        } else {
            Diploma::insertDiplomas($dbh, $_POST["id"], $i, $promo, $dpt);
        }
    } else if ($promo) {
        $update_study_query = "UPDATE `diplomas` SET `promotion`=? WHERE id=? AND diplome=?";
        array_push($update_study_array, $promo);
        array_push($update_study_array, $_POST["id"]);
        array_push($update_study_array, $i);
        Diploma::update($dbh, $update_study_query, $update_study_array);
    }
}

if (isset($_POST["email"])) {
    if ($_POST["email"]) {
        Info::setInfo($dbh, $_POST["id"], 0, $_POST["email"]);
    } else {
        Info::delete($dbh, $_POST["id"], 0);
    }
}
if (isset($_POST["fonction"])) {
    if ($_POST["fonction"]) {
        Info::setInfo($dbh, $_POST["id"], 1, $_POST["fonction"]);
    } else {
        Info::delete($dbh, $_POST["id"], 0);
    }
}
if (isset($_POST["entreprise"])) {
    if ($_POST["entreprise"]) {
        Info::setInfo($dbh, $_POST["id"], 2, $_POST["entreprise"]);
    } else {
        Info::delete($dbh, $_POST["id"], 0);
    }
}

$dbh = null;

