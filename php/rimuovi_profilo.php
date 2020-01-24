<?php
    require_once("sessione.php");
    require_once('connessione.php');
    if(!$_SESSION['logged']){
        header('location: access_denied.php');
    }
    $obj_connection = new DBConnection();
    if(!$obj_connection->create_connection()){
        $error="<div class=\"msg_box error_box\">Errore di connessione al database, verrai reindirizzato alla home entro qualche secondo</div>";
        $no_error=false;
        echo $error;
        header('refresh:5; url= index.php');
    }
    else{
        $queryResult=$obj_connection->connessione->query("SELECT ID_Foto FROM utente WHERE ID='".$_SESSION['ID']."'");
        $row=$queryResult->fetch_array(MYSQLI_ASSOC);
        if($row['ID_Foto']){
            $obj_connection->connessione->query("DELETE FROM foto WHERE ID='".$row['ID_Foto']."'");
        }
        $obj_connection->connessione->query("DELETE FROM utente WHERE ID='".$_SESSION['ID']."'");
        header('location: logout_script.php');
        
    }
    $obj_connection->close_connection();
?>