<?php
    if(!defined('m_panel_header')) { define("m_panel_header", true); }
    
    require '..'.DIRECTORY_SEPARATOR.'loader.php';
    
    $mc_yazilar = new mc_liste();
    $mc_yazilar->gorsel = false;
    $mc_yazilar->durum = true;
    $mc_yazilar->aciklama = "vurgula";
    $mc_yazilar->menu = $mc_modul_ayar['menu'];
    $mc_yazilar->tablo = $mc_modul_ayar['tablo'];
    $mc_yazilar->araclar = $mc_modul_ayar['araclar'];
    $mc_yazilar->tarih = $mc_modul_ayar['tarih'];
    $mc_yazilar->veriler = $mc_sorgu;
    echo '<div class="row clearfix">';
    $mc_yazilar->olustur();
    echo '<div class="col-md-12">'.m_sayfano($mc_modul_ayar['limit'], $mc_sorgu_say).'</div></div>';
    
    require mc_sablon.'footer.php';