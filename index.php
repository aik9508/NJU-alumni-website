<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/personal.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/ajax-utils.js"></script>
</head>

<body>
<header>
    <div class="container">
        <div class="row">
            <div id="logo" class="col-lg-3">
                <a href="index.php"><img src="images/logo.png"></a>
            </div>
            <div id="association" class="col-lg-3">
                <span>法国校友会</span>
            </div>
            <div class="header-right col-lg-2">
                <div id="button-inscription" class="popup-trigger">
                    <div class="glyphicon glyphicon-user"></div>
                    <div id="popup-login" class="popup-content">
                        <button id="button-signin" type="button">Sign in</button>
                        <br>
                        <button id="button-signup" type="button">Sign up</button>
                    </div>
                </div>
                <div id="button-lang" class="popup-trigger">
                    <div class="glyphicon glyphicon-globe"></div>
                    <div id="popup-lang" class="popup-content">
                        <button id="button-zh" type="button">中文</button>
                        <button id="button-fr" type="button">Français</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div id="menu" class="collapse navbar-collapse">
    <div class="container">
        <ul id="menu-list">
            <li id="button-accueil" class="menu-item"><a href="index.php">ACCUEIL</a></li>
            <li id="button-profile" class="menu-item"><a href="index.php?page=profile">NOTRE PROFIL</a></li>
            <li id="button-activity" class="menu-item"><a href="index.php?page=activity">ACTIVITÉS</a></li>
            <li id="button-community" class="menu-item"><a href="index.php?page=community">COMMUNAUTÉ</a></li>
            <li id="button-contact" class="menu-item"><a href="#contact">CONTACTEZ-NOUS</a></li>
        </ul>
    </div>
</div>
<?php
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
echo <<<EOT
<div id="loginform-container" class="modal">
    <form id="loginform" action="$actual_link">
        <div class="imgcontainer">
            <span id='close-login' class="close" title="Close Modal">&times;</span>
            <img src="img_avatar2.png" alt="Avatar" class="avatar">
        </div>

        <label><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="uname" required>

        <label><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="psw" required>


        <button type="submit">Login</button>

<!--        <span id="forgetpsw">Forgot <a href="#">password?</a></span>-->
        <input type="checkbox" checked="checked"> Remember me
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
        require 'snippets/community-snippet.php';
    else
        echo "<h1>No Such Page</h1>";
    ?>


</div>
<!--Here ends the main contents-->

<div id="gotop"><img src="images/gotop.png"></div>
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
                    <img src="images/foot_logo.png">
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
<script src="js/script.js"></script>
</body>

</html>