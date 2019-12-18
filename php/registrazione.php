<?php
    session_start();
    require_once("addItems.php");
    if($_SESSION['logged']==true){
        header('location:index.php');
        exit();
    }
    $page=addItems("../html/registrazione.html");
    echo $page;
?>