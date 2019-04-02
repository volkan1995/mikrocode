<?php
if (!defined('m_panel_header')) {
    define("m_panel_header", true);
}
require '..' . DIRECTORY_SEPARATOR . 'loader.php';
?>
<form class="row clearfix" id="content-form">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-12">
            <div class="row">
                <div class="card">
                    <div class="header"><?= mc_ustmenu($mc_modul_ayar['menu'], $mc_headtitle) ?></div>
                    <div class="body">
                        <ul class="nav nav-tabs m-b-10" role="tablist">
                            <?php
                            foreach ($m_diller as $dil => $tanimlar) {
                                if (empty($tanimlar->baslik)) {
                                    continue;
                                }
                                echo '<li><a href="#form_' . $dil . '" data-toggle="tab" aria-expanded="false"><img src="' . mc_img . '/ulke/' . $dil . '.png" style="height: 14px;margin-right: 5px;">' . $tanimlar->baslik . '</a></li>';
                            }
                            ?>
                            <li class="multi-lang-save-li"><button type="submit" class="btn btn-lg btn-theme waves-effect btn-block">Kaydet</button></li>
                            <li class="multi-lang-copy-li"><span type="submit" class="btn btn-circle-xs btn-link waves-effect"><i class="material-icons">swap_horiz</i></span></li>
                        </ul>
                        <div class="tab-content">
                            <?php foreach ($m_diller as $dil => $tanimlar) { ?>
                                <fieldset role="tabpanel" data-dil="<?= $dil ?>" class="row tab-pane fade" id="form_<?= $dil ?>">
                                    <div class="col-md-9 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="baslik" placeholder="Başlık Giriniz" value="" required/>
                                            </div>
                                        </div>
                                        <div class="row">                                        
                                            <div class="col-md-12 m-t-10">
                                                <select name="sayfa" class="form-control show-tick" data-grup="kategori" required><?= mc_kategoriler(['tablo' => $mc_modul_ayar['tablo'], 'dil' => $dil]) ?></select>
                                            </div> 
                                            <div class="col-md-6 m-t-15">
                                                <select name="kategori" class="form-control show-tick live_trigger" required>
                                                    <option value='yazi'><?= mc_dil('yazi') ?></option>
                                                    <option data-trigger="#sekmede_ac_<?= $dil ?>" value='yonlendir'><?= mc_dil('yonlendir') ?></option>
                                                    <option value='kategoriler'><?= mc_dil('kategori') ?></option>
                                                    <option value='icerikler'><?= mc_dil('icerik') ?></option>
                                                    <option value='yazilar'><?= mc_dil('sayfa') ?></option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 m-t-15">                    
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="parametre" placeholder="<?= mc_dil('parametre') ?>" value=""/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        if (isset($mc_modul_ayar['tasarim']['icerik']) && $mc_modul_ayar['tasarim']['icerik']) {
                                            echo '<div class="m-t-30">' . mc_editor() . '</div>';
                                        }
                                        if (isset($mc_modul_ayar['tasarim']['galeri']) && $mc_modul_ayar['tasarim']['galeri']) {
                                            echo '<div class="m-t-30">' . mc_dosyalar("gorsel", [], "galeri", ['baslik' => "Galeri Resimleri Seç / Yükle", 'detaylar' => true]) . '</div>';
                                        }
                                        if (isset($mc_modul_ayar['tasarim']['ek']) && $mc_modul_ayar['tasarim']['ek']) {
                                            echo '<div class="m-t-30">' . mc_dosyalar("dosya", [], "ek", ['baslik' => "Ek Seç / Yükle", 'detaylar' => true]) . '</div>';
                                        }
                                        ?>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <div class="switch m-t-20">
                                            <b class="mc_sw_b80">Yayın</b>
                                            <label><input name="yayin" type="checkbox" checked/><span class="lever switch-col-theme"></span></label>
                                        </div>
                                        <div class="switch m-t-20">
                                            <b class="mc_sw_b80"><?= mc_dil('menu') ?></b>
                                            <label><input name="menu" type="checkbox" checked/><span class="lever switch-col-theme"></span></label>
                                        </div>   
                                        <div class="switch m-t-20" id="sekmede_ac_<?= $dil ?>" style="display:none">
                                            <b class="mc_sw_b80">Sekmede Aç</b>
                                            <label><input name="sekme" type="checkbox"/><span class="lever switch-col-theme"></span></label>
                                        </div>
                                        <?php
                                        if (isset($mc_modul_ayar['tasarim']['resim']) && $mc_modul_ayar['tasarim']['resim']) {
                                            echo '<div class="m-t-10">' . mc_dosya("gorsel", 0, "kapak") . '</div>';
                                        }
                                        if (isset($mc_modul_ayar['tasarim']['video']) && $mc_modul_ayar['tasarim']['video']) {
                                            echo '<div class="m-t-10">' . mc_dosya("video", 0, "video") . '</div>';
                                        }
                                        ?>
                                    </div>
                                </fieldset>                           
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php
require mc_sablon . 'footer.php';
