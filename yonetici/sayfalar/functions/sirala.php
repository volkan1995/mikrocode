<?php
    if(!defined('m_guvenlik')) { exit; }
    
    require 'ayar.php';
    
    if(isset($_POST['kaydet'])){        
        if(!mc_yetki($mc_modul_ayar['menu'])){ exit; }
        $mc_sirala = $m_vt->sortby(['table'=>$mc_modul_ayar['tablo'],'sort' => $_POST['sira'],'parent' => "ust", 'group' => "grup"]);        
        if($mc_sirala['sonuc']){
            mc_uyari(-1,"<b>".mc_dil('basarili')."</b>Sayfalar sıralandı");
        }else{
            mc_uyari(-4,"<b>".mc_dil('basarili')."</b>Sayfalar bilinmeyen bir hatadan dolayı sıralanamadı. Hata detayı<br/>".$mc_sirala['sonuc']);
        }        
    }
    
    $mc_title = mc_dil($mc_modul_ayar['sirala']);
    
    if (!empty($mt_diller)) {
        if(empty($_GET['filtre_dil'])){
            $_GET['filtre_dil'] = array_keys($mt_diller)[0];
        }
    }