<?php
    header('refresh:5; url= index.php');

    echo $file_content=file_get_contents('../html/access_denied.html');

?>