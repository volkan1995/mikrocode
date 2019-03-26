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
            <div class="body">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" class="form-control" name="baslik" value="<?= $get_eklentiler->baslik ?>" required/>
                        <label class="form-label">Başlık Giriniz <b>*</b></label>
                    </div>
                </div>
            </div>
            <div class="body body_editor">
                <pre id="mc_temaEditor"><?= htmlentities($eklenti_icerik) ?></pre>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-4 col-xs-12">
        <div class="card">
            <div class="body">
                <button type="submit" class="btn btn-sm btn-theme waves-effect"><?= mc_dil('kaydet') ?></button>
                <input type="hidden" name="id" value="<?= $get_eklentiler->id ?>" />
                <div class="switch m-t-20">
                    <b class="mc_sw_b80">Yayın</b>
                    <label><input name="yayin" type="checkbox"<?= $get_eklentiler->durum == 1 ? " checked" : null ?>/><span class="lever switch-col-theme"></span></label>
                </div>                
                <div class="m-t-20">
                    <h4>Bilgiler</h4>
                    <?php
                    if(is_numeric($get_eklentiler->tabloid)){
                        if ($get_eklentiler->tabloid == 0) {
                            echo '<p><b>Bölüm : </b>Yönetici</p>';
                        }else if ($get_eklentiler->tabloid == 1) {
                            echo '<p><b>Bölüm : </b>Sistem</p>';
                        }
                        echo '<p><b>Modül : </b>' . mc_dil($get_eklentiler->icerik) . '</p>';
                        if ($get_eklentiler->tip == "index") {
                            echo '<p><b>Görev : </b>Widget</p>';
                        } else {
                            echo '<p><b>Görev : </b>' . mc_dil($get_eklentiler->tip) . '</p>';
                        }
                        echo '<p><b>Kimlik : </b>' . $get_eklentiler->tabload . '</p>';                        
                    }
                    if (count($get_eklentiler->eklenti)) {
                        echo '<div class="m-t-20"><b>Özellikler</b>';
                        foreach ($get_eklentiler->eklenti as $key => $value) {
                            echo '<p><b>' . mc_dil($key) . ' : </b>' . $value . '</p>';
                        }
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</form>
<?php require mc_sablon . 'footer.php'; ?>
<script>
    var editor;
    mc_loadJs("<?= mc_plugins ?>ace/ace.js").done(function () {
        editor = ace.edit("mc_temaEditor");
        ace.config.set('basePath', '<?= mc_plugins ?>ace');
        ace.config.set('modePath', '<?= mc_plugins ?>ace');
        ace.config.set('themePath', '<?= mc_plugins ?>ace');
        editor.setTheme("ace/theme/<?= $mc_editorSbln ?>");
        editor.getSession().setMode("ace/mode/php");
        editor.$blockScrolling = Infinity;
        editor.setShowPrintMargin(false);
        editor.setReadOnly(true);
    });
</script>
