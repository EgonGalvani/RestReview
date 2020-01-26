<?php
    require_once('sessione.php');
    require_once("connessione.php");
    require_once("addItems.php");
    require_once('recensione.php');
    require_once('errore.php');

    $page= (new addItems)->add("../html/lemierecensioni.html");
    $page = str_replace('><a href="lemierecensioni.php">Le mie recensioni</a>', 'class="active">Le mie recensioni',$page);

    if($_SESSION['logged']==true){
        if($_SESSION['permesso']=='Utente'){
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

            $list_recensioni='';
            $obj_connection = new DBConnection();
            if($obj_connection->create_connection()){
                $id_utente=$_SESSION['ID'];

                if($query_recensioni=$obj_connection->connessione->query("SELECT * FROM recensione WHERE ID_Utente=$id_utente")){
                    $array_recensioni=$obj_connection->queryToArray($query_recensioni);
                    if(count($array_recensioni)>0){
                        $list_recensioni='<dl class="card_list rec_list">';
                        foreach($array_recensioni as $value){
                            $recensione=new recensione($value);
                            $list_recensioni.=$recensione->createRecensioneUtenteLoggato($id_utente,$_SESSION['permesso']);
                        }
                        $list_recensioni.='</dl>';
                    }else{
                        $list_recensioni='<p>Non hai ancora scritto nessuna recensione</p>';
                    }
                    $query_recensioni->close();
                }else{
                    //query fallita
                    $page= (new addItems)->add("../html/base.html");
                    $page=str_replace('%PATH%','Ricerca',$page);
                    $page=str_replace('%MESSAGGIO%',(new errore('query'))->printHTMLerror(),$page);
                    echo $page;
                    exit;
                }
                $obj_connection->close_connection();
            }else{
                //connessione fallita
                $page= (new addItems)->add("../html/base.html");
                $page=str_replace('%PATH%','Ricerca',$page);
                $page=str_replace('%MESSAGGIO%',(new errore('DBConnection'))->printHTMLerror(),$page);
                echo $page;
                exit;
            }
            $page=str_replace('%MESSAGGIO%',$msg,$page);
            $page=str_replace('%LIST%',$list_recensioni,$page);
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