<?php

if (!defined('mc_fonksiyonlar')) {
    define("mc_fonksiyonlar", m_cekirdek . "panel" . DIRECTORY_SEPARATOR . "fonksiyonlar" . DIRECTORY_SEPARATOR);
}

if (!defined('mc_siniflar')) {
    define("mc_siniflar", m_cekirdek . "panel" . DIRECTORY_SEPARATOR . "siniflar" . DIRECTORY_SEPARATOR);
}

define("mc_update", "https://guncelle.mikrobilisim.net");

define("mc_panel", m_domain . "/yonetici/");

define("mc_css", mc_sistem . "sablon/css/");

define("mc_js", mc_sistem . "sablon/js/");

define("mc_fonts", mc_sistem . "sablon/fonts/");

define("mc_plugins", mc_sistem . "sablon/plugins/");

define("md_img", mc_sistem . "sablon/images/");

require m_sistem . "diller" . DIRECTORY_SEPARATOR . "index.php";

require mc_fonksiyonlar . "index.php";

require mc_siniflar . "index.php";

require m_cekirdek . "panel" . DIRECTORY_SEPARATOR . "kullanici.php";

if (file_exists(m_tema . "lang" . DIRECTORY_SEPARATOR . "index.php")) {
    include m_tema . "lang" . DIRECTORY_SEPARATOR . "index.php";
}
