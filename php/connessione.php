<?php

    class DBConnection{
        const HOST_DB ="localhost";
        const USERNAME ="root";
        const PASSWORD ="";
        const DATABASE_NAME ="tecweb";
    
        public $connessione = null;
        
        public function create_connection(){
            $this->connessione = new mysqli(static::HOST_DB,static::USERNAME,static::PASSWORD,static::DATABASE_NAME);
            //$this->connessione = new mysqli("localhost","root","","tecweb");
            if(!$this->connessione){ return false;}
            return true;
        }

        public function queryDB($query){
            $queryResult = $this->connessione->query($query);

            if($queryResult->num_rows>0){
                $result=array();
                while(!$row=$result->fetch_array(MYSQLI_ASSOC)){
                    array_push($result,$row);
                }
                return $result;
            }else{
                return false;
            }
        }
    }
?>