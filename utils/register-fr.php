<?php
session_start();
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
    "Département des Sciences Politiques",
    "Département d'Electronique",
    "Faculté de Droit",
    "Département de Management et d'ingénierie",
    "Département d'Astronomie et des Sciences Spatiales"
);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="../css/master.css">
        <link rel="stylesheet" href="../css/register.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
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
            <a id="logo" href="../index.php?page=home&lang=<?php echo $_SESSION['lang']; ?>"><img src="../images/nju-logo.png" class="img-responsive" alt="NJU"></a>
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
                        <div class="custom-selectbox">
                            <select class=" custom-select" id="sexe">
                                <option>Femme</option>
                                <option>Homme</option>
                                <option>Autre</option>
                                <option>Non précis</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Quel(s) diplôme(s) avez-vous obtenu(s) à l'Université de Nanjing?</label>
                        <ul class="nav nav-tabs">
                            <li class="active" id='li-licence'><a id='licence'>Licence</a></li>
                            <li id='li-master'><a id='master'>Master</a></li>
                            <li id='li-doctorat'><a id='doctorat'>Doctorat</a></li>
                        </ul>
                    </div>
                    <div id='div-licence'>
                        <?php
                        $id = 'licence';
                        require 'register_info-fr.php'
                        ?>
                    </div>
                    <div id='div-master'>
                        <?php
                        $id = 'master';
                        require 'register_info-fr.php'
                        ?>
                    </div>
                    <div id='div-doctorat'>
                        <?php
                        $id = 'doctorat';
                        require 'register_info-fr.php';
                        ?>
                    </div>
                    <div id='error-diplome' class="error-container"></div>
                    <div class="vertical-center-parent">
                        <input type="submit" value="Valider" id='input-valider'>
                    </div>
                </div>
            </div>
        </div>
        <div class="success-container vertical-center-parent" id='success-container'>
            <div class="alert alert-success vertical-center-parent vertical-center success-inner">
                <div class="vertical-center text-center" >
                    <p>Vous êtes la <span id="nb_alumni"></span> ème personne inscrite sur notre site!</p>
                    <a href="../index.php" class="">Retourner à la page d'accueil</a>
                </div>
            </div>
        </div>
        <footer>
            <div class="footer-bottom">
                <span>Copyright@Ke WANG & Shiwen XIA</span>
            </div>
        </footer>
        <script src="../js/register-fr.js"></script>
    </body>
</html>