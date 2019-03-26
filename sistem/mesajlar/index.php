<?php
    if(!defined('m_sistem_header')) { define("m_sistem_header", true); }
    require '../../yonetici/loader.php';
    if(mc_yetki("mesajlar")){
        $mc_ek_ozellikler = new mc_liste();
        $mc_ek_ozellikler->menu = "mesajlar";
        $mc_ek_ozellikler->tablo = "mesajlar";
        $mc_ek_ozellikler->araclar = ['goruntule', 'sil', 'durum', 'siralama', 'arama'];
        $mc_ek_ozellikler->aciklama = "gonderen";
        $mc_ek_ozellikler->tarih = "tarih";
        $mc_ek_ozellikler->veriler = $m_vt->select()->from('mesajlar')->where('tip', 0)->result();
        echo '<div class="row clearfix">';
        $mc_ek_ozellikler->olustur();
        echo '</div>';
    }
    require_once mc_sablon.'footer.php';