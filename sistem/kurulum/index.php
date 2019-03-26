<?php
    if(!defined('m_guvenlik')) { define("m_guvenlik", true); }
    
    if(!defined('m_kurulum')) { define("m_kurulum", true); }
    
    if(isset($_GET['adim'])){
        $mc_kurulum_adim = $_GET['adim'];
    }else{
        $mc_kurulum_adim = 1;
    }
    
    require_once $_SERVER["DOCUMENT_ROOT"].'/index.php';
    
    $mc_kurulum_url = parse_url(m_url, PHP_URL_PATH);
    
    if($mc_kurulum_kk){
        if($mc_kurulum_adim > 3 && (!isset($_POST['yuzde']) || $mc_kurulum_adim != $mc_kurulum_son)){            
            $mc_kurulum_adim = 2;
        }        
        if(isset($_SESSION['kuruluyor'])){ unset($_SESSION['kuruluyor']); }
    }else{
        $_SESSION['kuruluyor'] = true;
    }
    
    if(!empty($_GET)){ require 'get.php'; }
    
    if(!empty($_POST)){ require 'post.php'; }
    
?>
﻿<!DOCTYPE html>
<html lang="<?=$mc_dil?>">
    <head>
        <meta charset="UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"/>
        <title><?=mc_dil('kurulum_yapiliyor')?></title>
        <link rel="icon" href="<?=mc_img?>favicon.ico" type="image/x-icon"/>
        <link href="<?=mc_plugins?>bootstrap/css/bootstrap.css" rel="stylesheet"/>
        <link href="<?=mc_plugins?>node-waves/waves.min.css" rel="stylesheet" />
        <link href="<?=mc_plugins?>animate-css/animate.css" rel="stylesheet" />
        <link href="<?=mc_plugins?>bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
        <link href="<?=mc_css?>style.css?v=25" rel="stylesheet" />
        <link href="<?=mc_css?>themes/light.css" rel="stylesheet" />
        <link href="<?=mc_css?>themes/theme-light-blue.css" rel="stylesheet" />
        <script> function mc_loadEvent(a){var b=window.onload;window.onload="function"!=typeof window.onload?a:function(){b(),a();};} </script>
        <style>
            .container-fluid .card { box-shadow: none; }
            .container-fluid .card .header { padding: 17px 19px; }
            section.content {margin-top: 0px;}
            .left_top_user{padding:13px 15px 12px 15px}
            .left_top_user .info-container .name{font-size:14px}
            .left_top_user .info-container .email{font-size:12px;padding-right: 20px}
            .left_top_user .info-container .user-helper-dropdown{right:-3px;bottom:-8px}
            .sidebar .menu{padding-bottom:130px}
            .sidebar{height:calc(100vh - 70px)}
        </style>
    </head>
    <body class="theme-light-blue">
         <div class="page-loader-wrapper">
            <div class="loader">
                <div class="preloader">
                    <div class="spinner-layer pl-red">
                        <div class="circle-clipper left"><div class="circle"></div></div>
                        <div class="circle-clipper right"><div class="circle"></div></div>
                    </div>
                </div>
                <p><?=mc_dil('lutfen_bekleyiniz')?>...</p>
            </div>
        </div>
        <div class="overlay"></div>    
        <section>
            <aside id="leftsidebar" class="sidebar" style="top:0;height: 100%;">
                <div class="user-info left_top_user">
                    <div class="image">
                        <img style="border-radius: 0;" src="<?=mc_img?>logofb.png" width="48" height="48" alt="Mikrocode" />
                    </div>
                    <div class="info-container">
                        <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=mc_dil('m_kurulum')?></div>
                        <div class="email">destek@mikrocode.net</div>
                    </div>
                </div>
                <div class="menu">
                    <ul class="list">
                        <?php if($mc_kurulum_kk){ if($mc_kurulum_adim ==1){ ?>
                            <li class="active"><a href="javascript:void(0);">
                                <i class="material-icons">outlined_flag</i><span><?=mc_dil('guncelleme_basliyor')?></span>
                            </a></li>
                            <li><a href="javascript:void(0);">
                                <i class="material-icons">supervised_user_circle</i><span><?=mc_dil('kullanici_kontrol')?></span>
                            </a></li>
                            <li><a href="javascript:void(0);">
                                <i class="material-icons">flag</i><span><?=mc_dil('guncellemeyi_tamamla')?></span>
                            </a></li>
                        <?php }else if($mc_kurulum_adim == 2){ ?>
                            <li><a href="<?=$mc_kurulum_url?>?adim=1">
                                <i class="material-icons">outlined_flag</i><span><?=mc_dil('guncelleme_basliyor')?></span>
                            </a></li>
                            <li class="active"><a href="javascript:void(0);">
                                <i class="material-icons">supervised_user_circle</i><span><?=mc_dil('kullanici_kontrol')?></span>
                            </a></li>
                            <li><a href="javascript:void(0);">
                                <i class="material-icons">flag</i><span><?=mc_dil('guncellemeyi_tamamla')?></span>
                            </a></li>
                        <?php }else{ ?>
                            <li><a href="<?=$mc_kurulum_url?>?adim=1">
                                <i class="material-icons">outlined_flag</i><span><?=mc_dil('guncelleme_basliyor')?></span>
                            </a></li>
                            <li><a href="<?=$mc_kurulum_url?>?adim=2">
                                <i class="material-icons">supervised_user_circle</i><span><?=mc_dil('kullanici_kontrol')?></span>
                            </a></li>
                            <li class="active"><a href="javascript:void(0);">
                                <i class="material-icons">flag</i><span><?=mc_dil('guncellemeyi_tamamla')?></span>
                            </a></li>
                        <?php } }else{ if($mc_kurulum_adim==1){ ?>
                            <li class="active"><a href="javascript:void(0);">
                                <i class="material-icons">outlined_flag</i><span><?=mc_dil('ilk_kurulum')?></span>
                            </a></li>
                            <li><a href="javascript:void(0);">
                                <i class="material-icons">data_usage</i><span><?=mc_dil('vt_ayarlari')?></span>
                            </a></li>
                            <li><a href="javascript:void(0);">
                                <i class="material-icons">supervised_user_circle</i><span><?=mc_dil('super_kullanici_olustur')?></span>
                            </a></li>
                            <li><a href="javascript:void(0);">
                                <i class="material-icons">zoom_in</i><span><?=mc_dil('kurulum_ake')?></span>
                            </a></li>
                            <li><a href="javascript:void(0);">
                                <i class="material-icons">flag</i><span><?=mc_dil('kurulumu_tamamla')?></span>
                            </a></li>
                        <?php }else if($mc_kurulum_adim==2){ ?>
                            <li><a href="<?=$mc_kurulum_url?>?adim=1">
                                <i class="material-icons">outlined_flag</i><span><?=mc_dil('ilk_kurulum')?></span>
                            </a></li>
                            <li class="active"><a href="javascript:void(0);">
                                <i class="material-icons">data_usage</i><span><?=mc_dil('vt_ayarlari')?></span>
                            </a></li>
                            <li><a href="javascript:void(0);">
                                <i class="material-icons">supervised_user_circle</i><span><?=mc_dil('super_kullanici_olustur')?></span>
                            </a></li>
                            <li><a href="javascript:void(0);">
                                <i class="material-icons">zoom_in</i><span><?=mc_dil('kurulum_ake')?></span>
                            </a></li>
                            <li><a href="javascript:void(0);">
                                <i class="material-icons">flag</i><span><?=mc_dil('kurulumu_tamamla')?></span>
                            </a></li>
                        <?php }else if($mc_kurulum_adim==3){ ?>
                            <li><a href="<?=$mc_kurulum_url?>?adim=1">
                                <i class="material-icons">outlined_flag</i><span><?=mc_dil('ilk_kurulum')?></span>
                            </a></li>
                            <li><a href="<?=$mc_kurulum_url?>?adim=2">
                                <i class="material-icons">data_usage</i><span><?=mc_dil('vt_ayarlari')?></span>
                            </a></li>
                            <li class="active"><a href="javascript:void(0);">
                                <i class="material-icons">supervised_user_circle</i><span><?=mc_dil('super_kullanici_olustur')?></span>
                            </a></li>
                            <li><a href="javascript:void(0);">
                                <i class="material-icons">zoom_in</i><span><?=mc_dil('kurulum_ake')?></span>
                            </a></li>
                            <li><a href="javascript:void(0);">
                                <i class="material-icons">flag</i><span><?=mc_dil('kurulumu_tamamla')?></span>
                            </a></li>
                        <?php }else if($mc_kurulum_adim==4){ ?>
                            <li><a href="<?=$mc_kurulum_url?>?adim=1">
                                <i class="material-icons">outlined_flag</i><span><?=mc_dil('ilk_kurulum')?></span>
                            </a></li>
                            <li><a href="<?=$mc_kurulum_url?>?adim=2">
                                <i class="material-icons">data_usage</i><span><?=mc_dil('vt_ayarlari')?></span>
                            </a></li>
                            <li><a href="<?=$mc_kurulum_url?>?adim=3">
                                <i class="material-icons">supervised_user_circle</i><span><?=mc_dil('super_kullanici_olustur')?></span>
                            </a></li>
                            <li class="active"><a href="javascript:void(0);">
                                <i class="material-icons">zoom_in</i><span><?=mc_dil('kurulum_ake')?></span>
                            </a></li>
                            <li><a href="javascript:void(0);">
                                <i class="material-icons">flag</i><span><?=mc_dil('kurulumu_tamamla')?></span>
                            </a></li>
                        <?php }else if($mc_kurulum_adim==5){ ?>
                            <li><a href="<?=$mc_kurulum_url?>?adim=1">
                                <i class="material-icons">outlined_flag</i><span><?=mc_dil('ilk_kurulum')?></span>
                            </a></li>
                            <li><a href="<?=$mc_kurulum_url?>?adim=2">
                                <i class="material-icons">data_usage</i><span><?=mc_dil('vt_ayarlari')?></span>
                            </a></li>
                            <li><a href="<?=$mc_kurulum_url?>?adim=3">
                                <i class="material-icons">supervised_user_circle</i><span><?=mc_dil('super_kullanici_olustur')?></span>
                            </a></li>
                            <li><a href="<?=$mc_kurulum_url?>?adim=4">
                                <i class="material-icons">zoom_in</i><span><?=mc_dil('kurulum_ake')?></span>
                            </a></li>
                            <li class="active"><a href="javascript:void(0);">
                                <i class="material-icons">flag</i><span><?=mc_dil('kurulumu_tamamla')?></span>
                            </a></li>
                        <?php } } ?>
                    </ul>
                </div>
                <div class="legal">
                    <div class="copyright">&copy; 2018 <a href="//mikrocode.net" target="_blank">Mikrocode</a>.</div>
                </div>        
            </aside>
        </section>
        <section class="content">
            <div class="container-fluid"><?php if($mc_kurulum_kk){ include "k".$mc_kurulum_adim.'.php'; }else{ include $mc_kurulum_adim.'.php'; }?></div>
        </section>
    </body>
    <script src="<?=mc_plugins?>jquery/jquery.min.js"></script>
    <script src="<?=mc_plugins?>bootstrap/js/bootstrap.js"></script>
    <script src="<?=mc_plugins?>node-waves/waves.min.js"></script>
    <script src="<?=mc_plugins?>bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?=mc_plugins?>bootstrap-notify/bootstrap-notify.min.js"></script>
    <script src="<?=mc_js?>kurulum.js"></script> 
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css"/>
</html>