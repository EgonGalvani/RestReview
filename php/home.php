<?php
    session_start();
    require_once("connessione.php");
        $file_content = file_get_contents("../html/index.html");
        $menu = file_get_contents("../components/menu.html");
        //bisogna aggiungere la parte del menu per l'amministratore

        echo str_replace("%MENU%",$menu,$file_content);
    $connessione->close();

?>