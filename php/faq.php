<?php

    $file_content=file_get_contents('../html/faq.html');

    require_once('menu_list.php');
    $menuList=new menuList('utente');
    
    $search='<li><a href="../php/faq.php"><abbr xml:lang="en" title="Frequently Asked Questions">FAQ</abbr></a></li>';
    $replace='<li class="active"><abbr xml:lang="en" title="Frequently Asked Questions">FAQ</abbr></li>';
    
    $menu=str_replace($search,$replace,$menuList->getHTMLmenu());

    $file_content=str_replace('%MENU%',$menu,$file_content);

    echo $file_content;

?>