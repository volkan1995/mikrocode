<?php

$mc_tablolar[0] = "ayarlar";
$mc_sql[$mc_tablolar[0]]['erisim'] = "TINYINT(2) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[0]]['dil'] = "VARCHAR(5) DEFAULT NULL";
$mc_sql[$mc_tablolar[0]]['lisans'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[0]]['sistem'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[0]]['ayar'] = "TEXT NULL";
$mc_sql[$mc_tablolar[0]]['bilgi'] = "TEXT NULL";
$mc_sql[$mc_tablolar[0]]['iletisim'] = "TEXT NULL";
$mc_sql[$mc_tablolar[0]]['medya'] = "TEXT NULL";
$mc_sql[$mc_tablolar[0]]['eklenti'] = "TEXT NULL";

$mc_tablolar[1] = "gruplar";
$mc_sql[$mc_tablolar[1]]['baslik'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[1]]['yetki'] = "TEXT NULL";
$mc_sql[$mc_tablolar[1]]['panel'] = "TINYINT(2) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[1]]['site'] = "TINYINT(2) NULL DEFAULT 0";

$mc_tablolar[2] = "kullanicilar";
$mc_sql[$mc_tablolar[2]]['kadi'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[2]]['grup'] = "TINYINT(2) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[2]]['mail'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[2]]['sifre'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[2]]['ad'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[2]]['soyad'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[2]]['resim'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[2]]['izinler'] = "TEXT NULL";
$mc_sql[$mc_tablolar[2]]['eklenti'] = "TEXT NULL";
$mc_sql[$mc_tablolar[2]]['vds'] = "TEXT NULL";
$mc_sql[$mc_tablolar[2]]['tema'] = "TEXT NULL";
$mc_sql[$mc_tablolar[2]]['etarih'] = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";

$mc_tablolar[3] = "ip";
$mc_sql[$mc_tablolar[3]]['ip'] = "VARCHAR(20) DEFAULT NULL";
$mc_sql[$mc_tablolar[3]]['kid'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[3]]['cihaz'] = "TINYINT(2) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[3]]['tarih'] = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";

$mc_tablolar[4] = "dosyalar";
$mc_sql[$mc_tablolar[4]]['baslik'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[4]]['tip'] = "TINYINT(2) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[4]]['klasor'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[4]]['ekleyen'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[4]]['boyut'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[4]]['konum'] = "TEXT NULL";
$mc_sql[$mc_tablolar[4]]['etarih'] = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";

$mc_tablolar[5] = "galeriler";
$mc_sql[$mc_tablolar[5]]['baslik'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[5]]['sef'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[5]]['kategori'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[5]]['ekleyen'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[5]]['dosyalar'] = "TEXT NULL";
$mc_sql[$mc_tablolar[5]]['durum'] = "TINYINT(2) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[5]]['sira'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[5]]['etarih'] = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";

$mc_tablolar[6] = "sayfalar";
$mc_sql[$mc_tablolar[6]]['baslik'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[6]]['sef'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[6]]['tip'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[6]]['dil'] = "VARCHAR(5) DEFAULT NULL";
$mc_sql[$mc_tablolar[6]]['grup'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[6]]['ust'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[6]]['durum'] = "TINYINT(2) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[6]]['menu'] = "TINYINT(2) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[6]]['resim'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[6]]['icerik'] = "TEXT NULL";
$mc_sql[$mc_tablolar[6]]['sira'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[6]]['eklenti'] = "TEXT NULL";
$mc_sql[$mc_tablolar[6]]['ekleyen'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[6]]['duzenleyen'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[6]]['etarih'] = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";
$mc_sql[$mc_tablolar[6]]['dtarih'] = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";

$mc_tablolar[7] = "kategoriler";
$mc_sql[$mc_tablolar[7]]['baslik'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[7]]['sef'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[7]]['aciklama'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[7]]['icerik'] = "TEXT NULL";
$mc_sql[$mc_tablolar[7]]['tip'] = "TINYINT(2) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[7]]['dil'] = "VARCHAR(5) DEFAULT NULL";
$mc_sql[$mc_tablolar[7]]['grup'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[7]]['ust'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[7]]['durum'] = "TINYINT(2) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[7]]['sira'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[7]]['vurgula'] = "TINYINT(2) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[7]]['ekleyen'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[7]]['duzenleyen'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[7]]['resim'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[7]]['eklenti'] = "TEXT NULL";
$mc_sql[$mc_tablolar[7]]['izinler'] = "TEXT NULL";
$mc_sql[$mc_tablolar[7]]['etarih'] = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";
$mc_sql[$mc_tablolar[7]]['dtarih'] = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";

$mc_tablolar[8] = "yazilar";
$mc_sql[$mc_tablolar[8]]['baslik'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[8]]['sef'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[8]]['aciklama'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[8]]['icerik'] = "TEXT NULL";
$mc_sql[$mc_tablolar[8]]['tip'] = "TINYINT(2) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[8]]['dil'] = "VARCHAR(5) DEFAULT NULL";
$mc_sql[$mc_tablolar[8]]['grup'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[8]]['kategori'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[8]]['durum'] = "TINYINT(2) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[8]]['sira'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[8]]['vurgula'] = "TINYINT(2) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[8]]['ekleyen'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[8]]['duzenleyen'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[8]]['resim'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[8]]['eklenti'] = "TEXT NULL";
$mc_sql[$mc_tablolar[8]]['etarih'] = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";
$mc_sql[$mc_tablolar[8]]['dtarih'] = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";

$mc_tablolar[9] = "mesajlar";
$mc_sql[$mc_tablolar[9]]['baslik'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[9]]['aciklama'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[9]]['durum'] = "TINYINT(2) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[9]]['tip'] = "TINYINT(2) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[9]]['icerik'] = "TEXT NULL";
$mc_sql[$mc_tablolar[9]]['isim'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[9]]['gonderen'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[9]]['alici'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[9]]['ip'] = "VARCHAR(20) DEFAULT NULL";
$mc_sql[$mc_tablolar[9]]['tarih'] = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";

$mc_tablolar[10] = "bildirimler";
$mc_sql[$mc_tablolar[10]]['baslik'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[10]]['tarih'] = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";

$mc_tablolar[11] = "eklentiler";
$mc_sql[$mc_tablolar[11]]['baslik'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[11]]['durum'] = "TINYINT(2) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[11]]['tabload'] = "VARCHAR(64) DEFAULT NULL";
$mc_sql[$mc_tablolar[11]]['tabloid'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[11]]['icerik'] = "TEXT NULL";
$mc_sql[$mc_tablolar[11]]['eklenti'] = "TEXT NULL";
$mc_sql[$mc_tablolar[11]]['tip'] = "VARCHAR(64) DEFAULT NULL";
$mc_sql[$mc_tablolar[11]]['tarih'] = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";

$mc_tablolar[12] = "ekler";
$mc_sql[$mc_tablolar[12]]['baslik'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[12]]['aciklama'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[12]]['sef'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[12]]['icerik'] = "TEXT NULL";
$mc_sql[$mc_tablolar[12]]['tip'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[12]]['resim'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[12]]['sira'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[12]]['durum'] = "TINYINT(2) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[12]]['vurgula'] = "TINYINT(2) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[12]]['ekleyen'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[12]]['eklenti'] = "TEXT NULL";
$mc_sql[$mc_tablolar[12]]['tarih'] = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";
$mc_sql[$mc_tablolar[12]]['tarih1'] = "VARCHAR(16) DEFAULT NULL";
$mc_sql[$mc_tablolar[12]]['saat1'] = "VARCHAR(16) DEFAULT NULL";
$mc_sql[$mc_tablolar[12]]['tarih2'] = "VARCHAR(16) DEFAULT NULL";
$mc_sql[$mc_tablolar[12]]['saat2'] = "VARCHAR(16) DEFAULT NULL";

$mc_tablolar[13] = "klasorler";
$mc_sql[$mc_tablolar[13]]['baslik'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[13]]['tip'] = "TINYINT(2) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[13]]['ust'] = "INT(11) NULL DEFAULT 0";

$mc_tablolar[14] = "mapi";
$mc_sql[$mc_tablolar[14]]['baslik'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[14]]['tip'] = "TINYINT(2) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[14]]['durum'] = "TINYINT(2) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[14]]['kod'] = "VARCHAR(16) DEFAULT NULL";
$mc_sql[$mc_tablolar[14]]['anahtar'] = "VARCHAR(32) DEFAULT NULL";
$mc_sql[$mc_tablolar[14]]['dongu'] = "VARCHAR(32) DEFAULT NULL";
$mc_sql[$mc_tablolar[14]]['sayac'] = "SMALLINT(6) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[14]]['istemci'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[14]]['servis'] = "VARCHAR(255) DEFAULT NULL";
$mc_sql[$mc_tablolar[14]]['tarih'] = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";

$mc_tablolar[15] = "mesajlasma";
$mc_sql[$mc_tablolar[15]]['kullanici'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[15]]['oturum'] = "INT(11) NULL DEFAULT 0";
$mc_sql[$mc_tablolar[15]]['mesaj'] = "TEXT NULL";
$mc_sql[$mc_tablolar[15]]['tarih'] = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";

$yenisayac = 15;

$moduller = array_diff(scandir(m_moduller), array('..', '.'));
foreach ($moduller as $modul) {
    if (is_dir(m_moduller . $modul) && file_exists(m_moduller . $modul . "/sql.php")) {
        include m_moduller . $modul . "/sql.php";
        if (isset($mc_modulsql) && is_array($mc_modulsql)) {
            foreach ($mc_modulsql as $alt => $alt_sql) {
                if (is_array($alt_sql)) {
                    if (!isset($mc_sql[$alt])) {
                        $yenisayac++;
                        $mc_tablolar[$yenisayac] = $alt;
                        $mc_sql[$alt] = $alt_sql;
                    }
                }
            }
        }
    }
}
if (defined('mt_isim') && file_exists(m_temalar . mt_isim . DIRECTORY_SEPARATOR . "plugins" . DIRECTORY_SEPARATOR . "sql.php")) {
    include m_temalar . mt_isim . DIRECTORY_SEPARATOR . "plugins" . DIRECTORY_SEPARATOR . "sql.php";
    if (isset($mc_modulsql) && is_array($mc_modulsql)) {
        foreach ($mc_modulsql as $alt => $alt_sql) {
            if (is_array($alt_sql)) {
                if (!isset($mc_sql[$alt])) {
                    $yenisayac++;
                    $mc_tablolar[$yenisayac] = $alt;
                    $mc_sql[$alt] = $alt_sql;
                }
            }
        }
    }
}