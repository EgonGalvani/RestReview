<?php
    require_once('reg_ex.php');
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

        public function getErrors(){
            $err_array=array("nome"=>"",
                            "desc"=>"",
                            "tel"=>"",
                            "email"=>"",
                            "civ"=>"",
                            "cap"=>"");
            if(!check_nome($this->nome)){
                $err_array['nome']="[Il nome può contenere solo lettere e non può essere vuoto]";
            }
            if(strlen($this->descrizione)<20){
                $err_array['desc']="[La descrizione deve essere lunga almeno 20 caratteri]";
            }
            if(!check_tel($this->telefono)){
                $err_array['tel']="[Il numero di telefono deve essere composto da dieci cifre]";
            }
            if(!check_email($this->email)){
                $err_array['email']="[L'email inserita non è valida]";
            }
            if(!check_num($this->civico)){
                $err_array['civ']="[Il numo civico può contenere solo cifre]";
            }
            if(!check_cap($this->cap)){
                $err_array['cap']="[Il cap è un numero di cinque cifre]";
            }
            return $err_array;
        }

        public function numErrors($err_array){
            $count=0;
            foreach($err_array as $key=>$value){
                if($value!=''){
                    $count++;
                }
            }
        }


    }

?>