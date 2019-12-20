<?php
    class ristorante{

        public $nome;
        public $descrizione;
        public $tipo;
        public $telefono;
        public $email;
        public $sito;
        public $ora_ap;
        public $ora_chiu;
        public $giorno;

        //si può fare una class indirizzo
        public $via;
        public $civico;
        public $cap;
        public $citta;
        public $nazione;

        public function __construct($n,$d,$t,$tel,$e,$s,$oap,$och,$g,$v,$civ,$cp,$cit,$naz){
            $this->nome=$n;
            $this->descrizione=$d;
            $this->tipo=$t;
            $this->telefono=$tel;
            $this->email=$e;
            $this->sito=$s;
            $this->ora_ap=$oap;
            $this->ora_chiu=$och;
            $this->giorno=$g;
            $this->via=$v;
            $this->civico=$civ;
            $this->cap=$cp;
            $this->citta=$cit;
            $this->nazione=$naz;
        }

        public function errors(){
            
        }

        public function numErrors(){
            
        }


    }

?>