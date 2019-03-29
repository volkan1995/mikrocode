<?php

if (!defined('m_guvenlik')) { exit; }
require 'ayar.php';

if (isset($_POST['kaydet'])) {
    mc_yetki($mc_modul_ayar['yetki'], 1);   
    
    if (!isset($_POST['diller'])) {
        $_POST['diller']['tr'] = $_POST;
    }
    $dil_grup = 0;
    foreach ($_POST['diller'] as $dil => $_POST) {
        if (empty($_POST['baslik'])) {
            mc_uyari(-3, "<b>" . mc_dil('basarisiz') . "</b>" . mc_dil('bos_alanlar_var'));            
        }
        if (empty($_POST['sef'])) { $_POST['sef'] = $_POST['baslik']; }
        $_POST['sef'] = mc_sefurl($_POST['baslik']);        
        if ($m_vt->select()->from($mc_modul_ayar['tablo'])->where("sef", $_POST['sef'])->count() > 0) {
            mc_uyari(-3, "<b>" . mc_dil('basarisiz') . "</b>Zaten benzer bir sayfa kaydı mevcut " . $_POST['baslik']);
        }
        
        if (!isset($_POST['sayfa'])) { $_POST['sayfa'] = 0; } else { $_POST['sayfa'] = intval($_POST['sayfa']); }
        if (empty($_POST['kategori'])) { $_POST['kategori'] = "yazi"; }
        if (!in_array($_POST['kategori'], ["yazi", "yonlendir", "kategoriler", "icerikler", "sayfalar"])) {
            $_POST['kategori'] = "yazi";
        }
        
        if (!isset($_POST['icerik'])) { $_POST['icerik'] = null; }
        if (!isset($_POST['kapak' ])) { $_POST['kapak'] = 0; } else { $_POST['kapak'] = intval($_POST['kapak']); }
        if (!isset($_POST['yayin'])) { $_POST['yayin'] = 0; } else { $_POST['yayin'] = intval($_POST['yayin']); }
        if (!isset($_POST['menu'])) { $_POST['menu'] = 0; } else { $_POST['menu'] = intval($_POST['menu']); }
        if ($_POST['kategori'] != "yazi") {
            if (!isset($_POST['parametre'])) { $_POST['parametre'] = null; }
            $_POST['icerik'] = $_POST['parametre'];
        }
        
        $mc_json = array();
        
        if (!empty($_POST['video'])) {  $mc_json['video'] = $_POST['video']; }            
        if (isset($_POST['ek']) && !empty($_POST['ek'])) { $mc_json['ek'] = $_POST['ek']; }
        if (isset($_POST['galeri']) && !empty($_POST['galeri'])) {
            $mc_json['galeri_ek'] = $_POST['galeri'];
            $mc_json['galeri'] = array_keys($mc_json['galeri']);            
        }
        
        if ($_POST['kategori'] == "yonlendir" && isset($_POST['sekme'])) { $mc_json['sekme'] = $_POST['sekme']; }
        
        $mc_kaydet = $m_vt->ekle([
            'table' => $mc_modul_ayar['tablo'],
            'values' => [
                'baslik' => $_POST['baslik'],
                'sef' => $_POST['sef'],
                'icerik' => $_POST['icerik'],
                'tip' => $_POST['kategori'],
                'ust' => $_POST['sayfa'],
                'durum' => $_POST['yayin'],
                'menu' => $_POST['menu'],
                'ekleyen' => mc_oturum_id,
                'resim' => $_POST['kapak'],
                'eklenti' => json_encode($mc_json),
                'grup' => $dil_grup,
                'dil' => $dil
            ]
        ])['sonuc'];
        if ($dil_grup == 0) {
            $dil_grup = $m_vt->son_id();
            $mc_kaydet = $m_vt->guncelle([ 'table' => $mc_modul_ayar['tablo'], 'values' => [ 'grup' => $dil_grup], 'where' => ['id' => $dil_grup]])['sonuc'];
        }
        if (!$mc_kaydet) { break; }
    }
    if ($mc_kaydet) {
        mc_uyari(-1, "<b>" . mc_dil('basarili') . "</b>Sayfa eklendi");
    } else {
        mc_uyari(-4, "<b>" . mc_dil('basarili') . "</b>Sayfa bilinmeyen bir hatadan dolayı eklenemedi.");
    }
}

$mc_title = mc_dil($mc_modul_ayar['ekle']);