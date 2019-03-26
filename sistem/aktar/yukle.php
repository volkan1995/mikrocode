<?php
if (!defined('m_sistem_header')) {
    define("m_sistem_header", true);
}
require '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'yonetici' . DIRECTORY_SEPARATOR . 'loader.php';
?>  
<form class="row clearfix" id="content-form">
    <div class="col-md-9 col-sm-8 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>FTP Aktarımı</h2>
            </div>
            <div class="body body_xs" id="yazdir_alan">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="ftp_server" required="" value="<?= isset($m_ayarlar->sistem->ftp_server) ? $m_ayarlar->sistem->ftp_server : null ?>"/>
                                    <label class="form-label"><?= mc_dil('ftp_sunucusu') ?> <b>*</b></label>
                                </div>
                            </div>
                        </div>                
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="ftp_user" required="" value="<?= isset($m_ayarlar->sistem->ftp_user) ? $m_ayarlar->sistem->ftp_user : null ?>"/>
                                    <label class="form-label"><?= mc_dil('ftp_kadi') ?> <b>*</b></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="password" class="form-control" name="ftp_pass" required="" value="<?= isset($m_ayarlar->sistem->ftp_pass) ? $m_ayarlar->sistem->ftp_pass : null ?>"/>
                                    <label class="form-label"><?= mc_dil('ftp_ksifresi') ?> <b>*</b></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="ftp_path" required="" value="<?= isset($m_ayarlar->sistem->ftp_path) ? $m_ayarlar->sistem->ftp_path : "/public_html" ?>"/>
                                    <label class="form-label"><?= mc_dil('ftp_dizin') ?> <b>*</b></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="demo-checkbox">                        
                                <input type="checkbox" id="ftp_kaydet" name="ftp_kaydet" class="chk-col-theme"/>
                                <label for="ftp_kaydet"><?= mc_dil('bilgileri_hatirla') ?></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <span class="btn btn-xs btn-default waves-effect m-r-15 m-t-5 m-b-10" id="ftp_kontrol_btn" onclick="return ftp_kontrol(); return false;">Bağlantıyı Kontrol Et</span><br/>
                        </div>
                    </div>
                </div>
                
                <div class="setting_block row m-t-20 m-b-20">
                    <div class="col-sm-4"> 
                        <div class="switch">
                            <label>
                                <b><?= mc_dil('sablon') ?></b>
                                <input type="checkbox" name="sablon" checked/>
                                <span class="lever switch-col-theme"></span>
                            </label>  
                        </div>
                    </div>
                    <div class="col-sm-4"> 
                        <div class="switch">
                            <label>
                                <b><?= mc_dil('sistem') ?></b>
                                <input type="checkbox" name="sistem" onchange="$('.sistem_modulleri').fadeToggle(300);"/>
                                <span class="lever switch-col-theme"></span>
                            </label>  
                        </div>
                    </div>
                    <div class="col-sm-4"> 
                        <div class="switch">
                            <label>
                                <b><?= mc_dil('yonetici') ?></b>
                                <input type="checkbox" name="yonetici" onchange="$('.yonetici_modulleri').fadeToggle(300);"/>
                                <span class="lever switch-col-theme"></span>
                            </label>  
                        </div>
                    </div>
                </div>
                <div class="row sistem_modulleri" style="display:none">
                    <div class="col-sm-12 m-b-10 m-t-10">   
                        <div class="demo-checkbox">                        
                            <input type="checkbox" id="sistemtumu" name="sistemtumu" class="chk-col-theme tumunu_sec_cb" data-element=".sistem_modul"/>
                            <label for="sistemtumu"><b><?= mc_dil('sistem_modulleri') ?></b></label>
                        </div>
                    </div>
                    <?php
                    foreach (array_diff(scandir(m_sistem), array('..', '.')) as $modul) {
                        if (!is_dir(m_sistem . $modul)) {
                            continue;
                        }
                        ?>
                        <div class="col-sm-4 col-xs-6">   
                            <div class="demo-checkbox">                        
                                <input type="checkbox" id="sistemmoduller[<?= $modul ?>]" name="sistemmoduller[<?= $modul ?>]" class="chk-col-theme sistem_modul"/>
                                <label for="sistemmoduller[<?= $modul ?>]"><?= mc_dil($modul) ?></label>
                            </div>  
                        </div>
                    <?php } ?>
                </div>
                <div class="row yonetici_modulleri" style="display:none">
                    <div class="col-sm-12 m-b-10 m-t-10">   
                        <div class="demo-checkbox">                        
                            <input type="checkbox" id="tumu" name="tumu" class="chk-col-theme tumunu_sec_cb" data-element=".yonetici_modul"/>
                            <label for="tumu"><b><?= mc_dil('yonetici_modulleri') ?></b></label>
                        </div>
                    </div>
                    <?php
                    foreach (array_diff(scandir(m_moduller), array('..', '.')) as $modul) {
                        if (!is_dir(m_moduller . $modul)) {
                            continue;
                        }
                        ?>
                        <div class="col-sm-4 col-xs-6">   
                            <div class="demo-checkbox">                        
                                <input type="checkbox" id="moduller[<?= $modul ?>]" name="moduller[<?= $modul ?>]" class="chk-col-theme yonetici_modul"/>
                                <label for="moduller[<?= $modul ?>]"><?= mc_dil($modul) ?></label>
                            </div>  
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-4 col-xs-12">
        <div class="card">
            <div class="body">
                <button type="submit" class="btn btn-sm btn-theme waves-effect"><?= mc_dil('yuklemeyi_baslat') ?></button>
            </div>
        </div>
    </div>
</form>
<script>
var ftp_kontrol_tf = true;
function ftp_kontrol(){
    
    function form_kontrol(){
       
    }
    post_array['kontrol'] = "onay"; 
    $( "#content-form" ).submit();
    
 /*   if(ftp_kontrol_tf){
        var eskiyazi = $("#ftp_kontrol_btn").text();
        $("#ftp_kontrol_btn").text("Bağlantı sınanıyor...");
        $("#ftp_kontrol_btn").attr("disabled", true);
        ftp_kontrol_tf = false;
        $.post(mc_sistem + "aktar/yukle.php",
            { kaydet:"onay", kontrol:"onay" },
            function(data){
                $("#ftp_kontrol_btn").text(eskiyazi);
                $("#ftp_kontrol_btn").attr("disabled", false);
                ftp_kontrol_tf = true;              
            }
        );
    }*/
}
</script>
<?php
require mc_sablon . 'footer.php';
