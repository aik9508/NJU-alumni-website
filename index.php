<?php
session_start();
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (isset($_POST["signout"])) {
    unset($_SESSION["currentUser"]);
    header("Location: ".$actual_link);
}

if (!isset($_SESSION["alumni_number"])) {
    require "utils/register_database.php";
    $dbh = Database::connect();
    $_SESSION["alumni_number"] = User::countResults($dbh, "WHERE 1", null);
}

if (!isset($_GET["lang"]) || $_GET["lang"] != "fr") {
    $lang = "zh";
} else {
    $lang = "fr";
}

if (!isset($_SESSION["lang"]) || $lang != $_SESSION["lang"]) {
    $_SESSION["lang"] = $lang;
    if ($_SESSION["lang"] == "zh") {
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
    } else {
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
    }
}

$langIszh = (!isset($_GET["lang"]) || $_GET["lang"] == "zh");

$menu_items = $langIszh ? array("主页", "关于我们", "活动新闻", "校友名录") : array("ACCUEIL", "NOTRE PROFIL", "ACTIVITÉS", "COMMUNAUTÉ");
$lang = (isset($_GET["lang"])) ? ("&lang=" . $_GET["lang"]) : "";

$profile_items = array("NJU", "Asso", "Chairmen", "Council", "Cert");
$profile_names = $langIszh ? array("南大简介", "校友会简介", "主席团成员", "理事会成员", "注册文件") : array("À propos de NJU", "À propos de l'AAENF", "Direction", "Conceil", "Déclaration");

$activity_items = array("event", "photo");
$activity_names = $langIszh ? array("活动交流", "相册影集") : array("Activités", "Photos & Vidéos");

if (strpos($actual_link, 'lang=fr')) {
    $link_fr = $actual_link;
    $link_zh = str_replace("lang=fr", "lang=zh", $actual_link);
} else if (strpos($actual_link, 'lang=zh')) {
    $link_zh = $actual_link;
    $link_fr = str_replace("lang=zh", "lang=fr", $actual_link);
} else if (strpos($actual_link, "?")) {
    $link_zh = $actual_link . "&lang=zh";
    $link_fr = $actual_link . "&lang=fr";
} else {
    $link_zh = $actual_link . "?lang=zh";
    $link_fr = $actual_link . "?lang=fr";
}

if (isset($_POST["login_email"]) and isset($_POST["psw"])) {
    if (!class_exists("Database")) {
        require "utils/register_database.php";
    }
    if(!isset($dbh) || $dbh==null){
        $dbh = Database::connect();
    }
    if (User::checkPassword($dbh, $_POST["login_email"], $_POST["psw"])) {
        $user = User::getUserByEmail($dbh, $_POST["login_email"]);
        $_SESSION["currentUser"] = array(
            "id" => $user->id,
            "nom" => $user->nom,
            "prenom" => $user->prenom,
        );
        $dbh = null;
        header("Location: ".$actual_link);
    }
    $dbh=null;
    
}

$visited = "utils/counterFolder/visited.txt";
if (!isset($_SESSION["val_visited"])) {
    $_SESSION["val_visited"] = 0;
    if (!file_exists($visited)) {
        $file_visited = fopen($visited, "w");
        fwrite($file_visited, 1);
        $_SESSION["val_visited"] = 1;
        fclose($file_visited);
    } else {
        $file_visited = fopen($visited, "r");
        $_SESSION["val_visited"] = fread($file_visited, filesize($visited));
        fclose($file_visited);
    }
}

if (!isset($_SESSION["lastVisited"])) {
    $_SESSION["lastVisited"] = time();
}

if (!isset($_SESSION['hasVisited']) || time() - $_SESSION["lastVisited"] > 1000) {
    $_SESSION['hasVisited'] = true;
    $_SESSION["lastVisited"] = time();
    $file_visited = fopen($visited, "r");
    $_SESSION["val_visited"] = fread($file_visited, filesize($visited));
    fclose($file_visited);
    $_SESSION["val_visited"] = $_SESSION["val_visited"] + 1;
    $file_visited = fopen($visited, "w");
    fwrite($file_visited, $_SESSION["val_visited"]);
    fclose($file_visited);
}
?>
<!doctype html>
<html>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>AAENF</title>
        <link rel="stylesheet" href="css/master.css">
        <link rel="stylesheet" href="css/profile.css?<?php echo time();?>">
        <link rel="stylesheet" href="css/personal.css?<?php echo time();?>">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
        <link href="css/community.css" rel="stylesheet">
        <link href="css/unite-gallery.css" rel="stylesheet">
        <link href="css/ug-theme-default.css" rel="stylesheet">
        <link href="css/cropper.css" rel="stylesheet">
        <link href="css/reponsive.css?" rel="stylesheet">

        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/cropper.js"></script>

    </head>

    <body>
        <div id="wrap-menu">
            <p class="wrap-item wrap-item-first"><?php echo $langIszh ? '导航' : 'PILOTAGE'; ?></p>
            <a href="index.php?page=home<?php echo $lang; ?>"><p id="wrap-button-accueil"  class="wrap-item wrap-item-second">        
<?php echo $menu_items[0] ?>     
                </p> </a>

            <a href="index.php?page=profile<?php echo $lang; ?>"><p id="wrap-button-profile"  class="wrap-item wrap-item-second">        
<?php echo $menu_items[1] ?>        
                </p></a>
            <a href="index.php?page=profile&subpage=0<?php echo $lang; ?>"><p class="wrap-item wrap-item-third wrap-profile-button"><?php echo $profile_names[0]; ?></p></a>
            <a href="index.php?page=profile&subpage=1<?php echo $lang; ?>"><p class="wrap-item wrap-item-third wrap-profile-button"><?php echo $profile_names[1]; ?></p></a>
            <a href="index.php?page=profile&subpage=2<?php echo $lang; ?>"><p class="wrap-item wrap-item-third wrap-profile-button"><?php echo $profile_names[2]; ?></p></a>
            <a href="index.php?page=profile&subpage=3<?php echo $lang; ?>"><p class="wrap-item wrap-item-third wrap-profile-button"><?php echo $profile_names[3]; ?></p></a>
            <a href="index.php?page=profile&subpage=4<?php echo $lang; ?>"><p class="wrap-item wrap-item-third wrap-profile-button"><?php echo $profile_names[4]; ?></p></a>

            <a href="index.php?page=activity<?php echo $lang; ?>"><p id="wrap-button-activity"  class="wrap-item wrap-item-second">
<?php echo $menu_items[2] ?>  
                </p></a>
            <a href="index.php?page=activity&subpage=0<?php echo $lang; ?>"><p class="wrap-item wrap-item-third wrap-activity-button"><?php echo $activity_names[0]; ?></p></a>
            <a href="index.php?page=activity&subpage=1<?php echo $lang; ?>"><p class="wrap-item wrap-item-third wrap-activity-button"><?php echo $activity_names[1]; ?></p></a>

            <a href="index.php?page=community<?php echo $lang; ?>"><p id="wrap-button-community"  class="wrap-item wrap-item-second">
<?php echo $menu_items[3] ?>     
                </p></a>

            <p class="wrap-item wrap-item-first"><?php echo $langIszh ? '账户' : 'COMPTE'; ?></p>
<?php if (!isset($_SESSION["currentUser"])) { ?>
                <p class="wrap-item wrap-item-second" id="wrap-signin"><?php echo $langIszh ? '登录' : 'Se connecter'; ?></p>
                <p class="wrap-item wrap-item-second" id="wrap-signup"><?php echo $langIszh ? '注册' : "S'inscrire"; ?></p>
            <?php } else { ?>
                <p class="wrap-item wrap-item-second" id="wrap-signout"><?php echo $langIszh ? '退出登录' : 'Se déconnecter'; ?></p>
<?php } ?>

            <p class="wrap-item wrap-item-first"><?php echo $langIszh ? '语言' : 'LANGUE'; ?></p>
            <a href='<?php echo $langIszh ? $link_fr : $link_zh; ?>'><p class="wrap-item wrap-item-second"><?php echo $langIszh ? 'Français' : '中文'; ?></p></a>
        </div>

        <div id="overal-container">
            <!-- This is the whole page content, seperated form the side-menu -->
            <header>
                <div class="container">
                    <div class="row">
                        <div id="wrap-button" class="glyphicon glyphicon-th-list col-xs-1"></div>
                        <div id="logo" class="col-lg-4 col-md-4 col-sm-6 col-xs-9">
                            <a <?php echo "href='index.php?page=home".$lang."'"?>><img src="images/nju-logo.png" alt="logo" /></a>
                        </div>

                        <div class="header-right col-lg-2 col-md-2 col-sm-4">
                            <div id="button-inscription" class="popup-trigger">
                                <div class="glyphicon glyphicon-user"></div>
                                <div id="popup-login" class="popup-content">
<?php if (isset($_SESSION["currentUser"])) { ?>
                                        <form method="post">
                                            <input id='button-signout' name="signout" value="<?php
                                                   echo $langIszh ? " 退出登录 " : "Se déconnecter ";
                                                   ?>" type='submit' />
                                        </form>
                                        <?php } else { ?>
                                        <div id='button-signin' class='button'>
    <?php echo $langIszh ? "登录" : "Se connecter"; ?>
                                        </div>
                                        <br/>
                                        <div id='button-signup' class='button'>
                                        <?php echo $langIszh ? "注册" : "S'inscrire"; ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div id="userName">
                                <span><?php
                                    if (isset($_SESSION["currentUser"])) {
                                        echo ucfirst($_SESSION["currentUser"]["prenom"]) . " " . ucfirst($_SESSION["currentUser"]["nom"]);
                                    }
                                    ?>
                                </span>
                            </div>
                            <div id="button-lang" class="popup-trigger">
                                <div class="glyphicon glyphicon-globe"></div>
                                <div id="popup-lang" class="popup-content">
                                    <a <?php echo "href='$link_zh'" ?>><div id="button-zh" class="button">中文</div></a>
                                    <a <?php echo "href='$link_fr'" ?>><div id="button-fr" class="button">Français</div></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div id="menu" class="collapse navbar-collapse">
                <div class="container">

                    <ul id="menu-list">
                        <li id="button-accueil" class="menu-item">
                            <a href="index.php?page=home<?php echo $lang; ?>">
<?php echo $menu_items[0] ?>
                            </a>
                        </li>
                        <li id="button-profile" class="menu-item">
                            <a href="index.php?page=profile<?php echo $lang; ?>">
<?php echo $menu_items[1] ?>
                            </a>
                        </li>
                        <li id="button-activity" class="menu-item">
                            <a href="index.php?page=activity<?php echo $lang; ?>">
<?php echo $menu_items[2] ?>
                            </a>
                        </li>
                        <li id="button-community" class="menu-item">
                            <a href="index.php?page=community<?php echo $lang; ?>">
<?php echo $menu_items[3] ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>


            <div id="loginform-container" class="modal">
                <form id="loginform" method="post" action="javascript:void(0);">
                    <div class="imgcontainer">
                        <span id='close-login' class="close" title="Close Modal">&times;</span>
                        <img src="images/default.jpg" alt="Avatar" class="avatar">
                    </div>

                    <label><b><?php echo $langIszh ? "邮箱：" : "Email : "; ?></b></label>
                    <input type="text" placeholder=<?php echo (!isset($_GET["lang"]) || $_GET["lang"] == "zh" ) ? "您的邮箱" : "Email"; ?> name="login_email" required>
                    <label><b><?php echo $langIszh ? "密码：" : "Mot de pass : "; ?></b></label>
                    <input type="password" placeholder=<?php echo $langIszh ? "您的密码" : "Password"; ?> name="psw" required>
                    <button type="submit" id="login-submit">
<?php echo $langIszh ? "登录" : "Connectez-vous"; ?>
                    </button>
                    <div id="error-info"> </div>
                </form>
            </div>

            <!-- Here insert main contents of each page -->
            <div id="main-content">
                <?php
                if (!(isset($_GET['page'])) || $_GET['page'] == 'home')
                    require 'snippets/home-snippet.php';
                else if ($_GET['page'] == 'profile')
                    require 'snippets/profile-snippet.php';
                else if ($_GET['page'] == 'activity')
                    require 'snippets/activity-snippet.php';
                else if ($_GET['page'] == 'community')
                    require 'snippets/community-snippet.php';
                else
                    echo "<h1>No Such Page</h1>";
                ?>


            </div>
            <!--Here ends the main contents-->

            <div id="gotop"><img src="images/gotop.png" alt='TOP'></div>
            <footer>
                <div class="footer-top">
                    <div class="container">
                        <div class="row">
                            <!--start friendly links-->
                            <div class="friendly-links col-sm-4 col-md-5 vertical-center">
                                <a class="icon-href" href="http://www.nju.edu.cn/" target="_blank">
                                    <span class="icon icon1"></span>
                                    <p>NJU</p>
                                </a>
                                <a class="icon-href" href="http://bbs.nju.edu.cn/" target="_blank">
                                    <span class="icon icon2"></span>
                                    <p>BBS</p>
                                </a>
                                <a class="icon-href" href="http://www.nju.org.cn/" target="_blank">
                                    <span class="icon icon3"></span>
                                    <p>AN</p>
                                </a>
                                <a class="icon-href" href="http://njuedf.nju.edu.cn" target="_blank">
                                    <span class="icon icon4"></span>
                                    <p>FN</p>
                                </a>
                            </div>
                            <!--end friendly links-->

                            <!--start foot logo-->
                            <div class="foot-logo col-xs-6 col-sm-6 col-md-2 vertical-center">
                                <img src="images/foot_logo.png" alt='LOGO'>
                            </div>
                            <!--end foot logo-->

                            <!--start follow links-->
                            <div id='contact' class="follow-links col-xs-6 col-sm-6 col-md-5 vertical-center">
                                <a class="icon-href" href="#">
                                    <span class="icon icon1"></span>
                                </a>
                                <a class="icon-href" href="#">
                                    <span class="icon icon2"></span>
                                </a>
                                <a class="icon-href" href="#">
                                    <span class="icon icon3"></span>
                                </a>
                                <a class="icon-href" href="#">
                                    <span class="icon icon4"></span>
                                </a>
                            </div>
                            <!--end follow links-->
                        </div>
                        <!--end footer-top row-->
                    </div>
                    <!--end footer-top container-->
                </div>
                <!--end footer-top-->

                <!--start footer-botton-->
                <div class="footer-bottom">
                    <span>Copyright@Ke WANG & Shiwen XIA</span>
                </div>
                <!--end footer-bottom-->
            </footer>
            <script src="js/script.js?<?php echo time();?>"></script>
            <script src="js/unitegallery.min.js"></script>
            <script src="js/ug-theme-default.js"></script>
        </div>
    </body>
</html>