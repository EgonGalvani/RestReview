<?php 

    require_once("sessione.php");
    require_once('connessione.php');
    if($_SESSION['logged']==true){
        header('location:index.php');
        exit();
    }

    /*Aggiunta header,menu e footer*/
    require_once('addItems.php');
    $page=addItems('../html/registrazione.html');

    $tipo=0;
    $mail='';
    $nome='';
    $cognome='';
    $sesso='ns';
    $datan='';
    $pwd='';
    $pwd2='';
    $piva=NULL;
    $rsoc=NULL;
    $id_foto=0;
    /* se ci sono valori in _POST cerca di fare registrazione o stampa errore */
    if(isset($_POST['registrati'])){
        if(isset($_POST['tipo_utente'])){
            $tipo=$_POST['tipo_utente'];
        }
        if(isset($_POST['email'])){
            $mail=$_POST['email'];
        }
        if(isset($_POST['nome'])){
            $nome=$_POST['nome'];
        }
        if(isset($_POST['cognome'])){
            $cognome=$_POST['cognome'];
        }
        if(isset($_POST['sesso'])){
            $sesso=$_POST['sesso'];
        }
        if(isset($_POST['nascita'])){
            $datan=$_POST['nascita'];
        }
        if(isset($_POST['password'])){
            $pwd=$_POST['password'];
        }
        if(isset($_POST['repeatpassword'])){
            $pwd2=$_POST['repeatpassword'];
        }
        if(isset($_POST['piva'])){
            $piva=$_POST['piva'];
        }
        if(isset($_POST['rsoc'])){
            $rsoc=$_POST['rsoc'];
        }

        /* crea connessione al DB */
        $obj_connection = new DBConnection();

        if($obj_connection->create_connection()){
            
            $tipo=$obj_connection->escape_str(trim($tipo));
            $mail=$obj_connection->escape_str(trim($mail));
            $nome=$obj_connection->escape_str(trim($nome));
            $cognome=$obj_connection->escape_str(trim($cognome));
            $sesso=$obj_connection->escape_str(trim($sesso));
            $datan=$obj_connection->escape_str(trim($datan));
            $pwd=hash("sha256",$obj_connection->escape_str(trim($pwd)));
            $piva=$obj_connection->escape_str(trim($piva));
            $rsoc=$obj_connection->escape_str(trim($rsoc));

            if($tipo==0){//utente
                $permessi="Utente";
                $query=$obj_connection->insertDB("INSERT INTO `utente` (`ID`, `PWD`, `Mail`, `Nome`, `Cognome`, `Data_Nascita`, `ID_Foto`, `Ragione_Sociale`, `P_IVA`, `Permessi`, `Sesso`) VALUES (NULL,\"$pwd\", \"$mail\", \"$nome\", \"$cognome\", \"$datan\", NULL, NULL, NULL, \"$permessi\", \"$sesso\");");
            }else if($tipo==1){//ristoratore
                $permessi="Ristoratore";
                $query=$obj_connection->insertDB("INSERT INTO `utente` (`ID`, `PWD`, `Mail`, `Nome`, `Cognome`, `Data_Nascita`, `ID_Foto`, `Ragione_Sociale`, `P_IVA`, `Permessi`, `Sesso`) VALUES (NULL,\"$pwd\", \"$mail\", \"$nome\", \"$cognome\", \"$datan\", NULL, \"$rsoc\", \"$piva\", \"$permessi\", \"$sesso\");");         
            }

            if(!$query){
                $error="[Errore nell'inserimento dei dati]";
            }else{
                $obj_connection->close_connection();
                header('location: login.php');
                exit;
            }
            $obj_connection->close_connection();
        }else{
            $error="[Errore di connesione al database]";
        }


        $error=str_replace("[","<div>",$error);
        $error=str_replace("]","</div>",$error);
        $page=str_replace("%ERROR%",$error,$page);

    }
    if($tipo==1){
        $page=str_replace('checked="%REC_CHECKED%"',"",$page);
        $page=str_replace('checked="%RIST_CHECKED%"',"checked=\"checked\"",$page);
    }
    else{
        $page=str_replace('checked="%REC_CHECKED%"',"checked=\"checked\"",$page);
        $page=str_replace('checked="%RIST_CHECKED%"',"",$page);
    }
    $page=str_replace("%MAIL_VALUE%",$mail,$page);
    $page=str_replace("%NOME_VALUE%",$nome,$page);
    $page=str_replace("%COGNOME_VALUE%",$cognome,$page);
    $page=str_replace("%DATAN_VALUE%",$datan,$page);
    if($sesso==="ns"){
        $page=str_replace('selected="%SEL_NS%"',"selected=\"selected\"",$page);
        $page=str_replace('selected="%SEL_UOMO%"',"",$page);
        $page=str_replace('selected="%SEL_DONNA%"',"",$page);
        $page=str_replace('selected="%SEL_ALTRO%"',"",$page);
    }else if($sesso==="Uomo"){
        $page=str_replace('selected="%SEL_NS%"',"",$page);
        $page=str_replace('selected="%SEL_UOMO%"',"selected=\"selected\"",$page);
        $page=str_replace('selected="%SEL_DONNA%"',"",$page);
        $page=str_replace('selected="%SEL_ALTRO%"',"",$page);
    }else if($sesso==="Donna"){
        $page=str_replace('selected="%SEL_NS%"',"",$page);
        $page=str_replace('selected="%SEL_UOMO%"',"",$page);
        $page=str_replace('selected="%SEL_DONNA%"',"selected=\"selected\"",$page);
        $page=str_replace('selected="%SEL_ALTRO%"',"",$page);
    }else if($sesso==="Altro"){
        $page=str_replace('selected="%SEL_NS%"',"",$page);
        $page=str_replace('selected="%SEL_UOMO%"',"",$page);
        $page=str_replace('selected="%SEL_DONNA%"',"",$page);
        $page=str_replace('selected="%SEL_ALTRO%"',"selected=\"selected\"",$page);
    }
    $page=str_replace("%PWD1_VALUE%","password",$page);
    $page=str_replace("%PWD2_VALUE%","password",$page);
    $page=str_replace("%PIVA_VALUE%",$piva,$page);
    $page=str_replace("%RSOC_VALUE%",$rsoc,$page);
    echo $page;
?>