<?php

if (!isset($_SESSION['kullanici'])) {
    if (isset($_COOKIE["kullanici_id"]) && isset($_COOKIE["kullanici_sifre"]) && !is_array($_COOKIE["kullanici_sifre"]) && !is_array($_COOKIE["kullanici_id"])) {
        $_SESSION['kullanici']['id'] = $_COOKIE["kullanici_id"];
        $_SESSION['kullanici']['sifre'] = $_COOKIE["kullanici_sifre"];
    }
}
if (isset($_SESSION['kullanici']['id']) && isset($_SESSION['kullanici']['sifre'])) {
    $mc_oturum = $m_vt->sec(['table' => "kullanicilar", 'where' => ['id' => $_SESSION['kullanici']['id'], 'sifre' => $_SESSION['kullanici']['sifre']]]);

    if (!$mc_oturum) {
        include 'cikis.php';
    }

    $mc_oturum = $mc_oturum[0];

    if (!defined('mc_oturum_id')) {
        define('mc_oturum_id', $mc_oturum->id);
    }

    $mc_oturum->eklenti = json_decode($mc_oturum->eklenti, true);

    $mc_oturum_def = array('dil' => "tr");

    if (!empty($mc_oturum->ad) || !empty($mc_oturum->soyad)) {
        $mc_oturum->name = rtrim($mc_oturum->ad . " " . $mc_oturum->soyad);
    } else {
        $mc_oturum->name = $mc_oturum->kadi;
    }

    $mc_oturum->eklenti = json_decode(json_encode($mc_oturum->eklenti));
}