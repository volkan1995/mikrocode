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
                            <input type="text" class="form-control" name="baslik" value="<?= $get_ekozellik->baslik ?>" required/>
                            <label class="form-label">Başlık Giriniz <b>*</b></label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">                    
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="sef" value="<?= $get_ekozellik->sef ?>"/>
                            <label class="form-label">Kimlik / Sef</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">                    
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="aciklama" value="<?= $get_ekozellik->aciklama ?>"/>
                            <label class="form-label">Açıklama</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">                    
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="adresy" value="<?= m_jsonAl($get_ekozellik->eklenti, 'adresy', null) ?>"/>
                            <label class="form-label">Adres Yazısı</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">                    
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="adres" value="<?= m_jsonAl($get_ekozellik->eklenti, 'adres', null) ?>"/>
                            <label class="form-label">Adres / URL</label>
                        </div>
                    </div>
                </div>
                <div class='m-t-30 col-md-12'><?= mc_editor($get_ekozellik->icerik) ?></div>
                <div class="m-t-30 col-md-12">
                    <?= mc_dosyalar("dosya", m_jsonAl($get_ekozellik->eklenti, 'galeri', []), "galeri", ['baslik' => "Galeri Dosyaları Seç / Yükle"]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-4 col-xs-12">
        <div class="card">
            <div class="body">
                <button type="submit" class="btn btn-sm btn-theme waves-effect">Kaydet</button>
                <input type="hidden" name="id" value="<?= $get_ekozellik->id ?>" />
                <div class="switch m-t-20">
                    <b class="mc_sw_b80">Yayın</b>
                    <label><input name="yayin" type="checkbox"<?= $get_ekozellik->durum == 1 ? " checked" : null ?>/><span class="lever switch-col-theme"></span></label>
                </div>
                <div class="switch m-t-20">
                    <b class="mc_sw_b80">HTML:</b>
                    <label><input name="html" type="checkbox"<?= m_jsonAl($get_ekozellik->eklenti, 'html', 1) == 1 ? " checked" : null ?>/><span class="lever switch-col-theme"></span></label>
                </div>
                <div class="form-group form-float m-t-20">
                    <div class="form-line">
                        <input type="text" class="form-control" name="icon" value="<?= m_jsonAl($get_ekozellik->eklenti, 'icon', null) ?>"/>
                        <label class="form-label">İkon</label>
                    </div>
                </div>
                <div class='m-t-10'><?= mc_dosya("gorsel", $get_ekozellik->resim, "kapak") ?></div>                
                <div class='m-t-10'><?= mc_dosya("video", m_jsonAl($get_ekozellik->eklenti, 'video', 0), "video") ?></div>                
            </div>
        </div>
    </div>
</form>
<?php
require mc_sablon . 'footer.php';
