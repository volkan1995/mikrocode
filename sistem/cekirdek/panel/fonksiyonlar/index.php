<?php

require mc_fonksiyonlar . 'dosya.php';

require mc_fonksiyonlar . 'form.php';

function mc_uyari($tur = 0, $mesaj = null, $bekle_ms = 0) {
    if (!is_numeric($tur) && is_array($mesaj) && count($mesaj) == 2) {
        if ($tur) {
            if (!array_key_exists(0, $mesaj) && array_key_exists(1, $mesaj)) {
                $tur = 1;
                $mesaj = $mesaj[1];
            } else if (array_key_exists(2, $mesaj)) {
                $tur = 2;
                $mesaj = $mesaj[2];
            } else {
                $tur = 1;
                $mesaj = $mesaj[0];
            }
        } else {
            if (array_key_exists(3, $mesaj)) {
                $tur = 3;
                $mesaj = $mesaj[3];
            } else if (array_key_exists(4, $mesaj)) {
                $tur = 4;
                $mesaj = $mesaj[4];
            } else {
                $tur = 3;
                $mesaj = end($mesaj);
            }
        }
    }
    if (!is_numeric($tur) || is_array($mesaj)) {
        $tur = 3;
        $mesaj = "<b>" . mc_dil('uyari_hata') . "</b> " . mc_dil('uyari_hata_p');
    } else {
        $mesaj = trim(str_replace(array("\\", "\x00", "\n", "\r", "'", '"', "\x1a"), array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z"), $mesaj));
    }
    if ($tur < 0) {
        $tur = abs($tur);
        $cikis = true;
    } else {
        $cikis = false;
    }
    if ($bekle_ms < 1) {
        $bekle_ms = strlen(strip_tags($mesaj)) * 100;
    }
    $tur_dizi = array("bg-black", "alert-success", "alert-info", "alert-warning", "alert-danger");
    if (!isset($tur_dizi[$tur])) {
        $tur = 0;
    }
    echo "<script>mc_hazir(function(){ showNotification('" . $tur_dizi[$tur] . "','" . $mesaj . "','" . $bekle_ms . "'); });</script>";
    if ($cikis) {
        exit;
    }
}

function mc_izin_hazirla($izin = "") {
    if (is_string($izin) && strlen($izin) > 0) {
        $rtn = null;
        for ($i = 0; $i < 4; $i++) {
            if (!isset($izin[$i])) {
                $rtn .= "0";
            } else {
                if ($izin[$i] != "1") {
                    $rtn .= "0";
                } else {
                    $rtn .= "1";
                }
            }
        }
    } else {
        $rtn = "0000";
    }
    return $rtn;
}

function mc_izin($izinler = "", $al = "") {
    if (strlen($izinler) == 4) {
        $al_dizi = array('g' => 0, 'e' => 1, 'd' => 2, 's' => 3);
        if (isset($al_dizi[$al])) {
            if ($izinler[$al_dizi[$al]] == 1) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    } else {
        return 0;
    }
}

function mc_yetki($d = null, $i = 0, $durdur = true, $uyari = true) {
    if ($i >= 0 && $i < 4) {
        global $m_vt;
        $s1 = $m_vt->select()->from("gruplar")->where('id', $GLOBALS['mc_oturum']->grup)->result();
        if (!count($s1)) {
            mc_uyari(-4, "<b>" . mc_dil('basarisiz') . "</b>" . mc_dil('yetkihata_4'));
        }
        $s1 = $s1[0];
        if ($s1->panel == 0) {
            if ($uyari) {
                mc_uyari(3, "<b>" . mc_dil('basarisiz') . "</b>" . mc_dil('yetkihata_3'));
            }
            if (strlen($d) < 2) {
                m_git(mc_panel . "cikis.php");
            }
        }
        if (strlen($s1->yetki) > 1 && strlen($d) > 1) {
            $izd = mc_izin_hazirla(m_jsonAl($s1->yetki, $d))[$i];
            if ($izd == 0) {
                global $mc_oturum;
                $izk = mc_izin_hazirla(m_jsonAl(m_jsonAl($mc_oturum->izinler, 'moduler'), $d))[$i];
                if ($izk == 0) {
                    if ($uyari) {
                        mc_uyari(3, "<b>" . mc_dil('basarisiz') . "</b>" . mc_dil('yetkihata_2'));
                    }
                    if ($durdur) {
                        exit;
                    } else {
                        return false;
                    }
                }
            }
        }
    }
    return true;
}

function mc_sef($i = null) {
    $tr = array("/Ğ/", "/Ü/", "/Ş/", "/İ/", "/Ö/", "/Ç/", "/ğ/", "/ü/", "/ş/", "/ı/", "/ö/", "/ç/");
    $en = array("G", "U", "S", "I", "O", "C", "g", "u", "s", "i", "o", "c");
    $i = preg_replace("/[^0-9a-zA-ZÄzçÇğĞıİöÖşŞüÜ]/", " ", $i);
    $i = preg_replace($tr, $en, $i);
    $i = preg_replace("/ +/", " ", $i);
    $i = preg_replace("/ /", ".", $i);
    $i = preg_replace("/\s/", "", $i);
    $i = preg_replace("/^-/", "", $i);
    $i = preg_replace("/-$/", "", $i);
    $i = str_replace("\\", "", $i);
    return strtolower($i);
}

function mc_ustmenu($m = null, $t = null, $al = false, $b = true) {
    $r = null;
    if (in_array($m, ['genel', 'ayarlar'])) {
        $al = true;
    }
    if ($b) {
        $r = $r . '<h2>' . $t . '</h2>';
    }
    $r .= '<ul class="header-dropdown m-r--5">' .
            '<li class="dropdown">' .
            '<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="material-icons">more_vert</i></a>' .
            '<ul class="dropdown-menu pull-right">';
    if ($al) {
        $menu = m_depo . "panel-menu.php";
    } else {
        $menu = m_moduller . $m . DIRECTORY_SEPARATOR . "menu.php";
    }
    if (!file_exists($menu)) {
        $menu = m_depo . "panel-menu.php";
    }
    if (file_exists($menu)) {
        if ($al) {
            $lnk = mc_sistem;
            $konum = str_replace("/sistem/", null, $_SERVER['SCRIPT_NAME']);
        } else {
            $lnk = mc_panel;
            $konum = str_replace("/yonetici/", null, $_SERVER['SCRIPT_NAME']);
        }
        include $menu;
        if (isset($mc_menuStr)) {
            $mc_menuler = json_decode($mc_menuStr, true);
        }
        if (isset($mc_menuler[$m]['tema']) && $mc_menuler[$m]['tema']) {
            $lnk = mc_panel . "modul.php?tema=";
            $konum = str_replace("/yonetici/", null, $_SERVER['SCRIPT_NAME']);
        }
        if (!m_gelistirici && isset($mc_menuler[$m]['gelistirici']) && $mc_menuler[$m]['gelistirici']) {
            $menu_yaz = false;
        } else {
            $menu_yaz = true;
        }
        if (isset($mc_menuler[$m]['gorev']) && $menu_yaz) {
            if ($GLOBALS['mc_oturum']->grup < 3 || !isset($mc_menuler[$m]['admin']) || !$mc_menuler[$m]['admin']) {
                foreach ($mc_menuler[$m]['gorev'] as $key => $value) {
                    if (isset($value['gorev']) && is_string($value['gorev'])) {
                        $value['gorev'] = rtrim($value['gorev'], "/");
                        if ((!m_gelistirici && isset($value['gelistirici']) && $value['gelistirici']) || $konum == $value['gorev'] || $konum == $value['gorev'] . "/index.php") {
                            continue;
                        }
                        if ($GLOBALS['mc_oturum']->grup > 2 && isset($value['admin']) && $value['admin']) {
                            continue;
                        }
                        $r = $r . "<li><a href='" . $lnk . $value['gorev'] . "' class='waves-effect waves-block'><i class='material-icons'>" . $value['ikon'] . "</i>" . mc_dil($value['baslik']) . "</a></li>";
                    }
                }
            }
        }
    }
    $r .= '<li><a href="javascript:void(0);" onclick="return m_yazdir(\'yazdir_alan\');" class=" waves-effect waves-block">' . mc_dil('sayfayi_yazdir') . '</a></li>' .
            '<li><a href="javascript:void(0);" class=" waves-effect waves-block">' . mc_dil('sayfayi_disa_aktar') . '</a></li>' .
            '</ul></li></ul>';
    return $r;
}

function mc_klasorolustur($yol = null) {
    $yol = explode(DIRECTORY_SEPARATOR, $yol);
    $ds = count($yol);
    $olustur = null;
    for ($x = 0; $x < $ds; $x++) {
        for ($i = 0; $i <= $x; $i++) {
            ($i !== 0) ? $olustur .= '/' . $yol[$i] : $olustur .= $yol[$i];
        }
        if (!is_dir($olustur)) {
            mkdir($olustur);
        }
        $olustur = '';
    }
    return 1;
}

function mc_klasorsil($dir) {
    $substr1 = substr($dir, strlen($dir) - 1, 1);
    if ($substr1 != '/' || $substr1 != DIRECTORY_SEPARATOR)
        $dir .= DIRECTORY_SEPARATOR;
    if ($handle = opendir($dir)) {
        while ($obj = readdir($handle)) {
            if ($obj != '.' && $obj != '..') {
                if (is_dir($dir . $obj)) {
                    if (!mc_klasorsil($dir . $obj))
                        return false;
                } elseif (is_file($dir . $obj)) {
                    if (!unlink($dir . $obj))
                        return false;
                }
            }
        }
        closedir($handle);
        if (!@rmdir($dir))
            return false;
        return true;
    }
    return false;
}

function mc_boyutyaz($b = 0, $k = true, $o = 2) {
    $bd = array("Byte", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
    $bb = 1024;
    $s = $b."Byte";
    $e = null;
    if($b < 0){ $e = "-"; }
    $b = abs($b);
    foreach ($bd as $xb) {
        $s = round($b, $o);
        if ($k) {
            $s.=$xb;
        }
        if ($b < $bb) {
            break;
        }
        $b/=$bb;
    }
    if ($s == "-1Byte") {
        $s = "Ölçülemiyor";
    }
    return $e.$s;
}