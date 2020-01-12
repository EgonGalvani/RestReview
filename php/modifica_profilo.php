<?php
    require_once("sessione.php");
    require_once('connessione.php');
    require_once("reg_ex.php");
    require_once('addItems.php');
    require_once("uploadImg.php");
  
    if(!$_SESSION['logged']){
        header('location: access_denied.php');
    }
    
    $page= (new addItems)->add("../html/modifica_profilo.html");
 
    $no_error=true;
    $error='';
    $img_error="";
    $pwd_error="";
    $dati_error="";
    $nome="";
    $cognome="";
    $piva="";
    $rsoc="";
    $oldpath="../img/imgnotfound.jpg";
    $sesso="Sconosciuto";
    $tipo=0;
    //connessione db
    $obj_connection = new DBConnection();
    if(!$obj_connection->create_connection()){
        $error="<div class=\"msg_box error_box\">Errore di connessione al database</div>";
        $no_error=false;
    }
    if($no_error){
        $queryResult=$obj_connection->connessione->query("SELECT * FROM utente WHERE ID='".$_SESSION['ID']."'");
        $row=$queryResult->fetch_array(MYSQLI_ASSOC);
        $nome=$row['Nome'];
        $cognome=$row['Cognome'];
        $sesso=$row['Sesso'];
        $piva=$row['P_IVA'];
        $rsoc=$row['Ragione_Sociale'];
        if($row['Permessi']==="Ristoratore"){
            $tipo=1;
        }
        //query per img profilo
        if($row['ID_Foto']){
            $queryResult=$obj_connection->connessione->query("SELECT * FROM foto WHERE ID='".$row['ID_Foto']."'");
            if($queryResult){
                $row=$queryResult->fetch_array(MYSQLI_ASSOC);
                $page=str_replace($oldpath,$row['Path'],$page);
                $oldpath=$row['Path'];
            }
        }   
    }
    if(isset($_POST['mod_foto'])&&$no_error){
        $filePath="../img/Utenti/";
        if(isset($_FILES['new_foto_profilo'])&&$_FILES['new_foto_profilo']['size'] != 0){
            $uploadResult = uploadImage("Utenti/","new_foto_profilo");
            if($uploadResult['error']==""){
                $filePath=$uploadResult['path'];
            }
            else{
                $img_error=$uploadResult['error'];
            }
        }
        if($filePath!=="../img/Utenti/"&&$uploadResult['error']==""){//è stato caricato qualcosa
            $obj_connection->connessione->query("INSERT INTO `foto` (`ID`, `Path`) VALUES (NULL, \"$filePath\")");//se arrivo a questo punto inserisco sicuramente qualcosa
            $queryResult=$obj_connection->connessione->query("SELECT * FROM foto WHERE Path='".$filePath."'");
            $row=$queryResult->fetch_array(MYSQLI_ASSOC);//C'è sicuramente solo un risultato, quello appena inserito
            $id_foto=$row['ID'] ;
            $id=$_SESSION['ID'];
            $obj_connection->connessione->query("UPDATE `utente` SET `ID_Foto`= '$id_foto' WHERE `utente`.`ID` = $id ");
            $page=str_replace($oldpath,$filePath,$page);
        }
    }
    if(isset($_POST['mod_pwd'])&&$no_error){
        $mod_pwd_no_error=true;
        $hashed_pwd=hash("sha256",$obj_connection->escape_str(trim($_POST['old_password'])));
        $id=$_SESSION['ID'];
        if(!$log_query=$obj_connection->queryDB("SELECT * FROM utente WHERE ID=\"$id\" AND PWD=\"$hashed_pwd\"")){
            $pwd_error=$pwd_error."<div class=\"msg_box error_box\">Vecchia password non corretta.</div>";
            $mod_pwd_no_error=false;
        }
        if($_POST['password']!=$_POST['repeat_pwd']){
            $pwd_error=$pwd_error."<div class=\"msg_box error_box\">Nuova Password e Ripeti Password non coincidono</div>";
            $mod_pwd_no_error=false;
        }
        if(!check_pwd($_POST['password'])){
            $pwd_error=$pwd_error."<div class=\"msg_box error_box\">La password deve essere lunga almeno 8 caratteri, contenere almeno una lettera maiuscola una minuscola e un numero.</div>";
            $mod_pwd_no_error=false;
        }
        if($mod_pwd_no_error){
            $new_pwd=hash("sha256",$obj_connection->escape_str(trim($_POST['password'])));
            $obj_connection->connessione->query("UPDATE `utente` SET `PWD`= '$new_pwd' WHERE `utente`.`ID` = $id ");
            $pwd_error="<div class=\"msg_box success_box\">Password modificata correttamente.</div>";
        }
    }
    if(isset($_POST['mod_prof'])&&$no_error){
        $mod_dati_no_error=true;
        $nome=$_POST['nome'];
        $cognome=$_POST['cognome'];
        $sesso=$_POST['sesso'];
        $id=$_SESSION['ID'];
        if($_SESSION['permesso']==='Ristoratore'){
            $piva=$_POST['piva'];
            $rsoc=$_POST['rsoc'];
        }        
        if(!check_nome($nome)){
            $dati_error=$dati_error."<div class=\"msg_box error_box\">Il nome deve avere lunghezza minima di 2 caratteri e non può presentare numeri al proprio interno.</div>";
            $mod_dati_no_error=false;
        }
        if(!check_nome($cognome)){
            $dati_error=$dati_error."<div class=\"msg_box error_box\">Il cognome deve avere lunghezza minima di 3 caratteri e non può presentare numeri al proprio interno.</div>";
            $mod_dati_no_error=false;
        }
        if($_SESSION['permesso']==='Ristoratore'){
            if(!check_piva($piva)){
                $dati_error=$dati_error."<div class=\"msg_box error_box\">La partita IVA inserita non è corretta.</div>";
                $no_error=false;
            }
        }
        if($mod_dati_no_error){
            if($_SESSION['permesso']==='Ristoratore'){
                $obj_connection->connessione->query("UPDATE `utente` SET `Nome`= '$nome', `Cognome`= '$cognome', `Sesso`= '$sesso', `P_IVA`= '$piva', `Ragione_Sociale`= '$rsoc' WHERE `utente`.`ID` = $id ");
            }
            else{
                $obj_connection->connessione->query("UPDATE `utente` SET `Nome`= '$nome', `Cognome`= '$cognome', `Sesso`= '$sesso' WHERE `utente`.`ID` = $id ");
            }
            header('location: modifica_profilo.php');
        }
         
    }

    $page=str_replace("%ERROR%",$error,$page);
    $page=str_replace("%IMG_ERROR%",$img_error,$page);
    $page=str_replace("%PASSWORD_ERROR%",$pwd_error,$page);
    $page=str_replace("%DATI_ERROR%",$dati_error,$page);
    $page=str_replace("%NOME%",$nome,$page);
    $page=str_replace("%COGNOME%",$cognome,$page);
    if($sesso==="Sconosciuto"){
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
    if($tipo==1){//ristoratore
        $page=str_replace("%P_IVA%",$piva,$page);
        $page=str_replace("%R_SOC%",$rsoc,$page);
    }
    else{///toglie ragione sociale e p iva
        $page=str_replace('<label id="piva_l" for="piva">Partita <abbr title="Imposta su Valore Aggiunto">IVA:</abbr></label>',"",$page);
        $page=str_replace('<input id="piva" type="text" name="piva" value="%P_IVA%" tabindex="11" class="full_width_input"/>',"",$page);
        $page=str_replace('<label id="rsoc_l" for="rsoc">Ragione sociale:</label>',"",$page);
        $page=str_replace('<input id="rsoc" type="text" name="rsoc" value="%R_SOC%" tabindex="12" class="full_width_input"/>',"",$page);
    }

    echo $page;
?>