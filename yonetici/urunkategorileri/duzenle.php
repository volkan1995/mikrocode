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
                            foreach ($m_diller as $dil => $tanimlar) {
                                if (empty($tanimlar->baslik)) {
                                    unset($m_diller[$dil]);
                                    continue;
                                }
                                if ($dil_tf) {
                                    echo '<li role="presentation" class="active"><a href="#form_' . $dil . '" data-toggle="tab" aria-expanded="true"><img src="' . mc_img . '/ulke/' . $dil . '.png" style="height: 14px;margin-right: 5px;">' . $tanimlar->baslik . '</a></li>';
                                    $dil_tf = false;
                                } else {
                                    echo '<li role="presentation"><a href="#form_' . $dil . '" data-toggle="tab" aria-expanded="false"><img src="' . mc_img . '/ulke/' . $dil . '.png" style="height: 14px;margin-right: 5px;">' . $tanimlar->baslik . '</a></li>';
                                }
                            }
                            ?>
                        </ul>
                        <div class="tab-content">
                            <?php
                            $dil_tf = true;
                            foreach ($m_diller as $dil => $tanimlar) {
                                if ($dil_tf) {
                                    echo '<div role="tabpanel" class="row tab-pane fade active in" id="form_' . $dil . '">';
                                    $dil_tf = false;
                                } else {
                                    echo '<div role="tabpanel" class="row tab-pane fade" id="form_' . $dil . '">';
                                }
                                    
                                if(!isset($get_kategoriler[$dil])){
                                    $veri_baslik = null;
                                    $veri_id = 0;
                                    $veri_icerik = null;
                                    $veri_aciklama = null;
                                    $veri_izinler = null;
                                    $veri_eklenti = null;
                                    $veri_durum = 1;
                                    $veri_vurgula = 0;
                                    $veri_resim = 0;
                                    $veri_ust = 0;                            
                                }else{
                                    $get_kategori = $get_kategoriler[$dil];
                                    mc_ic_yetki($get_kategori->izinler, 0, true);
                                    $veri_baslik = $get_kategori->baslik;
                                    $veri_id = $get_kategori->id;
                                    $veri_icerik = $get_kategori->icerik;
                                    $veri_aciklama = $get_kategori->aciklama;
                                    $veri_izinler = $get_kategori->izinler;
                                    $veri_eklenti = $get_kategori->eklenti;
                                    $veri_durum = $get_kategori->durum;
                                    $veri_vurgula = $get_kategori->vurgula;
                                    $veri_resim = $get_kategori->resim;
                                    $veri_ust = $get_kategori->ust;
                                    if(strlen($veri_eklenti) > 3){ $veri_eklenti = json_decode($veri_eklenti); }
                                }
                                
                                ?>
                                <div class="col-md-9 col-sm-8 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="baslik[<?=$dil?>]" placeholder="Başlık Giriniz" value="<?= $veri_baslik ?>" required/>
                                        </div>
                                    </div>
                                    <div class="m-t-25">
                                        <select name="kategori[<?=$dil?>]" class="form-control show-tick"><?= mc_kategoriler(['sec' => $veri_ust, 'tip' => $mc_modul_ayar['tip']]) ?></select>
                                    </div>  
                                    <div class="form-group m-t-20">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="aciklama[<?=$dil?>]" placeholder="Açıklama Giriniz" value="<?= $veri_aciklama ?>"/>
                                        </div>
                                    </div>
                                    <div class='m-t-30'><?= mc_editor($veri_icerik, "m_editor_{$dil}") ?></div>
                                    <div class="m-t-30">
                                        <?= mc_dosyalar("gorsel", m_jsonAl($veri_eklenti, "galeri", []), "galeri_{$dil}", ['baslik' => "Galeri Resimleri Seç / Yükle"]) ?>
                                    </div> 
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-12">
                                    <input type="hidden" name="diller[]" value="<?= $dil ?>" />
                                    <input type="hidden" name="id[<?=$dil?>]" value="<?= $veri_id ?>" />
                                    <div class="switch m-t-20">
                                        <b class="mc_sw_b80">Yayın</b>
                                        <label><input name="yayin[<?=$dil?>]" type="checkbox"<?= $veri_durum == 1 ? " checked" : null ?>/><span class="lever switch-col-theme"></span></label>
                                    </div>
                                    <div class="switch m-t-15">
                                        <b class="mc_sw_b80">Vurgula</b>
                                        <label><input name="vurgula[<?=$dil?>]" type="checkbox"<?= $veri_vurgula == 1 ? " checked" : null ?>/><span class="lever switch-col-theme"></span></label>
                                    </div>               
                                    <div class='m-t-20'><?= mc_dosya("gorsel", $veri_resim, "kapak_" . $dil) ?></div>                
                                    <div class='m-t-10'><?= mc_dosya("video", m_jsonAl($veri_eklenti, 'video', 0), "video_".$dil) ?></div>
                                    <?php
                                    if ($mc_oturum->grup < 3 && isset($mc_modul_ayar['tasarim']['izinler']) && $mc_modul_ayar['tasarim']['izinler']) {
                                        echo '<div class="m-t-30"><b>Özel İzin</b></div><div class="m-t-10"><select id="optgroup" class="ms" multiple="multiple" name="izinler['.$dil.'][]">';
                                        foreach ($m_vt->select()->from("gruplar")->where('baslik', "kurucu", "<>")->result() as $grup) {
                                            echo '<optgroup label="' . $grup->baslik . '">';
                                            foreach ($m_vt->select("`id`,`izinler`,`grup`,`kadi`")->from("kullanicilar")->where('grup', $grup->id)->result() as $kullanici) {
                                                $kullanici->izinler = json_decode($kullanici->izinler, true);
                                                if (isset($kullanici->izinler[$mc_modul_ayar['tablo']]) && in_array($get_kategori->id, $kullanici->izinler[$mc_modul_ayar['tablo']])) {
                                                    echo '<option value="' . $kullanici->id . '" selected>' . $kullanici->kadi . '</option>';
                                                } else {
                                                    echo '<option value="' . $kullanici->id . '">' . $kullanici->kadi . '</option>';
                                                }
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