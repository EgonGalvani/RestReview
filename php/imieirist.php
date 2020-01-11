<?php
    require_once('sessione.php');
    require_once("addItems.php");

    $page= (new addItems)->add("../html/imieirist.html");
    $page=str_replace('><a href="imieirist.php">I miei ristoranti</a>', 'class="active">I miei ristoranti',$page);

    echo $page;
?>