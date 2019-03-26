<?php
if(!defined('m_guvenlik')) { exit; }

/* Menü ve modül ismi aynıdır */
$mc_modul_ayar['menu'] = "urunler";
$mc_modul_ayar['yetki'] = "urunkategorileri";
$mc_modul_ayar['alt_yetki'] = "urunler";

/* Veritabanında çalışacağı tablo */
$mc_modul_ayar['tablo'] = "kategoriler";

/* Listede gözükecek araçlar */
$mc_modul_ayar['araclar'] = ['duzenle', 'sil', 'yayin', 'vurgula'];

/* Veritabanındaki tarih verisi */
$mc_modul_ayar['tarih'] = "etarih";

/* Aynı tabloda birden fazla içerik türü varsa atanır, yoksa 0 atanır */
$mc_modul_ayar['tip'] = 0;

/* Sıralamada iç içe geçme derinliğini belirtir, 1 ve 0 değeri iç içe geçmez */
$mc_modul_ayar['sirala_sekme'] = 2;

/* Dil dosyasındaki anahtarlar */
$mc_modul_ayar['baslik'] = "kategoriler";
$mc_modul_ayar['ekle'] = "yeni_kategori_ekle";
$mc_modul_ayar['sirala'] = "kategorileri_sirala";

/* Tasarımsal Ayarlar */
$mc_modul_ayar['tasarim']['aciklama'] = false;
$mc_modul_ayar['tasarim']['kategori'] = false;
$mc_modul_ayar['tasarim']['icerik'] = false;
$mc_modul_ayar['tasarim']['yayin'] = true;
$mc_modul_ayar['tasarim']['vurgula'] = false;
$mc_modul_ayar['tasarim']['resim'] = false;
$mc_modul_ayar['tasarim']['video'] = false;
$mc_modul_ayar['tasarim']['galeri'] = false;
$mc_modul_ayar['tasarim']['ek'] = false;
$mc_modul_ayar['tasarim']['izinler'] = false;