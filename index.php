<?php

@ini_set('display_errors', 0);
@ini_set('display_startup_errors', 0);
error_reporting(0);

/* Gelişitirici Modları
 * 0 | FALSE    : Kapalı
 * 1 | TRUE     : Otomatik İşlemler ve Ek Ayarlar
 * 2            : Otomatik İşlemler, Ek Ayarlar ve Hata Raporları
 */
define("m_gelistirici", 0);

if (m_gelistirici > 0) {
    $m_iz = explode(" ", microtime());
    $m_iz = doubleval($m_iz[1]) + doubleval($m_iz[0]);
    if (m_gelistirici == 2) {
        ini_set('xdebug.var_display_max_depth', '-1');
        ini_set('xdebug.var_display_max_children', '-1');
        ini_set('xdebug.var_display_max_data', '-1');
        @ini_set('display_errors', 1);
        @ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

/* Katman: 0 */
define("m_dizin", realpath(__DIR__) . DIRECTORY_SEPARATOR);

/* Katman: 1 */
define("m_sistem", m_dizin . "sistem" . DIRECTORY_SEPARATOR);
define("m_sablon", m_dizin . "sablon" . DIRECTORY_SEPARATOR);
define("m_dosyalar", m_dizin . "dosyalar" . DIRECTORY_SEPARATOR);
define("m_moduller", m_dizin . "yonetici" . DIRECTORY_SEPARATOR);
define("m_depo", m_dizin . "depo" . DIRECTORY_SEPARATOR);

/* Katman: 2 */
define("m_eklentiler", m_sablon . "eklentiler" . DIRECTORY_SEPARATOR);
define("m_temalar", m_sablon . "temalar" . DIRECTORY_SEPARATOR);
define("m_cekirdek", m_sistem . "cekirdek" . DIRECTORY_SEPARATOR);
define("mc_sablon", m_sistem . "sablon" . DIRECTORY_SEPARATOR);
define("mc_ayarlar", m_sistem . "ayarlar" . DIRECTORY_SEPARATOR);
define("mc_yardimcilar", m_sistem . "yardimcilar" . DIRECTORY_SEPARATOR);

function m_git($git = "index.php") {
    @header("location: $git");
    echo "<script type='text/javascript'> window.top.location=\"$git\"; </script>";
    exit;
}

if (!defined('m_guvenlik')) {
    if (!file_exists(m_depo . "veritabani.php")) {
        m_git("/sistem/kurulum/");
    } else {
        echo "Yasak erişim yapıyorsunuz.";
        exit;
    }
}

@ob_start();

@session_start();

if (!defined('m_kurulum')) {
    require m_cekirdek . "index.php";
} else {
    require m_sistem . "kurulum" . DIRECTORY_SEPARATOR . "loader.php";
}

header('Content-Type: text/html; charset=utf-8');