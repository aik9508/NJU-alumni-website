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
<div class="profil vertical-center">
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
                    $text = $text . $_SESSION['DEPARTEMENT_ARRAY'][$diploma->departement];
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
            <img class="thumbnail" <?php
            if ($photoPath == null) {
                echo "src='sources/default.jpg'";
            } else {
                echo "src=photoDAtaBase/" . $photoPath;
            }
            ?> alt="photo" id="photo"/>
        </div>
        <form id="upload_form" action="save_photo.php" method="post" enctype="multipart/form-data">
            <input type="button" id="upload_photo" value="Choisir ma photo" class="btn btn-primary">
            <input type="file" name="photoFile" id="imgFile" accept="image/*" style="display: none">
        </form>
        <div id="photo_info"></div>
    </div>
    <div id="cropper-wrapper" class="display-none">
        <div id="cropper-area" class="vertical-center-parent"></div>
        <div>
            <span id="cropper-valider">Valider</span>
            <span id="cropper-annuler">Annuler</span>
        </div>
    </div>
</div>
<script src="js/cropper.js"></script>
<script>
    $(document).ready(function () {
        $('#upload_photo').click(function () {
            console.log("OK");
            $('#imgFile').click();
        });
        $('#imgFile').change(function () {
            if ($(this)[0].files && $(this)[0].files[0]) {
                var file = $(this)[0].files[0];
                var photo_obj = window.URL.createObjectURL(file);
                $("#cropper-wrapper").removeClass("display-none");
                $("#cropper-area").html("<img class='responsive vertical-center' alt='photo' id='cropper-container'/>");
                $("#cropper-container").attr("src", photo_obj);
                $('#cropper-container').cropper({
                    viewMode: 1,
                    dragMode: 'move',
                    aspectRatio: 1,
                    autoCropArea: 0.5,
                    restore: false,
                    guides: false,
                    highlight: false,
                    cropBoxMovable: false,
                    cropBoxResizable: false

                });
                //$("#photo").attr("src", window.URL.createObjectURL(file));
//                $("#upload_form").ajaxForm(
//                        {target: '#photo_info'}
//                ).submit();
            }
        });
        $('#cropper-valider').click(function(){
            var croppedCanvas = $("#cropper-container").cropper('getCroppedCanvas');
            var croppng=croppedCanvas.toDataURL("image/png");
            $("#photo").attr("src", croppng);
            $("#cropper-wrapper").addClass("display-none");
            $('#imgFile').val("");
            $.post("utils/save_photo.php",{
                pngimageData: croppng
            },function(response){
                $("#photo_info").html(response);
            });
        });
    });
</script>
