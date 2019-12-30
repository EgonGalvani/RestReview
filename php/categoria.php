<?php
    class categorie{

        public $type;
        public $cat_values;

        public function __construct($t){
            $this->type=$t;
            $this->cat_values=$this->getCategorie();
        }

        private function getCategorie(){
            require_once("connessione.php");
            $obj_connection = new DBConnection();
            $cat_values=array();
            if($obj_connection->create_connection()){
                if($cat_result=$obj_connection->connessione->query("SELECT * FROM categoria ORDER BY Nome ASC")){
                    $array_cat=$obj_connection->queryToArray($cat_result);
                    $cat_result->close();
                    foreach($array_cat as $row){
                        foreach($row as $value){
                            array_push($cat_values,$value);
                        }
                    }
                }
                
                $obj_connection->close_connection();
            }
            return $cat_values;
        }

        public function getHTMLList(){
            switch($this->type){
                case 'Inserimento': $list_categorie='<option value="default" %VALUE_DEFAULT_CAT%>-selezionare una categoria-</option>';
                break;
                case 'Ricerca': $list_categorie='<option value="default" %VALUE_DEFAULT_CAT%>Tutte le categorie</option>';
                break;
                default: $list_categorie='';
            }

            foreach($this->cat_values as $value){
                $list_categorie.="<option value=\"$value\" %VALUE_".strtoupper($value)."_CAT%>$value</option>";
            }
            return $list_categorie;
        }   

        public function getCatArray(){
            $arr=$this->cat_values;
            array_push($arr,"default");
            return $arr;
        }
    }
?>