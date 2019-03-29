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
                            foreach ($mt_diller as $dil => $tanimlar) {
                                if (empty($tanimlar['dil'])) {
                                    continue;
                                }
                                echo '<li><a href="#form_' . $dil . '" data-toggle="tab" aria-expanded="false"><img src="' . mc_img . '/ulke/' . $dil . '.png" style="height: 14px;margin-right: 5px;">' . $tanimlar['dil'] . '</a></li>';
                            }
                            ?>
                            <li class="multi-lang-save-li"><button type="submit" class="btn btn-lg btn-theme waves-effect btn-block">Kaydet</button></li>
                            <li class="multi-lang-copy-li"><span type="submit" class="btn btn-circle-xs btn-link waves-effect"><i class="material-icons">swap_horiz</i></span></li>
                        </ul>
                        <div class="tab-content">
                            <?php
                            foreach ($sorgu_sayfalar as $dil => $sayfa) {
                                $sayfa->eklenti = json_decode($sayfa->eklenti);
                                $sekme = m_jsonAl($sayfa->eklenti, 'sekme', 0);
                                ?>
                                <fieldset role="tabpanel" data-dil="<?= $dil ?>" class="row tab-pane fade" id="form_<?=$dil?>">
                                    <div class="col-md-9 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="baslik" placeholder="Başlık Giriniz" value="<?= $sayfa->baslik ?>" required/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 m-t-10">
                                                <select name="sayfa" class="form-control show-tick" required><?= mc_kategoriler(['tablo' => $mc_modul_ayar['tablo'], 'sec' => $sayfa->ust, 'dil' => $dil]) ?></select>
                                            </div>   
                                            <div class="col-md-6 m-t-15">
                                                <select name="kategori" class="form-control show-tick live_trigger" required>
                                                    <option value='yazi'><?= mc_dil('yazi') ?></option>
                                                    <option data-trigger="#sekmede_ac_<?= $dil ?>" value='yonlendir'<?= $sayfa->tip == 'yonlendir' ? " selected" : null ?>><?= mc_dil('yonlendir') ?></option>
                                                    <option value='kategoriler'<?= $sayfa->tip == 'kategoriler' ? " selected" : null ?>><?= mc_dil('kategori') ?></option>
                                                    <option value='icerikler'<?= $sayfa->tip == 'icerikler' ? " selected" : null ?>><?= mc_dil('icerik') ?></option>
                                                    <option value='yazilar'<?= $sayfa->tip == 'yazilar' ? " selected" : null ?>><?= mc_dil('sayfa') ?></option>
                                                </select>
                                            </div>                                         
                                            <div class="col-md-6 m-t-15">                    
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="parametre" placeholder="<?= mc_dil('parametre') ?>" value="<?= $sayfa->tip != 'yazi' ? $sayfa->icerik : null ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        if (isset($mc_modul_ayar['tasarim']['icerik']) && $mc_modul_ayar['tasarim']['icerik']) {
                                            echo '<div class="m-t-30">' . mc_editor($sayfa->tip == 'yazi' ? $sayfa->icerik : null) . '</div>';
                                        }
                                        if (isset($mc_modul_ayar['tasarim']['galeri']) && $mc_modul_ayar['tasarim']['galeri']) {
                                            echo '<div class="m-t-30">' . mc_dosyalar("gorsel", m_jsonAl($sayfa->eklenti, "galeri", []), "galeri", ['baslik' => "Galeri Resimleri Seç / Yükle", 'detaylar' => m_jsonAl($sayfa->eklenti, "galeri_ek", [])]) . '</div>';
                                        }
                                        if (isset($mc_modul_ayar['tasarim']['ek']) && $mc_modul_ayar['tasarim']['ek']) {
                                            echo '<div class="m-t-30">' . mc_dosyalar("dosya", m_jsonAl($sayfa->eklenti, "ek", []), "ek", ['baslik' => "Ek Seç / Yükle", 'detaylar' => m_jsonAl($sayfa->eklenti, "ek_ek", [])]) . '</div>';
                                        }
                                        ?>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <input type="hidden" name="id" value="<?= $sayfa->id ?>" />
                                        <div class="switch m-t-20">
                                            <b class="mc_sw_b80">Yayın</b>
                                            <label><input name="yayin" type="checkbox"<?= $sayfa->durum == 1 ? " checked" : null ?>/><span class="lever switch-col-theme"></span></label>
                                        </div>
                                        <div class="switch m-t-20">
                                            <b class="mc_sw_b80"><?= mc_dil('menu') ?></b>
                                            <label><input name="menu" type="checkbox"<?= $sayfa->menu == 1 ? " checked" : null ?>/><span class="lever switch-col-theme"></span></label>
                                        </div>   
                                        <div class="switch m-t-20" id="sekmede_ac_<?= $dil ?>" style="<?= $sekme != 1 ? "display:none" : null ?>">
                                            <b class="mc_sw_b80">Sekmede Aç</b>
                                            <label><input name="sekme" type="checkbox"<?= $sekme == 1 ? " checked" : null ?>/><span class="lever switch-col-theme"></span></label>
                                        </div>                                    
                                        <?php
                                        if (isset($mc_modul_ayar['tasarim']['resim']) && $mc_modul_ayar['tasarim']['resim']) {
                                            echo '<div class="m-t-10">' . mc_dosya("gorsel", $sayfa->resim, "kapak") . '</div>';
                                        }
                                        if (isset($mc_modul_ayar['tasarim']['video']) && $mc_modul_ayar['tasarim']['video']) {
                                            echo '<div class="m-t-10">' . mc_dosya("video", m_jsonAl($sayfa->eklenti, 'video', 0), "video") . '</div>';
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
