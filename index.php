<?php
session_start();
if (isset($_POST["signout"])) {
    session_unset("currentUser");
}
if (isset($_POST["email"]) and isset($_POST["psw"])) {
    require "utils/register_database.php";
    $dbh = Database::connect();
    if (User::checkPassword($dbh, $_POST["email"], $_POST["psw"])) {
        $user = User::getUserByEmail($dbh, $_POST["email"]);
        $_SESSION["currentUser"] = array(
        "id" => $user->id,
        "nom" => $user->nom,
        "prenom" => $user->prenom,
        );
    }
    $dbh = null;
}

if (!isset($_GET["lang"]) || $_GET["lang"] != "fr") {
    $_SESSION["lang"] = "zh";
} else {
    $_SESSION["lang"] = "fr";
}

if (!isset($_SESSION["DEPARTMENT_ARRAY"])) {
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
?>
  <!doctype html>

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AAENF</title>
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/profile.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
    <link rel="stylesheet" href="css/personal.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
    <link href="css/community.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" rel="stylesheet">
    <link href="css/unite-gallery.css" rel="stylesheet">
    <link href="css/ug-theme-default.css" rel="stylesheet">
    <link href="css/cropper.css" rel="stylesheet">

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/cropper.js"></script>

  </head>

  <body>
    <header>
      <div class="container">
        <div class="row">
          <div id="logo" class="col-lg-6 col-md-6 col-sm-8 col-xs-8">
            <a href="index.php"><img src="images/nju-logo.png" alt="logo" /></a>
            <span id='association'>法国校友会</span>
          </div>
            
          <div class="header-right col-lg-2 col-md-2 col-sm-4 col-xs-4">
            <div id="button-inscription" class="popup-trigger">
              <div class="glyphicon glyphicon-user"></div>
              <div id="popup-login" class="popup-content">
                <?php if (isset($_SESSION["currentUser"])) { ?>
                  <form method="post">
                    <input id='button-signout' name="signout" value="<?php echo (!isset($_GET["lang"]) || $_GET["lang"] == "zh") ? "退出登录" : "Se déconnecter";?>" type='submit' />
                  </form>
                  <?php } else { ?>
                    <div id='button-signin' class='button'>
                      <?php echo (!isset($_GET["lang"]) || $_GET["lang"] == "zh") ? "登录" : "Se connecter";?>
                    </div>
                    <br/>
                    <div id='button-signup' class='button'>
                      <?php echo (!isset($_GET["lang"]) || $_GET["lang"] == "zh") ? "注册" : "S'inscrire";?>
                    </div>
                    <?php
}
?>
              </div>
            </div>
            <div id="userName" <?php if (isset($_SESSION[ "currentUser"])) { echo "userid=" . $_SESSION[ "currentUser"][ "id"]; } ?> >
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
                <?php
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
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
?>

                  <div id="button-zh" class="button"><a <?php echo "href='$link_zh'" ?>>中文</a></div>


                  <div id="button-fr" class="button"><a <?php echo "href='$link_fr'" ?>>Français</a></div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
    <div id="menu" class="collapse navbar-collapse">
      <div class="container">
        <?php
$menu_items = (!isset($_GET["lang"]) || $_GET["lang"] == "zh") ? array("主页", "关于我们", "活动新闻", "校友名录", "联系我们") : array("ACCUEIL", "NOTRE PROFIL", "ACTIVITÉS", "COMMUNAUTÉ", "CONTACTEZ-NOUS");
$lang = (isset($_GET["lang"]))?("&lang=".$_GET["lang"]):"";
?>
          <ul id="menu-list">
            <li id="button-accueil" class="menu-item">
              <a href="index.php?page=home<?php echo $lang; ?>">
                <?php echo $menu_items[0]?>
              </a>
            </li>
            <li id="button-profile" class="menu-item">
              <a href="index.php?page=profile<?php echo $lang; ?>">
                <?php echo $menu_items[1]?>
              </a>
            </li>
            <li id="button-activity" class="menu-item">
              <a href="index.php?page=activity<?php echo $lang; ?>">
                <?php echo $menu_items[2]?>
              </a>
            </li>
            <li id="button-community" class="menu-item">
              <a href="index.php?page=community<?php echo $lang; ?>">
                <?php echo $menu_items[3]?>
              </a>
            </li>
            <li id="button-contact" class="menu-item">
              <a href="#contact">
                <?php echo $menu_items[4]?>
              </a>
            </li>
          </ul>
      </div>
    </div>
    <?php
echo <<<EOT
<div id="loginform-container" class="modal">
<form id="loginform" method="post" action="javascript:void(0);">
<div class="imgcontainer">
<span id='close-login' class="close" title="Close Modal">&times;</span>
<img src="sources/default.jpg" alt="Avatar" class="avatar">
</div>

<label><b>Email</b></label>
<input type="text" placeholder="Enter Email" name="email" required>

<label><b>Password</b></label>
<input type="password" placeholder="Enter Password" name="psw" required>
<button type="submit" id="login-submit" >Login</button>
<div id="error-info"> </div>
</form>
</div>
EOT
?>
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
    require 'snippets/community-snippet-'.$_SESSION["lang"].'.php';
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
                <!--<img src="sources/icon.png">-->
              </div>
              <!--end friendly links-->

              <!--start foot logo-->
              <div class="foot-logo col-sm-4 col-md-2 vertical-center">
                <img src="images/foot_logo.png" alt='LOGO'>
              </div>
              <!--end foot logo-->

              <!--start follow links-->
              <div id='contact' class="follow-links col-sm-4 col-md-5 vertical-center">
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
                <!-- <img src="sources/shares.png"> -->
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
      <script src="js/script.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
      <script src="js/index_sup.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
      <script src="js/unitegallery.min.js"></script>
      <script src="js/ug-theme-default.js"></script>
  </body>

  </html>