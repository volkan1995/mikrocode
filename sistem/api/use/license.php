<?php
    if(!defined('m_guvenlik')) { exit; }
    
    $mapi_result['download'] = null;
    
    $mapi_result['status'] = false;
    
    $guncelleme = m_ekyaz('guncelleme', true);
    
    if(isset($guncelleme->durum) && $guncelleme->durum == 1){
        
        $guncelleme->eklenti = json_decode($guncelleme->eklenti);
        
        if(isset($guncelleme->eklenti->galeri[0])){
            
            $dosya_bul = $m_vt->select()->from("dosyalar")->where('tip', 4)->where('id', $guncelleme->eklenti->galeri[0])->result();
            
            if(count($dosya_bul)){
                
                $mapi_result['download'] = m_domain."/dosyalar".$dosya_bul[0]->konum;
                
                $mapi_result['status'] = true;
                
            }
            
        }
        
    }