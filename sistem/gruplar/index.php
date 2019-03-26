<?php
    if(!defined('m_sistem_header')) { define("m_sistem_header", true); }
    require '../../yonetici/loader.php';
    if($mc_oturum->grup == 1){ $grup_yetki = 1; }else{ $grup_yetki = 2; }        
    $mc_m_api = new mc_liste();
    $mc_m_api->durum = true;
    $mc_m_api->tarih = false;
    $mc_m_api->menu = "gruplar";
    $mc_m_api->tablo = "gruplar";
    $mc_m_api->araclar = ['duzenle', 'sil'];
    $mc_m_api->aciklama = "baslik";        
    $mc_m_api->veriler = $m_vt->select()->from('gruplar')->where('id', $grup_yetki , ">")->result();        
    echo '<div class="row clearfix">';
    $mc_m_api->olustur();
    echo '</div>';
        
    require_once mc_sablon.'footer.php';