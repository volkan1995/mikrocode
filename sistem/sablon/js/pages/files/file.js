if(!mc_dosya_m){
        
        mc_dosya_m = true;

        var m_da_url = mc_sistem + "dosyalar/index.php";

        var m_di_url = mc_sistem + "dosyalar/islevler.php";
        
        var m_dosyaYTF = true;
        
        mc_hazir(function(){
            $(document).on('click', '#m_dosyayukle_btn', function(e) {               
                var last_list = $("#m_dosya_agac .agac a").last();
                if(last_list.attr("target") == "file"){ $("#m_dosya_agac .agac").last().remove(); }
                if(last_list.data("tip") != "yukle"){
                     if(m_dosyaYTF){
                        m_dosyaYTF = false;
                        $('.file_loader').fadeIn(25);
                        NProgress.start(); 
                        var this_a = $(this);
                        var last_a = $("#m_dosya_agac .agac a[target=dir]").last();
                        $.post(m_da_url, {gorev:'yukle',tip:last_a.data("tip"),klasor:last_a.data("id")},
                        function(data){
                            m_dosyaYTF = true;
                            $('.file_loader').fadeOut(150);
                            NProgress.done();
                            $('.m_dosya_sol').empty().html(data);
                            dosya_ileri("upload","yukle",0,this_a.text());
                            mc_otoimgload();
                        });                        
                    }
                }                
                return false;
            });

            $(document).on('click', '.m_klasor_list a[target]', function(e) {
                if(m_dosyaYTF){
                    m_dosyaYTF = false;
                    $('.file_loader').fadeIn(25);
                    NProgress.start(); 
                    var this_a = $(this);
                    if(this_a.attr("target") == "dir"){
                        $.post(m_da_url, {tip:this_a.data("tip"),klasor:this_a.data("id")},
                        function(data){
                            m_dosyaYTF = true;
                            $('.file_loader').fadeOut(150);
                            NProgress.done();
                            $('.m_dosya_sol').empty().html(data);
                            dosya_ileri("dir",this_a.data("tip"),this_a.data("id"),this_a.children(".dosya_isim").text());
                            mc_otoimgload();
                        });
                    }else{
                        $.post(m_da_url, {gorev:'onizle',target:"file",tip:this_a.data("tip"),id:this_a.data("id")},
                        function(data){
                            m_dosyaYTF = true;
                            $('.file_loader').fadeOut(150);
                            NProgress.done();
                            $('.m_dosya_sol').empty().html(data);
                            dosya_ileri("file",this_a.data("tip"),this_a.data("id"),this_a.children(".dosya_isim").text());
                            if($('audio').not(".mc_muzikc audio, .mc_apl_ok").length > 0){ $('audio').not(".mc_muzikc audio, .mc_apl_ok").mc_apl(); }
                            mc_otoimgload();
                        });
                    }                    
                }
                return false;
            });

            $(document).on('click', '#m_dosya_agac .agac a[target]', function(e) {                
                var this_a = $(this);
                var this_last = $("#m_dosya_agac .agac a[target]").last();
                if(this_a.data("id") !=  this_last.data("id") || this_a.data("tip") !=  this_last.data("tip")){
                    if(m_dosyaYTF){
                        m_dosyaYTF = false;
                        $('.file_loader').fadeIn(25);
                        NProgress.start(); 
                        $.post(m_da_url, {tip:this_a.data("tip"),klasor:this_a.data("id")},
                        function(data){
                            m_dosyaYTF = true;
                            $('.file_loader').fadeOut(150);
                            NProgress.done();
                            this_a.parent(".agac").nextAll(".agac").remove();
                            this_a.parent(".agac").addClass("active");
                            $('.m_dosya_sol').empty().html(data);
                            if($("#m_dosya_agac .agac a[target]").length == 1){
                                $("#m_dosya_agac .no_pre").css({'display':"none"});
                            }
                            mc_otoimgload();
                        });
                    }
                }                
                return false;
            }); 

            $(document).on('click', '#m_dosya_agac .no_pre a', function(e) {                
                if($("#m_dosya_agac .agac a[target]").length > 1){
                    if(m_dosyaYTF){
                        m_dosyaYTF = false;
                        $('.file_loader').fadeIn(25);
                        NProgress.start(); 
                        var this_a = $("#m_dosya_agac .agac a[target]").last().parent().prev().children("a");
                        $.post(m_da_url, {tip:this_a.data("tip"),klasor:this_a.data("id")},
                        function(data){
                            m_dosyaYTF = true;
                            $('.file_loader').fadeOut(150);
                            NProgress.done();
                            this_a.parent(".agac").nextAll(".agac").remove();
                            this_a.parent(".agac").addClass("active");
                            $('.m_dosya_sol').empty().html(data);
                            if($("#m_dosya_agac .agac a[target]").length == 1){
                                $("#m_dosya_agac .no_pre").css({'display':"none"});
                            }
                            mc_otoimgload();
                        });
                    }
                }else{
                    $("#m_dosya_agac .no_pre").css({'display':"none"});
                }
                return false;
            });

            $(document).on('click', '#m_yeniklasor_btn', function(e) {
                if(m_dosyaYTF){
                    m_dosyaYTF = false;
                    $('.file_loader').fadeIn(25);
                    NProgress.start(); 
                    var this_a = $("#m_dosya_agac .agac a[target=dir]").last();
                    $.post(m_da_url, {gorev:'yeni',tip:this_a.data("tip"),klasor:this_a.data("id")},
                    function(data){
                        m_sag_ac(data);
                    });
                }
                return false;
            });

            $(document).on('click', '.m_sag_iptal', function(e) {
                m_sag_iptal();
                return false;
            });      

            $(document).on('click', '.m_klasor_list .sag_menu', function(e) {
                if(m_dosyaYTF){
                    m_dosyaYTF = false;
                    $('.file_loader').fadeIn(25);
                    NProgress.start(); 
                    var this_m = $(this);
                    $.post(m_da_url, {gorev:'onizle',target:"dir",tip:this_m.data("tip"),id:this_m.data("id")},
                    function(data){
                        m_sag_ac(data);
                        mc_otoimgload();
                    });
                }
                return false;
            });
        
        });
        
        function m_sag_iptal(){
            $('.m_dosya_sol').removeClass("m_dosya_sol_dar");
            $('.m_dosya_sag').removeClass("m_dosya_sag_acik");
            $('.m_dosya_sag').empty();
            $('.m_sag_iptal').css({'display':"none"});
        }
        function m_sag_ac(data){
            m_dosyaYTF = true;
            $('.file_loader').fadeOut(150);
            NProgress.done();
            $('.m_sag_iptal').css({'display':"inline"});
            $('.m_dosya_sol').addClass("m_dosya_sol_dar");
            $('.m_dosya_sag').addClass("m_dosya_sag_acik");
            $('.m_dosya_sag').empty().html(data);
            $.mcPanel.input.aktif();
            $.mcPanel.select.aktif();
        }
        function dosya_ileri(target, tip, klasor, isim){
            $('#m_dosya_agac .agac').removeClass("active");
            var m_icon = "";
            if(target == "file"){
                m_icon = '<i class="material-icons">library_books</i> ';
            }else if(target == "upload"){
                m_icon = '<i class="material-icons">file_upload</i> ';
            }
            $('#m_dosya_agac').append('<li class="agac active"><a href="javascript:void(0);" target="' + target + '" data-isim="' + isim + '" data-id="' + klasor + '" data-tip="' + tip + '">' + m_icon + '<span>' + isim + '</span></a></li>');
            $("#m_dosya_agac .no_pre").css({'display':"inline"});
        }
        
        function mc_yeniklasor(){
            if(m_dosyaYTF){
                m_dosyaYTF = false;
                $('.file_loader').fadeIn(25);
                NProgress.start(); 
                var this_form = $("#mc_yeniklasor_form");
                var this_btn = this_form.children("button[type=submit]");
                var this_txt = this_btn.text();
                this_btn.text("Bekleyiniz...");
                $.post(m_di_url, this_form.serialize(),
                function(data){
                    m_dosyaYTF = true;
                    $('.file_loader').fadeOut(150);
                    NProgress.done();
                    this_btn.text(this_txt);
                    if($("#m_dosya_agac .agac a[target=dir]").last().data("id") == $("#ust_klasor").val()){
                        $('.m_dosya_sol > p').remove();
                        $('.m_dosya_sol').prepend(data);
                    }else{
                        $('#post_sonuc').append(data);
                        $('#post_sonuc .m_klasor_list').remove();
                    }
                });
            }
        }

        function m_dosyakapat(){
            if($(".m_dosya_sag_acik").length > 0){
                m_sag_iptal();
            }else{
                $('#m_m_dyc').empty();
                $("#m_m_dy").modal('hide');                    
            }

        }
        
    }