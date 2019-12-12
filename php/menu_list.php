<?php
    class menuList{
        public $type;

        public function __construct($t='visitatore'){
            $this->type=$t;
        }

        public function getHTMLmenu(){
            $menu='<ul><li xml:lang="en"><a href="../html/index.html">Home</a></li>';
            if($this->type='utente'){
                $menu.='<li><a href="../html/profilo.html">Il mio profilo</a><li>
                        <li><a href="../php/lemierecensioni.php">Le mie recensioni</a><li>';
            }else{
                if($this->type='ristoratore'){
                    $menu.='<li><a href="../html/profilo.html">Il mio profilo</a><li>
                            <li><a href="../html/imieirist.html">I miei ristoranti</a></li>
                            <li><a href="../html/ins_rist.html">Inserisci nuovo ristorante</a></li>';
                }
            }
            $menu.='<li><a href="../html/ultimiristoranti.html">Ultimi ristoranti inseriti</a></li>
                    <li><a href="../html/casuale.html">Ristorante casuale</a></li>
                    <li><a href="../html/regolamento.html">Regolamento</a></li>
                    <li><a href="../html/faq.html"><abbr xml:lang="en" title="Frequently Asked Questions">FAQ</abbr></a></li>
                    <li><a href="../html/chisiamo.html">Chi Siamo</a></li></ul>';
            return $menu;
        }

    }

?>