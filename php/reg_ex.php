<?php

    function check_email($email){
        if(preg_match('/^([\w\-\+\.]+)\@([\w\-\+\.]+)\.([\w\-\+\.]+)$/',$email)==1){
            return true;
        }
        return false;
    }

    function check_pwd($password){
        if(preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/',$password)==1){
            return true;
        }
        return false;
    }

    function check_nome($nome){
        if(preg_match('/^([a-zA-Z]*)$/',$nome)==1){
            return true;
        }
        return false;
    }

    function check_tel($tel){
        if(preg_match('/^(\d{10})$/',$tel)==1){
            return true;
        }
        return false;
    }

    function check_num($num){
        if(preg_match('/^([1-9][0-9]*)$/',$num)==1){
            return true;
        }
        return false;
    }

    function check_cap($cap){
        if(preg_match('/^(\d{5})$/',$cap)==1){
            return true;
        }
        return false;
    }
?>