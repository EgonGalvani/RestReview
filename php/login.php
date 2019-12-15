<?php

    function error_msg($type,$num){
        if($type=='email'){
            switch($num){
                case 1: return 'email non valida';
                case 2: return 'email non corretta';
            }
        }
        if($type=='pwd'){
            switch($num){
                case 1: return 'password non valida';
                case 2: return 'password non corretta';
            }
        }
        return '';
    }

    session_start();
    if(isset($_SESSION['logged'])){
        header('location:index.php');
        exit();
    }
    $file_content=file_get_contents('../html/login.html');

    /*Aggiunta header*/
    $header='<div id="header">
    <h1 id="title">RestReview</h1>
    <a id="hamburger" href="#menu" class="a_btn">MENU</a></div>'; 
    $file_content=str_replace('%HEADER%',$header,$file_content);

    /* Aggiunta menu*/
    require_once('menu_list.php');
    $menuList=new menuList('visitatore');
    $file_content=str_replace('%MENU%',$menuList->getHTMLmenu(),$file_content);

    /*Visualizzo eventuali messaggi di errore*/
    if(isset($_GET['pwd_error']) && $_GET['pwd_error']!=''){
        $search='<div id="content">';
        $replace=$search.'<p id="pwd_error_msg">Errore: '.error_msg('pwd',$_GET['pwd_error']).'</p>';
        $file_content=str_replace($search,$replace,$file_content);
    }
    if(isset($_GET['email_error']) && $_GET['email_error']!=''){
        $search='<div id="content">';
        $replace=$search.'<p id="email_error_msg">Errore: '.error_msg('email',$_GET['email_error']).'</p>';
        $file_content=str_replace($search,$replace,$file_content);
    }

    echo $file_content;
?>