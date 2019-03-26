<?php

if (!defined('mt_fonksiyonlar')) {
    define("mt_fonksiyonlar", m_cekirdek . "site" . DIRECTORY_SEPARATOR . "fonksiyonlar" . DIRECTORY_SEPARATOR);
}

if (!defined('mt_siniflar')) {
    define("mt_siniflar", m_cekirdek . "site" . DIRECTORY_SEPARATOR . "siniflar" . DIRECTORY_SEPARATOR);
}

require mt_fonksiyonlar . "index.php";

require mt_siniflar . "index.php";

if (!defined('mt_isim') || !mt_isim) {
    echo "<font color='#ce0000'><b>TR:</b></font> Lütfen tema seçin<br/>";
    echo "<font color='red'><b>EN:</b></font> Please select a theme<br/>";
    echo "<font color='blue'><b>RU:</b></font> выберите тему<br/>";
    echo "<font color='green'><b>AR:</b></font> يرجى اختيار موضوع";
    exit;
}