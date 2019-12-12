<?php

    $file_content=file_get_contents('../html/login.html');

    require_once('menu_list.php');
    $menuList=new menuList('visitatore');

    $file_content=str_replace('%MENU%',$menuList->getHTMLmenu(),$file_content);

    echo $file_content;

?>