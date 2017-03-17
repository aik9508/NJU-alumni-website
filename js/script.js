(function (global) {
    var homePhp = "snippets/home-snippet.php";
    var profilePhp = "snippets/profile-snippet.php";
    var actpagePhp = "snippets/activity-snippet.php";

// Convenience function for inserting for 'select'
    var insertPhp = function (selector, phpfile) {
        var targetElem = $(selector);
        targetElem.load(phpfile);
    };

    var insertHtml = function (selector, html) {
        var targetElem = document.querySelector(selector);
        targetElem.innerHTML = html;
    };

// Show loading icon inside element identified by 'selector'.
    var showLoading = function (selector) {
        var html = "<div class='text-center'>";
        html += "<img src='images/ajax-loader.gif'></div>";
        insertHtml(selector, html);
    };

// Return substitute of '{{propName}}'
// with propValue in given 'string'
    var insertProperty = function (string, propName, propValue) {
        var propToReplace = "{{" + propName + "}}";
        string = string
            .replace(new RegExp(propToReplace, "g"), propValue);
        return string;
    };

// Remove the class 'active' from home and switch to Menu button
    var switchMenuToActive = function () {
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



    // $('#button-accueil').click(function () {
    //     showLoading("#main-content");
    //     $ajaxUtils.sendGetRequest(
    //         homePhp,
    //         function () {
    //             $('#main-content').load(homePhp)
    //         },
    //         false);
    // });
    //
    // // Load the profile page when menu button clicked
    // $('#button-profile').click(function () {
    //     showLoading("#main-content");
    //     $ajaxUtils.sendGetRequest(
    //         profilePhp,
    //         function () {
    //             $('#main-content').load(profilePhp)
    //         },
    //         false);
    // });
    //
    // // Load the activity page when menu button clicked
    // $('#button-activity').click(function () {
    //     showLoading("#main-content");
    //     $ajaxUtils.sendGetRequest(
    //         actpagePhp,
    //         function () {
    //             $('#main-content').load(actpagePhp)
    //         },
    //         false);
    // });

    // // Page scrolls to the follow-links when the contact button clicked
    // $('#button-contact').click(function(){
    //     var height = $('.follow-links').offset().top;
    //     var scrolleddistance = $(window).scrollTop();
    //     var scrolldistance = (height-scrolleddistance);
    //     $("html,body").animate({scrollTop: scrolldistance.toString() + 'px'}, 200);
    // });

    // Gotop button appears and disappears
    $('#gotop').ready($('#gotop').fadeOut(0)); // Initially non visible
    $(window).scroll(function () {
        if ($(window).scrollTop() > 150) { // 150: when the menu bar disappears
            $("#gotop").fadeIn(400);
        } else {
            $("#gotop").stop().fadeOut(400); // stop the previous animation to prevent conflict
        }
    });
    // Page scrolls to top when gotop button clicked
    $("#gotop").click(function () {
        $("html,body").animate({scrollTop: "0px"}, 200);// during 200ms
    });

    $('#button-inscription').mouseover(function () {
        var popup = document.getElementById("popup-login");
        popup.classList.toggle("show");
    });
    $('#button-inscription').mouseout(function () {
        var popup = document.getElementById("popup-login");
        popup.classList.toggle("show");
    });
    $('#button-lang').mouseover(function () {
        var popup = document.getElementById("popup-lang");
        popup.classList.toggle("show");
    });
    $('#button-lang').mouseout(function () {
        var popup = document.getElementById("popup-lang");
        popup.classList.toggle("show");
    });

    $('#button-signin').click(function () {
        $('#loginform-container').css('display','block');
    });

    $('#close-login').click(function () {
        $('#loginform-container').css('display','none');
    });

    $('#loginform-container').click(function (event) {
        if (event.target == this){
            $('#loginform-container').css('display','none');
        }
    });

})(window);
