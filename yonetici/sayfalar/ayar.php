<?php
if(!defined('m_guvenlik')) { exit; }

/* Menü ve modül ismi aynıdır */
$mc_modul_ayar['menu'] = "sayfalar";
$mc_modul_ayar['yetki'] = "sayfalar";

/* Veritabanında çalışacağı tablo */
$mc_modul_ayar['tablo'] = "sayfalar";
$mc_modul_ayar['ust_tablo'] = "sayfalar";

/* Veritabanındaki tarih verisi */
$mc_modul_ayar['tarih'] = "etarih";
$mc_modul_ayar['ust'] = "ust";

/* Listede gözükecek araçlar */
$mc_modul_ayar['araclar'] = ['duzenle', 'sil', 'yayin', 'vurgula', 'siralama', 'arama', 'resim', 'filtre' => ['katman' => 1]];

/* Sıralamada iç içe geçme derinliğini belirtir, 1 ve 0 değeri iç içe geçmez */
$mc_modul_ayar['sirala_sekme'] = 2;

/* Sayfa başına içerik limiti */
$mc_modul_ayar['limit'] = $m_panel_sinir;

/* Dil dosyasındaki anahtarlar */
$mc_modul_ayar['baslik'] = "sayfalar";
$mc_modul_ayar['ekle'] = "yeni_sayfa_ekle";
$mc_modul_ayar['sirala'] = "sayfalari_sirala";

/* Tasarımsal Ayarlar */
$mc_modul_ayar['tasarim']['aciklama'] = true;
$mc_modul_ayar['tasarim']['kategori'] = true;
$mc_modul_ayar['tasarim']['icerik'] = true;
$mc_modul_ayar['tasarim']['yayin'] = true;
$mc_modul_ayar['tasarim']['vurgula'] = true;
$mc_modul_ayar['tasarim']['resim'] = true;
$mc_modul_ayar['tasarim']['video'] = false;
$mc_modul_ayar['tasarim']['galeri'] = true;
$mc_modul_ayar['tasarim']['izinler'] = true;