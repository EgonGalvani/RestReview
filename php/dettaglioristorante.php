<?php
    require_once('sessione.php');
    require_once("addItems.php");

    $page= (new addItems)->add("../html/dettaglioristorante.html");

    if(isset($_GET['id'])){
        $id_ristorante=$_GET['id'];
        require_once('connessione.php');
        $obj_connection=new DBConnection();
        if($obj_connection->create_connection()){

            if($result=$obj_connection->connessione->query("SELECT * FROM ristorante WHERE ID=$id_ristorante")){
                $query_result=$obj_connection->queryToArray($result);
                if(count($query_result)>0){
                    $ristorante=$query_result[0];
                    //Breadcrumb
                    $breadcrumb='<a href="index.php">Home</a>&gt&gt'.$ristorante['Nome'];
                    $page=str_replace('%PATH%',$breadcrumb,$page);

                    // il path,descrizione e estensione vanno cercate nel db
                    if($queryFoto=$obj_connection->connessione->query("SELECT f.Path AS Percorso FROM foto AS f, ristorante AS r, corrispondenza AS c WHERE r.ID=$id_ristorante AND r.ID=c.ID_Ristorante AND c.ID_Foto=f.ID")){
                        $arrayFoto=$obj_connection->queryToArray($queryFoto);
                        $page=str_replace('%MAIN_IMG_PATH%',$arrayFoto[0]['Percorso'],$page);
                        $page=str_replace('%MAIN_IMG_DESC%','',$page);
                    }else{
                        $page=str_replace('%MAIN_IMG_PATH%','',$page);
                        $page=str_replace('%MAIN_IMG_DESC%','',$page);
                    }

                    $page=str_replace('%NOME_RISTORANTE%',$ristorante['Nome'],$page);
                    $page=str_replace('%CATEGORIA%',$ristorante['Categoria'],$page);
                    $page=str_replace('%DESCRIZIONE%',$ristorante['Descrizione'],$page);

                    $orario=date("H:i",strtotime($ristorante['Ora_Apertura'])).' - '.date("H:i",strtotime($ristorante['Ora_Chiusura']));
                    $page=str_replace('%ORARI%',$orario,$page); 
                    //mettere insieme orario chiusura, apertura
                    $page=str_replace('%GIORNO_CHIUSURA%',$ristorante['Giorno_Chiusura'],$page);
                    $page=str_replace('%TELEFONO%',$ristorante['Tel'],$page);
                    $page=str_replace('%EMAIL%',$ristorante['Mail'],$page);
                    //indirizzo
                    require_once('indirizzo.php');
                    $indirizzo=new indirizzo($ristorante['Via'],$ristorante['Civico'],$ristorante['Citta'],$ristorante['CAP'],$ristorante['Nazione']);
                    $page=str_replace('%INDIRIZZO%',$indirizzo->getIndirizzo(),$page);
                    $page=str_replace('%SITO%',$ristorante['sito'],$page);
                    //stelle
                    $num_stelle='-';
                    $lista_stelle='';
                    $num_recensioni=0;
                    if($query_star_avg=$obj_connection->connessione->query("SELECT COUNT(Stelle) AS numero, AVG(Stelle) AS media FROM recensione WHERE ID_Ristorante=\"".$id_ristorante."\"")){
                        $array_star_avg=$obj_connection->queryToArray($query_star_avg);
                        if(count($array_star_avg)>0 && $array_star_avg[0]['numero']>0){
                            require_once('stelle.php');
                            $num_stelle=round($array_star_avg[0]['media'],1);
                            $stelle=new stelle($num_stelle);
                            $lista_stelle=$stelle->printStars();
                            $num_recensioni=$array_star_avg[0]['numero'];
                        }
                        $query_star_avg->close();
                    }
                    $page=str_replace('%NUMERO_STELLE%',$num_stelle,$page);
                    $page=str_replace('%LISTA_STELLE%',$lista_stelle,$page);
                    $page=str_replace('%NUMERO_RECENSIONI%',$num_recensioni,$page);

                    $percentages=array(0,0,0,0,0);
                    if($query_star_perc=$obj_connection->connessione->query("SELECT COUNT(*) AS numero, Stelle FROM recensione WHERE ID_Ristorante=\"".$id_ristorante."\" GROUP BY Stelle")){
                        $array_star_perc=$obj_connection->queryToArray($query_star_perc);
                        foreach($array_star_perc as $value){
                            $percentages[$value['Stelle']-1]=round($value['numero']/$num_recensioni*100);
                        }
                        $query_star_perc->close();
                    }
                    $page=str_replace('%1_star_perc%',$percentages[0],$page);
                    $page=str_replace('%2_star_perc%',$percentages[1],$page);
                    $page=str_replace('%3_star_perc%',$percentages[2],$page);
                    $page=str_replace('%4_star_perc%',$percentages[3],$page);
                    $page=str_replace('%5_star_perc%',$percentages[4],$page);

                    $list_recensioni='';
                    //ordinamento
                    if(isset($_GET['ordinamento']) && $_GET['ordinamento']==1){
                        $query="SELECT * FROM recensione WHERE ID_Ristorante=\"".$id_ristorante."\" ORDER BY Data DESC";
                        $recenti='selected="selected"';
                        $votati='';
                        
                    }else{
                        $query="SELECT ID,Data,Stelle,Oggetto,Descrizione,r.ID_Utente,ID_Ristorante,COUNT(*) AS numero FROM mi_piace AS m, recensione AS r 
                        WHERE ID_Ristorante=".$id_ristorante." AND ID_Recensione=ID GROUP BY ID ORDER BY numero DESC";
                        $recenti='';
                        $votati='selected="selected"';
                    }
                    $page=str_replace('%PIU_RECENTI%',$recenti,$page);
                    $page=str_replace('%PIU_VOTATI%',$votati,$page);

                    if($query_recensioni=$obj_connection->connessione->query($query)){
                        $array_recensioni=$obj_connection->queryToArray($query_recensioni);
                        if(count($array_recensioni)>0){
                            $list_recensioni='<dl class="card_list rec_list">';
                            foreach($array_recensioni as $value){
                                require_once('recensione.php');
                                $recensione=new recensione($value);
                                $list_recensioni.=$recensione->createItemRecensione($_SESSION['ID'],$_SESSION['permesso']);
                            }
                            $list_recensioni.='</dl>';
                        }else{
                            $list_recensioni='<p>Non sono presenti recensioni</p>';
                        }
                        $query_recensioni->close();
                    }// errore query
                    $page=str_replace('%LIST%',$list_recensioni,$page);

                    //form inserimento recensione
                    $ins_rec_form='';
                    if($_SESSION['permesso']=='Utente'){
                        $ins_rec_form='<form action="ins_recensione.php" method="post">
                                    <input type="hidden" name="id_ristorante" value="%ID_RIST%"/>
                                    <input type="submit" value="Inserisci recensione" class="btn"/>
                                    </form>';
                    }else{
                        if($_SESSION['permesso']=='Visitatore')
                            $ins_rec_form='<p><a href="login.php">Effettua il login per inserire una recensione</a></p>';
                    }
                    $page=str_replace('%FORM_INSERIMENTO_RECENSIONE%',$ins_rec_form,$page);

                    //form inserimento foto
                    $ins_foto_form='';
                    if($_SESSION['permesso']=='Ristoratore'){
                        $ins_foto_form='<form action="ins_new_photo.php" method="post">
                                            <fieldset>
                                            <input type="hidden" value="%ID_RIST%"/>
                                            <input type="submit" value="Inserisci nuova foto" class="btn" id="new_photo_button" />
                                            </fieldset>
                                        </form>';
                    }
                    $page=str_replace('%FORM_INSERIMENTO_FOTO%',$ins_foto_form,$page);
                    
                    $page=str_replace('%ID_RIST%',$id_ristorante,$page);

                    //eliminazione recensione
                    $msg='';
                    if(isset($_POST['eliminaRec'])){
                        $obj_connection=new DBConnection();
                        $obj_connection->create_connection();
                        if($obj_connection->connessione->query("DELETE FROM recensione WHERE ID=".$_POST['ID_Recensione'])){
                            $msg='<p class="msg_box success_box">Recensione eliminata</p>';
                        }else{
                            $msg='<p class="msg_box error_box">Eliminazione fallita</p>';
                        }
                        $obj_connection->close_connection();
                    }
                    $page=str_replace('%MESSAGGIO%',$msg,$page);

                }else{
                    //ristorante non presente
                    header('location: ../html/404.html');
                    exit;
                }
            }else{
                //errore query DB
            }

        }else{
            //connessione fallita
        }

    }else{
        header('location: ../html/404.html');
        exit;
    }

    echo $page;


?>