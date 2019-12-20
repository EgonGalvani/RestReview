<?php
    session_start();

    if(!isset($_SESSION['logged'])){
        $_SESSION['logged']=false;
    }
    if(!isset($_SESSION['permesso'])){
        $_SESSION['permesso']=false;
    }

    if(isset($_SESSION['current_page'])){
        if(basename($_SERVER["REQUEST_URI"])!=$_SESSION['current_page']){
            $_SESSION['prev_page']=$_SESSION['current_page'];
        }
    }
    $_SESSION['current_page']=basename($_SERVER["REQUEST_URI"]);

    if(!isset($_SESSION['prev_page'])){
        $_SESSION['prev_page']='index.php';
    }
?>