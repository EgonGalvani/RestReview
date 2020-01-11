<?php 
    require_once('sessione.php');
    require_once('addItems.php');

    $page= (new addItems)->add("../html/ins_recensione.html");   

    echo $page;
?>