(function (global) {
    var homePhp = "snippets/home-snippet.php";
    var profilePhp = "snippets/profile-snippet.php";

// Convenience function for inserting innerHTML for 'select'
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


    // $(document).ready(function () {
    //     showLoading("#main-content");
    //     $ajaxUtils.sendGetRequest(
    //         homePhp,
    //         insertPhp("#main-content", homePhp),
    //         false);
    // });
    $('#button-accueil').click(function () {
        showLoading("#main-content");
        $ajaxUtils.sendGetRequest(
            homePhp,
            insertPhp("#main-content", homePhp),
            false);
    });

    $('#button-profile').click(function () {
        showLoading("#main-content");
        $ajaxUtils.sendGetRequest(
            profilePhp,
            insertPhp("#main-content", profilePhp),
            false);
    });


    $(window).scroll(function () {  //只要窗口滚动,就触发下面代码
        // var scrollt = document.documentElement.scrollTop + document.body.scrollTop; //获取滚动后的高度
        if ($(window).scrollTop() > 150) {  //判断滚动后高度超过200px,就显示
            $("#gotop").fadeIn(400); //淡入
        } else {
            $("#gotop").stop().fadeOut(400); //如果返回或者没有超过,就淡出.必须加上stop()停止之前动画,否则会出现闪动
        }
    });
    $("#gotop").click(function () { //当点击标签的时候,使用animate在200毫秒的时间内,滚到顶部
        $("html,body").animate({scrollTop: "0px"}, 200);
    });

})(window);
