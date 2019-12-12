<?php

    $file_content=file_get_contents('../html/profilo.html');

    require_once('menu_list.php');
    $menuList=new menuList('utente');

    $search='<li><a href="../php/profilo.php">Il mio profilo</a></li>';
    $replace='<li class="active">Il mio profilo</li>';
    
    $menu=str_replace($search,$replace,$menuList->getHTMLmenu());

    $file_content=str_replace('%MENU%',$menu,$file_content);

    echo $file_content;

?>