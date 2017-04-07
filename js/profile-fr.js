$(document).ready(function () {
    var inputs = new Array($("input[name='nom']"),
            $("input[name='prenom']"),
            $("input[name='email']"),
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

    $(".cropper-wrapper").append("<img id='source_photo' class='display-none' alt='source'/>");

    $("#source_photo")[0].onload = function () {
        if ($("#imgFile")[0].files && $("#imgFile")[0].files[0]) {
            var file = $("#imgFile")[0].files[0];
            if (file.size > 300000) {
                var quality = 300000 * 100 / file.size;
                var photo_obj = jic.compress($(this)[0], quality, file.type).src;
                $("#temp-container").attr("src", photo_obj);
            }
            $('#temp-container').cropper({
                viewMode: 1,
                dragMode: 'move',
                aspectRatio: 1,
                autoCropArea: 0.5,
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
            var photo_obj = window.URL.createObjectURL(file);
            $("#source_photo").attr("src", photo_obj);
        }
    });

    $('#upload-photo').click(function () {
        if (!$(this).parent("li").hasClass("disabled")) {
            console.log("OK2");
            var croppedCanvas = $("#temp-container").cropper('getCroppedCanvas');
            var croppng = croppedCanvas.toDataURL("image/png");
            $("#original-photo").attr("src", croppng);
            $("#photo").attr("src", croppng);
            $("#temp-container").hide();
            $('#temp-container').cropper('destroy');
            $("#original-photo").show();
            $("#change-photo").parent("li").removeClass('disabled');
            $("#upload-photo").parent("li").addClass('disabled');
            $("#cancel-photo").parent("li").addClass('disabled');
            $('#imgFile').val("");
            $.post("utils/save_photo.php", {
                pngimageData: croppng
            }, function (response) {
                console.log("OK3");
                console.log(response);
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
        console.log("OK");
        if (isAllValid()) {
            console.log("valid");
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
                            $("#profile-wrapper").load("utils/profile-fr.php");
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

    inputs[0].autocheck(isNonEmpty, toolTipError(inputs[0], 'Le nom ne doit pas être vide.'));
    inputs[1].autocheck(isNonEmpty, toolTipError(inputs[1], 'Le prénom ne doit pas être vide.'));
    inputs[2].autocheck(isEmailValid, toolTipError(inputs[2], 'Adresse e-mail invalide.'));
    inputs[3].autocheck(isPromoValid, toolTipError(inputs[3], 'Promotion invalide'));
    inputs[4].autocheck(isPromoValid, toolTipError(inputs[4], 'Promotion invalide'));
    inputs[5].autocheck(isPromoValid, toolTipError(inputs[5], 'Promotion invalide'));
    inputs[6].autocheck(isTelValid, toolTipError(inputs[6], "Ce format de numéro de téléphone n'est pas reconnu."));
    inputs[7].autocheck(isEntrepriseValid, toolTipError(inputs[7], "Veuillez indiquer votre entreprise."));
    inputs[8].autocheck(isFonctionValid, toolTipError(inputs[8], "Veuillez indiquer votre entreprise."));

    $("input[name='ancien-mdp']").autocheck(isNonEmpty, toolTipError($(this), "Veuillez entrer votre ancien mot de passe."));
    $("input[name='nouveau-mdp']").focusin(function () {
        $(this).css('border-color', 'rgb(102,175,233)');
    });
    $("input[name='nouveau-mdp']").focusout(function () {
        if (!isNonEmpty($(this).val())) {
            $(this).css('border-color', 'red');
            toolTipError($(this), "Le nouveau mot de passe ne peut pas être vide.")();
        } else if (!isPswValid($(this).val())) {
            $(this).css('border-color', 'red');
            toolTipError($(this), "Les mots de passe courts sont faciles à deviner. Veuillez recommencer en utilisant au moins 8 caractères.")();
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
            toolTipError($(this), "Veuillez confirmer votre mot de passe.")();
        } else if (!isPswCorrect($(this).val())) {
            $(this).css('border-color', 'red');
            toolTipError($(this), "Les mots de passe ne correspondent pas. Voulez-vous réessayer?")();
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
            alert("Veuillez choisir au moins un diplôme que vous avez obtenu à l'université de Nanjing et remplir votre promotion ainsi que votre département.");
        }
    }
    return allValid;
}


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

