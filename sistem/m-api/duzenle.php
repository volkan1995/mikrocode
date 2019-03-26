<?php
    if(!defined('m_sistem_header')) { define("m_sistem_header", true); }    
    require '../../yonetici/loader.php';
?>  
<form class="row clearfix" id="content-form">
    <div class="col-md-9 col-sm-8 col-xs-12">
        <div class="card">
            <div class="header">
                <h2><?=mc_ustmenu("ayarlar",$mc_headtitle, true)?></h2>
            </div>
            <div class="body">
                <input type="hidden" name="id" value="<?=$_GET['id']?>"/>
                <div class="form-group">
                    <label>API Kodu :</label> <span><?=$mc_veri->kod?></span>
                </div>
                <div class="form-group">
                    <label>API Anahtarı :</label> <span><?=$mc_veri->anahtar?></span>
                </div>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="baslik" placeholder="API İsmi" value="<?=$mc_veri->baslik?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="istemci" placeholder="İstemci ID / URL" data-role="tagsinput" value="<?=$mc_veri->istemci?>"/>
                    </div>
                    <small class="col-grey">Bu API için en fazla 5 istemci belirleyebilirsiniz.</small>
                </div>                
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" name="limit" placeholder="Saat başına istek limiti" value="<?=$mc_veri_limit?>" min="0" max="3600"/>
                    </div>
                    <small class="col-grey">Sınırsız istek için 0 giriniz veya boş bırakınız. MAX: 3600</small>
                </div>
                <p class="m-b-10"><b>Servisler</b></p>
                <div class="demo-checkbox">
                <?php foreach ($mc_istekler as $key => $value) { ?>
                    <input type="checkbox" id="apiuse_<?=$key?>" name="api_use[<?=$key?>]" class="chk-col-theme"<?php if(in_array($key,$mc_servisler)){ echo " checked"; } ?>/>
                    <label class="col-md-3" for="apiuse_<?=$key?>"><?=ucfirst($value)?></label>
                <?php } ?>
                </div>                
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-4 col-xs-12">
        <div class="card">
            <div class="body">
                <button type="submit" class="btn btn-sm btn-theme waves-effect"><?=mc_dil('kaydet')?></button>
                <div class="switch m-t-20">
                    <b>API Oluşturulma Zamanı</b>
                    <label><?=$mc_veri->tarih?></label>
                </div>
                <div class="switch m-t-20">
                    <b>Durum</b>
                    <label><input name="yayin" type="checkbox"<?=$mc_veri->durum==1?' checked':null?>/><span class="lever switch-col-theme"></span></label>
                </div>
            </div>
        </div>
    </div>
</form>
<?php require_once mc_sablon.'footer.php'; ?>
<script>
    mc_loadCss("<?=mc_plugins?>bootstrap-tagsinput/bootstrap-tagsinput.css?v=1");
    mc_loadJs("<?=mc_plugins?>bootstrap-tagsinput/bootstrap-tagsinput.min.js?v=1").done(function (){
        $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
    });    
</script>