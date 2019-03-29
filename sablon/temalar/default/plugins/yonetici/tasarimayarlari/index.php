<style>
    .mt_colorpicker{ cursor: crosshair; position: relative; z-index: 0; display: inline-block; }
    .mt_colorpicker:hover{ outline: #555 solid 2px !important; }
    .mt_design_body{position: relative; display: inline-block; float: left;}
    .mt_design_body .material-icons{ font-size: 1.6em; overflow: hidden; position: relative; margin: -4px 4px 0 4px; display: inline-flex; vertical-align: middle; }
    .mt_design_body .tema_input_ackapa{cursor:pointer;}
    .mt_design_body input{display:none; position: absolute; left: -2px;top: -7px;border-radius: 0;text-align: center;width: 104%; width: calc(100% + 4px);}
    .mt_colorpicker > span{background-color: transparent !important;}
    .colorpicker{ margin-top: 2px !important; margin-left: 55px; }
    
    /* Özel Alanlar */
    .mt_design_body{background-color: <?= $tema_ayar['renkler']['body'] ?>; color:<?= $tema_ayar['renkler']['color'] ?>;}
    .tema_banner{background-image: url('<?= $tema_banner ?>');background-size: cover;}
    .tema_backcolor{background-color: <?= $tema_ayar['renkler']['backcolor'] ?>;color:#fff;}
    .tema_backcolor_hover{background-color: <?= $tema_ayar['renkler']['backcolor_alt'] ?>;color:#fff;}
    .tema_color_alt{color:<?= $tema_ayar['renkler']['color_alt'] ?>}
    .tema_banner p{color: <?= $tema_ayar['renkler']['banner_color'] ?>;}
    .tema_navbar{background-color: <?= $tema_ayar['renkler']['navbar'] ?>}
    .menu_renk{color: <?= $tema_ayar['renkler']['navbar_color'] ?>}
    .menu_hover_renk{color: <?= $tema_ayar['renkler']['navbar_color_alt'] ?>}    
</style>
<form class="clearfix" id="content-form">
    <div class="card">
        <div class="col-md-12 p-t-10">
            <b class="left font-20">Tema Renklerini Düzenle</b>
            <button type="submit" class="submit btn btn-sm btn-theme waves-effect right"><?= mc_dil('kaydet') ?></button>
        </div>
    </div>
    <div class="mt_design_body clearfix m-b-30">
        <div class="col-md-12 p-t-25 p-b-25 tema_navbar">
            <span class="menu_renk">
                <span class="mt_colorpicker" data-fill=".tema_navbar" data-tip="backcolor" data-name="navbar">
                    <span>Menü Arkaplanı</span>
                    <input type="text" class="form-control tema_input_navbar" name="navbar" value="<?= $tema_ayar['renkler']['navbar'] ?>" required=""/>
                </span>
                <i class="material-icons tema_input_ackapa" data-input=".tema_input_navbar">arrow_drop_down</i>                            
            </span>
            <span class="right m-l-20 menu_hover_renk">
                <span class="mt_colorpicker" data-fill=".menu_hover_renk" data-tip="color" data-name="navbar_color_alt">
                    <span>Menü Fare Hareketi</span>
                    <input type="text" class="form-control tema_input_navbar_color_alt" name="navbar_color_alt" value="<?= $tema_ayar['renkler']['navbar_color_alt'] ?>" required=""/>
                </span>
                <i class="material-icons tema_input_ackapa" data-input=".tema_input_navbar_color_alt">arrow_drop_down</i>  
            </span>                        
            <span class="right menu_renk">
                <span class="mt_colorpicker" data-fill=".menu_renk" data-tip="color" data-name="navbar_color">
                    <span>Menü 1 | Menü 2</span>
                    <input type="text" class="form-control tema_input_navbar_color" name="navbar_color" value="<?= $tema_ayar['renkler']['navbar_color'] ?>" required=""/>
                </span>
                <i class="material-icons tema_input_ackapa" data-input=".tema_input_navbar_color">arrow_drop_down</i>  
            </span>
        </div>
        <div class="col-md-12 p-t-90 p-b-90 m-b-25 tema_banner">
            <p class="text-center font-18">                           
            <i class="material-icons tema_input_ackapa" data-input=".tema_input_banner_color">arrow_drop_down</i> 
            <br/>
            <span class="mt_colorpicker" data-fill=".tema_banner p" data-tip="color" data-name="banner_color">
                <span>Banner Slogan Yazısı<br/>Renk ayarı</span>
                <input type="text" class="form-control tema_input_banner_color" name="banner_color" value="<?= $tema_ayar['renkler']['banner_color'] ?>" required=""/>
            </span>
            </p>
        </div>
        <div class="col-md-4 m-t-15 text-center">
            <div class="col-md-12 p-t-20 p-b-20 tema_backcolor">                        
                <span class="mt_colorpicker" data-fill=".tema_backcolor" data-name="backcolor" data-tip="backcolor">
                    <span>Yazı arkaplanı</span>
                    <input type="text" class="form-control tema_input_backcolor" name="backcolor" value="<?= $tema_ayar['renkler']['backcolor'] ?>" required=""/>
                </span>
                <i class="material-icons tema_input_ackapa" data-input=".tema_input_backcolor">arrow_drop_down</i>  
            </div>
            <div class="col-md-12 p-t-40 p-b-40">
                <span class="mt_colorpicker" data-fill=".mt_design_body" data-name="body" data-tip="backcolor">
                    <span>Sayfa arkaplanı</span>
                    <input type="text" class="form-control tema_input_body" name="body" value="<?= $tema_ayar['renkler']['body'] ?>" required=""/>
                </span>
                <i class="material-icons tema_input_ackapa" data-input=".tema_input_body">arrow_drop_down</i>
            </div>
        </div>
        <div class="col-md-4 m-t-15 text-center">
            <div class="col-md-12 p-t-20 p-b-20 tema_backcolor">
                <span>Başlık</span>
            </div>
            <div class="col-md-12 p-t-40 p-b-40">
                <span>Yazı</span>
            </div>
        </div>
        <div class="col-md-4 m-t-15 text-center">
            <div class="col-md-12 p-t-20 p-b-20 tema_backcolor_hover">
                <span class="mt_colorpicker" data-fill=".tema_backcolor_hover" data-name="backcolor_alt" data-tip="backcolor">
                    <span>Fare Hareketi</span>
                    <input type="text" class="form-control tema_input_backcolor_alt" name="backcolor_alt" value="<?= $tema_ayar['renkler']['backcolor_alt'] ?>" required=""/>
                </span>
                <i class="material-icons tema_input_ackapa" data-input=".tema_input_backcolor_alt">arrow_drop_down</i>
            </div>
            <div class="col-md-12 p-t-40 p-b-40">                            
                <span class="mt_colorpicker tema_color_alt" data-fill=".tema_color_alt" data-name="color_alt" data-tip="color">
                    <span>Bağlantı renkleri</span>
                    <input type="text" class="form-control tema_input_color_alt" name="color_alt" value="<?= $tema_ayar['renkler']['color_alt'] ?>" required=""/>
                </span>
                <i class="material-icons tema_input_ackapa" data-input=".tema_input_color_alt">arrow_drop_down</i>
            </div>
        </div>
        <div class="col-md-12 text-center" style="padding:50px 23% 130px 23%;">
            <i class="material-icons tema_input_ackapa" data-input=".tema_input_color">arrow_drop_down</i>
            <br/>
            <span class="mt_colorpicker" data-fill=".mt_design_body" data-name="color" data-tip="color">
                <span>Lorem Ipsum pasajlarının birçok çeşitlemesi vardır. Ancak bunların büyük bir çoğunluğu mizah katılarak veya rastgele...</span>
                <input type="text" class="form-control tema_input_color" name="color" value="<?= $tema_ayar['renkler']['color'] ?>" required=""/>
            </span>
        </div>
        <div class="col-md-12 text-center p-b-20">
            © 2019 Tüm telif hakları saklıdır <a href="<?=m_firma_url?>" class="tema_color_alt" target="_blank"><?=m_firma?></a>
        </div>
    </div>
</form>
<script>
    mc_loadJs("<?= mc_plugins ?>bootstrap-colorpicker/js/bootstrap-colorpicker.min.js").done(function () {
        mc_loadCss("<?= mc_plugins ?>bootstrap-colorpicker/css/bootstrap-colorpicker.min.css")
        var hedef_fill = null;
        $('.mt_colorpicker').colorpicker({'component': "span"}).on('changeColor', function (event) {
            if (typeof $(this).data('fill') != 'undefined') {
                hedef_fill = $($(this).data('fill'));
            } else {
                hedef_fill = $(this);
            }
            if (typeof $(this).data('tip') == 'undefined' || $(this).data('tip') == "color") {
                hedef_fill.css({'color': event.color.toString()});
            } else {
                hedef_fill.css({'background-color': event.color.toString()});
            }
            $("input[name='" + $(this).data('name') + "']").val(event.color.toHex());
            delete(event);
        });

        $('.tema_input_ackapa').on('click', function (e) {
            hedef_input = $($(this).data('input'));
            hedef_input.slideToggle(200);
        });
    });
</script>
