<?php
    require_once("sessione.php");
    require_once("uploadImg.php");
    require_once('connessione.php');
    require_once("addItems.php");

    //check se loggato
    if($_SESSION['logged']==false){
        header('location: login.php');
        exit;
    }
    
    $page= (new addItems)->add("../html/ins_ristorante.html");
   
    if($_SESSION['permesso']=='Ristoratore'){

        $errors=array("nome"=>"",
                    "desc"=>"",
                    "cat"=>"",
                    "tel"=>"",
                    "email"=>"",
                    "sito"=>"",
                    "ora_ap"=>"",
                    "ora_chiu"=>"",
                    "giorno"=>"",
                    "via"=>"",
                    "civ"=>"",
                    "citta"=>"",
                    "cap"=>"",
                    "naz"=>"");
        $num_errori=0;
        $img_error='';

        $nome='';
        $desc='';
        $categoria='default';
        $tel='';
        $email='';
        $sito='';
        $ora_ap='';
        $ora_chiu='';
        $arr_giorno=array("lun"=>"",
                    "mar"=>"",
                    "mer"=>"",
                    "gio"=>"",
                    "ven"=>"",
                    "sab"=>"",
                    "dom"=>"");
        $via='';
        $civico='';
        $cap='';
        $citta='';
        $nazione='';
        $main_foto_desc='';
        $desc_img_1='';
        $desc_img_2='';
        $desc_img_3='';

        /* controllo se è stato fatto il submit */
        if(isset($_POST['nome'])){
            $nome=htmlentities(trim($_POST['nome']));

            if(isset($_POST['b_descrizione'])){
                $desc=htmlentities(trim($_POST['b_descrizione']));
            }

            if(isset($_POST['categoria'])){
                $categoria=htmlentities(trim($_POST['categoria']));
            }

            if(isset($_POST['telefono'])){
                $tel=htmlentities(trim($_POST['telefono']));
            }

            if(isset($_POST['email'])){
                $email=htmlentities(trim($_POST['email']));
            }

            if(isset($_POST['sito'])){
                $sito=htmlentities(trim($_POST['sito']));
            }

            if(isset($_POST['o_apertura'])){
                $ora_ap=htmlentities(trim($_POST['o_apertura']));
            }

            if(isset($_POST['o_chiusura'])){
                $ora_chiu=htmlentities(trim($_POST['o_chiusura']));
            }
            
            if(isset($_POST['free_day'])){
                $giorno=htmlentities(trim($_POST['free_day']));
                $arr_giorno["$giorno"]='checked="checked"';
            }else{
                $giorno='';
            }

            if(isset($_POST['via'])){
                $via=htmlentities(trim($_POST['via']));
            }
            if(isset($_POST['civico'])){
                $civico=htmlentities(trim($_POST['civico']));
            }

            if(isset($_POST['citta'])){
                $citta=htmlentities(trim($_POST['citta']));
            }
            if(isset($_POST['cap'])){
                $cap=htmlentities(trim($_POST['cap']));
            }

            if(isset($_POST['nazione'])){
                $nazione=htmlentities(trim($_POST['nazione']));
            }

            //immagini
            if(isset($_POST['main_photo_description'])){
                $main_foto_desc=htmlentities(trim($_POST['main_photo_description']));
            }
            
            require_once('ristorante.php');
            $rist_fields=array("Nome"=>$nome,
                                "Descrizione"=> $desc,
                                "Categoria"=> $categoria,
                                "Tel"=> $tel,
                                "Mail"=> $email,
                                "sito"=> $sito,
                                "Ora_Apertura"=> $ora_ap,
                                "Ora_Chiusura"=> $ora_chiu,
                                "Giorno_Chiusura"=> $giorno, 
                                "Via"=> $via,
                                "Civico"=> $civico,
                                "CAP"=>$cap,
                                "Citta"=> $citta,
                                "Nazione"=> $nazione);
            $ristorante=new ristorante($rist_fields);

            $errors=$ristorante->getErrors();
            $num_errori=$ristorante->numErrors($errors);
           
            //Inserimento
            if($num_errori==0){
                if($insert=$ristorante->insertIntoDB()){
                    $page=str_replace('%MESSAGGIO%','<p class="msg_box">Inserimento avvenuto con successo</p>',$page);
                
                    if($_FILES["main_photo"]['size'] != 0){
                        $uploadResult = uploadImage("ristoranti/","main_photo");
                        if($uploadResult['error']==""){
                            $filePath=$uploadResult['path'];
                        }
                        else{
                            $img_error=$img_error.$uploadResult['error'];
                        }
                    }
                    $obj_connection=new DBConnection();
                    $obj_connection->create_connection();
                    if($filePath!=="../img/ritoranti/" && $uploadResult['error']==""){//è stato caricato qualcosa
                        $obj_connection->connessione->query("INSERT INTO `foto` (`ID`, `Path`) VALUES (NULL, \"$filePath\")");//se arrivo a questo punto inserisco sicuramente qualcosa
                        $queryResult=$obj_connection->connessione->query("SELECT ID FROM foto WHERE Path='".$filePath."'");
                        $arrayResult=$obj_connection->queryToArray($queryResult);
                        $obj_connection->connessione->query("INSERT INTO corrispondenza VALUES (".$arrayResult[0]['ID'].",\"$insert\")");
                    }
                    header('location: imieirist.php?type=0');
                    exit;
                }else{
                    $page=str_replace('%MESSAGGIO%','<p class="msg_box error_box">Inserimento fallito</p>',$page);
                }
            }
        }   
        if($num_errori>0){
            $err="[Sono presenti $num_errori campi compilati non correttamente]";
        }else{
            $err='';
        }

        $page=str_replace('%MESSAGGIO%',$err,$page);
        $page=str_replace('%ERR_NOME%',$errors['nome'],$page);
        $page=str_replace('%ERR_DESC%',$errors['desc'],$page);
        $page=str_replace('%ERR_CAT%',$errors['cat'],$page);
        $page=str_replace('%ERR_TEL%',$errors['tel'],$page);
        $page=str_replace('%ERR_EMAIL%',$errors['email'],$page);
        $page=str_replace('%ERR_SITO%',$errors['sito'],$page);
        $page=str_replace('%ERR_OR_AP%',$errors['ora_ap'],$page);
        $page=str_replace('%ERR_OR_CH%',$errors['ora_chiu'],$page);
        $page=str_replace('%ERR_GIORNO%',$errors['giorno'],$page);
        $page=str_replace('%ERR_VIA%',$errors['via'],$page);
        $page=str_replace('%ERR_CIV%',$errors['civ'],$page);
        $page=str_replace('%ERR_CITTA%',$errors['citta'],$page);
        $page=str_replace('%ERR_CAP%',$errors['cap'],$page);
        $page=str_replace('%ERR_NAZ%',$errors['naz'],$page);
        $page=str_replace('%ERR_IMG%',$img_error,$page);

        $page=str_replace('[','<p class="msg_box error_box">',$page);
        $page=str_replace(']','</p>',$page);

        $page=str_replace('%VALUE_NOME%',$nome,$page);
        $page=str_replace('%VALUE_DESC%',$desc,$page);
        
        require_once("categoria.php");
        $category=new categorie('Inserimento');
        $page=str_replace('%CATEGORIA%',$category->getHTMLList(),$page);
        foreach($category->getCatArray() as $value){
            if($categoria==$value){
                $page=str_replace('%VALUE_'.strtoupper($value).'_CAT%','selected="selected"',$page);
            }else{
                $page=str_replace('%VALUE_'.strtoupper($value).'_CAT%','',$page);
            }
        }

        $page=str_replace('%VALUE_CAT%',$categoria,$page);
        $page=str_replace('%VALUE_TEL%',$tel,$page);
        $page=str_replace('%VALUE_EMAIL%',$email,$page);
        $page=str_replace('%VALUE_SITO%',$sito,$page);
        $page=str_replace('%VALUE_OR_AP%',$ora_ap,$page);
        $page=str_replace('%VALUE_OR_CH%',$ora_chiu,$page);
        $page=str_replace('%LUN%',$arr_giorno['lun'],$page);
        $page=str_replace('%MAR%',$arr_giorno['mar'],$page);
        $page=str_replace('%MER%',$arr_giorno['mer'],$page);
        $page=str_replace('%GIO%',$arr_giorno['gio'],$page);
        $page=str_replace('%VEN%',$arr_giorno['ven'],$page);
        $page=str_replace('%SAB%',$arr_giorno['sab'],$page);
        $page=str_replace('%DOM%',$arr_giorno['dom'],$page);
        $page=str_replace('%VALUE_VIA%',$via,$page);
        $page=str_replace('%VALUE_CIV%',$civico,$page);
        $page=str_replace('%VALUE_CITTA%',$citta,$page);
        $page=str_replace('%VALUE_CAP%',$cap,$page);
        $page=str_replace('%VALUE_NAZ%',$nazione,$page);
        $page=str_replace('%DESC_MAIN_IMG%',$main_foto_desc,$page);
        $page=str_replace('%DESC_1_IMG%',$desc_img_1,$page);
        $page=str_replace('%DESC_2_IMG%',$desc_img_2,$page);
        $page=str_replace('%DESC_3_IMG%',$desc_img_3,$page);

        

    }else{
        header('location: access_denied.php');
        exit;
    }

    echo $page;
?>