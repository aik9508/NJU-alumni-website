<?php
/*Register page*/
session_start();
if (!isset($_SESSION["lang"])) {
    $_SESSION["lang"] = "zh";
}
if (!isset($_SESSION["DEPARTEMENT_ARRAY"])) {
    $_SESSION["DEPARTEMENT_ARRAY"] = array(
        "大气科学学院",
        "地理与海洋科学学院",
        "地球科学与工程学院",
        "海外教育学院",
        "化学化工学院",
        "环境学院",
        "计算机科学与技术系",
        "建筑与城市规划学院",
        "教育研究院",
        "匡亚明学院",
        "历史学系",
        "软件学院",
        "商学院",
        "社会学院",
        "生命科学学院",
        "数学系",
        "外国语学院",
        "文学院",
        "物理学院",
        "现代工程与应用科学学院",
        "新闻传播学院",
        "信息管理学院",
        "医学院",
        "哲学系",
        "政府管理学院",
        "电子科学与工程学院",
        "法学院",
        "工程管理学院",
        "天文与空间科学学院"
    );
}
if ($_SESSION["lang"] == "fr") {
    $msg = array(
        "last_name" => "Nom ",
        "first_name" => "Prénom ",
        "create_password" => "Créez un mot de passe :",
        "password" => "Mot de passe",
        "confirm_password" => "Confirmez votre mot de passe :",
        "email_adress" => "Votre adress e-mail :",
        "email" => "Email",
        "telephone_number" => "Numéro de téléphone mobile :",
        "telephone" => "Téléphone",
        "gender" => "Sexe :",
        "woman" => "Femme",
        "man" => "Homme",
        "other" => "Autre",
        "secret" => "Non précis",
        "choose_degree" => "Quel(s) diplôme(s) avez-vous obtenu(s) à l'Université de Nanjing?",
        "bachelor" => "Licence",
        "master" => "Master",
        "doctor" => "Doctorat",
        "your_class" => "Votre promotion :",
        "your_school" => "Votre département :",
        "class" => "Promotion",
        "submit" => "Valider"
    );
} else {
    $msg = array(
        "last_name" => "姓",
        "first_name" => "名",
        "create_password" => "创建密码:",
        "password" => "密码",
        "confirm_password" => "确认密码:",
        "email_adress" => "邮箱(用户名):",
        "email" => "邮箱",
        "telephone_number" => "手机号码:",
        "telephone" => "手机",
        "gender" => "性别:",
        "woman" => "女",
        "man" => "男",
        "other" => "其他",
        "secret" => "不便透露",
        "choose_degree" => "您在南京大学的学习经历:",
        "bachelor" => "本科",
        "master" => "硕士",
        "doctor" => "博士",
        "your_class" => "入学年份:",
        "your_school" => "院系:",
        "class" => "入学年份",
        "submit" => "提交"
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
                        <label class="control-label col-xs-6 input-left" for="nom"><?php echo $msg["last_name"]; ?>&nbsp;:</label>
                        <label class="control-label col-xs-6 input-right" for="prenom"><?php echo $msg["first_name"]; ?>&nbsp;:</label>
                        <div class="col-xs-6 input-left">
                            <input type="text" class="form-control" id="nom" <?php echo "placeholder='" . $msg["last_name"] . "'"; ?>>
                        </div>
                        <div class="col-xs-6 input-right">
                            <input type="text" class="form-control" id="prenom" <?php echo "placeholder='" . $msg["first_name"] . "'"; ?>>
                        </div>
                        <div class="col-xs-6 input-left error-container" id='error-nom'></div>
                        <div class="col-xs-6 input-right error-container" id='error-prenom'></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="mdp"><?php echo $msg["create_password"]; ?></label>
                        <div>
                            <input type="password" class="form-control" id="mdp" <?php echo "placeholder='" . $msg["password"] . "'"; ?>>
                        </div>
                        <div id='error-mdp' class="error-container"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="confirmer_mdp"><?php echo $msg["confirm_password"]; ?></label>
                        <div>
                            <input type="password" class="form-control" id="confirmer_mdp" <?php echo "placeholder='" . $msg["password"] . "'"; ?>>
                        </div>
                        <div id='error-confirmer_mdp' class="error-container"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="email"><?php echo $msg["email_adress"]; ?></label>
                        <div>
                            <input type="email" class="form-control" id="email" <?php echo "placeholder='" . $msg["email"] . "'"; ?>>
                        </div>
                        <div id='error-email' class="error-container"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="num"><?php echo $msg["telephone_number"]; ?>&nbsp;:</label>
                        <div>
                            <input type="text" class="form-control" id="num" <?php echo "placeholder='" . $msg["telephone"] . "'"; ?>>
                        </div>
                        <div id='error-num' class="error-container"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="sexe"><?php echo $msg["gender"]; ?></label>
                        <div class="custom-selectbox">
                            <select class=" custom-select" id="sexe">
                                <option><?php echo $msg["woman"]; ?></option>
                                <option><?php echo $msg["man"]; ?></option>
                                <option><?php echo $msg["other"]; ?></option>
                                <option><?php echo $msg["secret"]; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo $msg["choose_degree"]; ?></label>
                        <ul class="nav nav-tabs">
                            <li class="active" id='li-licence'><a id='licence'><?php echo $msg["bachelor"]; ?></a></li>
                            <li id='li-master'><a id='master'><?php echo $msg["master"]; ?></a></li>
                            <li id='li-doctorat'><a id='doctorat'><?php echo $msg["doctor"]; ?></a></li>
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
                        <input type="submit" <?php echo "value='" . $msg["submit"] . "'"; ?> id='input-valider'>
                    </div>
                </div>
            </div>
        </div>
        <div class="success-container vertical-center-parent" id='success-container'>
            <div class="alert alert-success vertical-center-parent vertical-center success-inner">
                <div class="vertical-center text-center" >
                    <?php if ($_SESSION["lang"] == "fr") { ?>
                        <p>Vous êtes la <span id="nb_alumni"></span> ème personne inscrite sur notre site!</p>
                        <a href="../index.php">Retourner à la page d'accueil</a>
                    <?php } else { ?>
                        <p>您是本站第<span id="nb_alumni"></span>位注册的用户!</p>
                        <a href="../index.php">返回首页</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <footer>
            <div class="footer-bottom">
                <span>Copyright@Ke WANG & Shiwen XIA</span>
            </div>
        </footer>
        <script src="../js/register.js"></script>
    </body>
</html>