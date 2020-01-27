<?php
    require_once('sessione.php');
    require_once('addItems.php');

    $page= (new addItems)->add("../html/chisiamo.html");
    $page=str_replace('><a href="chisiamo.php">Chi Siamo</a>', ' class="active">Chi Siamo',$page);
    
    echo $page;
?>