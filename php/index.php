<?php

    $file_content=file_get_contents('../html/index.html');

    require_once('menu_list.php');
    $menuList=new menuList('utente');
        
    $search='<li xml:lang="en"><a href="../php/index.php">Home</a></li>';
    $replace='<li xml:lang="en" class="active">Home</li>';
    
    $menu=str_replace($search,$replace,$menuList->getHTMLmenu());

    $file_content=str_replace('%MENU%',$menu,$file_content);

    echo $file_content;

?>