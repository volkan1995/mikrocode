<?php
if (!defined('m_sistem_header')) {
    define("m_sistem_header", true);
}
require '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'yonetici' . DIRECTORY_SEPARATOR . 'loader.php';
?>
<div class="row clearfix">    
    <div class="col-xs-12">
        <div class="card">
            <div class="header">
                <h2><?= mc_ustmenu("ayarlar", mc_dil('tema_duzenle') . ": " . $_GET['tema_isim'] . '<i id="mc_tema_isim_yaz"></i>', true) ?></h2>
                <form class="m-t-20" id="content-form">
                    <div class="input-group" style="margin-bottom:0;">
                        <select name="tema_sayfa" class="form-control show-tick" id="tema_sayfa" onchange="mc_temaduzenle_yukle();">
                            <?= $tema_sayfalar ?>
                        </select>
                        <span class="input-group-addon" style=" padding: 0; padding-left: 5px;">
                            <button type="submit" class="btn btn-sm btn-default waves-effect"><?= mc_dil('kaydet') ?></button>
                            <input type="hidden" id="tema_isim" name="tema" value="<?=$_GET['tema_isim']?>" />
                        </span>
                    </div>
                </form>
            </div>

            <div class="body body_editor">
                <pre id="mc_temaEditor"></pre>
            </div>
        </div>
    </div>
</div>
<?php require mc_sablon . 'footer.php'; ?>
<script>
    var editor;
    mc_loadJs("<?= mc_plugins ?>ace/ace.js").done(function () {
        editor = ace.edit("mc_temaEditor");
        ace.config.set('basePath', '<?= mc_plugins ?>ace');
        ace.config.set('modePath', '<?= mc_plugins ?>ace');
        ace.config.set('themePath', '<?= mc_plugins ?>ace');
        editor.setTheme("ace/theme/<?= $mc_editorSbln ?>");
        editor.setShowPrintMargin(false);
        editor.$blockScrolling = Infinity;
        /* editor.setReadOnly(true);*/
        $("#tema_sayfa").trigger('change');
    });
    
    function mc_temaduzenle_yukle() {
        if (mc_FKaydetTF) {
            editor.setReadOnly(true);
            mc_FKaydetTF = false;
            var secili_tema_opt = $("#tema_sayfa option:selected");
            $.post(mc_sistem + "temalar/duzenle.php", {tema: $('#tema_isim').val(), tema_sayfa: secili_tema_opt.val()},
            function (data) {
                editor.setValue(data, -1);
                editor.getSession().setMode("ace/mode/" + secili_tema_opt.data('ext'));
                $('#mc_tema_isim_yaz').html("<b>" + secili_tema_opt.data('ext') + "</b> &rarr; " + secili_tema_opt.text());
                mc_FKaydetTF = true;
                editor.setReadOnly(false);
            }
            );
        }
    }
    
    function form_kontrol(){
        post_array['icerik'] = editor.getValue();
    }
    
</script>