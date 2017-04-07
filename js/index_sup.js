$(document).ready(function () {
    $("#userName").click(function () {
        $.post("utils/getSession.php", {
            id: true,
            lang: true
        }, function (response) {
            var results=$.parseJSON(response);
            if (results[0]) {
                var lang = results[1];
                if (!lang || lang != "fr") {
                    lang = "zh";
                }
                $("body").append("<div id='profile-wrapper' class='vertical-center-parent background-wrapper'></div>");
                $("#profile-wrapper").load("utils/profile-"+lang+".php");
            }
        });
    });

    $(document).on("click", "#profile-wrapper", function (event) {
        if (event.target === this) {
            $(this).remove();
        }
    });

    $("#login-submit").click(function () {
        $.post("utils/checkUser.php", {
            email: $("input[name=email]").val().trim(),
            psw: $("input[name=psw]").val().trim()
        }, function (response) {
            if (!response) {
                $("#error-info").css("color", "red").html("Email ou mot de passe incorrect. Veuillez réessayer.");
            } else {
                $("#loginform").attr("action", "");
                $("#loginform").submit();
            }
        });
    });
});