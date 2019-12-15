<?php

    session_start();

    include("connessione.php");

    if(!isset($_SESSION["email"])){
        $email=$_POST["email"];
        $password=$_POST["password"];

        if(!$log_query=$connessione->query("SELECT * FROM utente WHERE Mail='$email' AND PWD='$password'")){
            echo "Errore";
        }else{
            $row=$log_query->fetch_array(MYSQLI_ASSOC);
            $_SESSION["email"]=$email;
            $_SESSION["password"]=$password;
            $_SESSION["ID"]=$row["ID"];
        }
    }

?>