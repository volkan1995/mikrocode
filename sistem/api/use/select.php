<?php
    if(!defined('m_guvenlik')) { exit; }
    
    if(!isset($_POST['query'])){ hataYaz(3, $mapi_dil[7]); }
    
    $mapi_sorgu = json_decode($_POST['query']);
    
    if(!isset($mapi_sorgu->pdo_sql) || !isset($mapi_sorgu->values)){ hataYaz(3, $mapi_dil[6]."; JSON:".$_POST['query']); }
    
    if(strstr($mapi_sorgu->pdo_sql, "kullanicilar")){ hataYaz(2, $mapi_dil[8]); }
    
    if(strstr($mapi_sorgu->pdo_sql, "*")){ hataYaz(3, $mapi_dil[9]); }
    
    if(strstr($mapi_sorgu->pdo_sql, "sifre") || strstr($mapi_sorgu->pdo_sql, "pass")){ hataYaz(2, $mapi_dil[10]); }
    
    try {
        
        $mapi_vt = $m_vt->sorgu($mapi_sorgu->pdo_sql,$mapi_sorgu->values);

        $mapi_result['count'] = count($mapi_vt);

        $mapi_result['fetch'] = $mapi_vt;
        
    }catch(Exception $ex) {
        
        $mapi_result['status'] = false;
         
    }

    