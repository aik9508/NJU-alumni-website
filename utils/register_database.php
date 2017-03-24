<?php

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
    
    public static function setPhoto($dbh, $id, $photoPath){
        $query="INSERT INTO `photos`(`id`, `photo`) VALUES(?,?)";
        $sth=$dbh->prepare($query);
        $sth->execute(array($id, $photoPath));
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
    public $licence;
    public $master;
    public $doctorat;

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

    public static function insertUser($dbh, $nom, $prenom, $email, $mdp, $numero, $sexe, $licence, $master, $doctorat) {
        if (User::getUserByEmail($dbh, $email) == null) {
            $sth = $dbh->prepare("INSERT INTO `NJUers`(`nom`, `prenom`, `email`, `mdp`, `numero`, `sexe`, `licence`, `master`, `doctorat`) VALUES(?,?,?,?,?,?,?,?,?)");
            $sth->execute(array($nom, $prenom, $email, $mdp, $numero, $sexe, $licence, $master, $doctorat));
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

}

//$dbh = Database::connect();
//$departements = ["Département de Physique", "Département de Chimie", "Département de Mathématiques", "Département d'Informatique", "Département de Biologie", "Ecole d'honneur de Kuangyamin"];
//for ($i = 0; $i < 20; $i++) {
//    $nom = "fu";
//    $prenom = "yunguan";
//    $email = "yunguan.fu_$i@163.com";
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
//        Diploma::insertDiplomas($dbh, $id, 0, rand(1979, 2016), $departements[rand(0, 5)]);
//    }
//    if ($master == 1) {
//        Diploma::insertDiplomas($dbh, $id, 1, rand(1979, 2016), $departements[rand(0, 5)]);
//    }
//    if ($doctorat == 1) {
//        Diploma::insertDiplomas($dbh, $id, 2, rand(1979, 2016), $departements[rand(0, 5)]);
//    }
//}
//$dbh = null;
