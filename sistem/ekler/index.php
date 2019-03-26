<?php
    if(!defined('m_sistem_header')) { define("m_sistem_header", true); }
    require '../../yonetici/loader.php';
    if(mc_yetki("ek_ozellikler")){
        $mc_ek_ozellikler = new mc_liste();
        $mc_ek_ozellikler->gorsel = true;
        $mc_ek_ozellikler->durum = true;
        $mc_ek_ozellikler->menu = "ayarlar";
        $mc_ek_ozellikler->tablo = "ekler";
        $mc_ek_ozellikler->araclar = ['duzenle', 'sil', 'yayin'];
        $mc_ek_ozellikler->aciklama = "sef";
        $mc_ek_ozellikler->tarih = false;
        $mc_ek_ozellikler->veriler = $m_vt->select()->from('ekler')->where('tip', 0)->result();
        echo '<div class="row clearfix">';
        $mc_ek_ozellikler->olustur();
        echo '</div>';
    }
    require_once mc_sablon.'footer.php';