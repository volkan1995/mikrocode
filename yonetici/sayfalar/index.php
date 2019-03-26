 <?php
    if(!defined('m_panel_header')) { define("m_panel_header", true); }
    
    require '..'.DIRECTORY_SEPARATOR.'loader.php';

    $mc_sayfalar = new mc_liste();
    $mc_sayfalar->gorsel = true;
    $mc_sayfalar->durum = true;
    $mc_sayfalar->menu = $mc_modul_ayar['menu'];
    $mc_sayfalar->tablo = $mc_modul_ayar['tablo'];
    $mc_sayfalar->araclar = $mc_modul_ayar['araclar'];
    $mc_sayfalar->tarih = $mc_modul_ayar['tarih'];
    $mc_sayfalar->aciklama = "tip";
    $mc_sayfalar->veriler = $get_sayfalar;
    echo '<div class="row clearfix">';
    $mc_sayfalar->olustur();
    echo '<div class="col-md-12">'.m_sayfano($mc_modul_ayar['limit'], $get_sayfalar_count).'</div></div>';

    require mc_sablon.'footer.php';