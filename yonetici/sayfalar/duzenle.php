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
                            <li class="multi-lang-save-li"><button type="submit" class="btn btn-lg bg-grey waves-effect btn-block">Kaydet</button></li>
                            <?php
                            $dil_tf = true;
                            foreach ($mt_diller as $dil => $tanimlar) {
                                if(empty($tanimlar['dil'])){
                                    unset($mt_diller[$dil]);
                                    continue;
                                }
                                if ($dil_tf) {
                                    echo '<li role="presentation" class="active"><a href="#form_' . $dil . '" data-toggle="tab" aria-expanded="true"><img src="' . mc_img . '/ulke/' . $dil . '.png" style="height: 14px;margin-right: 5px;">' . $tanimlar['dil'] . '</a></li>';
                                    $dil_tf = false;
                                } else {
                                    echo '<li role="presentation"><a href="#form_' . $dil . '" data-toggle="tab" aria-expanded="false"><img src="' . mc_img . '/ulke/' . $dil . '.png" style="height: 14px;margin-right: 5px;">' . $tanimlar['dil'] . '</a></li>';
                                }
                            }
                            ?>
                        </ul>
                        <div class="tab-content">
                            <?php
                            $dil_tf = true;
                            foreach ($mt_diller as $dil => $tanimlar) {
                                if ($dil_tf) {
                                    echo '<div role="tabpanel" class="row tab-pane fade active in" id="form_' . $dil . '">';
                                    $dil_tf = false;
                                } else {
                                    echo '<div role="tabpanel" class="row tab-pane fade" id="form_' . $dil . '">';
                                }
                                if (!isset($get_sayfalar[$dil])) {
                                    $veri_baslik = null;
                                    $veri_id = 0;
                                    $veri_icerik = null;
                                    $veri_eklenti = null;
                                    $veri_durum = 1;
                                    $veri_resim = 0;
                                    $veri_tip = 0;
                                    $veri_menu = 1;
                                    $veri_ust = 0;
                                    if (isset($mc_modul_ayar['tasarim']['ek']) && $mc_modul_ayar['tasarim']['ek']) {
                                        $m_ekid['b'] = null;
                                        $m_ekid['a'] = null;
                                        $m_ekid['u'] = null;
                                        $m_ekid['y'] = null;
                                    }
                                } else {
                                    $get_sayfa = $get_sayfalar[$dil];
                                    $veri_baslik = $get_sayfa->baslik;
                                    $veri_id = $get_sayfa->id;
                                    $veri_icerik = $get_sayfa->icerik;
                                    $veri_eklenti = $get_sayfa->eklenti;
                                    $veri_durum = $get_sayfa->durum;
                                    $veri_resim = $get_sayfa->resim;
                                    $veri_tip = $get_sayfa->tip;
                                    $veri_menu = $get_sayfa->durum;
                                    $veri_ust = $get_sayfa->ust;
                                    $sekme = 0;
                                    if (strlen($veri_eklenti) > 3) {
                                        $veri_eklenti = json_decode($veri_eklenti);
                                    }
                                    if (isset($mc_modul_ayar['tasarim']['ek']) && $mc_modul_ayar['tasarim']['ek']) {
                                        $m_ekid['b'] = m_jsonAl($veri_eklenti, 'ek_b');
                                        $m_ekid['a'] = m_jsonAl($veri_eklenti, 'ek_a');
                                        $m_ekid['u'] = m_jsonAl($veri_eklenti, 'ek_u');
                                        $m_ekid['y'] = m_jsonAl($veri_eklenti, 'ek_y');
                                        $sekme = m_jsonAl($veri_eklenti, 'sekme', 0);
                                    }
                                }
                                ?>
                                <div class="col-md-9 col-sm-8 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="baslik[<?= $dil ?>]" placeholder="Başlık Giriniz" value="<?= $veri_baslik ?>" required/>
                                        </div>
                                    </div>
                                    <div class="row">                                        
                                        <div class="col-md-12 m-t-10">
                                            <select name="sayfa[<?= $dil ?>]" class="form-control show-tick" required><?= mc_kategoriler(['tablo' => $mc_modul_ayar['tablo'], 'sec' => $veri_ust, 'dil' => $dil]) ?></select>
                                        </div>   
                                        <div class="col-md-6 m-t-15">
                                            <select name="kategori[<?= $dil ?>]" class="form-control show-tick live_trigger" required>
                                                <option value='yazi'><?= mc_dil('yazi') ?></option>
                                                <option data-trigger="#sekmede_ac" value='yonlendir'<?= $veri_tip == 'yonlendir' ? " selected" : null ?>><?= mc_dil('yonlendir') ?></option>
                                                <option value='kategoriler'<?= $veri_tip == 'kategoriler' ? " selected" : null ?>><?= mc_dil('kategori') ?></option>
                                                <option value='icerikler'<?= $veri_tip == 'icerikler' ? " selected" : null ?>><?= mc_dil('icerik') ?></option>
                                                <option value='yazilar'<?= $veri_tip == 'yazilar' ? " selected" : null ?>><?= mc_dil('sayfa') ?></option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 m-t-15">                    
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="parametre[<?= $dil ?>]" placeholder="<?= mc_dil('parametre') ?>" value="<?= $veri_tip != 'yazi' ? $veri_icerik : null ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if (isset($mc_modul_ayar['tasarim']['icerik']) && $mc_modul_ayar['tasarim']['icerik']) {
                                        echo '<div class="m-t-30">' . mc_editor($veri_tip == 'yazi' ? $veri_icerik : null, "m_editor_{$dil}") . '</div>';
                                    }
                                    if (isset($mc_modul_ayar['tasarim']['galeri']) && $mc_modul_ayar['tasarim']['galeri']) {
                                        echo '<div class="m-t-30">' . mc_dosyalar("gorsel", m_jsonAl($veri_eklenti, "galeri", []), "galeri_" . $dil, ['baslik' => "Galeri Resimleri Seç / Yükle"]) . '</div>';
                                    }
                                    if (isset($mc_modul_ayar['tasarim']['ek']) && $mc_modul_ayar['tasarim']['ek']) {
                                        echo '<div class="m-t-30">' . mc_dosyalar("dosya", m_jsonAl($veri_eklenti, "ek", []), $dil . "_ek", ['baslik' => "Ek Seç / Yükle", 'detaylar' => true]) . '</div>';
                                    }
                                    ?>
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-12">
                                    <input type="hidden" name="diller[]" value="<?= $dil ?>" />
                                    <input type="hidden" name="id[<?= $dil ?>]" value="<?= $veri_id ?>" />
                                    <div class="switch m-t-20">
                                        <b class="mc_sw_b80">Yayın</b>
                                        <label><input name="yayin[<?= $dil ?>]" type="checkbox"<?= $veri_durum == 1 ? " checked" : null ?>/><span class="lever switch-col-theme"></span></label>
                                    </div>
                                    <div class="switch m-t-20">
                                        <b class="mc_sw_b80"><?= mc_dil('menu') ?></b>
                                        <label><input name="menu[<?= $dil ?>]" type="checkbox"<?= $veri_menu == 1 ? " checked" : null ?>/><span class="lever switch-col-theme"></span></label>
                                    </div>   
                                    <div class="switch m-t-20" id="sekmede_ac" style="<?= !isset($veri_eklenti->sekme) ? "display:none" : null ?>">
                                        <b class="mc_sw_b80">Sekmede Aç</b>
                                        <label><input name="sekme[<?= $dil ?>]" type="checkbox"<?= $sekme == 1 ? " checked" : null ?>/><span class="lever switch-col-theme"></span></label>
                                    </div>
                                    <?php
                                    if (isset($mc_modul_ayar['tasarim']['resim']) && $mc_modul_ayar['tasarim']['resim']) {
                                        echo '<div class="m-t-10">' . mc_dosya("gorsel", $veri_resim, "kapak_" . $dil) . '</div>';
                                    }
                                    if (isset($mc_modul_ayar['tasarim']['video']) && $mc_modul_ayar['tasarim']['video']) {
                                        echo '<div class="m-t-10">' . mc_dosya("video", m_jsonAl($veri_eklenti, 'video', 0), "video_" . $dil) . '</div>';
                                    }
                                    ?>
                                </div>                            
                                <?php
                                echo "</div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php
require mc_sablon . 'footer.php';
