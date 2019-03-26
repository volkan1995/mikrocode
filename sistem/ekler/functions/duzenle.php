<?php
    if(!defined('m_guvenlik')) { exit; }
    
    if(isset($_POST['kaydet'])){
        
        mc_yetki("ek_ozellikler",2);
        
        unset($_POST['kaydet']);
        
        if(empty($_POST['baslik'])){ mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>".mc_dil('bos_alanlar_var')); }
        
        if(empty($_POST['sef'])){ $_POST['sef'] = $_POST['baslik']; }
        
        $_POST['sef'] = mc_sefurl($_POST['sef']);   
        
        $_POST['id'] = intval($_POST['id']);
        
        if(count($m_vt->select()->from("ekler")->where("id",$_POST['id'],"<>")->where("sef",$_POST['sef'])->result()) > 0){
            mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>Zaten benzer bir ek özellik kaydı mevcut");
        }
        
        if(!isset($_POST['m_editor'])){ $_POST['m_editor'] = null; }
        
        if(!isset($_POST['aciklama'])){ $_POST['aciklama'] = null; }
        
        if(!isset($_POST['kapak'])){ $_POST['kapak'] = 0; }else{ $_POST['kapak'] = intval($_POST['kapak']); }
        
        if(!isset($_POST['yayin'])){ $_POST['yayin'] = 0; }else{ $_POST['yayin'] = intval($_POST['yayin']); }
        
        $post_json = array();
        
        if(isset($_POST['adres']) && !empty($_POST['adres'])){ $post_json['adres'] = $_POST['adres']; }
        if(isset($_POST['adresy']) && !empty($_POST['adresy'])){ $post_json['adresy'] = $_POST['adresy']; }
        if(isset($_POST['galeri']) && !empty($_POST['galeri'])){ $post_json['galeri'] = $_POST['galeri']; }
        if(isset($_POST['video']) && !empty($_POST['video'])){ $post_json['video'] = $_POST['video']; }
        if(isset($_POST['icon']) && !empty($_POST['icon'])){ $post_json['icon'] = $_POST['icon']; }
        if(!isset($_POST['html']) || $_POST['html'] != 1){
            $post_json['html'] = 0;
            $_POST['m_editor'] = strip_tags($_POST['m_editor']);
        }
        
        if(count($post_json)){ $post_json = json_encode($post_json); }else{ $post_json = null; }
        
        $mc_kaydet = $m_vt->guncelle([
            'table'=>"ekler",
            'values'=>[
                'baslik' => $_POST['baslik'],
                'sef' => $_POST['sef'],
                'aciklama' => $_POST['aciklama'],
                'icerik' => $_POST['m_editor'],
                'durum' => $_POST['yayin'],
                'resim' => $_POST['kapak'],
                'eklenti' => $post_json
            ],
            'where' => ['id'=>$_POST['id']]
        ])['sonuc'];
        
        if($mc_kaydet){
            mc_uyari(-1,"<b>".mc_dil('basarili')."</b>Ek özellik düzenlendi");
        }else{
            mc_uyari(-4,"<b>".mc_dil('basarili')."</b>Ek özellik bilinmeyen bir hatadan dolayı düzenlenemedi.");
        }
        
    }
    
    if(!isset($_GET['id'])){ exit; }
    
    $get_ekozellik = $m_vt->select()->from("ekler")->where("id",$_GET['id'])->result();
    
    if(!count($get_ekozellik)){ exit; }
    
    $get_ekozellik = $get_ekozellik[0];
    
    if(strlen($get_ekozellik->eklenti) > 3){ $get_ekozellik->eklenti = json_decode($get_ekozellik->eklenti); }
    
    $mc_title = mc_dil('duzenle').": ".$get_ekozellik->baslik;