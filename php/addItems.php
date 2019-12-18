<?php
    //$subjectPath= pagina html a cui aggiungere le cose
    //$addMenu= true di default, passare false come parametro se non si vuole aggiungere il menu
    //ritorna una stringa con il contenuto della pagina modificata
    function addItems($subjectPath,$addMenu=true){
        $file_content = file_get_contents($subjectPath);
        if($addMenu){
        //Aggiunge menu
        $menu = file_get_contents("../components/menu.html");
        //Aggiunta menu generico
        $file_content=str_replace("%MENU%",$menu,$file_content);
        if(isset($_SESSION['permesso'])){
            //Aggiunta menu admin
            if($_SESSION['permesso']==="Admin"){
                $toAdd='
                <li xml:lang="en"><a href="../php/index.php">Home</a></li>
                <li><a href="../php/pannello_amministratore.php">Pannello amministratore</a></li>
                ';
                $file_content=str_replace('<li class="active" xml:lang="en">Home</li>',$toAdd,$file_content);
            }
            //Aggiunta menu ristoratore
            if($_SESSION['permesso']==="Ristoratore"){
                $toAdd='
                <li xml:lang="en"><a href="../php/index.php">Home</a></li>
                <li><a href="../php/mio_profilo.php">Il mio profilo</a></li>
                <li><a href="../php/miei_ristoranti.php">I miei ristoranti</a></li>
                ';
                $file_content=str_replace('<li class="active" xml:lang="en">Home</li>',$toAdd,$file_content);
            }
            //Aggiunta menu utente loggato
            if($_SESSION['permesso']==="Utente"){
                $toAdd='
                <li xml:lang="en"><a href="../php/index.php">Home</a></li>
                <li><a href="../php/mio_profilo.php">Il mio profilo</a></li>
                <li><a href="../php/mie_recensioni.php">Le mie recensioni</a></li>
                ';
                $file_content=str_replace('<li class="active" xml:lang="en">Home</li>',$toAdd,$file_content);
            }
        }
        }       
        
        //Aggiunge header
        $header = file_get_contents("../components/header.html");
        if(isset($_SESSION['logged'])&&$_SESSION['logged']){            
            $header=str_replace('<a href="../php/login.php" class="a_btn">LOGIN</a>',
                                    "toReplace",$header);
            $header=str_replace('<a href="../php/registrazione.php" class="a_btn">REGISTRAZIONE</a>',
                                    "",$header);
            $header=str_replace("toReplace",'<a href="../php/logout_script.php" class="a_btn">LOGOUT</a>',$header);
        }
        if(basename($_SERVER["REQUEST_URI"])=="login.php"){
            $header ='<div id="header">
            <h1 id="title">RestReview</h1>
            <a id="hamburger" href="#menu" class="a_btn">MENU</a>
            <a href="../php/registrazione.php" class="a_btn">REGISTRAZIONE</a>
            </div>';
        }
        if(basename($_SERVER["REQUEST_URI"])=="registrazione.php"){
            $header ='<div id="header">
            <h1 id="title">RestReview</h1>
            <a id="hamburger" href="#menu" class="a_btn">MENU</a>
            <a href="../php/login.php" class="a_btn">LOGIN</a>
            </div>';
        }
        $file_content=str_replace("%HEADER%",$header,$file_content);
        
        //Aggiunge footer
        $footer = file_get_contents("../components/footer.html");
        return str_replace("%FOOTER%",$footer,$file_content);
       
    }