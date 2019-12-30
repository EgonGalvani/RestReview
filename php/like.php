<?php

    class like{
        public $id_utente;
        public $id_recensione;

        public function __construct($id_u,$id_r){
            $this->id_utente=$id_u;
            $this->id_recensione=$id_r;
        }

        public function insertIntoDB(){
            require_once('connessione.php');
            $obj_connection=new DBConnection();
            $obj_connection->create_connection();
            if($obj_connection->connessione->query("INSERT INTO mi_piace VALUE ($this->id_utente,$this->id_recensione)")){
                //la query ha successo, non è detto che l'inserimento sia stato effettuato
                $obj_connection->close_connection();
            }else{
                //errore
            }
        }

        public function removeFromDB(){
            require_once('connessione.php');
            $obj_connection=new DBConnection();
            $obj_connection->create_connection();
            if($obj_connection->connessione->query("DELETE FROM mi_piace WHERE ID_Utente=$this->id_utente AND ID_Recensione=$this->id_recensione")){
                //la query ha successo, non è detto che l'inserimento sia stato effettuato
                $obj_connection->close_connection();
            }else{
                //errore
            }
        }
    }
?>