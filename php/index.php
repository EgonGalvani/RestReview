<?php
    session_start();
    require_once("connessione.php");
    require_once("addItems.php");
   
    $page= (new addItems)->add("../html/index.html");
    $page = str_replace('><a href="index.php">Home</a>', 'class="active">Home',$page);

    echo $page;
?>