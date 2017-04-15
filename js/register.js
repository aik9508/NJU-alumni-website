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
            email_existed: "Vous avez saisi une adresse e-mail déjà associée à un compte.",
            short_password: "Les mots de passe courts sont faciles à deviner. Veuillez recommencer en utilisant au moins 8 caractères.",
            incorrect_password: "Les mots de passe ne correspondent pas. Voulez-vous réessayer?",
            telephone_error: "Ce format de numéro de téléphone n'est pas reconnu. Veuillez vérifier le numéro.",
            school_error: "Veuillez choisir votre département",
            class_error: "Veuillez indiquer votre promotion",
            incorrect_class: "Veuillez vérifier votre promotion",
            allvalid_error: "Veuillez choisir au moins un diplôme que vous avez obtenu à l'université de Nanjing et remplir votre promotion ainsi que votre département."
        };
    } else {
        msg = {
            empty_error: "此项不能为空。",
            email_error: "您无法用此邮箱创建帐号。",
            email_existed: "您输入的邮箱已被使用,请重新输入。",
            short_password: "过短的密码很容易被猜到。请尝试使用至少包含 8 个字符的密码。",
            incorrect_password: "两个密码不匹配。是否重试？",
            telephone_error: "该电话号码的格式无法识别。",
            school_error: "请选择您的院系。",
            class_error: "请输入您的入学年份。",
            incorrect_class: "请核对您的入学年份。",
            allvalid_error: "请至少选择一段您在南京大学的学习经历,并注明入学年份和院系。"
        };
    }
    $('#div-master').hide();
    $('#div-doctorat').hide();
    function change_tab(id) {
        return $('#' + id).click(function () {
            var id_array = ['licence', 'master', 'doctorat'];
            for (var i = 0; i < id_array.length; i++) {
                $('#li-' + id_array[i]).removeClass('active');
                $('#div-' + id_array[i]).hide();
            }
            $('#li-' + id).addClass('active');
            $('#div-' + id).show();
        });
    }

    var diplomas = ['licence', 'master', 'doctorat'];
    for (var i = 0; i < diplomas.length; i++) {
        change_tab(diplomas[i]);
        $('#dept-' + diplomas[i]).focusin(function () {
            $('#error-diplome').html("");
        });
    }

    setAutoCheck($("#nom"), $("#error-nom"), [
        new Pair(isNonEmpty, msg.empty_error)]);
    setAutoCheck($("#prenom"), $("#error-prenom"), [
        new Pair(isNonEmpty, msg.empty_error)]);
    setAutoCheck($("#email"), $("#error-email"), [
        new Pair(isNonEmpty, msg.empty_error),
        new Pair(isEmailValid, msg.email_error)
    ]);
    setAutoCheck($("#mdp"), $("#error-mdp"), [
        new Pair(isNonEmpty, msg.empty_error),
        new Pair(isPswValid, msg.short_password)
    ]);
    setAutoCheck($("#confirmer_mdp"), $("#error-confirmer_mdp"), [
        new Pair(isNonEmpty, msg.empty_error),
        new Pair(isPswCorrect, msg.incorrect_password)
    ]);
    setAutoCheck($("#num"), $("#error-num"), [
        new Pair(isTelValid, msg.telephone_error)]);
    $("#promo-licence").autocheck(focusInFunction($("#error-diplome")), [{
            validFunction: isPromoValid,
            errorFunction: promoError("licence")
        }]);
    $("#promo-master").autocheck(focusInFunction($("#error-diplome")), [{
            validFunction: isPromoValid,
            errorFunction: promoError("master")
        }]);
    $("#promo-doctorat").autocheck(focusInFunction($("#error-diplome")), [{
            validFunction: isPromoValid,
            errorFunction: promoError("doctorat")
        }]);

    $("#input-valider").click(function () {
        if (isAllValid()) {
            $.post('register_post.php', {
                nom: $("#nom").val().trim().toLowerCase(),
                prenom: $("#prenom").val().trim().toLowerCase(),
                mdp: $("#mdp").val(),
                email: $("#email").val().trim().toLowerCase(),
                num: $("#num").val().trim(),
                sexe: $("#sexe").val(),
                promo_licence: $("#promo-licence").val().trim(),
                dept_licence: $("#dept-licence").val(),
                promo_master: $("#promo-master").val().trim(),
                dept_master: $("#dept-licence").val(),
                promo_doctorat: $("#promo-doctorat").val().trim(),
                dept_doctorat: $("#dept-licence").val()},
                    function (response) {
                        $("#nb_alumni").html(response);
                    });
            $("#success-container").fadeIn(500);
            $("#success-container").css('display', 'flex');
        }
    });

    function isAllValid() {
        var allValid = isNonEmpty($("#nom").val())
                && isNonEmpty($("#prenom").val())
                && isEmailValid($("#email").val())
                && isPromoValid($("#promo-licence").val())
                && isPromoValid($("#promo-master").val())
                && isPromoValid($("#promo-doctorat").val())
                && isTelValid($("#num").val())
                && isPswValid($("#mdp").val())
                && isPswCorrect($("#confirmer_mdp").val());
        if (!($("#dept-licence").val() && $("#promo-licence").val()
                || $("#dept-master").val() && $("#promo-master").val()
                || $("#dept-doctorat").val() && $("#promo-doctorat").val())) {
            allValid = false;
            $("#error-diplome").html(msg.allvalid_error);
        }
        $("input").focusout();
        var diplomas = ['licence', 'master', 'doctorat'];
        for (var i = 0; i < diplomas.length; i++) {
            var id = diplomas[i];
            if (!$("#dept-" + id).val() && $("#promo-" + id).val()) {
                $("#error-diplome").html(msg.school_error);
                $('#' + id).click();
                return false;
            } else if ($("#dept-" + id).val() && !$("#promo-" + id).val()) {
                $("#error-diplome").html(msg.class_error);
                $('#' + id).click();
                return false;
            }
        }
        return allValid;
    }
});

function Pair(validFunction, msg) {
    this.validFunction = validFunction;
    this.msg = msg;
}

function setAutoCheck(element, error_container, funMsgPairs) {
    var handlers = [];
    for (var i = 0; i < funMsgPairs.length; i++) {
        handlers[i] = {
            validFunction: funMsgPairs[i].validFunction,
            errorFunction: errorFunction(error_container, funMsgPairs[i].msg)
        };
    }
    element.autocheck(focusInFunction(error_container), handlers);
}

if (!$.prototype.autocheck) {
    $.prototype.autocheck = function (focusInFunction, handlers) {
        $(this).focusin(function () {
            $(this).css('border-color', 'rgb(102,175,233)');
            focusInFunction();
        });
        $(this).focusout(function () {
            for (var i = 0; i < handlers.length; i++) {
                var result = handlers[i].validFunction($(this).val());
                if (result) {
                    $(this).css('border-color', 'rgb(204,204,204)');
                    if (result !== true) {
                        $(this).val(result);
                    }
                } else {
                    $(this).css('border-color', 'red');
                    if (handlers[i].errorFunction) {
                        handlers[i].errorFunction();
                    }
                    break;
                }
            }
        });
    };
}

function focusInFunction(element) {
    return function () {
        element.html("");
    };
}

function errorFunction(element, text) {
    return function () {
        element.html(text);
    };
}
function promoError(diplome) {
    return function () {
        var lang=getLang();
        if(lang==="fr"){
            $("#error-diplome").html("Veuillez vérifier votre promotion");
        }else{
           $("#error-diplome").html("请核对您的入学年份"); 
        }
        setTimeout(function () {
            $("#" + diplome).click()
        }, 50);
    };
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
    if (psw === $("#mdp").val().trim()) {
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
        $.post('checkUser.php', 'email=' + email.trim(), function (response) {
            if (response === 'existed') {
                var lang = getLang();
                $('#email').css('border-color', 'red');
                if (lang === "fr") {
                    $('#error-email').html("Vous avez saisi une adresse e-mail déjà associée à un compte.");
                } else {
                    $('#error-email').html("邮箱已被使用。");
                }
                return false;
            } else {
                return true;
            }
        });
        return email;
    } else {
        return false;
    }
}

if (!String.prototype.splice) {
    String.prototype.splice = function (start, delCount, newSubStr) {
        return this.slice(0, start) + newSubStr + this.slice(start + Math.abs(delCount));
    };
}

function isTelValid(tel) {
    if (!tel)
        return true;
    tel = tel.replace(/ /g, "");
    var re = /^(0|\+33)[1-9](\d){8}$/;
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

