<?php
session_start();
if (!isset($_SESSION["DEPARTMENT_ARRAY"])) {
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
            <a id="logo"><img src="../images/nju-logo.png" class="img-responsive" alt="NJU"></a>
            <!--            <a id="langue"><div class="glyphicon glyphicon-globe"></div></a>
                        <a id="connecter"><div class="glyphicon glyphicon-user"></div></a>-->
        </div>
        <div class="grad">
            <div id="container-backgroud">
                <div class="input-main ">
                    <div  class="form-group container">
                        <label class="control-label col-xs-6 input-left" for="nom">姓:</label>
                        <label class="control-label col-xs-6 input-right" for="prenom">名:</label>
                        <div class="col-xs-6 input-left">
                            <input type="text" class="form-control" id="nom" placeholder="姓">
                        </div>
                        <div class="col-xs-6 input-right">
                            <input type="text" class="form-control" id="prenom" placeholder="名">
                        </div>
                        <div class="col-xs-6 input-left error-container" id='error-nom'></div>
                        <div class="col-xs-6 input-right error-container" id='error-prenom'></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="email">邮箱(用户名):</label>
                        <div>
                            <input type="email" class="form-control" id="email" placeholder="邮箱">
                        </div>
                        <div id='error-email' class="error-container"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="mdp">设置密码:</label>
                        <div>
                            <input type="password" class="form-control" id="mdp" placeholder="密码" data-toggle="tooltip" title="Hooray!">
                        </div>
                        <div id='error-mdp' class="error-container"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="confirmer_mdp">确认密码:</label>
                        <div>
                            <input type="password" class="form-control" id="confirmer_mdp" placeholder="确认密码">
                        </div>
                        <div id='error-confirmer_mdp' class="error-container"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="num">手机:</label>
                        <div>
                            <input type="text" class="form-control" id="num" placeholder="手机">
                        </div>
                        <div id='error-num' class="error-container"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="sexe">性别:</label>
                        <div class="custom-selectbox">
                            <select class=" custom-select" id="sexe">
                                <option>女</option>
                                <option>男</option>
                                <option>其他</option>
                                <option>不便透露</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">您的入学年份:</label>
                        <ul class="nav nav-tabs">
                            <li class="active" id='li-licence'><a id='licence'>本科</a></li>
                            <li id='li-master'><a id='master'>硕士</a></li>
                            <li id='li-doctorat'><a id='doctorat'>博士</a></li>
                        </ul>
                    </div>
                    <div id='div-licence'>
                        <?php
                        $id = 'licence';
                        require 'register_info-zh.php'
                        ?>
                    </div>
                    <div id='div-master'>
                        <?php
                        $id = 'master';
                        require 'register_info-zh.php'
                        ?>
                    </div>
                    <div id='div-doctorat'>
                        <?php
                        $id = 'doctorat';
                        require 'register_info-zh.php';
                        ?>
                    </div>
                    <div id='error-diplome' class="error-container"></div>
                    <div class="vertical-center-parent">
                        <input type="submit" value="提交" id='input-valider'>
                    </div>
                </div>
            </div>
        </div>
        <div class="success-container vertical-center-parent" id='success-container'>
            <div class="alert alert-success vertical-center-parent vertical-center success-inner">
                <div class="vertical-center text-center" >
                    <p>您是本站第<span id="nb_alumni"></span>位注册的用户!</p>
                    <a href="../index.php" class="">返回首页</a>
                </div>
            </div>
        </div>
        <footer>
            <div class="footer-bottom">
                <span>Copyright@王珂 夏诗文</span>
            </div>
        </footer>
        <script src="../js/register-zh.js"></script>
    </body>
</html>