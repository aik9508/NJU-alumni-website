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
        <script src="../js/register.js"></script>
        <title>Enregistrer</title>
    </head>
    <body>
        <div id="header">
            <a id="logo"><img src="../images/logo.png" class="img-responsive" alt="NJU"></a>
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
                        <div class="col-xs-6 input-left" id='error-nom'></div>
                        <div class="col-xs-6 input-right" id='error-prenom'></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="mdp">Créez un mot de passe&nbsp;:</label>
                        <div>
                            <input type="password" class="form-control" id="mdp" placeholder="Mot de passe" data-toggle="tooltip" title="Hooray!">
                        </div>
                        <div id='error-mdp'></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="confirmer_mdp">Confirmez votre mot de passe&nbsp;:</label>
                        <div>
                            <input type="password" class="form-control" id="confirmer_mdp" placeholder="Mot de passe">
                        </div>
                        <div id='error-confirmer_mdp'></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="email">Votre adress e-mail&nbsp;:</label>
                        <div>
                            <input type="email" class="form-control" id="email" placeholder="Email">
                        </div>
                        <div id='error-email'></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="num">Numéro de téléphone mobile&nbsp;:</label>
                        <div>
                            <input type="text" class="form-control" id="num" placeholder="Téléphone">
                        </div>
                        <div id='error-num'></div>
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
                    <div id='error-diplome'></div>
                    <div class="vertical-center-parent">
                        <input class="btn btn-primary btn-block" type="submit" value="Valider" id='input-valider'>
                    </div>
                </div>
            </div>
        </div>
        <div class="success-container vertical-center-parent" id='success-container'>
            <div class="alert alert-success vertical-center-parent vertical-center success-inner">
                <div class="vertical-center text-center" >
                    <p>Vous êtes la 10000 ème personne inscrite sur notre site!</p>
                    <a href="../index.php" class="">Retourner à la page d'accueil</a>
                </div>
            </div>
        </div>
        <footer>
            <div class="footer-bottom">
                <span>Copyright@Ke WANG & Shiwen XIA</span>
            </div>
        </footer>
    </body>
</html>