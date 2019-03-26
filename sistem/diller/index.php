<?php

if (!defined('m_guvenlik')) {
    exit;
}

$mc_diller = (object) array(
    'tr' => array('dil' => "Türkçe", 'timezone' => "Europe/Istanbul", 'lc_time' => "tr_TR", 'lc_all' => "Turkish"),
    'en' => array('dil' => "English", 'timezone' => "Europe/London", 'lc_time' => "en_GB", 'lc_all' => "English_United_Kingdom"),
    'ru' => array('dil' => "русский", 'timezone' => "Europe/Moscow", 'lc_time' => "ru_RU", 'lc_all' => "Russian"),
    'fr' => array('dil' => "Français", 'timezone' => "Europe/Paris", 'lc_time' => "fr_FR", 'lc_all' => "French_Standard"),
    'ar' => array('dil' => "العربية", 'timezone' => "Asia/Riyadh", 'lc_time' => "tr_TR", 'lc_all' => "Arabic_Saudi_Arabia")
);

if (isset($_POST['dil'])) {
    $_SESSION['dil'] = $_POST['dil'];
    unset($_POST['dil']);
}

if (!isset($_SERVER["HTTP_ACCEPT_LANGUAGE"])) {
    $_SERVER["HTTP_ACCEPT_LANGUAGE"] = "tr";
}

if (isset($_SESSION['dil']) && !empty($_SESSION['dil'])) {
    if (isset($mc_diller->{$_SESSION['dil']})) {
        $mc_dil = $_SESSION['dil'];
    } else {
        $mc_dil = $mc_dil = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
    }
} else {
    $mc_dil = $mc_dil = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
}

if (defined('m_kurulum')) {
    if (file_exists(m_sistem . "diller" . DIRECTORY_SEPARATOR . "kurulum" . DIRECTORY_SEPARATOR . $mc_dil . ".php")) {
        require m_sistem . "diller" . DIRECTORY_SEPARATOR . "kurulum" . DIRECTORY_SEPARATOR . $mc_dil . ".php";
    } else if (file_exists(m_sistem . "diller" . DIRECTORY_SEPARATOR . "kurulum" . DIRECTORY_SEPARATOR . "tr.php")) {
        require m_sistem . "diller" . DIRECTORY_SEPARATOR . "kurulum" . DIRECTORY_SEPARATOR . "tr.php";
    }
} else {
    if (file_exists(m_sistem . "diller" . DIRECTORY_SEPARATOR . "yonetici" . DIRECTORY_SEPARATOR . $mc_dil . ".php")) {
        require m_sistem . "diller" . DIRECTORY_SEPARATOR . "yonetici" . DIRECTORY_SEPARATOR . $mc_dil . ".php";
    } else if (file_exists(m_sistem . "diller" . DIRECTORY_SEPARATOR . "yonetici" . DIRECTORY_SEPARATOR . "tr.php")) {
        require m_sistem . "diller" . DIRECTORY_SEPARATOR . "yonetici" . DIRECTORY_SEPARATOR . "tr.php";
    }
}

if (isset($mc_s_dil) && is_array($mc_s_dil)) {
    function mc_dil($yaz) {
        if (isset($GLOBALS['mc_s_dil'][$yaz])) {
            return $GLOBALS['mc_s_dil'][$yaz];
        } else {
            return $yaz;
        }
    }
} else {
    function mc_dil($yaz) {
        return "#tanımsız";
    }
}