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

    include("connessione.php");

    if(!$result = $connessione->query("SELECT * FROM recensione WHERE ID_Utente=2")){
        echo "Non è possibile visualizzare le tue recensioni";
        exit();
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

                if(!$count = $connessione->query("SELECT COUNT(*) AS likes,ID FROM mi_piace AS m, recensione AS r 
                    WHERE r.ID_Utente=2 AND m.ID_Recensione=r.ID GROUP BY r.ID")){
                    $item=str_replace("%NUMERO_MI_PIACE%","",$item);  
                }else{
                    while($like = $count->fetch_array(MYSQLI_ASSOC)){
                        if($like["ID"]==$row["ID"]){
                            $item = str_replace("%NUMERO_MI_PIACE%",$like["likes"],$item);
                        }
                    }
                    $count->free();
                }
                $item=str_replace("%LIKE_FORM%","",$item);
                $list=$list.$item;
            }
        }else{
            $list="";
        }
        $file_content = file_get_contents("../html/lemierecensioni.html");
        echo str_replace("%LIST%",$list,$file_content);

        $result->free();
    }
    $connessione->close();

?>