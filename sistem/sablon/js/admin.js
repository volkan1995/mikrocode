if (typeof jQuery === "undefined") { throw new Error("Lütfen jquery kütüphanesini sayfaya çağrınız"); }
$.mcPanel = {};
$.mcPanel.solMenu = {
    ustmenutara: function () {
        $.each($('.menu .list li.active'), function (i, val) {
            var $activeFind = $(val).find('a:eq(0)');
            if($activeFind.closest('.dis_menu').length > 0){
                $activeFind = $activeFind.closest('.dis_menu');
                $activeFind.addClass('active');
            }
        });
    },
    altmenutara: function () {
        $.each($('.menu .list li.active'), function (i, val) {
            var $activeAnchors = $(val).find('a:eq(0)');
            $activeAnchors.addClass('toggled');
            $activeAnchors.next().show();
        });
    },
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
        $('a').on('click', function (e) {
            var this_aclck = $(this);
            setTimeout(function(){
                if(this_aclck.closest('.dis_menu').length > 0 && (this_aclck.is('[href*="/"') || this_aclck.is('[href*="?"'))){
                    $('.menu .list li.active').not(this).removeClass('active');                
                    this_aclck.closest('li').addClass('active');   
                    $.mcPanel.solMenu.ustmenutara();   
                    $.mcPanel.solMenu.altmenutara();         
                }
            },50);
        });        
        $.each($('.menu-toggle.toggled'), function (i, val) {
            $(val).next().slideToggle(0);
        });        
        $.mcPanel.solMenu.ustmenutara();        
        $.mcPanel.solMenu.altmenutara();
        $('.menu-toggle').on('click', function (e) {
            var $this = $(this);
            var $content = $this.next();
            if ($($this.parents('ul')[0]).hasClass('list')) {
                var $not = $(e.target).hasClass('menu-toggle') ? e.target : $(e.target).parents('.menu-toggle');
                $.each($('.menu-toggle.toggled').not($not).next(), function (i, val) {
                    if ($(val).is(':visible')) {
                        $(val).prev().toggleClass('toggled');
                        $(val).slideUp();
                    }
                });
            }
            $this.toggleClass('toggled');
            $content.slideToggle(320);
        });
        _this.checkStatuForResize(true);
        $(window).resize(function () {
            _this.checkStatuForResize(false);
        });
        Waves.attach('.menu .list a', ['waves-block']);
        Waves.init();
    },
    checkStatuForResize: function (firstTime) {
        var $body = $('body');
        var $openCloseBar = $('.navbar .navbar-header .bars');
        var width = $body.width();
        if (firstTime) {
            $body.find('.content, .sidebar').addClass('no-animate').delay(1000).queue(function () {
                $(this).removeClass('no-animate').dequeue();
            });
        }
        if(width < 1170) {
            $body.addClass('ls-closed');
            $openCloseBar.fadeIn();
            if($body.find('.navbar-header .user-info').length > 0){
                if(width < 768){ userpl = "55px"; }else{ userpl = "45px"; }
                $body.find('.navbar-header .user-info').css({'padding-left':userpl});
            }
        }else{
            $body.removeClass('ls-closed');
            $body.find('.navbar-header .user-info').css({'padding-left':"0"});
            $openCloseBar.fadeOut();
        }
    },
    isOpen: function () {
        return $('body').hasClass('overlay-open');
    }
};
$.mcPanel.sagMenu = {
    aktif: function () {
        var _this = this;
        var $sidebar = $('#rightsidebar');
        var $overlay = $('.overlay');
        var $sonyazi = $('.tab-nav-right li a').text();
        $(window).click(function (e) {
            var $target = $(e.target);
            if (e.target.nodeName.toLowerCase() === 'i') { $target = $(e.target).parent(); }

            if (!$target.hasClass('js-right-sidebar') && _this.isOpen() && $target.parents('#rightsidebar').length === 0) {
                if (!$target.hasClass('bars')) $overlay.fadeOut();
                $sidebar.removeClass('open');
            }
        });
        $('.js-right-sidebar').on('click', function () {
            $sidebar.toggleClass('open');
            if (_this.isOpen()) { $overlay.fadeIn(); } else { $overlay.fadeOut(); }
        });        
        $('#hizli_menu a').on('click', function () {
            $('.tab-nav-right li').removeClass('active');
            $('.tab-nav-right li a').text('Geri');
        });        
        $('.tab-nav-right li a').on('click', function () {
            $('.tab-nav-right li a').text($sonyazi);
        });
    },
    isOpen: function () {
        return $('.right-sidebar').hasClass('open');
    }
};
var $searchBar = $('.search-bar');
$.mcPanel.ara = {
    aktif: function () {
        var _this = this;
        $('.js-search').on('click', function () {
            _this.showSearchBar();
        });
        $searchBar.find('.close-search').on('click', function () {
            _this.hideSearchBar();
        });
        $searchBar.find('input[type="text"]').on('keyup', function (e) {
            if (e.keyCode == 27) { _this.hideSearchBar(); }
        });
    },
    showSearchBar: function () {
        $searchBar.addClass('open');
        $searchBar.find('input[type="text"]').focus();
    },
    hideSearchBar: function () {
        $searchBar.removeClass('open');
        $searchBar.find('input[type="text"]').val('');
    }
};
$.mcPanel.navbar = {
    aktif: function () {
        var $body = $('body');
        var $overlay = $('.overlay');
        $('.bars').on('click', function () {
            $body.toggleClass('overlay-open');
            if ($body.hasClass('overlay-open')) { $overlay.fadeIn(); } else { $overlay.fadeOut(); }
        });
        $('.nav [data-close="true"]').on('click', function () {
            var isVisible = $('.navbar-toggle').is(':visible');
            var $navbarCollapse = $('.navbar-collapse');
            if (isVisible) {
                $navbarCollapse.slideUp(function () {
                    $navbarCollapse.removeClass('in').removeAttr('style');
                });
            }
        });
    }
};
$.mcPanel.input = {
    aktif: function () {
        $('.form-control').focus(function () {
            $(this).parent().addClass('focused');
        });
        $('.form-control').focusout(function () {
            var $this = $(this);
            if ($this.parents('.form-group').hasClass('form-float')) {
                if ($this.val() == '') { $this.parents('.form-line').removeClass('focused'); }
            }
            else {
                $this.parents('.form-line').removeClass('focused');
            }
        });
        $('body').on('click', '.form-float .form-line .form-label', function () {
            $(this).parent().find('input').focus();
        });
        $('.form-control').each(function () {
            if ($(this).val() !== '') {
                $(this).parents('.form-line').addClass('focused');
            }
        });
    }
};
$.mcPanel.select = {
    aktif: function () {
        if ($.fn.selectpicker) { $('select:not(.ms)').selectpicker(); }
    }
};
$.mcPanel.dropdownMenu = {
    aktif: function () {
        var _this = this;
        $('.dropdown, .dropup, .btn-group').on({
            "show.bs.dropdown": function () {
                var dropdown = _this.dropdownEffect(this);
                _this.dropdownEffectStart(dropdown, dropdown.effectIn);
            },
            "shown.bs.dropdown": function () {
                var dropdown = _this.dropdownEffect(this);
                if (dropdown.effectIn && dropdown.effectOut) {
                    _this.dropdownEffectEnd(dropdown, function () { });
                }
            },
            "hide.bs.dropdown": function (e) {
                var dropdown = _this.dropdownEffect(this);
                if (dropdown.effectOut) {
                    e.preventDefault();
                    _this.dropdownEffectStart(dropdown, dropdown.effectOut);
                    _this.dropdownEffectEnd(dropdown, function () {
                        dropdown.dropdown.removeClass('open');
                    });
                }
            }
        });
        Waves.attach('.dropdown-menu li a', ['waves-block']);
        Waves.init();
    },
    dropdownEffect: function (target) {
        var effectIn = 'fadeIn', effectOut = 'fadeOut';
        var dropdown = $(target), dropdownMenu = $('.dropdown-menu', target);
        if (dropdown.length > 0) {
            var udEffectIn = dropdown.data('effect-in');
            var udEffectOut = dropdown.data('effect-out');
            if (udEffectIn !== undefined) { effectIn = udEffectIn; }
            if (udEffectOut !== undefined) { effectOut = udEffectOut; }
        }
        return {
            target: target,
            dropdown: dropdown,
            dropdownMenu: dropdownMenu,
            effectIn: effectIn,
            effectOut: effectOut
        };
    },
    dropdownEffectStart: function (data, effectToStart) {
        if (effectToStart) {
            data.dropdown.addClass('dropdown-animating');
            data.dropdownMenu.addClass('animated dropdown-animated');
            data.dropdownMenu.addClass(effectToStart);
        }
    },
    dropdownEffectEnd: function (data, callback) {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        data.dropdown.one(animationEnd, function () {
            data.dropdown.removeClass('dropdown-animating');
            data.dropdownMenu.removeClass('animated dropdown-animated');
            data.dropdownMenu.removeClass(data.effectIn);
            data.dropdownMenu.removeClass(data.effectOut);
            if (typeof callback == 'function') {
                callback();
            }
        });
    }
};
$.mcPanel.post = {
    yukle: function(al_url){
        if($.mcPanel.post.mc_js_dosyasorgula(al_url) === false){ al_url = al_url + "/"; }
        $.post(al_url, {mc_js:"onay"},
        function(data){ mc_js_icerik.html(data); mc_elementTara(); })
        .done(function() { })
        .fail(function() { mc_js_icerik.html(mc_js_hata + al_url); })
        .always(function(){ mc_js_kilit = false; NProgress.done(); mc_js_icerik.fadeIn(100); });
    },
    aktif: function(){
        function yukle(al_url){
            if($.mcPanel.post.mc_js_dosyasorgula(al_url) === false){ al_url = al_url + "/"; }
            $.post(al_url, {mc_js:"onay"},
            function(data){ mc_js_icerik.html(data); mc_elementTara(); })
            .done(function() { })
            .fail(function() { mc_js_icerik.html(mc_js_hata + al_url); })
            .always(function(){ mc_js_kilit = false; NProgress.done(); mc_js_icerik.fadeIn(100); });
        }
        var mc_js_kilit = false;
        if(mc_js_calistir === true){
            $(document).on('click', 'a', function(e) {
                if($(this).is('[target*="_"')){
                    return true;
                }else if($(this).is('[target="dir"')){
                    var this_a = $(this);
                    if(this_a.attr("href") != "javascript:void(0);" && this_a.attr("href") != "#"){
                        history.pushState(null, null, this_a.attr("href"));
                    }
                }else{
                    if(mc_js_kilit === false){
                        var this_a = $(this);
                        if(this_a.is('[href*="/"') || this_a.is('[href*="?"')) {
                            mc_js_kilit = true;
                            var mc_js_url = document.createElement('a');
                            mc_js_url.href = this_a.attr("href");
                            if(mc_js_url.hostname == window.location.hostname){
                                NProgress.start();
                                mc_js_icerik.fadeOut(100);
                                history.pushState(null, null, this_a.attr("href"));
                                $('.menu .list li.active').not(this).removeClass('active');
                                setTimeout(function(){
                                    mc_js_icerik.empty();
                                    if($.mcPanel.post.mc_js_dosyasorgula(this_a.attr("href")) === false){
                                        if(mc_js_url.pathname.substr(-1) === '/') {
                                            mc_js_url.pathname = mc_js_url.pathname.substr(0, mc_js_url.pathname.length - 1);
                                        }
                                        var yeni_url = mc_js_url.pathname + "/index.php" +mc_js_url.search + mc_js_url.hash;
                                    }else{
                                        var yeni_url = this_a.attr("href");
                                    }
                                   yukle(yeni_url); 
                                }, 100);
                                
                            }else{
                                mc_js_kilit = false;
                                return true;
                            }
                        }else{
                            return true;
                        }
                    }
                    return false;
                }
            });
        }
        window.addEventListener("popstate", function(e) {
            mc_js_icerik.fadeOut(100);
            setTimeout(function(){
                mc_js_icerik.empty();
                yukle(window.location.href);
            }, 100);
            return false;
        });
    },
    mc_js_dosyasorgula: function(url){
        var matches = url.match(/\/([^\/?#]+)[^\/]*$/);
        if ($.isArray(matches) && matches.length > 1) {
            var parcali_url = matches[1].split(".");
            if($.isArray(parcali_url) && parcali_url.length > 1){ return true; }else{ return false; }
        }else{ return true; }
    }
};
var edge = 'Microsoft Edge';
var ie10 = 'Internet Explorer 10';
var ie11 = 'Internet Explorer 11';
var opera = 'Opera';
var firefox = 'Mozilla Firefox';
var chrome = 'Google Chrome';
var safari = 'Safari';
$.mcPanel.tarayici = {
    aktif: function () {
        var _this = this;
        var className = _this.getClassName();
        if (className !== '') $('html').addClass(_this.getClassName());
    }, getBrowser: function(){
        var userAgent = navigator.userAgent.toLowerCase();
        if(/edge/i.test(userAgent)){ return edge; }
        else if(/rv:11/i.test(userAgent)){ return ie11; }
        else if(/msie 10/i.test(userAgent)){ return ie10; }
        else if(/opr/i.test(userAgent)){ return opera; }
        else if(/chrome/i.test(userAgent)){ return chrome; }
        else if(/firefox/i.test(userAgent)){ return firefox; }
        else if(!!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/)){ return safari; }
        return undefined;
    }, getClassName: function(){
        var browser = this.getBrowser();
        if(browser === edge){ return 'edge'; }
        else if(browser === ie11){ return 'ie11'; }
        else if(browser === ie10){ return 'ie10'; }
        else if(browser === opera){ return 'opera'; }
        else if(browser === chrome){ return 'chrome'; }
        else if(browser === firefox){ return 'firefox'; }
        else if(browser === safari){ return 'safari'; }
        else{ return ''; }
    }
};
$(function () {
    $.mcPanel.post.aktif();
    $.mcPanel.tarayici.aktif();
    $.mcPanel.solMenu.aktif();
    $.mcPanel.sagMenu.aktif();
    $.mcPanel.navbar.aktif();
    $.mcPanel.dropdownMenu.aktif();
    $.mcPanel.input.aktif();
    $.mcPanel.ara.aktif();
    setTimeout(function () { $('.page-loader-wrapper').fadeOut(); }, 50);
});