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

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/profile_test.css">
        <link rel="stylesheet" type="text/css" href="../css/personal.css">
        <link rel="stylesheet" type="text/css" href="../css/cropper.css">
        <link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script>
            window.jQuery || document.write("<script type='text/javascript' src='../js/jquery.js'><\/script>");
        </script>
        <title>Profil : <?php echo "$alumnus->prenom $alumnus->nom" ?></title>
    </head>
    <body>
        <div id="profil">
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
                            echo "src='../sources/default.jpg'";
                        } else {
                            echo "src=../photoDAtaBase/" . $photoPath;
                        }
                        ?> alt="photo" id="photo"/>
                    </div>
                    <span id="profil-email"><?php echo "<a href='#' >$alumnus->email</a>"; ?></span>
                </div>
            </div>
            <div class="flip-container">
                <div class="flipper">
                    <div class="front">
                        <div class="profil-info">
                            <p><span>Diplômes :</span> <button id="editer" class="profil-button">Editer</button></p>
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
                    <div class="back">
                        <div class="profil-photo">
                            <nav class="navbar navbar-inverse">
                                <div class="container-fluid">
                                    <div class="navbar-header">
                                        <a class="navbar-brand">Photo de Votre Profil</a>
                                    </div>
                                    <ul class="nav navbar-nav">
                                        <li><a id="change-photo">Changer</a></li>
                                        <li class="disabled"><a id="upload-photo">Valider</a></li>
                                        <li class="disabled"><a id="cancel-photo">Annuler</a></li>
                                        <li id="close-container"><span class="close-cross">×</span></li>
                                    </ul>
                                </div>
                            </nav>
                            <div class="cropper-wrapper vertical-center-parent">
                                <img id="temp-container" class="display-none" src="" alt="temp">
                                <div class="vertical-center">
                                    <img class="thumbnail" <?php
                                    if ($photoPath == null) {
                                        echo "src='../sources/default.jpg'";
                                    } else {
                                        echo "src=../photoDAtaBase/" . $photoPath;
                                    }
                                    ?> alt="photo" id="original-photo"/>
                                </div>
                            </div>
                            <input type="file" name="photoFile" id="imgFile" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>

            <div class="profil-edit-wrapper display-none">
                <div class="overflow-hidden">
                    <button class="profil-button" id="profil-annuler">Annuler</button>
                    <button class="profil-button" id="profil-valider">Valider</button>
                </div>
                <div class="col-sm-6">
                    <label>Nom : </label>
                    <div class="tooltip">
                        <input class="input-short form-control" type="text" name="nom" placeholder="Nom" <?php echo "value=" . $alumnus->nom ?>>
                        <span class="tooltiptext"></span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <label>Prénom : </label>
                    <div class="tooltip">
                        <input class="input-short form-control" type="text" name="prenom" placeholder="Prénom" <?php echo "value=" . $alumnus->prenom ?>>
                        <span class="tooltiptext"></span>
                    </div>
                </div>
                <div class="col-sm-12">
                    <label>Email : </label>
                    <div class="tooltip">
                        <input class="input-long form-control" type="email" name="email" placeholder="Email" <?php
                        if ($email_extra) {
                            echo "value=" . $email_extra;
                        } else {
                            echo "value=" . $alumnus->email;
                        }
                        ?>>
                        <span class="tooltiptext"></span>
                    </div>
                    <label>Tél : </label>
                    <div class="tooltip">
                        <input class="input-long form-control" type="text" name="num" placeholder="Tél" <?php
                        if ($alumnus->numero) {
                            echo "value='" . $alumnus->numero . "'";
                        }
                        ?>>
                        <span class="tooltiptext"></span>
                    </div>
                </div>
                <?php
                $titre_diplome = ['licence', 'master', 'doctorat'];
                $info_diplome = [$licence, $master, $doctorat];
                for ($i = 0; $i < 3; $i++) {
                    echo <<<EOT
                <div class="col-sm-6">
                    <label> $titre_diplome[$i] : </label>
                    <div class='tooltip'>
                        <input class="input-short form-control" type="text" name="promo-$titre_diplome[$i]" placeholder="2017"
EOT;

                    if ($info_diplome[$i]) {
                        echo "value={$info_diplome[$i]->promotion}";
                    }
                    echo <<<EOT
                        >
                        <span class="tooltiptext"></span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <label>Ecole : </label>
                    <div class="custom-selectbox">
                    <select class="input-short" id="select-$titre_diplome[$i]">
                    "<option></option>"
EOT;
                    for ($j = 0; $j < count($_SESSION["DEPARTEMENT_ARRAY"]); $j++) {
                        if ($info_diplome[$i] && $j == $info_diplome[$i]->departement) {
                            echo"<option selected='selected'>" . $_SESSION["DEPARTEMENT_ARRAY"][$j] . "</option>";
                        } else {
                            echo"<option>" . $_SESSION["DEPARTEMENT_ARRAY"][$j] . "</option>";
                        }
                    }
                    echo "</select></div></div>";
                }
                ?>
                <div class="col-sm-6">
                    <label>Entreprise : </label>
                    <div class="tooltip">
                        <input class="input-short form-control" type="text" name="entreprise" placeholder="Entreprise" <?php
                        if ($entreprise) {
                            echo "value=" . $entreprise;
                        }
                        ?>>
                        <span class="tooltiptext"></span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <label>Fonction : </label>
                    <div class="tooltip">
                        <input class="input-short form-control" type="text" name="fonction" placeholder="Fonction"<?php
                        if ($fonction) {
                            echo "value=" . $fonction;
                        }
                        ?>>
                        <span class="tooltiptext"></span>
                    </div>
                </div>
                <input type="hidden" name="id" <?php echo "value=" . $id ?>>
            </div>

        </div>
        <script src="../js/cropper.js"></script>
        <script>
            $(document).ready(function () {
                var inputs = new Array($("input[name='nom']"),
                        $("input[name='prenom']"),
                        $("input[name='email']"),
                        $("input[name='promo-licence']"),
                        $("input[name='promo-master']"),
                        $("input[name='promo-doctorat']"),
                        $("input[name='num']"),
                        $("input[name='entreprise']"),
                        $("input[name='fonction']"),
                        $("input[name='id']")
                        );
                var initial_vals = new Array(inputs.length);
                for (var i = 0; i < initial_vals.length; i++) {
                    initial_vals[i] = inputs[i].val();
                }
                var dpt_licence_inital = $("#select-licence").find(":selected");
                var dpt_master_inital = $("#select-master").find(":selected");
                var dpt_doctorat_inital = $("#select-doctorat").find(":selected");

                $('#change-photo').click(function () {
                    if (!$(this).parent("li").hasClass('disabled')) {
                        $('#imgFile').click();
                    }
                });

                $('#imgFile').change(function () {
                    if ($(this)[0].files && $(this)[0].files[0]) {
                        $("#original-photo").hide();
                        $("#temp-container").show();
                        $("#change-photo").parent("li").addClass('disabled');
                        $("#upload-photo").parent("li").removeClass('disabled');
                        $("#cancel-photo").parent("li").removeClass('disabled');
                        var file = $(this)[0].files[0];
                        var photo_obj = window.URL.createObjectURL(file);
                        $("#temp-container").attr("src", photo_obj);
                        $('#temp-container').cropper({
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
                    }
                });

                $('#upload-photo').click(function () {
                    var croppedCanvas = $("#temp-container").cropper('getCroppedCanvas');
                    var croppng = croppedCanvas.toDataURL("image/png");
                    $("#original-photo").attr("src", croppng);
                    $("#photo").attr("src", croppng);
                    $("#temp-container").hide();
                    $('#temp-container').cropper('destroy');
                    $("#original-photo").show();
                    $("#change-photo").parent("li").removeClass('disabled');
                    $("#upload-photo").parent("li").addClass('disabled');
                    $("#cancel-photo").parent("li").addClass('disabled');
                    $('#imgFile').val("");
                    $.post("save_photo.php", {
                        pngimageData: croppng
                    }, function (response) {
                        $("#photo_info").html(response);
                    });
                });

                $('#cancel-photo').click(function () {
                    $("#temp-container").hide();
                    $('#temp-container').cropper('destroy');
                    $("#original-photo").show();
                    $("#change-photo").parent("li").removeClass('disabled');
                    $("#upload-photo").parent("li").addClass('disabled');
                    $("#cancel-photo").parent("li").addClass('disabled');
                    $('#imgFile').val("");
                });


                $("#editer").click(function () {
                    $(".flip-container").hide();
                    $(".profil-edit-wrapper").show();
                });
                $("#profil-valider").click(function () {
                    if (isAllValid()) {
                        if (hasChanged()) {
                            var postList = {};
                            for (var i = 0; i < inputs.length; i++) {
                                if (inputs[i].val().trim() !== initial_vals[i]) {
                                    postList[inputs[i].attr("name")] = inputs[i].val().trim();
                                }
                            }
                            if ($("#select-licence").find(":selected")[0] !== dpt_licence_inital[0]) {
                                postList["dpt-licence"] = $("#select-licence").val();
                            }
                            if ($("#select-master").find(":selected")[0] !== dpt_master_inital[0]) {
                                postList["dpt-master"] = $("#select-master").val();
                            }
                            if ($("#select-doctorat").find(":selected")[0] !== dpt_doctorat_inital[0]) {
                                postList["dpt-doctorat"] = $("#select-doctorat").val();
                            }
                            postList["id"] = initial_vals[9];
                            $.when($.post(
                                    "update_post.php",
                                    postList,
                                    function (response) {
                                        console.log(response);
                                    }
                            )).done(function () {
                                location.reload();
                            });
                        }
                        $(".profil-edit-wrapper").hide();
                        $(".flip-container").show();
                    } 
                });
                $("#profil-annuler").click(function () {
                    for (var i = 0; i < inputs.length; i++) {
                        inputs[i].val(initial_vals[i]);
                        inputs[i].css("border-color", 'rgb(204,204,204)');
                    }
                    dpt_licence_inital.prop("selected", true);
                    dpt_master_inital.prop("selected", true);
                    dpt_doctorat_inital.prop("selected", true);
                    $(".profil-edit-wrapper").hide();
                    $(".flip-container").show();
                });

                inputs[0].autocheck(isNonEmpty, toolTipError(inputs[0], 'Le nom ne doit pas être vide.'));
                inputs[1].autocheck(isNonEmpty, toolTipError(inputs[1], 'Le prénom ne doit pas être vide.'));
                inputs[2].autocheck(isEmailValid, toolTipError(inputs[2], 'Adresse e-mail invalide.'));
                inputs[3].autocheck(isPromoValid, toolTipError(inputs[3], 'Promotion invalide'));
                inputs[4].autocheck(isPromoValid, toolTipError(inputs[4], 'Promotion invalide'));
                inputs[5].autocheck(isPromoValid, toolTipError(inputs[5], 'Promotion invalide'));
                inputs[6].autocheck(isTelValid, toolTipError(inputs[6], "Ce format de numéro de téléphone n'est pas reconnu."));
                inputs[7].autocheck(isEntrepriseValid, toolTipError(inputs[7], "Veuillex indiquer votre entreprise."));
                inputs[8].autocheck(isFonctionValid, toolTipError(inputs[8], "Veuillex indiquer votre entreprise."));

                function hasChanged() {
                    for (var i = 0; i < inputs.length; i++) {
                        if (inputs[i].val() !== initial_vals[i]) {
                            return true;
                        }
                    }
                    if ($("#select-licence").find(":selected")[0] !== dpt_licence_inital[0]
                            || $("#select-master").find(":selected")[0] !== dpt_master_inital[0]
                            || $("#select-doctorat").find(":selected")[0] !== dpt_doctorat_inital[0]) {
                        return true;
                    }
                    return false;
                }

                $("#close-container .close-cross").click(function () {
                    if ($("#original-photo").is(':visible')) {
                        $(".flip-container").removeClass('hover');
                    }
                });
                $("#photo").click(function () {
                    if ($('.flip-container').is(':visible')) {
                        $(".flip-container").addClass('hover');
                    }
                });
            });

            function isAllValid() {
                var allValid = isNonEmpty($("input[name='nom']").val())
                        && isNonEmpty($("input[name='prenom']").val())
                        && isEmailValid($("input[name='email']").val())
                        && isPromoValid($("input[name='promo-licence']").val())
                        && isPromoValid($("input[name='promo-master']").val())
                        && isPromoValid($("input[name='promo-doctorat']").val())
                        && isTelValid($("input[name='num']").val())
                        && isEntrepriseValid($("input[name='entreprise']").val())
                        && isFonctionValid($("input[name='fonction']").val());
                if (allValid) {
                    allValid = allValid &&
                            $("input[name='promo-licence']").val()
                            + $("input[name='promo-master']").val()
                            + $("input[name='promo-doctorat']").val().trim() != "";
                    if (!allValid) {
                        alert("Veuillez choisir au moins un diplôme que vous avez obtenu à l'université de Nanjing et remplir votre promotion ainsi que votre département.");
                    }
                }
                return allValid;
            }


            if (!String.prototype.splice) {
                String.prototype.splice = function (start, delCount, newSubStr) {
                    return this.slice(0, start) + newSubStr + this.slice(start + Math.abs(delCount));
                };
            }

            if (!$.prototype.autocheck) {
                $.prototype.autocheck = function (validFunction, errorFunction) {
                    $(this).focusin(function () {
                        $(this).css('border-color', 'rgb(102,175,233)');
                    });
                    $(this).focusout(function () {
                        var result = validFunction($(this).val());
                        if (result) {
                            $(this).css('border-color', 'rgb(204,204,204)');
                            if (result !== true) {
                                $(this).val(result);
                            }
                        } else {
                            $(this).css('border-color', 'red');
                            if (errorFunction) {
                                errorFunction();
                            }
                        }
                    });
                };
            }

            function toolTipError(element, text) {
                return function () {
                    var errorTip = $(element.parent().find(".tooltiptext")[0]);
                    errorTip.html(text);
                    errorTip.addClass('open');
                    setTimeout(function () {
                        $.when(errorTip.fadeOut(1000)).done(function () {
                            errorTip.removeClass('open');
                            errorTip.show();
                        });
                    }, 3000);
                };
            }

            function isNonEmpty(val) {
                if (val.trim() != "") {
                    return val.trim();
                } else {
                    return false;
                }
            }

            function isPromoValid(promo) {
                if (!promo) {
                    return true;
                }
                var thisYear = new Date().getFullYear();
                if ($.isNumeric(promo)) {
                    if (!(promo <= thisYear && promo >= 1949)) {
                        if (promo >= 0 && promo < 100) {
                            if (promo <= thisYear % 1000) {
                                return (+promo) + 2000;
                            } else if (promo >= 49) {
                                return (+promo) + 1900;
                            } else {
                                return false;
                            }
                        } else {
                            return false;
                        }
                    } else {
                        return promo;
                    }
                }
            }

            function isEmailValid(email) {
                if (!email)
                    return true;
                var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if (re.test(email.trim())) {
                    return email;
                } else {
                    return false;
                }
            }

            function isEntrepriseValid(entreprise) {
                if (entreprise.trim() == "") {
                    if ($("input[name='fonction']").val().trim() == "") {
                        $("input[name='fonction']").css('border-color', 'rgb(204,204,204)');
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    $("input[name='fonction']").css('border-color', 'rgb(204,204,204)');
                    return entreprise.trim();
                }
            }

            function isFonctionValid(fonction) {
                if (fonction.trim() == "") {
                    $("input[name='entreprise']").css('border-color', 'rgb(204,204,204)');
                    return true;
                } else if ($("input[name='entreprise']").val().trim() == "") {
                    return false;
                } else {
                    $("input[name='entreprise']").css('border-color', 'rgb(204,204,204)');
                    return fonction.trim();
                }
            }

            function isTelValid(tel) {
                if (!tel)
                    return true;
                var re = /^(\+33 |0|\+33)[1-9]( \d\d|\d\d){4}$/;
                if (re.test(tel.trim())) {
                    return telFormat(tel);
                } else {
                    return false;
                }
            }

            function telFormat(tel) {
                tel = tel.replace(/ /g, "");
                if (tel.charAt(0) !== '+') {
                    tel = "+33" + tel.substring(1);
                }
                tel = tel.splice(3, 0, " ");
                tel = tel.splice(5, 0, " ");
                tel = tel.splice(8, 0, " ");
                tel = tel.splice(11, 0, " ");
                tel = tel.splice(14, 0, " ");
                return tel;
            }

            $('.custom-selectbox select').on('click', function (e) {

                const self = this;
                $('.custom-selectbox').each(function () {
                    if (this !== self && $(this).hasClass('open')) {
                        $(this).removeClass('open');
                    }
                });
                $(this).parent().toggleClass("open");
                return false;
            });
            /* This click event on document to detect outside click */
//            $("body").on('click', function () {
//                var $selectBoxContainer = $('.custom-selectbox');
//                if ($selectBoxContainer.hasClass('open')) {
//                    $selectBoxContainer.removeClass('open');
//                } else {
//                    return false;
//                }
//            });
        </script>
    </body>
</html>