<?php
    session_start();
    require_once("connessione.php");
    require_once("addItems.php");
    $page= addItems("../html/index.html");
    echo $page;
?>