<?php

if (empty($_GET['token'])) {
    exit;
}

$_GET['token'] = json_decode(base64_decode(substr($_GET['token'], 2, -1)));

if (empty($_GET['token']->client) || empty($_GET['token']->id) || empty($_GET['token']->key)) {
    $mapi_result['status'] = false;
    $mapi_result['error']['message'] = "Token eşleşmesi hatalı";
    $mapi_result['error']['data'] = $_GET['token'];
    exit(json_encode($mapi_result['error']));
}

function HttpStatus($code) {
    $status = array(
    0 => 'Başarılı',  
    1 => 'Yetkisiz Erişim',  
    2 => 'Yetkisiz İşlem',
    3 => 'Hatalı İstek');   
    return $status[$code] ? $status[$code] : $status[500];
}

function hataYaz($hata = 0, $yaz = null) {
    header("Content-Type: application/json; charset=utf-8");
    $ja['status'] = false;
    $ja['code'] = $hata;
    $ja['error'] = HttpStatus($hata);
    $ja['message'] = $yaz;
    echo json_encode($ja);
    exit;
}

/* Verileri al */
$m_api = array('kod' => trim($_GET['token']->id), 'anahtar' => trim($_GET['token']->key));

/* API bul ve yakala */
$mapi_bul = $m_vt->select()->from("mapi")->where("kod", $m_api['kod'])->where("anahtar", $m_api['anahtar'])->where("durum", 1)->where("tip", 0)->result();
if (count($mapi_bul) == 0) {
    hataYaz(1, "Token eşleşmesi hatalı; ID:" . $m_api['kod'] . ", KEY:" . $m_api['kod']);
}
$mapi_bul = $mapi_bul[0];;

/* Api'nin izinli servislerini kontrol et */
if (!in_array(2, explode(",", $mapi_bul->servis))) {
    hataYaz(1, "Yetkisiz istek; USE:" . "select");
}

/* İstemciler arasında sorgula */
$m_urlparcala = parse_url($_GET['token']->client);
if (!isset($m_urlparcala['host'])) {
    $m_urlparcala['host'] = $m_urlparcala['path'];
}
$m_api['istemci'] = preg_replace('/www\./i', '', $m_urlparcala['host']);
$mapi_istemciler = json_decode($mapi_bul->istemci);
if (count($mapi_istemciler) && !in_array($m_api['istemci'], $mapi_istemciler)) {
    hataYaz(1, "Yetkisiz istek; CLIENT:" . $m_api['istemci']);
}


/* API limitini kontrol et */
$mapi_dongu = json_decode($mapi_bul->dongu);
if (!empty($mapi_dongu)) {
    $mapi_ymdH = date('ymdH');
    if ($mapi_dongu->s != $mapi_ymdH) {
        $mapi_kaydet = $m_vt->guncelle(['table' => "mapi", 'values' => ['sayac' => 1, 'dongu' => json_encode(array('s' => $mapi_ymdH, 'l' => $mapi_dongu->l))], 'where' => ['id' => $mapi_bul->id]])['sonuc'];
    } else {
        $mapi_sayac = $mapi_bul->sayac + 1;
        $mapi_kalan = $mapi_dongu->l - $mapi_sayac;
        if ($mapi_sayac > $mapi_dongu->l) {
            $mapi_fark = floor((strtotime(date('Y-m-d H:00:00', strtotime('+1 hour'))) - time()) / 60);
            hataYaz(2, "Saatlik işlem limitine ulaşıldı! Kalan süre: {$mapi_fark} dk");
        }
        $mapi_kaydet = $m_vt->guncelle(['table' => "mapi", 'values' => ['sayac' => $mapi_sayac], 'where' => ['id' => $mapi_bul->id]])['sonuc'];
    }
    if (!$mapi_kaydet) {
        hataYaz(1, "Bu hizmet geçici olarak kullanımdan kaldırıldı; USE:" . $m_api['istek']);
    }
}


$urun_sor = $m_vt->select()->from('yazilar')->where('durum', 1)->where('tip', 0)->where('grup', $id)->where('dil', $dil)->result();
if(!count($urun_sor)){
    hataYaz(1, "İstenen ürün bulunamadı!");
}
$urun_sor = $urun_sor[0];

$kat_sor = $m_vt->select()->from('kategoriler')->where('durum', 1)->where('id', $urun_sor->kategori)->result();
if(!count($kat_sor)){
    hataYaz(1, "İstenen ürün kategorisi bulunamadı!");
}


$mapi_result['status'] = true;

$mapi_result['count'] = 1;

$mapi_result['fetch'] = [
    'baslik' => $urun_sor->baslik,
    'aciklama' => $urun_sor->aciklama,
    'icerik' => $urun_sor->icerik,
    'resim' => m_resim($urun_sor->resim, 500, 500, 2, 100),    
    'kategoriID' => $urun_sor->kategori,
    'kategori' => $kat_sor[0]->baslik,
    'kategoriSef' => $kat_sor[0]->sef    
];

if(isset($mapi_kalan)){
    $mapi_result['fetch']['apiLimit'] = $mapi_kalan;
}

var_dump($mapi_result);

exit;