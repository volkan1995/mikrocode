<?php

if (!defined('m_site')) {
    define("m_site", true);
}

if (!defined('m_guvenlik')) {
    define("m_guvenlik", true);
}

if (!defined('m_baglanti')) {
    define("m_baglanti", true);
}

require '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'index.php';

if (!file_exists(mt_isim . DIRECTORY_SEPARATOR . "functions" . DIRECTORY_SEPARATOR . "functions.php")) {
    echo "functions.php dosyası olmadan devam edilemez";
    exit;
}

if (!file_exists(mt_isim . DIRECTORY_SEPARATOR . "functions" . DIRECTORY_SEPARATOR . "settings.php")) {
    echo "settings.php dosyası olmadan devam edilemez";
    exit;
}

set_include_path('.' . DIRECTORY_SEPARATOR . mt_isim . DIRECTORY_SEPARATOR);

require mt_isim . DIRECTORY_SEPARATOR . "functions" . DIRECTORY_SEPARATOR . "functions.php";

$m_rota = new m_rota(['tema' => mt_isim]);

require mt_isim . DIRECTORY_SEPARATOR . "functions" . DIRECTORY_SEPARATOR . "settings.php";

$m_rota->calistir();

$m_rota->dosyalariAktar();