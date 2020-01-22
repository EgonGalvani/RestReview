<?php
    session_start();
    require_once("connessione.php");
    require_once("addItems.php");
   
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
        

    }
    $list .= "</dl>";
    $page = str_replace('%ERROR%', $error,$page);
    $page = str_replace('%LIST%', $list,$page);
    echo $page;
?>