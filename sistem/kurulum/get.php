<?php
    if(!defined('m_guvenlik')) { exit; }
    if($mc_kurulum_kk){
        if($mc_kurulum_adim == 3 && (!isset($_SESSION['gecici']) || $_SESSION['gecici'] == false)){
            $mc_kurulum_adim = 2;
        }
    }else{
        if(isset($_GET['adim'])){
            if(!isset($_SESSION['dil']) && empty($_SESSION['dil'])){
                $mc_kurulum_adim = 1;
            }else if($mc_kurulum_adim > 3){
                if(!isset($_SESSION['name']) || !isset($_SESSION['mail']) || !isset($_SESSION['pass']) || empty($_SESSION['name']) || empty($_SESSION['mail']) || empty($_SESSION['pass'])){
                    header("location: ".mc_sistem."kurulum/?adim=3");
                    echo "<script type='text/javascript'> window.top.location='".mc_sistem."kurulum/?adim=3'; </script>";
                    exit;  
                }
                if($mc_kurulum_vtb == false){
                    header("location: ".mc_sistem."kurulum/?adim=2");
                    echo "<script type='text/javascript'> window.top.location='".mc_sistem."kurulum/?adim=2'; </script>";
                    exit; 
                }
            }    
        }
    }