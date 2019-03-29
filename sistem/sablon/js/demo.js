mc_js_icerik = $('#mc_js_icerik');
$(".nav > li.multi-lang-copy-li").click(function () {
    var secili_field = $('form fieldset.active');
    var diger_fields = $('form fieldset:not(.active)');
    diger_fields.each(function () {
        var diger_field = $(this);
        for (var i = 0; i < secili_field.find('.mc_ds').length; i++) {
            var secili_td = secili_field.find('.mc_ds').eq(i);
            var diger_td = diger_field.find('.mc_ds').eq(i);
            diger_td.find('.mcd_secililer').empty();
            for (var j = 0; j < secili_td.find('.mcd_secililer > *').length; j++) {
                var secili_d = secili_td.find('.mcd_secililer > *').eq(j);
                secili_d.clone().appendTo(diger_td.find('.mcd_secililer'));
                diger_td.find('.mcd_secililer > *').find('input').each(function () {
                    $(this).attr('name', $(this).attr('name').toString().replace("diller[" + secili_field.data('dil') + "]", "diller[" + diger_field.data('dil') + "]"));
                });
                delete secili_d;
            }            
            delete secili_td, diger_td;
        }
        for (var i = 0; i < secili_field.find('select').length; i++) {
            var secili_select = secili_field.find('select').eq(i).find('option:selected');
            diger_field.find('select').eq(i).find("option").eq(secili_select.index()).attr("selected", true).change();
            delete secili_select;
        }
        for (var i = 0; i < secili_field.find('input').length; i++) {
            var secili_input = secili_field.find('input').eq(i);
            var diger_input = diger_field.find('input').eq(i);
            if (secili_input.attr('type') == "checkbox" || secili_input.attr('type') == "radio") {
                diger_input.prop('checked', secili_input.prop('checked'));
            } else {
                diger_input.val(secili_input.val());
            }
            delete secili_input, diger_input;
        }
        delete diger_field;
    });
    diger_fields.find('select').selectpicker('refresh');
    delete secili_field, diger_fields;
});
document.addEventListener("keydown", function(e) {
    last_keycode = e.keyCode;
    if((window.navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)  && last_keycode == 83) {
        if($("#content-form").length > 0){
            e.preventDefault();
            if($("#content-form .submit").length > 0){
                $("#content-form .submit").trigger("click");
            }else{
                $("#content-form button[type=submit]:first-child").trigger("click");
            }
            return false;
        }else if($("#settings-form button[type=submit]").length > 0){
            e.preventDefault();
            $("#settings-form button[type=submit]:first-child").trigger("click");
            return false;
        }
    }
});
$(document).on('change', '.live_trigger', function(e) {       
    $('option[data-trigger]', this).each(function(){
        var this_opt_data = $(this).data('trigger');
        if($(this_opt_data).length > 0){
            if(this.selected){ $(this_opt_data).css({'display':'inherit'}); }else{ $(this_opt_data).css({'display':'none'}); }
        }
    });
});
$(document).on('click', '.indir', function(e) {
    var isim = $(this).data("isim");
    var src = $(this).data("src");
    if(isim.length > 0 && src.length > 0){
        var fkl = document.createElement('a');
        fkl.href=src;
        fkl.download = isim;
        fkl.target = "_blank";
        document.body.appendChild(fkl);
        fkl.click();
        document.body.removeChild(fkl);
        delete fkl;
        return false;
    }
    delete isim, src;
});
if($('#content-form, .oto-form').length > 0){
    $("#content-form, .oto-form").each(function () {
        if ($(this).find("fieldset[data-dil]").length > 0) {
            var data_dil = null;
            $(this).find("fieldset[data-dil]").first().addClass("active in");
            $(this).find(".nav-tabs li").first().addClass("active");
            $(this).find("fieldset[data-dil]").each(function () {
                var this_fieldset = $(this);
                data_dil = this_fieldset.data('dil');
                if (this_fieldset.find(".mc_ds").length > 0) {
                    this_fieldset.find(".mc_ds").each(function () {
                        $(this).attr('id', $(this).attr('id') + "_" + data_dil);
                        if ($(this).find("[data-isim]").length == 1) {
                            var data_isim = $(this).find("[data-isim]");
                            data_isim.data('name', "diller[" + data_dil + "][" + data_isim.data('isim') + "]");
                            data_isim.data('isim', data_isim.data('isim') + "_" + data_dil);
                            data_isim.attr('data-isim', data_isim.data('isim'));
                        }
                    });
                }
                this_fieldset.find("*:not(div)[name]").each(function () {
                    $(this).attr('name', "diller[" + data_dil + "][" + $(this).attr('name') + "]");
                });
                if (this_fieldset.find(".m_editor").length > 0) {
                    this_fieldset.find(".m_editor").each(function () {
                        $(this).attr('dil', data_dil);
                    });
                }
                delete this_fieldset;
            });
            delete data_dil;
        }
    });
    $(document).on('submit', '#content-form, .oto-form', function(e) {
        if(mc_FKaydetTF === true && last_keycode != 13){   
            mc_FKaydetTF = false;    
            var confirmbol = true;
            var notext = true;
            var this_fid = "#" + $(this).attr("id");        
            var mc_otofkBtn = $(this_fid + " button[type=submit]:first-child");
            if($(this_fid + " .submit").length > 0){
                var mc_otofkBtn = $(this_fid + " .submit");
            }else{
                var mc_otofkBtn = $(this_fid + " button[type=submit]:first-child");
            }            
            if(mc_otofkBtn.attr("notext") == "true"){ notext = false; }
            if(notext){ var mc_otofkTxt = mc_otofkBtn.text();
            mc_otofkBtn.text(mcd_lutfen_bekleyiniz + "..."); }
            $(this_fid + ' input[type]').css({"border": 0,"padding-left": 0});
            $(this_fid + ' input[confirm]').each(function (){
                var this_cnf = $(this).attr('confirm');
                var uyusmayan = $(this_fid + ' input[name=' + this_cnf + ']');
                if(uyusmayan.val() != $(this).val()){
                    uyusmayan.css({"border": "1px solid orange","padding-left": "7px"});
                    $(this).css({"border": "1px solid orange","padding-left": "7px"});
                    showNotification('alert-warning','<b>Başarısız</b>Uyuşmayan alanlar mevcut','5000'); 
                    confirmbol = false;
                    return false;
                }
            });
            if(confirmbol === false || (typeof form_kontrol === "function" && form_kontrol() == false)){
                setTimeout(function(){ if(notext){ mc_otofkBtn.text(mc_otofkTxt); } mc_FKaydetTF = true; }, 200); 
                return false;
            }
            $(this_fid + ' .m_editor').each(function (){
                if($(this).attr('dil')){
                    if(!post_array['diller']){
                        post_array['diller'] = {};
                    }
                    if(!post_array['diller'][$(this).attr('dil')]){
                        post_array['diller'][$(this).attr('dil')] = {};
                    }
                    post_array['diller'][$(this).attr('dil')][$(this).attr('name')] = $(this).froalaEditor('html.get');
                }else{
                    post_array['icerik'] = $(this).froalaEditor('html.get');
                }
            });
            $(this_fid + ' input[type=checkbox]').each(function (){
                var this_cbn = $(this).attr('name');
                if(typeof this_cbn != 'undefined') {
                    if($(this).prop('checked')){ post_array[this_cbn] = 1; }else{ post_array[this_cbn] = 0; }
                }   
            });        
            post_array['kaydet'] = "onay"; 
            /* Eklentiler için diğer formları tara ve post_array dizisine at, m_domain + window.location.pathname */
            $.post(window.location.href,($(this).serialize()+'&'+$.param(post_array)),
                function(data){
                    $('#post_sonuc').append(data);
                    setTimeout(function(){ if(notext){ mc_otofkBtn.text(mc_otofkTxt); } mc_FKaydetTF = true; }, 200);                            
                }
            );
            post_array = {};
        }
        return false;    
    });
}
$(document).on('submit', '#settings-form', function(e) {
    if(mc_FKaydetTF === true && last_keycode != 13){
        mc_FKaydetTF = false;
        var this_fid = "#" + $(this).attr("id");
        var this_dir = $(this).data("dir");
        if(typeof this_dir === "undefined" || this_dir.length <= 0){ this_dir = "ayarlar"; }
        var mc_otofkBtn = $(this_fid + " button[type=submit]:first-child");
        var mc_otofkTxt = mc_otofkBtn.text();
        var last_sslistspn = $(last_sslistbtn).text();
        mc_otofkBtn.text(mcd_lutfen_bekleyiniz + "...");
        $(last_sslistbtn).text(mcd_lutfen_bekleyiniz + "...");
        $(this_fid + ' input[type=checkbox]').each(function (){
            var this_cbn = $(this).attr('name');
            if(typeof this_cbn != 'undefined') {
                if($(this).prop('checked')){ post_array[this_cbn] = 1; }else{ post_array[this_cbn] = 0; }
            }   
        });        
        post_array['kaydet'] = "onay"; 
        post_array['mcp_adres'] = this_btn_h; 
        post_array['mcp_tip'] = this_btn_t;        
        $.post(mc_sistem + this_dir + "/aktar.php",($("#settings-form").serialize()+'&'+$.param(post_array)),
            function(data){
                $('#post_sonuc').append(data);
                setTimeout(function(){
                    mc_otofkBtn.text(mc_otofkTxt);
                    $(last_sslistbtn).text(last_sslistspn);
                    mc_FKaydetTF = true;
                }, 200);                            
            }
        );
    }
    return false;
}); 
$(document).on('click', '.kopyala', function(e) {
    var yazi = $(this).data("yazi");
    if(yazi.length > 0){
        if((yazi.charAt(0) == "." || yazi.charAt(0) == "#") && $(yazi).length > 0){
            var input = $(yazi);
            var yazi = input.val();
            input.select();
            document.execCommand("copy");
        }else{
            var m_hid_inp = document.createElement("input");
            m_hid_inp.setAttribute("value", yazi);
            document.body.appendChild(m_hid_inp);
            m_hid_inp.select();
            document.execCommand("copy");
            document.body.removeChild(m_hid_inp);
        }
        mc_ctrlCfixYazi='<b>Kopyalandı!</b>';
        showNotification('alert-info', mc_ctrlCfixYazi, 10000);
    }
});
$(document).on('change', '.tumunu_sec_cb', function(e) {
    $($(this).data('element')).not(this).prop('checked', this.checked);
});
$(document).on('click', '.mc_dosyabtn[data-type]', function(e){
    $.post(mc_sistem + "dosyalar/popup_aktar.php", {coklu:$(this).data("multi"),tip:$(this).data("type"),detay:$(this).data("detay"),aktar:$(this).data("isim"),hazirla:"onay"},
    function(data){
        $('#mc_m_dyc').empty().html(data);
        $("#mc_m_dy").modal('show');
        mc_otoimgload();
    });
});
$(document).on('click', '.mcd_baslik .mcd_kapat', function(e){
    $(this).parents(".mc_ds").css({'border': "0"});
    var out_parent = $(this).parents(".mcd_secililer");
    if(out_parent.find(".mcd_values").length == 1){
        out_parent.html("<input type='hidden' class='mcd_def' name='" + out_parent.find(".mcd_values").attr('name') + "' value='0'/>");
    }else{
        $(this).parents(".mcd_secili, .mc_surukleb_item").remove();
    }
    return false;
});
$(document).on('click', '.satir-sil[data-id]', function(e){
    $.post( mc_sistem + "yardimcilar/sil/sil.php", {id:$(this).data("id"), tablo:$('#mc_liste_tablo').val(), baslik:$('#mc_liste_baslik').val()},
    function(data){
        $('#post_sonuc').append(data);                    
    });
});
$(document).on('click', '.sil-onay', function(e){
    $.post( mc_sistem + "yardimcilar/sil/sil.php", {onay:"onay", id:$(this).data("id"), tablo:$(this).data('tablo'), baslik:$(this).data('baslik')},
    function(data){
        $('#post_sonuc').append(data);                    
    });
});
$(document).on('click', '#mc_liste_coklusilbtn, .mcd_coklusilbtn', function(e){
    var sil_array = new Array();
    $('.mc_liste_cbx .chk-col-theme:checked').each(function () {
        sil_array.push($(this).data('id')); 
    });
    $.post( mc_sistem + "yardimcilar/sil/sil.php", {id:JSON.stringify(sil_array), tablo:$('#mc_liste_tablo').val(), baslik:$('#mc_liste_baslik').val()},
    function(data){
        $('#post_sonuc').append(data);                    
    });
});
$(document).on('click', '#mc_liste_tumunu_sec', function(e){
  var checked = e.currentTarget.checked;
  $('.mc_liste_cbx .chk-col-theme').prop('checked', checked);
  mc_listetara();
});
var mc_liste_sonsecili = null;
$(document).on('click', '.mc_liste_cbx .chk-col-theme', function(e){
    if(!mc_liste_sonsecili) { mc_liste_sonsecili = this; }
    if(e.shiftKey) {
        var from = $('.mc_liste_cbx .chk-col-theme').index(this);
        var to = $('.mc_liste_cbx .chk-col-theme').index(mc_liste_sonsecili);
        var start = Math.min(from, to);
        var end = Math.max(from, to) + 1;
        $('.mc_liste_cbx .chk-col-theme').slice(start, end).filter(':not(:disabled)').prop('checked', mc_liste_sonsecili.checked);
    }
    mc_liste_sonsecili = this;
    if(e.altKey){
        $('.mc_liste_cbx .chk-col-theme').filter(':not(:disabled)').each(function () {
            var $checkbox = $(this);
            $checkbox.prop('checked', !$checkbox.is(':checked'));
        });
    }
    mc_listetara();
});
function mc_listetara(){
    var secili_liste = $('.mc_liste_cbx .chk-col-theme:checked');
    var secilmeyen_liste = $('.mc_liste_cbx .chk-col-theme:not(:checked)');
    var secili_liste_uz = secili_liste.length;
    var secilmeyen_liste_uz = secilmeyen_liste.length;
    if(secilmeyen_liste_uz > 0){ $('#mc_liste_tumunu_sec').prop('checked', false); }else{ $('#mc_liste_tumunu_sec').prop('checked', true); }
    secili_liste.parents('.mc_liste_cbx').addClass("mc_liste_secili"); 
    secilmeyen_liste.parents('.mc_liste_cbx').removeClass("mc_liste_secili");
    $('.mc_liste_ss').text(secili_liste_uz);
    if(secili_liste_uz > 0){
        $('.mc_liste_coklug, .mcd_coklusilbtn, #mcd_coklusec_btn').fadeIn(300);   
    }else{
        $('.mc_liste_coklug, .mcd_coklusilbtn, #mcd_coklusec_btn').fadeOut(300); 
    }
} 
$(document).on('click', '.mc_liste_cbx', function(e) {
    if(e.ctrlKey){
        var elem = $(this);
        mc_liste_sonsecili = elem.find(".chk-col-theme")[0];
        elem.find('.chk-col-theme').prop('checked', !elem.find('.chk-col-theme').is(':checked'));
        elem.toggleClass("mc_liste_secili");
        mc_listetara();
    }
});
$(document).on('change', '.mc_liste_cbx input', function() {
    if(this.checked) {
        $(this).parents(".mc_liste_cbx").addClass("mc_liste_secili");
    }else{
        $(this).parents(".mc_liste_cbx").removeClass("mc_liste_secili");
    }
});
$(document).on('change', 'select.live_post', function(e){
    this_slc = $(this);      
    this_opt = $('option:selected', this);
    $.post(this_slc.data("action"),{livepost:"tr",data:this_slc.val(),datajson:this_slc.data("json")},
        function(data){
            if($('select' + this_slc.data("result")).length > 0){
                $('select' + this_slc.data("result")).html(data);
                $('select' + this_slc.data("result")).selectpicker('refresh');
            }else{
                $(this_slc.data("result")).html(data);
            }
        }
    ); 

});
function mc_elementTara(){
    if($.fn.selectpicker && $('.settings-body select:not(.ms)').length > 0){
        $('.settings-body select:not(.ms)').selectpicker();                            
    }
    $.mcPanel.dropdownMenu.aktif();
    $.mcPanel.input.aktif();
    $.mcPanel.select.aktif();
    if($('audio').not(".mc_muzikc audio, .mc_apl_ok").length > 0){
        $('audio').not(".mc_muzikc audio, .mc_apl_ok").mc_apl();
    }
    if($('.index_widget').length > 0){
        $('.index_widget').suruklebirak({ selector: ".mc_index_widget_item" });
    }
    if($('.mcd_galeri_drag').length > 0){
        $('.mcd_galeri_drag').suruklebirak({
            moveClass: ".mcd_baslik span",
            trigger:10
        });
    }
    if($('#content-form, .oto-form').length > 0){
        $("#content-form, .oto-form").each(function () {
            if ($(this).find("fieldset[data-dil]").length > 0) {
                $(this).find("fieldset[data-dil]").first().addClass("active in");
                $(this).find(".nav-tabs li").first().addClass("active");            
            }
        });
    }    
    mc_otoimgload();
}
function skinChanger() {
    $('.right-sidebar .demo-choose-skin li').on('click', function () {
        var $body = $('#renk_temasi');
        var $this = $(this);
        $.post(m_domain + "/sistem/ayarlar/aktar.php", {kaydet:"onay",mcp_adres:"kisisel_ayarlar",mcp_tip:"ayar",renk:$this.data('theme')},
        function(){
            $('.right-sidebar .demo-choose-skin li').removeClass('active');
            $body.attr('href', $body.attr('konum') + 'theme-' + $this.data('theme') + '.css?v=3');
            $this.addClass('active');
        });
    });
}
function mc_temamod(durum) {
    $.post(m_domain + "/sistem/ayarlar/aktar.php", {kaydet:"onay",mcp_adres:"kisisel_ayarlar",mcp_tip:"ayar",mod:durum},
    function(){
        var moddata = "light";
        if(durum == true){ moddata = "dark"; }
        $('#mod_teması').attr('href', $('#mod_teması').attr('konum') + moddata + '.css');
    });
}
function m_yazdir(divid) {
    if (document.getElementById != null){
        var inclcss = '<link href="/sistem/sablon/plugins/bootstrap/css/bootstrap.css?v=2" rel="stylesheet" type="text/css"/><link href="/sistem/sablon/css/style.css?v=7" rel="stylesheet" type="text/css"/><link href="/sistem/sablon/css/themes/theme-cyan.css?v=3" rel="stylesheet" type="text/css"/>';
        var html = '<HTML>\n<HEAD>\n' + inclcss + '\n';
        if (document.getElementsByTagName != null) {
            var headTags = document.getElementsByTagName("head");
            if (headTags.length > 0)
                html += headTags[0].innerHTML;
        }
        html += '\n</HEAD>\n<BODY>\n';
        delete headTags;
        var printReadyElem = document.getElementById(divid);
        if (printReadyElem != null){
            html += printReadyElem.innerHTML;
        }else {
            alert("Hata, yazdırılıcak alan bulunamadı.");
            return false;
        }
        html += '\n</BODY>\n</HTML>';
        delete printReadyElem;
        var printWin = window.open("", "print");
        printWin.document.open();
        printWin.document.write(html);
        printWin.document.close();
        setTimeout(function () {
            printWin.print();
        }, 100);
        delete html;
        delete inclcss;
        delete printWin;
    } else{
        alert("Tarayıcı desteklenmiyor.");
    }
}
$(function () {
    $('[data-toggle="tooltip"]').tooltip({ container: 'body' });
    $('[data-toggle="popover"]').popover();
    skinChanger();
});