<?php
    class menuList{
        public $type;

        public function __construct($t='visitatore'){
            $this->type=$t;
        }

        public function getHTMLmenu(){
            $menu='<ul><li xml:lang="en"><a href="../html/index.html">Home</a></li>';
            if($this->type=='utente'){
                $menu.='<li><a href="../php/profilo.php">Il mio profilo</a></li>
                        <li><a href="../php/lemierecensioni.php">Le mie recensioni</a></li>';
            }else{
                if($this->type=='ristoratore'){
                    $menu.='<li><a href="../php/profilo.php">Il mio profilo</a></li>
                            <li><a href="../php/imieirist.php">I miei ristoranti</a></li>
                            <li><a href="../php/ins_rist.php">Inserisci nuovo ristorante</a></li>';
                }
            }
            $menu.='<li><a href="../php/ultimiristoranti.php">Ultimi ristoranti inseriti</a></li>
                    <li><a href="../php/casuale.php">Ristorante casuale</a></li>
                    <li><a href="../php/regolamento.php">Regolamento</a></li>
                    <li><a href="../php/faq.php"><abbr xml:lang="en" title="Frequently Asked Questions">FAQ</abbr></a></li>
                    <li><a href="../php/chisiamo.php">Chi siamo</a></li></ul>';
            return $menu;
        }

    }

?>