//cross domain screen scraping script

$(document).ready(function () {
    $("#information>ul>li").each(function(i){
       $(this).attr("id","news"+i) ;
    });
    
    $.ajax({
        type: "POST",
        url: "utils/bbs.php",
        dataType: "html",
        success: function (html)
        {
            var doc = $.parseHTML(html);
            var news = $(".content_small li a", doc);
            var url = "http://news.nju.edu.cn/";
            for (var i = 0; i < 10; i++) {
                var text = $(news[i]).text();
                var href = $(news[i]).attr("href");
                var toAppend = "<a href='" + url + href + "' target='_blank'>" + text + "</a>";
                $("#news" + i).append(toAppend);
            }
        }
    });
});

