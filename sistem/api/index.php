<?php
if (empty($_SERVER['HTTP_REFERER'])) {
    $mapi_result['status'] = false;
    $mapi_result['error'] = "Token eşleşmesi hatalı: Doğrulama kodu";
    exit(json_encode($mapi_result['error']));
}
if (empty($_SERVER['HTTP_ID']) || empty($_SERVER['HTTP_KEY']) || empty($_SERVER['HTTP_USE'])) {   
    if (empty($_GET['id']) || empty($_GET['key']) || empty($_GET['use'])) {
        $mapi_result['status'] = false;
        $mapi_result['error'] = "Token eşleşmesi hatalı";
        exit(json_encode($mapi_result['error']));
    }
    $_SERVER['HTTP_ID'] = $_GET['id'];
    $_SERVER['HTTP_KEY'] = $_GET['key'];
    $_SERVER['HTTP_USE'] = $_GET['use'];
}

if (empty($_GET['lang'])) {
    $_GET['lang'] = "tr";
}

if (!defined('m_guvenlik')) {
    define("m_guvenlik", true);
}
if (!defined('m_baglanti')) {
    define("m_baglanti", true);
}

require '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'index.php';

require m_cekirdek . "fonksiyonlar" . DIRECTORY_SEPARATOR . "api.php";

if (file_exists("." . DIRECTORY_SEPARATOR . "lang" . DIRECTORY_SEPARATOR . $_GET['lang'] . ".php")) {
    require "." . DIRECTORY_SEPARATOR . "lang" . DIRECTORY_SEPARATOR . $_GET['lang'] . ".php";
} else {
    require "." . DIRECTORY_SEPARATOR . "lang" . DIRECTORY_SEPARATOR . "tr.php";
}

/* Verileri al */
$m_api = array('kod' => trim($_SERVER['HTTP_ID']), 'anahtar' => trim($_SERVER['HTTP_KEY']), 'istek' => trim($_SERVER['HTTP_USE']));

/* İstek geçerli mi */
if (!in_array($m_api['istek'], $mc_istekler)) {
    hataYaz(1, $mapi_dil[0] . "; USE:" . $m_api['istek']);
}

/* API bul ve yakala */
$mapi_bul = $m_vt->select()->from("mapi")
        ->where("kod", $m_api['kod'])->where("anahtar", $m_api['anahtar'])->where("durum", 1)->where("tip", 0)
        ->result();
if (count($mapi_bul) == 0) {
    hataYaz(1, $mapi_dil[1] . "; ID:" . $_SERVER['HTTP_ID'] . ", KEY:" . $_SERVER['HTTP_KEY']);
}
$mapi_bul = $mapi_bul[0];

/* Api'nin izinli servislerini kontrol et */
$mapi_use = explode(",", $mapi_bul->servis);
if (!in_array(array_search($m_api['istek'], $mc_istekler), $mapi_use)) {
    hataYaz(1, $mapi_dil[13] . "; USE:" . $m_api['istek']);
}

/* İstemciler arasında sorgula */
$m_urlparcala = parse_url($_SERVER['HTTP_REFERER']);
if (!isset($m_urlparcala['host'])) {
    $m_urlparcala['host'] = $m_urlparcala['path'];
}
$m_api['istemci'] = preg_replace('/www\./i', '', $m_urlparcala['host']);
$mapi_istemciler = json_decode($mapi_bul->istemci);
if (count($mapi_istemciler) && !in_array($m_api['istemci'], $mapi_istemciler)) {
    hataYaz(1, $mapi_dil[5] . "; CLIENT:" . $m_api['istemci']);
}

/* API limitini kontrol et */
$mapi_dongu = json_decode($mapi_bul->dongu);
if (!empty($mapi_dongu)) {
    $mapi_ymdH = date('ymdH');
    if ($mapi_dongu->s != $mapi_ymdH) {
        $mapi_kaydet = $m_vt->guncelle(['table' => "mapi", 'values' => ['sayac' => 1, 'dongu' => json_encode(array('s' => $mapi_ymdH, 'l' => $mapi_dongu->l))], 'where' => ['id' => $mapi_bul->id]])['sonuc'];
    } else {
        $mapi_sayac = $mapi_bul->sayac + 1;
        if ($mapi_sayac > $mapi_dongu->l) {
            $mapi_fark = floor((strtotime(date('Y-m-d H:00:00', strtotime('+1 hour'))) - time()) / 60);
            hataYaz(2, $mapi_dil[2] . "! " . $mapi_dil[3] . ": {$mapi_fark} " . $mapi_dil[11]);
        }
        $mapi_kaydet = $m_vt->guncelle(['table' => "mapi", 'values' => ['sayac' => $mapi_sayac], 'where' => ['id' => $mapi_bul->id]])['sonuc'];
    }
    if (!$mapi_kaydet) {
        hataYaz(1, $mapi_dil[4] . "; USE:" . $m_api['istek']);
    }
}

/* API dizinde ara ve yükle */
$m_api['konum'] = "." . DIRECTORY_SEPARATOR . "use" . DIRECTORY_SEPARATOR . $m_api['istek'] . ".php";
if (file_exists($m_api['konum'])) {
    $mapi_result['status'] = true;
    require $m_api['konum'];
} else {
    hataYaz(1, $mapi_dil[4] . "; USE:" . $m_api['istek']);
}

/* Verileri yaz */
echo json_encode($mapi_result);
exit(1);