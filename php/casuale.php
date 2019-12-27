<?php

    require_once('sessione.php');
    require_once('errore.php');

    require_once("addItems.php");
    $page=addItems('../html/casuale.html');

    $page=str_replace('<li><a href="casuale.php">Ristorante casuale</a></li>',
                    '<li class="active">Ristorante casuale</li>',$page);

    require_once('categoria.php');
    $page=str_replace('%TIPOLOGIA%',$list_categorie,$page);

    $risultato='';
    $error_msg='';
    if(isset($_GET['search'])){
        $search=$_GET['search'];

        $tipo='';
        if(isset($_GET['tipologia'])){
            $tipo=$_GET['tipologia'];
        }

        require_once('connessione.php');
        $obj_connection=new DBConnection();
        
        if($obj_connection->create_connection()){

            if($query_res=$obj_connection->queryDB("SELECT * FROM ristorante WHERE Citta=\"$search\" AND Categoria=\"$tipo\"")){
                if(count($query_res)>0){
                    $random=rand(0,count($query_res)-1);
                    $ristorante=$query_res[$random];

                    $risultato=file_get_contents('../components/item_ristorante.html');
                    $risultato=str_replace('%NOME%',$ristorante['Nome'],$risultato);

                    require_once('indirizzo.php');
                    $indirizzo=new indirizzo($ristorante['Via'],$ristorante['Civico'],$ristorante['Citta'],$ristorante['CAP'],$ristorante['Nazione']);
                    $risultato=str_replace('%INDIRIZZO%',$indirizzo->getIndirizzo(),$risultato);
                    $risultato=str_replace('%TIPOLOGIA%',$ristorante['Categoria'],$risultato);

                    //stelle
                    if($query_star=$obj_connection->queryDB("SELECT COUNT(Stelle) AS numero, AVG(Stelle) AS media FROM recensione WHERE ID_Ristorante=\"".$ristorante['ID']."\"")){
                        if(count($query_star)>0 && $query_star[0]['numero']>0){
                            require_once('stelle.php');
                            $num_stelle=round($query_star[0]['media'],1);
                            $stelle=new stelle($num_stelle);
                            $lista_stelle=$stelle->printStars();
                        }else{
                            $num_stelle='-';
                            $lista_stelle='';
                        }
                    }else{
                        $num_stelle='-';
                        $lista_stelle='';
                    }
                    $risultato=str_replace('%NUMERO_STELLE%',$num_stelle,$risultato);
                    $risultato=str_replace('%LISTA_STELLE%',$lista_stelle,$risultato);

                    $risultato=str_replace('%DESCRIZIONE%',$ristorante['Descrizione'],$risultato);

                    require_once('addForms.php');
                    $dettaglioForm = new formRistorante('Dettaglio',$ristorante['ID']);
                    $risultato=str_replace('%FORMS%',$dettaglioForm->getForm(),$risultato);
                }else{
                    $risultato="Siamo spiacenti, non ci sono ristoranti di questo tipo nella zona scelta";
                }
            }else{
                $risultato="";
                $error=new errore('query');
                $error_msg=$error->printHTMLerror();
            }
            $obj_connection->close_connection();
        }else{
            $error=new errore('DBConnection');
            $error_msg=$error->printHTMLerror();
        }

    }
    $page=str_replace('%ERRORI%',$error_msg,$page);
    $page=str_replace('%RISULTATO%',$risultato,$page);

    echo $page;

?>