<?php

    function addItems($subjectPath){
        //Aggiunge menu
        $menu = file_get_contents("../components/menu.html");
        $file_content = file_get_contents($subjectPath);
        //bisogna aggiungere la parte del menu per l'amministratore
        $menu_added=str_replace("%MENU%",$menu,$file_content);
        
        //Aggiunge header
        $header = file_get_contents("../components/header.html");
        $header_added=str_replace("%HEADER%",$header,$menu_added);
        
        //Aggiunge footer
        $footer = file_get_contents("../components/footer.html");
        echo str_replace("%FOOTER%",$footer,$header_added);
       
    }

?>