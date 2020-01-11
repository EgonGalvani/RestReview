<?php
    header('refresh:5; url= index.php');
    require_once('addItems.php');    

    $page = (new addItems)->add("../html/access_denied.html");
    echo $page; 
?>