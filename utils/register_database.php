<?php

define("SEL", "eureka");
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
        $query = "SELECT * FROM `diplomas` WHERE id=? ORDER BY diplome ASC";
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
    
    public static function getDiploma($dbh, $id, $diplome) {
        $query = "SELECT * FROM `diplomas` WHERE id=? AND diplome=?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Diploma');
        $sth->execute(array($id, $diplome));
        if ($sth->rowCount() == 0) {
            $dbh = null;
            return null;
        } else {
            $result = $sth->fetch();
            $dbh = null;
            return $result;
        }
    }
    
    public static function insertDiplomas($dbh, $id, $diplome, $promotion, $departement) {
        $sth = $dbh->prepare("INSERT INTO `diplomas`(`id`,`diplome`,`promotion`,`departement`) VALUES(?,?,?,?)");
        $sth->execute(array($id, $diplome, $promotion, $departement));
        $dbh = null;
    }
    
    public static function delete($dbh, $id, $diplome) {
        $sth = $dbh->prepare("DELETE FROM `diplomas` WHERE `id`=? AND `diplome`=? ");
        $sth->execute(array($id, $diplome));
        $dbh = null;
    }
    
    public static function update($dbh, $query, $query_array) {
        $sth = $dbh->prepare($query);
        $sth->execute($query_array);
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
            $dbh = null;
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
        $dbh = null;
    }
    
}

class Info {
    
    public $id;
    public $type;
    public $content;
    
    public function __toString() {
        return "$this->content";
    }
    
    public static function getInfo($dbh, $id, $type) {
        $query = "SELECT `content` FROM `infos` WHERE id=? AND type=?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($id, $type));
        if ($sth->rowCount() == 0) {
            $dbh = null;
            return null;
        } else {
            $content = $sth->fetch();
            $dbh = null;
            return $content["content"];
        }
    }
    
    public static function delete($dbh, $id, $type){
        $sth = $dbh->prepare("DELETE FROM `infos` WHERE `id`=? AND `type`=? ");
        $sth->execute(array($id, $type));
        $dbh = null;
    }
    
    public static function setInfo($dbh, $id, $type, $content) {
        if (Info::getInfo($dbh, $id, $type) == null) {
            $query = "INSERT INTO `infos`(`content`,`type`, `id`) VALUES(?,?,?)";
        } else {
            $query = "UPDATE `infos` SET `content`=? WHERE `type`=? AND `id`=?";
        }
        $sth = $dbh->prepare($query);
        $sth->execute(array($content, $type, $id));
        $dbh = null;
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
        //$info = "[". $this->login ."] ". $this->prenom . " <b>". $this->nom . "</b>". " né(e) le ";
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
            $sth->execute(array($nom, $prenom, $email, sha1($mdp.SEL), $numero, $sexe));
            return TRUE;
        } else {
            return null;
        }
    }
    
    public static function checkPassword($dbh, $email, $mdp) {
        $user = User::getUserByEmail($dbh, $email);
        if ($user != null) {
            if ($user->mdp == sha1($mdp.SEL)) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
    
    public static function checkPasswordByID($dbh, $id, $mdp) {
        $user = User::getUserByID($dbh, $id);
        if ($user != null) {
            if ($user->mdp == sha1($mdp.SEL)) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
    
    public static function changePassword($dbh, $id, $mdp){
        $query="UPDATE `NJUers` SET `mdp`=? WHERE id=?";
        $sth=$dbh->prepare($query);
        $sth->execute(array(sha1($mdp.SEL),$id));
        return $sth->rowCount();
    }
    
    public static function update($dbh, $query, $query_array) {
        $sth = $dbh->prepare($query);
        $sth->execute($query_array);
    }
    
    public static function createQuery($nom, $prenom, $promo_start, $promo_end, $studies, $departements) {
        $query = "";
        if ($promo_start == "") {
            $promo_start = 1949;
        }
        if ($promo_end == "") {
            $promo_end = date("Y");
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
        
        /* promotions */
        $joined = false;
        if (is_numeric($promo_start) AND is_numeric($promo_end) AND $promo_start <= $promo_end) {
            $joined = true;
            if ($promo_start > 1949 OR $promo_end < date("Y")) {
                $query = $query . " AND diplomas.promotion>=$promo_start AND diplomas.promotion<=$promo_end";
                $joined = true;
            }
        }
        
        /* departements */
        if ($departements != null AND count($departements) < 29) {
            $joined = true;
            $query = $query . " AND (diplomas.departement=$departements[0]";
            for ($i = 1; $i < count($departements); $i++) {
                $query = $query . " OR diplomas.departement=$departements[$i]";
            }
            $query = $query . ")";
        }
        
        /* diplomes */
        if ($studies != null AND count($studies) < 3) {
            $joined = true;
            $query = $query . " AND (diplomas.diplome=$studies[0]";
            for ($i = 1; $i < count($studies); $i++) {
                $query = $query . " OR diplomas.diplome=$studies[$i]";
            }
            $query = $query . ")";
        }
        
        if ($joined) {
            $query = "JOIN `diplomas` ON diplomas.id=NJUers.id " . $query;
        }
        
        $query = $query . " ORDER BY `NJUers`.`id` ASC";
        
        return array($query, $query_array);
    }
    
    public static function searchUser($dbh, $query, $query_array, $limit1, $limit2) {
        $query = "SELECT DISTINCT `NJUers`.`id`, `nom`, `prenom` FROM `NJUers`" . $query . " LIMIT " . $limit1 . " , " . $limit2;
        $sth = $dbh->prepare($query);
        $sth->execute($query_array);
        $user = $sth->fetchAll();
        if (count($user) == 0) {
            return null;
        }
        return $user;
    }
    
    public static function countResults($dbh, $query, $query_array) {
        $query = "SELECT COUNT(DISTINCT(`NJUers`.id)) AS nbResults FROM `NJUers` " . $query;
        $sth = $dbh->prepare($query);
        $sth->execute($query_array);
        return $sth->fetch()["nbResults"];
    }
    
}

class ActivityList {
    public $num;
    public $article;
    public $gallery;
    public $title;
    public $author;
    public $date;
    public $caption;
    public $title_fr;
    public $tag_fr;
    public $caption_fr;
    
    public static function getActivityInfo($dbh, $num) {
        $query = "SELECT * FROM `activities` WHERE num=?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'ActivityList');
        $sth->execute(array($num));
        if ($sth->rowCount() == 0) {
            $dbh = null;
            return null;
        } else {
            $activityinfo = $sth->fetch();
            $dbh = null;
            return $activityinfo;
        }
    }
    
    public static function getActivityNumber($dbh) {
        $nRows = $dbh->query('select COUNT(*) from activities')->fetchColumn();
        return $nRows;
    }
    
    public static function getGalleryActivities($dbh) {
        $query = "SELECT * FROM `activities` WHERE gallery=1";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'ActivityList');
        $sth->execute();
        if ($sth->rowCount() == 0) {
            $dbh = null;
            return null;
        } else {
            $galleries = $sth->fetchAll();
            $dbh = null;
            return $galleries;
            
        }
    }
    public static function getArticleActivities($dbh) {
        $query = "SELECT * FROM `activities` WHERE article=1";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'ActivityList');
        $sth->execute();
        if ($sth->rowCount() == 0) {
            $dbh = null;
            return null;
        } else {
            $articles = $sth->fetchAll();
            $dbh = null;
            return $articles;
            
        }
    }
}