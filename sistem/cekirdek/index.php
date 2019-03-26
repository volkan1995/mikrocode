<?php

if (file_exists(m_depo . "veritabani.php")) {
    require m_depo . "veritabani.php";
}

@date_default_timezone_set('Europe/Istanbul');
@setlocale(LC_TIME, 'tr_TR');
@setlocale(LC_ALL, "turkish");

define("m_host", $_SERVER['HTTP_HOST']);
require m_cekirdek . "fonksiyonlar" . DIRECTORY_SEPARATOR . "temel.php";

if (defined('m_baglanti') && m_baglanti) {
    require m_cekirdek . "siniflar" . DIRECTORY_SEPARATOR . "veritabani.php";
    $m_vt = new m_baglan();
    if (!$m_vt->kontrol) {
        m_git("//" . m_host . "/sistem/kurulum/?adim=2");
    }
    require m_cekirdek . "ayarlar.php";
}

if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
    $_SERVER['HTTPS'] = 'on';
    define("m_domain", "https://" . m_host);
} else {
    define("m_domain", "http://" . m_host);
}

define("m_url", m_domain . $_SERVER['REQUEST_URI']);
define("mc_sistem", m_domain . "/sistem/");
define("mc_img", mc_sistem . "sablon/resimler/");

if (!isset($_SERVER["HTTP_REFERER"])) {
    $_SERVER["HTTP_REFERER"] = m_url;
}

if (defined('mt_isim')) {
    define("m_tema", m_temalar . mt_isim . DIRECTORY_SEPARATOR);
    define("mt_tema", m_domain . "/sablon/temalar/" . mt_isim . "/");
}

require m_cekirdek . "fonksiyonlar" . DIRECTORY_SEPARATOR . "index.php";
require m_cekirdek . "siniflar" . DIRECTORY_SEPARATOR . "index.php";

if (defined('m_site') && m_site) {
    require m_cekirdek . "site" . DIRECTORY_SEPARATOR . "index.php";
} else if (defined('m_panel') && m_panel) {
    require m_cekirdek . "panel" . DIRECTORY_SEPARATOR . "index.php";
}