<?php

if (!defined('m_guvenlik')) {
    exit;
}
if ($mc_oturum->grup > 1) {
    exit;
}
if (isset($_POST['tema_sayfa'])) {
    if(!isset($_POST['tema'])){
        $_POST['tema'] = m_tema;
    }else{
        $_POST['tema'] = m_temalar . $_POST['tema'] . DIRECTORY_SEPARATOR;
    }
    $_POST['tema_sayfa'] = $_POST['tema'] . str_replace(["/", DIRECTORY_SEPARATOR], DIRECTORY_SEPARATOR, base64_decode($_POST['tema_sayfa']));
    try {
        if (file_exists($_POST['tema_sayfa'])) {
            if (isset($_POST['kaydet']) && isset($_POST['icerik'])) {
                $dosya = fopen($_POST['tema_sayfa'], 'w');
                flock($dosya, 2);
                fwrite($dosya, $_POST['icerik']);
                flock($dosya, 3);
                $dfc = fclose($dosya);
                $d_adi = preg_replace('/\\.[^.\\s]{2,5}$/', '', basename($_POST['tema_sayfa']));
                if ($dfc) {
                    mc_uyari(1, "<b>" . mc_dil('basarili') . "!</b> $d_adi dosyasını düzenlediniz.");
                } else {
                    mc_uyari(2, "<b>" . mc_dil('basarisiz') . "!</b> $d_adi bilinmeyen bir hatadan dolayı düzenlenemedi.");
                }
                exit;
            }
            $t_oku = file($_POST['tema_sayfa']);
            foreach ($t_oku as $t_yaz) {
                echo $t_yaz;
            }
        }
    } catch (Exception $ex) {
        
    }
    exit;
}
if(!isset($_GET['tema'])){
    $_GET['tema_isim'] = mt_isim;
    $_GET['tema'] = m_tema;
}else{
    $_GET['tema_isim'] = $_GET['tema'];
    $_GET['tema'] = m_temalar . $_GET['tema'] . DIRECTORY_SEPARATOR;
}
if(!file_exists($_GET['tema'])){
    $_GET['tema_isim'] = mt_isim;
    $_GET['tema'] = m_tema;
}
function tema_sayfalar($temaicdizin = null, $ic_dizin = 0) {
    $rtn = null;
    $dosyalar = [ 'php' => [], 'css' => [], 'js' => [], 'html' => [], 'xml' => [], 'txt' => []];
    if (is_dir($_GET['tema'] . $temaicdizin)) {
        if ($tsd = opendir($_GET['tema'] . $temaicdizin)) {
            $optuzn = array_keys($dosyalar);
            while ($td = readdir($tsd)) {
                if ($td == "." || $td == "..") {
                    continue;
                }
                $icdir = rtrim($_GET['tema'] . $temaicdizin, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $td;
                if (is_dir($icdir)) {
                    if ($ic_dizin <= 2) {
                        if (!empty($temaicdizin)) {
                            $td = $temaicdizin . DIRECTORY_SEPARATOR . $td;
                        }
                        $alt_dosyalar = tema_sayfalar($td, $ic_dizin + 1);
                        foreach ($dosyalar as $key => $value) {
                            $dosyalar[$key] = array_merge($dosyalar[$key], $alt_dosyalar[$key]);
                        }
                    }
                } else {
                    $dosya_pi = pathinfo($icdir);
                    if (!isset($dosya_pi["extension"])) {
                        $dosya_pi["extension"] = null;
                    }
                    $dosya_pi["extension"] = strtolower($dosya_pi["extension"]);
                    foreach ($optuzn as $value) {
                        if ($dosya_pi["extension"] == $value) {
                            if (!empty($temaicdizin)) {
                                $td = $temaicdizin . DIRECTORY_SEPARATOR . $td;
                            }
                            $dosyalar[$value][] = str_replace(DIRECTORY_SEPARATOR, "/", $td);
                            continue;
                        }
                    }
                }
            }
        }
    }
    return $dosyalar;
}

$tema_sayfalar = null;

foreach (tema_sayfalar() as $key => $value) {
    if (is_array($value) && count($value)) {
        $tema_sayfalar = $tema_sayfalar . '<optgroup label="*' . strtoupper($key) . '">';
        foreach ($value as $val) {
            $tema_sayfalar = $tema_sayfalar . '<option data-ext="' . $key . '" value="' . base64_encode($val) . '">' . preg_replace('/\\.[^.\\s]{2,5}$/', '', $val) . '</option>';
        }
        $tema_sayfalar = $tema_sayfalar . "</optgroup>";
    }
}

if($mc_renk_tema == "dark"){
    $mc_editorSbln = "merbivore";
}else{
    $mc_editorSbln = "chrome";
}