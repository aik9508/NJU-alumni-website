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

$(document).ready(function () {
    var lang = getLang();
    var msg;
    if (lang === "fr") {
        msg = {
            empty_error: "Ce champ est obligatoire!",
            email_error: "Adresse e-mail invalide.",
            short_password: "Les mots de passe courts sont faciles à deviner. Veuillez recommencer en utilisant au moins 8 caractères.",
            incorrect_password: "Les mots de passe ne correspondent pas. Voulez-vous réessayer?",
            wrong_password: "Mot de passe incorrect.",
            telephone_error: "Ce format de numéro de téléphone n'est pas reconnu.",
            incorrect_class: "Veuillez vérifier votre promotion.",
            class_error: "Promotion invalide",
            logout_error: "Veuillez vous connecter!",
            company_error: "Veuillez indiquer votre entreprise.",
            allvalid_error: "Veuillez choisir au moins un diplôme que vous avez obtenu à l'université de Nanjing et remplir votre promotion ainsi que votre département."
        };
    } else {
        msg = {
            empty_error: "此项不能为空。",
            email_error: "邮箱地址错误",
            short_password: "过短的密码很容易被猜到。请尝试使用至少包含 8 个字符的密码。",
            incorrect_password: "两个密码不匹配。是否重试？",
            wrong_password: "密码错误。",
            telephone_error: "该电话号码的格式无法识别。",
            incorrect_class: "请核对您的入学年份。",
            class_error: "入学年份有误",
            logout_error: "请先登录!",
            company_error: "请注明您的就职单位。",
            allvalid_error: "请至少选择一段您在南京大学的学习经历,并注明入学年份和院系。"
        };
    }
    var inputs = new Array($("input[name='nom']"),
            $("input[name='prenom']"),
            $("#profil input[name='email']"),
            $("input[name='promo-licence']"),
            $("input[name='promo-master']"),
            $("input[name='promo-doctorat']"),
            $("input[name='num']"),
            $("input[name='entreprise']"),
            $("input[name='fonction']"),
            $("input[name='id']")
            );
    var initial_vals = new Array(inputs.length);
    for (var i = 0; i < initial_vals.length; i++) {
        initial_vals[i] = inputs[i].val();
    }
    var dpt_licence_inital = $("#select-licence").find(":selected");
    var dpt_master_inital = $("#select-master").find(":selected");
    var dpt_doctorat_inital = $("#select-doctorat").find(":selected");

    $('#change-photo').click(function () {
        if (!$(this).parent("li").hasClass('disabled')) {
            $('#imgFile').click();
        }
    });

    var output_format = "image/jpeg";

    $(".cropper-wrapper").append("<img id='source_photo' class='display-none' alt='source'/>");

    $("#source_photo")[0].onload = function () {
        if ($("#imgFile")[0].files && $("#imgFile")[0].files[0]) {
            var file = $("#imgFile")[0].files[0];
            if (file.size > 300000) {
                var quality = 300000 * 100 / file.size;
                if (quality < 20) {
                    quality = 20;
                }
                var photo_obj;
                if (output_format === "image/png") {
                    photo_obj = jic.compress($(this)[0], quality, "png").src;
                } else {
                    photo_obj = jic.compress($(this)[0], quality, "jpeg").src;
                }
                $("#temp-container").attr("src", photo_obj);
            } else {
                $('#temp-container').attr("src", $(this).attr("src"));
            }
            $('#temp-container').cropper({
                viewMode: 1,
                dragMode: 'move',
                aspectRatio: 1,
                autoCropArea: 0.7,
                restore: false,
                guides: false,
                highlight: false,
                cropBoxMovable: false,
                cropBoxResizable: false

            });
        }
    };

    $('#imgFile').change(function () {
        if ($(this)[0].files && $(this)[0].files[0]) {
            $("#original-photo").hide();
            $("#temp-container").show();
            $("#change-photo").parent("li").addClass('disabled');
            $("#upload-photo").parent("li").removeClass('disabled');
            $("#cancel-photo").parent("li").removeClass('disabled');
            var file = $(this)[0].files[0];
            output_format = file.type;
            var photo_obj = window.URL.createObjectURL(file);
            $("#source_photo").attr("src", photo_obj);
        }
    });

    $('#upload-photo').click(function () {
        if (!$(this).parent("li").hasClass("disabled")) {
            var croppedCanvas = $("#temp-container").cropper('getCroppedCanvas');
            var cropimg;
            if (output_format === "image/png") {
                cropimg = croppedCanvas.toDataURL("image/png");
            } else {
                cropimg = croppedCanvas.toDataURL("image/jpeg");
            }
            $("#original-photo").attr("src", cropimg);
            $("#photo").attr("src", cropimg);
            $("#temp-container").hide();
            $('#temp-container').cropper('destroy');
            $("#original-photo").show();
            $("#change-photo").parent("li").removeClass('disabled');
            $("#upload-photo").parent("li").addClass('disabled');
            $("#cancel-photo").parent("li").addClass('disabled');
            $('#imgFile').val("");
            $.post("utils/save_photo.php", {
                imageData: cropimg,
                type: output_format
            }, function (response) {
            });
        }
    });

    $('#cancel-photo').click(function () {
        if (!$(this).parent("li").hasClass("disabled")) {
            $("#temp-container").hide();
            $('#temp-container').cropper('destroy');
            $("#original-photo").show();
            $("#change-photo").parent("li").removeClass('disabled');
            $("#upload-photo").parent("li").addClass('disabled');
            $("#cancel-photo").parent("li").addClass('disabled');
            $('#imgFile').val("");
        }
    });


    $("#editer").click(function () {
        $(".flip-container").hide();
        $(".profil-edit-wrapper").show();
    });
    $("#profil-valider").click(function () {
        if (isAllValid()) {
            if (hasChanged()) {
                var postList = {};
                for (var i = 0; i < inputs.length; i++) {
                    if (inputs[i].val().trim() !== initial_vals[i]) {
                        postList[inputs[i].attr("name")] = inputs[i].val().trim();
                    }
                }
                if ($("#select-licence").find(":selected")[0] !== dpt_licence_inital[0]) {
                    postList["dpt-licence"] = $("#select-licence").val();
                }
                if ($("#select-master").find(":selected")[0] !== dpt_master_inital[0]) {
                    postList["dpt-master"] = $("#select-master").val();
                }
                if ($("#select-doctorat").find(":selected")[0] !== dpt_doctorat_inital[0]) {
                    postList["dpt-doctorat"] = $("#select-doctorat").val();
                }
                postList["id"] = initial_vals[9];
                $.post(
                        "utils/update_post.php",
                        postList,
                        function (response) {
                            $("#profile-wrapper").load("utils/profile-" + lang + ".php");
                        }
                );
            }
            $(".profil-edit-wrapper").hide();
            $(".flip-container").show();
        }
    });
    $("#profil-annuler").click(function () {
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].val(initial_vals[i]);
            inputs[i].css("border-color", 'rgb(204,204,204)');
        }
        dpt_licence_inital.prop("selected", true);
        dpt_master_inital.prop("selected", true);
        dpt_doctorat_inital.prop("selected", true);
        $(".profil-edit-wrapper").hide();
        $(".flip-container").show();
    });

    $("#modifier-mdp").click(function () {
        $(".pwd-edit-wrapper").show();
        $(".profil-edit-wrapper").hide();
    });

    $("#mdp-annuler").click(function () {
        $(".profil-edit-wrapper").show();
        $(".pwd-edit-wrapper").hide();
        clearAllPassword();
    });

    $("#mdp-valider").click(function () {
        if (isPswValid($("input[name='ancien-mdp']").val())
                && isNonEmpty($("input[name='nouveau-mdp']").val())
                && isPswCorrect($("input[name='confirmer-mdp']").val())) {
            $.post("utils/checkPassword.php", {
                pwd: $("input[name='ancien-mdp']").val().trim(),
                new_pwd: $("input[name='nouveau-mdp']").val().trim()
            }, function (response) {
                if (!response) {
                    $("input[name='ancien-mdp']").css('border-color', 'red');
                    toolTipError($("input[name='ancien-mdp']"), "Mot de passe invalide.")();
                } else if (response === "Not Login") {
                    alert("Veuillez vous connecter!");
                } else {
                    $(".profil-edit-wrapper").show();
                    $(".pwd-edit-wrapper").hide();
                    clearAllPassword();
                }
            });
        } else {
            $("input[name='ancien-mdp']").focusout();
            $("input[name='nouveau-mdp']").focusout();
            $("input[name='confirmer-mdp']").focusout();
        }
    });

    inputs[0].autocheck(isNonEmpty, toolTipError(inputs[0], msg.empty_error));
    inputs[1].autocheck(isNonEmpty, toolTipError(inputs[1], msg.empty_error));
    inputs[2].autocheck(isEmailValid, toolTipError(inputs[2], msg.email_error));
    inputs[3].autocheck(isPromoValid, toolTipError(inputs[3], msg.class_error));
    inputs[4].autocheck(isPromoValid, toolTipError(inputs[4], msg.class_error));
    inputs[5].autocheck(isPromoValid, toolTipError(inputs[5], msg.class_error));
    inputs[6].autocheck(isTelValid, toolTipError(inputs[6], msg.telephone_error));
    inputs[7].autocheck(isEntrepriseValid, toolTipError(inputs[7], msg.company_error));
    inputs[8].autocheck(isFonctionValid, toolTipError(inputs[8], msg.company_error));

    $("input[name='ancien-mdp']").autocheck(isNonEmpty, toolTipError($("input[name='ancien-mdp']"), msg.empty_error));
    $("input[name='nouveau-mdp']").focusin(function () {
        $(this).css('border-color', 'rgb(102,175,233)');
    });
    $("input[name='nouveau-mdp']").focusout(function () {
        if (!isNonEmpty($(this).val())) {
            $(this).css('border-color', 'red');
            toolTipError($(this), msg.empty_error)();
        } else if (!isPswValid($(this).val())) {
            $(this).css('border-color', 'red');
            toolTipError($(this), msg.short_password)();
        } else {
            $(this).css('border-color', 'rgb(204,204,204)');
        }
    });
    $("input[name='confirmer-mdp']").focusin(function () {
        $(this).css('border-color', 'rgb(102,175,233)');
    });
    $("input[name='confirmer-mdp']").focusout(function () {
        if (!isNonEmpty($(this).val())) {
            $(this).css('border-color', 'red');
            toolTipError($(this), msg.empty_error)();
        } else if (!isPswCorrect($(this).val())) {
            $(this).css('border-color', 'red');
            toolTipError($(this), msg.incorrect_password)();
        } else {
            $(this).css('border-color', 'rgb(204,204,204)');
        }
    });

    function hasChanged() {
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].val() !== initial_vals[i]) {
                return true;
            }
        }
        if ($("#select-licence").find(":selected")[0] !== dpt_licence_inital[0]
                || $("#select-master").find(":selected")[0] !== dpt_master_inital[0]
                || $("#select-doctorat").find(":selected")[0] !== dpt_doctorat_inital[0]) {
            return true;
        }
        return false;
    }

    $("#close-container .close-cross").click(function () {
        if ($("#original-photo").is(':visible')) {
            $(".flip-container").removeClass('hover');
        }
    });

    $("#photo").click(function () {
        if ($('.flip-container').is(':visible')) {
            $(".flip-container").addClass('hover');
        }
    });

    function clearAllPassword() {
        $("input[name='ancien-mdp']").val("").css("border-color", "rgb(204,204,204)");
        $("input[name='nouveau-mdp']").val("").css("border-color", "rgb(204,204,204)");
        $("input[name='confirmer-mdp']").val("").css("border-color", "rgb(204,204,204)");
    }

    function isAllValid() {
        var allValid = isNonEmpty($("input[name='nom']").val())
                && isNonEmpty($("input[name='prenom']").val())
                && isEmailValid($("input[name='email']").val())
                && isPromoValid($("input[name='promo-licence']").val())
                && isPromoValid($("input[name='promo-master']").val())
                && isPromoValid($("input[name='promo-doctorat']").val())
                && isTelValid($("input[name='num']").val())
                && isEntrepriseValid($("input[name='entreprise']").val())
                && isFonctionValid($("input[name='fonction']").val());
        if (allValid) {
            allValid = allValid &&
                    $("input[name='promo-licence']").val()
                    + $("input[name='promo-master']").val()
                    + $("input[name='promo-doctorat']").val().trim() != "";
            if (!allValid) {
                alert(msg.allvalid_error);
            }
        }
        return allValid;
    }

    function isNonEmpty(val) {
        if (val.trim() != "") {
            return val.trim();
        } else {
            return false;
        }
    }

    function isPswValid(psw) {
        if (psw.trim().length < 8 && psw.trim().length > 0) {
            return false;
        } else {
            return psw;
        }
    }

    function isPswCorrect(psw) {
        if (psw === $("input[name='nouveau-mdp']").val().trim()) {
            return psw;
        } else {
            return false;
        }
    }

    function isPromoValid(promo) {
        if (!promo) {
            return true;
        }
        var thisYear = new Date().getFullYear();
        if ($.isNumeric(promo)) {
            if (!(promo <= thisYear && promo >= 1949)) {
                if (promo >= 0 && promo < 100) {
                    if (promo <= thisYear % 1000) {
                        return (+promo) + 2000;
                    } else if (promo >= 49) {
                        return (+promo) + 1900;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return promo;
            }
        }
    }

    function isEmailValid(email) {
        if (!email)
            return true;
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (re.test(email.trim())) {
            return email;
        } else {
            return false;
        }
    }

    function isEntrepriseValid(entreprise) {
        if (entreprise.trim() == "") {
            if ($("input[name='fonction']").val().trim() == "") {
                $("input[name='fonction']").css('border-color', 'rgb(204,204,204)');
                return true;
            } else {
                return false;
            }
        } else {
            $("input[name='fonction']").css('border-color', 'rgb(204,204,204)');
            return entreprise.trim();
        }
    }

    function isFonctionValid(fonction) {
        if (fonction.trim() == "") {
            $("input[name='entreprise']").css('border-color', 'rgb(204,204,204)');
            return true;
        } else if ($("input[name='entreprise']").val().trim() == "") {
            return false;
        } else {
            $("input[name='entreprise']").css('border-color', 'rgb(204,204,204)');
            return fonction.trim();
        }
    }

    function isTelValid(tel) {
        if (!tel)
            return true;
        var re = /^(\+33 |0|\+33)[1-9]( \d\d|\d\d){4}$/;
        if (re.test(tel.trim())) {
            return telFormat(tel);
        } else {
            return false;
        }
    }

    function telFormat(tel) {
        tel = tel.replace(/ /g, "");
        if (tel.charAt(0) !== '+') {
            tel = "+33" + tel.substring(1);
        }
        tel = tel.splice(3, 0, " ");
        tel = tel.splice(5, 0, " ");
        tel = tel.splice(8, 0, " ");
        tel = tel.splice(11, 0, " ");
        tel = tel.splice(14, 0, " ");
        return tel;
    }
});

if (!String.prototype.splice) {
    String.prototype.splice = function (start, delCount, newSubStr) {
        return this.slice(0, start) + newSubStr + this.slice(start + Math.abs(delCount));
    };
}

if (!$.prototype.autocheck) {
    $.prototype.autocheck = function (validFunction, errorFunction) {
        $(this).focusin(function () {
            $(this).css('border-color', 'rgb(102,175,233)');
        });
        $(this).focusout(function () {
            var result = validFunction($(this).val());
            if (result) {
                $(this).css('border-color', 'rgb(204,204,204)');
                if (result !== true) {
                    $(this).val(result);
                }
            } else {
                $(this).css('border-color', 'red');
                if (errorFunction) {
                    errorFunction();
                }
            }
        });
    };
}

function toolTipError(element, text) {
    return function () {
        var errorTip = $(element.parent().find(".tooltiptext")[0]);
        errorTip.html(text);
        errorTip.addClass('open');
        setTimeout(function () {
            $.when(errorTip.fadeOut(1000)).done(function () {
                errorTip.removeClass('open');
                errorTip.show();
            });
        }, 3000);
    };
}
