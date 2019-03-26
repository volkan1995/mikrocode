<?php
if(!defined('m_guvenlik')) { exit; }

/* Menü ve modül ismi aynıdır */
$mc_modul_ayar['menu'] = "kataloglar";
$mc_modul_ayar['yetki'] = "kataloglar";

/* Veritabanında çalışacağı tablo */
$mc_modul_ayar['tablo'] = "yazilar";
$mc_modul_ayar['ust_tablo'] = "kategoriler";

/* Veritabanındaki tarih ve kategori verisi */
$mc_modul_ayar['tarih'] = "etarih";
$mc_modul_ayar['ust'] = "kategori";

/* Aynı tabloda birden fazla içerik türü varsa atanır, yoksa 0 atanır */
$mc_modul_ayar['tip'] = 3;
$mc_modul_ayar['kategori'] = 3;

/* Listede gözükecek araçlar */
$mc_modul_ayar['araclar'] = ['duzenle', 'sil', 'yayin', 'vurgula', 'siralama', 'arama', 'resim'];

/* Sıralamada iç içe geçme derinliğini belirtir, 1 ve 0 değeri iç içe geçmez */
$mc_modul_ayar['sirala_sekme'] = 1;

/* Sayfa başına içerik limiti */
$mc_modul_ayar['limit'] = $m_panel_sinir;

/* Dil dosyasındaki anahtarlar */
$mc_modul_ayar['baslik'] = "kataloglar";
$mc_modul_ayar['ekle'] = "yeni_katalog_ekle";
$mc_modul_ayar['sirala'] = "kataloglar";

/* Tasarımsal Ayarlar */
$mc_modul_ayar['tasarim']['aciklama'] = true;
$mc_modul_ayar['tasarim']['kategori'] = false;
$mc_modul_ayar['tasarim']['icerik'] = false;
$mc_modul_ayar['tasarim']['yayin'] = true;
$mc_modul_ayar['tasarim']['vurgula'] = false;
$mc_modul_ayar['tasarim']['resim'] = true;
$mc_modul_ayar['tasarim']['video'] = false;
$mc_modul_ayar['tasarim']['galeri'] = false;
$mc_modul_ayar['tasarim']['ek'] = true;
$mc_modul_ayar['tasarim']['izinler'] = false;