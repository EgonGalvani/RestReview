<?php
function makeCard($id,$obj_connection){
        $approvazione="";
        $list="";
        $queryResult=$obj_connection->connessione->query("SELECT * FROM ristorante WHERE ID=$id");
        while($row=$queryResult->fetch_array(MYSQLI_ASSOC)){
            if($_SESSION['permesso']=="Admin"&&$row['Approvato']=="In attesa"){
                $approvazione="<div><a href=\"approva.php?id=$id\">Approva ristorante </a> <a href=\"rifiuta.php?id=$id\"> Rifuta ristorante</a></div>";
            }
            $nome=$row['Nome'];
            $id=$row['ID'];
            $path="../img/ristoranti/default.jpg";
            $queryImg=$obj_connection->connessione->query("SELECT * FROM `corrispondenza` WHERE `ID_Ristorante`=$id");
            if($queryImg){
                $rowImg=$queryImg->fetch_array(MYSQLI_ASSOC);
                $id_foto=$rowImg['ID_Foto'];
                $queryImg2=$obj_connection->connessione->query("SELECT * FROM `foto` WHERE `ID`=$id_foto");
                if ($queryImg2) {
                    $rowImg=$queryImg2->fetch_array(MYSQLI_ASSOC);
                    $path=$rowImg['Path'];
                }                
            }
            $citta=$row['Citta'];
            $via=$row['Via'];
            $civico=$row['Civico'];
            $nazione=$row['Nazione'];
            $indirizzo=$citta.", ".$via." N° ".$civico.", ".$nazione ;
            $tipologia=$row['Categoria'];
            $stelle=0;
            $queryStelle=$obj_connection->connessione->query("SELECT AVG(Stelle) AS Media FROM `recensione` WHERE `ID_Ristorante`=$id");
            if($queryStelle){
                $rowStelle=$queryStelle->fetch_array(MYSQLI_ASSOC);
                $stelle=round($rowStelle['Media'],1);
                
            }
            $i=0;
            $stelleInt=round($stelle,0);
            $listaStelle="";
            while($i<$stelleInt){
                $listaStelle=$listaStelle."&#9733";
                $i++;
            }
            $i=0;
            while($i<5-$stelleInt){
                $listaStelle=$listaStelle."&#9734";
                $i++;
            }
            $descrizione=$row['Descrizione'];
            $forms="<a href=\"dettaglioristorante.php?id=$id\">Vai al ristorante</a>";
            $list = $list ."
                <dt >$nome</dt>
                <dd>
                    <img class=\"rist_img\" src=\"$path\" alt=\"Immagine principale ristorante $nome\" />      

                    <div class=\"rist_dett\">
                        <span>$indirizzo</span>
                        <span>Categoria: $tipologia</span>

                        <span class=\"stelle_item\">Stelle: $stelle/5 
                            <span class=\"stelle_counter\">$listaStelle</span>
                        </span>

                        <p class=\"rist_descrizione\">$descrizione</p>

                        $forms 
                        $approvazione
                            
                    </div> 
                </dd>
                ";
        }
        return $list;
    }
?>