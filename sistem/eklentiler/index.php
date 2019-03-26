<?php
    if(!defined('m_sistem_header')) { define("m_sistem_header", true); }
    
    require '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'yonetici' . DIRECTORY_SEPARATOR . 'loader.php';
  
    $mc_m_api = new mc_liste();
    $mc_m_api->durum = true;
    $mc_m_api->tarih = false;
    $mc_m_api->menu = "ayarlar";
    $mc_m_api->tablo = "eklentiler";
    $mc_m_api->araclar = ['duzenle', 'sil'];
    $mc_m_api->aciklama = "tip";        
    $mc_m_api->veriler = $m_vt->select()->from('eklentiler')->result();        
    echo '<div class="row clearfix">';
    $mc_m_api->olustur();
    echo '</div>';
    
    require mc_sablon.'footer.php';