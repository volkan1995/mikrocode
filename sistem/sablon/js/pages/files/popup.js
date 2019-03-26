if(!mc_dosya_p){
        
        mc_dosya_p = true;
    
        var mc_da_url = mc_sistem + "dosyalar/popup_aktar.php";
        
        var mc_di_url = mc_sistem + "dosyalar/islevler.php";
        
        var mcd_coklu_o =  0;
        
        var mcd_cdtf = false;
        
        var mcdp_tf = true;
        
        $(document).on('click', '#mc_dosyayukle_btn', function(e) {
            var last_list = $("#mc_dosya_agac .agac a").last();
            if(last_list.data("tip") != "yukle"){
                var this_a = $(this);
                var last_a = $("#mc_dosya_agac .agac a[target=dir]").last();
                $.post(mc_da_url, {gorev:'yukle',tip:last_a.data("tip"),klasor:last_a.data("id")},
                function(data){
                    $('.mc_dosya_sol').empty().html(data);
                    dosya_ileri("upload","yukle",0,this_a.text());
                    mc_otoimgload();
                });
            }
            return false;
        });

        $(document).on('click', '.mc_klasor_list a[target]', function(e) {
            var this_a = $(this);
            if(this_a.attr("target") == "dir"){
                $.post(mc_da_url, {tip:this_a.data("tip"),klasor:this_a.data("id")},
                function(data){
                    $('.mc_dosya_sol').empty().html(data);
                    dosya_ileri("dir",this_a.data("tip"),this_a.data("id"),this_a.children(".dosya_isim").text());
                    mc_otoimgload();
                });
            }else{
                $.post(mc_da_url, {gorev:'onizle',target:"file",tip:this_a.data("tip"),id:this_a.data("id")},
                function(data){
                    mc_sag_ac(data);
                    if($('audio').not(".mc_muzikc audio, .mc_apl_ok").length > 0){
                        $('audio').not(".mc_muzikc audio, .mc_apl_ok").mc_apl();
                    }
                    mc_otoimgload();
                });
            }
            return false;
        });

        $(document).on('click', '#mc_dosya_agac .agac a[target]', function(e) {
            var this_a = $(this);
            var this_last = $("#mc_dosya_agac .agac a[target]").last();
            if(this_a.data("id") !=  this_last.data("id") || this_a.data("tip") !=  this_last.data("tip")){
                $.post(mc_da_url, {tip:this_a.data("tip"),klasor:this_a.data("id")},
                function(data){
                    this_a.parent(".agac").nextAll(".agac").remove();
                    this_a.parent(".agac").addClass("active");
                    $('.mc_dosya_sol').empty().html(data);
                    if($("#mc_dosya_agac .agac a[target]").length == 1){
                        $("#mc_dosya_agac .no_pre").css({'display':"none"});
                    }
                    mc_otoimgload();
                });
            }
            return false;
        }); 

        $(document).on('click', '#mc_dosya_agac .no_pre a', function(e) {
            if($("#mc_dosya_agac .agac a[target]").length > 1){
                var this_a = $("#mc_dosya_agac .agac a[target]").last().parent().prev().children("a");
                $.post(mc_da_url, {tip:this_a.data("tip"),klasor:this_a.data("id")},
                function(data){
                    this_a.parent(".agac").nextAll(".agac").remove();
                    this_a.parent(".agac").addClass("active");
                    $('.mc_dosya_sol').empty().html(data);
                    if($("#mc_dosya_agac .agac a[target]").length == 1){
                        $("#mc_dosya_agac .no_pre").css({'display':"none"});
                    }
                    mc_otoimgload();
                });
            }else{
                $("#mc_dosya_agac .no_pre").css({'display':"none"});
            }
            return false;
        });

        $(document).on('click', '#mc_yeniklasor_btn', function(e) {
            var this_a = $("#mc_dosya_agac .agac a[target=dir]").last();
            $.post(mc_da_url, {gorev:'yeni',tip:this_a.data("tip"),klasor:this_a.data("id")},
            function(data){
                mc_sag_ac(data);
            });
            return false;
        });
        
        $(document).on('click', '.mc_sag_iptal', function(e) {
            mc_sag_iptal();
            return false;
        });      
        
        $(document).on('click', '.mc_klasor_list .sag_menu', function(e) {
            var this_m = $(this);
            $.post(mc_da_url, {gorev:'onizle',target:"dir",tip:this_m.data("tip"),id:this_m.data("id")},
            function(data){
                mc_sag_ac(data);
                mc_otoimgload();
            });
            return false;
        });
        
        $(document).on('click', '#mcd_coklusec_btn', function(e) {
            if($("#mcd_coklu_o").val() == 1){
                var this_id = $("#mcd_aktar_id");
                var this_mcds = "#mcds_" + this_id.val();                
                var mcd_detay_d = $("#mcd_detay_d").val();
                var sec_array = new Array();
                $('.mc_liste_secili .chk-col-theme').each(function () {
                    if($(this_mcds + " .mcd_secili_" + $(this).data('id')).length == 0){ sec_array.push( $(this).data('id')); }
                });
                if(sec_array.length > 0){
                    $.post(mc_di_url, {dosya_sec:"onay",detay:mcd_detay_d,coklu:1,aktarid:this_id.val(),id:JSON.stringify(sec_array)},
                    function(data){
                        if($(this_mcds + " > #mcd_secililer .mcd_def").length > 0){ $(this_mcds + " > #mcd_secililer .mcd_def").remove(); }
                        $(this_mcds + " > #mcd_secililer").append(data);
                    });
                }
            }
            return false;
        });
        
        function mc_sag_iptal(){
            $('.mc_dosya_sol').removeClass("mc_dosya_sol_dar");
            $('.mc_dosya_sag').removeClass("mc_dosya_sag_acik");
            $('.mc_dosya_sag').empty();
            $('.mc_sag_iptal').css({'display':"none"});
        }
        function mc_sag_ac(data){
            $('.mc_sag_iptal').css({'display':"inline"});
            $('.mc_dosya_sol').addClass("mc_dosya_sol_dar");
            $('.mc_dosya_sag').addClass("mc_dosya_sag_acik");
            $('.mc_dosya_sag').empty().html(data);
            $.mcPanel.input.aktif();
            $.mcPanel.select.aktif();
        }
        function dosya_ileri(target, tip, klasor, isim){
            $('#mc_dosya_agac .agac').removeClass("active");
            var mc_icon = "";
            if(target == "file"){
                mc_icon = '<i class="material-icons">library_books</i> ';
            }else if(target == "upload"){
                mc_icon = '<i class="material-icons">file_upload</i> ';
            }
            $('#mc_dosya_agac').append('<li class="agac active"><a href="javascript:void(0);" target="' + target + '" data-isim="' + isim + '" data-id="' + klasor + '" data-tip="' + tip + '">' + mc_icon + isim + '</a></li>');
            $("#mc_dosya_agac .no_pre").css({'display':"inline"});
        }
        
        function mc_yeniklasor(){
            var this_form = $("#mc_yeniklasor_form");
            var this_btn = this_form.children("button[type=submit]");
            var this_txt = this_btn.text();
            this_btn.text("Bekleyiniz...");
            $.post(mc_di_url, this_form.serialize(),
            function(data){
                this_btn.text(this_txt);
                if($("#mc_dosya_agac .agac a[target=dir]").last().data("id") == $("#ust_klasor").val()){
                    $('.mc_dosya_sol > p').remove();
                    $('.mc_dosya_sol').prepend(data);
                }else{
                    $('#post_sonuc').append(data);
                    $('#post_sonuc .mc_klasor_list').remove();
                }
            });
        }
        
        function mc_dosyakapat(){
            if($(".mc_dosya_sag_acik").length > 0){
                mc_sag_iptal();
            }else{
                $('#mc_m_dyc').empty();
                $("#mc_m_dy").modal('hide');                    
            }
        }
        
        function mc_dosyaform(){
            var this_id = $("#mcd_aktar_id");
            var this_mcds = "#mcds_" + this_id.val();
            var mcd_coklu_o = $("#mcd_coklu_o").val();
            var mcd_detay_d = $("#mcd_detay_d").val();
            mcd_cdtf = false;
            if(mcdp_tf == false){
                $(this_mcds + ' .mcd_secili_' + $('.mcd_sid').val()).remove();
                $(this_mcds).css({'border': "0"});
                $("#mcd_sec_btn").text("Sec");
                mcdp_tf = true;
            }else{
                $(this_mcds + " .mcd_values").each(function(i){
                    if($(this).val() == $('.mcd_sid').val()){
                        alert("Aynı dosya var");
                        mcd_cdtf = true;
                    }
                });            
                if(mcd_cdtf == false && this_id.length > 0){
                    var post_array = {detay:mcd_detay_d,dosya_sec:"onay",coklu:mcd_coklu_o,aktarid:this_id.val()};
                    $.post(mc_di_url, ($("#mc_dosya_form").serialize()+'&'+ $.param(post_array)),
                    function(data){
                        mcdp_tf = false;
                        $("#mcd_sec_btn").text("Kaldır");
                        if(mcd_coklu_o == 1){
                            if($(this_mcds + " > #mcd_secililer .mcd_def").length > 0){
                                $(this_mcds + " > #mcd_secililer .mcd_def").remove();
                            }
                            $(this_mcds + " > #mcd_secililer").append(data);
                        }else{
                            $(this_mcds + " > #mcd_secililer").html(data);
                        }
                        if($('audio').not(".mc_muzikc audio, .mc_apl_ok").length > 0){ $('audio').not(".mc_muzikc audio, .mc_apl_ok").mc_apl(); }
                    });
                }
            }
            
        }
    
    }