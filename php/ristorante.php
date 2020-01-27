<?php
    require_once('sessione.php');
    require_once('reg_ex.php');
    class ristorante{
        public $id = -1;
        public $nome;
        public $descrizione;
        public $categoria;
        public $telefono;
        public $email;
        public $sito;
        public $ora_ap;
        public $ora_chiu;
        public $giorno;

        public $via;
        public $civico;
        public $cap;
        public $citta;
        public $nazione;
        public $approvato;
        public $proprietario;

        public function __construct($array){
            if(isset($array['ID'])){
                $this->id=$array['ID'];
            }
            $this->nome=$array['Nome'];
            $this->descrizione=$array['Descrizione'];
            $this->categoria=$array['Categoria'];
            $this->telefono=$array['Tel'];
            $this->email=$array['Mail'];
            $this->sito=$array['sito'];
            $this->ora_ap=$array['Ora_Apertura'];
            $this->ora_chiu=$array['Ora_Chiusura'];
            $this->giorno=$array['Giorno_Chiusura'];
            $this->via=$array['Via'];
            $this->civico=$array['Civico'];
            $this->cap=$array['CAP'];
            $this->citta=$array['Citta'];
            $this->nazione=$array['Nazione'];
            if(isset($array['Approvato'])){
                $this->approvato=$array['Approvato'];
            }
            if(isset($array['ID_Proprietario'])){
                $this->proprietario=$array['ID_Proprietario'];
            }
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
                if(strlen($this->descrizione) < 20){
                    $err_array['desc']="[La descrizione deve essere lunga almeno 20 caratteri]";
                } else {
                    if(strlen($this->descrizione) > 500) {
                        $err_array['desc']="[La descrizione deve essere lunga al massimo 500 caratteri]";
                    }
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
            }else{
                if(!check_sito($this->sito)){
                    $err_array['sito']="[Inserire un url valido]";
                }
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

        private function pulisciDati($connection){
            $this->nome=$connection->escape_str(htmlentities(trim($this->nome)));
            $this->descrizione=$connection->escape_str(htmlentities(trim($this->descrizione)));
            $this->categoria=$connection->escape_str(htmlentities(trim($this->categoria)));
            $this->telefono=$connection->escape_str(htmlentities(trim($this->telefono)));
            $this->email=$connection->escape_str(htmlentities(trim($this->email)));
            $this->sito=$connection->escape_str(htmlentities(trim($this->sito)));
            $this->ora_ap=$connection->escape_str(htmlentities(trim($this->ora_ap)));
            $this->ora_chiu=$connection->escape_str(htmlentities(trim($this->ora_chiu)));
            $this->giorno=$connection->escape_str(htmlentities(trim($this->giorno)));
            $this->via=$connection->escape_str(htmlentities(trim($this->via)));
            $this->civico=$connection->escape_str(htmlentities(trim($this->civico)));
            $this->cap=$connection->escape_str(htmlentities(trim($this->cap)));
            $this->citta=$connection->escape_str(htmlentities(trim($this->citta)));
            $this->nazione=$connection->escape_str(htmlentities(trim($this->nazione)));

        }

        public function insertIntoDB(){
            require_once('sessione.php');
            require_once('connessione.php');
            $obj_connection=new DBConnection();
            $obj_connection->create_connection();

            $this->pulisciDati($obj_connection);
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

        public function createItemRistorante(){
            $ristorante=file_get_contents('../components/item_ristorante.html');
            $ristorante=str_replace('%NOME%',$this->nome,$ristorante);

            require_once('indirizzo.php');
            $indirizzo=new indirizzo($this->via,$this->civico,$this->citta,$this->cap,$this->nazione);
            $ristorante=str_replace('%INDIRIZZO%',$indirizzo->getIndirizzo(),$ristorante);
            $ristorante=str_replace('%TIPOLOGIA%',$this->categoria,$ristorante);

            $ristorante=str_replace('%DESCRIZIONE%',$this->descrizione,$ristorante);

            require_once('connessione.php');
            $connection=new DBConnection();
            $connection->create_connection();
            //immagine
            if($queryFoto=$connection->connessione->query("SELECT f.Path AS Percorso FROM foto AS f, ristorante AS r, corrispondenza AS c WHERE r.ID=$this->id AND r.ID=c.ID_Ristorante AND c.ID_Foto=f.ID ORDER BY f.ID ASC")){
                $arrayFoto=$connection->queryToArray($queryFoto);
                if(count($arrayFoto)>0){
                    $ristorante=str_replace('%PATH_IMG%',$arrayFoto[0]['Percorso'],$ristorante);
                }
                else{
                    $ristorante=str_replace('%PATH_IMG%',"../img/ristoranti/default.jpg",$ristorante);
                }
            }
            //stelle
            $num_stelle='-';
            $lista_stelle='';
            if($query_star_avg=$connection->connessione->query("SELECT COUNT(Stelle) AS numero, AVG(Stelle) AS media FROM recensione WHERE ID_Ristorante=\"".$this->id."\"")){
                $array_star_avg=$connection->queryToArray($query_star_avg);
                if(count($array_star_avg)>0 && $array_star_avg[0]['numero']>0){
                    require_once('stelle.php');
                    $num_stelle=round($array_star_avg[0]['media'],1);
                    $stelle=new stelle($num_stelle);
                    $lista_stelle=$stelle->printStars();
                }
                $query_star_avg->close();
            }
            $ristorante=str_replace('%NUMERO_STELLE%',$num_stelle,$ristorante);
            $ristorante=str_replace('%LISTA_STELLE%',$lista_stelle,$ristorante);

            //forms
            $form_list='';
            require_once('addForms.php');
            $detail_form=new formRistorante('Dettaglio',$this->id);
            $form_list.=$detail_form->getForm();
            if($_SESSION['permesso']=='Ristoratore'&&$this->proprietario==$_SESSION['ID']){
                $delete_form=new formRistorante('Elimina',$this->id);
                $form_list.=$delete_form->getForm();
            }else{
                if($_SESSION['permesso']=='Admin'&&$this->approvato=='In attesa'){
                    $accept_form= new formRistorante('Accetta',$this->id);
                    $form_list.=$accept_form->getForm();
                    $deny_form= new formRistorante('Rifiuta',$this->id);
                    $form_list.=$deny_form->getForm();
                }
            }
            $ristorante=str_replace('%FORMS%',$form_list,$ristorante);

            $connection->close_connection();

            return $ristorante;
        }

    }

?>