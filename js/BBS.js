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
            var doc = document.implementation.createHTMLDocument('');
            doc.open();
            doc.write(html);
            var news = doc.querySelectorAll(".content_small li a");
            var url = "http://news.nju.edu.cn/";
            for (var i = 0; i < 10; i++) {
                var text = news[i].text;
                var href = news[i].getAttribute("href");
                var toAppend = "<a href='" + url + href + "' target='_blank'>" + text + "</a>";
                $("#news" + i).append(toAppend);
            }
            doc.close();
        }
    });
});

