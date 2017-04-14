$(document).ready(function () {
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

    // Get the language attibute of current page via $_GET.
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


    // Block of functions for the counting visitors and alumni
    function isShow($el) {
        var winH = $(window).height(),
            scrollH = $(window).scrollTop(), 
            top = $el.offset().top;
        if (top < scrollH + winH) {
            return true;
        } else {
            return false;
        }
    };

    var alumni = $('#alumni-number').attr('data-count');
    var visitors = $('#visitor-number').attr('data-count');
    var fun = function() {
        if (isShow($('#alumni-number'))) {
            var i = 0;
            var step1 = Math.floor(alumni / 200)+1;
            var count_1 = setInterval(function() {
                $('#alumni-number').html(i.toLocaleString('fr-FR'));
                i = i + step1;
                if (i > alumni) {
                    clearInterval(count_1);
                    $('#alumni-number').html(parseInt(alumni, 10).toLocaleString('fr-FR'));

                }
            }, 2);

            var j = 0;
            var step2 = Math.floor(visitors / 200)+1;
            var count_2 = setInterval(function() {
                $('#visitor-number').html(j.toLocaleString('fr-FR'));
                j = j + step2;
                if (j > visitors) {
                    clearInterval(count_2);
                    $('#visitor-number').html(parseInt(visitors, 10).toLocaleString('fr-FR'));
                }
            }, 2);

            window.removeEventListener('scroll', fun);
        }
    }
    window.addEventListener("scroll", fun);
    // Here ends functions for the counting.


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
        $("html,body").animate({
            scrollTop: "0px"
        }, 200); // during 200ms
    });

    $('#button-inscription').mouseover(function () {
        $("#popup-login").stop(true).fadeIn();
    });

    $('#button-inscription').mouseout(function () {
        $("#popup-login").stop(true).fadeOut();
    });
    $('#button-lang').mouseover(function () {
        var popup = document.getElementById("popup-lang");
        popup.classList.toggle("show");
    });
    $('#button-lang').mouseout(function () {
        var popup = document.getElementById("popup-lang");
        popup.classList.toggle("show");
    });

    $('#button-signup').click(function () {
        window.open('utils/register.php?lang='+getLang(), '_self');
    });

    $('#button-signin').click(function () {
        $('#loginform-container').css('display', 'block');
    });

    $('#close-login').click(function () {
        $('#loginform-container').css('display', 'none');
    });

    $('#loginform-container').click(function (event) {
        if (event.target == this) {
            $('#loginform-container').css('display', 'none');
        }
    });
    $('#profile-menu>ul>li').each(function (i) {
        $(this).attr('id', 'profile-item' + i);
        $('#profile-item' + i).click(function () {
            var lang = getLang();
            $($('.profile-content-title>span')[1]).html($('#profile-item' + i + ">span")[1].innerHTML);
            $('#profile-content').load("snippets/" + $('#profile-item' + i + ">span")[1].getAttribute("data-name") + "-snippet-" + lang + ".php");
        });
    });

    $('.profile-head-menu').each(function (i) {
        $(this).attr('id', 'profile-head-item' + i);
        $('#profile-head-item' + i).click(function () {
            $(".accordion-menu").css('display', 'none');
            var lang = getLang();
            $($('.profile-content-title>span')[1]).html($('#profile-head-item' + i + ">span")[1].innerHTML);
            $('#profile-content').load("snippets/" + $('#profile-head-item' + i + ">span")[1].getAttribute("data-name") + "-snippet-" + lang + ".php");
        });
    });

    $('.activity-head-menu').each(function (i) {
        $(this).attr('id', 'activity-head-item' + i);
        $('#activity-head-item' + i).click(function () {
            $(".accordion-menu").css('display', 'none');
            var lang = getLang();
            $($('.activity-content-title>span')[1]).html($('#activity-head-item' + i + ">span")[1].innerHTML);
            $('#activity-content').load("snippets/" + $('#activity-head-item' + i + ">span")[1].getAttribute("data-name") + "-snippet.php", {
                "lang": lang
            });
        });
    });

    $('#activity-menu>ul>li').each(function (i) {
        $(this).attr('id', 'activity-item' + i);
        $('#activity-item' + i).click(function () {
            var lang = getLang();
            $($('.activity-content-title>span')[1]).html($('#activity-item' + i + ">span")[1].innerHTML);
            $('#activity-content').load("snippets/" + $('#activity-item' + i + ">span")[1].getAttribute("data-name") + "-snippet.php", {
                "lang": lang
            });
        });
    });

    $(document).on("click", ".activity-modal-link", function () {
        var lang = getLang();
        var num = $(this).attr('data-num');
        $(".modal-content").load("snippets/activity/" + num + "-" + lang + ".php");
    });

    $(document).on("click", ".photo-modal-link", function () {
        var num = $(this).attr('data-num');
        $("#gallery-container").load("snippets/photo/" + num + ".php");
    });

    $(document).on("click", ".modal-box", function (event) {
        if (event.target == this) {
            $(".modal-box").css('display', 'none');
            $("#gallery").html("");
        }
    });

    $(".accordion").click(function () {
        if ($(".accordion-menu").css('display') == 'none') {
            $(".accordion-menu").css('display', 'block');
        } else {
            $(".accordion-menu").css('display', 'none');
        }
    });

    $('#wrap-button').click(function (e) {
        e.stopPropagation();
        if ($("#wrap-menu").offset().left != 0) {
            $("#overal-container").css('left', '190px');
            $("#wrap-menu").css('left', '0').css('height', $(window).outerHeight());
            setTimeout(function () {
                $("#overal-container").css('position', 'fixed').css('overflow-y', 'scroll');
            }, 600);
            $("#overal-container").css('opacity', '0.8');

        } else {
            $("#overal-container").css('left', '0');
            $("#wrap-menu").css('left', '-190px');
            setTimeout(function () {
                $("#overal-container").css('position', 'absolute').css('overflow-y', 'auto');
            }, 600);
            $("#overal-container").css('opacity', '1.0');
        }
    });

    $('#wrap-menu').click(function (e) {
        e.stopPropagation();
    });

    $(window).resize(function () {
        if ($(window).outerHeight() > $("#wrap-menu").height()) {
            $("#wrap-menu").css('height', $(window).outerHeight());
        }
        if ($(window).outerWidth() > 767) {
            $("#overal-container").css('left', '0');
            $("#wrap-menu").css('left', '-190px');
            setTimeout(function () {
                $("#overal-container").css('position', 'absolute').css('overflow-y', 'auto');
            }, 600);
            $("#overal-container").css('opacity', '1.0');
        }
    });

    $('body').click(function () {
        if ($("#wrap-menu").offset().left == 0) {
            $("#overal-container").css('left', '0');
            $("#wrap-menu").css('left', '-190px');
            setTimeout(function () {
                $("#overal-container").css('position', 'absolute').css('overflow-y', 'auto');
            }, 600);
            $("#overal-container").css('opacity', '1.0');
        }
    });

    $(window).resize(function () {
        if ($(window).outerHeight() > $("#wrap-menu").height()) {
            $("#wrap-menu").css("height", $(window).outerHeight());
        }
    });
    
    $("#wrap-signin").click(function(){
        $('#wrap-button').click();
        $('#button-signin').click();
    });
    
    $("#wrap-signout").click(function(){
        $('#button-signout').click();
    });
    
    $("#wrap-signup").click(function(){
        $('#wrap-button').click();
        $('#button-signup').click();
    });

});