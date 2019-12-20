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

        $errors=array("nome"=>"",
                            "desc"=>"",
                            "tel"=>"",
                            "email"=>"",
                            "civ"=>"",
                            "cap"=>"");
        $num_errori=0;

        $nome='';
        $desc='';
        $tipo='';
        $tel='';
        $email='';
        $sito='';
        $ora_ap='';
        $ora_chiu='';
        $giorno='';
        $via='';
        $civico='';
        $cap='';
        $citta='';
        $nazione='';

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
            require_once('ristorante.php');
            $ristorante=new ristorante($nome, $desc, $tipo, $tel, $email, $sito, $ora_ap, $ora_chiu,$giorno, $via, $civico,
                             $cap, $citta, $nazione);

            $errors=$ristorante->getErrors();
            $num_errori=$ristorante->numErrors($errors);
           
        }   
        if($num_errori>0){
            $err="[Sono presenti $num_errori campi compilati non correttamente]";
        }else{
            $err='';
        }

        $page=str_replace('%NUM_ERRORI%',$err,$page);
        $page=str_replace('%ERR_NOME%',$errors['nome'],$page);
        $page=str_replace('%ERR_DESC%',$errors['desc'],$page);
        $page=str_replace('%ERR_TEL%',$errors['tel'],$page);
        $page=str_replace('%ERR_EMAIL%',$errors['email'],$page);
        $page=str_replace('%ERR_CIV%',$errors['civ'],$page);
        $page=str_replace('%ERR_CAP%',$errors['cap'],$page);

        $page=str_replace('[','<p class="msg_box err_box">',$page);
        $page=str_replace(']','</p>',$page);

        $page=str_replace('%VALUE_NOME%',$nome,$page);
        $page=str_replace('%VALUE_DESC%',$desc,$page);
        $page=str_replace('%VALUE_EMAIL%',$email,$page);
        $page=str_replace('%VALUE_SITO%',$sito,$page);
        

    }else{
        header('location: access_denied.php');
        exit;
    }

    echo $page;
?>