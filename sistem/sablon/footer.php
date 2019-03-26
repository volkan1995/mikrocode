<?php
if (!isset($_POST['mc_js'])) {
    echo '</div><div id="post_sonuc" style="display:inherit"></div>';
    if ($mc_muzikcalar) {
        include mc_yardimcilar . "muzikcalar" . DIRECTORY_SEPARATOR . "footer.php";
    }
    ?>        
    </section>
    <script src="<?= mc_plugins ?>bootstrap/js/bootstrap.js?v=2"></script>
    <script src="<?= mc_js ?>admin.js?v=26"></script>
    <script src="<?= mc_js ?>demo.js?v=26"></script>
    <link href="<?= mc_css ?>nprogress.css?v=2" rel="stylesheet" type="text/css"/>
    <link href="<?= mc_plugins ?>node-waves/waves.min.css?v=2" rel="stylesheet" />
    <script src="<?= mc_js ?>nprogress.js?v=2" type="text/javascript" defer="defer"></script>
    <script src="<?= mc_plugins ?>node-waves/waves.min.js?v=2" defer="defer"></script>
    <script src="<?= mc_plugins ?>bootstrap-notify/bootstrap-notify.min.js?v=4" defer="defer"></script>
    <script>
        function mc_otoimgload() {
            $("img.otoload").each(function () {
                $(this).attr('src', $(this).data('src'));
            });
        }
        mc_hazir(function () {
            mc_loadCss(mc_plugins + "bootstrap-select/css/bootstrap-select.css?v=3");
            mc_loadJs(mc_plugins + "bootstrap-select/js/bootstrap-select.min.js?v=2").done(function () {
                $.mcPanel.select.aktif();
            });
            mc_loadJs("<?= mc_js ?>pages/files/sesoynatici.js?v=1").done(function () {
                if ($('audio').not(".mc_muzikc audio, .mc_apl_ok").length > 0) {
                    $('audio').not(".mc_muzikc audio, .mc_apl_ok").mc_apl();
                }
            });
            mc_loadCss("https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext");
            mc_loadCss(mc_plugins + "material-fonts/css/font.css?v=2");
            mc_loadJs(mc_plugins + "nestable/mc.drag.js?v=9").done(function () {
                if ($('.index_widget').length > 0) {
                    $('.index_widget').suruklebirak({selector: ".mc_index_widget_item"});
                }
                if ($('.mcd_galeri_drag').length > 0) {
                    $('.mcd_galeri_drag').suruklebirak({
                        moveClass: ".mcd_baslik span",
                        trigger: 10
                    });
                }
            });
            $(document).on('click', '.ekran_alintisi_btn', function (e) {
                var datacrop = $(this).data('crop');
                if (datacrop.length > 0) {
                    mc_loadJs(mc_plugins + "html2canvas/html2canvas.min.js").done(function () {
                        $('body:not(.ls-closed) section.content').attr({'style': 'margin: 80px 15px 0 270px'});
                        $('.overlay').css({'display': 'none'});
                        $('#rightsidebar').removeClass('open');
                        setTimeout(function () {
                            html2canvas(document.querySelector(datacrop)).then(canvas => {
                                var fkl = document.createElement('a');
                                fkl.href = canvas.toDataURL("image/png");
                                fkl.download = $('title').text();
                                document.body.appendChild(fkl);
                                fkl.click();
                                document.body.removeChild(fkl);
                                delete fkl, canvas;
                                $('section.content').removeAttr('style');
                            });
                        }, 100);
                    });
                }
                delete datacrop;
            });
            mc_otoimgload();
        });
        var mc_sohbet_ayarlar = {
            kullanici_adi: "<?= $mc_oturum->kadi ?>",
            kullanici_id: <?= mc_oturum_id ?>,
            api_anahtari: "<?= m_host ?>",
            giris_kapisi: 0,
            listele_url: "<?= m_domain ?>/sistem/yardimcilar/sohbet/_listele.php",
            gonder_url: "<?= m_domain ?>/sistem/yardimcilar/sohbet/_gonder.php"
        };
    </script>
    <!-- <script src="https://otomasyon.mikrocode.net/eklentiler/mcsohbet.js?v=2" defer="defer"></script>-->
    <div class="modal fade" id="mc_m_dy" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document"><div class="modal-content" id="mc_m_dyc"></div></div>
    </div>
    <?php
    if (m_gelistirici > 0) {
        if (m_jsonAl($m_ayarlar->ayar, "mckv") == 1) {
            include mc_yardimcilar . "footer.php";
        }
        //include mc_yardimcilar . "sohbet" . DIRECTORY_SEPARATOR . "panel.php";
    }
    ?>
    <script>
        mc_hazir(function () {
            $("#mc_sure_sunucu").text("<?= round(abs(mc_microzaman() - $mc_microT1) * 1000) ?>");
            $("#mc_sure_sayfa").text((Date.now() - mc_timerStart));
            $("#mc_boyut_sayfa").text(Math.round(document.getElementsByTagName('*')[0].outerHTML.length / 1024));
            delete mc_timerStart;
        });
    </script>
    <?php
    echo '</body></html>';
}