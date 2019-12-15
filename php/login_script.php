<?php
    session_start();
    require_once("connessione.php");
    require_once('reg_ex.php');
    $obj_connection = new DBConnection();

    if($obj_connection->create_connection()){
        $email=$_POST['email'];
        if(!check_email($email)){
            header('location: login.php?error=not_valid_email');
            exit;
        }
        if(!$email_query=$obj_connection->queryDB("SELECT * FROM utente WHERE Mail='".$email."'")){
            header('location: login.php?error=wrong_email');
            exit;
        }

        $password=$_POST['password'];
        if(check_pwd($password)){
            header('location: login.php?error=not_valid_password')
        }
        if(!$log_query=$obj_connection->queryDB("SELECT * FROM utente WHERE Mail='".$email."' AND PWD='".$password."'")){
            header('location: login.php?wrong_pwd=1');
            exit;
        }else{
            $_SESSION['logged']=true;
            $_SESSION['email']=$email;
            $_SESSION['ID']=$log_query[0]['ID'];
            $_SESSION['permesso']=$log_query[0]['Permessi'];
        }

        //Reindirizzamento sulla home
        header('Location: ../php/index.php');
    }
?>