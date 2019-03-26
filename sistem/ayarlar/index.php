<?php
if (!defined('m_sistem_header')) {
    define("m_sistem_header", true);
}
require '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'yonetici' . DIRECTORY_SEPARATOR . 'loader.php';
if (!isset($mc_menu)) {
    $mc_menu = new mc_menu();
    $mc_genelayarlar = $mc_menu->menu_sec(['ayarlar', 0]);
}
?>
<div class="row clearfix">
    <form class="col-md-8 col-xs-12" method="POST" id="settings-form" data-dir="ayarlar">
        <div class="settings-div">
            <div class="col-md-12 col-xs-12 settings-head"><h4></h4><?= mc_ustmenu("ayarlar", $mc_headtitle, true, false) ?></div>
            <div class="col-md-12 col-xs-12 settings-body"></div>
            <div class="col-md-12 col-xs-12 settings-footer"></div>
        </div>
    </form>

    <div class="col-md-4 col-xs-12">
        <div class="settings-list">
            <?php
            if (!empty($mc_genelayarlar) && isset($mc_genelayarlar->gorev) && is_array($mc_genelayarlar->gorev)) {
                foreach ($mc_genelayarlar->gorev as $altmenu) {
                    if (!m_gelistirici && isset($altmenu->gelistirici) && $altmenu->gelistirici == true) {
                        continue;
                    }
                    if (isset($altmenu->admin) && $altmenu->admin && $mc_oturum->grup > 2) {
                        continue;
                    }
                    if (isset($altmenu->gorev) && is_string($altmenu->gorev) && strpos($altmenu->gorev, "#") == true) {
                        $mc_ayar_diez = explode("#", $altmenu->gorev)[1];
                        echo '<a href="' . $mc_ayar_diez . '" class="setting-list waves-effect waves-block" id="setting_' . $mc_ayar_diez . '" mcp_tip="ayar">';
                        echo '<i class="material-icons">' . $altmenu->ikon . '</i><span>' . mc_dil($altmenu->baslik) . '</span>';
                        echo '</a>';
                    }
                }
            } else if ($mc_oturum->grup < 3) {
                echo '<a href="gelismis_ayarlar" class="setting-list waves-effect waves-block" id="setting_gelismis_ayarlar" mcp_tip="ayar">';
                echo '<i class="material-icons">perm_data_setting</i><span>' . mc_dil('gelismis_ayarlar') . '</span>';
                echo '</a>';
            }
            ?>
        </div>
    </div>
</div>
<script>
    var this_btn_h = null;
    var this_btn_t = null;
    var last_sslistbtn = null;
    mc_hazir(function () {
        mc_loadCss("<?= mc_plugins ?>bootstrap-tagsinput/bootstrap-tagsinput.css?v=1");
        mc_loadJs("<?= mc_plugins ?>bootstrap-tagsinput/bootstrap-tagsinput.min.js?v=1").done(function () {
            $(document).on('click', '.setting-list', function (e) {
                if (mc_FKaydetTF == true) {
                    NProgress.start();
                    var this_btn = $(this);
                    mc_FKaydetTF = false;
                    $(".setting-list").removeClass("active");
                    last_sslistbtn = "#" + this_btn.attr("id") + " > span";
                    var last_sslistspn = $(last_sslistbtn).text();
                    $(".settings-head > h4").html(this_btn.html());
                    $(last_sslistbtn).text(mcd_lutfen_bekleyiniz + "...");
                    history.pushState(null, null, window.location.pathname + '#' + this_btn.attr("href"));
                    this_btn_h = this_btn.attr("href");
                    this_btn_t = this_btn.attr("mcp_tip");
                    $.post(mc_sistem + "ayarlar/aktar.php", {mcp_adres: this_btn_h, mcp_tip: this_btn_t},
                    function (data) {
                        $('.settings-body').empty().html(data);
                        $(last_sslistbtn).text(last_sslistspn);
                        $('title').text(last_sslistspn + " | Yönetim Paneli");
                        mc_FKaydetTF = true;
                        setTimeout(function () {
                            this_btn.addClass("active");
                        }, 200);
                        mc_elementTara();
                        NProgress.done();
                    }
                    );
                }
                return false;
            });
            var ayar_diez = $(location).attr('hash').substr(1);
            if (ayar_diez.length > 0) {
                $("#setting_" + ayar_diez).trigger("click");
            } else {
                $(".setting-list:first").trigger("click");
            }
        });
    });
</script>
<?php
require mc_sablon . 'footer.php';
