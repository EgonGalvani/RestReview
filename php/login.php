<?php 

    require_once("sessione.php");
    if($_SESSION['logged']==true){
        header('location:index.php');
        exit();
    }

    /*Aggiunta header,menu e footer*/
    require_once('addItems.php');
    $page=addItems('../html/login.html');

    $email='';
    $pwd='';
    $check='';
    $error='';
    /* se ci sono valori in _POST cerca di fare il login o stampa errore */
    if(isset($_POST['email'])){
        $email=$_POST['email'];
        if(isset($_POST['password'])){
            $pwd=$_POST['password'];
        }
        if(isset($_POST['remember_me'])){
            $check='checked="checked"';
        }

        /* crea connessione al DB */
        require_once('connessione.php');
        $obj_connection = new DBConnection();

        if($obj_connection->create_connection()){

            $email=$obj_connection->escape_str(trim($email));
            $hashed_pwd=hash("sha256",$obj_connection->escape_str(trim($pwd)));

            if(!$log_query=$obj_connection->queryDB("SELECT * FROM utente WHERE Mail=\"$email\" AND PWD=\"$hashed_pwd\"")){
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
            $error="[Errore di connessione al database]";
        }

    }

    $error=str_replace("[",'<div class="msg_box error_box">',$error);
    $error=str_replace("]","</div>",$error);
    $page=str_replace("%ERROR%",$error,$page);
    $page=str_replace("%VALUE_EMAIL%",$email,$page);
    $page=str_replace("%VALUE_PASSWORD%",$pwd,$page);
    $page=str_replace("%CHECKED%",$check,$page);

    echo $page;
?>