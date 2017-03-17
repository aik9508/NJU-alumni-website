<?php
session_start();
//if (!isset($_SESSION['loggedin'])) {
//    header('Location: ../index.php');
//    exit();
//} else {
$id = 3;
require 'register_database.php';
$dbh = Database::connect();
$alumnus = User::getUserByID($dbh, $id);
//}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/profile.css">
        <title>Profil : <?php echo "$alumnus->prenom $alumnus->nom" ?></title>
    </head>
    <body>
        <div class="profil">
            <div class='profil-info'>
                <div class="text-center">
                    <p id="name"><b><?php echo"$alumnus->prenom $alumnus->nom" ?></b></p>
                </div>
                <div id="contact">
                    <?php
                    echo "<a href='#' class='float-left'>$alumnus->email</a>";
                    if ($alumnus->numero != null) {
                        echo "<span class='float-right'><i>Mob</i> : $alumnus->numero</span>";
                    }
                    ?>
                </div>
                <hr/>
                <div id="diplomas">
                    <ul>
                        <?php
                            $diplomas=Diploma::getDiplomas($dbh, $id);
                            foreach ($diplomas as $diploma) {
                                $text="$diploma->promotion : ";
                                if($diploma->diplome==0){
                                    $text=$text.'licence ';
                                }else if($diploma->diplome==1){
                                    $text=$text.'master ';
                                }else{
                                    $text=$text.'doctorat ';
                                }
                                $text=$text."($diploma->departement)";
                                echo "<li>$text</li>";
                            }
                        ?>
                    </ul>
                </div>
                <hr/>
                 <div class="edit" contenteditable="true">
                
                </div>
                <script>

                </script>
            </div>
            <div class="profil-photo text-center">
                <img <?php
                    if($alumnus->sexe==0){
                        echo "src='../sources/homme.jpg'";
                    }else if($alumnus->sexe==1){
                        echo "src='../sources/femme.jpg'";
                    }else{
                        echo "src='../sources/autre.jpg'";
                    }
                    ?> alt="photo" id="photo"/>
            </div>
        </div>
    </body>
</html>

