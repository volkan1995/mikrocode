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
                            <li class="multi-lang-copy-li"><span type="submit" class="btn btn-circle-xs btn-link waves-effect"><i class="material-icons">swap_horiz</i></span></li>
                        </ul>
                        <div class="tab-content">
                            <?php
                            $dil_tf = true;
                            foreach ($mt_diller as $dil => $tanimlar) {
                                if ($dil_tf) {
                                    echo '<fieldset role="tabpanel" data-dil="' . $dil . '" class="row tab-pane fade active in" id="form_' . $dil . '">';
                                    $dil_tf = false;
                                } else {
                                    echo '<fieldset role="tabpanel" data-dil="' . $dil . '" class="row tab-pane fade" id="form_' . $dil . '">';
                                }
                                ?>
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
                                <?php
                                echo "</fieldset>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    mc_hazir(function () {
        $("form").each(function () {
            if ($(this).find("fieldset[data-dil]").length > 0) {
                var data_dil = null;
                $(this).find("fieldset[data-dil]").each(function () {
                    var this_fieldset = $(this);
                    data_dil = this_fieldset.data('dil');
                    if (this_fieldset.find(".mc_ds").length > 0) {
                        this_fieldset.find(".mc_ds").each(function () {
                            $(this).attr('id', $(this).attr('id') + "_" + data_dil);
                            if ($(this).find("[data-isim]").length == 1) {
                                var data_isim = $(this).find("[data-isim]");
                                data_isim.data('name', "diller[" + data_dil + "][" + data_isim.data('isim') + "]");
                                data_isim.data('isim', data_isim.data('isim') + "_" + data_dil);
                                data_isim.attr('data-isim', data_isim.data('isim'));
                            }
                        });
                    }
                    this_fieldset.find("*:not(div)[name]").each(function () {
                        $(this).attr('name', "diller[" + data_dil + "][" + $(this).attr('name') + "]");
                    });
                    if (this_fieldset.find(".m_editor").length > 0) {
                        this_fieldset.find(".m_editor").each(function () {
                            $(this).attr('dil', data_dil);
                        });
                    }
                });
            }
        });
        
        $(".nav > li.multi-lang-copy-li").click(function () {
            var secili_field = $('fieldset.active');
            secili_field.find("#mcd_secililer[data-grup]").each(function () {
                var secili_input = this;
                $('#mcd_secililer[data-grup="'+$(secili_input).data('grup')+'"]').not(secili_input).each(function () {                    
                    var eski_name = $(this).find("input").attr('name');                    
                    $(this).html($(secili_input).html());
                    $(this).find("input").attr('name',eski_name)
                });
            });
            
            secili_field.find("select[data-grup]").each(function () {
                var secili_input = this;
                $('select[data-grup="'+$(secili_input).data('grup')+'"]').not(secili_input).each(function () {
                    $(this).find("option").eq($(secili_input).index() - 1).change();
                });
            });
            
        });

    });
</script>
<?php
require mc_sablon . 'footer.php';
