<?php
    if(!defined('m_guvenlik')) { exit; } 
    
    $klasorler_id = array(0 => "Anadizin");
    
    $klasor_bul = $m_vt->select()
        ->from("klasorler")
        ->result();
    
    foreach ($klasor_bul as $value) {
        $klasorler_id[$value->id] = $value->baslik;
    }

    $dosya_bul = $m_vt->select()
        ->from("dosyalar")
        ->where('tip', $_POST['tip'])
        ->result();
    
    $dosya_buld = array();
    
    foreach ($dosya_bul as $value) {
        $dosya_bulg['url'] = m_domain."/dosyalar".$value->konum;
        $dosya_bulg['thumb'] = m_resim($value->konum,200,200);
        $dosya_bulg['name'] = $value->baslik;
        $dosya_bulg['type'] = "image";
        $dosya_bulg['id'] = $value->id;
        if(isset($klasorler_id[$value->klasor])){
            $dosya_bulg['tag'] = $klasorler_id[$value->klasor]; 
        }else{
            $dosya_bulg['tag'] = $klasorler_id[0];  
        }      
        $dosya_buld[] = json_decode(json_encode($dosya_bulg),true);
    }
    
    echo json_encode($dosya_buld);
    
    exit;