<?php

if (!isset($_SESSION)) {
    session_start();
}

header('Content-Type: text/html; charset=utf-8');

$_SESSION = array();

@setcookie("kullanici_id", "", time() - (3600 * 24 * 10));

@setcookie("kullanici_sifre", "", time() - (3600 * 24 * 10));

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - (3600 * 24 * 10), '/');
}

session_destroy();

$mc_s_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/yonetici/";

if (isset($_SERVER["HTTP_REFERER"])) {

    $mc_url = $_SERVER["HTTP_REFERER"];
} else {

    $mc_url = $mc_s_url;
}

$mc_urlJson64 = $mc_s_url . "giris.php?get=" . base64_encode(json_encode(['git' => $mc_url, 'yetki' => 2]));

@header("location: " . $mc_urlJson64);

echo "<script type='text/javascript'>window.top.location=\"$mc_urlJson64\"; </script>";

exit;