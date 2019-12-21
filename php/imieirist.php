<?php

    require_once('sessione.php');

    require_once("addItems.php");
    $page=addItems('../html/imieirist.html');

    $page=str_replace('<li><a href="imieirist.php">I miei ristoranti</a></li>',
                '<li class="active">I miei ristoranti</li>',$page);

    echo $page;

?>