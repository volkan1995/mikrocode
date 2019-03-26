<?php
    if(!defined('m_guvenlik')) { exit; }
    
    if(isset($_POST['renk'])){
        if(isset($mc_temarenkler[$_POST['renk']])){
            $mc_oturum->tema = m_jsonDegistir($mc_oturum->tema, "renk", $_POST['renk']);
            $m_vt->guncelle(['table'=>"kullanicilar",'values'=>['tema'=>json_encode($mc_oturum->tema)],'where' => ['id'=>mc_oturum_id]])['sonuc'];
        }        
        exit;
    }else if(isset($_POST['mod'])){        
        if($_POST['mod'] == "true"){
            $mc_oturum->tema = m_jsonDegistir($mc_oturum->tema, "mod", "dark");
        }else{
            $mc_oturum->tema = m_jsonDegistir($mc_oturum->tema, "mod", "light");
        }
        $m_vt->guncelle(['table'=>"kullanicilar",'values'=>['tema'=>json_encode($mc_oturum->tema)],'where' => ['id'=>mc_oturum_id]])['sonuc'];
        exit;
    }
    
    $guncelle_values = array();
    
    if(isset($_POST['secili_dil']) && isset($mc_diller->{$_POST['secili_dil']})){
        
        $mc_oturum->tema = m_jsonDegistir($mc_oturum->tema, "dil", $_POST['secili_dil']);
        
        $_SESSION['dil'] = $mc_oturum->tema->dil;    
        
        $_COOKIE["kullanici_dil"] = $mc_oturum->tema->dil;
        
        $guncelle_values['tema'] = json_encode($mc_oturum->tema);
        
    }
    
    if(isset($_POST['muzikcalar'])){
        
        $mc_oturum->eklenti = m_jsonDegistir($mc_oturum->eklenti, "muzikcalar", $_POST['muzikcalar']);
        
        if(isset($_POST['muzik_g']) && is_array($_POST['muzik_g'])){
            
            $mc_oturum->eklenti = m_jsonDegistir($mc_oturum->eklenti, "muzikler", implode(",", $_POST['muzik_g']));
            
        }
        
        $guncelle_values['eklenti'] = json_encode($mc_oturum->eklenti);
        
    }
    
    $mc_kaydet = $m_vt->guncelle(['table'=>"kullanicilar",'values'=>$guncelle_values,'where' => ['id'=>mc_oturum_id]])['sonuc'];
        
    mc_uyari($mc_kaydet,["<b>Başarılı</b>Ayarlarınız kaydedildi","<b>Başarısız</b>Ayarlarınız bilinmeyen bir sebepten dolayı kaydedilemedi"]);