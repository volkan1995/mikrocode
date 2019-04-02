<?php

function mc_dosya_adlandir($i = '') {
    $i = trim(strip_tags($i));
    $b = array("ç", "Ç", "ğ", "Ğ", "ı", "İ", "ö", "Ö", "ş", "Ş", "ü", "Ü", "-");
    $d = array("c", "c", "g", "g", "i", "i", "o", "o", "s", "s", "u", "u", "");
    $i = strtolower(str_replace($b, $d, $i));
    $i = str_replace(" ", ".", $i);
    $i = preg_replace('/[^a-zA-Z0-9\-\._]/', '', $i);
    return str_replace("..", ".", $i);
}

function mc_klasor_olustur($k = null) {
    if ($k == null) {
        return false;
    }
    $e = "";
    foreach (explode("/", $k) as $d) {
        $e = $e . $d . DIRECTORY_SEPARATOR;
        if (($d != ".." && $d != ".") && !file_exists($e)) {
            if (!mkdir($e)) {
                return false;
            }
        }
    }
    return true;
}

function mc_dosya_ismi($i = "", $a = false, $s = false) {
    $d = explode(".", $i);
    if (count($d) > 1) {
        $u = end($d);
        if ($a) {
            return $u;
        } else {
            if ($s) {
                $i = mc_dosya_adlandir($i);
            }
            return substr($i, 0, (strlen($i) - (strlen($u) + 1)));
        }
    } else {
        return null;
    }
}

function mc_dosya($t = "", $id = 0, $is = null, $ozellikler = array()) {
    if (!is_numeric($t)) {
        $td = array('dosya' => 0, 'gorsel' => 1, 'video' => 2, 'ses' => 3, 'arsiv' => 4, 'belge' => 5);
        if (isset($td[$t])) {
            $t = $td[$t];
        } else {
            $t = 0;
        }
    }
    if ($is == null) {
        $is = "d_" . $t;
    }
    if (!is_array($ozellikler)) {
        $ozellikler = array();
    }
    if (!isset($ozellikler['baslik'])) {
        $yd = array('dosya', 'gorsel', 'video', 'ses', 'arsiv', 'belge');
        if (!isset($yd[$t])) {
            $t = 0;
        }
        $ozellikler['baslik'] = mc_dil($yd[$t] . "_yukle_sec");
    }
    if (isset($ozellikler['style'])) {
        $style = $ozellikler['style'];
    } else {
        $style = null;
    }
    if ($id > 0) {
        $idb = true;
        $r = "<div id='mcds_$is' class='mc_ds' style='" . $style . "'>";
    } else {
        $idb = false;
        $r = "<div id='mcds_$is' class='mc_ds' style='" . $style . "'>";
    }
    $r .= "<div class='mc_dosyabtn btn btn-link btn-sm waves-effect' data-multi='0' data-isim='$is' data-type='$t'>" . $ozellikler['baslik'] . "</div>";
    $r .= "<div class='mcd_secililer' data-grup='$is'>";
    $r .= mc_dosya_al($id, $is);
    $r .= "</div></div>";
    return $r;
}

function mc_dosyalar($t = "", $id = 0, $is = null, $ozellikler = array()) {
    if (!is_numeric($t)) {
        $td = array('dosya' => 0, 'gorsel' => 1, 'video' => 2, 'ses' => 3, 'arsiv' => 4, 'belge' => 5);
        if (isset($td[$t])) {
            $t = $td[$t];
        } else {
            $t = 0;
        }
    }
    if ($is == null) {
        $is = "g_" . $t;
    }
    if (!is_array($ozellikler)) {
        $ozellikler = array();
    }
    if (!isset($ozellikler['baslik'])) {
        $yd = array('dosya', 'gorsel', 'video', 'ses', 'arsiv', 'belge');
        if (!isset($yd[$t])) {
            $t = 0;
        }
        $ozellikler['baslik'] = mc_dil($yd[$t] . "_yukle_sec");
    }
    if (!isset($ozellikler['detaylar'])) {
        $ozellikler['detaylar'] = false;
        $dty = 0;
    } else {
        $dty = 1;
    }
    if (!isset($ozellikler['btn'])) {
        $ozellikler['btn'] = "sm";
    }
    if (is_array($id) && count($id) > 0) {
        $idb = true;
        $r = "<div id='mcds_$is' class='mc_ds'>";
    } else {
        $idb = false;
        $r = "<div id='mcds_$is' class='mc_ds'>";
    }
    $r .= "<div class='mc_dosyabtn btn btn-link btn-" . $ozellikler['btn'] . " waves-effect' data-multi='1' data-isim='$is' data-type='$t' data-detay='{$dty}'>" . $ozellikler['baslik'] . "</div>";
    $r .= "<ul class='mcd_galeri_drag mcd_secililer'>";
    if ($idb) {
        $r .= mc_dosya_al($id, $is, $ozellikler['detaylar']);
    }
    $r .= "</ul></div>";
    return $r;
}

function mc_dosya_al($id = 0, $is = null, $dt = false) {
    if (is_array($id)) {
        global $m_vt;
        $dosya_bul = $m_vt->select()
                ->from("dosyalar")
                ->inwhere('id', $id)
                ->orderby('id', $id)
                ->result();
        $r = null;
        foreach ($dosya_bul as $sira => $dosya) {
            $r .= '<li class="mc_surukleb_item mcd_secili_' . $dosya->id . '">';
            $r .= '<div class="mcd_secili">';
            if ($dt != false && !empty($dt->{$dosya->id})) {
                $rand = rand(100,999);
                $dt_r = $dt->{$dosya->id};
                $r.='<div class="mcd_gd"><button class="btn btn-xs btn-default waves-effect" role="button" data-toggle="collapse" href="#mc_gdty' . $rand.$dosya->id . '" aria-expanded="false" aria-controls="mc_gdty' . $rand.$dosya->id . '">
                        <i class="material-icons">drag_handle</i></button><div class="collapse" id="mc_gdty' . $rand.$dosya->id . '" aria-expanded="false">
                        <div class="form-group">
                        <div class="form-line"><input type="text" class="form-control" style="margin-bottom:3px;" name="'.$dosya->id.'][b" placeholder="Başlık" value="' . (!empty($dt_r->b) ? $dt_r->b : null) . '"/></div>
                        <div class="form-line"><input type="text" class="form-control" style="margin-bottom:3px;" name="'.$dosya->id.'][a" placeholder="Açıklama" value="' . (!empty($dt_r->a) ? $dt_r->a : null) . '"/></div>
                        <div class="form-line"><input type="text" class="form-control" style="margin-bottom:3px;" name="'.$dosya->id.'][u" placeholder="Adres" value="' . (!empty($dt_r->u) ? $dt_r->u : null) . '"/></div>
                        <div class="form-line"><input type="text" class="form-control" name="'.$dosya->id.'][y" placeholder="Adres Yazısı" value="' . (!empty($dt_r->y) ? $dt_r->y : null) . '"/></div>
                        </div></div></div>';
            }
            $r.='<div class="mcd_baslik"><span title="' . $dosya->baslik . '">' . $dosya->baslik . '</span><i class="mcd_kapat material-icons">close</i></div>';
            if ($dosya->tip == 1) {
                $r .= '<div style="text-align: center"><img src="' . m_resim($dosya->konum, 215, 175, 2) . '" class="img-responsive"></div>';
            } elseif ($dosya->tip == 2) {
                $r .= '<video controls preload="metadata" poster="" class="m-t-5" style="width:100%;"><source src="' . m_domain . '/dosyalar' . $dosya->konum . '" type="video/mp4">Tarayıcı desteği yok</video>';
            } elseif ($dosya->tip == 3) {
                $r .= '<audio preload="metadata" src="' . m_domain . '/dosyalar' . $dosya->konum . '">Desteklenmiyor</audio>';
            }
            $r .= '<input type="hidden" class="mcd_values" name="' . $is . '][' . $dosya->id . '" value="' . $dosya->id . '"/></div></li>';
        }
        return $r;
    } elseif ($id > 0) {
        global $m_vt;
        $dosya_bul = $m_vt->select()
                ->from("dosyalar")
                ->where('id', $id)
                ->result();
        if (!count($dosya_bul)) {
            return null;
        }
        $dosya_bul = $dosya_bul[0];
        $r = '<div class="mcd_secili mcd_secili_' . $dosya_bul->id . '"><div class="mcd_baslik"><span title="' . $dosya_bul->baslik . '">' . $dosya_bul->baslik . '</span><i class="mcd_kapat material-icons">close</i></div>';
        if ($dosya_bul->tip == 1) {
            $r .= '<div style="text-align: center"><img src="' . m_resim($dosya_bul->konum, 250, 175, 2) . '" class="img-responsive"></div>';
        } elseif ($dosya_bul->tip == 2) {
            $r .= '<video controls preload="metadata" poster="" class="m-t-5" style="width:100%;"><source src="' . m_domain . '/dosyalar' . $dosya_bul->konum . '" type="video/mp4">Tarayıcı desteği yok</video>';
        } elseif ($dosya_bul->tip == 3) {
            $r .= '<audio preload="metadata" src="' . m_domain . '/dosyalar' . $dosya_bul->konum . '">Desteklenmiyor</audio>';
        }
        $r .= '<input type="hidden" class="mcd_values" name="' . $is . '" value="' . $dosya_bul->id . '"/></div>';
        return $r;
    } else {
        return '<input type="hidden" class="mcd_values" name="' . $is . '" value="0"/>';
    }
}

function mc_bityaz($b = 0) {
    $b = intval($b / 1000);
    $bd = array("Kbit/s", "Mbit", "Gbit", "Tbit");
    $bb = 1000;
    $s = "$b Kbit";
    foreach ($bd as $xb) {
        $s = round($b, 2) . " $xb";
        if ($b < $bb) {
            break;
        }
        $b /= $bb;
    }
    if ($s == "-1 KBit") {
        $s = "Ölçülemiyor";
    }
    return $s;
}

function mc_dosya_olustur($d = null, $i = null) {
    if (file_exists($d)) {
        return true;
    }
    if (empty($i)) {
        $i = '@header("location: /404");
        echo \'<script type="text/javascript"> window.top.location="/404"; </script>\';
        exit;';
    }
    $yd = fopen($d, "w");
    if (!$yd) {
        return false;
    }
    flock($yd, 2);
    fwrite($yd, $i);
    flock($yd, 3);
    fclose($yd);
    return true;
}
