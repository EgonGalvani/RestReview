<?php

class addItems {

    // $subjectPath= pagina html a cui aggiungere le cose
    // $addMenu= true di default, passare false come parametro se non si vuole aggiungere il menu
    // ritorna una stringa con il contenuto della pagina modificata
    public function add($subjectPath, $hasMenu = true, $hasHeader = true){ 
        $file_content = file_get_contents($subjectPath);
        
        if($hasMenu) $this->addMenu($file_content); 
        if($hasHeader) $this->addHeader($file_content); 

        return $file_content; 
    }

    public function addHeader(&$page) {
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
       
        $page = str_replace("%HEADER%",$header,$page);  
    }

    public function addMenu(&$page) {

        // menù di base 
        $menu = '<ul><li xml:lang="en"><a href="index.php">Home</a></li>'; 

        if(isset($_SESSION['permesso'])){
            
            switch($_SESSION['permesso']) {
                case 'Admin': 
                        $menu .= '<li><a href="pannello_amministratore.php">Pannello amministratore</a></li>';
                    break; 
                case 'Ristoratore': 
                        $menu .= '<li><a href="profilo.php">Il mio profilo</a></li>
                                    <li><a href="imieirist.php?type=0">I miei ristoranti</a></li>'; 
                    break; 
                case 'Utente': 
                        $menu .= '<li><a href="profilo.php">Il mio profilo</a></li>
                                <li><a href="lemierecensioni.php">Le mie recensioni</a></li>';
                    break;  
                }          
        }

        $menu .= '<li><a href="ultimiristoranti.php">Ultimi ristoranti inseriti</a></li>
            <li><a href="casuale.php">Ristorante casuale</a></li>
            <li><a href="regolamento.php">Regolamento</a></li>
            <li><a href="faq.php"><abbr xml:lang="en" title="Frequently Asked Questions">FAQ</abbr></a></li>
            <li><a href="chisiamo.php">Chi Siamo</a></li></ul>';

        $page = str_replace('%MENU%', $menu, $page);
    }

}
