<?php

if (!defined('m_guvenlik')) {
    exit;
}

$m_ayarlar = $m_vt->select()->from("ayarlar")->where('id', 1)->result();

if (!count($m_ayarlar)) {
    m_git("//" . m_host . "/sistem/kurulum/?adim=2");
}

if (defined('m_site') && m_site && $m_ayarlar[0]->erisim != 1) {
    echo "Site erişime kapalı";
    exit;
}

$m_ayarlar = $m_ayarlar[0];

$m_ayarlar->ayar = json_decode($m_ayarlar->ayar);
$m_ayarlar->bilgi = json_decode($m_ayarlar->bilgi);
$m_ayarlar->medya = json_decode($m_ayarlar->medya);
$m_ayarlar->eklenti = json_decode($m_ayarlar->eklenti);
$m_ayarlar->iletisim = json_decode($m_ayarlar->iletisim);

$m_baslik = m_jsonAl($m_ayarlar->bilgi, 'baslik', "Site Başlığı");
$m_aciklama = m_jsonAl($m_ayarlar->bilgi, 'aciklama', "Yeni sitemize hoş geldiniz");
$m_anahtar = m_jsonAl($m_ayarlar->bilgi, 'anahtar');

$mc_ps = intval(m_jsonAl($m_ayarlar->ayar, "mcps"));

$m_site_sinir = m_jsonAl($m_ayarlar->ayar, "sinir_site", 10);
$m_panel_sinir = m_jsonAl($m_ayarlar->ayar, "sinir_panel", 20);