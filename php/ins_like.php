<?php
    require_once('sessione.php');
    unset($_SESSION['current_page']);

    require_once('like.php');
    $like=new like($_POST['ID_Viewer'],$_POST['ID_Recensione']);
    $like->insertIntoDB();

    header('location: '.$_SESSION['prev_page']);
?>