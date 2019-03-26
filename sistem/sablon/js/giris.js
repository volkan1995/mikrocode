if (typeof jQuery === "undefined") { throw new Error("Lütfen jquery kütüphanesini sayfaya çağrınız"); }
$.mcDiger = {};
$.mcDiger.input = {
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
$.mcDiger.select = { aktif: function(){ if($.fn.selectpicker){ $('select:not(.ms)').selectpicker(); } } };
$(function(){
    $.mcDiger.input.aktif();
    $.mcDiger.select.aktif();
    setTimeout(function(){
        $('.page-loader-wrapper').fadeOut();
        Waves.attach('.menu .list a', ['waves-block']);
        Waves.init();
    }, 50);
});