<?php

if (!defined('m_guvenlik')) {
    exit;
}
if (isset($_POST['name']) && (isset($_POST['pass']) || isset($_POST['password']))) {
    if (isset($_POST['password'])) {
        $_POST['pass'] = $_POST['password'];
    }
    $mc_oturum = $m_vt->sec(['table' => "kullanicilar", 'where' => ['kadi' => $_POST['name'], 'sifre' => sha1(md5($_POST['pass']))]]);
    if (count($mc_oturum) == 1) {
        $mc_oturum = $mc_oturum[0];
        $s1 = $m_vt->select()->from("gruplar")->where('id', $mc_oturum->grup)->result();
        if (!count($s1)) {
            echo 'Geçersiz kullanıcı grubuna dahilsiniz. Yöneticiniz ile iletisime geçiniz.';
            exit;
        }
        if ($s1[0]->site == 0) {
            echo 'Bu site için erişim yetkiniz bulunmamaktadır!';
            exit;
        }
        $_SESSION['kullanici']['id'] = $mc_oturum->id;
        $_SESSION['kullanici']['sifre'] = $mc_oturum->sifre;
        if (isset($_POST['hatirla']) && $_POST['hatirla'] == "on") {
            setcookie("kullanici_id", $mc_oturum->id, time() + (3600 * 24 * 7));
            setcookie("kullanici_sifre", $mc_oturum->sifre, time() + (3600 * 24 * 7));
            if (isset($_SESSION['dil'])) {
                setcookie("kullanici_dil", $_SESSION['dil'], time() + (3600 * 24 * 7));
            }
        }
        if (isset($_POST['referer'])) {
            $mc_json64_git = $_POST['referer'];
        } else {
            if (isset($_GET['get'])) {
                $mc_json64_git = base64_decode($_GET['get']);
            } else {
                if (isset($_SERVER["HTTP_REFERER"])) {
                    $mc_json64_git = $_SERVER["HTTP_REFERER"];
                } else {
                    $mc_json64_git = "/";
                }
            }
        }
        if ($mc_json64_git == m_url) {
            $mc_json64_git = "/";
        }
        echo "Giriş başarılı, bekleyiniz...";
        echo "<script>setTimeout(function(){ window.location.href = \"{$mc_json64_git}\"; }, 1000);</script>";
    } else {
        echo 'Giriş bilgileri hatalı!';
    }
    exit;
} else if (defined('mc_oturum_id')) {
    if (isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] != m_url) {
        m_git($_SERVER["HTTP_REFERER"]);
    } else {
        m_git("/");
    }
    exit;
}