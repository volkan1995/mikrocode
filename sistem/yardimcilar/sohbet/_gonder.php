<?php

if (empty($_POST['mesaj'])) {
    exit("<b>Gönderim hatası</b><br/>Mesaj verisi boş olamaz.");
}

if (!defined('mdb_guvenlik')) {
    define("mdb_guvenlik", true);
}

require 'mc.baglan.php';

$mc_kaydet = $m_vt->ekle([
    'table' => mdt_messages,
    'values' => [mdt_messages_user => $_POST['kullanici_id'], mdt_messages_text => json_encode($_POST['mesaj'])]
]);

if ($mc_kaydet['sonuc']) {
    exit("1");
} else {
    exit("<b>Gönderim hatası</b><br/>İstemciye kayıtlı sunucu hatası");
}

