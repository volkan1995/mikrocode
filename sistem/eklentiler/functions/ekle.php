<?php
    if(!defined('m_guvenlik')) { exit; }
    
    if(isset($_POST['kaydet'])){
        
        unset($_POST['kaydet']);
        
    }
    
    $mc_title = mc_dil('eklenti_yukle');