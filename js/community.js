
function selectForm(button, list, lang) {
    const self = this;

    self.lang = lang;
    self.button = $(button);
    self.list = $(list);
    self.list.prepend("<span class='text-center'>Effacer Tous</span>");
    self.clearAndSelect = $(self.list.find("span")[0]);

    self.button.html("<span class='multiselect-button-content'></span><span class='arrow-down'></span>");

    self.button.click(function (e) {
        e.stopPropagation();
        var position = self.button.position();
        var height = self.button.outerHeight();
        self.list.css("top", position.top + height + 15).css("left", position.left).toggle();
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

selectForm.prototype.init = function () {
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

    self.clearAndSelect.click(function (e) {
        e.stopPropagation();
        if ($(this).hasClass("active")) {
            self.selectAll();
            self.switchToClear();
        } else {
            self.clearAll();
            self.switchToSelect();
        }
    });

    $(window).resize(function () {
        var position = self.button.position();
        var height = self.button.outerHeight();
        self.list.css("top", position.top + height + 15).css("left", position.left);
    });

};

selectForm.prototype.switchToClear = function () {
    const self = this;
    self.clearAndSelect.removeClass("active");
    if (self.lang === "fr") {
        self.clearAndSelect.html("Effacer Tous");
    } else {
        self.clearAndSelect.html("全部取消");
    }
};

selectForm.prototype.switchToSelect = function () {
    const self = this;
    self.clearAndSelect.addClass("active");
    if (self.lang === "fr") {
        self.clearAndSelect.html("Choisir Tous");
    } else {
        self.clearAndSelect.html("全部选择");
    }
};

selectForm.prototype.changeContent = function () {
    const self = this;

    if (self.nbChecked === 0) {
        if (self.lang === "fr") {
            self.content.html("Aucune sélection");
        } else {
            self.content.html("无");
        }
        self.switchToSelect();
    } else if (self.nbChecked === 1) {
        var labelText = String(self.list.find("input[type=checkbox]:checked").parent("label").text()).trim();
        if (labelText.length > 38) {
            labelText = labelText.substring(0, 35) + "...";
        }
        self.content.html(labelText);
    } else if (self.nbChecked === self.nbTotal) {
        if (self.lang === "fr") {
            self.content.html("Tous (" + self.nbChecked + ")");
        } else {
            self.content.html("全部 (" + self.nbChecked + ")");
        }
        self.switchToClear();
    } else {
        if (self.lang === "fr") {
            self.content.html("Tous (" + self.nbChecked + ")");
        } else {
            self.content.html("已选择 " + self.nbChecked + " 项");
        }
    }
};

selectForm.prototype.clearAll = function () {
    const self = this;
    self.nbChecked = 0;
    self.labels.each(function () {
        $(this).removeClass("active");
    });
    self.options.each(function () {
        $(this).prop("checked", false);
    });
    if (self.lang === "fr") {
        self.content.html("Aucune sélection");
    } else {
        self.content.html("无");
    }
};

selectForm.prototype.selectAll = function () {
    const self = this;
    self.nbChecked = self.nbTotal;
    self.labels.each(function () {
        $(this).addClass("active");
    });
    self.options.each(function () {
        $(this).prop("checked", true);
    });
    if (self.lang === "fr") {
        self.content.html("Tous (" + self.nbChecked + ")");
    } else {
        self.content.html("全部 (" + self.nbChecked + ")");
    }
};

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

function addListenerToProfiles(lang) {
    $(".profile-info>a").each(function () {
        $(this).click(function () {
            console.log("An element is created");
            if ($('body').find("#profile-wrapper").length === 0) {
                $('body').append("<div id='profile-wrapper' class='vertical-center-parent background-wrapper'></div>");
                document.body.style.overflow = 'hidden';
                $('body').on('mousewheel', document.disableScrollFn);
                $.post("utils/profile-"+lang+".php", {
                    alumni_id: $(this).attr("id")
                }, function (response) {
                    $("#profile-wrapper").html(response);
                });
            }
        });
    });
}

var getLang = function () {
    var lang = "zh";
    var url = document.location.toString();
    if (url.indexOf('?') !== -1) {
        var query = url
                .replace(/^.*?\?/, '')
                .replace(/#.*$/, '')
                .split('&');
        for (var i = 0, l = query.length; i < l; i++) {
            var aux = decodeURIComponent(query[i]).split('=');
            if (aux[0] == "lang") {
                lang = aux[1];
            }
        }
    }
    return lang;
};

this.disableScrollFn = function (e) {
    e.preventDefault();
    e.stopPropagation();
};

$(document).ready(function () {
    var nb_results = 0;
    var nb_total = 0;
    var study_options;
    var departement_options;
    var nom_filter;
    var prenom_filter;
    var promo_start_filter;
    var promo_end_filter;
    var isloading = false;
    var lang = getLang();

    $(".multiselect-wrapper").each(function () {
        var list = $(this).find("ul");
        var button = $(this).find("button");
        new selectForm(button, list, lang);
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
        if ($(window).width() < 768) {
            $("#search-hide").click();
        }
    });

    function search(count) {
        if (!isloading) {
            isloading = true;
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
                        count: count
                    },
                    function (response) {
                        $("#loader").hide();
                        $("#response").append(response);
                        if (count) {
                            nb_total = $("#count").html();
                            if(lang==="fr"){
                                $("#nb-results").html(nb_total + " résultat(s) trouvé(s) :");
                            }else{
                                $("#nb-results").html("共找到 "+nb_total+" 个结果:" );
                            }
                        }
                        nb_results = $(".profile-card").length;
                        isloading = false;
                        addListenerToProfiles(lang);
                    }
            );
        }
    }

    $(window).scroll(function () {
        if (nb_results >= 20 && nb_results < nb_total && !isloading) {
            var buffer = $(".buffer");
            if (isShow(buffer)) {
                $("#loader").show();
                search(false);
            }
        }
    });

    $(document).on("click", "#profile-wrapper", function (event) {
        if (event.target == this) {
            $(this).remove();
            document.body.style.overflow = 'auto';
            $('body').off('mousewheel', document.disableScrollFn);
        }
    });

    /*responsive*/
    $("#search-hide").click(function () {
        if ($(".table-filter").is(":visible")) {
            $(".filter-wrapper").addClass("move-out");
            $(".table-filter").hide(1000);
            $("#response").css("text-align", "center");
            if ($(window).width() > 980) {
                $(".table-filter").attr("hideAfterClick", "1");
            }
            $(".table-filter").attr("showAfterClick", "");
        }
    });

    $("#search-show").click(function () {
        if (!$(".table-filter").is(":visible")) {
            $(".table-filter").show(1000);
            $(".filter-wrapper").removeClass("move-out");
            if ($(window).width() > 980) {
                $("#response").css("text-align", "left");
            } else {
                $(".table-filter").attr("showAfterClick", "1");
            }
            $(".table-filter").attr("hideAfterClick", "");
        }
    });

    $(window).resize(function () {
        if ($(this).width() <= 980) {
            $(".table-filter").attr("hideAfterClick", "");
            if (!$(".table-filter").attr("showAfterClick")) {
                $(".filter-wrapper").addClass("move-out");
                $(".table-filter").hide();
                $("#response").css("text-align", "center");
            }
        } else {
            $(".table-filter").attr("showAfterClick", "");
            if (!$(".table-filter").attr("hideAfterClick")) {
                $(".filter-wrapper").removeClass("move-out");
                $(".table-filter").show();
                $("#response").css("text-align", "left");
            }
        }
    });

    $("#button-recherche").click();

});