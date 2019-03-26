<?php

if (!defined('m_guvenlik')) {
    exit;
}

require 'ayar.php';

if (isset($_POST['kaydet'])) {

    mc_yetki($mc_modul_ayar['yetki'], 1);
    
    $dil_grup = 0;

    foreach ($_POST['diller'] as $dil) {
        if (empty($_POST['baslik'][$dil])) {
            mc_uyari(-3, "<b>" . mc_dil('basarisiz') . "</b>" . mc_dil('bos_alanlar_var'));
        }

        if (empty($_POST['sef'][$dil])) {
            $_POST['sef'][$dil] = $_POST['baslik'][$dil];
        }
        $_POST['sef'][$dil] = mc_sefurl($_POST['baslik'][$dil]);

        if (!isset($_POST['kategori'][$dil])) {
            $_POST['kategori'][$dil] = 0;
        } else {
            $_POST['kategori'][$dil] = intval($_POST['kategori'][$dil]);
        }
        
        $yetki = mc_yetki($mc_modul_ayar['menu'], 1, false, false);
        if(isset($mc_modul_ayar['tasarim']['kategori']) && $mc_modul_ayar['tasarim']['kategori']){
            if(empty($_POST['kategori'][$dil]) || intval($_POST['kategori'][$dil]) <= 0){ mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>".mc_dil('kategori_seciniz')); }
            $get_kategori = $m_vt->select()->from($mc_modul_ayar['ust_tablo'])->where("id", $_POST['kategori'][$dil])->result();
            if(count($get_kategori)){
                if($get_kategori[0]->ekleyen != mc_oturum_id){
                    mc_ozel_yetki([$mc_modul_ayar['ust_tablo'] => $get_kategori[0]->id]);    
                }
            }else{
                mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>".mc_dil('kategori_seciniz'));
            }
        }else{
            $_POST['kategori'][$dil] = 0;
        }
        if(!$yetki){ mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>Bu işlem için yetkiniz yok."); }
        
        if($m_vt->select()->from($mc_modul_ayar['tablo'])->where("sef",$_POST['sef'][$dil])->where($mc_modul_ayar['ust'], $_POST['kategori'][$dil])->where("tip",$mc_modul_ayar['tip'])->count() > 0){
            mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>Zaten benzer bir içerik kaydı mevcut. " . $_POST['baslik'][$dil]);
        }

        if (!isset($_POST['m_editor_' . $dil])) {
            $_POST['m_editor_' . $dil] = null;
        }

        if (!isset($_POST['aciklama'][$dil])) {
            $_POST['aciklama'][$dil] = null;
        }

        if (!isset($_POST['kapak_' . $dil])) {
            $_POST['kapak_' . $dil] = 0;
        } else {
            $_POST['kapak_' . $dil] = intval($_POST['kapak_' . $dil]);
        }

        if (!isset($_POST['yayin'][$dil])) {
            $_POST['yayin'][$dil] = 0;
        } else {
            $_POST['yayin'][$dil] = intval($_POST['yayin'][$dil]);
        }

        if (!isset($_POST['vurgula'][$dil])) {
            $_POST['vurgula'][$dil] = 0;
        } else {
            $_POST['vurgula'][$dil] = intval($_POST['vurgula'][$dil]);
        }

        $mc_json[$dil] = array();

        if (isset($_POST['galeri_' . $dil]) && !empty($_POST['galeri_' . $dil])) {
            $mc_json[$dil]['galeri'] = $_POST['galeri_' . $dil];
        }

        if (!empty($_POST['video_' . $dil])) {
            $mc_json[$dil]['video'] = $_POST['video_' . $dil];
        }
        
        if(isset($_POST[$dil.'_ek']) && !empty($_POST[$dil.'_ek'])){ $mc_json[$dil]['ek'] = $_POST[$dil.'_ek']; }
        if(isset($_POST[$dil.'_ek_b'])){ $mc_json[$dil]['ek_b'] = $_POST[$dil.'_ek_b']; }
        if(isset($_POST[$dil.'_ek_a'])){ $mc_json[$dil]['ek_a'] = $_POST[$dil.'_ek_a']; }
        if(isset($_POST[$dil.'_ek_u'])){ $mc_json[$dil]['ek_u'] = $_POST[$dil.'_ek_u']; }
        if(isset($_POST[$dil.'_ek_y'])){ $mc_json[$dil]['ek_y'] = $_POST[$dil.'_ek_y']; } 
        
        $mc_json[$dil] = json_encode($mc_json[$dil]);
        
        $mc_kaydet = $m_vt->ekle([
                    'table' => $mc_modul_ayar['tablo'],
                    'values' => [
                        'baslik' => $_POST['baslik'][$dil],
                        'sef' => $_POST['sef'][$dil],
                        'aciklama' => $_POST['aciklama'][$dil],
                        'icerik' => $_POST['m_editor_' . $dil],
                        'tip' => $mc_modul_ayar['tip'],
                        $mc_modul_ayar['ust'] => $_POST['kategori'][$dil],
                        'durum' => $_POST['yayin'][$dil],
                        'vurgula' => $_POST['vurgula'][$dil],
                        'ekleyen' => mc_oturum_id,
                        'resim' => $_POST['kapak_' . $dil],
                        'eklenti' => $mc_json[$dil],
                        'grup' => $dil_grup,
                        'dil' => $dil
                    ]
                ])['sonuc'];

        if ($dil_grup == 0) {
            $dil_grup = $m_vt->son_id();
            $mc_kaydet = $m_vt->guncelle([ 'table' => $mc_modul_ayar['tablo'], 'values' => [ 'grup' => $dil_grup], 'where' => ['id' => $dil_grup]])['sonuc'];
        }
        if (!$mc_kaydet) {
            break;
        }
    }

    if ($mc_kaydet) {
        mc_uyari(-1, "<b>" . mc_dil('basarili') . "</b>İçerik eklendi");
    } else {
        mc_uyari(-4, "<b>" . mc_dil('basarili') . "</b>İçerik bilinmeyen bir hatadan dolayı eklenemedi.");
    }
}

$mc_title = mc_dil($mc_modul_ayar['ekle']);