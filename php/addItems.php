<?php

    function addItems($subjectPath){
        //Aggiunge menu
        $menu = file_get_contents("../components/menu.html");
        $file_content = file_get_contents($subjectPath);
        //Aggiunta menu generico
        $menu_added=str_replace("%MENU%",$menu,$file_content);
        if(isset($_SESSION['permesso'])){
            //Aggiunta menu admin
            if($_SESSION['permesso']==="Admin"){
                $toAdd="
                <li class=\"active\" xml:lang=\"en\">Home</li>
                <li><a href=\"../php/pannello_amministratore.php\">Pannello amministratore</a></li>
                ";
                $menu_added=str_replace("<li class=\"active\" xml:lang=\"en\">Home</li>",$toAdd,$menu_added);
            }
            //Aggiunta menu ristoratore
            if($_SESSION['permesso']==="Ristoratore"){
                $toAdd="
                <li class=\"active\" xml:lang=\"en\">Home</li>
                <li><a href=\"../php/mio_profilo.php\">Il mio profilo</a></li>
                <li><a href=\"../php/miei_ristoranti.php\">I miei ristoranti</a></li>
                ";
                $menu_added=str_replace("<li class=\"active\" xml:lang=\"en\">Home</li>",$toAdd,$menu_added);
            }
            //Aggiunta menu utente loggato
            if($_SESSION['permesso']==="Utente"){
                $toAdd="
                <li class=\"active\" xml:lang=\"en\">Home</li>
                <li><a href=\"../php/mio_profilo.php\">Il mio profilo</a></li>
                <li><a href=\"../php/mie_recensioni.php\">Le mie recensioni</a></li>
                ";
                $menu_added=str_replace("<li class=\"active\" xml:lang=\"en\">Home</li>",$toAdd,$menu_added);
            }
        }
        
        //Aggiunge header
        $header = file_get_contents("../components/header.html");
        if($_SESSION['logged']){            
            $header=str_replace("<a href=\"../php/login.php\" class=\"a_btn\">LOGIN</a>",
                                    "toReplace",$header);
            $header=str_replace("<a href=\"../php/registrazione.php\" class=\"a_btn\">REGISTRAZIONE</a>",
                                    "",$header);
            $header=str_replace("toReplace","<a href=\"../php/logout.php\" class=\"a_btn\">LOGOUT</a>",$header);
        }
        $header_added=str_replace("%HEADER%",$header,$menu_added);
        
        //Aggiunge footer
        $footer = file_get_contents("../components/footer.html");
        echo str_replace("%FOOTER%",$footer,$header_added);
       
    }

?>