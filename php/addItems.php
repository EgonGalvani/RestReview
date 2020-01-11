<?php
    //n$subjectPath= pagina html a cui aggiungere le cose
    // $addMenu= true di default, passare false come parametro se non si vuole aggiungere il menu
    // ritorna una stringa con il contenuto della pagina modificata
    function addItems($subjectPath,$addMenu=true){
        $file_content = file_get_contents($subjectPath);
        
        // aggiunge menù 
        if($addMenu){

            // menù di base 
            $tabindex = 1; 
            $menu = '<ul><li xml:lang="en" tabindex="' . $tabindex++ . '"><a href="index.php">Home</a></li>'; 
          
            if(isset($_SESSION['permesso'])){
               
                switch($_SESSION['permesso']) {
                    case 'Admin': 
                            $menu .= '<li tabindex="' . $tabindex++ . '"><a href="pannello_amministratore.php">Pannello amministratore</a></li>';
                        break; 
                    case 'Ristoratore': 
                            $menu .= '<li tabindex="' . $tabindex++ . '"><a href="profilo.php">Il mio profilo</a></li>
                                       <li tabindex="' . $tabindex++ . '"><a href="imieirist.php">I miei ristoranti</a></li>'; 
                        break; 
                    case 'Utente': 
                            $menu .= '<li tabindex="' . $tabindex++ . '"><a href="profilo.php">Il mio profilo</a></li>
                                      <li tabindex="' . $tabindex++ . '"><a href="lemierecensioni.php">Le mie recensioni</a></li>';
                        break;  
                    }          
            }

            $menu .= '<li tabindex="' . $tabindex++ . '"><a href="ultimiristoranti.php">Ultimi ristoranti inseriti</a></li>
                <li tabindex="' . $tabindex++ . '"><a href="casuale.php">Ristorante casuale</a></li>
                <li tabindex="' . $tabindex++ . '"><a href="regolamento.php">Regolamento</a></li>
                <li tabindex="' . $tabindex++ . '"><a href="faq.php"><abbr xml:lang="en" title="Frequently Asked Questions">FAQ</abbr></a></li>
                <li tabindex="' . $tabindex++ . '"><a href="chisiamo.php">Chi Siamo</a></li></ul>';

            $file_content = str_replace('%MENU%', $menu, $file_content);
        }       
        
        //Aggiunge header
        $header = file_get_contents("../components/header.html");
        if(isset($_SESSION['logged'])&&$_SESSION['logged']){            
            $header=str_replace('<a href="../php/login.php" class="btn">LOGIN</a>',
                                    "toReplace",$header);
            $header=str_replace('<a href="../php/registrazione.php" class="btn">REGISTRAZIONE</a>',
                                    "",$header);
            $header=str_replace("toReplace",'<a href="../php/logout_script.php" class="btn">LOGOUT</a>',$header);
        }
       
        if(basename($_SERVER["REQUEST_URI"])=="login.php"){
            $header ='<h1 id="title">RestReview</h1>
            <a id="hamburger" href="#menu" class="btn">MENU</a>
            <a href="../php/registrazione.php" class="btn">REGISTRAZIONE</a>
            ';
        }
      
        if(basename($_SERVER["REQUEST_URI"])=="registrazione.php"){
            $header ='<h1 id="title">RestReview</h1>
            <a id="hamburger" href="#menu" class="btn">MENU</a>
            <a href="../php/login.php" class="btn">LOGIN</a>
            ';
        }
        $file_content=str_replace("%HEADER%",$header,$file_content);
        
        //Aggiunge footer
        $footer = file_get_contents("../components/footer.html");
        return str_replace("%FOOTER%",$footer,$file_content);
       
    }
?>