<div class="head-picture">
    <img src="images/community_jumbotron.jpg" alt="Picture">
</div>

<div class="container">
    <table class="full-width">
        <tr>
            <td class="table-filter">
                <div class="main-filter">
                    <h3>Critère de recherche</h3>
                    <hr/>
                    <div class="form-group">
                        <label class="control-label" for="nom">Nom : </label>
                        <input type="text" class="form-control"  id="nom-filter" placeholder="Nom">
                        <label class="control-label" for="prenom">Prenom : </label>
                        <input type="text" class="form-control" id="prenom-filter" placeholder="prenom">
                        <label class="control-label" >Études : </label>
                        <div class="multiselect-wrapper">
                            <button class="multiselect-button form-control"></button>
                            <ul class="display-none" id="study-filter">
                                <li>
                                    <label>
                                        <input type="checkbox" name="0" checked="checked">&nbsp;Étudiants de NJU
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" name="1" checked="checked">&nbsp;Masters de NJU
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" name="2" checked="checked">&nbsp;Doctorants de NJU
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <label class="control-label">Promotion : </label> <br>
                        <input type="text" class="form-control promo-start" name="promotion_start" id="promo-filter1" placeholder="1949">
                        <span>-</span>
                        <input type="text" class="form-control promo-end" name="promotion_end" id="promo-filter2">
                        <label class="control-label">Départements : </label>
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
                            <button id="button-recherche">Rechercher</button>
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <div class="results" >
                    <div>
                        <h3 id="nb-results"></h3>
                    </div>
                    <div id="response" ></div>
                    <div class="buffer full-width text-center">
                        <img src="sources/loader.gif" alt="loader" class="display-none" id="loader">
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
<div id="profile-wrapper" class="vertical-center-parent">
</div>
<script src="js/community.js"></script>
