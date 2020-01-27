<?php
    require_once('sessione.php');
    require_once("addItems.php");
    require_once('connessione.php');
    require_once('ristorante.php');
    require_once('errore.php');

    $page= (new addItems)->add("../html/imieirist.html");
    $page=str_replace('><a href="imieirist.php?type=0">I miei ristoranti</a>', ' class="active">I miei ristoranti',$page);
    $msg='';
    if($_SESSION['logged']==true){
        if($_SESSION['permesso']=='Ristoratore'){
            //eliminazione ristorante
            if(isset($_POST['eliminaRist'])){
                $obj_connection=new DBConnection();
                if($obj_connection->create_connection()){
                    if($obj_connection->connessione->query("DELETE FROM ristorante WHERE ID=".$_POST['id'])){
                        $msg='<p class="msg_box success_box">Ristorante eliminato</p>';
                    }else{
                        $msg='<p class="msg_box error_box">Eliminazione fallita</p>';
                    }
                    $obj_connection->close_connection();
                }else{
                    $msg='<p class="msg_box error_box">Eliminazione fallita, non è stato possibile connettersi al Database</p>';
                }
            }
            //tab ristoranti approvati
            $tab='';
            if(isset($_GET['type'])){
                switch($_GET['type']){
                    case 0: {
                        $tab='<span class="tab_item active_tab">Approvati</span>
                        <a class="tab_item" href="imieirist.php?type=1">In fase di approvazione</a>
                        <a class="tab_item" href="imieirist.php?type=2">Rifiutati</a>';
                        $stato='Approvato';
                    break;
                    }
                    case 1: {
                        $tab='<a class="tab_item" href="imieirist.php?type=0">Approvati</a>
                        <span class="tab_item active_tab">In fase di approvazione</span>
                        <a class="tab_item" href="imieirist.php?type=2">Rifiutati</a>';
                        $stato='In attesa';
                    break;
                    }
                    case 2: {
                        $tab='<a class="tab_item" href="imieirist.php?type=0">Approvati</a>
                        <a class="tab_item" href="imieirist.php?type=1">In fase di approvazione</a>
                        <span class="tab_item active_tab">Rifiutati</span>';
                        $stato='Non approvato';
                    break;
                    }
                }
                $page=str_replace('%TAB_MENU_CONTENT%',$tab,$page);

                $obj_connection=new DBConnection();
                if($obj_connection->create_connection()){
                    $query="SELECT * FROM ristorante WHERE ID_Proprietario=".$_SESSION['ID']." AND Approvato=\"$stato\"";
                    if($query_rist=$obj_connection->connessione->query($query)){
                        $array_rist=$obj_connection->queryToArray($query_rist);
                        if(count($array_rist)>0){
                            $list_ristoranti='<dl class="card_list rist_list">';
                            foreach($array_rist as $value){
                                $ristorante=new ristorante($value);
                                $list_ristoranti.=$ristorante->createItemRistorante();
                            }
                            $list_ristoranti.='</dl>';
                        }else{
                            $list_ristoranti='<p>Non sono presenti ristoranti</p>';
                        }
                        $page=str_replace('%LIST%',$list_ristoranti,$page);
                    }else{
                        //errore nella query
                        $page= (new addItems)->add("../html/base.html");
                        $page=str_replace('%PATH%','Ricerca',$page);
                        $page=str_replace('%MESSAGGIO%',(new errore('query'))->printHTMLerror(),$page);
                    }
                    $obj_connection->close_connection();
                }else{
                    //errore di connessione
                    $page= (new addItems)->add("../html/base.html");
                    $page=str_replace('%PATH%','Ricerca',$page);
                    $page=str_replace('%MESSAGGIO%',(new errore('DBConnection'))->printHTMLerror(),$page);
                }
                

            }else{
                //reindirizzamento se non è definito il type
                header('location: 404.php');
                exit;
            }

        }else{
            header('location: access_denied.php');
            exit;
        }
    }else{
        header('location: index.php');
        exit;
    }
    $page=str_replace('%MESSAGGIO%',$msg,$page);
    echo $page;
?>