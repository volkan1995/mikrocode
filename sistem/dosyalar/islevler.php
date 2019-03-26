<?php    
    if(!defined('m_guvenlik')) { define('m_guvenlik',true); }
    
    $mcd_coklu = 0;
    
    if(isset($_POST['coklu']) && $_POST['coklu'] == 1){ $mcd_coklu = 1; }
    
    if(isset($_POST['dosya_sec'])){
        
        require 'islev_sec.php';
        
    }elseif(isset($_POST['ust_klasor'])){
        
        require 'islev_yeni.php';
        
    }elseif(isset($_FILES) && count($_FILES) == 1){
        
        require 'islev_yukle.php';
       
    }
    
    exit;
    
    