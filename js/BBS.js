//$(document).ready(function () {
//    $.getJSON("http://bbs.nju.edu.cn",
//    function(data){
//        console.log(data);
//    });
//}
//);
//url='https://www.frankiz.net/';
//
//function createCORSRequest(method, url) {
//  var xhr = new XMLHttpRequest();
//  if ("withCredentials" in xhr) {
//    // Check if the XMLHttpRequest object has a "withCredentials" property.
//    // "withCredentials" only exists on XMLHTTPRequest2 objects.
//    xhr.open(method, url, true);
//
//  } else if (typeof XDomainRequest !== "undefined") {
//
//    // Otherwise, check if XDomainRequest.
//    // XDomainRequest only exists in IE, and is IE's way of making CORS requests.
//    xhr = new XDomainRequest();
//    xhr.open(method, url);
//
//  } else {
//
//    // Otherwise, CORS is not supported by the browser.
//    xhr = null;
//
//  }
//  return xhr;
//}
//
//var xhr = createCORSRequest('GET', url);
//if (!xhr) {
//  throw new Error('CORS not supported');
//}
//xhr.send();

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
            var toAppend="<a href='"+url+href+"' target='_blank'>"+text+"</a>";
            $("#news"+(i+1)).append(toAppend);
        }
        doc.close();
    }
});