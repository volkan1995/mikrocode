<?php
    if(!defined('m_guvenlik')) { exit; }
    
    if($mc_oturum->grup > 2){
        m_git("/404");
    }
    
    require_once m_cekirdek."fonksiyonlar/api.php";
    
    if(isset($_POST['kaydet'])){
        
        if(empty($_POST['baslik'])){
            mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>".mc_dil('bos_alanlar_var'));
        }
        
        $_POST['id'] = intval($_POST['id']);
        
        if(count($m_vt->select()->from("gruplar")->where("id",$_POST['id'],"<>")->where("baslik",$_POST['baslik'])->result()) > 0){
            mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>Aynı başlıkta grup kaydı mevcut");
        }
        
        if(isset($_POST['panel'])){ $_POST['panel'] = intval($_POST['panel']); }else{ $_POST['panel'] = 0; }
        
        if(isset($_POST['site'])){ $_POST['site'] = intval($_POST['site']); }else{ $_POST['site'] = 0; }
        
        $modul_hash = null;
        if(isset($_POST['izinler'])){
            foreach ($_POST['izinler'] as $modul_key => $modul) {
                if(isset($modul[0]) && $modul[0] == 1){ $modul_hash = "1"; }else{ $modul_hash = "0"; }
                if(isset($modul[1]) && $modul[1] == 1){ $modul_hash .= "1"; }else{ $modul_hash .= "0"; }
                if(isset($modul[2]) && $modul[2] == 1){ $modul_hash .= "1"; }else{ $modul_hash .= "0"; }
                if(isset($modul[3]) && $modul[3] == 1){ $modul_hash .= "1"; }else{ $modul_hash .= "0"; }
                $grup_dizi[$modul_key] = $modul_hash;
            } 
        }
        
        $mc_kaydet = $m_vt->guncelle([
            'table'=>"gruplar",
            'values'=>[
                'baslik' => $_POST['baslik'],
                'panel' => $_POST['panel'],
                'site' => $_POST['site'],
                'yetki'=> json_encode($grup_dizi)
            ],
            'where' => ['id'=>$_POST['id']]
        ])['sonuc'];
        
        if($mc_kaydet){
            mc_uyari(-1,"<b>".mc_dil('basarili')."</b>Grup düzenlendi");
        }else{
            mc_uyari(-4,"<b>".mc_dil('basarili')."</b>Grup bilinmeyen bir hatadan dolayı düzenlenemedi.");
        }
        
    }
    
    if($mc_oturum->grup > 2){  m_git("/404"); }
    
    if(!isset($_GET['id']) || empty($_GET['id'])){ exit; }
        
    $_GET['id'] = intval($_GET['id']);
    
    $mc_veri = $m_vt->select()->from("gruplar")->where("id",$_GET['id'])->result();

    if(!count($mc_veri)){ exit; }
    
    $mc_veri = $mc_veri[0];

    $mc_title = mc_dil('grup_duzenleniyor');
    
    $engelli_moduller = array( '..', '.','index.php', 'loader.php','giris.php', 'cikis.php','kullanicilar', 'tema-olustur', 'yonetici.php' ,'anketler_arge');
    $moduller = array_diff(scandir(m_moduller), $engelli_moduller);
    $moduller[] = "ek_ozellikler";
    $moduller[] = "m_api";
    $moduller[] = "mesajlar";
    $moduller[] = "dosyalar";
    $tema_modulleri = m_tema . "plugins" . DIRECTORY_SEPARATOR . "yonetici";
    if(file_exists($tema_modulleri) && is_dir($tema_modulleri)){
        $moduller = array_merge($moduller, array_diff(scandir($tema_modulleri), $engelli_moduller));
    }