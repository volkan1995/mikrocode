<?php
if(!isset($_POST['eklenti_tara'])){
    exit;
}
if (!defined('m_baglanti')) {
    define("m_baglanti", true);
}
if (!defined('m_panel')) {
    define("m_panel", true);
}
if (!defined('m_guvenlik')) {
    define("m_guvenlik", true);
}
require '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'index.php';

$mc_kaydet_sayac = 0;

/* Modül Eklentilerini Tara */
$mc_moduller = array_diff(scandir(m_moduller), array('..', '.', 'loader.php', 'index.php', 'giris.php', 'cikis.php'));
foreach ($mc_moduller as $modul) {
    $modul_ic = m_moduller . $modul . DIRECTORY_SEPARATOR . "plugins";
    if (!file_exists($modul_ic)) {
        continue;
    }
    $mc_modul_ic = array_diff(scandir($modul_ic), array('..', '.'));
    foreach ($mc_modul_ic as $modul_tip) {
        $modul_ic_konum = $modul_ic . DIRECTORY_SEPARATOR . $modul_tip;
        if (!is_dir($modul_ic_konum)) {
            continue;
        }
        $mc_modul_eklentiler = array_diff(scandir($modul_ic_konum), array('..', '.'));
        foreach ($mc_modul_eklentiler as $eklenti) {
            $modul_eklenti_konum = $modul_ic_konum . DIRECTORY_SEPARATOR . $eklenti;
            if(is_file($modul_eklenti_konum)){
                $eklenti_detay = pathinfo($modul_eklenti_konum);
                if(!isset($eklenti_detay['extension']) || strtolower($eklenti_detay['extension']) != "php"){
                    continue;
                }
                $eklenti_sor = $m_vt->select()->from('eklentiler')
                        ->where('tip', $modul_tip)->where('tabloid', 0)
                        ->where('icerik', $modul)->where('tabload', $eklenti_detay['filename'])
                        ->result();
                
                if(!count($eklenti_sor)){
                    $modul_baslik = $modul;
                    $modul_eklenti = null;
                    $eklenti_xml = $modul_ic_konum . DIRECTORY_SEPARATOR . $eklenti_detay['filename'] . ".xml";
                    if (file_exists($eklenti_xml)) {
                        $xml = simplexml_load_file($eklenti_xml);
                        if (isset($xml->baslik)) {
                            $modul_baslik = $xml->baslik;
                        }
                        if (isset($xml->css)) {
                            $modul_eklenti = json_encode(['css' => strval($xml->css)]);
                        }
                    }
                    $mc_kaydet = $m_vt->ekle([
                        'table'=> 'eklentiler',
                        'values'=>[
                            'baslik' => $modul_baslik,
                            'tip' => $modul_tip,
                            'tabloid' => 0,
                            'icerik' => $modul,
                            'tabload' => $eklenti_detay['filename'],
                            'eklenti' => $modul_eklenti
                        ]
                    ])['sonuc'];
                    if($mc_kaydet){
                        $mc_kaydet_sayac += 1;
                    }
                }
            }
        }
    }
}

echo $mc_kaydet_sayac . " yeni eklenti yüklendi.";