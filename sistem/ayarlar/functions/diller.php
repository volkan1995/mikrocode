<?php
    if(!defined('m_guvenlik')) { exit; }
    
    $secili_diller = array();
    
    if(isset($_POST['diller']) && is_array($_POST['diller'])){
        
        foreach ($_POST['diller'] as $key => $value) {
            
            if($value == 1 && isset($mc_diller[$key])){
                
                $secili_diller[$key] = $mc_diller[$key];
                      
            }
            
        }
        
    }
    
    $syc = 1;
    
    if(!count($secili_diller)){
        mc_uyari(-3, "<b>" . mc_dil('basarisiz') . "</b>En az bir dil tanımlı olmalı.");
    }
    
    if($m_vt->select()->from('diller')->count() > 0){
        $m_vt->select()->from('diller')->delete();
    }
    
    foreach ($secili_diller as $key => $value) {
        
        if(empty($value['hizala'])){ $value['hizala'] = 0; }else{ $value['hizala'] = 1; }
                
        $mc_kaydet = $m_vt->ekle([
            'table' => "diller",
            'values' => [
                'id' => $syc,
                'baslik' => $value['dil'],
                'sef' => $key,
                'durum' => 1,
                'timezone' => $value['timezone'],
                'lc_time' => $value['lc_time'],
                'lc_all' => $value['lc_all'],
                'hizala' => $value['hizala']
            ]
        ])['sonuc'];

        if($mc_kaydet){
            $syc += 1;
        }
        
    }
    
    if($syc > 1){
        mc_uyari(-1, "<b>" . mc_dil('basarili') . "</b>Dil ayarları eklendi");
    } else {
        mc_uyari(-4, "<b>" . mc_dil('basarisiz') . "</b>Dil ayarları yapılamadı.");
    }