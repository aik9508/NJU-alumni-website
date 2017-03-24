<?php
session_start();
if (isset($_SESSION['currentUser'])) {
    $id = $_SESSION['currentUser']['id'];
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

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/profile.css">
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="http://malsup.github.com/jquery.form.js"></script> 
        <script>
            window.jQuery || document.write("<script type='text/javascript' src='../js/jquery.js'><\/script>");
        </script>
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
                        $diplomas = Diploma::getDiplomas($dbh, $id);
                        foreach ($diplomas as $diploma) {
                            $text = "$diploma->promotion : ";
                            if ($diploma->diplome == 0) {
                                $text = $text . 'licence ';
                            } else if ($diploma->diplome == 1) {
                                $text = $text . 'master ';
                            } else {
                                $text = $text . 'doctorat ';
                            }
                            $text = $text . "($diploma->departement)";
                            echo "<li>$text</li>";
                        }
                        $dbh = null;
                        ?>
                    </ul>
                </div>
                <hr/>
                <div class="edit" contenteditable="true">

                </div>
            </div>
            <div class="profil-photo text-center">
                <div>
                    <img <?php
                    if ($photoPath == null) {
                        if ($alumnus->sexe == 0) {
                            echo "src='../sources/homme.jpg'";
                        } else if ($alumnus->sexe == 1) {
                            echo "src='../sources/femme.jpg'";
                        } else {
                            echo "src='../sources/autre.jpg'";
                        }
                    }else{
                        echo "src='$photoPath'";
                    }
                    ?> alt="photo" id="photo"/>
                </div>
                <form id="upload_form" action="save_photo.php" method="post" enctype="multipart/form-data">
                    <input type="button" id="upload_photo" value="Choisir ma photo" class="btn btn-primary">
                    <input type="file" name="photoFile" id="imgFile" accept="image/*" style="display: none">
                </form>
                <div id="photo_info"></div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('#upload_photo').click(function () {
                    $('#imgFile').click();
                });
                $('#imgFile').change(function () {
                    if ($(this)[0].files && $(this)[0].files[0]) {
                        var file = $(this)[0].files[0];
                        $("#photo").attr("src", window.URL.createObjectURL(file));
                        $("#upload_form").ajaxForm(
                                {target: '#photo_info'}
                        ).submit();
                    }
                });
            });
        </script>
    </body>
</html>