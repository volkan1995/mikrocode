<?php

function m_resim($rs, $g = false, $h = 0, $zc = 1, $q = 70) {
    if (is_numeric($rs)) {
        if ($rs > 0) {
            global $m_vt;
            $s = $m_vt->select("`konum`")->from("dosyalar")->where('id', $rs)->where('tip', 1)->result();
            if (count($s)) {
                $k = m_domain . "/dosyalar" . $s[0]->konum;
            } else {
                return mc_img . "varsayilan.png?v=256";
            }
        } else {
            return mc_img . "varsayilan.png?v=256";
        }
    } else {
        if (strtolower(substr($rs, 0, 4)) == "http") {
            $k = $rs;
        } else {
            $k = m_domain . "/dosyalar" . $rs;
        }
    }
    if ($g == false) {
        return $k;
    } else {
        if ($h < 1) {
            $h = $g;
        }
        return mc_sistem . "dosyalar/resim.php?src=$k&w=$g&h=$h&zc=$zc&q=$q";
    }
}

function m_kisalt($kelime = "", $str = 10) {
    if (strlen(strip_tags($kelime)) > $str) {
        if (function_exists("mb_substr")) {
            $kelime = mb_substr($kelime, 0, $str - 5, "UTF-8") . '..';
        } else {
            $kelime = substr($kelime, 0, $str) . '..';
        }
    }
    return $kelime;
}

function m_getip() {
    if (getenv("HTTP_CLIENT_IP")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
        if (strstr($ip, ',')) {
            $tmp = explode(',', $ip);
            $ip = trim($tmp[0]);
        }
    } else {
        $ip = getenv("REMOTE_ADDR");
    }
    return $ip;
}

function m_dil($k = null) {
    return $k;
}
