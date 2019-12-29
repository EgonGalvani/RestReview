<?php

    require_once('sessione.php');

    require_once("addItems.php");
    $page=addItems('../html/dettaglioristorante.html');

    if(isset($_GET['id'])){
        $id_ristorante=$_GET['id'];
        require_once('connessione.php');
        $obj_connection=new DBConnection();
        if($obj_connection->create_connection()){

            if($query_result=$obj_connection->queryDB("SELECT * FROM ristorante WHERE ID=$id_ristorante")){
                
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
                    if($query_star=$obj_connection->queryDB("SELECT COUNT(Stelle) AS numero, AVG(Stelle) AS media FROM recensione WHERE ID_Ristorante=\"".$id_ristorante."\"")){
                        if(count($query_star)>0 && $query_star[0]['numero']>0){
                            require_once('stelle.php');
                            $num_stelle=round($query_star[0]['media'],1);
                            $stelle=new stelle($num_stelle);
                            $lista_stelle=$stelle->printStars();
                            $num_recensioni=$query_star[0]['numero'];
                        }
                    }
                    $page=str_replace('%NUMERO_STELLE%',$num_stelle,$page);
                    $page=str_replace('%LISTA_STELLE%',$lista_stelle,$page);
                    $page=str_replace('%NUMERO_RECENSIONI%',$num_recensioni,$page);

                    $percentages=array(0,0,0,0,0);
                    if($query_star=$obj_connection->queryDB("SELECT COUNT(*) AS numero, Stelle FROM recensione WHERE ID_Ristorante=\"".$id_ristorante."\" GROUP BY Stelle")){
                        foreach($query_star as $value){
                            $percentages[$value['Stelle']-1]=round($value['numero']/$num_recensioni*100);
                        }
                    }
                    $page=str_replace('%1_star_perc%',$percentages[0],$page);
                    $page=str_replace('%2_star_perc%',$percentages[1],$page);
                    $page=str_replace('%3_star_perc%',$percentages[2],$page);
                    $page=str_replace('%4_star_perc%',$percentages[3],$page);
                    $page=str_replace('%5_star_perc%',$percentages[4],$page);

                    $list_recensioni='';
                    if($query_recensioni=$obj_connection->queryDB("SELECT * FROM recensione WHERE ID_Ristorante=\"".$id_ristorante."\"")){
                        if(count($query_recensioni)>0){
                            $list_recensioni='<dl>';
                            foreach($query_recensioni as $value){
                                require_once('recensione.php');
                                $recensione=new recensione($value);

                                $list_recensioni.=$recensione->createItemRecensione();
                            }
                            $list_recensioni.='</dl>';
                        }else{
                            $list_recensioni='<p>Non sono presenti recensioni</p>';
                        }
                    }// errore query
                    $page=str_replace('%LIST%',$list_recensioni,$page);
                    $page=str_replace('%URL_PAGINA%',basename($_SERVER['REQUEST_URI']),$page);
                    $page=str_replace('%ID_RIST%',$id_ristorante,$page);



                }else{
                    //ristorante non è presente nel DB
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