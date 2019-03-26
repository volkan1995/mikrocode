<?php

function mt_kadi_kontrol($k = null) {
    $r = true;
    $t = null;
    $at = str_replace(['_'], '', $k);
    if (!ctype_alnum($at) || preg_match('/[^a-zA-Z0-9]/', $at)) {
        $t = m_dil('kadi_ozel_karakter_iceremez');
        $r = false;
    } elseif (is_numeric(substr($k, 0, 1))) {
        $t = m_dil('kadi_rakamla_baslayamaz');
        $r = false;
    } elseif (trim(strlen($k)) < 3) {
        $t = m_dil('kullanici_adi_enaz3');
        $r = false;
    }
    return [$r, $t];
}

function mt_mail_kontrol($m1 = null, $m2 = null) {
    $r = true;
    $t = null;
    if (!filter_var($m1, FILTER_VALIDATE_EMAIL)) {
        $t = m_dil('eposta_agd');
        $r = false;
    } else if (!empty($m2) && $m1 != $m2) {
        $t = m_dil('epostalar_uyusmuyor');
        $r = false;
    }
    return [$r, $t];
}

function mt_sifre_kontrol($s1 = null, $s2 = null) {
    $r = true;
    $t = null;
    if (preg_match("/\s/", $s1)) {
        $t = m_dil('sifre_bosluk_iceremez');
        $r = false;
    } else if (strlen($s1) < 5) {
        $t = m_dil('sifre_enaz5');
        $r = false;
    } else if (ctype_alnum($s1)) {
        $t = m_dil('sifre_enaz1_ozel');
        $r = false;
    } else if (!preg_match("/\S*((?=\S{6,})(?=\S*[A-Z_@ÜĞİŞÖÇ]))\S*/", $s1)) {
        $t = m_dil('sifre_enaz1_buyuk');
        $r = false;
    } else if (!empty($s2) && $s1 != $s2) {
        $t = m_dil('sifreler_uyusmuyor');
        $r = false;
    }
    if ($r) {
        $s1 = sha1(md5(trim($s1)));
    }
    return [$r, $t, $s1];
}

function mt_telefon($no = null, $ulke_kod = "90", $uzunluk = 10) {
    $no = preg_replace("/[^0-9]/", "", $no);
    $uku = strlen($ulke_kod);
    $first = substr($no, 0, 1);
    if ($first == "0") {
        $no = substr($no, 1);
    }
    if (substr($no, 0, $uku) != $ulke_kod) {
        $rtn = -2;
    } else {
        $numara = substr($no, $uku);
        if (substr($numara, 0, 1) == "0") {
            $numara = substr($numara, 1);
        }
        if (strlen($numara) != $uzunluk) {
            $rtn = -1;
        } else {
            $rtn = "+" . $ulke_kod . $numara;
        }
    }
    return $rtn;
}