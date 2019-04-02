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
        include m_cekirdek . 'panel' . DIRECTORY_SEPARATOR . 'cikis.php';
    }

    $mc_oturum = $mc_oturum[0];
    
    $mc_grup = $m_vt->select()->from("gruplar")->where('id', $mc_oturum->grup)->where('panel', 1)->result();

    if (!count($mc_grup)) {
        m_git(mc_panel . "cikis.php");
    }

    $mc_grup = $mc_grup[0];
    
    if (!defined('mc_oturum_id')) {
        define('mc_oturum_id', $mc_oturum->id);
    }

    $mc_oturum->tema = json_decode($mc_oturum->tema, true);

    $mc_oturum->eklenti = json_decode($mc_oturum->eklenti, true);

    $mc_oturum_def = array(
        'renk' => "cyan",
        'mod' => "light",
        'dil' => "tr"
    );

    $mc_temarenkler = array(
        'red' => "Kırmızı",
        'pink' => "Pembe",
        'purple' => "Mor",
        'deep-purple' => "Koyu Mor",
        'indigo' => "Eflatun",
        'blue' => "Mavi",
        'light-blue' => "Açık Mavi",
        'cyan' => "Gökyüzü Mavisi",
        'teal' => "Su Yeşili",
        'green' => "Yeşil",
        'light-green' => "Açık Yeşil",
        'lime' => "Limon",
        'yellow' => "Sarı",
        'amber' => "Koyu Sarı",
        'orange' => "Turuncu",
        'deep-orange' => "Koyu Turuncu",
        'grey' => "Gri",
        'blue-grey' => "Mavi Gri",
        'brown' => "Kahverengi",
        'black' => "Siyah"
    );

    if (!empty($mc_oturum->ad) || !empty($mc_oturum->soyad)) {
        $mc_oturum->name = rtrim($mc_oturum->ad . " " . $mc_oturum->soyad);
    } else {
        $mc_oturum->name = $mc_oturum->kadi;
    }

    foreach ($mc_oturum_def as $key => $val) {
        if (!isset($mc_oturum->tema[$key])) {
            $mc_oturum->tema[$key] = $val;
        }
    }

    if (!isset($mc_temarenkler[$mc_oturum->tema['renk']])) {
        $mc_oturum->tema['renk'] = $mc_oturum_def['renk'];
    }

    if (isset($mc_diller[$mc_oturum->tema['dil']])) {
        $_SESSION['dil'] = $mc_oturum->tema['dil'];
        $_COOKIE["kullanici_dil"] = $mc_oturum->tema['dil'];
    } else {
        $mc_oturum->tema['dil'] = $mc_oturum_def['dil'];
    }

    if (!isset($mc_oturum->eklenti['muzikcalar'])) {
        $mc_oturum->eklenti['muzikcalar'] = 0;
    }

    $mc_oturum->tema = json_decode(json_encode($mc_oturum->tema));

    $mc_oturum->eklenti = json_decode(json_encode($mc_oturum->eklenti));

    $mc_oturum->izinler = json_decode($mc_oturum->izinler, true);
    
    $mc_renk_tema = $mc_oturum->tema->mod;
    
    if(is_numeric($mc_renk_tema)){ $mc_renk_tema = "light"; }
    
} else {
    if (!defined('m_girisyap')) {
        include m_cekirdek . 'panel' . DIRECTORY_SEPARATOR . 'cikis.php';
    }
}