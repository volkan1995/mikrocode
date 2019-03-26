<?php
if (!defined('mdb_guvenlik') || !isset($_POST['api_anahtari'], $_POST['kullanici_id'], $_POST['giris_kapisi'])) {
    exit("<b>Gönderim hatası</b><br/>İstemci sunucusunda güvenlik hatası");
}

require 'mc.veritabani.php';

require 'mc.mysql.class.php';

$m_vt = new m_baglan();

if (!$m_vt->kontrol) {
    exit("<b>Bağlantı Hatası</b><br/>Veritabanı bilgileri hatalı");
}

$kullanici = $m_vt->select()->from(mdt_users)->where(mdt_users_id, $_POST['kullanici_id'])->result();

if (!count($kullanici)) {
    exit("<b>Gönderim hatası</b><br/>Kayıtlı kullanıcı bulunamadı");
}

$kullanici = $kullanici[0];

function mc_zamanHesapla($tarih, $tam = false) {
    $simdi = new DateTime();
    $gelenTarih = new DateTime($tarih);
    $diff = $simdi->diff($gelenTarih);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $birimler = array(
        'y' => 'yıl',
        'm' => 'ay',
        'w' => 'hafta',
        'd' => 'gün',
        'h' => 'saat',
        'i' => 'dakika',
        's' => 'saniye',
    );
    foreach ($birimler as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v;
        } else {
            unset($birimler[$k]);
        }
    }
    if (!$tam) {
        $birimler = array_slice($birimler, 0, 1);
    }
    return $birimler ? implode(', ', $birimler) . ' önce' : 'az önce';
}

function mc_htmlCevir($yazi = null){
    return str_replace(array(" ", "\r\n", "\r", "\n"), array('&nbsp;', '<br />', '<br />', '<br />'), htmlentities(json_decode($yazi)));
}