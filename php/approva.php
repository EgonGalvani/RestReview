<?php
    require_once('connessione.php');
    require_once('sessione.php');
    if($_SESSION['permesso']!="Admin"){
        header('location: access_denied.php');
    }
    if(isset($_POST['approva'])){
        $no_error=true;
        $id=$_POST['id'];
        $obj_connection = new DBConnection();
        if(!$obj_connection->create_connection()){
            echo "Errore di connessione al database, stai per essere reindirizzato al pannello amministratore.";
            header('refresh:5; url= pannello_amministratore.php');
            $no_error=false;
        }
        if($no_error){
            $obj_connection->connessione->query("UPDATE `ristorante` SET `Approvato` = 'Approvato' WHERE `ristorante`.`ID` = $id");
            header('location: pannello_amministratore.php');
        }
    }
?>