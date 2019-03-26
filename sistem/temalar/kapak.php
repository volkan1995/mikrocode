<?php

require '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'yonetici' . DIRECTORY_SEPARATOR . 'loader.php';

if (isset($_POST['kaydet']) && isset($_POST['tema']) && isset($_POST['resim'])) {
    if (file_exists(m_temalar . $_POST['tema'])) {
        $mevcut_konum = m_temalar . $_POST['tema'] . DIRECTORY_SEPARATOR;
        if (file_exists($mevcut_konum . "kapak.png")) {
            unlink($mevcut_konum . "kapak.png");
        }
        $kaydet = file_put_contents($mevcut_konum . "kapak.png", base64_decode($_POST['resim']));
        if ($kaydet && file_exists($mevcut_konum . "kapak.png")) {
            $mc_simge = m_domain . "/sablon/temalar/" . $_POST['tema'] . "/kapak.png";
            echo '<script> $("#mc_tema_' . m_url_duzelt($_POST['tema']) . ' > img").attr("src", "' . m_resim($mc_simge, 300, 200, 2) . '?v=' . time() . '"); </script>';
        }
    }
}