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
        
        $_POST['kategori'] = 0;
        if(!empty($mc_modul_ayar['tasarim']['kategori'])){
            if (!empty($_POST['kategori'])) {
                $_POST['kategori'] = intval($_POST['kategori']);
            }        
        }
        
        if($m_vt->select()->from($mc_modul_ayar['tablo'])->where("sef",$_POST['sef'])->where($mc_modul_ayar['ust'], $_POST['kategori'])->where("tip",$mc_modul_ayar['tip'])->count() > 0){
            mc_uyari(-3, "<b>" . mc_dil('basarisiz') . "</b>Zaten benzer bir sayfa kaydı mevcut " . $_POST['baslik']);
        }
        
        if (!isset($_POST['aciklama'])) { $_POST['aciklama'] = null; }
        if (!isset($_POST['icerik'])) { $_POST['icerik'] = null; }
        if (!isset($_POST['kapak' ])) { $_POST['kapak'] = 0; } else { $_POST['kapak'] = intval($_POST['kapak']); }
        if (!isset($_POST['yayin'])) { $_POST['yayin'] = 0; } else { $_POST['yayin'] = intval($_POST['yayin']); }
        if (!isset($_POST['vurgula'])) { $_POST['vurgula'] = 0; } else { $_POST['vurgula'] = intval($_POST['vurgula']); }
        
        $mc_json = array();
        
        if (!empty($_POST['video'])) {  $mc_json['video'] = $_POST['video']; }            
        if (!empty($_POST['ek']) && is_array($_POST['galeri'])) {
            $mc_json['ek_ek'] = $_POST['ek'];
            $mc_json['ek'] = array_keys($mc_json['ek_ek']);             
        }
        if (!empty($_POST['galeri']) && is_array($_POST['galeri'])) {
            $mc_json['galeri_ek'] = $_POST['galeri'];
            $mc_json['galeri'] = array_keys($mc_json['galeri_ek']);            
        }
        
        $mc_kaydet = $m_vt->ekle([
            'table' => $mc_modul_ayar['tablo'],
            'values' => [
                'baslik' => m_html_chars($_POST['baslik'], 'enc'),
                'sef' => $_POST['sef'],
                'aciklama' => m_html_chars($_POST['aciklama'], 'enc'),
                'icerik' => $_POST['icerik'],
                'tip' => $mc_modul_ayar['tip'],
                $mc_modul_ayar['ust'] => $_POST['kategori'],
                'durum' => $_POST['yayin'],
                'vurgula' => $_POST['vurgula'],
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
        mc_uyari(-1, "<b>" . mc_dil('basarili') . "</b>İçerik eklendi");
    } else {
        mc_uyari(-4, "<b>" . mc_dil('basarili') . "</b>İçerik bilinmeyen bir hatadan dolayı eklenemedi.");
    }
}

$mc_title = mc_dil($mc_modul_ayar['ekle']);