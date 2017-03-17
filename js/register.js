$(document).ready(function () {
    /*
     * Show the infomation of year and faculty 
     */
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
        $('#promo-' + diplomas[i]).focusin(function () {
            $('#error-diplome').html("");
        });
        $('#dept-' + diplomas[i]).focusin(function () {
            $('#error-diplome').html("");
        });
    }

    /**/
    var champs_obligatoire = ['nom', 'prenom', 'mdp', 'confirmer_mdp', 'email'];

    function isEmpty(identity) {
        if (!$("#" + identity).val()) {
            $('#error-' + identity).html("<font color='red'>Ce champs est obligatoire!<\/font>");
            $("#" + identity).css('border-color', 'red');
            return true;
        } else {
            $("#" + identity).css('border-color', 'rgb(204,204,204)');
            return false;
        }
    }

    for (var i = 0; i < champs_obligatoire.length; i++) {
        $('#' + champs_obligatoire[i]).focusout(function () {
            return isEmpty(this.id);
        });
        $('#' + champs_obligatoire[i]).focusin(function () {
            $('#error-' + this.id).html("");
            $(this).css('border-color', 'rgb(102,175,233)');
        });
    }

    /*Check if the email adress is valid*/
    function isEmailValid() {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if ($("#email").val()) {
            if (!re.test($("#email").val().trim())) {
                $('#email').css('border-color', 'red');
                $('#error-email').html("<font color='red'>Adresse e-mail invalide.<\/font>");
                return false;
            }
            $.post('checkUser.php', 'email=' + $("#email").val().trim(), function (response) {
                if (response === 'existed') {
                    $('#email').css('border-color', 'red');
                    $('#error-email').html("<font color='red'>Vous avez saisi une adresse e-mail déjà associée à un compte.<\/font>");
                    return false;
                }
            });
            return true;
        }
        return false;
    }
    $('#email').focusout(isEmailValid);

    /*Check if the telephone number is valid*/
    function isTelValid() {
        var re = /^(\+33 |0|\+33)[1-9]( \d\d|\d\d){4}$/;
        if ($("#num").val()) {
            if (!re.test($("#num").val().trim())) {
                $('#error-num').css('border-color', 'red');
                $('#error-num').html("<font color='red'>Ce format de numéro de téléphone n'est pas reconnu. Veuillez vérifier le numéro.<\/font>");
                return false;
            } else {
                $("#num").val(telFormat($("#num").val()));
                $("#num").css('border-color', 'rgb(204,204,204)');
                return true;
            }
        }
        $("#num").css('border-color', 'rgb(204,204,204)');
        return true;
    }
    $('#num').focusout(isTelValid);
    $('#num').focusin(function () {
        $('#error-num').html("");
        $(this).css('border-color', 'rgb(102,175,233)');
    });



    /*Check if the password is enough long*/
    function isPasswordEnoughLong() {
        if ($("#mdp").val().length < 8 && $("#mdp").val().length > 0) {
            $('#mdp').css('border-color', 'red');
            $('#error-mdp').html("<font color='red'>Les mots de passe courts sont faciles à deviner. Veuillez recommencer en utilisant au moins 8 caractères.<\/font>");
        }
    }
    $('#mdp').focusout(isPasswordEnoughLong);

    /*Check if the two passwords match*/
    function isMatched() {
        if ($("#confirmer_mdp").val() !== $('#mdp').val()) {
            $('#confirmer_mdp').css('border-color', 'red');
            $('#error-confirmer_mdp').html("<font color='red'>Les mots de passe ne correspondent pas. Voulez-vous réessayer ?<\/font>");
        }
    }
    $('#confirmer_mdp').focusout(isMatched);

    function checkAll(diplomas) {
        var allValid = true;
        for (var i = 0; i < champs_obligatoire.length; i++) {
            if (isEmpty(champs_obligatoire[i])) {
                allValid = false;
            }
        }
        if (!(isEmailValid && isPasswordEnoughLong && isMatched && isTelValid)) {
            allValid = false;
        }
        if (!($("#promo-licence").val() || $("#promo-master").val() || $("#promo-doctorat").val())) {
            allValid = false;
            $("#error-diplome").html("<font color='red'>Veuillez choisir au moins un diplôme que vous avez obtenu à l'université de Nanjing et remplir votre promotion ainsi que votre département.<\/font>");
        } else {
            var thisYear = new Date().getFullYear();
            for (var i = 0; i < diplomas.length; i++) {
                var year = $("#promo-" + diplomas[i]).val();
                if (year === "")
                    continue;
                var faculty = $("#dept-" + diplomas[i]).val();
                if ($.isNumeric(year)) {
                    if (!(year <= thisYear && year >= 1949)) {
                        if (year >= 0 && year < 100) {
                            if (year <= thisYear % 1000) {
                                $("#promo-" + diplomas[i]).val((+year) + 2000);
                            } else {
                                $("#promo-" + diplomas[i]).val((+year) + 1900);
                            }
                            if (!faculty) {
                                allValid = false;
                                $("#error-diplome").html("<font color='red'>Veuillez choisir votre département<\/font>");
                            }
                        } else {
                            allValid = false;
                            $("#error-diplome").html("<font color='red'>Veuillez vérifier votre promotion<\/font>");
                        }
                    }
                } else {
                    allValid = false;
                    $("#error-diplome").html("<font color='red'>Veuillez vérifier votre promotion<\/font>");
                }
            }
        }
        return allValid;
    }

    $("#input-valider").click(function () {
        if (checkAll(diplomas)) {
            $.post('register_post.php', {
                nom: $("#nom").val().trim(),
                prenom: $("#prenom").val().trim(),
                mdp: $("#mdp").val(),
                email: $("#email").val().trim(),
                num: $("#num").val().trim(),
                sexe: $("#sexe").val(),
                promo_licence: $("#promo-licence").val().trim(),
                dept_licence: $("#dept-licence").val(),
                promo_master: $("#promo-master").val().trim(),
                dept_master: $("#dept-licence").val(),
                promo_doctorat: $("#promo-doctorat").val().trim(),
                dept_doctorat: $("#dept-licence").val()},
                    function (response) {
                        $('#error-diplome').html(response);
                    });
            $("#success-container").fadeIn(500);
            $("#success-container").css('display', 'flex');
        }
    });

    $("#input-valider").click(function(){
       //$("#success-container").css('display', 'flex');
       
    });

    if (!String.prototype.splice) {
        /**
         * {JSDoc}
         *
         * The splice() method changes the content of a string by removing a range of
         * characters and/or adding new characters.
         *
         * @this {String}
         * @param {number} start Index at which to start changing the string.
         * @param {number} delCount An integer indicating the number of old chars to remove.
         * @param {string} newSubStr The String that is spliced in.
         * @return {string} A new string with the spliced substring.
         */
        String.prototype.splice = function (start, delCount, newSubStr) {
            return this.slice(0, start) + newSubStr + this.slice(start + Math.abs(delCount));
        };
    }

    function telFormat(tel) {
        tel=tel.replace(/ /g, "");
        if (tel.charAt(0) !== '+') {
            tel="+33"+tel.substring(1);
        }
        tel=tel.splice(3,0," ");
        tel=tel.splice(5,0," ");
        tel=tel.splice(8,0," ");
        tel=tel.splice(11,0," ");
        tel=tel.splice(14,0," ");
        return tel;
    }
});