<?php
    $host ="localhost";
    $username ="root";
    $password ="";
    $db ="tecweb";
    $connessione = new mysqli($host,$username,$password,$db);
    
    
    if ($connessione->connect_errno) {
        echo "Connessione fallita (". $connessione->connect_errno. "): " . $connessione->connect_error;
        exit();
    }
?>