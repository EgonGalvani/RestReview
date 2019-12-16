<?php
    session_start();
    $file_content=file_get_contents('../html/registrazione.html');

    require_once("addItems.php");
    addItems("../html/registrazione.html");

?>