<?php

if (!defined('m_guvenlik')) { exit; }
require 'ayar.php';

if (isset($_POST['kaydet'])) {
    
    mc_yetki($mc_modul_ayar['yetki'], 2);   
    
    if (empty($_POST['diller'])) { $_POST['diller']['tr'] = $_POST; }    
    $grupID = 0; 
    
    foreach ($_POST['diller'] as $dil => $_POST) {
        $id = 0;
        if (!empty($_POST['id'])) {
            $id = intval($_POST['id']);
            $varlik_sor = $m_vt->select()->from($mc_modul_ayar['tablo'])->where("id", $id)->where("tip", $mc_modul_ayar['tip'])->result();
            if (count($varlik_sor) == 0) {
                mc_uyari(-3, "<b>" . mc_dil('basarisiz') . "</b>İçerik kaydı bulunamadı. {$dil}: " . $_POST['baslik']);
            }
            if ($grupID == 0) {
                $grupID = ( $varlik_sor[0]->grup == 0 ? $varlik_sor[0]->id :  $varlik_sor[0]->grup );
            }
        }
        
        if($grupID == 0){
            mc_uyari(-3, "<b>" . mc_dil('basarisiz') . "</b>İçerik kaydı bulunamadı. {$dil}: " . $_POST['baslik']);
        }
        
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
        
        if ($id == 0) {
            if($m_vt->select()->from($mc_modul_ayar['tablo'])->where("sef",$_POST['sef'])->where($mc_modul_ayar['ust'], $_POST['kategori'])->where("tip",$mc_modul_ayar['tip'])->count() > 0){
                mc_uyari(-3, "<b>" . mc_dil('basarisiz') . "</b>Zaten benzer bir içerik kaydı mevcut " . $_POST['baslik']);
            }
        } else {
            if($m_vt->select()->from($mc_modul_ayar['tablo'])->where("sef",$_POST['sef'])->where($mc_modul_ayar['ust'], $_POST['kategori'])->where("tip",$mc_modul_ayar['tip'])->where("id", $_POST['id'], "<>")->count() > 0){
                mc_uyari(-3, "<b>" . mc_dil('basarisiz') . "</b>Zaten benzer bir içerik kaydı mevcut " . $_POST['baslik']);
            }
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
        
        $kayit_verileri = array(
            'baslik' => m_html_chars($_POST['baslik'], 'enc'),
            'sef' => $_POST['sef'],
            'aciklama' => m_html_chars($_POST['aciklama'], 'enc'),
            'icerik' => $_POST['icerik'],
            'tip' => $mc_modul_ayar['tip'],
            $mc_modul_ayar['ust'] => $_POST['kategori'],
            'durum' => $_POST['yayin'],
            'vurgula' => $_POST['vurgula'],
            'resim' => $_POST['kapak'],
            'eklenti' => json_encode($mc_json),
            'grup' => $grupID,
            'dil' => $dil
        );        
        
        if ($id == 0) {
            $kayit_verileri['ekleyen'] = mc_oturum_id;
            $mc_kaydet = $m_vt->ekle([ 'table' => $mc_modul_ayar['tablo'], 'values' => $kayit_verileri ])['sonuc'];
        } else {
            $kayit_verileri['duzenleyen'] = mc_oturum_id;
            $mc_kaydet = $m_vt->guncelle(['table' => $mc_modul_ayar['tablo'], 'values' => $kayit_verileri, 'where' => ['id' => $id] ])['sonuc'];
        }
        if (!$mc_kaydet) { break; }
        
    }
    if ($mc_kaydet) {
        mc_uyari(-1, "<b>" . mc_dil('basarili') . "</b>İçerik düzenlendi");
    } else {
        mc_uyari(-4, "<b>" . mc_dil('basarili') . "</b>İçerik bilinmeyen bir hatadan dolayı düzenlenemedi.");
    }
}

if (!isset($_GET['id'])) {
    exit;
}

$sorgu_icerik = $m_vt->select("grup")->from($mc_modul_ayar['tablo'])->where("id", $_GET['id'])->result();
if(!count($sorgu_icerik)){
    mc_uyari(-3, "<b>" . mc_dil('basarisiz') . "</b>İçerik kaydı bulunamadı.");
}

$sorgu_icerikler = $m_vt->select("`dil`")->from($mc_modul_ayar['tablo'])->where("grup", $sorgu_icerik[0]->grup)->orderby('id',"ASC")->group(true,false);
if(!count($sorgu_icerikler)){
   mc_uyari(-3, "<b>" . mc_dil('basarisiz') . "</b>İçerik grubu kaydı bulunamadı.");
}
$first_key = array_keys($sorgu_icerikler)[0];
foreach ($m_diller as $dil => $tanim) {
    if(empty($sorgu_icerikler[$dil])){
        $sorgu_icerikler[$dil] = new StdClass();
        foreach ($sorgu_icerikler[$first_key] as $key => $value) {
            $sorgu_icerikler[$dil]->{$key} = is_numeric($value)?0:null;
        }
    }
}

$mc_title = mc_dil('duzenle') . ": " . $sorgu_icerikler[$first_key]->baslik;
