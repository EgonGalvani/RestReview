<?php 

    require_once("sessione.php");
    if($_SESSION['logged']==true){
        header('location:index.php');
        exit();
    }

    /*Aggiunta header,menu e footer*/
    require_once('addItems.php');
    $page=addItems('../html/registrazione.html');

    $tipo='';
    $mail='';
    $nome='';
    $cognome='';
    $sesso='';
    $datan='';
    $pwd='';
    $pwd2='';
    $piva='';
    $rsoc='';
    /* se ci sono valori in _POST cerca di fare registrazione o stampa errore */
    if(isset($_POST['registrati'])){
        if(isset($_POST['tipo_utente'])){
            $email=$_POST['tipo_utente'];
        }
        if(isset($_POST['email'])){
            $email=$_POST['email'];
        }
        if(isset($_POST['nome'])){
            $email=$_POST['nome'];
        }
        if(isset($_POST['cognome'])){
            $email=$_POST['cognome'];
        }
        if(isset($_POST['sesso'])){
            $email=$_POST['sesso'];
        }
        if(isset($_POST['nascita'])){
            $email=$_POST['nascita'];
        }
        if(isset($_POST['password'])){
            $email=$_POST['password'];
        }
        if(isset($_POST['repeatpassword'])){
            $email=$_POST['repeatpassword'];
        }
        if(isset($_POST['piva'])){
            $email=$_POST['piva'];
        }
        if(isset($_POST['rsoc'])){
            $email=$_POST['rsoc'];
        }

        /* crea connessione al DB */
        require_once('connessione.php');
        $obj_connection = new DBConnection();

        if($obj_connection->create_connection()){
            
            $tipo=$obj_connection->escape_str(trim($tipo));
            $mail=$obj_connection->escape_str(trim($mail));
            $nome=$obj_connection->escape_str(trim($nome));
            $cognome=$obj_connection->escape_str(trim($cognome));
            $sesso=$obj_connection->escape_str(trim($sesso));
            $datan=$obj_connection->escape_str(trim($datan));
            $pwd=hash("sha256",$obj_connection->escape_str(trim($pwd)));
            $piva=$obj_connection->escape_str(trim($piva));
            $rsoc=$obj_connection->escape_str(trim($rsoc));

            if($tipo==0){
                $query=$obj_connection->queryDB("")
            }else{

            }

            if(!$query){
                $error="[Le credenziali inserite non sono corrette]";
            }else{
                $_SESSION['logged']=true;
                $_SESSION['email']=$email;
                $_SESSION['ID']=$log_query[0]['ID'];
                $_SESSION['permesso']=$log_query[0]['Permessi'];

                $obj_connection->close_connection();
                if(isset($_SESSION['prev_page'])){
                    header('location: '.$_SESSION['prev_page']);
                    exit;
                }
                header('location: index.php');
                exit;
            }
            $obj_connection->close_connection();
            }else{
            $error="[Errore di connesione al database]";
            }

        }

        $error=str_replace("[","<div>",$error);
        $error=str_replace("]","</div>",$error);
        $page=str_replace("%ERROR%",$error,$page);
        $page=str_replace("%VALUE_EMAIL%",$email,$page);
        $page=str_replace("%VALUE_PASSWORD%",$pwd,$page);
        $page=str_replace("%CHECKED%",$check,$page);

    }
    echo $page;
?>