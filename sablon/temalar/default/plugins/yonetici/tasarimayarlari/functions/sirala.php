<?php

if (!defined('m_guvenlik')) {
    exit;
}

require 'ayar.php';

$temp_css = m_tema . "includes" . DIRECTORY_SEPARATOR;

$tema_incs = array();

if (is_dir($temp_css)) {
    if ($tsd = opendir($temp_css)) {
        while ($td = readdir($tsd)) {
            if ($td == "." || $td == "..") {
                continue;
            }
            $dosya_pi = pathinfo($temp_css . $td);
            if (isset($dosya_pi["extension"]) && strtolower($dosya_pi["extension"]) == "php") {
                $tema_incs[] = $dosya_pi["filename"];
            }
        }
    }
}

if (isset($_POST['kaydet'])) {

    if (!mc_yetki($mc_modul_ayar['yetki'])) {
        exit;
    }

    $save_incs = array();

    if (isset($_POST['sira']) && !is_array($_POST['sira'])) {
        $_POST['sira'] = json_decode($_POST['sira']);
        if (count($_POST['sira'])) {
            foreach ($_POST['sira'] as $value) {
                if (isset($value->id) && in_array($value->id, $tema_incs)) {
                    $save_incs[] = $value->id;
                }
            }
        }
    }

    $m_ayarlar->eklenti = m_jsonDegistir($m_ayarlar->eklenti, 'inc_sort', json_encode($save_incs), false);

    $mc_values['eklenti'] = $m_ayarlar->eklenti;

    $mc_kaydet = $m_vt->guncelle(['table' => "ayarlar", 'values' => $mc_values, 'where' => ['id' => 1]])['sonuc'];

    mc_uyari($mc_kaydet, ["<b>Başarılı</b>Tasarım kaydedildi", "<b>Başarısız</b>Tasarım bilinmeyen bir sebepten dolayı kaydedilemedi"]);

    exit;
}

if (isset($m_ayarlar->eklenti->inc_sort)) {
    $inc_sort = json_decode($m_ayarlar->eklenti->inc_sort);
    if(empty($inc_sort)){
        $inc_sort = $tema_incs;
    }
} else {
    $inc_sort = $tema_incs;
}


$mc_title = mc_dil($mc_modul_ayar['sirala']);
