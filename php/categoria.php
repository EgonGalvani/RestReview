<?php
    require_once("connessione.php");
    $obj_connection = new DBConnection();
    
    $list_categorie='<option value="default">-selezionare una categoria-</option>';
    if($obj_connection->create_connection()){

        $cat_result=$obj_connection->queryDB("SELECT * FROM categoria ");

        foreach($cat_result as $row){
            foreach($row as $value){
                $list_categorie.="<option value=\"$value\" %VALUE_".strtoupper($value)."_CAT%>".$value."</option>";
            }
        }
        $obj_connection->close_connection();
    }
?>