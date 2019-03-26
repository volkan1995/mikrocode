<?php
    if(!defined('m_guvenlik')) { exit; }
    if(isset($mc_oturum->eklenti->muzikcalar) && $mc_oturum->eklenti->muzikcalar == 1){
        $mc_kullanici_muzikcalar = " checked";
    }else{ $mc_kullanici_muzikcalar = null; }
?>
<div class="col-md-4 setting_left">
    <b>Panel görüntüleme dili</b>
</div>
<div class="col-md-8 setting_right">
    <select name="secili_dil" required="" class="form-control show-tick">
        <?php
            $mc_secili_dil = false;
            foreach ($mc_diller as $key => $value){
                if($mc_dil == $key && isset($mc_oturum->tema->dil)){ $mc_oturum->tema->dil = $key; echo "<option value='$key' selected>".$value['dil']."</option>"; $mc_secili_dil = true; }
                else{ echo "<option value='$key'>".$value['dil']."</option>"; }
            }
        ?>
    </select>
</div>
<?php if(m_jsonAl($m_ayarlar->ayar,"mcps")==1){ ?>
<div class="col-md-4 setting_left">
    <b>Müzik Çalar</b>
</div>
<div class="col-md-8 setting_right">
   <div class="switch mc_dosyabtn_switch">
        <label>
            <input type="checkbox" name="muzikcalar"<?=$mc_kullanici_muzikcalar?>/>
            <span class="lever switch-col-theme"></span>
        </label>
    </div>
    <?=mc_dosyalar("ses", explode(",", m_jsonAl($mc_oturum->eklenti,"muzikler")), "muzik_g", ['baslik' => "Müzik Seç / Yükle", 'btn' => "md"])?>
</div> 
<?php } ?>