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
                        <span class="head-filter">搜索条件: </span>
                    </div>
                    <div class="bighr"></div>
                    <div class="form-group main-filter">
                        <label class="control-label" >姓: </label>
                        <input type="text" class="form-control"  id="nom-filter" placeholder="姓">
                        <label class="control-label" >名: </label>
                        <input type="text" class="form-control" id="prenom-filter" placeholder="名">
                        <label class="control-label" >学历: </label>
                        <div class="multiselect-wrapper">
                            <button class="multiselect-button form-control"></button>
                            <ul class="display-none" id="study-filter">
                                <li>
                                    <label>
                                        <input type="checkbox" name="0" checked="checked">&nbsp;本科
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" name="1" checked="checked">&nbsp;硕士
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" name="2" checked="checked">&nbsp;博士
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <label class="control-label">入学年: </label> <br>
                        <input type="text" class="form-control promo-start" name="promotion_start" id="promo-filter1" placeholder="1949">
                        <span>-</span>
                        <input type="text" class="form-control promo-end" name="promotion_end" id="promo-filter2">
                        <label class="control-label">院系: </label>
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
                            <button id="button-recherche">搜索</button>
                        </div>
                    </div>
                    <div class="bighr"></div>
                </div>
            </td>
            <td class="table-results">
                <div class="results" >
                    <div class="block-title">
                        <span class="glyphicon glyphicon-chevron-right" id="search-show"></span>
                        <span id='nb-results' class="head-results">搜索校友 : </span>
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
<script src="js/community-zh.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
