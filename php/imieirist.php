<?php

    $file_content=file_get_contents('../html/imieirist.html');

    require_once('menu_list.php');
    $menuList=new menuList('ristoratore');

    $search='<li><a href="../php/imieirist.php">I miei ristoranti</a></li>';
    $replace='<li class="active">I miei ristoranti</li>';
    
    $menu=str_replace($search,$replace,$menuList->getHTMLmenu());

    $file_content=str_replace('%MENU%',$menu,$file_content);

    echo $file_content;

?>