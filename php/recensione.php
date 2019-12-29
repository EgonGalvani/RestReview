<?php

    class recensione{
        public $id;
        public $data;
        public $stelle;
        public $oggetto;
        public $descrizione;
        public $id_utente;
        public $id_ristorante;

        public function __construct($array){
            $this->id=$array['ID'];
            $this->data=$array['Data'];
            $this->stelle=$array['Stelle'];
            $this->oggetto=$array['Oggetto'];
            $this->descrizione=$array['Descrizione'];
            $this->id_utente=$array['ID_Utente'];
            $this->id_ristorante=$array['ID_Ristorante'];
        }

        public function createItemRecensione(){
            $recensione=file_get_contents('../components/item_recensione.html');
            $recensione=str_replace('%TITOLO%',$this->oggetto,$recensione);
            $recensione=str_replace('%DATA%',$this->data,$recensione);

            require_once('connessione.php');
            $connection=new DBConnection();
            if(!$connection->create_connection()){
                return false;
            }
            if(!$query_utente=$connection->queryDB("SELECT * FROM utente AS u,foto AS f WHERE u.ID=$this->id_utente AND u.ID_Foto=f.ID")){
                return false;
            }
            $utente=$query_utente[0];
            $recensione=str_replace('%URL_IMG_PROFILO%',$utente['Path'],$recensione);
            $recensione=str_replace('%NOME_UTENTE%',$utente['Nome'],$recensione);
            $recensione=str_replace('%COGNOME_UTENTE%',$utente['Cognome'],$recensione); 

            $recensione=str_replace('%CONTENUTO%',$this->descrizione,$recensione);
            $recensione=str_replace('%NUMERO_STELLE%',$this->stelle,$recensione);
            require_once('stelle.php');
            $stars=new stelle($this->stelle);
            $recensione=str_replace('%LISTA_STELLE%',$stars->printStars(),$recensione);  
            
            if(!$query_likes=$connection->queryDB("SELECT COUNT(*) AS numero FROM mi_piace WHERE ID_Recensione=$this->id")){
                return false;
            }
            $likes=$query_likes[0];
            $recensione=str_replace('%NUMERO_MI_PIACE%',$likes['numero'],$recensione);

            //aggiungere form
            /*$recensione=str_replace('%LIKE_FORM%','',$recensione);*/

            $connection->close_connection();

            return $recensione;
        }


    }

?>