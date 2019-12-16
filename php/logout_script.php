<?php
    session_start();
    session_unset();

    header('location: index.php');

    /* Modifica per fare logout e restare sulla stessa pagina (se non richiede di essere loggati) */
    /*header('location: '.$_SESSION['prev_page']);*/
?>