<?php 
    require_once('addItems.php');
    require_once('sessione.php');
    require_once('connessione.php');
    require_once('indirizzo.php');
    require_once('uploadImg.php');

    $page= (new addItems)->add("../html/ins_new_photo.html");

    if($_SESSION['logged']){
        if($_SESSION['permesso']=='Ristoratore'){

            $obj_connection=new DBConnection();
            //reperimento dati ristorante
            if(isset($_POST['id_ristorante'])){

                $nome_rist='';
                $indirizzo='';
                
                if($obj_connection->create_connection()){
                    
                    $query="SELECT r.Nome AS Nome, r.Via AS Via, r.Civico AS Civ, r.Citta AS Citta, r.CAP AS CAP, r.Nazione AS Nazione
                         FROM ristorante AS r 
                         WHERE r.ID=".$_POST['id_ristorante'];
                    if($query_rist=$obj_connection->connessione->query($query)){
                        $array_rist=$obj_connection->queryToArray($query_rist);
                        if(count($array_rist)>0){
                            $nome_rist=$array_rist[0]['Nome'];
                            $indirizzo=(new indirizzo($array_rist[0]['Via'],$array_rist[0]['Civ'],$array_rist[0]['Citta'],$array_rist[0]['CAP'],$array_rist[0]['Nazione']))->getIndirizzo();
                        }
                        $query_rist->close();
                    }else{
                    //query fallita
                    }

                    $obj_connection->close_connection();
                }else{
                //connessione fallita
                }

                //check errori
                $desc_foto='';
                $err='';
                $err_foto='';
                $err_desc='';
                if(isset($_POST['descrizione_foto'])){
                    $desc_foto=htmlentities(trim($_POST['descrizione_foto']));
                    if($desc_foto==''){
                        $err_desc='<p class="msg_box error_box">Inserire una descrizione per la foto</p>';
                        $num_errori++;
                    }
                    /*if(!isset($_FILES["nuova_foto"]['size'])){
                        $err_foto='<p class="msg_box error_box">Inserire una foto</p>';
                        $num_errori++;
                    }*/
                    //inserimento
                    if($num_errori==0){
                        if($_FILES["nuova_foto"]['size'] != 0){
                            $gestImg = new gestImg();
                            $uploadResult = $gestImg->uploadImage("ristoranti/","nuova_foto");
                            if($uploadResult['error']==""){
                                $filePath=$uploadResult['path'];
                            }
                            else{
                                $img_error=$img_error.$uploadResult['error'];
                            }
                    
                            $obj_connection->create_connection();
                            if($filePath!=="../img/ristoranti/" && $uploadResult['error']==""){//è stato caricato qualcosa
                                $obj_connection->connessione->query("INSERT INTO foto VALUES (NULL, \"$filePath\", \"$desc_foto\")");//se arrivo a questo punto inserisco sicuramente qualcosa
                                $queryResult=$obj_connection->connessione->query("SELECT ID FROM foto WHERE Path='".$filePath."'");
                                $arrayResult=$obj_connection->queryToArray($queryResult);
                                $obj_connection->connessione->query("INSERT INTO corrispondenza VALUES (".$arrayResult[0]['ID'].",\"".$_POST['id_ristorante']."\")");
                            }
                            $obj_connection->close_connection();
                            header('location: dettaglioristorante.php?id='.$_POST['id_ristorante']);
                            exit;
                        }
                    }else{
                        $err="[Sono presenti $num_errori campi compilati non correttamente]";
                    }
                }
                $page=str_replace('%MESSAGGIO%',$err,$page);
                $page=str_replace('%ERR_FOTO%',$err_foto,$page);
                $page=str_replace('%ERR_DESC%',$err_desc,$page);
                $page=str_replace('%NOME_RISTORANTE%',$nome_rist,$page);
                $page=str_replace('%INDIRIZZO_RISTORANTE%',$indirizzo,$page);
                $page=str_replace('%DESCRIZIONE_FOTO%',$desc_foto,$page);

                $page=str_replace('%ID_RIST%',$_POST['id_ristorante'],$page);
                $page=str_replace('%PATH_RISTO%','dettaglioristorante.php?id='.$_POST['id_ristorante'],$page);

            }

        }else{
            header('location: access_denied.php');
            exit;
        }

    }else{
        header('location: login.php');
        exit;
    }

    echo $page;

?>