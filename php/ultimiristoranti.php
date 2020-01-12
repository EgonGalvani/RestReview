<?php
    require_once('sessione.php');
    require_once('addItems.php');
    require_once('connessione.php');
  
    $page= (new addItems)->add("../html/ultimiristoranti.html");
    $page = str_replace('><a href="ultimiristoranti.php">Ultimi ristoranti inseriti</a>', 'class="active">Ultimi ristoranti inseriti',$page);
    $error="";
    $list="";
    $no_error=true;
    $obj_connection = new DBConnection();
    if(!$obj_connection->create_connection()){
        $error=$error."<div class=\"msg_box error_box\">Errore di connessione al database</div>";
        $no_error=false;
    }
    if($no_error){
        $queryResult=$obj_connection->connessione->query("SELECT * FROM ristorante WHERE Approvato='Approvato' ORDER BY ID DESC LIMIT 5");
        while($row=$queryResult->fetch_array(MYSQLI_ASSOC)){
            $nome=$row['Nome'];
            $id=$row['ID'];
            $path="../img/ristoranti/default.jpg";
            $queryImg=$obj_connection->connessione->query("SELECT * FROM `corrispondenza` WHERE `ID_Ristorante`=$id");
            if($queryImg){
                $rowImg=$queryImg->fetch_array(MYSQLI_ASSOC);
                $id_foto=$rowImg['ID_Foto'];
                $queryImg2=$obj_connection->connessione->query("SELECT * FROM `foto` WHERE `ID`=$id_foto");
                $rowImg=$queryImg2->fetch_array(MYSQLI_ASSOC);
                $path=$rowImg['Path'];
            }
            $citta=$row['Citta'];
            $via=$row['Via'];
            $civico=$row['Civico'];
            $nazione=$row['Nazione'];
            $indirizzo=$citta.", ".$via." N° ".$civico.", ".$nazione ;
            $tipologia=$row['Categoria'];
            
            $list=$list."
            <dt >$nome</dt>
            <dd>
                <img class=\"rist_img\" src=\"$path\" alt=\"Immagine principale ristorante $nome\" />      

                <div class=\"rist_dett\">
                    <span>$indirizzo</span>
                    <span>Categoria: $tipologia</span>

                    <span class=\"stelle_item\">Stelle: %NUMERO_STELLE%/5 
                        <span class=\"stelle_counter\">%LISTA_STELLE%</span>
                    </span>

                    <p class=\"rist_descrizione\">%DESCRIZIONE%</p>

                    %FORMS% 
                        
                </div> 
            </dd>
            ";
        }
    }

    $page = str_replace('%ERROR%', $error,$page);
    $page = str_replace('%LIST%', $list,$page);
    echo $page;
?>