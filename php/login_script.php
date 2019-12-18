<?php
    session_start();
    require_once("connessione.php");
    require_once("reg_ex.php");
    $obj_connection = new DBConnection();

    if($obj_connection->create_connection()){
        $email=trim($_POST['email']);
        $email=$obj_connection->escape_str($email);
        $email_error='';
        if(!check_email($email)){
            $email_error='1';
        }else{
            if(!$obj_connection->queryDB("SELECT * FROM utente WHERE Mail='".$email."'")){
                $email_error='2';
            }
        }

        $password=hash("sha256",trim($_POST['password']));
        $password=$obj_connection->escape_str($password);
        $pwd_error='';
        if($password==''){
            $pwd_error='1';
        }else{
            if(!$log_query=$obj_connection->queryDB("SELECT * FROM utente WHERE Mail='".$email."' AND PWD='".$password."'")){
                $pwd_error='2';
            }
        }
        /* chiusura connessione */
        $obj_connection->close_connection();


        if($log_query){
            $_SESSION['logged']=true;
            $_SESSION['email']=$email;
            $_SESSION['ID']=$log_query[0]['ID'];
            $_SESSION['permesso']=$log_query[0]['Permessi'];

            if(isset($_SESSION['prev_page'])){
                header('location: '.$_SESSION['prev_page']);
                exit;
            }
            header('location: index.php');
            exit;
        }else{
            header('location: login.php?email_error='.$email_error.'&pwd_error='.$pwd_error);
            exit; 
        }       
    }
?>