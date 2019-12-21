<?php

    require_once('sessione.php');

    require_once('addItems.php');
    $page=addItems('../html/chisiamo.html');

    $page=str_replace('<li><a href="chisiamo.php">Chi Siamo</a></li>',
                '<li class="active">Chi Siamo</li>',$page);

    echo $page;

?>