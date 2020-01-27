<?php
    require_once('sessione.php');
    require_once('errore.php');
    require_once('addItems.php');

    $page= (new addItems)->add("../html/casuale.html");
    $page=str_replace('><a href="casuale.php">Ristorante casuale</a>', ' class="active">Ristorante casuale',$page);

    $risultato='';
    $error_msg='';

    if(isset($_GET['tipologia'])){
        $tipo=$_GET['tipologia'];
    }else{
        $tipo='default';
    }
    $search='';
    if(isset($_GET['search'])){
        $search=$_GET['search'];

        require_once('connessione.php');
        $obj_connection=new DBConnection();
        
        if($obj_connection->create_connection()){
            $query="SELECT * FROM ristorante WHERE `Citta` LIKE '%$search%' ";
            if($tipo!='default')
                $query.=" AND Categoria=\"$tipo\"";
            if($query_res=$obj_connection->connessione->query($query)){
                if($query_res->num_rows>0){
                    $array_res=$obj_connection->queryToArray($query_res);
                    $query_res->close();
                    $random=rand(0,count($array_res)-1);
                    $ristorante=$array_res[$random];
                    header("location: dettaglioristorante.php?id=".$ristorante['ID']);
                    exit;
                }else{
                    if($tipo=='default'){
                        $risultato="<p>Siamo spiacenti, non ci sono ristoranti nella zona scelta</p>";
                    }else{
                        $risultato="<p>Siamo spiacenti, non ci sono ristoranti di tipo \"$tipo\" nella zona scelta</p>";
                    }
                }
            }else{
                $error=new errore('query');
                $error_msg=$error->printHTMLerror();
            }
            $obj_connection->close_connection();
        }else{
            $error=new errore('DBConnection');
            $error_msg=$error->printHTMLerror();
        }
    }

    $page=str_replace('%SEARCH_VALUE%',$search,$page);
    
    require_once('categoria.php');
    $categorie=new categorie('Ricerca');
    $page=str_replace('%TIPOLOGIA%',$categorie->getHTMLList(),$page);
    foreach($categorie->getCatArray() as $value){
        if($tipo==$value){
            $page=str_replace('%VALUE_'.strtoupper($value).'_CAT%','selected="selected"',$page);
        }else{
            $page=str_replace('%VALUE_'.strtoupper($value).'_CAT%','',$page);
        }
    }


    $page=str_replace('%ERRORI%',$error_msg,$page);
    $page=str_replace('%RISULTATO%',$risultato,$page);

    echo $page;

?>