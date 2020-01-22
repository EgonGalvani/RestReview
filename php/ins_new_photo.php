<?php 
    require_once('addItems.php');
    require_once('sessione.php');
    require_once('connessione.php');
    require_once('indirizzo.php');

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
                $page=str_replace('%NOME_RISTORANTE%',$nome_rist,$page);
                $page=str_replace('%INDIRIZZO_RISTORANTE%',$indirizzo,$page);
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