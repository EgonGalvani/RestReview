<?php
    require_once('reg_ex.php');

    class recensione{
        public $id=-1;
        public $data;
        public $stelle;
        public $oggetto;
        public $descrizione;
        public $id_utente;
        public $id_ristorante;

        public function __construct($array){
            if(isset($array['ID'])){
                $this->id=$array['ID'];
            }
            $this->data=$array['Data'];
            $this->stelle=$array['Stelle'];
            $this->oggetto=$array['Oggetto'];
            $this->descrizione=$array['Descrizione'];
            $this->id_utente=$array['ID_Utente'];
            $this->id_ristorante=$array['ID_Ristorante'];
        }

        public function createItemRecensione($viewer_id,$viewer_permission){
            $recensione=file_get_contents('../components/item_recensione.html');
            $recensione=str_replace('%TITOLO%',$this->oggetto,$recensione);
            $recensione=str_replace('%DATA%',$this->data,$recensione);

            require_once('connessione.php');
            $connection=new DBConnection();
            if(!$connection->create_connection()){
                return false;
            }
            if(!$query_utente=$connection->connessione->query("SELECT * FROM utente AS u,foto AS f WHERE u.ID=$this->id_utente AND u.ID_Foto=f.ID")){
                return false;
            }
            $array_utente=$connection->queryToArray($query_utente);
            if(count($array_utente)>0){
                $utente=$array_utente[0];
            }else{
                return false;
            }
            $recensione=str_replace('%URL_IMG_PROFILO%',$utente['Path'],$recensione);
            $recensione=str_replace('%NOME_UTENTE%',$utente['Nome'],$recensione);
            $recensione=str_replace('%COGNOME_UTENTE%',$utente['Cognome'],$recensione); 

            $recensione=str_replace('%CONTENUTO%',$this->descrizione,$recensione);
            $recensione=str_replace('%NUMERO_STELLE%',$this->stelle,$recensione);
            require_once('stelle.php');
            $stars=new stelle($this->stelle);
            $recensione=str_replace('%LISTA_STELLE%',$stars->printStars(),$recensione);  
            
            if(!$query_likes=$connection->connessione->query("SELECT COUNT(*) AS numero FROM mi_piace WHERE ID_Recensione=$this->id")){
                return false;
            }
            $array_likes=$connection->queryToArray($query_likes);
            if(count($array_likes)>0){
                $likes=$array_likes[0];
            }else{
                return false;
            }
            $recensione=str_replace('%NUMERO_MI_PIACE%',$likes['numero'],$recensione);

            require_once('addForms.php');
            //like form
            if($viewer_permission=='Utente'){
                if($query_like_result=$connection->connessione->query("SELECT * FROM mi_piace WHERE ID_Utente=$viewer_id AND ID_Recensione=$this->id")){
                    if($array_like_result=$connection->queryToArray($query_like_result)){
                        $dislike_form=new formRecensione('Dislike',$this->id,$viewer_id);
                        $recensione=str_replace('%LIKE_FORM%',$dislike_form->getForm(),$recensione);
                    }else{
                        $like_form=new formRecensione('Like',$this->id,$viewer_id);
                        $recensione=str_replace('%LIKE_FORM%',$like_form->getForm(),$recensione);
                    }
                }//errore query
                
            }else{
                if($viewer_permission=='Visitatore'){
                    $link='<a href="login.php" title="Accedi per mettere mi piace">Accedi per mettere mi piace</a>';
                    $recensione=str_replace('%LIKE_FORM%',$link,$recensione);
                }else{
                    $recensione=str_replace('%LIKE_FORM%','',$recensione);
                }
            }
            //delete form
            if($viewer_permission=='Admin' || $this->id_utente==$viewer_id){
                $delete_form=new formRecensione('Elimina',$this->id,$viewer_id);
                $recensione=str_replace('%DELETE_FORM%',$delete_form->getForm(),$recensione);
            }else{
                $recensione=str_replace('%DELETE_FORM%','',$recensione);
            }

            $connection->close_connection();

            return $recensione;
        }

        public function createRecensioneUtenteLoggato($viewer_id,$viewer_permission){
            $recensione=file_get_contents('../components/recensione_utente_loggato.html');
            $recensione=str_replace('%TITOLO%',$this->oggetto,$recensione);
            $recensione=str_replace('%DATA%',$this->data,$recensione);

            require_once('connessione.php');
            $connection=new DBConnection();
            if(!$connection->create_connection()){
                return false;
            }
            if(!$query_ristorante=$connection->connessione->query("SELECT Nome FROM ristorante WHERE ID=$this->id_ristorante")){
                return false;
            }
            $array_ristorante=$connection->queryToArray($query_ristorante);
            if(count($array_ristorante)>0){
                $ristorante=$array_ristorante[0];
            }else{
                return false;
            }
            $recensione=str_replace('%NOME_RISTORANTE%',$ristorante['Nome'],$recensione);
            $recensione=str_replace('%ID_RISTORANTE%',$this->id_ristorante,$recensione);

            $recensione=str_replace('%CONTENUTO%',$this->descrizione,$recensione);
            $recensione=str_replace('%NUMERO_STELLE%',$this->stelle,$recensione);
            require_once('stelle.php');
            $stars=new stelle($this->stelle);
            $recensione=str_replace('%LISTA_STELLE%',$stars->printStars(),$recensione);  
            
            if(!$query_likes=$connection->connessione->query("SELECT COUNT(*) AS numero FROM mi_piace WHERE ID_Recensione=$this->id")){
                return false;
            }
            $array_likes=$connection->queryToArray($query_likes);
            if(count($array_likes)>0){
                $likes=$array_likes[0];
            }else{
                return false;
            }
            $recensione=str_replace('%NUMERO_MI_PIACE%',$likes['numero'],$recensione);

            require_once('addForms.php');
            //like form
            if($viewer_permission=='Utente'){
                if($query_like_result=$connection->connessione->query("SELECT * FROM mi_piace WHERE ID_Utente=$viewer_id AND ID_Recensione=$this->id")){
                    if($array_like_result=$connection->queryToArray($query_like_result)){
                        $dislike_form=new formRecensione('Dislike',$this->id,$viewer_id);
                        $recensione=str_replace('%LIKE_FORM%',$dislike_form->getForm(),$recensione);
                    }else{
                        $like_form=new formRecensione('Like',$this->id,$viewer_id);
                        $recensione=str_replace('%LIKE_FORM%',$like_form->getForm(),$recensione);
                    }
                }//errore query
                
            }else{
                if($viewer_permission=='Visitatore'){
                    $link='<a href="login.php" title="Accedi per mettere mi piace">Accedi per mettere mi piace</a>';
                    $recensione=str_replace('%LIKE_FORM%',$link,$recensione);
                }else{
                    $recensione=str_replace('%LIKE_FORM%','',$recensione);
                }
            }
            //delete form
            if($viewer_permission=='Admin' || $this->id_utente==$viewer_id){
                $delete_form=new formRecensione('Elimina',$this->id,$viewer_id);
                $recensione=str_replace('%DELETE_FORM%',$delete_form->getForm(),$recensione);
            }else{
                $recensione=str_replace('%DELETE_FORM%','',$recensione);
            }

            $connection->close_connection();
            return $recensione;
        }

        public function insertIntoDB(){
            require_once('sessione.php');
            require_once('connessione.php');

            $connection=new DBConnection();
            $connection->create_connection();

            $this->pulisciDati();
            $ins="INSERT INTO recensione VALUES(NULL,\"$this->data\",$this->stelle,\"$this->oggetto\",
                                                \"$this->descrizione\",$this->id_utente,
                                                $this->id_ristorante)";
            $query=$connection->connessione->query($ins);
            if($connection->connessione->affected_rows>0){
                return true;
            }else{
                return false;
            }
        }

        public function getErrors(){
            $err_array=array("titolo"=>"",
                            "contenuto"=>"");

            if($this->oggetto==''){
                $err_array['titolo']='[Campo obbligatorio]';
            }else{
                if(strlen($this->oggetto)<25 || strlen($this->oggetto)>50){
                    $err_array['titolo']='[Il titolo deve avere tra i 25 e 50 cartteri.]';
                }
            }

            if($this->descrizione==''){
                $err_array['contenuto']='[Campo obbligatorio]';
            }else{
                if(strlen($this->descrizione)<100 || strlen($this->descrizione)>250){
                    $err_array['contenuto']='[Il contenuto della recensione deve avere tra i 100 e 250 caratteri.]';
                }
            }
            return $err_array;
        }

        public function numErrors($err_array){
            $count=0;
            foreach($err_array as $value){
                if($value!=''){
                    $count++;
                }
            }
            return $count;
        }

        private function pulisciDati(){
            $this->data=htmlentities(trim($this->data));
            $this->stelle=htmlentities(trim($this->stelle));
            $this->oggetto=htmlentities(trim($this->oggetto));
            $this->descrizione=htmlentities(trim($this->descrizione));
            $this->id_utente=htmlentities(trim($this->id_utente));
            $this->id_ristorante=htmlentities(trim($this->id_ristorante));
        }

    }

?>