<?php

    session_start();
    if(!isset($_SESSION['logged'])){
        header('location: login.php');
        exit;
    }
    if(isset($_SESSION['permesso']) && $_SESSION['permesso']=='ristoratore'){

        $file_content=file_get_contents('../html/ins_rist.html');

        require_once('menu_list.php');
        $menuList=new menuList('ristoratore');
     
        $search='<li><a href="../php/ins_rist.php">Inserisci nuovo ristorante</a></li>';
        $replace='<li class="active">Inserisci nuovo ristorante<li>';
    
        $menu=str_replace($search,$replace,$menuList->getHTMLmenu());

        $file_content=str_replace('%MENU%',$menu,$file_content);

        echo $file_content;
    }else{
        header('location: access_denied.php');
    }
?>