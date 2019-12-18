<?php
    session_start();
    require_once("addItems.php");
    if($_SESSION['logged']==true){
        header('location:index.php');
        exit();
    }
    addItems("../html/registrazione.html");

?>