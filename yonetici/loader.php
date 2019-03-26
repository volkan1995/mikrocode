<?php

function mc_microzaman() {
    $mcz = explode(" ", microtime());
    $mcz = doubleval($mcz[1]) + doubleval($mcz[0]);
    return $mcz;
}
$mc_microT1 = mc_microzaman();

if (!defined('m_baglanti')) {
    define("m_baglanti", true);
}

if (!defined('m_panel')) {
    define("m_panel", true);
}

if (!defined('m_guvenlik')) {
    define("m_guvenlik", true);
}

if (defined('m_sistem_header') && m_sistem_header == true) {
    if (!defined('m_panel_header')) {
        define("m_panel_header", true);
    }
} else if (defined('m_tema_header') && m_tema_header == true) {
    if (!defined('m_panel_header')) {
        define("m_panel_header", true);
    }
    if (empty($_GET['tema'])) {
        exit;
    }
    $_SERVER["PHP_SELF"] = $_GET['tema'];
}

require $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'index.php';

$mc_this_fn = pathinfo(parse_url($_SERVER["PHP_SELF"])['path']);
$get_include_path = get_include_path();

if (defined('m_sistem_header') && m_sistem_header == true) {
    $mc_this_ff = m_dizin . "sistem" . DIRECTORY_SEPARATOR . basename($mc_this_fn['dirname']) . DIRECTORY_SEPARATOR . "functions" . DIRECTORY_SEPARATOR . $mc_this_fn['filename'] . ".php";
} else if (defined('m_tema_header') && m_tema_header == true) {
    if (!isset($mc_this_fn['extension'])) {
        $mc_this_fn['dirname'] = $mc_this_fn['filename'];
        $mc_this_fn['basename'] = "index.php";
        $mc_this_fn['filename'] = "index";
        $mc_this_fn['extension'] = "php";
    }
    $mc_this_path_array = $mc_this_fn;
    $mc_this_path = m_tema . "plugins" . DIRECTORY_SEPARATOR . "yonetici" . DIRECTORY_SEPARATOR . basename($mc_this_fn['dirname']) . DIRECTORY_SEPARATOR;
    $mc_this_ff = $mc_this_path . "functions" . DIRECTORY_SEPARATOR . $mc_this_fn['filename'] . ".php";
    $mc_this_file = $mc_this_path . $mc_this_fn['filename'] . ".php";
    set_include_path($mc_this_path);
} else {
    $mc_this_ff = m_dizin . "yonetici" . DIRECTORY_SEPARATOR . basename($mc_this_fn['dirname']) . DIRECTORY_SEPARATOR . "functions" . DIRECTORY_SEPARATOR . $mc_this_fn['filename'] . ".php";
}

if (file_exists($mc_this_ff)) {
    include $mc_this_ff;
}

if ($get_include_path != get_include_path()) {
    set_include_path($get_include_path);
}

unset($mc_this_fn, $mc_this_ff);

if (!isset($mc_title)) {
    $mc_title = "Anasayfa";
}

$mc_headtitle = $mc_title;

$mc_title = htmlspecialchars(strip_tags($mc_title)) . " | Yönetim Paneli";

if (defined('m_panel_header') && m_panel_header && !isset($_POST['mc_js'])) {
    mc_yetki();
    $mc_muzikcalar = false;
    if (!isset($_POST['mc_js'])) {
        if (m_jsonAl($mc_oturum->eklenti, "muzikcalar") == 1) {
            include mc_yardimcilar . "muzikcalar" . DIRECTORY_SEPARATOR . "loader.php";
        }
    }
    $mc_mesajlar = $m_vt->select()->from('mesajlar')->where('durum', 0)->where('tip', 0)->limit(10)->orderby('id', "DESC")->result();
    $mc_mesajlar_count = count($mc_mesajlar);
    $mc_bildirimler = array();

    if ($mc_oturum->grup < 3) {
        if (m_gelistirici) {
            $mc_bildirimler[] = [
                'tip' => "danger",
                'baslik' => "Geliştirici Modu Açık!",
                'icerik' => "Lütfen ana dizindeki index.php dosyasının içinde bulunan 'm_gelistirici' değerini <u>0</u> yapınız."
            ];
        }
        if ($m_ayarlar->erisim != 1) {
            $mc_bildirimler[] = [
                'tip' => "danger",
                'baslik' => mc_dil('onemli') . "!",
                'icerik' => "Site yayını şuan kapalı durumda. Ziyaretçi kaybedebilirsiniz, siteyi yayına almanızı tavsiye ediyoruz.",
                'adres' => mc_sistem . "ayarlar/#gelismis_ayarlar"
            ];
        }
        if (!defined('mt_isim') || !mt_isim) {
            $mc_bildirimler[] = [
                'tip' => "danger",
                'baslik' => mc_dil('onemli') . "!",
                'icerik' => "Aktif temanız bulunmuyor ve ziyaretçiler siteyi bu şekilde görüyor.",
                'adres' => mc_sistem . "temalar",
                'resim' => mc_img . "temayok.png"
            ];
        }
        $mc_bildirimler[] = [
            'tip' => "warning",
            'baslik' => mc_dil('uyari') . "!",
            'icerik' => "Yeni güncelleme mevcut, şimdi güncellemek için tıklayınız!",
            'adres' => mc_sistem . "ayarlar/#guncellestirmeler_ve_bilgi"
        ];
        if ($mc_ps != 1) {
            $mc_bildirimler[] = [
                'tip' => "info",
                'baslik' => mc_dil('bilgi') . "!",
                'icerik' => "Dinamik sayfaları aktifleştirerek panelin daha hızlı çalışmasını sağlayabilirsiniz.",
                'adres' => mc_sistem . "ayarlar/#gelismis_ayarlar",
                'resim' => mc_img . "dinamik.gif"
            ];
        }
    }
    if ($mc_mesajlar_count) {
        $mc_bildirimler[] = [
            'tip' => "primary",
            'baslik' => mc_dil('hatirlatma') . "!",
            'icerik' => "Okunmamış {$mc_mesajlar_count} yeni mesaj mevcut.",
            'adres' => mc_sistem . "mesajlar"
        ];
    }

    $t_count = count($mc_bildirimler);
    $mc_menu = new mc_menu();
    require mc_sablon . 'header.php';
} else if (isset($_POST['mc_js'])) {
    mc_yetki();
    echo "<script>$('title').text(\"$mc_title\");</script>";
}