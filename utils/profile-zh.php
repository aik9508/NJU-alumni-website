<?php
session_start();
if (isset($_POST['alumni_id'])) {
    $id = $_POST['alumni_id'];
    require 'register_database.php';
    $dbh = Database::connect();
    $alumnus = User::getUserByID($dbh, $id);
} else if (isset($_SESSION["currentUser"])) {
    $id = $_SESSION["currentUser"]["id"];
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
$display = isset($_POST["alumni_id"]) && isset($_SESSION["currentUser"]) && $_POST["alumni_id"] == $_SESSION["currentUser"]["id"] || isset($_SESSION["currentUser"]) && !isset($_POST["alumni_id"]);
?>
<div id="profil" class="vertical-center">
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
                    echo "src='sources/default.jpg'";
                } else {
                    echo "src='photoDAtaBase/" . $photoPath . "'";
                }
                ?> alt="photo" id="photo"/>
            </div>
            <span id="profil-email"><?php echo "<a style='cursor: auto;'>$alumnus->email</a>"; ?></span>
        </div>
    </div>
    <?php if ($display) { ?>
        <div class="flip-container">
            <div class="flipper">
                <div class="front">
                <?php } ?>
                <div class="profil-info">
                    <p><span>学历:</span> <?php
                        if ($display) {
                            echo "<button id='editer' class='profil-button'>编辑</button>";
                        }
                        ?></p>
                    <ul>
                        <?php
                        $diplomas = Diploma::getDiplomas($dbh, $id);
                        $licence = $master = $doctorat = 0;
                        foreach ($diplomas as $diploma) {
                            $text = "$diploma->promotion : ";
                            if ($diploma->diplome == 0) {
                                $licence = $diploma;
                                $text = $text . '本科 ';
                            } else if ($diploma->diplome == 1) {
                                $master = $diploma;
                                $text = $text . '硕士 ';
                            } else {
                                $doctorat = $diploma;
                                $text = $text . '博士 ';
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
                        echo "<p><span>职业: </span></p><ul>";
                        if ($entreprise) {
                            echo "<li> 就职单位: " . $entreprise . "</li>";
                        }
                        if ($fonction) {
                            echo "<li> 职位:&nbsp;&nbsp; " . $fonction . "</li>";
                        }
                        echo "</ul>";
                    }
                    ?>
                    <p><span>联系方式:</span></p>
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
            <?php if ($display) { ?>
                <div class="back">
                    <div class="profil-photo">
                        <nav class="navbar navbar-inverse">
                            <div class="container-fluid">
                                <div class="navbar-header">
                                    <a class="navbar-brand">个人照片</a>
                                </div>
                                <ul class="nav navbar-nav">
                                    <li><a id="change-photo">更换</a></li>
                                    <li class="disabled"><a id="upload-photo">保存</a></li>
                                    <li class="disabled"><a id="cancel-photo">取消</a></li>
                                    <li id="close-container"><span class="close-cross">×</span></li>
                                </ul>
                            </div>
                        </nav>
                        <div class="cropper-wrapper vertical-center-parent">
                            <img id="temp-container" class="display-none" src="" alt="temp">
                            <div class="vertical-center">
                                <img class="thumbnail" <?php
                                if ($photoPath == null) {
                                    echo "src='sources/default.jpg'";
                                } else {
                                    echo "src='photoDAtaBase/" . $photoPath . "'";
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
                <button class="profil-button" id="profil-annuler">取消</button>
                <button class="profil-button" id="profil-valider">保存</button>
                <button class="profil-button" id="modifier-mdp">修改密码</button>
            </div>
            <div class="col-sm-6">
                <label>姓: </label>
                <div class="tooltip">
                    <input class="input-short form-control" type="text" name="nom" placeholder="姓" <?php echo "value=" . $alumnus->nom ?>>
                    <span class="tooltiptext"></span>
                </div>
            </div>
            <div class="col-sm-6">
                <label>名: </label>
                <div class="tooltip">
                    <input class="input-short form-control" type="text" name="prenom" placeholder="名" <?php echo "value=" . $alumnus->prenom ?>>
                    <span class="tooltiptext"></span>
                </div>
            </div>
            <div class="col-sm-12">
                <label>电子邮箱: </label>
                <div class="tooltip">
                    <input class="input-long form-control" type="email" name="email" placeholder="邮箱" <?php
                    if ($email_extra) {
                        echo "value=" . $email_extra;
                    } else {
                        echo "value=" . $alumnus->email;
                    }
                    ?>>
                    <span class="tooltiptext"></span>
                </div>
                <label>手机: </label>
                <div class="tooltip">
                    <input class="input-long form-control" type="text" name="num" placeholder="手机" <?php
                    if ($alumnus->numero) {
                        echo "value='" . $alumnus->numero . "'";
                    }
                    ?>>
                    <span class="tooltiptext"></span>
                </div>
            </div>
            <?php
            $titre_diplome = ['licence', 'master', 'doctorat'];
            $titre_zh = ['本科', '硕士', '博士'];
            $info_diplome = [$licence, $master, $doctorat];
            for ($i = 0; $i < 3; $i++) {
                echo <<<EOT
                <div class="col-sm-6">
                    <label> $titre_zh[$i] : </label>
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
                    <label>院系: </label>
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
                <label>就职单位: </label>
                <div class="tooltip">
                    <input class="input-short form-control" type="text" name="entreprise" placeholder="就职单位" <?php
                    if ($entreprise) {
                        echo "value=" . $entreprise;
                    }
                    ?>>
                    <span class="tooltiptext"></span>
                </div>
            </div>
            <div class="col-sm-6">
                <label>职位: </label>
                <div class="tooltip">
                    <input class="input-short form-control" type="text" name="fonction" placeholder="职位"<?php
                    if ($fonction) {
                        echo "value=" . $fonction;
                    }
                    ?>>
                    <span class="tooltiptext"></span>
                </div>
            </div>
            <input type="hidden" name="id" <?php echo "value=" . $id ?>>
        </div>
        <div class="pwd-edit-wrapper vertical-center-parent display-none">
            <div class="overflow-hidden">
                <button class="profil-button" id="mdp-annuler">取消</button>
                <button class="profil-button" id="mdp-valider">确定</button>
            </div>
            <div class="pwd-input-container">

                <label for="ancien_mdp">当前密码: </label>
                <div class="tooltip">
                    <input class="form-control" type="password" name="ancien-mdp" placeholder="当前密码">
                    <span class="tooltiptext"></span>
                </div>
                <label for="nouveau_mdp">新密码: </label>
                <div class="tooltip">
                    <input class="form-control" type="password" name="nouveau-mdp" placeholder="新密码">
                    <span class="tooltiptext"></span>
                </div>
                <label for="confirmer_mdp">确认密码: </label>
                <div class="tooltip">
                    <input class="form-control" type="password" name="confirmer-mdp" placeholder="确认密码">
                    <span class="tooltiptext"></span>
                </div>
            </div>
        </div>
        <script src="js/JIC.min.js"></script>
        <script src="js/cropper.js"></script>
        <script src="js/profile-zh.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
    <?php }
    ?>
</div>

