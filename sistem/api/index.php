<?php
if (empty($_SERVER['HTTP_AUTHKEY'])) {
    if (empty($_POST['AUTHKEY'])) {
        $mapi_result['status'] = false;
        $mapi_result['error'] = "Doğrulama anahtarı geçersiz.";
        exit(json_encode($mapi_result['error']));
    }
    $_SERVER['HTTP_AUTHKEY'] = $_POST['AUTHKEY'];
}

if(strlen($_SERVER['HTTP_AUTHKEY']) > 10){
    $_SERVER['HTTP_AUTHKEY'] = substr($_SERVER['HTTP_AUTHKEY'], 2, -1);
}

$auth_key = json_decode(base64_decode($_SERVER['HTTP_AUTHKEY']));

if (empty($auth_key->client) || empty($auth_key->id) || empty($auth_key->key) || empty($_GET['use'])) {
    $mapi_result['status'] = false;
    $mapi_result['error']['message'] = "Token eşleşmesi hatalı";
    $mapi_result['error']['data'] = $auth_key;
    exit(json_encode($mapi_result['error']));
}

if (empty($_GET['lang'])) { $_GET['lang'] = "tr"; }
if (!defined('m_guvenlik')) { define("m_guvenlik", true); }
if (!defined('m_baglanti')) { define("m_baglanti", true); }

require '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'index.php';

require m_cekirdek . "fonksiyonlar" . DIRECTORY_SEPARATOR . "api.php";

if (file_exists("." . DIRECTORY_SEPARATOR . "lang" . DIRECTORY_SEPARATOR . $_GET['lang'] . ".php")) {
    require "." . DIRECTORY_SEPARATOR . "lang" . DIRECTORY_SEPARATOR . $_GET['lang'] . ".php";
} else {
    require "." . DIRECTORY_SEPARATOR . "lang" . DIRECTORY_SEPARATOR . "tr.php";
}

if (m_gelistirici < 1) {
    if(isset($_SERVER['HTTP_POSTMAN_TOKEN'])){
        $mapi_result['status'] = false;
        $mapi_result['error'] = $mapi_dil[14];
        exit(json_encode($mapi_result['error']));
    }
}

/* Verileri al */
$m_api = array('kod' => trim($auth_key->id), 'anahtar' => trim($auth_key->key), 'istek' => trim($_GET['use']));

/* İstek geçerli mi */
if (!in_array($m_api['istek'], $mc_istekler)) {
    hataYaz(1, $mapi_dil[0] . "; USE:" . $m_api['istek']);
}

/* API bul ve yakala */
$mapi_bul = $m_vt->select()->from("mapi")
        ->where("kod", $m_api['kod'])->where("anahtar", $m_api['anahtar'])->where("durum", 1)->where("tip", 0)
        ->result();
if (count($mapi_bul) == 0) {
    hataYaz(1, $mapi_dil[1] . "; ID:" . $auth_key->id . ", KEY:" . $auth_key->key);
}
$mapi_bul = $mapi_bul[0];

/* Api'nin izinli servislerini kontrol et */
$mapi_use = explode(",", $mapi_bul->servis);
if (!in_array(array_search($m_api['istek'], $mc_istekler), $mapi_use)) {
    hataYaz(1, $mapi_dil[13] . "; USE:" . $m_api['istek']);
}

/* İstemciler arasında sorgula */
$m_urlparcala = parse_url($auth_key->client);
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
exit;