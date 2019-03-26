<?php
    if(!defined('m_panel_header')) { define("m_panel_header", true); }
    require '..'.DIRECTORY_SEPARATOR.'loader.php';
    if(mc_yetki($mc_modul_ayar['menu'])){
        $mc_yazilar = new mc_liste('sirala');
        $mc_yazilar->durum = true;
        $mc_yazilar->sirala = true;
        $mc_yazilar->aciklama = false;
        $mc_yazilar->sekme = $mc_modul_ayar['sirala_sekme'];
        $mc_yazilar->veriler = ['table' => $mc_modul_ayar['tablo'],'where' => ['tip' => $mc_modul_ayar['tip']], 'orderby' => "sira, id"];
        ?>
        <form class="row clearfix" id="content-form">
            <div class="col-md-9 col-sm-8 col-xs-12">
                <div class="card">
                    <div class="body dd nestable-with-handle">
                        <?php $mc_yazilar->olustur(); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12">
                <div class="card">
                    <div class="header"><?=mc_ustmenu($mc_modul_ayar['menu'],$mc_headtitle)?></div>
                    <div class="body">
                        <button type="submit" class="btn btn-sm btn-theme waves-effect"><?=mc_dil('kaydet')?></button>
                        <input type="hidden" class="ddtextarea" name="sira"/>             
                    </div>
                </div>
            </div>
        </form>
    <?php } require_once mc_sablon.'footer.php'; ?>
    <script>     
        mc_loadJs("<?=mc_plugins?>nestable/jquery.nestable.js").done(function (){
            $('.dd').nestable({maxDepth: <?=$mc_yazilar->sekme?>});
            $('.dd').on('change', function () {
                $('.ddtextarea').val(window.JSON.stringify($(this).nestable('serialize')));
            });
        });
    </script>
