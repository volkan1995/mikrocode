<?php

if (!defined('m_guvenlik')) {
    exit;
}

require 'ayar.php';

$temp_css = m_tema . "template" . DIRECTORY_SEPARATOR . "css" . DIRECTORY_SEPARATOR;

if (!file_exists($temp_css . "colors.1.php")) {
    $tema_ayar['renkler'] = array();
}

include $temp_css . "colors.1.php";


if (isset($_POST['kaydet'])) {

    $tema_onbellek = m_depo . "onbellek" . DIRECTORY_SEPARATOR . mt_isim;
    
    if (file_exists($tema_onbellek)) {
        mc_klasorsil($tema_onbellek);
    }

    $m_ayarlar->eklenti = m_jsonDegistir($m_ayarlar->eklenti, 'onbellek', time(), false);
    
    foreach ($tema_ayar['renkler'] as $ayar => $deger) {
        if(isset($_POST[$ayar])){
            $m_ayarlar->eklenti = m_jsonDegistir($m_ayarlar->eklenti, $ayar, $_POST[$ayar], false);
        }
    }
    
    $mc_values['eklenti'] = $m_ayarlar->eklenti;
    
    $mc_kaydet = $m_vt->guncelle(['table' => "ayarlar", 'values' => $mc_values, 'where' => ['id' => 1]])['sonuc'];
   
    mc_uyari($mc_kaydet, ["<b>Başarılı</b>Tasarım kaydedildi", "<b>Başarısız</b>Tasarım bilinmeyen bir sebepten dolayı kaydedilemedi"]);

    exit;
}

$mc_title = mc_dil($mc_modul_ayar['renk']);

$tema_banner = m_ekyaz('index_slayt', 'resim');

if(empty($tema_banner)){
    $tema_banner = mc_img . "lines1.png";
}else{
    $tema_banner = m_resim(m_ekyaz('index_slayt', 'resim'), 1366, 768, 1, 70);
}
