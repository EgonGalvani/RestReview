<?php

    class DBConnection{
        const HOST_DB ="localhost";
        const USERNAME ="root";
        const PASSWORD ="";
        const DATABASE_NAME ="tecweb";
    
        public $connessione = null;
        
        public function create_connection(){
            $this->connessione = new mysqli(static::HOST_DB,static::USERNAME,static::PASSWORD,static::DATABASE_NAME);
            if(!$this->connessione){ return false;}
            return true;
        }

        public function queryDB($query){
            $queryResult = $this->connessione->query($query);

            if($queryResult->num_rows>0){
                $result=array();
                while($row=$queryResult->fetch_array(MYSQLI_ASSOC)){
                    array_push($result,$row);
                }
                return $result;
            }else{
                return false;
            }
        }

        public function close_connection(){
            if($this->connessione){
                $this->connessione->close();
            }
        }

        public function escape_str($string){
            return $this->connessione->real_escape_string($string);
        }
    }
?>