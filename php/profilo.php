<?php
    require_once("sessione.php");
    require_once('addItems.php');
    require_once('connessione.php');
    if(!$_SESSION['logged']){
        header('location: access_denied.php');
    }
   
    $page= (new addItems)->add("../html/profilo.html");
    $page=str_replace('><a href="profilo.php">Il mio profilo</a>', ' class="active">Il mio profilo',$page);
   
    $no_error=true;
    $error='';
    //connessione db
    $obj_connection = new DBConnection();
    if(!$obj_connection->create_connection()){
        $error="<div class=\"msg_box error_box\">Errore di connessione al database</div>";
        $no_error=false;
    }
    if($no_error){
        $queryResult=$obj_connection->connessione->query("SELECT * FROM utente WHERE ID='".$_SESSION['ID']."'");
        $row=$queryResult->fetch_array(MYSQLI_ASSOC);
        $page=str_replace("%EMAIL%",$row['Mail'],$page);
        $page=str_replace("%UTENZA%",$row['Permessi'],$page);
        $page=str_replace("%NOME%",$row['Nome'],$page);
        $page=str_replace("%COGNOME%",$row['Cognome'],$page);
        $page=str_replace("%SESSO%",$row['Sesso'],$page);
        $page=str_replace("%DATA_NASCITA%",$row['Data_Nascita'],$page);
        if($row['Permessi']==='Ristoratore'){
            $page=str_replace("%PARTITA_IVA%",$row['P_IVA'],$page);
            $page=str_replace("%RAGIONESOCIALE%",$row['Ragione_Sociale'],$page);
        }
        else{
            $page=str_replace('<dt>Partita <abbr title="imposta sul valore aggiunto">IVA</abbr>:</dt>',"",$page);
            $page=str_replace("<dd>%PARTITA_IVA%</dd>","",$page);
            $page=str_replace("<dt>Ragione Sociale: </dt>","",$page);
            $page=str_replace("<dd>%RAGIONESOCIALE%</dd>","",$page);
        }
        //query per img profilo
        if($row['ID_Foto']){
            $queryResult=$obj_connection->connessione->query("SELECT * FROM foto WHERE ID='".$row['ID_Foto']."'");
            if($queryResult){
                $row=$queryResult->fetch_array(MYSQLI_ASSOC);
                $page=str_replace('../img/imgnotfound.jpg',$row['Path'],$page);
            }
        }   
    }

    $page=str_replace("%ERROR%",$error,$page);
    $obj_connection->close_connection();
    echo $page;
?>