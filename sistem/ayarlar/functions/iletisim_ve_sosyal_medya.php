<?php
    if(!defined('m_guvenlik')) { exit; }
    
    $mc_values = array();
    
    foreach ($_POST as $k => $v) {
        if(!empty($v)){
            $mc_values[$k] = $v;
        }
    }
    
    $mc_kaydet = $m_vt->guncelle(['table'=>"ayarlar",'values'=>['iletisim' => json_encode($mc_values)],'where' => ['id'=>1]])['sonuc'];            
    
    mc_uyari($mc_kaydet,["<b>Başarılı</b>Ayarlarınız kaydedildi","<b>Başarısız</b>Ayarlarınız bilinmeyen bir sebepten dolayı kaydedilemedi"]);