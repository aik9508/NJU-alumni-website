$(document).ready(function() {
    var homePhp = "snippets/home-snippet.php";
    var profilePhp = "snippets/profile-snippet.php";
    var actpagePhp = "snippets/activity-snippet.php";

    // Convenience function for inserting for 'select'
    var insertPhp = function(selector, phpfile) {
        var targetElem = $(selector);
        targetElem.load(phpfile);
    };

    var insertHtml = function(selector, html) {
        var targetElem = document.querySelector(selector);
        targetElem.innerHTML = html;
    };

    // Show loading icon inside element identified by 'selector'.
    var showLoading = function(selector) {
        var html = "<div class='text-center'>";
        html += "<img src='images/ajax-loader.gif'></div>";
        insertHtml(selector, html);
    };

    // Return substitute of '{{propName}}'
    // with propValue in given 'string'
    var insertProperty = function(string, propName, propValue) {
        var propToReplace = "{{" + propName + "}}";
        string = string
            .replace(new RegExp(propToReplace, "g"), propValue);
        return string;
    };

    // Remove the class 'active' from home and switch to Menu button
    var switchMenuToActive = function() {
        // Remove 'active' from home button
        var classes = document.querySelector("#navHomeButton").className;
        classes = classes.replace(new RegExp("active", "g"), "");
        document.querySelector("#navHomeButton").className = classes;

        // Add 'active' to menu button if not already there
        classes = document.querySelector("#navMenuButton").className;
        if (classes.indexOf("active") == -1) {
            classes += " active";
            document.querySelector("#navMenuButton").className = classes;
        }
    };


    // Gotop button appears and disappears
    $('#gotop').ready($('#gotop').fadeOut(0)); // Initially non visible
    $(window).scroll(function() {
        if ($(window).scrollTop() > 150) { // 150: when the menu bar disappears
            $("#gotop").fadeIn(400);
        } else {
            $("#gotop").stop().fadeOut(400); // stop the previous animation to prevent conflict
        }
    });
    // Page scrolls to top when gotop button clicked
    $("#gotop").click(function() {
        $("html,body").animate({ scrollTop: "0px" }, 200); // during 200ms
    });

    $('#button-inscription').mouseover(function() {
        $("#popup-login").stop(true).fadeIn();
    });

    $('#button-inscription').mouseout(function() {
        $("#popup-login").stop(true).fadeOut();
    });
    $('#button-lang').mouseover(function() {
        var popup = document.getElementById("popup-lang");
        popup.classList.toggle("show");
    });
    $('#button-lang').mouseout(function() {
        var popup = document.getElementById("popup-lang");
        popup.classList.toggle("show");
    });

    $('#button-signup').click(function() {
        window.open('utils/register-zh.php', '_self');
    });

    $('#button-signin').click(function() {
        $('#loginform-container').css('display', 'block');
    });

    $('#close-login').click(function() {
        $('#loginform-container').css('display', 'none');
    });

    $('#loginform-container').click(function(event) {
        if (event.target == this) {
            $('#loginform-container').css('display', 'none');
        }
    });
    $('#profile-menu>ul>li').each(function(i) {
        $(this).attr('id', 'profile-item' + i);
        $('#profile-item' + i).click(function() {
            $($('.profile-content-title>span')[1]).html($('#profile-item' + i + ">span")[1].innerHTML);
            $('#profile-content').load("snippets/" + $('#profile-item' + i + ">span")[1].getAttribute("name") + "-snippet.php");
        });
    });

    $('#activity-menu>ul>li').each(function(i) {
        $(this).attr('id', 'activity-item' + i);
        $('#activity-item' + i).click(function() {
            $($('.activity-content-title>span')[1]).html($('#activity-item' + i + ">span")[1].innerHTML);
            $('#activity-content').load("snippets/" + $('#activity-item' + i + ">span")[1].getAttribute("name") + "-snippet.php");
        });
    });

    $(document).on("click", ".activity-modal-link", function() {
        $(".modal-box").css('display', 'block');
        var num = $(this).attr('num');
        $(".modal-content").load("snippets/activity/" + num + ".php");
    });

    $(document).on("click", ".photo-modal-link", function() {  
        var num = $(this).attr('num');
        $("#gallery-container").load("snippets/photo/" + num + ".php");
    });

    $(document).on("click", ".modal-box", function(event) {
        if (event.target == this) {
            $(".modal-box").css('display', 'none');
            $("#gallery").html("");
        }
    });


});