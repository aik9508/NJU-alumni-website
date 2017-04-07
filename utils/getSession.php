<?php
session_start();
$results=[];
if(isset($_SESSION["currentUser"]) && isset($_POST["id"]) ){
    array_push($results, $_SESSION["currentUser"]["id"]);
}else{
    array_push($results, false);
}
if(isset($_SESSION["lang"]) && isset($_POST["lang"])){
    array_push($results, $_SESSION["lang"]);
}else{
    array_push($results, false);
}
echo json_encode($results);

