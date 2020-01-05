<?php
    session_start();

    header("location: ".$_SESSION['prev_page']);
    
    session_unset();
?>