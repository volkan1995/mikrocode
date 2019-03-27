<?php

function m_ay_ismi($ay = 0, $kisa = false) {
    $ay = intval($ay);
    if ($ay > 0 && $ay < 13) {
        $ay -= 1;
        if ($kisa) {
            $aylar = ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'];
        } else {
            $aylar = ['Oca', 'Şub', 'Mar', 'Nis', 'May', 'Haz', 'Tem', 'Ağu', 'Eyl', 'Eki', 'Kası', 'Ara'];
        }
        return $aylar[$ay];
    }
    return null;
}

function m_jsonAl($json = "", $al = "", $yaz = null) {
    if (!is_object($json) && !is_array($json)) {
        $json = json_decode($json);
    }
    if (is_object($json)) {
        if (isset($json->$al)) {
            return $json->$al;
        }
    } else if (is_array($json)) {
        if (isset($json[$al])) {
            return $json[$al];
        }
    }
    return $yaz;
}

function m_jsonDegistir($json = "", $bul = "", $yaz = null, $r_obj = 0) {
    $is_json = true;
    if (!is_object($json)) {
        $json = json_decode($json);
        $is_json = false;
    }
    @$json->{$bul} = $yaz;
    if ($r_obj === true) {
        return $json;
    } elseif ($r_obj === false) {
        return $json = json_encode($json);
    } elseif ($is_json) {
        return $json;
    } else {
        return $json = json_encode($json);
    }
}

function m_post_olustur($post, $keys = '', &$return = []) {
    if (($post instanceof CURLFile) or ! (is_array($post) or is_object($post))) {
        $return[$keys] = $post;
        return $return;
    } else {
        foreach ($post as $key => $item) {
            m_post_olustur($item, $keys ? $keys . "[$key]" : $key, $return);
        }
        return $return;
    }
}

function m_curl($url = null, $headers = array(), $get = array(), $post = false) {
    if (is_array($get) && count($get)) {
        $url = $url . "?" . http_build_query($get);
    }
    $headers_ = array();
    if(empty($headers['REFERER']) || empty($headers['referer'])){
        $headers["referer"] = $_SERVER['HTTP_HOST'];
    }
    foreach ($headers as $key => $value) {
        $headers_[] = strtoupper($key).':'. $value;
    }
    $ch = curl_init();
    if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != "on") {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    if($post != false){
        $post_fields = m_post_olustur($post);
        curl_setopt($ch, CURLOPT_POST, $post_fields);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    }else{
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, false);
    }
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; tr-TR; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $rt = curl_exec($ch);
    curl_close($ch);
    return $rt;
}

function m_file_get_contents($url = null, $get = array(), $post = array()) {
    if (count($get)) {
        $url = $url . "?" . http_build_query($get);
    }
    if (count($post)) {
        $op['http']['method'] = "POST";
        $op['http']['content'] = http_build_query($post);
    }
    $op['http']['header'] = "Content-type: application/x-www-form-urlencoded\r\n";
    $op['http']['header'].= "Referer: " . $_SERVER['HTTP_HOST'];
    return @file_get_contents($url, false, stream_context_create($op));
}

function m_ekyaz($ek = null, $v = 'icerik', $h = true) {
    $r = null;
    if ($ek != null) {
        global $m_vt;
        if (isset($m_vt)) {
            $al = $m_vt->select()->from("ekler")->where('sef', $ek)->result();
            if (count($al) == 1) {
                if ($v === true) {
                    return $al[0];
                } elseif (isset($al[0]->{$v})) {
                    $r = $al[0]->{$v};
                }
            }
        }
    }
    return $r;
}

function m_tirnak_temizle($v = null, $mod = 0) {
    if ($mod == 0) {
        return str_replace(['"', "'"], "", $v);
    } else if ($mod == 1) {
        return str_replace("'", "", $v);
    } else {
        return str_replace('"', "", $v);
    }
}

function m_tarih($f = null, $t = 'now') {
    $z = date("$f", strtotime($t));
    $d = array(
        'Monday' => 'Pazartesi',
        'Tuesday' => 'Salı',
        'Wednesday' => 'Çarşamba',
        'Thursday' => 'Perşembe',
        'Friday' => 'Cuma',
        'Saturday' => 'Cumartesi',
        'Sunday' => 'Pazar',
        'January' => 'Ocak',
        'February' => 'Şubat',
        'March' => 'Mart',
        'April' => 'Nisan',
        'May' => 'Mayıs',
        'June' => 'Haziran',
        'July' => 'Temmuz',
        'August' => 'Ağustos',
        'September' => 'Eylül',
        'October' => 'Ekim',
        'November' => 'Kasım',
        'December' => 'Aralık',
        'Mon' => 'Pts',
        'Tue' => 'Sal',
        'Wed' => 'Çar',
        'Thu' => 'Per',
        'Fri' => 'Cum',
        'Sat' => 'Cts',
        'Sun' => 'Paz',
        'Jan' => 'Oca',
        'Feb' => 'Şub',
        'Mar' => 'Mar',
        'Apr' => 'Nis',
        'Jun' => 'Haz',
        'Jul' => 'Tem',
        'Aug' => 'Ağu',
        'Sep' => 'Eyl',
        'Oct' => 'Eki',
        'Nov' => 'Kas',
        'Dec' => 'Ara',
    );
    foreach ($d as $en => $tr) {
        $z = str_replace($en, $tr, $z);
    }
    if (strpos($z, 'Mayıs') !== false && strpos($f, 'F') === false)
        $z = str_replace('Mayıs', 'May', $z);
    return $z;
}

function m_sayfano($l = 1, $c = 0, $otoget = true, $getSkip = null, $urls1 = null, $urls2 = null) {
    if (is_numeric($l) && $l > 0 && is_numeric($c)) {
        if ($c > $l) {
            $ss = ceil($c / $l);
        } else {
            $ss = 1;
        }
        if (isset($_GET['p']) && $_GET['p'] > 0) {
            $s = intval($_GET['p']);
        } else {
            $s = 0;
        }
        if ($s >= $ss) {
            $s = $ss - 1;
            m_git(m_otoGets("p", $ss));
        }
        if ($c > 0) {
            $ts = $ss;
            $f = 3;
            $is = $s - $f;
            $rs = $s + $f;
            $s += 1;
            $r = "<nav><ul class='pagination'>";
            if ($is < 1 || $is == 2) {
                $is = 1;
            }
            if ($rs >= $ts - 1) {
                $rs = $ts;
            }
            if ($s > $f + 2) {
                $r.="<li><a href='" . m_otoGets("p", 1, $getSkip) . "'>&nbsp;1 &laquo;&nbsp;</a></li>";
            }
            for ($i = $is; $i <= $rs; $i++) {
                if ($s == $i) {
                    $r.="<li class='active'><span>$i</span></li>";
                } else if (!$otoget) {
                    $r.="<li><a href='" . $urls1 . $i . $urls2 . "'>$i</a></li>";
                } else {
                    $r.="<li><a href='" . m_otoGets("p", $i, $getSkip) . "'>$i</a></li>";
                }
            }
            if (!$otoget == 2 && $rs < ($ts - $f + 2)) {
                $r.="<li><a href='" . $urls1 . $ts . $urls2 . "'>&nbsp;&raquo $ts&nbsp;</a></li>";
            } else if ($rs < ($ts - $f + 2)) {
                $r.="<li><a href='" . m_otoGets("p", $ts, $getSkip) . "'>&nbsp;&raquo $ts&nbsp;</a></li>";
            }
            return $r . "</ul></nav>";
        }
    }
}

function m_otoGets($getKey = null, $getVal = null, $getSkip = null) {
    if (!empty($getKey)) {
        if (count($_GET)) {
            $m_urlparcala = parse_url(m_url);
            if (empty($m_urlparcala['port'])) {
                $m_url = "//" . $m_urlparcala['host'] . $m_urlparcala['path'];
            } else {
                $m_url = "//" . $m_urlparcala['host'] . ':' . $m_urlparcala['port'] . $m_urlparcala['path'];
            }
            $urlReturn = null;
            $nonThisGet = true;
            if (!empty($getSkip)) {
                foreach (explode(",", $getSkip) as $value) {
                    if (isset($_GET[$value])) {
                        unset($_GET[$value]);
                    }
                }
            }
            foreach ($_GET as $key => $value) {
                if ($getKey == $key) {
                    $urlReturn = $urlReturn . "&" . $key . "=" . $getVal;
                    $nonThisGet = false;
                } else {
                    if (is_array($value)) {
                        foreach ($value as $key1 => $value1) {
                            $urlReturn = $urlReturn . "&" . $key . "%5B%5D=" . $value1;
                        }
                    } else {
                        $urlReturn = $urlReturn . "&" . $key . "=" . $value;
                    }
                }
            }
            if ($nonThisGet) {
                $urlReturn = $urlReturn . "&" . $getKey . "=" . $getVal;
            }
            $urlReturn = $m_url . "?" . ltrim($urlReturn, "&");
        } else {
            $urlReturn = m_url . "?" . $getKey . "=" . $getVal;
        }
    } else {
        $urlReturn = $_SERVER['REQUEST_URI'];
    }
    return $urlReturn;
}

function m_url_duzelt($txt = null) {
    $bul = array("I", "Ğ", "Ü", "Ş", "İ", "Ö", "Ç", "Q", "W", "E", "R", "T", "Y", "U", "O", "P", "A", "S", "D", "F", "G", "H", "J", "K", "L", "Z", "X", "C", "V", "B", "N", "M", "ı", "ğ", "ü", "ş", "ö", "ç", "â");
    $dgstr = array("i", "g", "u", "s", "i", "o", "c", "q", "w", "e", "r", "t", "y", "u", "o", "p", "a", "s", "d", "f", "g", "h", "j", "k", "l", "z", "x", "c", "v", "b", "n", "m", "i", "g", "u", "s", "o", "c", "a");
    $txt = str_replace($bul, $dgstr, $txt);
    $txt = mb_strtolower($txt, 'UTF-8');
    $txt = preg_replace('#[^-a-zA-Z0-9_ ]#', '', $txt);
    $txt = trim($txt);
    $txt2 = "";
    $txt = str_replace("-", " ", $txt);
    $kelime = explode(" ", $txt);
    foreach ($kelime as $deger) {
        if ($deger != "") {
            $txt2 .= $deger . " ";
        }
    }
    $txt = $txt2;
    $txt = trim($txt);
    $txt = str_replace(" ", "-", $txt);
    $txt = trim($txt);
    return $txt;
}

function m_between($val = 0, $min = 0, $max = 9) {
    if ($val < $min || $val > $max) {
        return false;
    }
    return true;
}
