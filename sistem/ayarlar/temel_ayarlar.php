<?php
    if(!defined('m_guvenlik')) { exit; }    
    
    if(isset($m_ayarlar->medya->logo_tr)){ $m_logo['tr'] = $m_ayarlar->medya->logo_tr; }else{ $m_logo['tr'] = 0; }
    
    if(isset($m_ayarlar->medya->galeri_tr)){ $m_galeri['tr'] = $m_ayarlar->medya->galeri_tr; }else{ $m_galeri['tr'] = array(); }
    
    if(isset($m_ayarlar->medya->galeri_tr_b)){
        $m_galerid['b'] = $m_ayarlar->medya->galeri_tr_b;
        $m_galerid['a'] = @$m_ayarlar->medya->galeri_tr_a;
        $m_galerid['u'] = @$m_ayarlar->medya->galeri_tr_u;
        $m_galerid['y'] = @$m_ayarlar->medya->galeri_tr_y;
    
    }else{ $m_galerid = array(); }
    
?>
<div class="col-md-4 setting_left" style="display: none">
    <b>Site görüntüleme dili</b>
</div>
<div class="col-md-8 setting_right" style="display: none">
    <select name="sitedil" class="form-control show-tick">
        <option value="0"<?=$m_ayarlar->dil==0?" selected":null?>>Otomatik</option>
        <option value="tr"<?=$m_ayarlar->dil=="tr"?" selected":null?>>Türkçe</option>
        <option value="en"<?=$m_ayarlar->dil=="en"?" selected":null?>>English</option>
    </select>
</div>

<div class="col-md-4 setting_left">
    <b>Site başlığı</b>
</div>
<div class="col-md-8 setting_right">
    <div class="form-group">
        <div class="form-line">
            <input type="text" class="form-control" name="baslik" placeholder="<?=$m_baslik?>" value="<?=$m_baslik?>"/>
        </div>
    </div>
</div>

<div class="col-md-4 setting_left">
    <b>Site açıklaması</b>
</div>
<div class="col-md-8 setting_right">
    <div class="form-group">
        <div class="form-line">
            <textarea rows="4" class="form-control no-resize" name="aciklama" placeholder="<?=$m_aciklama?>"><?=$m_aciklama?></textarea>
        </div>
    </div>
</div>
<div class="setting_block">
    <div class="col-md-4 setting_left">
        <b>Anahtar Kelimeler</b>
    </div>
    <div class="col-md-8 setting_right">
        <div class="form-group">
            <div class="form-line">
                <input type="text" class="form-control" data-role="tagsinput" name="anahtar" placeholder="Anahtar Kelime Giriniz" value="<?=$m_anahtar?>"/>
            </div>
        </div>
    </div>
</div>
<div class="col-md-4 setting_left">
    <b>Site Logosu</b>
</div>
<div class="col-md-8 setting_right">
    <?=mc_dosya("gorsel",$m_logo['tr'],"logo_tr")?>
</div>
<div class="setting_block">
    <div class="col-md-4 setting_left">
        <b>Anasayfa Galerisi</b>
    </div>
    <div class="col-md-8 setting_right">
        <?=mc_dosyalar("gorsel",$m_galeri['tr'],"galeri_tr",['detaylar' => $m_galerid])?>
    </div>
</div>
<script>
    mc_loadCss("<?=mc_plugins?>bootstrap-tagsinput/bootstrap-tagsinput.css?v=1");
    mc_loadJs("<?=mc_plugins?>bootstrap-tagsinput/bootstrap-tagsinput.min.js?v=1").done(function (){
        $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
    });
</script>  