<?php 
    require_once('sessione.php');
    require_once('addItems.php');
    require_once('connessione.php');
    require_once('indirizzo.php');

    $page= (new addItems)->add("../html/ins_recensione.html");   

    if($_SESSION['logged']==true){
        if($_SESSION['permesso']=='Utente'){
            //gestione errori
            $errors=array("titolo"=>"",
                            "contenuto"=>"");
            $num_errors=0;

            $obj_connection=new DBConnection();

            if(isset($_POST['titolo_recensione'])){

            }
            if($num_errors>0){
                $err="[Sono presenti $num_errori campi compilati non correttamente]";
            }else{
                $err='';
            }
            //reperimento dati ristorante
            $nome_rist='';
            $img_path='';
            $indirizzo='';
            if($obj_connection->create_connection()){
                $query="SELECT f.Path AS Percorso, r.Nome AS Nome, r.Via AS Via, r.Civico AS Civ, r.Citta AS Citta, r.CAP AS CAP, r.Nazione AS Nazione
                         FROM ristorante AS r, corrispondenza AS c, foto AS f 
                         WHERE r.ID=".$_POST['id_ristorante']." AND r.ID=c.ID_Ristorante AND c.ID_Foto=f.ID ";
                if($query_rist=$obj_connection->connessione->query($query)){
                    $array_rist=$obj_connection->queryToArray($query_rist);
                    if(count($array_rist)>0){
                        $nome_rist=$array_rist[0]['Nome'];
                        $img_path=$array_rist[0]['Percorso'];
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
            $page=str_replace('%NOME_RISTORANTE%',$nome_rist,$page);
            $page=str_replace('%URL_IMG%',$img_path,$page);
            $page=str_replace('%INDIRIZZO_RISTORANTE%',$indirizzo,$page);
            $page=str_replace('%ID_RIST%',$_POST['id_ristorante'],$page);
    
            $page=str_replace('%MESSAGGIO%',$err,$page);
            $page=str_replace('%ERR_TITOLO%',$errors['titolo'],$page);
            $page=str_replace('%ERR_CONTENUTO%',$errors['contenuto'],$page);

        }else{
            header('location: access_denied.php');
            exit;
        }
    }else{
        header('location: index.php');
        exit;
    }

    echo $page;
?>