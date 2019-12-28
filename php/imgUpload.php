<?php
function uploadImage($folder){
    $target_dir = "../img/".$folder;
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $error="";
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $error= $error."<div class=\"msg_box error_box\">Questo file non è un'immagine.</div>";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {//500k
            $error= $error."<div class=\"msg_box error_box\">Il file è troppo grande, carica un file di dimensione minore di 500kB.</div>";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $error= $error."<div class=\"msg_box error_box\">Si possono caricale solo file JPG, JPEG, PNG e GIF.</div>";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 1) {
            $temp = explode(".", $_FILES["fileToUpload"]["name"]);
            $newfilename = round(microtime(true)) . '.' . end($temp);
            $target_file=$target_dir .$newfilename;
            if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $error= "<div class=\"msg_box error_box\">C'è stato un errore nel caricamento del file.</div>";
            }
        }
    $toReturn['error']=$error;
    $toReturn['path']=$target_file;
    return $toReturn;
}

?>