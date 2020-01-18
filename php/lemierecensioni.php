<?php
    require_once('sessione.php');
    require_once("connessione.php");
    require_once("addItems.php");
    require_once('recensione.php');

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
                            $list_recensioni.=$recensione->createItemRecensione($id_utente,$_SESSION['permesso']);
                        }
                        $list_recensioni.='</dl>';
                    }else{
                        $list_recensioni='<p>Non hai ancora scritto nessuna recensione</p>';
                    }
                    $query_recensioni->close();
                }else{
                    //query fallita
                }
                $obj_connection->close_connection();
            }else{
                //connessione fallita
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

    //OLD PAGE
    /*
    function stars($num){
        if($num<0 || $num>5){
            return "";
        }
        $stelle="";
        for($i=0;$i<$num;$i++){
            $stelle=$stelle."&#9733;";
        }
        for($i=5;$i>$num;$i--){
            $stelle=$stelle."&#9734;";
        }
        return $stelle;
    }   

    $obj_connection = new DBConnection();
    $connected = $obj_connection->create_connection();
    $id_utente=$_SESSION['ID'];

    
    $page= (new addItems)->add("../html/lemierecensioni.html");
    $page = str_replace('><a href="lemierecensioni.php">Le mie recensioni</a>', 'class="active">Le mie recensioni',$page);

    /* Recupero lista recensioni dal database */
    /*if($connected){
        if(!$result = $obj_connection->connessione->query("SELECT * FROM recensione WHERE ID_Utente=$id_utente")){
            $page=str_replace("%LIST%","Non è possibile visualizzare le tue recensioni",$page);
        }else{
            $list = '<dl class="card_list rec_list">';
            if($result->num_rows>0){
                while($row=$result->fetch_array(MYSQLI_ASSOC)){
                    $item = file_get_contents("../components/recensione_utente_loggato.html");
                    $item = str_replace("%TITOLO%",$row["Oggetto"],$item);
                    $item = str_replace("%DATA%",$row["Data"],$item);
                    $item = str_replace("%CONTENUTO%",$row["Descrizione"],$item);
                    $item = str_replace("%NUMERO_STELLE%",$row["Stelle"],$item);
                    $item = str_replace("%LISTA_STELLE%",stars($row["Stelle"]),$item);
                    $item = str_replace("%ID_RECENSIONE%",$row["ID"],$item);
                    $item = str_replace("%ID_RISTORANTE%",$row["ID_Ristorante"],$item);
                
                    $rest_id=$row["ID_Ristorante"];
                    $rest_name="";
                    if($restaurant= $obj_connection->connessione->query("SELECT Nome FROM ristorante WHERE ID=$rest_id")){
                        $rest_name=$restaurant->fetch_array(MYSQLI_ASSOC)["Nome"];
                        $restaurant->free();
                    }
                    $item=str_replace("%NOME_RISTORANTE%",$rest_name,$item);

                    $id_recensione=$row["ID"];
                    $num_likes="0";

                    if($likes = $obj_connection->connessione->query("SELECT COUNT(*) AS num FROM mi_piace AS m, recensione AS r 
                        WHERE r.ID_Utente=$id_utente AND m.ID_Recensione=$id_recensione")){
                        $num_likes = $likes->fetch_array(MYSQLI_ASSOC)["num"];
                        $likes->free();
                    }

                    $item = str_replace("%NUMERO_MI_PIACE%",$num_likes,$item);  
                    $item = str_replace("%LIKE_FORM%","",$item);

                    $list .= $item;
                }
            }

            $list .= '</dl>';
            $page= str_replace("%LIST%",$list,$page);

            $result->free();
        }
    }*/

    echo $page;

?>