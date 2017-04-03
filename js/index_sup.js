
$(document).ready(function () {
    var userId = $("#userName").attr("userid");
    $("#userName").click(function () {
        if (userId) {
            window.open("utils/profile_entire.php", "_blank");
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
                $("#loginform").attr("action","index.php");
                $("#loginform").submit();
            }
        });
    }
    );
});


