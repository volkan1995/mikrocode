<?php
    if(!defined('m_panel_header')) { define("m_panel_header", true); }
    
    require '..'.DIRECTORY_SEPARATOR.'loader.php';
    
    $mc_kategoriler = new mc_liste();
    $mc_kategoriler->gorsel = true;
    $mc_kategoriler->durum = true;
    $mc_kategoriler->menu = $mc_modul_ayar['menu'];
    $mc_kategoriler->tablo = $mc_modul_ayar['tablo'];
    $mc_kategoriler->araclar = $mc_modul_ayar['araclar'];
    $mc_kategoriler->tarih = "etarih";
    $mc_kategoriler->veriler = $tum_kategoriler;
    echo '<div class="row clearfix">';
    $mc_kategoriler->olustur();
    echo '</div>';
        
    require mc_sablon.'footer.php';