<?php
    session_start();
    require_once("connessione.php");
    require_once("addItems.php");
    require_once("makeRestaurantCard.php");
   
    $page= (new addItems)->add("../html/index.html");
    $page = str_replace('><a href="index.php">Home</a>', 'class="active">Home',$page);
    $error="";
    $list='<dl class="card_list rist_list">';
    $no_error=true;
    $obj_connection = new DBConnection();
    if(!$obj_connection->create_connection()){
        $error=$error."<div class=\"msg_box error_box\">Errore di connessione al database</div>";
        $no_error=false;
    }
    if($no_error){
        $queryResult=$obj_connection->connessione->query("SELECT ID_Ristorante, AVG(Stelle) AS Media FROM `recensione` GROUP BY ID_Ristorante ORDER BY Media DESC LIMIT 5");
        while($row=$queryResult->fetch_array(MYSQLI_ASSOC)){
            $list=$list.makeCard($row['ID_Ristorante'],$obj_connection);
        }
    }
    $list .= "</dl>";
    $page = str_replace('%ERROR%', $error,$page);
    $page = str_replace('%LIST%', $list,$page);
    echo $page;

    
?>