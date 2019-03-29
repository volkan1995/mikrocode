<?php
if(!defined('m_guvenlik')) { exit; }

/* Menü ve modül ismi aynıdır */
$mc_modul_ayar['menu'] = "temaayarlari";
$mc_modul_ayar['yetki'] = "temaayarlari";

/* Veritabanında çalışacağı tablo */
$mc_modul_ayar['tablo'] = "yazilar";
$mc_modul_ayar['ust_tablo'] = "kategoriler";

/* Sıralamada iç içe geçme derinliğini belirtir, 1 ve 0 değeri iç içe geçmez */
$mc_modul_ayar['sirala_sekme'] = 1;

/* Dil dosyasındaki anahtarlar */
$mc_modul_ayar['baslik'] = "Tema Ayarları";
$mc_modul_ayar['renk'] = "Renk Ayarları";
$mc_modul_ayar['sirala'] = "Sıra Ayarları";