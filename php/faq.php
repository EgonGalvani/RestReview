<?php
    require_once('sessione.php');
    require_once('addItems.php');
   
    $page= (new addItems)->add("../html/faq.html");
    $page = str_replace('><a href="faq.php"><abbr xml:lang="en" title="Frequently Asked Questions">FAQ</abbr></a>',
         ' class="active"><abbr xml:lang="en" title="Frequently Asked Questions">FAQ</abbr>',$page);

    echo $page;
?>