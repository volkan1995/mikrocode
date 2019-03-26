<?php
if (!defined('m_guvenlik')) {
    exit;
}
$mc_ayar_kayit_btn = false;
?>
<b>Optimizasyon</b> sitenin hızını etkileyen ayarları içerir.<br/>
Bu işlemde CSS ve JS dosyaları geri dönüştürülemez şekilde sıkıştıralacağı için optimize başlamadan önce yedekleme yapılacaktır. 
(<small>Olası sunucusu hatasına karşı lütfen el ile yedek almayı unutmayınız.</small>)<br/>
<small class="m-t-10"><b>Optimize edilecek dosya türleri: javascript:js, stil dosyaları:css</b></small>
<div class="setting_block m-t-10" style="display:none">
    <div class="col-md-3 setting_left">
        <b>HTML Sıkıştır</b>
    </div>
    <div class="col-md-9 setting_right">
        <div class="switch">
            <label>
                <input type="checkbox" name="htmlmin"/>
                <span class="lever switch-col-theme"></span>
            </label>
        </div>
        <small>Lütfen açık uçlu açıklama satırı bulunmadığından emin olunuz.<br/>ÖRNEK: <b>//</b> veya kapatılmamış <b>/*</b> , <b>&lt;!--</b> gibi karakter grupları</small>
    </div>
</div>
<div class="setting_block m-t-20 opt_block">
    <div class="row">
        <div class="col-md-4">
            <span class="btn btn-block waves-effect m-r-15 m-b-10 mc_opt_btn" onclick="return mc_opt_yedekle();">Optimizeyi Başlat</span>    
        </div>
        <div class="col-md-8">
            <span id="opt_alan" class="opt_yedek_alan"></span>
        </div>
    </div>
</div>
<div class="setting_block m-t-20 opt_block">
    <div class="row">
        <div class="col-md-4">
            <span class="btn btn-block waves-effect m-r-15 m-b-10" onclick="return mc_opt_modal('yedekal');">Sistemi Yedekle</span>
        </div>
        <div class="col-md-8">
        </div>
    </div>
</div>
<div class="setting_block m-t-20">
    <div class="row">
        <div class="col-md-4">
            <span class="btn btn-block waves-effect m-r-15 m-b-10">Tam Yedekler</span>  
        </div>
        <div class="col-md-4">
            <span class="btn btn-block waves-effect m-r-15 m-b-10">Veritabanı Yedekleri</span>
        </div>
        <div class="col-md-4">
            <span class="btn btn-block waves-effect m-r-15 m-b-10">Optimize Yedekleri</span>   
        </div>
    </div>
</div>


<div id="seoveopt_alan"></div>
<style>
    .opt_yedek_alan, .opt_yedek_alan i{
        float: left;
    }
    .opt_yedek_alan{
        line-height: 24px;
        margin-top: 3px;
    }
</style>
<script>
    mc_optTF = true;
    var eskiyazi = null;
    function mc_opt_yedekle() {
        if (mc_optTF) {
            mc_optTF = false;
            eskiyazi = $('.mc_opt_btn').text();
            $('.mc_opt_btn').text("Yedek alınıyor...");
            $.post(mc_sistem + "ayarlar/aktar.php", {kaydet: "onay", optyedekle: "onay", mcp_tip: "ayar", mcp_adres: "<?= $mc_post['mcp_adres'] ?>"},
            function (data) {
                setTimeout(function () {
                    $('#seoveopt_alan').html(data);
                    mc_optTF = true;
                }, 500);
            }
            );
        }
    }
    
    function mc_opt_modal(islem) {
        if(mc_optTF) {
            mc_optTF = false;
            eskiyazi = $('.mc_ydk_btn').text();
            $('.mc_ydk_btn').text("Bekleyiniz...");
            $.post(mc_sistem + "ayarlar/aktar.php", {kaydet: "onay", islem: islem, mcp_tip: "ayar", mcp_adres: "<?= $mc_post['mcp_adres'] ?>"},
            function (data) {
                setTimeout(function () {
                    $('#mc_m_dy').modal('show');
                    $('.mc_ydk_btn').text(eskiyazi);
                    $('#mc_m_dyc').html(data);
                    mc_optTF = true;
                }, 500);
            }
            );
        }
    }
    
    function mc_yedekle() {        
        if (mc_optTF) {
            mc_optTF = false;
            eskiyazi = $('.mc_ydk_btn').text();
            $('.mc_ydk_btn').text("Yedek alınıyor...");
            $.post(mc_sistem + "ayarlar/aktar.php", {kaydet: "onay", tamyedekle: "onay", mcp_tip: "ayar", mcp_adres: "<?= $mc_post['mcp_adres'] ?>"},
            function (data) {
                setTimeout(function () {
                    $('#seoveopt_alan').html(data);
                    mc_optTF = true;
                }, 500);
            }
            );
        }
    }
</script>