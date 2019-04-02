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
                                                <input type="text" class="form-control" name="baslik" placeholder="<?= mc_dil('baslik_giriniz') ?>" value="" required/>
                                            </div>
                                        </div>
                                        <?php if (isset($mc_modul_ayar['tasarim']['kategori']) && $mc_modul_ayar['tasarim']['kategori']) { ?>
                                            <div class="m-t-25">
                                                <select name="kategori" class="form-control show-tick"><?= mc_kategoriler(['dil' => $dil, 'tip' => $mc_modul_ayar['kategori']]) ?></select>
                                            </div> 
                                        <?php } if (isset($mc_modul_ayar['tasarim']['aciklama']) && $mc_modul_ayar['tasarim']['aciklama']) { ?>
                                            <div class="form-group m-t-20">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="aciklama" placeholder="<?= mc_dil('aciklama_giriniz') ?>"/>
                                                </div>
                                            </div> 
                                            <?php
                                        }                                        
                                        if (isset($mc_modul_ayar['tasarim']['icerik']) && $mc_modul_ayar['tasarim']['icerik']) {
                                            echo '<div class="m-t-30">' . mc_editor() . '</div>';
                                        }
                                        if (isset($mc_modul_ayar['tasarim']['galeri']) && $mc_modul_ayar['tasarim']['galeri']) {
                                            echo '<div class="m-t-30">' . mc_dosyalar("gorsel", [], "galeri", ['baslik' => "Galeri Resimleri Seç / Yükle"]) . '</div>';
                                        }
                                        if (isset($mc_modul_ayar['tasarim']['ek']) && $mc_modul_ayar['tasarim']['ek']) {
                                            echo '<div class="m-t-30">' . mc_dosyalar("dosya", [], "ek", ['baslik' => "Ek Seç / Yükle", 'detaylar' => true]) . '</div>';
                                        } 
                                        ?>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <div class="switch m-t-20">
                                            <b class="mc_sw_b80"><?= mc_dil('yayin') ?></b>
                                            <label><input name="yayin" type="checkbox" checked/><span class="lever switch-col-theme"></span></label>
                                        </div>
                                        <?php if (isset($mc_modul_ayar['tasarim']['vurgula']) && $mc_modul_ayar['tasarim']['vurgula']) { ?>
                                        <div class="switch m-t-20">
                                            <b class="mc_sw_b80"><?= mc_dil('manset') ?></b>
                                            <label><input name="vurgula" type="checkbox" checked/><span class="lever switch-col-theme"></span></label>
                                        </div>
                                        <?php
                                        }
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