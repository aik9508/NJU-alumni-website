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
                        <input type="text" class="form-control" name="nom" id="nom-filter" placeholder="Nom">
                        <label class="control-label" for="prenom">Prenom : </label>
                        <input type="text" class="form-control" name="prenom" id="prenom-filter" placeholder="prenom">
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
                            <button id="button-recherche">Recherche</button>
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
<div class="modal-box">
    
</div>
<script>
    class selectForm {
        constructor(button, list) {
            const self = this;

            self.button = $(button);
            self.list = $(list);

            self.button.html("<span class='multiselect-button-content'></span><span class='arrow-down'></span>");

            self.button.click(function (e) {
                e.stopPropagation();
                var offset = self.button.offset();
                var height = self.button.outerHeight();
                self.list.css("top", offset.top + height + 10).css("left", offset.left).toggle();
            });

            self.content = self.button.find("span.multiselect-button-content");
            self.list.addClass("multiselect-container").addClass("dropdown-menu");
            self.labels = self.list.find("label");
            self.options = self.list.find("input[type=checkbox]");
            self.nbTotal = self.options.length;
            self.nbChecked = 0;
            if (self.nbTotal > 10) {
                self.list.addClass("overflow-y-scroll");
            }
            self.init();
            self.changeContent();
        }

        init() {
            const self = this;

            self.labels.each(function () {
                $(this).click(function (e) {
                    e.stopPropagation();
                });
            });

            self.options.each(function () {
                if ($(this)[0].checked) {
                    $(this).parent("label").addClass("active");
                    self.nbChecked += 1;
                } else {
                    $(this).parent("label").removeClass("active");
                    self.nbChecked -= 1;
                }

                $(this).change(function () {
                    if ($(this)[0].checked) {
                        $(this).parent("label").addClass("active");
                        self.nbChecked += 1;
                    } else {
                        $(this).parent("label").removeClass("active");
                        self.nbChecked -= 1;
                    }
                    self.changeContent();
                });
            });

            $(window).resize(function () {
                var offset = self.button.offset();
                var height = self.button.outerHeight();
                self.list.css("top", offset.top + height + 10).css("left", offset.left);
            });

        }

        changeContent() {
            const self = this;

            if (self.nbChecked === 0) {
                self.content.html("Aucune sélection");
            } else if (self.nbChecked === 1) {
                self.content.html(self.list.find("input[type=checkbox]:checked").parent("label").text());
            } else if (self.nbChecked === self.nbTotal) {
                self.content.html("Tous (" + self.nbChecked + ")");
            } else {
                self.content.html(self.nbChecked + " sélectionné(e)s");
            }
        }

    }

    function isShow($el) {
        var winH = $(window).height(), //获取窗口高度
                scrollH = $(window).scrollTop(), //获取窗口滚动高度
                top = $el.offset().top + $el.outerHeight() + 20;//获取元素距离窗口顶部偏移高度
        if (top < scrollH + winH) {
            return true;//在可视范围
        } else {
            return false;//不在可视范围
        }
    }

    $(document).ready(function () {
        var nb_results = 0;
        var nb_total=0;
        var study_options;
        var departement_options;
        var nom_filter;
        var prenom_filter;
        var promo_start_filter;
        var promo_end_filter;
        var isloading = false;

        $(".multiselect-wrapper").each(function () {
            var list = $(this).find("ul");
            var button = $(this).find("button");
            new selectForm(button, list);
        });

        $("body").click(function () {
            $(".multiselect-container").each(function () {
                $(this).hide();
            });
        });

        $(window).resize(function () {
            $(".multiselect-wrapper").each(function (i) {
                var offset = $(this).offset();
                var height = $(this).outerHeight();
                $("#multiselect-container" + i).css("top", offset.top + height + 10).css("left", offset.left);
            });
        });

        $("#button-recherche").click(function () {
            nb_results = 0;
            var studies = $("#study-filter").find("input[type=checkbox]:checked");
            study_options = new Array(studies.length);
            studies.each(function (i) {
                study_options[i] = $(this).attr("name");
            });
            var departements = $("#departement-filter").find("input[type=checkbox]:checked");
            departement_options = new Array(departements.length);
            departements.each(function (i) {
                departement_options[i] = $(this).attr("name");
            });
            nom_filter = $("#nom-filter").val().trim().toLowerCase();
            prenom_filter = $("#prenom-filter").val().trim().toLowerCase();
            promo_start_filter = $("#promo-filter1").val().trim();
            promo_end_filter = $("#promo-filter2").val().trim();
            $("#response").html("");
            search(true);
        });

        function search(count) {
            if (!isloading) {
                isloading = true;
                console.log("number " + nb_results);
                $.post(
                        "utils/search_alumni.php",
                        {
                            nom: nom_filter,
                            prenom: prenom_filter,
                            promo_start: promo_start_filter,
                            promo_end: promo_end_filter,
                            studies: study_options,
                            departements: departement_options,
                            limit1: nb_results,
                            limit2: 20,
                            count : count
                        },
                        function (response) {
                            $("#loader").hide();
                            $("#response").append(response);
                            if(count){
                                nb_total=$("#count").html();
                                $("#nb-results").html(nb_total+" résultats trouvés :");
                            }
                            nb_results = $(".profile-card").length;
                            console.log("after search " + nb_results);
                            isloading = false;
                        }
                );
            }
        }

        $(window).scroll(function () {
            if (nb_results >= 20 && nb_results<nb_total && !isloading) {
                var buffer = $(".buffer");
                if (isShow(buffer)) {
                    $("#loader").show();
                    search(false);
                }
            }
        });
        
        $(".profile-info a").click(function(){
            
        });
    });
</script>
<!--<script>
    $(document).ready(function () {
        $(".multiselect-wrapper").each(function (i) {
            $(this).find(".multiselect-container").attr("id", "multiselect-container" + i);
            var multiButton = $(this).find(".multiselect-button");
            var content=$(multiButton).find("span.multiselect-button-content");
            $(multiButton).attr("id", "multiselect-button" + i);
            $(multiButton).click(function (e) {
                e.stopPropagation();
                var offset = $(this).offset();
                var height = $(this).outerHeight();
                $("#multiselect-container" + i).css("top", offset.top + height + 10).css("left", offset.left).toggle();
            });
            var labels = $("#multiselect-container" + i).find("label");
            var nbChecked = 0;
            labels.each(function () {
                var self = this;
                var cbox = $(this).find("input[type=checkbox]");
                if (cbox[0].checked) {
                    $(this).addClass("active");
                    nbChecked += 1;
                }
                $(this).click(function (e) {
                    e.stopPropagation();
                });

                /*When a checkbox is clicked, change the text of the corresponding button. */
                cbox.change(function () {
                    if ($(this)[0].checked) {
                        $(self).addClass("active");
                        nbChecked += 1;
                    } else {
                        $(self).removeClass("active");
                        nbChecked -= 1;
                    }
                    console.log("number of checked checkbox" + nbChecked);
                    console.log("labels' lenght : " + labels.length);
                    if (nbChecked === 0) {
                        content.html("Aucune sélection");
                    } else if (nbChecked === 1) {
                        content.html($("#multiselect-container" + i).find("input[type=checkbox]:checked").parent("label").text());
                    } else if (nbChecked === labels.length) {
                        content.html("Tous (" + nbChecked + ")");
                    } else {
                        content.html(nbChecked + " sélectionné(e)s");
                    }
                });
            });
        });
        $("body").click(function () {
            $(".multiselect-container").each(function () {
                $(this).hide();
            });
        });
        
        $( window ).resize(function() {
            $(".multiselect-wrapper").each(function(i){
                var offset = $(this).offset();
                var height = $(this).outerHeight();
                $("#multiselect-container" + i).css("top", offset.top + height + 10).css("left", offset.left);
            });
        });
    });
</script>-->
