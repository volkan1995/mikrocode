<?php if(!defined('m_guvenlik')) { exit; } ?>
<div class="col-md-4 setting_left">
    <b>Site Erişimi</b>
</div>
<div class="col-md-8 setting_right">
   <div class="switch">
        <label>
            <input type="checkbox" name="erisim"<?=$m_ayarlar->erisim==1?" checked":null?>/>
            <span class="lever switch-col-theme"></span>
        </label>
    </div>
</div>
<div class="col-md-4 setting_left">
    <b>Dinamik Sayfalar</b>
</div>
<div class="col-md-8 setting_right">
   <div class="switch">
        <label>
            <input type="checkbox" name="mcps"<?=m_jsonAl($m_ayarlar->ayar,"mcps")==1?" checked":null?>/>
            <span class="lever switch-col-theme"></span>
        </label>
    </div>
</div>
<?php if(m_gelistirici > 0){ ?>
<div class="col-md-4 setting_left">
    <b>Kenarları Vurgula</b>
</div>
<div class="col-md-8 setting_right">
   <div class="switch">
        <label>
            <input type="checkbox" name="mckv"<?=m_jsonAl($m_ayarlar->ayar,"mckv")==1?" checked":null?>/>
            <span class="lever switch-col-theme"></span>
        </label>
    </div>
</div>
<?php } ?>
<div class="col-md-4 setting_left">
    <b>İletişim Bilgileri Sayısı</b>
</div>
<div class="col-md-8 setting_right">
    <div class="form-group">
        <div class="form-line">
            <input type="number" class="form-control" max="10" min="1" name="mcis" placeholder="Kullanılan temada kaç adet iletişim bilgisi mevcut" value="<?=m_jsonAl($m_ayarlar->ayar,"mcis",1)?>"/>
        </div>
    </div>
</div>
<div class="col-md-4 setting_left">
    <b>Harita Bilgileri Sayısı</b>
</div>
<div class="col-md-8 setting_right">
    <div class="form-group">
        <div class="form-line">
            <input type="number" class="form-control" max="10" min="1" name="mchs" placeholder="Kullanılan temada kaç adet harita bilgisi mevcut" value="<?=m_jsonAl($m_ayarlar->ayar,"mchs",1)?>"/>
        </div>
    </div>
</div>
<div class="setting_block m-t-10">
    <small>Yeni bir modül yada eklenti yüklendiğinde veya bir sorun olduğunu düşünüyorsanız yeniden taratabilirsiniz.</small>
 </div>
<div class="setting_block m-b-10">
    <div class="col-md-6 setting_left">
        <span class="btn btn-xs btn-default waves-effect m-r-15 m-t-5 m-b-10" id="mc_solmenu_tara_btn" onclick="return sol_menu_tara(); return false;">Sol Menüyü Tara</span><br/>
        <span id="mc_solmenu_tara"></span>
    </div>
    <div class="col-md-6 setting_right">
        <span class="btn btn-xs btn-default waves-effect m-r-15 m-t-5 m-b-10" id="mc_eklenti_tara_btn" onclick="return eklenti_tara(); return false;">Eklentileri Tara</span><br/>
        <span id="mc_eklenti_tara"></span>
    </div>    
</div>
<script>
    var gelismis_ayarlar_tf = true;
    function sol_menu_tara(){
        if(gelismis_ayarlar_tf){
            var eskiyazi = $("#mc_solmenu_tara_btn").text();
            $("#mc_solmenu_tara_btn").text("Taranıyor...");
            $("#mc_solmenu_tara_btn").attr("disabled", true);
            gelismis_ayarlar_tf = false;
            $('#mc_solmenu_tara').empty();
            $.post(mc_sistem + "ayarlar/aktar.php",
                { kaydet:"onay", menu_tara:"onay", mcp_tip:"ayar", mcp_adres:"<?=$mc_post['mcp_adres']?>" },
                function(data){
                    $("#mc_solmenu_tara_btn").text(eskiyazi);
                    $('#mc_solmenu_tara').html(data);
                    $("#mc_solmenu_tara_btn").attr("disabled", false);
                    gelismis_ayarlar_tf = true;              
                }
            );
        }
    }
    function eklenti_tara(){
        if(gelismis_ayarlar_tf){
            var eskiyazi = $("#mc_eklenti_tara_btn").text();
            $("#mc_eklenti_tara_btn").text("Taranıyor...");
            $("#mc_eklenti_tara_btn").attr("disabled", true);
            gelismis_ayarlar_tf = false;
            $('#mc_eklenti_tara').empty();
            $.post(mc_sistem + "eklentiler/tara.php",
                { eklenti_tara:"onay" },
                function(data){
                    $("#mc_eklenti_tara_btn").text(eskiyazi);
                    $('#mc_eklenti_tara').html(data);
                    $("#mc_eklenti_tara_btn").attr("disabled", false);
                    gelismis_ayarlar_tf = true;              
                }
            );
        }
    }
</script>  