<?php
if (!defined('m_guvenlik')) {
    exit;
}
if (isset($_POST['islem'])) {
    $modaltitle = null;
    if ($_POST['islem'] == "yedekal") {
        $modaltitle = "Sistemi Yedekle";
    }
    echo '<ol class="breadcrumb breadcrumb-bg-' . $mc_oturum->tema->renk . '"><li class="agac"><b>' . $modaltitle . '</b></li></ol>';
    echo '<div class="modal-body">';
    if ($_POST['islem'] == "yedekal") {
        echo "<p>Lütfen yedeklemek istediğiniz bölümleri seçiniz, ardından <u>yedeklemeyi</u> başlatabilirsiniz.</p>";
        $yedekmodulleri = array('depo', 'dosyalar', 'sablon', 'sistem', 'yonetici', 'eskiyedekler', 'veritabani');
        echo '<div class="row">';
        foreach ($yedekmodulleri as $yedekmodul) {
            echo '<div class="col-sm-3 col-xs-6 m-b-10 m-t-10"><div class="demo-checkbox">' .
            '<input type="checkbox" id="' . $yedekmodul . '" name="' . $yedekmodul . '" class="chk-col-theme"/>' .
            '<label for="' . $yedekmodul . '">' . mc_dil($yedekmodul) . '</label></div></div>';
        }
        echo '</div><div class="row p-t-15"><div class="col-md-3"><span class="btn btn-block waves-effect m-r-15 mc_ydk_btn" onclick="return mc_yedekle();">Sistemi Yedekle</span></div>' .
        '<div class="col-md-9"><span id="ydk_alan" class="opt_yedek_alan"></span></div></div>';
    }
    echo '</div><div class="modal-footer"><button type="button" class="btn btn-link waves-effect">Kapat</button></div>';
    exit;
}



if (isset($_POST['tamyedekle'])) {
    if (PHP_VERSION >= 5.2) {
        if (!class_exists('ZipArchive')) {
            echo '<script>setTimeout(function () {$(".mc_opt_btn").text(eskiyazi);mc_optTF = true;}, 200);</script>';
            mc_uyari(-4, "<b>Başarısız</b>Sunucunuzda <u>ZipArchive</u> eklentisi yüklü olmadığı için <u>Yedekleme Sihirbazı</u> çalışmıyor.");
        }
    } else {
        echo '<script>setTimeout(function () {$(".mc_opt_btn").text(eskiyazi);mc_optTF = true;}, 200);</script>';
        mc_uyari(-4, "<b>Başarısız</b><u>Yedekleme Sihirbazı</u>'nı kullanabilmek için minimum <u>PHP 5.2</u> sürümünü kullanmanız gerekmektedir.<br>Sizin sürümünüz: " . PHP_VERSION);
    }
    if (!file_exists(m_dosyalar . "yedekler")) {
        $yeni_klasor = mkdir(m_dosyalar . "yedekler");
        if (!$yeni_klasor) {
            echo '<script>setTimeout(function () {$(".mc_opt_btn").text(eskiyazi);mc_optTF = true;}, 200);</script>';
            mc_uyari(-4, "<b>Başarısız</b>Yedek klasörü oluşturulamadı");
        }
    }
    if (!file_exists(m_dosyalar . "yedekler" . DIRECTORY_SEPARATOR . "tam")) {
        $yeni_klasor = mkdir(m_dosyalar . "yedekler" . DIRECTORY_SEPARATOR . "tam");
        if (!$yeni_klasor) {
            echo '<script>setTimeout(function () {$(".mc_opt_btn").text(eskiyazi);mc_optTF = true;}, 200);</script>';
            mc_uyari(-4, "<b>Başarısız</b>Yedek klasörü oluşturulamadı");
        }
    }
    include mc_yardimcilar . "yedekleme" . DIRECTORY_SEPARATOR . "db.php";
    $mc_vt_konum = m_dizin . mdb_name . '.sql';
    if (file_exists($mc_vt_konum)) {
        unlink($mc_vt_konum);
    }
    $db = new DBBackup(array('driver' => mdb_driver, 'host' => mdb_server, 'user' => mdb_user, 'password' => mdb_pass, 'database' => mdb_name));
    $backup = $db->backup();
    if (!$backup['error']) {
        $fp = fopen($mc_vt_konum, 'a+');
        fwrite($fp, $backup['msg']);
        fclose($fp);
    }
    include mc_yardimcilar . "yedekleme" . DIRECTORY_SEPARATOR . "zip.php";
    $mc_zip_isim = mt_isim . '_tam_' . date('Y-m-d_H-i-s');
    $mc_zip_konum = m_dosyalar . "yedekler" . DIRECTORY_SEPARATOR . "tam" . DIRECTORY_SEPARATOR . $mc_zip_isim;
    $mc_zip = new mc_arsivle();
    $mc_zip->zipOlustur($mc_zip_konum);
    $mc_zip->anaDizin = m_dizin;
    $mc_zip->altDizinler([mdb_name . '.sql', '.htaccess', 'index.php', 'depo', 'dosyalar', 'sablon', 'sistem', 'yonetici']);
    $mc_zip->atla(["depo/onbellek", "dosyalar/yedekler/tam"]);
    $mc_zip->arsivle();
    $mc_zip->close();
    if (file_exists($mc_vt_konum)) {
        unlink($mc_vt_konum);
    }
    ?>
    <script>
        $('#ydk_alan').html('<span class="indir" data-src="/dosyalar/yedekler/tam/<?= $mc_zip_isim ?>.zip" data-isim="<?= $mc_zip_isim ?>"><i class="material-icons">file_download</i> Yedeği indir</span>');
        setTimeout(function () {
            mc_optTF = true;
            $('.mc_ydk_btn').text(eskiyazi);
        }, 1000);
    </script>
    <?php
    exit;
}

if (isset($_POST['optyedekle'])) {
    if (PHP_VERSION >= 5.2) {
        if (!class_exists('ZipArchive')) {
            echo '<script>setTimeout(function () {$(".mc_opt_btn").text(eskiyazi);mc_optTF = true;}, 200);</script>';
            mc_uyari(-4, "<b>Başarısız</b>Sunucunuzda <u>ZipArchive</u> eklentisi yüklü olmadığı için <u>Yedekleme Sihirbazı</u> çalışmıyor.");
        }
    } else {
        echo '<script>setTimeout(function () {$(".mc_opt_btn").text(eskiyazi);mc_optTF = true;}, 200);</script>';
        mc_uyari(-4, "<b>Başarısız</b><u>Yedekleme Sihirbazı</u>'nı kullanabilmek için minimum <u>PHP 5.2</u> sürümünü kullanmanız gerekmektedir.<br>Sizin sürümünüz: " . PHP_VERSION);
    }
    if (!file_exists(m_dosyalar . "yedekler")) {
        $yeni_klasor = mkdir(m_dosyalar . "yedekler");
        if (!$yeni_klasor) {
            echo '<script>setTimeout(function () {$(".mc_opt_btn").text(eskiyazi);mc_optTF = true;}, 200);</script>';
            mc_uyari(-4, "<b>Başarısız</b>Yedek klasörü oluşturulamadı");
        }
    }
    if (!file_exists(m_dosyalar . "yedekler" . DIRECTORY_SEPARATOR . "optimizasyon")) {
        $yeni_klasor = mkdir(m_dosyalar . "yedekler" . DIRECTORY_SEPARATOR . "optimizasyon");
        if (!$yeni_klasor) {
            echo '<script>setTimeout(function () {$(".mc_opt_btn").text(eskiyazi);mc_optTF = true;}, 200);</script>';
            mc_uyari(-4, "<b>Başarısız</b>Yedek klasörü oluşturulamadı");
        }
    }
    include mc_yardimcilar . "yedekleme" . DIRECTORY_SEPARATOR . "zip.php";
    if (defined('mt_isim') && !empty(mt_isim)) {
        $mc_zip_isim = mt_isim . '_js-css_' . date('Y-m-d_H-i-s');
        $mc_zip_konum = m_dosyalar . "yedekler" . DIRECTORY_SEPARATOR . "optimizasyon" . DIRECTORY_SEPARATOR . $mc_zip_isim;
        $mc_zip = new mc_arsivle();
        $mc_zip->zipOlustur($mc_zip_konum);
        $mc_zip->izinli(["js", "css"]);
        $mc_zip->anaDizin = m_tema;
        $mc_zip->arsivle();
        $mc_zip->close();
        ?>
        <script>
            $('#opt_alan').html('<span class="indir" data-src="/dosyalar/yedekler/optimizasyon/<?= $mc_zip_isim ?>.zip" data-isim="<?= $mc_zip_isim ?>"><i class="material-icons">file_download</i> Yedeği indir</span>');
            mc_optTF = true;
            $('.mc_opt_btn').text("Optimize ediliyor...");
            $.post(mc_sistem + "ayarlar/aktar.php", {kaydet: "onay", optimizasyon: "onay", mcp_tip: "ayar", mcp_adres: "<?= $mc_post['mcp_adres'] ?>"},
            function (data) {
                setTimeout(function () {
                    $('#seoveopt_alan').html(data);
                    $('.mc_opt_btn').text("Optimize Tamamlandı");
                    setTimeout(function () {
                        $('.mc_opt_btn').text(eskiyazi);
                        mc_optTF = true;
                    }, 20000);
                }, 1000);
            }
            );
        </script>
        <?php
        exit;
    }
    echo '<script>setTimeout(function () {$(".mc_opt_btn").text(eskiyazi);mc_optTF = true;}, 200);</script>';
    exit;
}

use MatthiasMullie\Minify;

if (isset($_POST['optimizasyon'])) {
    if (defined('mt_isim') && !empty(mt_isim)) {
        include mc_yardimcilar . 'opt' . DIRECTORY_SEPARATOR . 'Minify.php';
        include mc_yardimcilar . 'opt' . DIRECTORY_SEPARATOR . 'CSS.php';
        include mc_yardimcilar . 'opt' . DIRECTORY_SEPARATOR . 'JS.php';
        include mc_yardimcilar . 'opt' . DIRECTORY_SEPARATOR . 'Exception.php';
        include mc_yardimcilar . 'opt' . DIRECTORY_SEPARATOR . 'BasicException.php';
        include mc_yardimcilar . 'opt' . DIRECTORY_SEPARATOR . 'FileImportException.php';
        include mc_yardimcilar . 'opt' . DIRECTORY_SEPARATOR . 'IOException.php';
        include mc_yardimcilar . 'opt' . DIRECTORY_SEPARATOR . 'ConverterInterface.php';
        include mc_yardimcilar . 'opt' . DIRECTORY_SEPARATOR . 'Converter.php';

        function mc_opt_tara($dir, $sb = 0) {
            $ffs = scandir($dir);
            unset($ffs[array_search('.', $ffs, true)]);
            unset($ffs[array_search('..', $ffs, true)]);
            foreach ($ffs as $ff) {
                $icdir = $dir . $ff;
                $dosya_pi = pathinfo($icdir);
                if (!isset($dosya_pi["extension"])) {
                    $dosya_pi["extension"] = null;
                }
                $dosya_pi["extension"] = strtolower($dosya_pi["extension"]);
                $optuzn = array('css' => "css", 'js' => "js");
                if (is_dir($icdir)) {
                    $sb = mc_opt_tara($icdir . DIRECTORY_SEPARATOR, $sb);
                } else {
                    if (in_array($dosya_pi["extension"], $optuzn)) {
                        if ($dosya_pi["extension"] == "css") {
                            $opt_et = new Minify\CSS($icdir);
                        } else if ($dosya_pi["extension"] == "js") {
                            $opt_et = new Minify\JS($icdir);
                        }
                        if (file_exists($icdir . ".opt")) {
                            unlink($icdir . ".opt");
                        }
                        copy($icdir, $icdir . ".opt");
                        $opt = $opt_et->minify($icdir);
                        if ($opt) {
                            $eb = filesize($icdir . ".opt");
                            $yb = filesize($icdir);
                            if ($eb > $yb) {
                                $sb = $sb + ($eb - $yb);
                            }
                        }
                        if (file_exists($icdir . ".opt")) {
                            unlink($icdir . ".opt");
                        }
                    }
                }
            }
            return $sb;
        }

        $mc_son_boyut = mc_opt_tara(m_tema);
        $mc_son_boyut = mc_BoyutYaz($mc_son_boyut);
        mc_uyari(1, "<b>Optimize Tamamlandı</b>Toplamda $mc_son_boyut tasarruf edildi.", 60000);
    }
    exit;
}