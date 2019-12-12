<!-- appena si scrive il file che gestisce la session le query vanno modificate inserendo
 l'ID utente della session corrente-->

<?php
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
    
    session_start();

    require_once("connessione.php");
    $obj_connection = new DBConnection();
    $connected = $obj_connection->create_connection();

    $id_utente=$_SESSION["ID"];
    $file_content = file_get_contents('../html/lemierecensioni.html');

    /* Creazione menu */
    require_once('menu_list.php');
    $menuList=new menuList('utente');
    /*$menu=file_get_contents("../components/menu.html");
    $other_elements = '<li><a href="../html/profilo.html">Il mio profilo</a><li>
                        <li class="active">Le mie recensioni</a><li>'.$menu_item->getHTMLItem();*/
    $search='<li><a href="../php/lemierecensioni.php">Le mie recensioni</a><li>';
    $replace='<li class="active">Le mie recensioni<li>';
    
    $menu=str_replace($search,$replace,$menuList->getHTMLmenu());

    $file_content=str_replace("%MENU%",$menu,$file_content);

    /* Recupero lista recensioni dal database */
    if($connected){
        if(!$result = $obj_connection->connessione->query("SELECT * FROM recensione WHERE ID_Utente=$id_utente")){
            $file_content=str_replace("%LIST%","Non è possibile visualizzare le tue recensioni",$file_content);
        }else{
            $list = "";
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
                    $num_likes="";
                    if($likes = $obj_connection->connessione->query("SELECT COUNT(*) AS num FROM mi_piace AS m, recensione AS r 
                        WHERE r.ID_Utente=$id_utente AND m.ID_Recensione=$id_recensione")){
                        $num_likes=$likes->fetch_array(MYSQLI_ASSOC)["num"];
                        $likes->free();
                    }
                    $item=str_replace("%NUMERO_MI_PIACE%",$num_likes,$item);  

                    $item=str_replace("%LIKE_FORM%","",$item);

                    $list=$list.$item;
                }
            }
            $file_content= str_replace("%LIST%",$list,$file_content);

            $result->free();
        }
    }
    echo $file_content;

?>