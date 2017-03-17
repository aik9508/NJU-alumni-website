<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../css/test.css">
        <link rel="stylesheet" href="../css/master.css">
        <title>Animation Demo</title>
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script>
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
        </script>
    </head>
    <body>
        <div class="animate_div" id="div1">
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
        </div>
    </body>
</html>