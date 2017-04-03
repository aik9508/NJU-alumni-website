<?php
session_start();
if (!isset($_SESSION["DEPARTMENT_ARRAY"])) {
    $_SESSION["DEPARTEMENT_ARRAY"] = array(
        "Département des Sciences de l'Atmosphère",
        "Département des Sciences Géographique et Océanographiques",
        "Département des Sciences de la Terre",
        "Institut des étudiants étrangers",
        "Département de Chimie",
        "Département Environnment",
        "Département d'Informatique",
        "Département d'Architecture",
        "Insititut d'Education",
        "Ecole d'Honneur de Kuang Yaming",
        "Département d'Histoire",
        "Département d'Ingénierie logiciel",
        "Département des Sciences Commerciales",
        "Département de Sociologie",
        "Département des Sciences de la Vie",
        "Département de Mathématiques",
        "Département des Langues Etrangères",
        "Département de Littérature",
        "Département de Physique",
        "Département d'Ingénierie et des Sciences Appliquées",
        "Département de journalisme",
        "Département des Sciences d'Information",
        "Faculté de Médecine",
        "Département de Philosophie",
        "Département des Sciences Politiques"
    );
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="../css/master.css">
        <link rel="stylesheet" href="../css/register.css">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script>
            window.jQuery || document.write("<script type='text/javascript' src='../js/jquery.js'><\/script>");
        </script>
<!--        <script src="../js/register.js"></script>-->
        <title>Enregistrer</title>
    </head>
    <body>
        <div id="header">
            <a id="logo"><img src="../images/nju-logo.png" class="img-responsive" alt="NJU"></a>
            <!--            <a id="langue"><div class="glyphicon glyphicon-globe"></div></a>
                        <a id="connecter"><div class="glyphicon glyphicon-user"></div></a>-->
        </div>
        <div class="grad">
            <div id="container-backgroud">
                <div class="input-main ">
                    <div  class="form-group container">
                        <label class="control-label col-xs-6 input-left" for="nom">Nom&nbsp;:</label>
                        <label class="control-label col-xs-6 input-right" for="prenom">Prénom&nbsp;:</label>
                        <div class="col-xs-6 input-left">
                            <input type="text" class="form-control" id="nom" placeholder="Nom">
                        </div>
                        <div class="col-xs-6 input-right">
                            <input type="text" class="form-control" id="prenom" placeholder="Prénom">
                        </div>
                        <div class="col-xs-6 input-left error-container" id='error-nom'></div>
                        <div class="col-xs-6 input-right error-container" id='error-prenom'></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="mdp">Créez un mot de passe&nbsp;:</label>
                        <div>
                            <input type="password" class="form-control" id="mdp" placeholder="Mot de passe" data-toggle="tooltip" title="Hooray!">
                        </div>
                        <div id='error-mdp' class="error-container"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="confirmer_mdp">Confirmez votre mot de passe&nbsp;:</label>
                        <div>
                            <input type="password" class="form-control" id="confirmer_mdp" placeholder="Mot de passe">
                        </div>
                        <div id='error-confirmer_mdp' class="error-container"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="email">Votre adress e-mail&nbsp;:</label>
                        <div>
                            <input type="email" class="form-control" id="email" placeholder="Email">
                        </div>
                        <div id='error-email' class="error-container"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="num">Numéro de téléphone mobile&nbsp;:</label>
                        <div>
                            <input type="text" class="form-control" id="num" placeholder="Téléphone">
                        </div>
                        <div id='error-num' class="error-container"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="sexe">Sexe&nbsp;:</label>
                        <select class="form-control" id="sexe">
                            <option>Femme</option>
                            <option>Homme</option>
                            <option>Autre</option>
                            <option>Non précis</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Quel(s) diplôme(s) avez-vous obtenu(s) à l'Université de Nanjing?</label>
                        <ul class="nav nav-tabs">
                            <li class="active" id='li-licence'><a href="#div-licence" id='licence'>Licence</a></li>
                            <li id='li-master'><a href="#div-master" id='master'>Master</a></li>
                            <li id='li-doctorat'><a href="#div-doctorat" id='doctorat'>Doctorat</a></li>
                        </ul>
                    </div>
                    <div id='div-licence'>
                        <?php
                        $id = 'licence';
                        require 'register_info.php'
                        ?>
                    </div>
                    <div id='div-master'>
                        <?php
                        $id = 'master';
                        require 'register_info.php'
                        ?>
                    </div>
                    <div id='div-doctorat'>
                        <?php
                        $id = 'doctorat';
                        require 'register_info.php';
                        ?>
                    </div>
                    <div id='error-diplome' class="error-container"></div>
                    <div class="vertical-center-parent">
                        <input class="btn btn-primary btn-block" type="submit" value="Valider" id='input-valider'>
                    </div>
                </div>
            </div>
        </div>
        <div class="success-container vertical-center-parent" id='success-container'>
            <div class="alert alert-success vertical-center-parent vertical-center success-inner">
                <div class="vertical-center text-center" >
                    <?php
                    require 'register_database.php';
                    $dbh = Database::connect();
                    $nbAlumni = User::countResults($dbh, "WHERE 1", null);
                    $dbh = null;
                    ?>
                    <p>Vous êtes la <?php echo $nbAlumni ?> ème personne inscrite sur notre site!</p>
                    <a href="../index.php" class="">Retourner à la page d'accueil</a>
                </div>
            </div>
        </div>
        <footer>
            <div class="footer-bottom">
                <span>Copyright@Ke WANG & Shiwen XIA</span>
            </div>
        </footer>
        <script>
            $(document).ready(function () {
                $('#div-master').hide();
                $('#div-doctorat').hide();
                function change_tab(id) {
                    return $('#' + id).click(function () {
                        var id_array = ['licence', 'master', 'doctorat'];
                        for (var i = 0; i < id_array.length; i++) {
                            $('#li-' + id_array[i]).removeClass('active');
                            $('#div-' + id_array[i]).hide();
                        }
                        $('#li-' + id).addClass('active');
                        $('#div-' + id).show();
                    });
                }

                var diplomas = ['licence', 'master', 'doctorat'];
                for (var i = 0; i < diplomas.length; i++) {
                    change_tab(diplomas[i]);
                    $('#dept-' + diplomas[i]).focusin(function () {
                        $('#error-diplome').html("");
                    });
                }

                setAutoCheck($("#nom"), $("#error-nom"), [
                    new Pair(isNonEmpty, "Ce champ est obligatoire!")]);
                setAutoCheck($("#prenom"), $("#error-prenom"), [
                    new Pair(isNonEmpty, "Ce champ est obligatoire!")]);
                setAutoCheck($("#email"), $("#error-email"), [
                    new Pair(isNonEmpty, "Ce champ est obligatoire!"),
                    new Pair(isEmailValid, "Adresse e-mail invalide.")
                ]);
                setAutoCheck($("#mdp"), $("#error-mdp"), [
                    new Pair(isNonEmpty, "Ce champ est obligatoire!"),
                    new Pair(isPswValid, "Les mots de passe courts sont faciles à deviner. Veuillez recommencer en utilisant au moins 8 caractères.")
                ]);
                setAutoCheck($("#confirmer_mdp"), $("#error-confirmer_mdp"), [
                    new Pair(isNonEmpty, "Ce champ est obligatoire!"),
                    new Pair(isPswCorrect, "Les mots de passe ne correspondent pas. Voulez-vous réessayer")
                ]);
                setAutoCheck($("#num"), $("#error-num"), [
                    new Pair(isTelValid, "Ce format de numéro de téléphone n'est pas reconnu. Veuillez vérifier le numéro.")]);
                $("#promo-licence").autocheck(focusInFunction($("#error-diplome")), [{
                        validFunction: isPromoValid,
                        errorFunction: promoError("licence")
                    }]);
                $("#promo-master").autocheck(focusInFunction($("#error-diplome")), [{
                        validFunction: isPromoValid,
                        errorFunction: promoError("master")
                    }]);
                $("#promo-doctorat").autocheck(focusInFunction($("#error-diplome")), [{
                        validFunction: isPromoValid,
                        errorFunction: promoError("doctorat")
                    }]);

                $("#input-valider").click(function () {
                    if (isAllValid()) {
                        $.post('register_post.php', {
                            nom: $("#nom").val().trim().toLowerCase(),
                            prenom: $("#prenom").val().trim().toLowerCase(),
                            mdp: $("#mdp").val(),
                            email: $("#email").val().trim().toLowerCase(),
                            num: $("#num").val().trim(),
                            sexe: $("#sexe").val(),
                            promo_licence: $("#promo-licence").val().trim(),
                            dept_licence: $("#dept-licence").val(),
                            promo_master: $("#promo-master").val().trim(),
                            dept_master: $("#dept-licence").val(),
                            promo_doctorat: $("#promo-doctorat").val().trim(),
                            dept_doctorat: $("#dept-licence").val()},
                                function (response) {
                                    $('#error-diplome').html(response);
                                });
                        $("#success-container").fadeIn(500);
                        $("#success-container").css('display', 'flex');
                    }
                });
            });


            function isAllValid() {
                var allValid = isNonEmpty($("#nom").val())
                        && isNonEmpty($("#prenom").val())
                        && isEmailValid($("#email").val())
                        && isPromoValid($("#promo-licence").val())
                        && isPromoValid($("#promo-master").val())
                        && isPromoValid($("#promo-doctorat").val())
                        && isTelValid($("#num").val())
                        && isPswValid($("#mdp").val())
                        && isPswCorrect($("#confirmer_mdp").val());
                if (!($("#dept-licence").val() && $("#promo-licence").val()
                        || $("#dept-master").val() && $("#promo-master").val()
                        || $("#dept-doctorat").val() && $("#promo-doctorat").val())) {
                    allValid = false;
                    $("#error-diplome").html("Veuillez choisir au moins un diplôme que vous avez obtenu à l'université de Nanjing et remplir votre promotion ainsi que votre département.");
                }
                $("input").focusout();
                var diplomas = ['licence', 'master', 'doctorat'];
                for (var i = 0; i < diplomas.length; i++) {
                    var id = diplomas[i];
                    if (!$("#dept-" + id).val() && $("#promo-" + id).val()) {
                        $("#error-diplome").html("Veuillez choisir votre département");
                        $('#' + id).click();
                        return false;
                    } else if ($("#dept-" + id).val() && !$("#promo-" + id).val()) {
                        $("#error-diplome").html("Veuillez indiquer votre promotion");
                        $('#' + id).click();
                        return false;
                    }
                }
                return allValid;
            }

            function Pair(validFunction, msg) {
                this.validFunction = validFunction;
                this.msg = msg;
            }

            function setAutoCheck(element, error_container, funMsgPairs) {
                var handlers = [];
                for (var i = 0; i < funMsgPairs.length; i++) {
                    handlers[i] = {
                        validFunction: funMsgPairs[i].validFunction,
                        errorFunction: errorFunction(error_container, funMsgPairs[i].msg)
                    };
                }
                element.autocheck(focusInFunction(error_container), handlers);
            }

            if (!$.prototype.autocheck) {
                $.prototype.autocheck = function (focusInFunction, handlers) {
                    $(this).focusin(function () {
                        $(this).css('border-color', 'rgb(102,175,233)');
                        focusInFunction();
                    });
                    $(this).focusout(function () {
                        for (var i = 0; i < handlers.length; i++) {
                            var result = handlers[i].validFunction($(this).val());
                            if (result) {
                                $(this).css('border-color', 'rgb(204,204,204)');
                                if (result !== true) {
                                    $(this).val(result);
                                }
                            } else {
                                $(this).css('border-color', 'red');
                                if (handlers[i].errorFunction) {
                                    handlers[i].errorFunction();
                                }
                                break;
                            }
                        }
                    });
                };
            }

            function focusInFunction(element) {
                return function () {
                    element.html("");
                };
            }

            function errorFunction(element, text) {
                return function () {
                    element.html(text);
                };
            }
            function promoError(diplome) {
                return function () {
                    $("#error-diplome").html("Veillez vérifier votre promotion.");
                    setTimeout(function () {
                        $("#" + diplome).click()
                    }, 50);
                };
            }

            function isNonEmpty(val) {
                if (val.trim() != "") {
                    return val.trim();
                } else {
                    return false;
                }
            }

            function isPswValid(psw) {
                if (psw.trim().length < 8 && psw.trim().length > 0) {
                    return false;
                } else {
                    return psw;
                }
            }

            function isPswCorrect(psw) {
                if (psw === $("#mdp").val().trim()) {
                    return psw;
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

            if (!String.prototype.splice) {
                String.prototype.splice = function (start, delCount, newSubStr) {
                    return this.slice(0, start) + newSubStr + this.slice(start + Math.abs(delCount));
                };
            }

            function isTelValid(tel) {
                if (!tel)
                    return true;
                tel = tel.replace(/ /g, "");
                var re = /^(0|\+33)[1-9](\d){8}$/;
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
        </script>
    </body>
</html>