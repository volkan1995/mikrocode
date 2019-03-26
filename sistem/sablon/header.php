<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title><?= $mc_title ?></title>
        <link rel="icon" href="<?= m_domain . '/sablon/temalar/' . mt_isim ?>/favicon.ico" type="image/x-icon"/>    
        <link href="<?= mc_plugins ?>bootstrap/css/bootstrap.css?v=2" rel="stylesheet" />
        <link href="<?= mc_plugins ?>animate-css/animate.css?v=2" rel="stylesheet" />
        <link href="<?= mc_css ?>style.css?v=25" rel="stylesheet" />
        <link href="<?= mc_css ?>themes/<?= $mc_renk_tema?>.css" rel="stylesheet" id="mod_teması" konum="<?= mc_css ?>themes/"/>
        <link href="<?= mc_css ?>themes/theme-<?= $mc_oturum->tema->renk ?>.css?v=25" id="renk_temasi" konum="<?= mc_css ?>themes/" rel="stylesheet" />   
        <script>
        var mc_timerStart = Date.now();
        function mc_hazir(mc_funcs) {
            /in/.test(document.readyState) ? setTimeout('mc_hazir(' + mc_funcs + ')', 9) : mc_funcs();
        }
        var m_gelistirici = <?= m_gelistirici ? "true" : "false" ?>;
        var mc_dosya_m = false;
        var mc_dosya_p = false;
        var post_array = {};
        var cssArray = [];
        var mc_FKaydetTF = true;
        var mc_js_calistir = <?= $mc_ps == 1 ? "true" : "false" ?>;
        var mc_js_icerik = null;
        var mc_js_hata = "<?= mc_dil('bu_sayfada_hata_var') ?>!<br/><?= mc_dil('sayfa') ?>: ";
        var m_domain = window.location.protocol + "//" + window.location.host;
        var mc_sistem = m_domain + "/sistem/";
        var mc_plugins = "<?= mc_plugins ?>";
        var mcd_kaydet = "<?= mc_dil('kaydet') ?>";
        var mcd_lutfen_bekleyiniz = "<?= mc_dil('lutfen_bekleyiniz') ?>";
        var last_keycode = 0;
        mc_loadJs = function (url, opts) {
            opts = $.extend(opts || {}, {dataType: "script", cache: true, url: url});
            return $.ajax(opts);
        };
        mc_loadCss = function (href) {
            if ($.inArray(href, cssArray) != -1) {
                return true;
            }
            cssArray.push(href);
            var cssLink = $("<link>");
            $("head").append(cssLink);
            cssLink.attr({rel: "stylesheet", type: "text/css", href: href});
            return true;
        };
    </script>
    <script src="<?= mc_plugins ?>jquery/jquery.min.js?v=2"></script>
</head>
<body>
<div class="nprogress-back"></div>
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-<?= $mc_oturum->tema->renk ?>">
                <div class="circle-clipper left"><div class="circle"></div></div>
                <div class="circle-clipper right"><div class="circle"></div></div>
            </div>
        </div><p><?= mc_dil('lutfen_bekleyiniz') ?>...</p>
    </div>
</div>
<div class="overlay"></div>    
<div class="search-bar">
    <div class="search-icon"><i class="material-icons">search</i></div>
    <input type="text" placeholder="Her yerde ara..."/>
    <div class="close-search"><i class="material-icons">close</i></div>
</div>    
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">  
            <?php if ($mc_muzikcalar) { ?>
                <div class="user-info left_top_user">
                    <div class="image">
                        <img src="<?= m_resim($mc_oturum->resim, 48, 48) ?>" width="48" height="48" title="<?= $mc_oturum->mail ?>" />
                    </div>
                    <div class="info-container">
                        <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $m_baslik ?></div>
                        <div class="email"><?= $mc_oturum->name ?></div>
                        <div class="btn-group user-helper-dropdown">
                            <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="<?= mc_sistem ?>kullanicilar/profil.php"><i class="material-icons">person</i><?= mc_dil('profilim') ?></a></li>
                                <li><a href="<?= mc_sistem ?>kullanicilar/duzenle.php?id=<?= mc_oturum_id ?>"><i class="material-icons">edit</i><?= mc_dil('profilimi_duzenle') ?></a></li>
                                <li role="seperator" class="divider"></li>
                                <li><a href="<?= mc_panel ?>cikis.php" target="_self"><i class="material-icons">input</i><?= mc_dil('cikis_yap') ?></a></li>
                            </ul>
                        </div>
                    </div>
                    <style>
                        .left_top_user{padding:1px 0;float: left}
                        .left_top_user .info-container .name{font-size:15px}
                        .left_top_user .info-container .email{font-size:13px}
                        .left_top_user .info-container .user-helper-dropdown{right:0;bottom:0} 
                        .sidebar .menu{padding-bottom:20px}
                        .sidebar{height:calc(90vh - 70px)}
                        #mc_js_icerik{padding-bottom: 70px}
                    </style>
                </div>   
            <?php } else { ?>
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?= mc_panel ?>"><?= $m_baslik ?></a>
                <ul class="nav navbar-left">                    
                    <li data-toggle="tooltip" class="nav_sag_btn" data-placement="bottom" title="Siteyi görüntüle" data-original-title="Siteyi görüntüle">
                        <a href="/" target="_blank" style="padding: 13px 10px 7px 10px;">
                            <i class="material-icons font-30">desktop_windows</i>
                        </a>
                    </li>
                </ul>
                <style>
                    .left_top_user{padding:13px 15px 12px 15px}
                    .left_top_user .info-container .name{font-size:14px}
                    .left_top_user .info-container .email{font-size:12px;padding-right: 20px}
                    .left_top_user .info-container .user-helper-dropdown{right:-3px;bottom:-8px}
                    .sidebar .menu{padding-bottom:130px}
                    .sidebar{height:calc(100vh - 70px)}
                </style>
            <?php } ?>             
            <a href="javascript:void(0);" class="bars"></a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">                    
                <li style="display:none">
                    <a href="javascript:void(0);" class="js-search" data-close="true">
                        <i class="material-icons">search</i>
                    </a>
                </li>                
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        <i class="material-icons">message</i>
                        <span class="label-count mc_mesajlar_sayac"><?= $mc_mesajlar_count ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"><?= mc_dil('mesajlar') ?></li>
                        <li class="body">
                            <ul class="menu">
                                <?php foreach ($mc_mesajlar as $mesaj) { ?>
                                    <li class="mc_mesaj_id_<?= $mesaj->id ?>">
                                        <a href="<?= m_domain ?>/sistem/mesajlar/goruntule.php?id=<?= $mesaj->id ?>">
                                            <div class="icon-circle bg-theme"><i class="material-icons">message</i></div>
                                            <div class="menu-info">
                                                <h4><?= $mesaj->baslik ?></h4>
                                                <p><i class="material-icons">access_time</i> <?= m_tarih('j F Y H:i', $mesaj->tarih) ?>
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li class="footer"><a href="<?= mc_sistem ?>mesajlar/"><?= mc_dil('tum_mesajlari_goster') ?></a></li>
                    </ul>
                </li>                    
                <li class="pull-right">
                    <a href="javascript:void(0);" class="js-right-sidebar" data-close="true" style="padding:2px;">
                        <i class="material-icons<?= $t_count > 0 ? ' m_fade_animate' : null ?>" style="font-size:29px;">blur_on</i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<section>
    <aside id="leftsidebar" class="sidebar">
        <?php if (!$mc_muzikcalar) { ?>
            <div class="user-info left_top_user">
                <div class="image">
                    <img src="<?= m_resim($mc_oturum->resim, 48, 48) ?>" width="48" height="48" title="<?= $mc_oturum->name ?>" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $mc_oturum->name ?></div>
                    <div class="email"><?= $mc_oturum->mail ?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="<?= mc_sistem ?>kullanicilar/profil.php"><i class="material-icons">person</i><?= mc_dil('profilim') ?></a></li>
                            <li><a href="<?= mc_sistem ?>kullanicilar/duzenle.php?id=<?= mc_oturum_id ?>"><i class="material-icons">edit</i><?= mc_dil('profilimi_duzenle') ?></a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="<?= mc_panel ?>cikis.php" target="_self"><i class="material-icons">input</i><?= mc_dil('cikis_yap') ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
        } echo '<div class="menu"><ul class="list">' . $mc_menu->sol_menu() . '</ul></div>';
        if (!$mc_muzikcalar) {
            ?>
            <div class="legal">
                <div class="copyright">&copy; <?= date('Y') ?> <a href="<?= m_firma_url ?>"><?= m_firma ?></a></div>
            </div>
        <?php } ?>
    </aside>        
    <aside id="rightsidebar" class="right-sidebar">
        <ul class="nav nav-tabs tab-nav-right" role="tablist">
            <li role="presentation" class="active" style="width: 100%;"><a href="#hizli_menu" data-toggle="tab"><?= mc_dil('eylem_merkezi') ?></a></li>
        </ul>
        <div class="tab-content" style="height: 80%;">
            <div role="tabpanel" class="tab-pane fade in active in active" id="hizli_menu">
                <p></p>
                <a href="#genel_ayarlar" data-toggle="tab" class="col-xs-12 col-md-6 col-theme">
                    <div class="demo-color-box">
                        <div><i class="material-icons">settings</i></div>
                        <div><?= mc_dil('genel_ayarlar') ?></div>
                    </div>
                </a>
                <a href="#renk_ayarla" data-toggle="tab" class="col-xs-12 col-md-6 col-theme">
                    <div class="demo-color-box">
                        <div><i class="material-icons">color_lens</i></div>
                        <div><?= mc_dil('tema_rengi') ?></div>
                    </div>
                </a>
                <a href="<?= mc_sistem ?>kullanicilar/profil.php" class="col-xs-12 col-md-6 col-theme">
                    <div class="demo-color-box">
                        <div><i class="material-icons">person</i></div>
                        <div><?= mc_dil('profilim') ?></div>
                    </div>
                </a>
                <a href="<?= mc_sistem ?>kullanicilar/duzenle.php?id=<?= mc_oturum_id ?>" class="col-xs-12 col-md-6 col-theme">
                    <div class="demo-color-box">
                        <div><i class="material-icons">edit</i></div>
                        <div><?= mc_dil('profilimi_duzenle') ?></div>
                    </div>
                </a>                    
                <a href="#bildirim_listele" data-toggle="tab" class="col-xs-12 col-md-6 col-theme">
                    <div class="demo-color-box">
                        <div><i class="material-icons">notifications</i></div>
                        <div><?= mc_dil('bildirimler') ?></div>
                        <?php
                        if (count($mc_bildirimler)) {
                            echo '<span class="label-count">' . count($mc_bildirimler) . '</span>';
                        }
                        ?>
                    </div>
                </a>
                <a href="#ekran_alintisi" data-toggle="tab" class="col-xs-12 col-md-6 col-theme">
                    <div class="demo-color-box">
                        <div><i class="material-icons">add_a_photo</i></div>
                        <div><?= mc_dil('ekran_alintisi') ?></div>
                    </div>
                </a>
                <a href="<?= mc_panel ?>cikis.php" target="_self" class="col-xs-12 col-md-6 col-theme">
                    <div class="demo-color-box">
                        <div><i class="material-icons">input</i></div>
                        <div><?= mc_dil('cikis_yap') ?></div>
                    </div>
                </a>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="genel_ayarlar">
                <p></p>
                <?php
                $mc_genelayarlar = $mc_menu->menu_sec(['ayarlar', 0]);
                if (!empty($mc_genelayarlar) && isset($mc_genelayarlar->gorev) && is_array($mc_genelayarlar->gorev)) {
                    foreach ($mc_genelayarlar->gorev as $altmenu) {
                        if (isset($altmenu->gorev) && is_string($altmenu->gorev)) {
                            if (!m_gelistirici && isset($altmenu->gelistirici) && $altmenu->gelistirici == true) {
                                continue;
                            }
                            if (isset($altmenu->admin) && $altmenu->admin && $mc_oturum->grup > 2) {
                                continue;
                            }
                            echo '<a href="' . mc_sistem . $altmenu->gorev . '" class="col-xs-12 col-md-6 col-theme"><div class="demo-color-box">';
                            echo '<div><i class="material-icons">' . $altmenu->ikon . '</i></div>';
                            echo '<div>' . mc_dil($altmenu->baslik) . '</div>';
                            echo '</div></a>';
                        }
                    }
                }
                $mc_tumayarlar = $mc_menu->menu_sec(['ayarlar']);
                if (!empty($mc_tumayarlar) && isset($mc_tumayarlar->gorev) && is_array($mc_tumayarlar->gorev)) {
                    if (!isset($altmenu->admin) || !$altmenu->admin || $mc_oturum->grup < 3) {
                        foreach ($mc_tumayarlar->gorev as $altmenu) {
                            if (isset($altmenu->gizlilik) && $altmenu->gizlilik == 2) {
                                continue;
                            }
                            if (!m_gelistirici && isset($altmenu->gelistirici) && $altmenu->gelistirici == true) {
                                continue;
                            }
                            if (isset($altmenu->admin) && $altmenu->admin && $mc_oturum->grup > 2) {
                                continue;
                            }
                            if (isset($altmenu->gorev) && is_string($altmenu->gorev)) {
                                echo '<a href="' . mc_sistem . $altmenu->gorev . '" class="col-xs-12 col-md-6 col-theme"><div class="demo-color-box">';
                                echo '<div><i class="material-icons">' . $altmenu->ikon . '</i></div>';
                                echo '<div>' . mc_dil($altmenu->baslik) . '</div>';
                                echo '</div></a>';
                            } else if (isset($altmenu->adres)) {
                                echo '<a href="' . mc_sistem . $altmenu->adres . '" class="col-xs-12 col-md-6 col-theme"><div class="demo-color-box">';
                                echo '<div><i class="material-icons">' . $altmenu->ikon . '</i></div>';
                                echo '<div>' . mc_dil($altmenu->baslik) . '</div>';
                                echo '</div></a>';
                            }
                        }
                    }
                }
                ?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="renk_ayarla">
                <div class="switch mc_tema_mod">
                    <b>Koyu Tema</b>
                    <label>
                        <input type="checkbox" onchange="mc_temamod(this.checked)"<?=$mc_renk_tema=="dark"?" checked":null?>/>
                        <span class="lever switch-col-theme"></span>
                    </label>
                </div>
                <ul class="demo-choose-skin">
                    <?php
                    foreach ($mc_temarenkler as $renk_en => $renk) {
                        if ($renk_en == $mc_oturum->tema->renk) {
                            echo "<li data-theme='$renk_en' class='active'>";
                        } else {
                            echo "<li data-theme='$renk_en'>";
                        }
                        echo "<div class='$renk_en'></div><span>$renk</span></li>";
                    }
                    ?>
                </ul>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="bildirim_listele">
                <?php
                foreach ($mc_bildirimler as $bildirim) {
                    echo '<div class="m-alert padding-0 m-alert-' . $bildirim['tip'] . '">';
                    $bildirim['icerik'] = "<p>{$bildirim['icerik']}</p>";
                    if (isset($bildirim['resim']) && !empty($bildirim['resim'])) {
                        $bildirim['icerik'] = $bildirim['icerik'] . '<div class="m-alert-img"><img class="otoload" data-src="' . $bildirim['resim'] . '"></div>';
                    }
                    $bildirim['icerik'] = '<strong>' . $bildirim['baslik'] . '</strong><div class="m-alert-body">' . $bildirim['icerik'] . "</div>";

                    if (isset($bildirim['adres']) && !empty($bildirim['adres'])) {
                        $bildirim['icerik'] = '<a href="' . $bildirim['adres'] . '">' . $bildirim['icerik'] . '</a>';
                    }
                    echo $bildirim['icerik'];

                    echo '</div>';
                }
                ?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="ekran_alintisi">
                <p></p>
                <a href="javascript:void(0);" data-crop="html" class="ekran_alintisi_btn col-xs-12 col-md-6 col-theme">
                    <div class="demo-color-box">
                        <div><i class="material-icons">crop_free</i></div>
                        <div><?= mc_dil('sayfayi_kirp') ?></div>
                    </div>
                </a>
                <a href="javascript:void(0);" data-crop="#mc_js_icerik" class="ekran_alintisi_btn col-xs-12 col-md-6 col-theme">
                    <div class="demo-color-box">
                        <div><i class="material-icons">crop</i></div>
                        <div><?= mc_dil('icerigi_kirp') ?></div>
                    </div>
                </a>
                <a href="javascript:void(0);" data-crop="#leftsidebar ul.list" class="ekran_alintisi_btn col-xs-12 col-md-6 col-theme">
                    <div class="demo-color-box">
                        <div><i class="material-icons">crop_portrait</i></div>
                        <div><?= mc_dil('menuyu_kirp') ?></div>
                    </div>
                </a>
            </div>
        </div>
        <div style="height: 20%;">
            <div class="col-md-12 m-t-5">
                <small>                   
                    Sunucu Yanıt Zamanı : <font id='mc_sure_sunucu'></font> ms<br/>
                    Sayfa Boyutu : <font id='mc_boyut_sayfa'></font> KB<br/>
                    Sayfa Yüklenme Süresi <font id='mc_sure_sayfa'></font> ms
                </small>
            </div>
        </div>
    </aside>        
</section>
<section class="content">
    <?php if (m_gelistirici && $mc_oturum->grup < 3) { ?>
    <div class="col-xs-12">
        <div class="mc_console m-t-10 m-b-10" id="mc_console"></div>
    </div>
    <script>
        mc_loadJs(mc_plugins + "console/console.js").done(function () {
            mc_loadCss(mc_plugins + "console/console.css");
            mobileConsole.show();
        });
    </script>
    <?php } ?>
    <div class="container-fluid p-b-10" id="mc_js_icerik">