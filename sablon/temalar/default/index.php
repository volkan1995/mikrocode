<?php

if (isset($m_ayarlar->eklenti->inc_sort)) {
    
    foreach (json_decode($m_ayarlar->eklenti->inc_sort) as $inc) {
        
        $inc = m_tema . 'includes' . DIRECTORY_SEPARATOR . $inc . ".php";
        
        if(file_exists($inc)){
            
            include $inc;
            
        }
        
    }
    
} else {

    include 'includes/banner.php';

    include 'includes/kurumsal.php';

    include 'includes/hizmetler.php';

    include 'includes/fiyatlar.php';

    include 'includes/iletisim.php';
}