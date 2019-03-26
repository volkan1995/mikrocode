<?php

if (!defined('m_guvenlik')) {
    exit;
}

foreach ($_POST as $key => $value) {
    $m_ayarlar->ayar = m_jsonDegistir($m_ayarlar->ayar, $key, $value, false);
}

$mc_values['ayar'] = $m_ayarlar->ayar;

$mc_kaydet = $m_vt->guncelle(['table' => "ayarlar", 'values' => $mc_values, 'where' => ['id' => 1]])['sonuc'];

mc_uyari($mc_kaydet, ["<b>Başarılı</b>Ayarlarınız kaydedildi", "<b>Başarısız</b>Ayarlarınız bilinmeyen bir sebepten dolayı kaydedilemedi"]);
