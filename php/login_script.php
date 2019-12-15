<?php
    session_start();
    require_once("connessione.php");
    require_once('reg_ex.php');
    $obj_connection = new DBConnection();

    if($obj_connection->create_connection()){
        $email=$_POST['email'];
        $email_error='';
        if(!check_email($email)){
            $email_error='1';
        }else{
            if(!$obj_connection->queryDB("SELECT * FROM utente WHERE Mail='".$email."'")){
                $email_error='2';
            }
        }

        $password=$_POST['password'];
        $pwd_error='';
        if(!check_pwd($password)){
            $pwd_error='1';
        }else{
            if(!$log_query=$obj_connection->queryDB("SELECT * FROM utente WHERE Mail='".$email."' AND PWD='".$password."'")){
                $pwd_error='2';
            }
        }

        if($email_error=='' && $pwd_error==''){
            $_SESSION['logged']=true;
            $_SESSION['email']=$email;
            $_SESSION['ID']=$log_query[0]['ID'];
            $_SESSION['permesso']=$log_query[0]['Permessi'];

            header('Location: ../php/index.php');
            exit;
        }
        header('location: login.php?email_error='.$email_error.'&pwd_error='.$pwd_error);
        exit;        
    }
?>