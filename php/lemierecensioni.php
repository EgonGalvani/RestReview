<?php
    require_once('sessione.php');
    require_once("connessione.php");
    require_once("addItems.php");
    require_once('recensione.php');
    require_once('errore.php');

    function clearInd($ind,$total_pages){
        for($z=1;$z<=$total_pages;$z++){//Evita che nell'url ci siano robe tipo &pagen=2&pagen=1&pagen=3&pagen=2&pagen=4 mettendo solo la pagina corrente e non tutta la history delle pagine visitate
            $ind=str_replace("&pagen=$z","",$ind);
            $ind=str_replace("?pagen=$z","",$ind);
         }
        return $ind;
    }

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
            $pagesList='';
            $obj_connection = new DBConnection();
            if($obj_connection->create_connection()){
                $id_utente=$_SESSION['ID'];

                $results_per_page = 5;
                $total_pages=1;
                if($query_all_recensioni=$obj_connection->connessione->query("SELECT * FROM recensione WHERE ID_Utente=$id_utente")){
                    $array_all_recensioni=$obj_connection->queryToArray($query_all_recensioni);
                    $total_pages=ceil(count($array_all_recensioni) / $results_per_page);
                }
                //check su pagen passato tramite GET
                if(isset($_GET['pagen']) && (!check_number($_GET['pagen']) || $_GET['pagen']<1 || $_GET['pagen']>$total_pages)){
                    header('location: ../html/404.html');
                    exit;
                }
                if (isset($_GET["pagen"])) { $pagen  = $_GET["pagen"]; } else { $pagen=1; }; 
                $start_from = ($pagen-1) * $results_per_page;

                if($query_recensioni=$obj_connection->connessione->query("SELECT * FROM recensione WHERE ID_Utente=$id_utente LIMIT $start_from,$results_per_page")){
                    $array_recensioni=$obj_connection->queryToArray($query_recensioni);
                    if(count($array_recensioni)>0){
                        $list_recensioni='<dl class="card_list rec_list">';
                        foreach($array_recensioni as $value){
                            $recensione=new recensione($value);
                            $list_recensioni.=$recensione->createRecensioneUtenteLoggato($id_utente,$_SESSION['permesso']);
                        }
                        $list_recensioni.='</dl>';
                        $i=1;
                        $pagesList=" <div class=\"center\"> <div class=\"pagination\">";
                        $ind=$_SERVER['REQUEST_URI'];
                        if($pagen>1){
                            $prec=$pagen-1;
                            $ind=clearInd($ind,$total_pages);
                            $pagesList= $pagesList."\n<a href=\"$ind?pagen=$prec\">&laquo;;Precedente</a>";
                        }
                        while($i<=$total_pages){                
                            $ind=clearInd($ind,$total_pages);
                            if($i!=$pagen){
                                $pagesList= $pagesList."\n<a href=\"$ind?pagen=$i\">$i</a>";
                            }
                            else{
                                $pagesList= $pagesList."<span class=\"active\">$i</span>";
                            }
                            $i++;
                        }
                        if($pagen<$total_pages){
                            $succ=$pagen+1;
                            $pagesList= $pagesList."\n<a href=\"$ind?pagen=$succ\">Successiva&raquo;</a>";
                        }
                        $pagesList= $pagesList."</div></div>";
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
            $page = str_replace('%PAGESLIST%', $pagesList,$page);
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