<?php
    require_once('sessione.php');
    require_once('addItems.php');

    $page= (new addItems)->add("../html/regolamento.html");
    $page = str_replace('><a href="regolamento.php">Regolamento</a>', 'class="active">Regolamento',$page);

    echo $page;
?>