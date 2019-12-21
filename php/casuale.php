<?php

    require_once('sessione.php');

    require_once("addItems.php");
    $page=addItems('../html/casuale.html');

    $page=str_replace('<li><a href="casuale.php">Ristorante casuale</a></li>',
                    '<li class="active">Ristorante casuale</li>',$page);

    echo $page;

?>