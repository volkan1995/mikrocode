<?php
    if(!defined('m_guvenlik')) { exit; }
    $mail_securty = m_jsonAl($m_ayarlar->ayar, "mail_securty", null);
?>
<div class="setting_block">
    <div class="col-md-5 setting_left">
        <b>SMTP Doğrulama</b>
    </div>
    <div class="col-md-7 setting_right">
       <div class="switch">
            <label>
                <input type="checkbox" name="mail_smtp"<?=m_jsonAl($m_ayarlar->ayar,"mail_smtp")==1?" checked":null?>/>
                <span class="lever switch-col-theme"></span>
            </label>
        </div>
    </div>
</div>
<div class="setting_block">
    <div class="col-md-5 setting_left">
        <b>HTML Kullan</b>
    </div>
    <div class="col-md-7 setting_right">
       <div class="switch">
            <label>
                <input type="checkbox" name="mail_html"<?=m_jsonAl($m_ayarlar->ayar,"mail_html")==1?" checked":null?>/>
                <span class="lever switch-col-theme"></span>
            </label>
        </div>
    </div>
</div>
<div class="setting_block">
    <div class="col-md-5 setting_left">
        <b>SMTP Kullanıcı Adı</b>
    </div>
    <div class="col-md-7 setting_right">
        <div class="form-group">
            <div class="form-line">
                <input type="text" class="form-control" name="mail_user" placeholder="Örnek: otomatik@<?=m_host?>" value="<?=m_jsonAl($m_ayarlar->ayar, "mail_user", null)?>"/>
            </div>
        </div>
    </div>
</div>
<div class="setting_block">
    <div class="col-md-5 setting_left">
        <b>SMTP Kullanıcı Şifresi</b>
    </div>
    <div class="col-md-7 setting_right">
        <div class="form-group">
            <div class="form-line">
                <input type="password" class="form-control" name="mail_pass" placeholder="Kullanıcı adına tanımlı şifre" value="<?=m_jsonAl($m_ayarlar->ayar, "mail_pass", null)?>"/>
            </div>
        </div>
    </div>
</div>
<div class="setting_block">
    <div class="col-md-5 setting_left">
        <b>SMTP Sunucusu</b>
    </div>
    <div class="col-md-7 setting_right">
        <div class="form-group">
            <div class="form-line">
                <input type="text" class="form-control" name="mail_host" placeholder="Örnek: mail.<?=m_host?>" value="<?=m_jsonAl($m_ayarlar->ayar, "mail_host", null)?>"/>
            </div>
        </div>
    </div>
</div>
<div class="setting_block">
    <div class="col-md-5 setting_left">
        <b>SMTP Portu ve Güvenliği</b>
    </div>
    <div class="col-md-4 setting_right">
        <div class="form-group">
            <div class="form-line">
                <input type="text" class="form-control" name="mail_port" placeholder="Varsaylan bağlantı portu: 25" value="<?=m_jsonAl($m_ayarlar->ayar, "mail_port", 25)?>"/>
            </div>
        </div>
    </div>
    <div class="col-md-3 setting_right">
        <div class="form-group">
            <select name="mail_securty" class="form-control show-tick">
                <option value="">Güvenlik Yok</option>
                <option value="ssl"<?=$mail_securty=="ssl"?" selected":null?>>SSL</option>
                <option value="tls"<?=$mail_securty=="tls"?" selected":null?>>TLS</option>
            </select>
        </div>
    </div>
</div>
<div class="setting_block">
    <div class="col-md-5 setting_left">
        <b>İletilecek Adresler</b>
    </div>
    <div class="col-md-7 setting_right">
        <div class="form-group">
            <div class="form-line">
                <input type="text" class="form-control" data-role="tagsinput" name="mail_list" placeholder="Örnek: ad@<?=m_host?>" value="<?=m_jsonAl($m_ayarlar->ayar, "mail_list", null)?>"/>
            </div>
            <small>Gelen mesajlar yukarıda belirtilen mail adreslerine gönderilir.</small>
        </div>
    </div>
</div>
<div class="setting_block m-t-10">
<h4>Varsayılan Gönderen Bilgileri</h4>
</div>
<div class="setting_block">
    <div class="col-md-5 setting_left">
        <b>Görüntülenecek E-posta</b>
    </div>
    <div class="col-md-7 setting_right">
        <div class="form-group">
            <div class="form-line">
                <input type="email" class="form-control" name="mail_mail" placeholder="Örnek: info@<?=m_host?>" value="<?=m_jsonAl($m_ayarlar->ayar, "mail_mail", null)?>"/>
            </div>
        </div>
    </div>
</div>
<div class="setting_block">
    <div class="col-md-5 setting_left">
        <b>Görüntülenecek İsim</b>
    </div>
    <div class="col-md-7 setting_right">
        <div class="form-group">
            <div class="form-line">
                <input type="text" class="form-control" name="mail_head" placeholder="Örnek: <?=$m_baslik?>" value="<?=m_jsonAl($m_ayarlar->ayar, "mail_head", $m_baslik)?>"/>
            </div>
        </div>
    </div>
</div>
<div class="setting_block m-b-10 m-t-10">
    <span class="btn btn-xs btn-default waves-effect m-r-15 m-b-10" id="mc_mail_sina_btn" onclick="return mail_ayar_sina(); return false;">Ayarları Sına</span><br/>
    <span id="mc_mail_sina"></span>
</div>
<script>
    mc_loadCss("<?=mc_plugins?>bootstrap-tagsinput/bootstrap-tagsinput.css?v=1");
    mc_loadJs("<?=mc_plugins?>bootstrap-tagsinput/bootstrap-tagsinput.min.js?v=1").done(function (){
        $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
    });
    var mail_sina_tf = true;
    function mail_ayar_sina(){
        if(mail_sina_tf){
            if($("#settings-form input[name='mail_smtp']").is(":checked")){ var mail_smtp = 1; }else{ mail_smtp = 0; }
            if($("#settings-form input[name='mail_html']").is(":checked")){ var mail_html = 1; }else{ mail_html = 0; } 
            var mail_securty = $("#settings-form input[name='mail_securty']").val();
            var mail_user = $("#settings-form input[name='mail_user']").val();
            var mail_pass = $("#settings-form input[name='mail_pass']").val();
            var mail_host = $("#settings-form input[name='mail_host']").val();
            var mail_port = $("#settings-form input[name='mail_port']").val();
            var mail_list = $("#settings-form input[name='mail_list']").val();
            var mail_mail = $("#settings-form input[name='mail_mail']").val();
            var mail_head = $("#settings-form input[name='mail_head']").val();
            var eskiyazi = $("#mc_mail_sina_btn").text();
            $("#mc_mail_sina_btn").text("Ayarlar sınanıyor...");
            $("#mc_mail_sina_btn").attr("disabled", true);
            mail_sina_tf = false;
            $('#mc_mail_sina').empty();
            $.post(mc_sistem + "ayarlar/aktar.php",
                {
                    kaydet:"onay", mail_test:"onay", mcp_tip:"ayar", mcp_adres:"<?=$mc_post['mcp_adres']?>",
                    mail_smtp:mail_smtp, mail_html:mail_html, mail_user:mail_user, mail_securty:mail_securty,
                    mail_pass:mail_pass, mail_host:mail_host, mail_port:mail_port, mail_list:mail_list, mail_mail:mail_mail, mail_head:mail_head
                },
                function(data){
                    $("#mc_mail_sina_btn").text(eskiyazi);
                    $('#mc_mail_sina').html(data);
                    $("#mc_mail_sina_btn").attr("disabled", false);
                    mail_sina_tf = true;              
                }
            );
        }
    }
</script>  