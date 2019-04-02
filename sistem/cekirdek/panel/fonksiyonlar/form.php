<?php
function mc_kategoriler($a = array(), $f = false) {
    global $m_vt;
    $by = null;
    if (!isset($a['tablo'])) {
        $a['tablo'] = "kategoriler";
    }
    if (!isset($a['sec'])) {
        $a['sec'] = 0;
    }
    if (!isset($a['syc'])) {
        $a['syc'] = 0;
    }
    if (!isset($a['aciklama']) || $a['aciklama'] == false) {
        $a['aciklama'] = false;
    }
    if (!isset($a['baslik'])) {
        $a['baslik'] = "grup_seciniz";
    }
    if (!isset($a['ust'])) {
        $a['ust'] = 0;
    } else {
        $a['ust'] = intval($a['ust']);
    }
    if (isset($a['katman']) && $a['katman'] > 0) {
        if ($a['syc'] >= $a['katman']) {
            return null;
        }
    } else {
        $a['katman'] = 0;
    }
    if ($a['ust'] == 0) {
        $r = '<option value="0">' . mc_dil($a['baslik']) . '</option>';
        if ($f) {
            $r .= '<option value="-1">' . mc_dil('tumu') . '</option>';
        }
    } else {
        $r = null;
    }
    $k = $m_vt->select()->from($a['tablo']);
    if (!isset($a['ust_yok'])) {
        $k->where('ust', $a['ust']);
    }
    if (isset($a['tip'])) {
        $k->where('tip', $a['tip']);
    }
    if (isset($a['dil'])) {
        $k->where('dil', $a['dil']);
    }
    if (isset($a['grup'])) {
        $k->where('grup', $a['grup']);
    }
    for ($i = 0; $i < $a['syc']; $i++) {
        $by .= "&nbsp; &nbsp; &nbsp;";
    }
    foreach ($k->result() as $v) {
        $aciklama = null;
        if ($a['aciklama'] != false) {
            if (isset($v->{$a['aciklama']})) {
                $aciklama = " (" . $v->{$a['aciklama']} . ")";
            }
        }
        if ($a['sec'] != $v->id) {
            $r .= '<option value="' . $v->id . '">' . $by . $v->baslik . $aciklama . '</option>';
        } else {
            $r .= '<option value="' . $v->id . '" selected>' . $by . $v->baslik . $aciklama . '</option>';
        }
        if (!isset($a['ust_yok'])) {
            $r .= mc_kategoriler(['tablo' => $a['tablo'], 'ust' => $v->id, 'sec' => $a['sec'], 'katman' => $a['katman'], 'syc' => ($a['syc'] + 1)]);
        }
    }
    return $r;
}

function mc_editor($t = "", $id = null) {
    if (empty($id)) {
        $id = "m_editor" . rand(0, 9999999);
    }
    if (!empty($t)) {
        $t = m_html_chars($t);
        $t = str_replace("'", "&#39;", $t);
    }
    if (!empty($t)) {
        $t = str_replace("%22", '"', $t);
    }
    $t = preg_replace("/\r?\n/", "\\n", addslashes($t));
    if (isset($GLOBALS['mc_renk_tema']) && $GLOBALS['mc_renk_tema'] == "dark") {
        $tm1 = "dark";
        $tm2 = ",theme: 'dark'";
    } else {
        $tm1 = "style";
        $tm2 = null;
    }
    if(empty($GLOBALS['editor_syc'])){
       $GLOBALS['editor_syc'] = 1;
        return "<div class='m_editor' name='icerik' id='" . $id . "'></div>" .
            "<script>var mc_tum_editorler = []; mc_hazir(function(){ " .
            "mc_loadCss('" . mc_plugins . "editor/css/editor.min.css');" .
            "mc_loadCss('" . mc_plugins . "editor/css/" . $tm1 . ".min.css?v=1');" .
            "mc_loadCss('" . mc_plugins . "editor/css/plugs.min.css');" .
            "mc_loadCss('" . mc_plugins . "font-awesome/css/font-awesome.min.css?v=2');" .
            "mc_loadJs('" . mc_plugins . "editor/js/editor.min.js?v=1').done(function(){" .
            "mc_loadJs('" . mc_plugins . "editor/js/plugs.min.js').done(function(){" .
            "mc_loadJs('" . mc_plugins . "editor/js/languages/tr.js').done(function(){" .
            "$('#" . $id . "').froalaEditor({toolbarSticky: false,language: 'tr',fileUpload: false" . $tm2 . "});" .
            "$('#" . $id . "').froalaEditor('html.set','$t', false); $.each( mc_tum_editorler, function( key, value ) { if(typeof value === 'function'){ value(); } }); " .
            "});" .
            "});" .
            "});" .
            "});</script>";
    }else{
        $GLOBALS['editor_syc'] += 1;
        return "<div class='m_editor' name='icerik' id='" . $id . "'></div>" .
            "<script>mc_hazir(function(){  function mc_editor_function_{$id}(){" .
            "$('#" . $id . "').froalaEditor({toolbarSticky: false,language: 'tr',fileUpload: false" . $tm2 . "});" .
            "$('#" . $id . "').froalaEditor('html.set','$t', false);" .
            "} mc_tum_editorler.push(mc_editor_function_{$id}); });</script>";
    }    
}

function mc_kadi_kontrol($k = null) {
    $r = true;
    $t = null;
    $at = str_replace(['_'], '', $k);
    if (!ctype_alnum($at) || preg_match('/[^a-zA-Z0-9]/', $at)) {
        $t = mc_dil('kadi_ozel_karakter_iceremez');
        $r = false;
    } elseif (is_numeric(substr($k, 0, 1))) {
        $t = mc_dil('kadi_rakamla_baslayamaz');
        $r = false;
    } elseif (trim(strlen($k)) < 3) {
        $t = mc_dil('kullanici_adi_enaz3');
        $r = false;
    }
    return [$r, $t];
}

function mc_mail_kontrol($m1 = null, $m2 = null) {
    $r = true;
    $t = null;
    if (!filter_var($m1, FILTER_VALIDATE_EMAIL)) {
        $t = mc_dil('eposta_agd');
        $r = false;
    } else if (!empty($m2) && $m1 != $m2) {
        $t = mc_dil('epostalar_uyusmuyor');
        $r = false;
    }
    return [$r, $t];
}

function mc_sifre_kontrol($s1 = null, $s2 = null) {
    $r = true;
    $t = null;
    if (preg_match("/\s/", $s1)) {
        $t = mc_dil('sifre_bosluk_iceremez');
        $r = false;
    } else if (strlen($s1) < 5) {
        $t = mc_dil('sifre_enaz5');
        $r = false;
    } else if (ctype_alnum($s1)) {
        $t = mc_dil('sifre_enaz1_ozel');
        $r = false;
    } else if (!preg_match("/\S*((?=\S{6,})(?=\S*[A-Z_@ÜĞİŞÖÇ]))\S*/", $s1)) {
        $t = mc_dil('sifre_enaz1_buyuk');
        $r = false;
    } else if (!empty($s2) && $s1 != $s2) {
        $t = mc_dil('sifreler_uyusmuyor');
        $r = false;
    }
    if ($r) {
        $s1 = sha1(md5(trim($s1)));
    }
    return [$r, $t, $s1];
}

function mc_sefurl($m = null) {
    $e = array("I", "Ğ", "Ü", "Ş", "İ", "Ö", "Ç", "Q", "W", "E", "R", "T", "Y", "U", "O", "P", "A", "S", "D", "F", "G", "H", "J", "K", "L", "Z", "X", "C", "V", "B", "N", "M", "ı", "ğ", "ü", "ş", "ö", "ç", "â");
    $y = array("i", "g", "u", "s", "i", "o", "c", "q", "w", "e", "r", "t", "y", "u", "o", "p", "a", "s", "d", "f", "g", "h", "j", "k", "l", "z", "x", "c", "v", "b", "n", "m", "i", "g", "u", "s", "o", "c", "a");
    $m = str_replace($e, $y, $m);
    $m = mb_strtolower($m, 'UTF-8');
    $m = preg_replace('#[^-a-zA-Z0-9_ ]#', '', $m);
    $m = trim($m);
    $m2 = "";
    $m = str_replace("-", " ", $m);
    $k = explode(" ", $m);
    foreach ($k as $v) {
        if ($v != "") {
            $m2 .= $v . " ";
        }
    }
    $m = $m2;
    $m = trim($m);
    $m = str_replace(" ", "-", $m);
    $m = trim($m);
    return $m;
}

function mc_ic_izin($izinler = null) {
    global $mc_oturum;
    if ($mc_oturum->grup < 3) {
        echo '<div class="panel-group" id="mc_ic_izin" role="tablist" aria-multiselectable="true">';
        global $m_vt;
        foreach ($m_vt->select('`id`,`baslik`')->from("gruplar")->where('id', 2, ">")->where('panel', 1)->result() as $g) {
            $i_d = mc_izin_hazirla(m_jsonAl($izinler, $g->id));
            ?>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="gih_<?= $g->id ?>">
                    <h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#mc_ic_izin" href="#gia_<?= $g->id ?>" aria-expanded="false" aria-controls="gia_<?= $g->id ?>" class="collapsed"><?= mc_dil($g->baslik) ?></a></h4>
                </div>
                <div id="gia_<?= $g->id ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="gih_<?= $g->id ?>" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body">
                        <div class="demo-checkbox">                        
                            <input type="checkbox" id="g<?= $g->id ?>_i0" name="g[<?= $g->id ?>][0]" class="chk-col-theme"<?= $i_d[0] == 1 ? " checked" : null ?>/><label for="g<?= $g->id ?>_i0"><?= mc_dil('goruntule') ?></label>
                            <input type="checkbox" id="g<?= $g->id ?>_i1" name="g[<?= $g->id ?>][1]" class="chk-col-theme"<?= $i_d[1] == 1 ? " checked" : null ?>/><label for="g<?= $g->id ?>_i1"><?= mc_dil('duzenle') ?></label>
                            <input type="checkbox" id="g<?= $g->id ?>_i2" name="g[<?= $g->id ?>][2]" class="chk-col-theme"<?= $i_d[2] == 1 ? " checked" : null ?>/><label for="g<?= $g->id ?>_i2"><?= mc_dil('sil') ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        echo '</div>';
    }
}

function mc_ic_yetki($izinler = null, $i = 0, $durdur = false, $uyari = true, $grup = 0, $yetki = true) {
    if ($grup <= 0) {
        global $mc_oturum;
        $grup = $mc_oturum->grup;
    }
    $i_al = m_jsonAl($izinler, $grup);
    if ($i_al == null) {
        if ($yetki) {
            return true;
        } else {
            return false;
        }
    }
    $s = mc_izin_hazirla($i_al)[$i];
    if ($s == 0) {
        if ($uyari) {
            mc_uyari(3, "<b>" . mc_dil('basarisiz') . "</b>" . mc_dil('yetkihata_2'));
        }
        if ($durdur) {
            exit;
        }
        return false;
    }
    return true;
}

function mc_ozel_yetki($izinler = array(), $durdur = true, $uyari = true) {
    if (is_array($izinler)) {
        global $mc_oturum;
        if ($mc_oturum->grup < 3) {
            return true;
        }
        $rtn = false;
        if (!is_array($mc_oturum->izinler)) {
            $mc_oturum->izinler = json_decode($mc_oturum->izinler, true);
        }
        foreach ($izinler as $tablo => $id) {
            if (isset($mc_oturum->izinler[$tablo]) && in_array($id, $mc_oturum->izinler[$tablo])) {
                $rtn = true;
                break;
            }
        }
        if (!$rtn) {
            if ($uyari) {
                mc_uyari(3, "<b>" . mc_dil('basarisiz') . "</b>" . mc_dil('yetkihata_2'));
            }
            if ($durdur) {
                exit;
            }
        } else {
            return true;
        }
    } else {
        return true;
    }
}
