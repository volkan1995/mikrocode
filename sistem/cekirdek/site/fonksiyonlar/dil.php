<?php

if (isset($this->dil)) {
    
    if (isset($_GET['dil'])) {
        $_SESSION['dil'] = $_GET['dil'];
        $this->dil = $_SESSION['dil'];
    }else if (is_bool($this->dil) && $this->dil) {
        
        if (isset($_SESSION['dil'])) {
            $this->dil = $_SESSION['dil'];
        }else{
            if (!isset($_SERVER["HTTP_ACCEPT_LANGUAGE"])) {
                $_SERVER["HTTP_ACCEPT_LANGUAGE"] = "tr";
            }
            $this->dil = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
        }
        
        if(!isset($mt_diller[$this->dil])){
            $this->dil = array_keys($mt_diller)[0];
        }
        
    }else{
        
        $_SESSION['dil'] = $this->dil;
        
    }
    
}