<?php
    require_once('reg_ex.php');
    class ristorante{

        public $nome;
        public $descrizione;
        public $categoria;
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

        public function __construct($n,$d,$cat,$tel,$e,$s,$oap,$och,$g,$v,$civ,$cp,$cit,$naz){
            $this->nome=$n;
            $this->descrizione=$d;
            $this->categoria=$cat;
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
                            "cat"=>"",
                            "tel"=>"",
                            "email"=>"",
                            "sito"=>"",
                            "ora_ap"=>"",
                            "ora_chiu"=>"",
                            "giorno"=>"",
                            "via"=>"",
                            "civ"=>"",
                            "citta"=>"",
                            "cap"=>"",
                            "naz"=>"");
            //nome
            if($this->nome==''){
                $err_array['nome']="[Campo obbligatorio]";
            }else{
                if(!check_nome($this->nome)){
                $err_array['nome']="[Il nome può contenere solo lettere]";
                }
            }
            //descrizione
            if($this->descrizione==''){
                $err_array['desc']="[Campo obbligatorio]";
            }else{
                if(strlen($this->descrizione)<20){
                $err_array['desc']="[La descrizione deve essere lunga almeno 20 caratteri]";
                }
            }
            //categoria
            if($this->categoria==''){
                $err_array['cat']="[Campo obbligatorio]";
            }else{
                if($this->categoria=='default'){
                $err_array['cat']="[Selezionare una categoria]";
                }
            }
            //telefono
            if($this->telefono==''){
                $err_array['tel']="[Campo obbligatorio]";
            }else{
                if(!check_tel($this->telefono)){
                $err_array['tel']="[Il numero di telefono deve essere composto da dieci cifre]";
                }
            }
            //email
            if($this->email==''){
                $err_array['email']="[Campo obbligatorio]";
            }else{
                if(!check_email($this->email)){
                $err_array['email']="[L'email inserita non è valida]";
                }
            }
            //sito
            if($this->sito==''){
                $err_array['sito']="[Campo obbligatorio]";
            }
            //ora apertura
            if($this->ora_ap==''){
                $err_array['ora_ap']="[Campo obbligatorio]";
            }
            //ora chiusura
            if($this->ora_chiu==''){
                $err_array['ora_chiu']="[Campo obbligatorio]";
            }
            //giorno
            if($this->giorno==''){
                $err_array['giorno']="[Campo obbligatorio]";
            }
            //via
            if($this->via==''){
                $err_array['via']="[Campo obbligatorio]";
            }
            //civico
            if($this->civico==''){
                $err_array['civ']="[Campo obbligatorio]";
            }else{
                if(!check_num($this->civico)){
                $err_array['civ']="[Il numo civico può contenere solo cifre]";
                }
            }
            //citta
            if($this->citta==''){
                $err_array['citta']="[Campo obbligatorio]";
            }
            //cap
            if($this->cap==''){
                $err_array['cap']="[Campo obbligatorio]";
            }else{
                if(!check_cap($this->cap)){
                $err_array['cap']="[Il cap è un numero di cinque cifre]";
                }
            }
            //nazione
            if($this->nazione==''){
                $err_array['naz']="[Campo obbligatorio]";
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
            return $count;
        }

        private function pulisciDati(){
            $this->nome=htmlentities(trim($this->nome));
            $this->descrizione=htmlentities(trim($this->descrizione));
            $this->categoria=htmlentities(trim($this->categoria));
            $this->telefono=htmlentities(trim($this->telefono));
            $this->email=htmlentities(trim($this->email));
            $this->sito=htmlentities(trim($this->sito));
            $this->ora_ap=htmlentities(trim($this->ora_ap));
            $this->ora_chiu=htmlentities(trim($this->ora_chiu));
            $this->giorno=htmlentities(trim($this->giorno));
            $this->via=htmlentities(trim($this->via));
            $this->civico=htmlentities(trim($this->civico));
            $this->cap=htmlentities(trim($this->cap));
            $this->citta=htmlentities(trim($this->citta));
            $this->nazione=htmlentities(trim($this->nazione));

        }

        public function insertIntoDB(){
            require_once('sessione.php');
            require_once('connessione.php');
            $obj_connection=new DBConnection();
            $obj_connection->create_connection();

            $this->pulisciDati();
            $query_res=$obj_connection->queryDB("SELECT MAX(ID) as num FROM ristorante");
            $rist_id=$query_res[0]['num']+1;
            $ins="INSERT INTO ristorante 
                VALUE ($rist_id,\"".$_SESSION['ID']."\",\"".$this->nome.
                        "\",\"".$this->categoria."\",\"".$this->descrizione."\",\"".$this->telefono.
                        "\",\"".$this->email."\",\"".$this->giorno."\",\"".$this->ora_ap.
                        "\",\"".$this->ora_chiu."\",\"".$this->nazione."\",\"".$this->citta.
                        "\",\"".$this->cap."\",\"".$this->via."\",\"".$this->civico."\",\"In Attesa\",\"".$this->sito."\")";
            if($obj_connection->connessione->query($ins)){
                return $rist_id;
            }else{
                return false;
            }

        }

    }

?>