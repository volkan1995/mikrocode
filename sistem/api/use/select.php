<?php
    if(!defined('m_guvenlik')) { exit; }
    
    if(!isset($_POST['query'])){ hataYaz(3, $mapi_dil[7]); }
    
    $mapi_sorgu = json_decode($_POST['query']);
    
    if(!isset($mapi_sorgu->q) || !isset($mapi_sorgu->v)){ hataYaz(3, $mapi_dil[6]."; JSON:".$_POST['query']); }
    
    if(strstr($mapi_sorgu->q, "kullanicilar")){ hataYaz(2, $mapi_dil[8]); }
    
    if(strstr($mapi_sorgu->q, "*")){ hataYaz(3, $mapi_dil[9]); }
    
    if(strstr($mapi_sorgu->q, "sifre") || strstr($mapi_sorgu->q, "pass")){ hataYaz(2, $mapi_dil[10]); }
    
    try {
        
        $mapi_vt = $m_vt->sorgu($mapi_sorgu->q,$mapi_sorgu->v);

        $mapi_result['count'] = count($mapi_vt);

        $mapi_result['fetch'] = $mapi_vt;
        
    }catch(Exception $ex) {
        
        $mapi_result['status'] = false;
         
    }

    