<?php
    if(!defined('m_sistem_header')) { define("m_sistem_header", true); }
    require '../../yonetici/loader.php';
    if(mc_yetki("m_api")){
        $mc_m_api = new mc_liste();
        $mc_m_api->durum = true;
        $mc_m_api->menu = "ayarlar";
        $mc_m_api->tablo = "mapi";
        $mc_m_api->araclar = ['duzenle', 'sil', 'yayin'];
        $mc_m_api->aciklama = "kod";
        $mc_m_api->veriler = $m_vt->select()->from('mapi')->result();
        echo '<div class="row clearfix">';
        $mc_m_api->olustur();
        echo '</div>';
    }
    require_once mc_sablon.'footer.php';