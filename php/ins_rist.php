<?php

    require_once("sessione.php");

    //check se loggato
    if($_SESSION['logged']==false){
        header('location: login.php?prev_page=ins_rist.php');
        exit;
    }

    if($_SESSION['permesso']=='Ristoratore'){

        $file_content=file_get_contents('../html/ins_rist.html');

        /* menu, da cambiare con addItems */
        require_once('menu_list.php');
        $menuList=new menuList('ristoratore');
        $search='<li><a href="../php/ins_rist.php">Inserisci nuovo ristorante</a></li>';
        $replace='<li class="active">Inserisci nuovo ristorante<li>';
        $menu=str_replace($search,$replace,$menuList->getHTMLmenu());
        $file_content=str_replace('%MENU%',$menu,$file_content);

        echo $file_content;
        $_SESSION['prev_page']='ins_rist.php';
    }else{
        header('location: access_denied.php');
        $_SESSION['prev_page']='ins_rist.php';
        exit;
    }
?>