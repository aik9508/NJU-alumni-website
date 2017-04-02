<?php

if (isset($_POST)) {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $promo_start = $_POST["promo_start"];
    $promo_end = $_POST["promo_end"];
    $studies = [];
    if (isset($_POST["studies"])) {
        $studies = $_POST["studies"];
    }
    $departements = [];
    if (isset($_POST["departements"])) {
        $departements = $_POST["departements"];
    }
    require "register_database.php";
    $dbh = Database::connect();
    $query_params = User::createQuery($nom, $prenom, $promo_start, $promo_end, $studies, $departements);
    if ($_POST["count"]) {
        echo "<span id='count' class='display-none'>" . User::countResults($dbh, $query_params[0], $query_params[1]) . "</span>";
    }
    $results = User::searchUser($dbh, $query_params[0], $query_params[1], $_POST["limit1"], $_POST["limit2"]);
    if ($results == null) {
        echo null;
    } else {
        for ($i = 0; $i < count($results); $i++) {
            $individu = $results[$i];
            $name = ucfirst($individu["prenom"]) . " " . ucfirst($individu["nom"]);
            $photo = Photo::getPhoto($dbh, $individu["id"]);
            if ($photo == null) {
                $photo = "sources/default.jpg";
            } else {
                $photo = "photoDatabase/" . $photo;
            }
            $alumni_id = $individu["id"];
            echo <<<EOT
            <div class="profile-card col-lg-3 col-md-4 col-sm-6 col-xm-12">
                <div class="profile-img-wrapper">
                    <img src=$photo alt="photo" class="img-thumbnail"/>
                </div>
                <div class="profile-info">
                    <a id='$alumni_id'>$name</a>
                </div>
            </div>
EOT;
        }
    }
    $dbh = null;
}

