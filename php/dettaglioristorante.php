<?php

    require_once('sessione.php');

    require_once("addItems.php");
    $page=addItems('../html/dettaglioristorante.html');

    if(isset($_GET['id'])){
        $id_ristorante=$_GET['id'];
        require_once('connessione.php');
        $obj_connection=new DBConnection();
        if($obj_connection->create_connection()){

            if($result=$obj_connection->connessione->query("SELECT * FROM ristorante WHERE ID=$id_ristorante")){
                $query_result=$obj_connection->queryToArray($result);
                if(count($query_result)>0){
                    $ristorante=$query_result[0];

                    $page=str_replace('%NOME_RISTORANTE%',$ristorante['Nome'],$page);
                    $page=str_replace('%CATEGORIA%',$ristorante['Categoria'],$page);
                    $page=str_replace('%DESCRIZIONE%',$ristorante['Descrizione'],$page);

                    $orario=$ristorante['Ora_Apertura'].' - '.$ristorante['Ora_Chiusura'];
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
                    $query="SELECT * FROM recensione WHERE ID_Ristorante=\"".$id_ristorante."\"";
                    if(isset($_GET['ordinamento']) && $_GET['ordinamento']==1){
                        $query.=" ORDER BY Data DESC";
                        $recenti='selected="selected"';
                        $votati='';
                        
                    }else{
                        $query.=" ORDER BY Stelle DESC";
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
                    $page=str_replace('%ID_RIST%',$id_ristorante,$page);



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
        //reindirizzamento altra pagina
    }

    echo $page;


?>