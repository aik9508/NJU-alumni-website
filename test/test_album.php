<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../css/test.css">
        <link rel="stylesheet" href="../css/master.css">
        <title>Animation Demo</title>
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script>
            $(document).ready(function(){
                $(window).scroll(function(){
                    var masks=$(".mask");
                    var containers=$(".block_container");
                    var inners=$(".content");
                    var scrollLeft=$(this).scrollLeft();
                    for(var i=0;i<masks.length;i++){
                        $(masks[i]).css("left",(($(containers[i]).offset().left)-scrollLeft)*0.5+70);
                        $(inners[i]).css("background-position-x",($(containers[i]).offset().left)-scrollLeft-400);
                    }
                });
            });
        </script>
<!--        <script>
            $(document).ready(function () {
                setTimeout(function () {
                    $('#div1').show();
                }, 1000);
                setTimeout(function () {
                    $('#div2').show();
                }, 1200);
                setTimeout(function () {
                    $('#div3').show();
                }, 1400);
                setTimeout(function () {
                    $('#div4').show();
                }, 1600);
                setTimeout(function () {
                    $('#div5').show();
                }, 1800);
                setTimeout(function () {
                    $('#div6').show();
                }, 2000);
            });
        </script>-->
    </head>
    <body>
        <!--        <div class="animate_div" id="div1">
                    CSS3
                </div>
                <div class="animate_div" id="div2">
                    CSS3
                </div>
                <div class="animate_div" id="div3">
                    CSS3
                </div>
                <div class="animate_div" id="div4">
                    CSS3
                </div>
                <div class="animate_div" id="div5">
                    CSS3
                </div>
                <div class="animate_div" id="div6">
                    CSS3
                </div>-->
        <div class="wrap">
        <div class="block_container">
            <div class="album"><img class="img-responsive" src="../sources/葛布.jpg" alt="goddess"></div>
            <div class="mask">
                <div class="inner">
                    <div class="content"></div>
                </div>
            </div>
        </div>
        <div class="block_container">
            <div class="album"><img class="img-responsive" src="../sources/葛布.jpg" alt="goddess"></div>
            <div class="mask" id="mask2">
                <div class="inner" id="content2"><div class="content"></div></div>
            </div>
        </div>
        <div class="block_container">
            <div class="album"><img class="img-responsive" src="../sources/葛布.jpg" alt="goddess"></div>
            <div class="mask">
                <div class="inner"><div class="content"></div></div>
            </div>
        </div>
        </div>
    </body>
</html>