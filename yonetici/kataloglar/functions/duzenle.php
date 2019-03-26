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
                mc_uyari(-3, "<b>" . mc_dil('basarisiz') . "</b>İçerik kaydı bulunamadı $dil : " . $_POST['baslik'][$dil]);
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

        if (!isset($_POST['kategori'][$dil])) {
            $_POST['kategori'][$dil] = 0;
        } else {
            $_POST['kategori'][$dil] = intval($_POST['kategori'][$dil]);
        }

        if ($id == 0) {
            if (count($m_vt->select()->from($mc_modul_ayar['tablo'])
                                    ->where("sef", $_POST['sef'][$dil])->where($mc_modul_ayar['ust'], $_POST['kategori'][$dil])->where("tip", $mc_modul_ayar['tip'])
                                    ->result()) > 0) {
                mc_uyari(-3, "<b>" . mc_dil('basarisiz') . "</b>Zaten benzer bir içerik kaydı mevcut. $dil : " . $_POST['baslik'][$dil]);
            }
        } else {
            if (count($m_vt->select()->from($mc_modul_ayar['tablo'])
                                    ->in()->where("sef", $_POST['sef'][$dil])->where($mc_modul_ayar['ust'], $_POST['kategori'][$dil])->where("tip", $mc_modul_ayar['tip'])
                                    ->out()->where("id", $id, "<>")
                                    ->result()) > 0) {
                mc_uyari(-3, "<b>" . mc_dil('basarisiz') . "</b>Zaten benzer bir içerik kaydı mevcut. $dil : " . $_POST['baslik'][$dil]);
            }
        }

        if (!isset($_POST['m_editor_' . $dil])) {
            $_POST['m_editor_' . $dil] = null;
        }

        if (!isset($_POST['aciklama'][$dil])) {
            $_POST['aciklama'][$dil] = null;
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

        if (!isset($_POST['vurgula'][$dil])) {
            $_POST['vurgula'][$dil] = 0;
        } else {
            $_POST['vurgula'][$dil] = intval($_POST['vurgula'][$dil]);
        }

        $mc_json[$dil] = array();

        if (isset($_POST['galeri_' . $dil]) && !empty($_POST['galeri_' . $dil])) {
            $mc_json[$dil]['galeri'] = $_POST['galeri_' . $dil];
        }

        if (!empty($_POST['video_' . $dil])) {
            $mc_json[$dil]['video'] = $_POST['video_' . $dil];
        }
        
        if (!empty($_POST['ek_' . $dil])) {
            $mc_json[$dil]['ek'] = $_POST['ek_' . $dil];
        }
        
        $mc_json[$dil] = json_encode($mc_json[$dil]);

        if ($id == 0) {
            $mc_kaydet = $m_vt->ekle([
                        'table' => $mc_modul_ayar['tablo'],
                        'values' => [
                            'baslik' => $_POST['baslik'][$dil],
                            'sef' => $_POST['sef'][$dil],
                            'aciklama' => $_POST['aciklama'][$dil],
                            'icerik' => $_POST['m_editor_' . $dil],
                            'tip' => $mc_modul_ayar['tip'],
                            $mc_modul_ayar['ust'] => $_POST['kategori'][$dil],
                            'durum' => $_POST['yayin'][$dil],
                            'vurgula' => $_POST['vurgula'][$dil],
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
                            'aciklama' => $_POST['aciklama'][$dil],
                            'icerik' => $_POST['m_editor_' . $dil],
                            'tip' => $mc_modul_ayar['tip'],
                            $mc_modul_ayar['ust'] => $_POST['kategori'][$dil],
                            'durum' => $_POST['yayin'][$dil],
                            'vurgula' => $_POST['vurgula'][$dil],
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
        mc_uyari(-1, "<b>" . mc_dil('basarili') . "</b>Kategori düzenlendi");
    } else {
        mc_uyari(-4, "<b>" . mc_dil('basarili') . "</b>Kategori bilinmeyen bir hatadan dolayı düzenlenemedi.");
    }
}

if (!isset($_GET['id'])) {
    exit;
}

$get_yazi = $m_vt->select()->from($mc_modul_ayar['tablo'])->where("id", $_GET['id'])->result();
if (!count($get_yazi)) {
    exit;
}
$mc_title = mc_dil('duzenle') . ": " . $get_yazi[0]->baslik;

$get_yazilar = array();

if ($get_yazi[0]->grup == 0) {
    $sorgu_yazilar = $m_vt->select()->from($mc_modul_ayar['tablo'])->where("id", $get_yazi[0]->id)->result();
} else {
    $sorgu_yazilar = $m_vt->select()->from($mc_modul_ayar['tablo'])->where("grup", $get_yazi[0]->grup)->orderby('id', "ASC")->result();
}
foreach ($sorgu_yazilar as $sorgu_kategori) {
    if (isset($get_yazilar[$sorgu_kategori->dil])) {
        continue;
    }
    if (empty($sorgu_kategori->dil)) {
        $sorgu_kategori->dil = "tr";
    }
    $get_yazilar[$sorgu_kategori->dil] = $sorgu_kategori;
}

if (!isset($_GET['id'])) {
    exit;
}

$get_yazi = $m_vt->select()->from($mc_modul_ayar['tablo'])->where('tip', $mc_modul_ayar['tip'])->where("id", $_GET['id'])->result();
