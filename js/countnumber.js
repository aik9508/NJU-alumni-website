/**
 * Created by shiwen on 2/23/2017.
 */
(function(global) {

    function isShow($el) {
        var winH = $(window).height(), //获取窗口高度
            scrollH = $(window).scrollTop(), //获取窗口滚动高度
            top = $el.offset().top; //获取元素距离窗口顶部偏移高度
        if (top < scrollH + winH) {
            return true; //在可视范围
        } else {
            return false; //不在可视范围
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


})(window);