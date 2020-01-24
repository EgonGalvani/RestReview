<?php
    require_once('sessione.php');
    require_once('addItems.php');
    require_once('connessione.php');
    require_once("ristorante.php");
  
    $page= (new addItems)->add("../html/ultimiristoranti.html");
    $page = str_replace('><a href="ultimiristoranti.php">Ultimi ristoranti inseriti</a>', 'class="active">Ultimi ristoranti inseriti',$page);
    $error="";
    $list='<dl class="card_list rist_list">';
    $no_error=true;
    $obj_connection = new DBConnection();
    if(!$obj_connection->create_connection()){
        $error=$error."<div class=\"msg_box error_box\">Errore di connessione al database</div>";
        $no_error=false;
    }
    if($no_error){
        $queryResult=$obj_connection->connessione->query("SELECT * FROM ristorante WHERE Approvato='Approvato' ORDER BY ID DESC LIMIT 5");
        while($row=$queryResult->fetch_array(MYSQLI_ASSOC)){
            $ristorante = new ristorante($row);
            $list=$list.$ristorante->createItemRistorante();
        }
    }
    $list .= "</dl>";
    $page = str_replace('%ERROR%', $error,$page);
    $page = str_replace('%LIST%', $list,$page);
    $obj_connection->close_connection();
    echo $page;
?>