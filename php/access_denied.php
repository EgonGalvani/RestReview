<?php
    header('refresh:5; url= index.php');
    require_once('addItems.php');    
    echo $page=addItems('../html/access_denied.html');

?>