<?php

if (!defined('m_guvenlik')) {
    exit;
}

function hataYaz($hata = 0, $yaz = null) {
    header("Content-Type: application/json; charset=utf-8");
    $ja['status'] = false;
    $ja['code'] = $hata;
    $ja['error'] = HttpStatus($hata);
    $ja['message'] = $yaz;
    echo json_encode($ja);
    exit;
}

$mc_istekler = array(
    0 => 'test',
    1 => 'license',
    2 => 'select',
    3 => 'update',
    4 => 'insert',
    5 => 'delete',
    6 => 'file_upload',
    7 => 'files',
    8 => 'users'
);
