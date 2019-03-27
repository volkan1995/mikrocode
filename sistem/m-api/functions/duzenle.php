<?php
    if(!defined('m_guvenlik')) { exit; }    
    
    require_once m_cekirdek."fonksiyonlar/api.php";
    
    if(isset($_POST['kaydet'])){
        
        mc_yetki("m_api",2);
        
        unset($_POST['kaydet']);
        
        $api_use = array();
        if(isset($_POST['api_use'])){
            foreach ($_POST['api_use'] as $k => $v) {
                if($v == 1 && isset($mc_istekler[$k])){ $api_use[] = $k; }
            }
        }
        
        if(empty($_POST['baslik']) || empty($_POST['id']) || !count($api_use)){
            mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>".mc_dil('bos_alanlar_var'));
        }
        
        $_POST['id'] = intval($_POST['id']);
        
        if(count($m_vt->select()->from("mapi")->where("id",$_POST['id'],"<>")->where("baslik",$_POST['baslik'])->where("tip",0)->result()) > 0){
            mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>Aynı başlıkta API kaydı mevcut");
        }
        
        if(!empty($_POST['istemci'])){        
            $mapi_istemciler_exp = explode(",", $_POST['istemci']);    
            if(count($mapi_istemciler_exp) > 5){
                mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>En fazla 5 istemci belirlenebilir");
            }
            $mapi_istemciler = json_encode($mapi_istemciler_exp);
        }else{ $mapi_istemciler = null; }
        
        if(isset($_POST['limit']) && $_POST['limit'] > 0){
            $_POST['limit'] = intval($_POST['limit']);
            if($_POST['limit'] > 3600){
                mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>Saatlik istek 3600 limitini geçemez");
            }
            $mapi_dongu = json_encode(array('s'=>date('ymdH'), 'l'=>$_POST['limit']));
        }else{ $mapi_dongu = null; }
        
        if(isset($_POST['yayin'])){ $mapi_durum = $_POST['yayin']; }else{ $mapi_durum = 0; }
        
        $mc_kaydet = $m_vt->guncelle([
            'table'=>"mapi",
            'values'=>[
                'baslik' => $_POST['baslik'],
                'durum' =>$mapi_durum,
                'dongu' => $mapi_dongu,
                'istemci' => $mapi_istemciler,
                'servis' => implode(",", $api_use)
            ],
            'where' => ['id'=>$_POST['id']]
        ])['sonuc'];
        
        if($mc_kaydet){
            mc_uyari(-1,"<b>".mc_dil('basarili')."</b>API düzenlendi");
        }else{
            mc_uyari(-4,"<b>".mc_dil('basarili')."</b>API bilinmeyen bir hatadan dolayı düzenlenemedi.");
        }
        
    }
    
    if(!isset($_GET['id']) || empty($_GET['id'])){ exit; }
        
    $_GET['id'] = intval($_GET['id']);
    
    $mc_veri = $m_vt->select()->from("mapi")->where("id",$_GET['id'])->result();

    if(!count($mc_veri)){ exit; }
    
    $mc_veri = $mc_veri[0];

    $mc_title = mc_dil('api_duzenleniyor');
    
    $mapi_istemciler = array();
    
    if(strlen($mc_veri->istemci) > 0){
        $mapi_istemciler = json_decode($mc_veri->istemci);
        $mc_veri->istemci = implode(",", $mapi_istemciler);
    }

    $mc_veri_limit = 0;
    if(strlen($mc_veri->dongu) > 0){
        $mc_veri->dongu = json_decode($mc_veri->dongu);
        if(isset($mc_veri->dongu->l)){
            $mc_veri_limit = $mc_veri->dongu->l;
        }
    }
    
    $mc_servisler = explode(",", $mc_veri->servis);
    
    $api_headers = array(
        'id' => $mc_veri->kod,        
        'key' => $mc_veri->anahtar
    );