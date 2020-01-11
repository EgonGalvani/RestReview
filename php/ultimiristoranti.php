<?php
    require_once('sessione.php');
    require_once('addItems.php');
  
    $page= (new addItems)->add("../html/ultimiristoranti.html");
    $page = str_replace('><a href="ultimiristoranti.php">Ultimi ristoranti inseriti</a>', 'class="active">Ultimi ristoranti inseriti',$page);

    echo $page;
?>