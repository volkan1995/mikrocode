<?php
if (!defined('m_panel_header')) {
    define("m_panel_header", true);
}
require 'loader.php';
$mc_widgets = $m_vt->select()->from('eklentiler')->where('durum', 1)->where('tip', "index")->result();
?>
<div class="row">
    <div class="clearfix">
        <div class="col-sm-3 col-xs-6">
            <div class="info-box bg-pink hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">import_contacts</i>
                </div>
                <div class="content">
                    <div class="text">Haberler</div>
                    <div class="number count-to">
                        <?= @$m_vt->select()->from('yazilar')->where('tip', 5)->count() ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-xs-6">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">email</i>
                </div>
                <div class="content">
                    <div class="text">Mesajlar</div>
                    <div class="number count-to">
                        <?= @$m_vt->select()->from('mesajlar')->where('tip', 0)->count() ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-xs-6">
            <div class="info-box bg-light-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">notifications_none</i>
                </div>
                <div class="content">
                    <div class="text">Duyurular</div>
                    <div class="number count-to">
                        <?= @$m_vt->select()->from('yazilar')->where('tip', 4)->count() ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-xs-6">
            <div class="info-box bg-orange hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">person</i>
                </div>
                <div class="content">
                    <div class="text">Organizasyon</div>
                    <div class="number count-to">
                        <?= @$m_vt->select()->from('yazilar')->where('tip', 6)->count() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ul class=" clearfix index_widget">  
        <?php
        foreach ($mc_widgets as $widget) {
            $mc_widget_css = m_jsonAl($widget->eklenti, "css", "mc_index_widget_item_2");
            ?>    
            <li class="mc_index_widget_item <?= $mc_widget_css ?>" id="mc_widget_<?= $widget->id ?>" data-id="<?= $widget->id ?>" data-loaded = "false">
                <div class="card">
                    <div class="header">
                        <i class="material-icons mc_move_icon mc_move_icon_abs">flip_to_front</i>
                        <h2 class="mc_widget_h2"><?= mc_dil($widget->baslik) ?></h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);">Gizle</a></li>
                                    <li><a href="javascript:void(0);">Kapat</a></li>
                                    <li role="seperator" class="divider"></li>
                                    <li><a href="javascript:void(0);" onclick="mc_widget_boyut('4', '<?= $widget->id ?>')">Çok Küçük</a></li>
                                    <li><a href="javascript:void(0);" onclick="mc_widget_boyut('3', '<?= $widget->id ?>')">Küçük</a></li>
                                    <li><a href="javascript:void(0);" onclick="mc_widget_boyut('2', '<?= $widget->id ?>')">Orta</a></li>
                                    <li><a href="javascript:void(0);" onclick="mc_widget_boyut('3_t', '<?= $widget->id ?>')">Geniş</a></li>
                                    <li><a href="javascript:void(0);" onclick="mc_widget_boyut('4_t', '<?= $widget->id ?>')">Büyük</a></li>
                                    <li><a href="javascript:void(0);" onclick="mc_widget_boyut('1', '<?= $widget->id ?>')">Çok Büyük</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body mc_widget_body clearfix"></div>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>
<style>
    .mc_move_icon_abs {top: 16px;left: 10px}
    .mc_widget_loading{
        margin: 25px 0 15px 0;
    }
    .mc_widget_body {
        display: none;
        padding: 10px !important;
    }
    .mc_widget_h2{
        text-align: center;
    }
</style>
<?php require mc_sablon . 'footer.php'; ?>
<script>
    function mc_widget_boyut(css, wid) {
        wid = $('#mc_widget_' + wid);
        if (wid.length > 0) {
            wid.attr('class', "mc_index_widget_item mc_index_widget_item_" + css);
        }
    }

    function mc_is_scroll_dom(mc_wd) {
        if ($(mc_wd).length == 0) {
            return false;
        }
        var mc_st = $(window).scrollTop();
        var mc_sb = mc_st + $(window).height();
        var mc_dt = $(mc_wd).offset().top + ($(mc_wd).height() / 2);
        var mc_db = mc_dt + $(mc_wd).height();
        if(m_gelistirici){
            console.log("scrollTop: " + mc_st + " , windowHeight: " + mc_sb + " , widgetMiddle: " + mc_dt + " , widgetBottom: " + mc_db);
        }
        return (mc_sb >= mc_dt && mc_st <= mc_db);
    }
    var mc_preloader = '<div class="preloader"><div class="spinner-layer pl-cyan"><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
    var mc_widget_timer;

    function mc_widget_tara() {
        $.each($(".mc_index_widget_item[data-loaded='false']"), function () {
            var this_widget = $(this);
            var this_widget_id = "#" + this_widget.attr('id');
            if (mc_is_scroll_dom(this_widget_id) == true) {
                this_widget.attr('data-loaded', true);
                this_widget.find('.mc_widget_body').html('<p class="mc_widget_loading">' + this_widget.find(".mc_widget_h2").text() + ' yükleniyor...</p>' + mc_preloader);
                this_widget.find('.mc_widget_body').fadeIn(300);
                $.post(mc_sistem + "eklentiler/widget.php", {id: this_widget.data('id')},
                        function (data) {
                            this_widget.find('.mc_widget_body').html(data);
                            mc_otoimgload();
                        }
                );
            }
        });
    }

    mc_hazir(function () {
        setTimeout(function () {
            mc_widget_tara();
        }, 200);
        $(window).on('scroll', function () {
            clearTimeout(mc_widget_timer);
            mc_widget_timer = setTimeout(function (event) {
                mc_widget_tara();
            }, 200);
        });
    });
</script>