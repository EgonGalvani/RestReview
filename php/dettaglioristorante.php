<?php
    require_once('sessione.php');
    require_once("addItems.php");
    require_once('errore.php');

    function clearInd($ind,$total_pages){
        for($z=1;$z<=$total_pages;$z++){//Evita che nell'url ci siano robe tipo &pagen=2&pagen=1&pagen=3&pagen=2&pagen=4 mettendo solo la pagina corrente e non tutta la history delle pagine visitate
            $ind=str_replace("&pagen=$z","",$ind);
         }
        return $ind;
    }

    $page= (new addItems)->add("../html/dettaglioristorante.html");

    if(isset($_GET['id'])){
        $id_ristorante=$_GET['id'];
        require_once('connessione.php');
        $obj_connection=new DBConnection();
        if($obj_connection->create_connection()){
            if($result=$obj_connection->connessione->query("SELECT * FROM ristorante WHERE ID=$id_ristorante")){
                $query_result=$obj_connection->queryToArray($result);
                $result->close();
                if(count($query_result)>0){
                    $ristorante=$query_result[0];
                    //Breadcrumb
                    $breadcrumb='<a href="index.php">Home</a> &#8250; '.$ristorante['Nome'];
                    $page=str_replace('%PATH%',$breadcrumb,$page);

                    // il path e descrizione vanno cercate nel db
                    $extra_foto='';
                    if($queryFoto=$obj_connection->connessione->query("SELECT f.Path AS Percorso, f.Descrizione AS Descrizione FROM foto AS f, ristorante AS r, corrispondenza AS c WHERE r.ID=$id_ristorante AND r.ID=c.ID_Ristorante AND c.ID_Foto=f.ID ORDER BY f.ID ASC")){
                        $arrayFoto=$obj_connection->queryToArray($queryFoto);
                        if(count($arrayFoto)>0){  
                            $page=str_replace('%MAIN_IMG_PATH%',$arrayFoto[0]['Percorso'],$page);
                            $page=str_replace('%MAIN_IMG_DESC%',$arrayFoto[0]['Descrizione'],$page);
                            for($i=1;$i<count($arrayFoto);$i++){
                                $extra_foto.='<img class="photoes" src="'.$arrayFoto[$i]['Percorso'].'" alt="'.$arrayFoto[$i]['Descrizione'].'" />';
                            }
                        }else{
                            $page=str_replace('%MAIN_IMG_PATH%','',$page);
                            $page=str_replace('%MAIN_IMG_DESC%','',$page);
                        }
                    }else{
                        $page=str_replace('%MAIN_IMG_PATH%','',$page);
                        $page=str_replace('%MAIN_IMG_DESC%','',$page);
                    }
                    $page=str_replace('%EXTRA_PHOTO%',$extra_foto,$page);

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
                        $query="SELECT * FROM recensione WHERE ID_Ristorante=".$id_ristorante." ORDER BY Data DESC";
                        $recenti='selected="selected"';
                        $votati='';
                        
                    }else{
                        $query="SELECT ID,Data,Stelle,Oggetto,Descrizione,r.ID_Utente,ID_Ristorante,COUNT(*) AS numero FROM mi_piace AS m RIGHT OUTER JOIN recensione AS r ON ID_Recensione=ID
                        WHERE ID_Ristorante=".$id_ristorante." GROUP BY ID ORDER BY numero DESC";
                        $recenti='';
                        $votati='selected="selected"';
                    }
                    $page=str_replace('%PIU_RECENTI%',$recenti,$page);
                    $page=str_replace('%PIU_VOTATI%',$votati,$page);

                    $results_per_page = 5;
                    $pagesList="";
                    $total_pages=1;
                    if($query_all_recensioni=$obj_connection->connessione->query($query)){
                        $array_all_recensioni=$obj_connection->queryToArray($query_all_recensioni);
                        $total_pages=ceil(count($array_all_recensioni) / $results_per_page);
                    }

                    //recupero lista recensioni
                    if (isset($_GET["pagen"])) { $pagen  = $_GET["pagen"]; } else { $pagen=1; }; 
                    $start_from = ($pagen-1) * $results_per_page;
                    $query.=" LIMIT $start_from,$results_per_page";

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
                    }else{
                        $page=str_replace('%LIST%',(new errore('query'))->printHTMLerror(),$page);
                    }
                    $page=str_replace('%LIST%',$list_recensioni,$page);
                    $i=1;
                    $pagesList=" <div class=\"center\"> <div class=\"pagination\">";
                    $ind=$_SERVER['REQUEST_URI'];
                    if($pagen>1){
                        $prec=$pagen-1;
                        $ind=clearInd($ind,$total_pages);
                        $pagesList= $pagesList."\n<a href=\"$ind&pagen=$prec\">&laquoPrecedente</a>";
                    }
                    while($i<=$total_pages){                
                        $ind=clearInd($ind,$total_pages);
                        if($i!=$pagen){
                            $pagesList= $pagesList."\n<a href=\"$ind&pagen=$i\">$i</a>";
                        }
                        else{
                            $pagesList= $pagesList."<span class=\"active\">$i</span>";
                        }
                        $i++;
                    }
                    if($pagen<$total_pages){
                        $succ=$pagen+1;
                        $pagesList= $pagesList."\n<a href=\"$ind&pagen=$succ\">Successiva&raquo</a>";
                    }
                    $pagesList= $pagesList."</div></div>";
                    $page = str_replace('%PAGESLIST%', $pagesList,$page);

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
                    if($_SESSION['permesso']=='Ristoratore'&& $_SESSION['ID']==$ristorante['ID_Proprietario']){
                        $ins_foto_form='<form action="ins_new_photo.php" method="post">
                                            <fieldset>
                                            <input type="hidden" name="id_ristorante" value="%ID_RIST%"/>
                                            <input type="submit" value="Inserisci nuova foto" class="btn" id="new_photo_button" />
                                            </fieldset>
                                        </form>';
                    }
                    $page=str_replace('%FORM_INSERIMENTO_FOTO%',$ins_foto_form,$page);
                    
                    $page=str_replace('%ID_RIST%',$id_ristorante,$page);

                    //eliminazione recensione
                    $msg='';
                    if(isset($_POST['eliminaRec'])){
                        if($obj_connection->connessione->query("DELETE FROM recensione WHERE ID=".$_POST['ID_Recensione'])){
                            $msg='<p class="msg_box success_box">Recensione eliminata</p>';
                        }else{
                            $msg='<p class="msg_box error_box">Eliminazione fallita</p>';
                        }
                    }
                    $page=str_replace('%MESSAGGIO%',$msg,$page);

                }else{
                    //ristorante non presente
                    header('location: ../html/404.html');
                    exit;
                }
            }else{
                //errore query DB
                $page= (new addItems)->add("../html/base.html");
                $page=str_replace('%PATH%','Ricerca',$page);
                $page=str_replace('%MESSAGGIO%',(new errore('query'))->printHTMLerror(),$page);
            }

        }else{
            //connessione fallita
            $page= (new addItems)->add("../html/base.html");
            $page=str_replace('%PATH%','Ricerca',$page);
            $page=str_replace('%MESSAGGIO%',(new errore('DBConnection'))->printHTMLerror(),$page);
        }
        $obj_connection->close_connection();
    }else{
        header('location: ../html/404.html');
        exit;
    }

    echo $page;


?>