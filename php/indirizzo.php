<?php
    class indirizzo{

        public $via;
        public $numero;
        public $citta;
        public $cap;
        public $nazione;

        public function __construct($v,$num,$cit,$cp,$naz){
            $this->via=$v;
            $this->numero=$num;
            $this->citta=$cit;
            $this->cap=$cp;
            $this->nazione=$naz;
        }

        public function getIndirizzo(){
            return "via $this->via, $this->numero, $this->citta, $this->cap, $this->nazione";
        }

    }

?>