<?php
    require_once('sessione.php');
    require_once('addItems.php');
    require_once('connessione.php');
    if($_SESSION['permesso']!="Admin"){
        header('location: access_denied.php');
    }
    $page =(new addItems)->add("../html/pannello_amm.html");
    $error="";
    
    $page = str_replace('%ERROR%', $error,$page);
    echo $page;
?>