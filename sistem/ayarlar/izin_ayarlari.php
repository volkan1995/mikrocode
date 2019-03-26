<?php if(!defined('m_guvenlik')) { exit; } ?>
<p><b>UYARI!</b> <i>Bu bölümdeki ayarlar yöneticiler dışında tüm kullanıcılar için geçerlidir.</i></p>
<div class="setting_block">
    <div class="col-md-8 setting_left">
        <b>Ana Dizine Dosya Yüklemeyi Engelle</b>
    </div>
    <div class="col-md-4 setting_right">
       <div class="switch">
            <label>
                <input type="checkbox" name="mcddye"<?=m_jsonAl($m_ayarlar->ayar,"mcddye")==1?" checked":null?>/>
                <span class="lever switch-col-theme"></span>
            </label>
        </div>
    </div>
</div>
<div class="setting_block">
    <div class="col-md-8 setting_left">
        <b>Yeni Klasör Oluşturmayı Engelle</b>
    </div>
    <div class="col-md-4 setting_right">
       <div class="switch">
            <label>
                <input type="checkbox" name="mcykoe"<?=m_jsonAl($m_ayarlar->ayar,"mcykoe")==1?" checked":null?>/>
                <span class="lever switch-col-theme"></span>
            </label>
        </div>
    </div>
</div>
<div class="setting_block">  
    <div class="col-md-8 setting_left">
        <b>Kişisel Ayarlara Erişimi Engelle</b>
    </div>
    <div class="col-md-4 setting_right">
       <div class="switch">
            <label>
                <input type="checkbox" name="mckaee"<?=m_jsonAl($m_ayarlar->ayar,"mckaee")==1?" checked":null?>/>
                <span class="lever switch-col-theme"></span>
            </label>
        </div>
    </div>
</div>
<div class="setting_block">
    <div class="col-md-8 setting_left">
        <b>Sadece Yüklediği Dosyalara Erişebilsin</b>
    </div>
    <div class="col-md-4 setting_right">
       <div class="switch">
            <label>
                <input type="checkbox" name="mcsyde"<?=m_jsonAl($m_ayarlar->ayar,"mcsyde")==1?" checked":null?>/>
                <span class="lever switch-col-theme"></span>
            </label>
        </div>
    </div>
</div>