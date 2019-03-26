<?php
if (!defined('m_sistem_header')) {
    define("m_sistem_header", true);
}
require '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'yonetici' . DIRECTORY_SEPARATOR . 'loader.php';
?>  
<form class="row clearfix" id="content-form">
    <div class="col-md-9 col-sm-8 col-xs-12">
        <div class="card">
            <div class="header"><?= mc_ustmenu("ayarlar", $mc_headtitle, true) ?></div>
            <div class="body body_xs">
                <div class="col-md-6">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="baslik" placeholder="" value="" required/>
                            <label class="form-label">Başlık Giriniz <b>*</b></label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">                    
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="sef" value=""/>
                            <label class="form-label">Kimlik / Sef</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">                    
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="aciklama" value=""/>
                            <label class="form-label">Açıklama</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">                    
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="adresy" value=""/>
                            <label class="form-label">Adres Yazısı</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">                    
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="adres" value=""/>
                            <label class="form-label">Adres / URL</label>
                        </div>
                    </div>
                </div>
                <div class='m-t-30 col-md-12'><?= mc_editor() ?></div>
                <div class="m-t-30 col-md-12">
                    <?= mc_dosyalar("dosya", [], "galeri", ['baslik' => "Galeri Dosyaları Seç / Yükle"]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-4 col-xs-12">
        <div class="card">
            <div class="body">
                <button type="submit" class="btn btn-sm btn-theme waves-effect">Kaydet</button>
                <div class="switch m-t-20">
                    <b class="mc_sw_b80">Yayın</b>
                    <label><input name="yayin" type="checkbox" checked/><span class="lever switch-col-theme"></span></label>
                </div>
                <div class="switch m-t-20">    
                    <b class="mc_sw_b80">HTML:</b>                
                    <label><input name="html" type="checkbox" checked/><span class="lever switch-col-theme"></span></label>
                </div>
                <div class="form-group form-float m-t-20">
                    <div class="form-line">
                        <input type="text" class="form-control" name="icon" value=""/>
                        <label class="form-label">İkon</label>
                    </div>
                </div>
                <div class='m-t-10'><?= mc_dosya("gorsel", 0, "kapak") ?></div>                
                <div class='m-t-10'><?= mc_dosya("video", 0, "video") ?></div>                
            </div>
        </div>
    </div>
</form>
<?php
require mc_sablon . 'footer.php';
