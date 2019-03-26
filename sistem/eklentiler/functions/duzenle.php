<?php

if (!defined('m_guvenlik')) {
    exit;
}

if (isset($_POST['kaydet'])) {

    mc_yetki("eklentiler", 2);

    unset($_POST['kaydet']);

    if (empty($_POST['baslik'])) {
        mc_uyari(-3, "<b>" . mc_dil('basarisiz') . "</b>" . mc_dil('bos_alanlar_var'));
    }

    $_POST['id'] = intval($_POST['id']);

    if(!isset($_POST['yayin'])){ $_POST['yayin'] = 0; }else{ $_POST['yayin'] = intval($_POST['yayin']); }
    
    $mc_kaydet = $m_vt->guncelle([
                'table' => "eklentiler",
                'values' => [
                    'baslik' => $_POST['baslik'],
                    'durum' => $_POST['yayin']
                ],
                'where' => ['id' => $_POST['id']]
            ])['sonuc'];

    if ($mc_kaydet) {
        mc_uyari(-1, "<b>" . mc_dil('basarili') . "</b>Eklenti düzenlendi");
    } else {
        mc_uyari(-4, "<b>" . mc_dil('basarili') . "</b>Eklenti bilinmeyen bir hatadan dolayı düzenlenemedi.");
    }
}

if (!isset($_GET['id'])) {
    exit;
}

$get_eklentiler = $m_vt->select()->from("eklentiler")->where("id", $_GET['id'])->result();

if (!count($get_eklentiler)) {
    exit;
}

$get_eklentiler = $get_eklentiler[0];

$get_eklentiler->eklenti = json_decode($get_eklentiler->eklenti);

$eklenti_yol['yol'] = null;
if ($get_eklentiler->tabloid == 0) {
    $eklenti_yol['yol'] = rtrim(m_moduller, DIRECTORY_SEPARATOR);
}
$eklenti_yol['modul'] = $get_eklentiler->icerik;
$eklenti_yol['bolum'] = "plugins";
$eklenti_yol['tip'] = $get_eklentiler->tip;
$eklenti_yol['dosya'] = $get_eklentiler->tabload . ".php";
if (empty($eklenti_yol['yol'])) {
    $eklenti_yol['eklenti'] = ltrim(implode($eklenti_yol, DIRECTORY_SEPARATOR), DIRECTORY_SEPARATOR);
}else{
    $eklenti_yol['eklenti'] = implode($eklenti_yol, DIRECTORY_SEPARATOR);
}
$mc_title = mc_dil('duzenle') . ": " . $get_eklentiler->baslik;
$eklenti_icerik = null;
if (file_exists($eklenti_yol['eklenti'])) {
    $t_oku = file($eklenti_yol['eklenti']);
    foreach ($t_oku as $t_yaz) {
        $eklenti_icerik .= $t_yaz;
    }
}

if($mc_renk_tema == "dark"){
    $mc_editorSbln = "merbivore";
}else{
    $mc_editorSbln = "chrome";
}
