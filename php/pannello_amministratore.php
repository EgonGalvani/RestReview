<?php
    require_once('sessione.php');
    require_once('addItems.php');
    require_once('connessione.php');
    require_once("makeRestaurantCard.php");
    if($_SESSION['permesso']!="Admin"){
        header('location: access_denied.php');
    }
    $page =(new addItems)->add("../html/pannello_amm.html");
    $error="";
    $list='<h1>Ristoranti in attesa di approvazione</h1><dl class="card_list rist_list">';
    $no_error=true;
    $obj_connection = new DBConnection();
    if(!$obj_connection->create_connection()){
        $error=$error."<div class=\"msg_box error_box\">Errore di connessione al database</div>";
        $no_error=false;
    }
    if($no_error){
        if(isset($_POST['ins_cat'])){
            $cat=$_POST['nome_categoria'];
            $cat=$obj_connection->escape_str(trim(htmlentities($cat)));
            $obj_connection->connessione->query("INSERT INTO `categoria` (`Nome`) VALUES ('$cat')");
            $error=$error."<div class=\"msg_box success_box\">Inserimento avvenuto con successo</div>";
        }
        $queryResult=$obj_connection->connessione->query("SELECT ID FROM `ristorante` WHERE Approvato='In attesa'");
        while($row=$queryResult->fetch_array(MYSQLI_ASSOC)){
            $list=$list.makeCard($row['ID'],$obj_connection);
        }
    }
    $list .= "</dl>";
    $page = str_replace('%ERROR%', $error,$page);
    $page = str_replace('%LIST%', $list,$page);
    echo $page;
?>