<?php

define("NB_DEPARTEMENTS", 25);

class Database {

    public static function connect() {
        $dsn = 'mysql:dbname=Modal_projet;host=127.0.0.1';
        $user = 'root';
        $password = '';
        $dbh = null;
        try {
            $dbh = new PDO($dsn, $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
            exit(0);
        }
        return $dbh;
    }

}

class Diploma {

    public $id;
    public $diplome;
    public $promotion;
    public $departement;

    public function __toString() {
        return "$this->id $this->diplome ($this->departement $this->promotion)";
    }

    public static function getDiplomas($dbh, $id) {
        $query = "SELECT * FROM `diplomas` WHERE id=?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Diploma');
        $sth->execute(array($id));
        if ($sth->rowCount() == 0) {
            $dbh = null;
            return null;
        } else {
            $diplomes = $sth->fetchAll();
            $dbh = null;
            return $diplomes;
        }
    }

    public static function insertDiplomas($dbh, $id, $diplome, $promotion, $departement) {
        $sth = $dbh->prepare("INSERT INTO `diplomas`(`id`,`diplome`,`promotion`,`departement`) VALUES(?,?,?,?)");
        $sth->execute(array($id, $diplome, $promotion, $departement));
        $dbh = null;
    }

}

class Photo {

    public $id;
    public $photoPath;

    public function __toString() {
        return "$this->photoPath";
    }

    public static function getPhoto($dbh, $id) {
        $query = "SELECT `photo` FROM `photos` WHERE id=?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array($id));
        if ($sth->rowCount() == 0) {
            $dbh = null;
            return null;
        } else {
            $photo = $sth->fetch();
            return $photo["photo"];
        }
    }

    public static function setPhoto($dbh, $id, $photoPath) {
        if (Photo::getPhoto($dbh, $id) == null) {
            $query = "INSERT INTO `photos`(`photo`, `id`) VALUES(?,?)";
        } else {
            $query = "UPDATE `photos` SET `photo`=? WHERE `id`=?";
        }
        $sth = $dbh->prepare($query);
        $sth->execute(array($photoPath, $id));
    }

}

class User {

    public $id;
    public $nom;
    public $prenom;
    public $email;
    public $mdp;
    public $numero;
    public $sexe;

    public function __toString() {
        //$info = "[" . $this->login . "] ". $this->prenom . " <b>". $this->nom . "</b>". " né(e) le ";
        $gender = '';
        if ($this->sexe == 0) {
            $gender = 'H';
        } elseif ($this->sexe == 1) {
            $gender = 'F';
        }
        $info = "$this->nom $this->prenom ($gender) email : $this->email " . (($this->numero == null) ? "" : "numero : " . $this->numero);
        $info = $info . "<br/>";
        return $info;
    }

    public static function getUserByEmail($dbh, $email) {
        $query = "SELECT * FROM `NJUers` WHERE email=?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'User');
        $sth->execute(array($email));
        if ($sth->rowCount() != 1) {
            return null;
        }
        $user = $sth->fetch();
        $dbh = null;
        return $user;
    }

    public static function getUserByID($dbh, $id) {
        $query = "SELECT * FROM `NJUers` WHERE id=?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'User');
        $sth->execute(array($id));
        if ($sth->rowCount() != 1) {
            return null;
        }
        $user = $sth->fetch();
        $dbh = null;
        return $user;
    }

    public static function getUserByName($dbh, $nom, $prenom) {
        $query = "SELECT * FROM `NJUers` WHERE nom=? AND prenom=?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'User');
        $sth->execute(array($nom, $prenom));
        if ($sth->rowCount() == 0) {
            return null;
        }
        $user = $sth->fetchAll();
        $dbh = null;
        return $user;
    }

    public static function getIDByEmail($dbh, $email) {
        $query = "SELECT `id` FROM `NJUers` WHERE email=?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($email));
        if ($sth->rowCount() != 1) {
            return null;
        }
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $id = $sth->fetch();
        $dbh = null;
        return $id["id"];
    }

    public static function afficherTous($dbh) {
        $query = "SELECT * FROM `NJUers`";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'User');
        $request_succeeded = $sth->execute();
        if ($request_succeeded != false) {
            while ($user = $sth->fetch()) {
                echo "<p>" . $user . "</p>";
            }
        }
    }

    public static function insertUser($dbh, $nom, $prenom, $email, $mdp, $numero, $sexe) {
        if (User::getUserByEmail($dbh, $email) == null) {
            $sth = $dbh->prepare("INSERT INTO `NJUers`(`nom`, `prenom`, `email`, `mdp`, `numero`, `sexe`) VALUES(?,?,?,?,?,?)");
            $sth->execute(array($nom, $prenom, $email, $mdp, $numero, $sexe));
            return TRUE;
        } else {
            return null;
        }
    }

    public static function checkPassword($dbh, $email, $mdp) {
        $user = User::getUserByEmail($dbh, $email);
        if ($user != null) {
            if ($user->mdp == $mdp) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public static function createQuery($nom, $prenom, $promo_start, $promo_end, $studies, $departements) {
        $query = "";
        if ($promo_start == "") {
            $promo_start = 1949;
        }
        if ($promo_end == "") {
            $promo_end = date("Y");
        }

        /* promotions */
        $joined = false;
        if (is_numeric($promo_start) AND is_numeric($promo_end) AND $promo_start <= $promo_end) {
            if ($promo_start > 1949 OR $promo_end < date("Y")) {
                $query = $query . " JOIN `diplomas` ON diplomas.id=NJUers.id AND diplomas.promotion>=$promo_start AND diplomas.promotion<=$promo_end";
                $joined = true;
            }
        }

        /* departements */
        if ($departements != null AND count($departements) < NB_DEPARTEMENTS) {
            if (!$joined) {
                $query = $query . " JOIN `diplomas` ON diplomas.id=NJUers.id AND(";
                $joined = true;
            } else {
                $query = $query . " AND (";
            }
            $query = $query . "diplomas.departement=$departements[0]";
            for ($i = 1; $i < count($departements); $i++) {
                $query = $query . " OR diplomas.departement=$departements[$i]";
            }
            $query = $query . ")";
        }

        /* diplomes */
        if ($studies != null AND count($studies) < 3) {
            if (!$joined) {
                $query = $query . " JOIN `diplomas` ON diplomas.id=NJUers.id AND(";
                $joined = true;
            } else {
                $query = $query . " AND (";
            }
            $query = $query . "diplomas.diplome=$studies[0]";
            for ($i = 1; $i < count($studies); $i++) {
                $query = $query . " OR diplomas.diplome=$studies[$i]";
            }
            $query = $query . ")";
        }

        $query = $query . " WHERE 1=1";
        $query_array = [];
        if ($nom != "") {
            $query = $query . " AND nom=?";
            array_push($query_array, $nom);
        }
        if ($prenom != "") {
            $query = $query . " AND prenom=?";
            array_push($query_array, $prenom);
        }
        return array($query, $query_array);
    }

    public static function searchUser($dbh, $query, $query_array, $limit1, $limit2) {
        $query = "SELECT * FROM `NJUers`" . $query . " LIMIT " . $limit1 . " , " . $limit2;
        $sth = $dbh->prepare($query);
        $sth->execute($query_array);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'User');
        $user = $sth->fetchAll();
        if (count($user) == 0) {
            return null;
        }
        return $user;
    }

    public static function countResults($dbh, $query, $query_array) {
        $query = "SELECT COUNT(id) AS nbResults FROM `NJUers`" . $query;
        $sth = $dbh->prepare($query);
        $sth->execute($query_array);
        return $sth->fetch()["nbResults"];
    }

}

//$dbh = Database::connect();
//$departements = ["Département de Physique", "Département de Chimie", "Département de Mathématiques", "Département d'Informatique", "Département de Biologie", "Ecole d'honneur de Kuangyamin"];
//for ($i = 0; $i < 20; $i++) {
//    $nom = "fu";
//    $prenom = "yunguan";
//    $email = "wang.sun_$i@gmail.com";
//    $mdp = "12345678";
//    $numero = "+33 07 47 47 47 47";
//    $sexe = 0;
//    $licence = $master = $doctorat = 0;
//    while (true) {
//        $licence = rand(0, 1);
//        $master = rand(0, 1);
//        $doctorat = rand(0, 1);
//        if ($licence + $master + $doctorat != 0) {
//            break;
//        }
//    }
//    User::insertUser($dbh, $nom, $prenom, $email, $mdp, $numero, $sexe, $licence, $master, $doctorat);
//    $id = User::getIDByEmail($dbh, $email);
//    var_dump($id);
//    if ($licence == 1) {
//        Diploma::insertDiplomas($dbh, $id, 0, rand(1979, 2017), rand(0, 25));
//    }
//    if ($master == 1) {
//        Diploma::insertDiplomas($dbh, $id, 1, rand(1979, 2017), rand(0, 25));
//    }
//    if ($doctorat == 1) {
//        Diploma::insertDiplomas($dbh, $id, 2, rand(1979, 2017), rand(0, 25));
//    }
//}
//$dbh = null;
