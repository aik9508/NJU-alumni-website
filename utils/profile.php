<?php
session_start();
if (isset($_POST['alumni_id'])) {
    $id = $_POST['alumni_id'];
    require 'register_database.php';
    $dbh = Database::connect();
    $alumnus = User::getUserByID($dbh, $id);
} else {
    $id = 3;
    require 'register_database.php';
    $dbh = Database::connect();
    $alumnus = User::getUserByID($dbh, $id);
}
$photoPath = Photo::getPhoto($dbh, $id);
?>
<div id="profil" class="vertical-center">
    <div class="profil-header">
        <div class="profil-title">
            <span id="profil-name"><?php echo ucfirst($alumnus->prenom) . " " . ucfirst($alumnus->nom); ?></span>
            <?php
            if ($alumnus->numero != null) {
                echo "<span id='profil-tel'><i>Mob</i> : $alumnus->numero</span>";
            }
            ?>
        </div>
        <div class="mask">
            <div id="img-container">
                <img class="thumbnail"<?php
                if ($photoPath == null) {
                    echo "src=sources/default.jpg";
                } else {
                    echo "src=photoDAtaBase/" . $photoPath;
                }
                ?> alt="photo" id="photo"/>
            </div>
            <span id="profil-email"><?php echo "<a href='#' >$alumnus->email</a>"; ?></span>
        </div>
    </div>
    <div class="profil-info">
        <p><span>Diplômes :</span></p>
        <ul>
            <?php
            $diplomas = Diploma::getDiplomas($dbh, $id);
            $licence = $master = $doctorat = 0;
            foreach ($diplomas as $diploma) {
                $text = "$diploma->promotion : ";
                if ($diploma->diplome == 0) {
                    $licence = $diploma;
                    $text = $text . 'licence ';
                } else if ($diploma->diplome == 1) {
                    $master = $diploma;
                    $text = $text . 'master ';
                } else {
                    $doctorat = $diploma;
                    $text = $text . 'doctorat ';
                }
                $text = $text . $_SESSION['DEPARTEMENT_ARRAY'][$diploma->departement];
                echo "<li>$text</li>";
            }
            ?>
        </ul>
        <?php
        $fonction = Info::getInfo($dbh, $id, 1);
        $entreprise = Info::getInfo($dbh, $id, 2);
        if ($fonction || $entreprise) {
            echo "<p><span>Profession : </span></p><ul>";
            if ($entreprise) {
                echo "<li> Entreprise : " . $entreprise . "</li>";
            }
            if ($fonction) {
                echo "<li> Fonction &nbsp;&nbsp;: " . $fonction . "</li>";
            }
            echo "</ul>";
        }
        ?>
        <p><span>Contact : </span></p>
        <ul>
            <li><?php echo $alumnus->email ?></li>
            <?php
            $email_extra = Info::getInfo($dbh, $id, 0);
            if ($email_extra && $email_extra != $alumnus->email) {
                echo "<li>" . $email_extra . "</li>";
            }
            $dbh = null;
            ?>
        </ul>
    </div>
</div>