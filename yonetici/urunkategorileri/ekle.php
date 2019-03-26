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
                                if (empty($tanimlar['dil'])) {
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
                                ?>
                                <div class="col-md-9 col-sm-8 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="baslik[<?= $dil ?>]" placeholder="Başlık Giriniz" required/>
                                        </div>
                                    </div>
                                    <div class="m-t-25">
                                        <select name="kategori[<?=$dil?>]" class="form-control show-tick"><?= mc_kategoriler(['tip' => $mc_modul_ayar['tip']]) ?></select>
                                    </div> 
                                    <div class="form-group m-t-20">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="aciklama[<?= $dil ?>]" placeholder="Açıklama Giriniz"/>
                                        </div>
                                    </div> 
                                    <div class='m-t-30'><?= mc_editor(null, "m_editor_{$dil}") ?></div>
                                    <div class="m-t-30">
                                        <?= mc_dosyalar("gorsel", [], "galeri_{$dil}", ['baslik' => "Galeri Resimleri Seç / Yükle"]) ?>
                                    </div> 
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-12">
                                    <input type="hidden" name="diller[]" value="<?= $dil ?>" />
                                    <div class="switch m-t-20">
                                        <b class="mc_sw_b80">Yayın</b>
                                        <label><input name="yayin[<?= $dil ?>]" type="checkbox" checked/><span class="lever switch-col-theme"></span></label>
                                    </div>
                                    <div class="switch m-t-15">
                                        <b class="mc_sw_b80">Vurgula</b>
                                        <label><input name="vurgula[<?= $dil ?>]" type="checkbox"/><span class="lever switch-col-theme"></span></label>
                                    </div>               
                                    <div class='m-t-20'><?= mc_dosya("gorsel", 0, "kapak_" . $dil) ?></div>                
                                    <div class='m-t-10'><?= mc_dosya("video", 0, "video_" . $dil) ?></div>
                                    <?php
                                    if ($mc_oturum->grup < 3 && isset($mc_modul_ayar['tasarim']['izinler']) && $mc_modul_ayar['tasarim']['izinler']) {
                                        echo '<div class="m-t-30"><b>Özel İzin</b></div><div class="m-t-10"><select id="optgroup" class="ms" multiple="multiple" name="izinler[]">';
                                        foreach ($m_vt->select()->from("gruplar")->where('baslik', "kurucu", "<>")->result() as $grup) {
                                            echo '<optgroup label="' . $grup->baslik . '">';
                                            foreach ($m_vt->select("`id`,`izinler`,`grup`,`kadi`")->from("kullanicilar")->where('grup', $grup->id)->result() as $kullanici) {
                                                echo '<option value="' . $kullanici->id . '">' . $kullanici->kadi . '</option>';
                                            }
                                            echo '</optgroup>';
                                        }
                                        echo "</select></div>";
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
<?php require_once mc_sablon . 'footer.php'; ?>
<link href="<?= mc_plugins ?>multi-select/css/multi-select.css" rel="stylesheet" />
<script>
    mc_hazir(function () {
        mc_loadJs("<?= mc_plugins ?>multi-select/js/jquery.multi-select.js").done(function () {
            $('#optgroup').multiSelect({selectableOptgroup: true, selectableHeader: "Tüm Kullanıcılar", selectionHeader: "İzin Verilenler"});
        });
    });
</script>