<?php

    $file_content=file_get_contents('../html/regolamento.html');

    require_once('menu_list.php');
    $menuList=new menuList('utente');

    $search='<li><a href="../php/regolamento.php">Regolamento</a></li>';
    $replace='<li class="active">Regolamento</li>';
    
    $menu=str_replace($search,$replace,$menuList->getHTMLmenu());

    $file_content=str_replace('%MENU%',$menu,$file_content);

    echo $file_content;

?>