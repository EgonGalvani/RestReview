<?php

    $file_content=file_get_contents('../html/casuale.html');

    require_once('menu_list.php');
    $menuList=new menuList('utente');

    $search='<li><a href="../php/casuale.php">Ristorante casuale</a></li>';
    $replace='<li class="active">Ristorante casuale</li>';
    
    $menu=str_replace($search,$replace,$menuList->getHTMLmenu());

    $file_content=str_replace('%MENU%',$menu,$file_content);

    echo $file_content;

?>