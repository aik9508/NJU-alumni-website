<!DOCTYPE html>
<html>
<head>
    <style>
        /* Popup container - can be anything you want */
        .popup-trigger {
            position: relative;
            display: inline-block;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        body {
            background-color: #2aabd2;
        }

        /* The actual popup */
        .popup-trigger .popup-content {
            visibility: hidden;
            width: 160px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 8px 0;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -80px;
        }

        /* Popup arrow */
        .popup-trigger .popup-content::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;
        }

        /* Toggle this class - hide and show the popup */
        .popup-trigger .show {
            visibility: visible;
            -webkit-animation: fadeIn 1s;
            animation: fadeIn 1s;
        }

        /* Add animation (fade in the popup) */
        @-webkit-keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }

        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity:1 ;}
        }
    </style>
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/personal.css">

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/ajax-utils.js"></script>
</head>
<body style="text-align:center">

<h2>Popup</h2>
<div class="container">
    <div class="row">
        <div class="col-lg-3 pull-right">
            <div class="popup-trigger" onmouseover="show()" onmouseout="show()">
                <div id="tt" class="glyphicon glyphicon-globe"></div>
                <div class="popup-content" id="popup-login">A very Simple Popup!</div>
            </div>
        </div>
    </div>
</div>


<script>
    // When the user clicks on div, open the popup
    function show() {
        var popup = document.getElementById("popup-login");
        popup.classList.toggle("show");
    }
</script>

</body>
</html>
