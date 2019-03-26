if (typeof jQuery === "undefined") { throw new Error("Lütfen jquery kütüphanesini sayfaya çağrınız"); }
$.mcKurulum = {};
$.mcKurulum.solMenu = {
    aktif: function () {
        var _this = this;
        var $body = $('body');
        var $overlay = $('.overlay');
        $(window).click(function (e) {
            var $target = $(e.target);
            if (e.target.nodeName.toLowerCase() === 'i') { $target = $(e.target).parent(); }
            if (!$target.hasClass('bars') && _this.isOpen() && $target.parents('#leftsidebar').length === 0) {
                if (!$target.hasClass('js-right-sidebar')) $overlay.fadeOut();
                $body.removeClass('overlay-open');
            }
        });
        $.each($('.menu-toggle.toggled'), function(i, val){ $(val).next().slideToggle(0); });
        $.each($('.menu .list li.active'), function (i, val) {
            var $activeAnchors = $(val).find('a:eq(0)');
            $activeAnchors.addClass('toggled');
            $activeAnchors.next().show();
        });
        $('.menu-toggle').on('click', function (e) {
            var $this = $(this);
            var $content = $this.next();
            if ($($this.parents('ul')[0]).hasClass('list')) {
                var $not = $(e.target).hasClass('menu-toggle') ? e.target : $(e.target).parents('.menu-toggle');
                $.each($('.menu-toggle.toggled').not($not).next(), function (i, val) {
                    if($(val).is(':visible')){
                        $(val).prev().toggleClass('toggled');
                        $(val).slideUp();
                    }
                });
            }
            $this.toggleClass('toggled');
            $content.slideToggle(320);
        });
        _this.solMenuResponsive(true);
        $(window).resize(function(){ _this.solMenuResponsive(false); });
        Waves.attach('.menu .list a', ['waves-block']);
        Waves.init();
    },
    solMenuResponsive: function (durum) {
        var $body = $('body');
        var $openCloseBar = $('.navbar .navbar-header .bars');
        var width = $body.width();
        if(durum){
            $body.find('.content, .sidebar').addClass('no-animate').delay(1000).queue(function(){  $(this).removeClass('no-animate').dequeue(); });
        }
        if(width < 768){
            $body.addClass('ls-closed');
            $openCloseBar.fadeIn();
        }else{
            $body.removeClass('ls-closed');
            $openCloseBar.fadeOut();
        }
    },
    isOpen: function(){ return $('body').hasClass('overlay-open'); }
};
$.mcKurulum.input = {
    aktif: function () {
        $('.form-control').focus(function(){ $(this).parent().addClass('focused'); });
        $('.form-control').focusout(function () {
            var $this = $(this);
            if ($this.parents('.form-group').hasClass('form-float')) { if($this.val() == '') { $this.parents('.form-line').removeClass('focused'); } }
            else{ $this.parents('.form-line').removeClass('focused'); }
        });
        $('body').on('click', '.form-float .form-line .form-label', function(){ $(this).parent().find('input').focus(); });
        $('.form-control').each(function(){ if($(this).val() !== ''){ $(this).parents('.form-line').addClass('focused'); } });
    }
};
$.mcKurulum.select = { aktif: function(){ if($.fn.selectpicker){ $('select:not(.ms)').selectpicker(); } } };
$.mcKurulum.zaman = { fark: function(z){
    if(z > 60000){
        return Math.floor(z / (60000)) + " dk"; 
    }else if(z > 1000){
        return Math.floor(z / 1000) + " sn"; 
    }else{
        return z + " ms"; 
    }
}};
var mc_tablo = 0;
var mc_yuzde = 2;
var mc_yuzdeStr = "2%";
var mc_kurulumBar;
var mc_postjson;
var mc_ilkadim = false;
$.mcKurulum.basla = {
    aktif: function(){
        if(mc_ilkadim === false){
            $('#kurulum5_rapor').html(mc_kurulumAdim1);
            $('#kurulum5_1_rapor > div').append(mc_kurulumAdim1);
            mc_kurulumBar = $('#mc_kurulumBar');
            mc_kurulumBar.css({'width':mc_yuzdeStr});
            mc_kurulumBar.text(mc_yuzdeStr);
            mc_ilkadim = true;
        }
        $.post(mc_kurulumUrl,
            {yuzde:mc_yuzde,tablo:mc_tablo},
            function(d){
                mc_postjson = JSON.parse(d);
                mc_yuzde = parseInt(mc_postjson.yuzde);
                mc_tablo = parseInt(mc_postjson.tablo);
                mc_rapor = mc_postjson.rapor;
                mc_hareket = mc_postjson.hareket;
                mc_yuzdeStr = mc_yuzde + "%";
                mc_kurulumBar.css({'width':mc_yuzdeStr});
                mc_kurulumBar.text(mc_yuzdeStr);
                $('#kurulum5_rapor').html(mc_rapor);
                $('#kurulum5_1_rapor > div').append("<p>" + mc_hareket + "</p>");
                $('#kurulum5_1_rapor > div').animate({ scrollTop: 9999 }, 0);
                if(mc_yuzde < 100){
                    if(mc_yuzde >= 98){
                        mc_kurulumBar.removeClass('bg-light-blue');
                        mc_kurulumBar.addClass('bg-green');
                    }
                    setTimeout(function(){ $.mcKurulum.basla.aktif(); }, 200);
                }else{
                    mc_kurulumBar.removeClass('bg-light-blue');
                    mc_kurulumBar.removeClass('bg-green');
                    mc_kurulumBar.removeClass('progress-bar-striped');
                    mc_kurulumBar.removeClass('active');
                    mc_kurulumBar.addClass('progress-bar-success');
                    $('#kurulum5_1_rapor > div').append("<p>Kurulum süresi: " + $.mcKurulum.zaman.fark((new Date() - mc_kurulum_it)) + "</p>");
                }
                mc_kurulum_st = new Date();
            }
        );
    }
};
$(function(){
    $.mcKurulum.solMenu.aktif();
    $.mcKurulum.input.aktif();
    $.mcKurulum.select.aktif();
    setTimeout(function(){ $('.page-loader-wrapper').fadeOut(); }, 50);
});