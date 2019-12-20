<?php

    require_once("sessione.php");

    //check se loggato
    if($_SESSION['logged']==false){
        header('location: login.php');
        exit;
    }

    require_once("addItems.php");
    $page=addItems('../html/ins_rist.html');

    if($_SESSION['permesso']=='Ristoratore'){

        $error='';
        $errori=0;
        $nome='';
        $desc='';
        $tipo='';
        $tel='';
        $email='';
        $

        /* controllo se è stato fatto il submit */
        if(isset($_POST['nome'])){
            $nome=$_POST['nome'];
            
            // check sul nome

            if(isset($_POST['b_descrizione'])){
                $desc=$_POST['b_descrizione'];
            }

            if(isset($_POST['tipologia'])){
                $tipo=$_POST['tipologia'];
            }

            if(isset($_POST['telefono'])){
                $tel=$_POST['telefono'];
            }

            //check telefono

            if(isset($_POST['email'])){
                $email=$_POST['email'];
            }

            //check email

            if(isset($_POST['sito'])){
                $sito=$_POST['sito'];
            }

            //check sito

            if(isset($_POST['o_apertura'])){
                $ora_ap=$_POST['o_apertura'];
            }

            if(isset($_POST['o_chiusura'])){
                $ora_chiu=$_POST['o_chiusura'];
            }
             /*
                FARE PER RADIO BUTTON
             */

            if(isset($_POST['via'])){
                $via=$_POST['via'];
            }
            if(isset($_POST['civico'])){
                $civico=$_POST['civico'];
            }

            //check civico

            if(isset($_POST['citta'])){
                $citta=$_POST['citta'];
            }
            if(isset($_POST['cap'])){
                $cap=$_POST['cap'];
            }

            //check cap

            if(isset($_POST['nazione'])){
                $nazione=$_POST['nazione'];
            }
            /*
                FARE PER IMMAGINI
            */
        }
        

    }else{
        header('location: access_denied.php');
        exit;
    }

    echo $page;
?>