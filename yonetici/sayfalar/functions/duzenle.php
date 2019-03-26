<?php

if (!defined('m_guvenlik')) {
    exit;
}

require 'ayar.php';

if (isset($_POST['kaydet'])) {

    mc_yetki($mc_modul_ayar['yetki'], 2);
    $dil_grup = 0;
    foreach ($_POST['id'] as $dil => $id) {
        $id = intval(@$id);
        if ($id != 0) {
            $varlik_sor = $m_vt->select()->from($mc_modul_ayar['tablo'])->where("id", $id)->result();
            if (count($varlik_sor) == 0) {
                mc_uyari(-3, "<b>" . mc_dil('basarisiz') . "</b>Sayfa kaydı bulunamadı $dil : " . $_POST['baslik'][$dil]);
            }
            if ($dil_grup == 0) {
                if ($varlik_sor[0]->grup == 0) {
                    $dil_grup = $varlik_sor[0]->id;
                } else {
                    $dil_grup = $varlik_sor[0]->grup;
                }
            }
        }

        if (empty($_POST['baslik'][$dil])) {
            mc_uyari(-3, "<b>" . mc_dil('basarisiz') . "</b>" . mc_dil('bos_alanlar_var'));
        }

        if (empty($_POST['sef'][$dil])) {
            $_POST['sef'][$dil] = $_POST['baslik'][$dil];
        }
        $_POST['sef'][$dil] = mc_sefurl($_POST['baslik'][$dil]);

        if (!isset($_POST['sayfa'][$dil])) {
            $_POST['sayfa'][$dil] = 0;
        } else {
            $_POST['sayfa'][$dil] = intval($_POST['sayfa'][$dil]);
        }

        if ($id == 0) {
            if ($m_vt->select()->from($mc_modul_ayar['tablo'])->where("sef", $_POST['sef'][$dil])->count() > 0) {
                mc_uyari(-3, "<b>" . mc_dil('basarisiz') . "</b>Zaten benzer bir sayfa kaydı mevcut " . $_POST['baslik'][$dil]);
            }
        } else {
            if ($m_vt->select()->from($mc_modul_ayar['tablo'])->where("sef", $_POST['sef'][$dil])->where("id", $_POST['id'][$dil], "<>")->count() > 0) {
                mc_uyari(-3, "<b>" . mc_dil('basarisiz') . "</b>Zaten benzer bir sayfa kaydı mevcut" . $_POST['baslik'][$dil]);
            }
        }
        
        if (empty($_POST['kategori'][$dil])) {
            $_POST['kategori'][$dil] = "yazi";
        }

        if (!in_array($_POST['kategori'][$dil], ["yazi", "yonlendir", "kategoriler", "icerikler", "sayfalar"])) {
            $_POST['kategori'][$dil] = "yazi";
        }
    
        if (!isset($_POST['m_editor_' . $dil])) {
            $_POST['m_editor_' . $dil] = null;
        }

        if (!isset($_POST['kapak_' . $dil])) {
            $_POST['kapak_' . $dil] = 0;
        } else {
            $_POST['kapak_' . $dil] = intval($_POST['kapak_' . $dil]);
        }

        if (!isset($_POST['yayin'][$dil])) {
            $_POST['yayin'][$dil] = 0;
        } else {
            $_POST['yayin'][$dil] = intval($_POST['yayin'][$dil]);
        }

        if (!isset($_POST['menu'][$dil])) {
            $_POST['menu'][$dil] = 0;
        } else {
            $_POST['menu'][$dil] = intval($_POST['menu'][$dil]);
        }
        
        if ($_POST['kategori'][$dil] != "yazi") {
            if (!isset($_POST['parametre'][$dil])) {
                $_POST['parametre'][$dil] = null;
            }
            $_POST['m_editor_' . $dil] = $_POST['parametre'][$dil];
        }
        
        $mc_json[$dil] = array();

        if (isset($_POST['galeri_' . $dil]) && !empty($_POST['galeri_' . $dil])) {
            $mc_json[$dil]['galeri'] = $_POST['galeri_' . $dil];
        }
        if (!empty($_POST['video_' . $dil])) {
            $mc_json[$dil]['video'] = $_POST['video_' . $dil];
        }
        if (isset($_POST[$dil . '_ek']) && !empty($_POST[$dil . '_ek'])) {
            $mc_json[$dil]['ek'] = $_POST[$dil . '_ek'];
        }
        if (isset($_POST[$dil . '_ek_b'])) {
            $mc_json[$dil]['ek_b'] = $_POST[$dil . '_ek_b'];
        }
        if (isset($_POST[$dil . '_ek_a'])) {
            $mc_json[$dil]['ek_a'] = $_POST[$dil . '_ek_a'];
        }
        if (isset($_POST[$dil . '_ek_u'])) {
            $mc_json[$dil]['ek_u'] = $_POST[$dil . '_ek_u'];
        }
        if (isset($_POST[$dil . '_ek_y'])) {
            $mc_json[$dil]['ek_y'] = $_POST[$dil . '_ek_y'];
        }        
        if ($_POST['kategori'][$dil] == "yonlendir" && isset($_POST['sekme'][$dil])) {
            $mc_json[$dil]['sekme'] = $_POST['sekme'][$dil];
        }
    
        $mc_json[$dil] = json_encode($mc_json[$dil]);

        if ($id == 0) {
            $mc_kaydet = $m_vt->ekle([
                        'table' => $mc_modul_ayar['tablo'],
                        'values' => [
                            'baslik' => $_POST['baslik'][$dil],
                            'sef' => $_POST['sef'][$dil],
                            'icerik' => $_POST['m_editor_' . $dil],
                            'tip' => $_POST['kategori'][$dil],
                            'ust' => $_POST['sayfa'][$dil],
                            'durum' => $_POST['yayin'][$dil],
                            'menu' => $_POST['menu'][$dil],
                            'ekleyen' => mc_oturum_id,
                            'resim' => $_POST['kapak_' . $dil],
                            'eklenti' => $mc_json[$dil],
                            'grup' => $dil_grup,
                            'dil' => $dil
                        ]
                    ])['sonuc'];
        } else {
            $mc_kaydet = $m_vt->guncelle([
                        'table' => $mc_modul_ayar['tablo'],
                        'values' => [
                            'baslik' => $_POST['baslik'][$dil],
                            'sef' => $_POST['sef'][$dil],
                            'icerik' => $_POST['m_editor_' . $dil],
                            'tip' => $_POST['kategori'][$dil],
                            'ust' => $_POST['sayfa'][$dil],
                            'durum' => $_POST['yayin'][$dil],
                            'menu' => $_POST['menu'][$dil],
                            'duzenleyen' => mc_oturum_id,
                            'resim' => $_POST['kapak_' . $dil],
                            'eklenti' => $mc_json[$dil],
                            'grup' => $dil_grup,
                            'dil' => $dil
                        ],
                        'where' => ['id' => $id]
                    ])['sonuc'];
        }
        if (!$mc_kaydet) {
            break;
        }
    }

    if ($mc_kaydet) {
        mc_uyari(-1, "<b>" . mc_dil('basarili') . "</b>Sayfa düzenlendi");
    } else {
        mc_uyari(-4, "<b>" . mc_dil('basarili') . "</b>Sayfa bilinmeyen bir hatadan dolayı düzenlenemedi.");
    }
}

if (!isset($_GET['id'])) {
    exit;
}

$get_sayfa = $m_vt->select()->from($mc_modul_ayar['tablo'])->where("id", $_GET['id'])->result();
if (!count($get_sayfa)) {
    exit;
}
$mc_title = mc_dil('duzenle') . ": " . $get_sayfa[0]->baslik;

$get_sayfalar = array();
if ($get_sayfa[0]->grup == 0) {
    $sorgu_sayfalar = $m_vt->select()->from($mc_modul_ayar['tablo'])->where("id", $get_sayfa[0]->id)->result();
} else {
    $sorgu_sayfalar = $m_vt->select()->from($mc_modul_ayar['tablo'])->where("grup", $get_sayfa[0]->grup)->orderby('id', "ASC")->result();
}
foreach ($sorgu_sayfalar as $sorgu_sayfa) {
    if (isset($get_sayfalar[$sorgu_sayfa->dil])) {
        continue;
    }
    if (empty($sorgu_sayfa->dil)) {
        $sorgu_sayfa->dil = "tr";
    }
    $get_sayfalar[$sorgu_sayfa->dil] = $sorgu_sayfa;
}

if (!isset($_GET['id'])) {
    exit;
}
