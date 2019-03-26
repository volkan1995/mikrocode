<?php

if (!isset($_SESSION)) {
    session_start();
}

header('Content-Type: text/html; charset=utf-8');

$_SESSION = array();

@setcookie("kullanici_id", "", time() - (3600 * 24 * 7));

@setcookie("kullanici_sifre", "", time() - (3600 * 24 * 7));

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

session_destroy();

if (isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] != m_url) {
    $mc_url = $_SERVER["HTTP_REFERER"];
} else {
    $mc_url = "/";
}

@header("location: " . $mc_url);

echo "<script type='text/javascript'>window.top.location=\"$mc_url\"; </script>";

exit;