<?php
    session_start();
    require_once("connessione.php");
    require_once("addItems.php");
    addItems("../html/index.html");
?>