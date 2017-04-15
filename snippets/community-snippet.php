<?php
if ($_SESSION["lang"] == "fr") {
    $msg = array(
        "last_name" => "Nom ",
        "first_name" => "Prénom ",
        "search_criteria" => "Critères de recherche :",
        "studies" => "Études :",
        "bachelor" =>"Étudiants de NJU",
        "master" => "Master de NJU",
        "doctor" => "Doctorants de NJU",
        "class" => "Promotion :",
        "school" => "Département :",
        "search" => "Rechercher",
        "search_alumni" => "Chercher les alumni :"
    ); 
} else {
    $msg = array(
        "last_name" => "姓",
        "first_name" => "名",
        "search_criteria" => "搜索条件:",
        "studies" => "学历:",
        "bachelor" =>"本科",
        "master" => "硕士",
        "doctor" => "博士",
        "class" => "入学年份:",
        "school" => "学院:",
        "search" => "搜索",
        "search_alumni" => "搜索校友: "
    );
}
?>

<div class="head-picture">
    <img src="images/community_jumbotron.jpg" alt="Picture">
</div>

<div class="container main-wrapper">
    <table class="full-width">
        <tr>
            <td class="table-filter">
                <div class="filter-wrapper">
                    <div class="block-title">
                        <span class="glyphicon glyphicon-chevron-left" id="search-hide"></span>
                        <span class="head-filter"><?php echo $msg["search_criteria"]; ?></span>
                    </div>
                    <div class="bighr"></div>
                    <div class="form-group main-filter">
                        <label class="control-label" ><?php echo $msg["last_name"].":"; ?></label>
                        <input type="text" class="form-control"  id="nom-filter" <?php echo "placeholder='". $msg["last_name"]. "'"; ?>>
                        <label class="control-label" ><?php echo $msg["first_name"].":"; ?></label>
                        <input type="text" class="form-control" id="prenom-filter" <?php echo "placeholder='". $msg["first_name"]. "'"; ?>>
                        <label class="control-label" ><?php echo $msg["studies"]; ?></label>
                        <div class="multiselect-wrapper">
                            <button class="multiselect-button form-control"></button>
                            <ul class="display-none" id="study-filter">
                                <li>
                                    <label>
                                        <input type="checkbox" name="0" checked="checked">&nbsp;<?php echo $msg["bachelor"]; ?>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" name="1" checked="checked">&nbsp;<?php echo $msg["master"]; ?>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" name="2" checked="checked">&nbsp;<?php echo $msg["doctor"]; ?>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <label class="control-label"><?php echo $msg["class"]; ?></label> <br>
                        <input type="text" class="form-control promo-start" name="promotion_start" id="promo-filter1" placeholder="1949">
                        <span>-</span>
                        <input type="text" class="form-control promo-end" name="promotion_end" id="promo-filter2">
                        <label class="control-label"><?php echo $msg["school"]; ?></label>
                        <div class="multiselect-wrapper">
                            <button class="multiselect-button form-control"></button>
                            <ul class="display-none" id="departement-filter">
                                <?php
                                for ($i = 0; $i < count($_SESSION["DEPARTEMENT_ARRAY"]); $i++) {
                                    $departement = $_SESSION['DEPARTEMENT_ARRAY'][$i];
                                    echo <<<EOT
                        <li>
                            <label>
                                <input type="checkbox" name="$i" checked="checked">&nbsp;$departement
                            </label>
                        </li>
EOT;
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="text-center">
                            <button id="button-recherche"><?php echo $msg["search"]; ?></button>
                        </div>
                    </div>
                    <div class="bighr"></div>
                </div>
            </td>
            <td class="table-results">
                <div class="results" >
                    <div class="block-title">
                        <span class="glyphicon glyphicon-chevron-right" id="search-show"></span>
                        <span id='nb-results' class="head-results"><?php echo $msg["search_alumni"]; ?></span>
                    </div>
                    <div class="bighr"></div>
                    <div id="response" ></div>
                    <div class="buffer full-width text-center">
                        <img src="sources/loader.gif" alt="loader" class="display-none" id="loader">
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
<script src="js/community.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
