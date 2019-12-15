<?php

    public function check_email($email){
        if(preg_match('/^([\w\-\+\.]+)\@([\w\-\+\.]+)\.([\w\-\+\.]+)$/',$email)==1){
            return true;
        }
        return false;
    }

    public function check_pwd($password)
    if(preg_match('/^(?=.\d)(?=.[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/',$password)==1){
        return true;
    }
    return false;
?>