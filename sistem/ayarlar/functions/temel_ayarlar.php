<?php

if (!defined('m_guvenlik')) {
    exit;
}

if (!isset($_POST['baslik']) || empty($_POST['baslik'])) {
    mc_uyari(3, "<b>" . mc_dil('bos_alanlar_var') . "</b>");
    exit;
}

if (isset($_POST['sitedil'])) {
    $mc_values['dil'] = $_POST['sitedil'];
    unset($_POST['sitedil']);
}

if (isset($_POST['galeri_tr'])) {
    $mc_values['medya']['galeri_tr'] = $_POST['galeri_tr'];
    unset($_POST['galeri_tr']);
}

if (isset($_POST['logo_tr'])) {
    $mc_values['medya']['logo_tr'] = $_POST['logo_tr'];
    unset($_POST['logo_tr']);
}

if (isset($_POST['galeri_tr_b'])) {
    $mc_values['medya']['galeri_tr_b'] = $_POST['galeri_tr_b'];
    unset($_POST['galeri_tr_b']);
}

if (isset($_POST['galeri_tr_a'])) {
    $mc_values['medya']['galeri_tr_a'] = $_POST['galeri_tr_a'];
    unset($_POST['galeri_tr_a']);
}

if (isset($_POST['galeri_tr_u'])) {
    $mc_values['medya']['galeri_tr_u'] = $_POST['galeri_tr_u'];
    unset($_POST['galeri_tr_u']);
}

if (isset($_POST['galeri_tr_y'])) {
    $mc_values['medya']['galeri_tr_y'] = $_POST['galeri_tr_y'];
    unset($_POST['galeri_tr_y']);
}

$_POST['baslik'] = strip_tags($_POST['baslik']);
if (isset($_POST['aciklama'])) {
    $_POST['aciklama'] = strip_tags($_POST['aciklama']);
} else {
    $_POST['aciklama'] = null;
}
if (isset($_POST['anahtar'])) {
    $_POST['anahtar'] = strip_tags($_POST['anahtar']);
} else {
    $_POST['anahtar'] = null;
}

$mc_values['bilgi'] = json_encode($_POST);

$mc_values['medya'] = json_encode($mc_values['medya']);

$mc_kaydet = $m_vt->guncelle(['table' => "ayarlar", 'values' => $mc_values, 'where' => ['id' => 1]])['sonuc'];

mc_uyari($mc_kaydet, ["<b>Başarılı</b>Ayarlarınız kaydedildi", "<b>Başarısız</b>Ayarlarınız bilinmeyen bir sebepten dolayı kaydedilemedi"]);

echo '<script> $(".navbar-brand").text("' . $_POST['baslik'] . '"); </script>';
