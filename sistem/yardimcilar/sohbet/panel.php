<div class="mc_sohbet_alan card">
    <div class="panel-group full-body" id="accordion_19" role="tablist" aria-multiselectable="true">
        <div class="panel panel-col">
            <div class="panel-heading" role="tab">
                <h4 class="panel-title p-b-10 p-t-5">
                    <div role="button" class="mc_mesajlari_goster">
                        <p class="margin-0">Panel Sohbeti <small>(<span class="mc_sohbet_sayac">0</span> aktif)</small></p>
                        <small class="mc_sohbet_hareketler">Hoşgeldiniz</small>
                    </div>
                </h4>
            </div>
            <div class="panel-collapse collapse" role="tabpanel">
                <div class="panel-body padding-0">
                    <div class="mc_sohbet_mesajlar"></div>
                    <form class="mc_sohbet_form">
                        <div class="form-group">
                            <div class="form-line">
                                <textarea class="form-control" placeholder="Bir şeyler yazın..."></textarea>
                                <span class="picker mc_sohbet_e_btn">&#128515;</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>    
    var mc_sohbet_ayarlar = {
        kullanici_adi: "<?= $mc_oturum->kadi ?>",
        kullanici_id: <?=mc_oturum_id?>,
        api_anahtari: "<?= m_host ?>",
        giris_kapisi: 0,
        listele_url: "http://p4.mc:8080/sistem/yardimcilar/sohbet/_listele.php",
        gonder_url: "http://p4.mc:8080/sistem/yardimcilar/sohbet/_gonder.php"
    };
    
    var api_server = "https://otomasyon.mikrocode.net";
    var assets_server = "https://otomasyon.mikrocode.net/eklentiler/";
    var emoji_server = "https://otomasyon.mikrocode.net/eklentiler/";
    api_server = "http://localhost:7856";
    assets_server = mc_sistem + "yardimcilar/sohbet/";
    emoji_server = mc_plugins + "emoji/";
    
    const {
        kullanici_adi = null,
        kullanici_id = 0,
        api_anahtari = null,
        giris_kapisi = null,
        dom_nesnesi = "body",
        listele_url = null,
        gonder_url = null
    } = mc_sohbet_ayarlar;
    
    if (kullanici_adi == null || api_anahtari == null || giris_kapisi == null || dom_nesnesi == null || listele_url == null || gonder_url == null || kullanici_id == null || kullanici_id == 0) {
        throw new Error("Lütfen api_anahtari, giris_kapisi, kullanici_adi, kullanici_id, listele_url ve dom_nesnesi değişkenlerini eksiksiz tanımlayınız");
    }
    var mc_sohbet_scrollTF = false;
    var mc_sohbet_cssArray = [];
    function mc_sohbet_loadJS(url, opts) {
        opts = jQuery.extend(opts || {}, {dataType: "script", cache: true, url: url});
        return jQuery.ajax(opts);
    };
    function mc_sohbet_loadCss(href) {
        if (jQuery.inArray(href, mc_sohbet_cssArray) != -1) {
            return true;
        }
        mc_sohbet_cssArray.push(href);
        var cssLink = jQuery("<link>");
        jQuery("head").append(cssLink);
        cssLink.attr({rel: "stylesheet", type: "text/css", href: href});
        return true;
    };
    function mc_scroll_go() {
        var scroll_go = 0;
        jQuery.each(jQuery('.mc_sohbet_mesajlar > *'), function () {
            scroll_go += jQuery(this).height();
        });
        jQuery('.mc_sohbet_mesajlar').animate({scrollTop: scroll_go}, 200);
    }
    function mc_sohbet_htmlDecode(value) {
        return value.replace(/ /g, '&nbsp;').replace(/\n/g, "<br>");
    }
    function mc_sohbet_gelen_mesaj(gonderen, msg, zaman) {
        var zaman = new Date(zaman);
        jQuery('.mc_sohbet_mesajlar').append("<div class='mc_sohbet_left'><b>" + gonderen + "</b><p class='mc_sohbet_mesaj'>" + mc_sohbet_htmlDecode(msg) + "</p><small>" + zamanHesapla.gecmisZaman(zaman.getTime()) + "</small></div>");
        mc_sohbet_scrollTF = false;
    }
    function mc_sohbet_giden_mesaj(msg, zaman) {
        var zaman = new Date(zaman);
        jQuery('.mc_sohbet_mesajlar').append("<div class='mc_sohbet_right'><p class='mc_sohbet_mesaj'>" + mc_sohbet_htmlDecode(msg) + "</p><small>" + zamanHesapla.gecmisZaman(zaman.getTime()) + "</small></div>");
        mc_scroll_go();
    }
    var zamanHesapla = (function () {
        var degerler = {};
        degerler.terimler = {
            on_ek: '',
            son_ek: 'önce',
            seconds: 'az',
            minute: 'yaklaşık bir dakika',
            minutes: '%d dakika',
            hour: 'yaklaşık bir saat',
            hours: 'yaklaşık %d saat',
            day: 'bir gün',
            days: '%d gün',
            month: 'yaklaşık bir ay',
            months: '%d ay',
            year: 'yaklaşık 1 yıl',
            years: '%d yıl'
        };
        degerler.gecmisZaman = function (zaman) {
            var saniye = Math.floor((new Date() - parseInt(zaman)) / 1000),
                ayirici = this.terimler.ayirici || ' ',
                kelimeler = this.terimler.on_ek + ayirici,
                aralik = 0,
                araliklar = {
                    year: saniye / 31536000,
                    month: saniye / 2592000,
                    day: saniye / 86400,
                    hour: saniye / 3600,
                    minute: saniye / 60
                };
            var uzaklik = this.terimler.seconds;
            for (var key in araliklar) {
                aralik = Math.floor(araliklar[key]);

                if (aralik > 1) {
                    uzaklik = this.terimler[key + 's'];
                    break;
                } else if (aralik === 1) {
                    uzaklik = this.terimler[key];
                    break;
                }
            }
            uzaklik = uzaklik.replace(/%d/i, aralik);
            kelimeler += uzaklik + ayirici + this.terimler.son_ek;
            return kelimeler.trim();
        };
        return degerler;
    }());
    mc_sohbet_loadCss(assets_server + "sohbet.css?v=1");
    /* HTML send */
    
    jQuery.post(listele_url, {api_anahtari: api_anahtari, kullanici_id:kullanici_id, giris_kapisi:giris_kapisi},
        function(mesajlar){
            jQuery('.mc_sohbet_mesajlar').prepend(mesajlar);
            setTimeout(function(){
                mc_scroll_go();
            }, 200);            
        }
    );
    
    mc_sohbet_loadJS(api_server + "/socket.io/socket.io.js").done(function () {
        let socket = io(api_server);
        socket.emit('giris_yap', kullanici_id, kullanici_adi);
        socket.on('mesaj_liste', mc_sohbet_gelen_mesaj);
        socket.on('toplam_aktif', (mesaj) => {
            jQuery('.mc_sohbet_sayac').text(mesaj);
        });
        socket.on('hareketler', (mesaj) => {
            jQuery('.mc_sohbet_hareketler').text(mesaj);
        });
        var gonderTF = true;
        jQuery(document).on('click', '.mc_mesajlari_goster', function (e) {
            jQuery(this).parents(".panel").find(".collapse").collapse('toggle');
            if(mc_sohbet_scrollTF == false){
                mc_sohbet_scrollTF = true;
                mc_scroll_go();
            }
        });
        jQuery(document).on('submit', '.mc_sohbet_form', function (e) {
            if (gonderTF === true) {
                gonderTF = false;
                var gonderFRM = jQuery(this);
                var mesaj_input = jQuery('.mc_sohbet_form textarea');
                if (mesaj_input.val().length > 0) {
                    socket.emit('mesaj_gonder', gonder_url, mesaj_input.val(), mc_sohbet_giden_mesaj);
                }
                gonderTF = true;
                gonderFRM[0].reset();
            }
            return false;
        });

        jQuery(function () {
            jQuery(".mc_sohbet_form textarea").keypress(function (e) {
                if (e.which == 13 && !e.shiftKey) {
                    jQuery(this).closest("form").submit();
                    e.preventDefault();
                }
            });
        });
    });
    
    mc_sohbet_loadJS(emoji_server + "jquery.lsxemojipicker.js?v=1").done(function () {
        mc_sohbet_loadCss(emoji_server + "jquery.lsxemojipicker.css?v=1");
        var mc_sohbet_e_btn = false;
        jQuery(document).on('click', '.mc_sohbet_e_btn', function (e) {
            if (mc_sohbet_e_btn === false) {
                jQuery('.mc_sohbet_e_btn').lsxEmojiPicker({
                    closeOnSelect: false,
                    onSelect: function (emoji) {
                        jQuery(".mc_sohbet_form textarea").val(jQuery(".mc_sohbet_form textarea").val() + jQuery("<div/>").html(emoji.value).html());
                    }
                });
                jQuery('.lsx-emojipicker-container').css({'display': "block"});
                mc_sohbet_e_btn = true;
            }
        });
    });
    
</script>