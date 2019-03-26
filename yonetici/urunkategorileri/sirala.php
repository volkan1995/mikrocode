<?php
    if(!defined('m_panel_header')) { define("m_panel_header", true); }
    require '..'.DIRECTORY_SEPARATOR.'loader.php';
    if(mc_yetki($mc_modul_ayar['yetki'])){
        $mc_kategoriler = new mc_liste('sirala');
        $mc_kategoriler->durum = true;
        $mc_kategoriler->sirala = true;
        $mc_kategoriler->sekme = $mc_modul_ayar['sirala_sekme'];
        $mc_kategoriler->veriler = ['table' => $mc_modul_ayar['tablo'],'where' => ['ust' => 0,'tip' => $mc_modul_ayar['tip']], 'orderby' => "sira, id"];
        if (!empty($mt_diller) && !empty($_GET['filtre_dil'])) {
            $mc_kategoriler->veriler = ['table' => $mc_modul_ayar['tablo'],'where' => ['ust' => 0, 'dil' => $_GET['filtre_dil'], 'tip' => $mc_modul_ayar['tip']], 'orderby' => "sira, id"];
        } else {
            $mc_kategoriler->veriler = ['table' => $mc_modul_ayar['tablo'],'where' => ['ust' => 0,'tip' => $mc_modul_ayar['tip']], 'orderby' => "sira, id"];
        }
        ?>
        <form class="row clearfix" id="content-form">
            <div class="col-md-9 col-sm-8 col-xs-12">
                <div class="card">
                    <div class="body dd nestable-with-handle">
                        <?php $mc_kategoriler->olustur(); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12">
                <div class="card">
                    <div class="header"><?=mc_ustmenu($mc_modul_ayar['menu'],$mc_headtitle)?></div>
                    <div class="body">
                    <div class="m-b-10">
                        <select name="filtre_dil" class="form-control show-tick filtre_dil">
                            <?php
                            if (!empty($mt_diller)) {
                                foreach ($mt_diller as $dil => $tanimlar) {
                                    if (!isset($tanimlar['dil'])) {
                                        continue;
                                    }
                                    if ($_GET['filtre_dil'] == $dil) {
                                        echo '<option value="' . $dil . '" selected>' . $tanimlar['dil'] . '</option>';
                                        continue;
                                    }
                                    echo '<option value="' . $dil . '">' . $tanimlar['dil'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="m-b-20">
                        <a href="javascript:void(0)" class="btn btn-sm btn-theme waves-effect" onclick="sirala_getir();"><?= mc_dil('listele') ?></a>
                    </div>
                    <button type="submit" class="btn btn-sm btn-theme waves-effect"><?= mc_dil('kaydet') ?></button>
                    <input type="hidden" class="ddtextarea" name="sira"/>             
                    </div>
                </div>
            </div>
        </form>
    <?php } require_once mc_sablon.'footer.php'; ?>
    <script>     
        mc_loadJs("<?=mc_plugins?>nestable/jquery.nestable.js").done(function (){
            $('.dd').nestable({maxDepth: <?=$mc_kategoriler->sekme?>});
            $('.dd').on('change', function () {
                $('.ddtextarea').val(window.JSON.stringify($(this).nestable('serialize')));
            });
        });
        function sirala_getir() {
            var fullurl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            var kategori_id = $('.filtre_dil option:selected').val();
            window.location.href = fullurl + "?filtre_dil=" + kategori_id;
        }
    </script>
