<?php
    if(!defined('m_guvenlik')) { exit; }
    
    require_once m_cekirdek."fonksiyonlar/api.php";
    
    if(isset($_POST['kaydet'])){
        
        mc_yetki("m_api",1);
        
        unset($_POST['kaydet']);
        
        $api_use = array();
        if(isset($_POST['api_use'])){
            foreach ($_POST['api_use'] as $k => $v) {
                if($v == 1 && isset($mc_istekler[$k])){ $api_use[] = $k; }
            }
        }
        
        if(empty($_POST['baslik']) || empty($_POST['kod']) || empty($_POST['key']) || !count($api_use)){
            mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>".mc_dil('bos_alanlar_var'));
        }
        
        if(count($m_vt->select()->from("mapi")->in()
                ->where("kod",$_POST['kod'])
                ->where("anahtar",$_POST['key'],"=","OR")
                ->where("baslik",$_POST['baslik'],"=","OR")
                ->out()->where("tip",0)->result()) > 0){
            mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>Aynı kod veya anahtar kaydı mevcut");
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
        
        $mc_kaydet = $m_vt->ekle([
            'table'=>"mapi",
            'values'=>[
                'baslik' => $_POST['baslik'],
                'tip' => 0,
                'durum' =>$mapi_durum,
                'kod' => $_POST['kod'],
                'anahtar' => $_POST['key'],
                'dongu' => $mapi_dongu,
                'sayac' => 0,
                'istemci' => $mapi_istemciler,
                'servis' => implode(",", $api_use)
            ]
        ])['sonuc'];
        
        if($mc_kaydet){
            mc_uyari(-1,"<b>".mc_dil('basarili')."</b>Yeni API oluşturuldu");
        }else{
            mc_uyari(-4,"<b>".mc_dil('basarili')."</b>API bilinmeyen bir hatadan dolayı oluşturulamadı.");
        }
        
    }
    
    $mc_title = mc_dil('api_olustur');