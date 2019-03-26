<?php
if (!defined('m_guvenlik')) {
    exit;
}
$m_ayarlar->lisans = json_decode($m_ayarlar->lisans);
$m_ayarlar->sistem = json_decode($m_ayarlar->sistem);
$oto_g = 1;
$puanyaz = "Performans test edilmemiş";
if (isset($m_ayarlar->sistem->oto_g)) {
    if ($m_ayarlar->sistem->oto_g != 1) {
        $oto_g = 0;
    }
}
if (isset($m_ayarlar->sistem->puan)) {
    $m_mc_uyum = $m_ayarlar->sistem->puan;
    if ($m_mc_uyum == 100) {
        $puanyaz = "Çok iyi!";
    } else if ($m_mc_uyum >= 95) {
        $puanyaz = "Bu iyi!";
    } else if ($m_mc_uyum >= 70) {
        $puanyaz = "Pek iyi sayılmaz!";
    } else if ($m_mc_uyum >= 50) {
        $puanyaz = "Pek kötü sayılmaz!";
    } else {
        $puanyaz = "Çok kötü!";
    }
    $puanyaz = $m_mc_uyum . "% <small><i>" . $puanyaz . "</i></small>";
}
?>
<div class="setting_block">
    <div class="col-md-4 setting_left">
        <b>Paket / Sürüm</b>
    </div>
    <div class="col-md-8 setting_left">
        <?= isset($m_ayarlar->lisans->s) ? $m_ayarlar->lisans->s : "Arge" ?> / 1.1
    </div>
</div>
<div class="setting_block">
    <div class="col-md-4 setting_left">
        <b>Ürün Kimliği</b>
    </div>
    <div class="col-md-8 setting_left">
        <?= isset($m_ayarlar->lisans->k) ? $m_ayarlar->lisans->k : "Yasadışı Kullanım" ?>
    </div>
</div>
<div class="setting_block">
    <div class="col-md-4 setting_left">
        <b>Lisans Kodu</b>
    </div>
    <div class="col-md-8 setting_left">
        <?= isset($m_ayarlar->lisans->l) ? $m_ayarlar->lisans->l : "TR090-".date('Y')."-0000-0000" ?>
    </div>
</div>
<div class="setting_block">
    <div class="col-md-4 setting_left">
        <b>Maksimum Yükleme Boyutu</b>
    </div>
    <div class="col-md-8 setting_left">
        <?= ini_get("upload_max_filesize") . "B" ?>
    </div>
</div>
<div class="setting_block">
    <div class="col-md-4 setting_left">
        <b>Maksimum POST Veri Boyutu</b>
    </div>
    <div class="col-md-8 setting_left">
        <?= ini_get("post_max_size") . "B" ?>
    </div>
</div>    
<div class="setting_block">   
    <div class="col-md-4 setting_left">
        <b>İşlem Zaman Aşımı</b>
    </div>
    <div class="col-md-8 setting_left">
        <?= ini_get("max_execution_time") . " sn" ?>
    </div>
</div>
<div class="setting_block">   
    <div class="col-md-4 setting_left">
        <b>Kullanılabilir Hafıza Boyutu</b>
    </div>
    <div class="col-md-8 setting_left">
        <?= ini_get("memory_limit") . "B" ?>
    </div>
</div>
<div class="setting_block">   
    <div class="col-md-4 setting_left">
        <b>Minimum Gereksinimler</b>
    </div>
    <div class="col-md-8 setting_left">
        PHP 5.4, MySQL 5.5, 32MB Depolama
    </div>
</div>
<div class="setting_block">   
    <div class="col-md-4 setting_left">
        <b>Mevcut Sistem</b>
    </div>
    <div class="col-md-8 setting_left">
        PHP <?= phpversion() ?>, MySQL <?= $m_vt->sorgu("SHOW VARIABLES LIKE 'version'")[0]->Value ?>, <?= mc_boyutyaz(disk_total_space($_SERVER['DOCUMENT_ROOT'])) ?> Depolama
    </div>
</div>
<div class="setting_block">   
    <div class="col-md-4 setting_left">
        <b>Sistem Performansı</b>
    </div>
    <div class="col-md-8 setting_left">
        <span id="yenidentest_alan"><?= $puanyaz ?></span>
        <span class="btn btn-xs btn-link waves-effect m-l-10 mc_yenidentest_btn" onclick="return mc_yenidentest();">Yeniden Test Et</span>
    </div>
</div>
<div class="setting_block">   
    <div class="col-md-4 setting_left">
        <b>Son güncelleme</b>
    </div>
    <div class="col-md-8 setting_left">
        <span><small id="guncelleme_sonuc"><?= isset($m_ayarlar->lisans->t) ? $m_ayarlar->lisans->t : "Güncellenmemiş" ?></small></span>
        <div id="guncelleme_alan"><span class="btn btn-xs btn-link waves-effect m-l-10 guncelleme_btn" onclick="return mc_guncellemekontrol();">Güncelleştirmeleri Denetle</span></div>
    </div>
</div>
<div class="col-md-4 setting_left">
    <b>Otomatik Güncelleştir</b>
</div>
<div class="col-md-8 setting_right">
    <div class="switch">
        <label>
            <input type="checkbox" name="oto_g"<?= $oto_g == 1 ? " checked" : null ?>/>
            <span class="lever switch-col-theme" style="margin: 0"></span>
        </label>
    </div>
</div>
<script>
    mc_guncellemetTF = true;
    function mc_yenidentest() {
        if (mc_guncellemetTF) {
            mc_guncellemetTF = false;
            var eskiyazi = $('.mc_yenidentest_btn').text();
            $('.mc_yenidentest_btn').text("Test ediliyor...");
            $.post(mc_sistem + "ayarlar/aktar.php", {kaydet: "onay", yeni_test: "onay", mcp_tip: "ayar", mcp_adres: "<?= $mc_post['mcp_adres'] ?>"},
                    function (data) {
                        $('.mc_yenidentest_btn').text(eskiyazi);
                        setTimeout(function () {
                            $('#yenidentest_alan').html(data);
                            mc_guncellemetTF = true;
                        }, 500);
                    }
            );
        }
    }
    function mc_guncellemekontrol() {
        if (mc_guncellemetTF) {
            mc_guncellemetTF = false;
            var eskiyazi = $('.guncelleme_btn').text();
            $('.guncelleme_btn').text("Kontrol ediliyor...");
            $.post(mc_sistem + "ayarlar/aktar.php", {kaydet: "onay", guncelle: "onay", mcp_tip: "ayar", mcp_adres: "<?= $mc_post['mcp_adres'] ?>"},
                    function (data) {
                        $('.guncelleme_btn').text(eskiyazi);
                        $('#guncelleme_sonuc').html(data);
                        mc_guncellemetTF = true;
                    }
            );
        }
    }
<?php
if (!isset($m_ayarlar->sistem->puan)) {
    echo "mc_yenidentest();";
}
?>
</script>

