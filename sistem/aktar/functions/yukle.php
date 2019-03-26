<?php
if (!defined('m_guvenlik')) { exit; }
/*    ftp.mikrobilisim.net    mikropanel    v?50G6pr */

if(isset($_POST['kaydet'])){
    if (!isset($_POST['ftp_server']) || empty($_POST['ftp_server'])){
        mc_uyari(-3, "<b>Bağlantı Yapılamadı</b>FTP adresini giriniz.");
    }
    if (!isset($_POST['ftp_user']) || empty($_POST['ftp_user'])){
        mc_uyari(-3, "<b>Bağlantı Yapılamadı</b>FTP kullanıcı adını giriniz.");
    }
    if (!isset($_POST['ftp_pass']) || empty($_POST['ftp_pass'])){
        mc_uyari(-3, "<b>Bağlantı Yapılamadı</b>FTP kullanıcı şifresini giriniz.");
    }
    if (!isset($_POST['ftp_path']) || empty($_POST['ftp_path'])){
        $_POST['ftp_path'] = "/";
    }
    $_POST['ftp_path'] = trim($_POST['ftp_path']);
    if($_POST['ftp_path'] == "/"){
        $_POST['ftp_path'] = ".";
    }
    $m_ftp = @ftp_connect($_POST['ftp_server']);
    if (!$m_ftp) {
        mc_uyari(-4, "<b>Bağlantı Yapılamadı</b>Bağlantı kurulamıyor.", 30000);
    }
    $m_ftp_giris = @ftp_login($m_ftp, $_POST['ftp_user'], $_POST['ftp_pass']);
    if (!$m_ftp_giris) {
        ftp_close($m_ftp);
        mc_uyari(-4, "<b>Bağlantı Yapılamadı</b>Kullanıcı adı veya şifre yanlış.");
    }
    
    function fsNodeType($ftp, $fsNodePath){
        $lines = array_values(ftp_raw($ftp, "MLST $fsNodePath"));
        $linesCount = count($lines);
        if ($linesCount !== 3) {
            return FALSE;
        }
        if (!preg_match('/^250\-/', $lines[0]) || !preg_match('/^250 /', $lines[2])) {
            return FALSE;
        }
        if (preg_match('/[\s\;]type\=([^\;]+)/i', ' ' . $lines[1], $matches)) {
            return trim($matches[1]);
        } else {
            return FALSE;
        }
    }
    function isDir($ftp, $fsNodePath) {
        $type = strtolower(fsNodeType($ftp, $fsNodePath));
        return ($type === 'cdir' || $type === 'pdir' || $type === 'dir');

    }
    if (!isDir($m_ftp, $_POST['ftp_path'])) {
        ftp_close($m_ftp);
        mc_uyari(-4, "<b>Bağlantı Yapılamadı</b>Belirttiğiniz yol bulunamadı");
    }
    if(isset($_POST['kontrol'])){
        ftp_close($m_ftp);
        mc_uyari(-1, "<b>Başarılı</b>Bağlantı yapılabiliyor");
    }
    if (isset($_POST['ftp_kaydet']) && $_POST['ftp_kaydet'] == 1){    
        $m_ayarlar->sistem = m_jsonDegistir($m_ayarlar->sistem, 'ftp_server', $_POST['ftp_server'], false);
        $m_ayarlar->sistem = m_jsonDegistir($m_ayarlar->sistem, 'ftp_user', $_POST['ftp_user'], false);
        $m_ayarlar->sistem = m_jsonDegistir($m_ayarlar->sistem, 'ftp_pass', $_POST['ftp_pass'], false);
        $m_ayarlar->sistem = m_jsonDegistir($m_ayarlar->sistem, 'ftp_path', $_POST['ftp_path'], false);
        $mc_values['sistem'] = $m_ayarlar->sistem;
        $m_vt->guncelle(['table'=>"ayarlar",'values'=>$mc_values,'where' => ['id'=>1]]);
    }
    ftp_pasv($m_ftp, true);
    function ftp_klasor_oku($dizin = null, $konumlar = array()) {
        $dizin = rtrim($dizin, "/");
        $konumlar[] = $dizin;
        if (is_dir(m_dizin . $dizin)) {
            foreach (array_diff(scandir(m_dizin . $dizin), array('..', '.')) as $dosya) {
                if (is_dir(m_dizin . $dizin)) {
                    $konumlar = array_merge($konumlar, ftp_klasor_oku($dizin . "/" . $dosya));
                } else {
                    $konumlar[] = $dizin . "/" . $dosya;
                }
            }
        }
        return $konumlar;
    }
    $iys_konum = array(".htaccess", "index.php");
    $hata_liste = array();
    $yonetici_moduller_tf = false;
    $sistem_moduller_tf = false;
    if (isset($_POST['sablon']) && $_POST['sablon'] == 1) {
        $iys_konum[] = "sablon/";
        $iys_konum[] = "sablon/eklentiler/";
        $iys_konum[] = "sablon/temalar/";
        $iys_konum[] = "sablon/temalar/loader.php";
    }
   /* if (isset($_POST['sistem']) && $_POST['sistem'] == 1) {
        $iys_konum = array_merge($iys_konum, ftp_klasor_oku("sistem/"));
    }*/
    if (isset($_POST['sistem']) && $_POST['sistem'] == 1) {
        $iys_konum[] = "sistem/";
        $iys_konum[] = "sistem/.htaccess";
        $iys_konum[] = "sistem/index.php";
        $sistem_moduller_tf = true;
    }
    if ($sistem_moduller_tf && isset($_POST['sistemmoduller']) && is_array($_POST['sistemmoduller'])) {
        foreach ($_POST['sistemmoduller'] as $modul => $deger) {
            if ($deger == 0 || !is_dir(m_sistem . $modul)) {
                continue;
            }
            $iys_konum = array_merge($iys_konum, ftp_klasor_oku("sistem/{$modul}"));
        }
    }
    if (isset($_POST['yonetici']) && $_POST['yonetici'] == 1) {
        $iys_konum[] = "yonetici/";
        $iys_konum[] = "yonetici/cikis.php";
        $iys_konum[] = "yonetici/giris.php";
        $iys_konum[] = "yonetici/loader.php";
        $iys_konum[] = "yonetici/index.php";
        $yonetici_moduller_tf = true;
    }
    if ($yonetici_moduller_tf && isset($_POST['moduller']) && is_array($_POST['moduller'])) {
        foreach ($_POST['moduller'] as $modul => $deger) {
            if ($deger == 0 || !is_dir(m_moduller . $modul)) {
                continue;
            }
            $iys_konum = array_merge($iys_konum, ftp_klasor_oku("yonetici/{$modul}"));
        }
    }
    foreach ($iys_konum as $dosya) {
        $yerel = m_dizin.$dosya;
        $uzak = "/".$dosya;
        if(file_exists($yerel)){
            if (is_dir($yerel)){
                if (!@ftp_chdir($m_ftp, $uzak)) {
                    $islem = ftp_mkdir($m_ftp, $uzak);
                    if(!$islem){
                        $hata_liste[] = $uzak;
                    }
                }
            } else {
                $islem = ftp_put($m_ftp, $uzak, $yerel, FTP_BINARY);
                if(!$islem){
                    $hata_liste[] = $uzak;
                }
            }
        }
    }
    ftp_close($m_ftp);
    if(count($hata_liste)){
        mc_uyari(-3, "<b>Başarısız</b>".mc_dil('aktarim_hata').".", 120000);
        /*foreach ($hata_liste as $hatali) {  echo $hatali."<br/>"; }*/
    }else{
        mc_uyari(-1, "<b>Başarılı</b>".mc_dil('aktarim_tamamlandi').".", 120000);
    }
    exit;
}

$m_ayarlar->sistem = json_decode($m_ayarlar->sistem);