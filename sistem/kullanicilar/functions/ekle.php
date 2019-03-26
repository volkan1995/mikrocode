<?php
    if(!defined('m_guvenlik')) { exit; }
    
    if($mc_oturum->grup > 2){
        m_git("/404");
    }
    
    if(isset($_POST['kaydet'])){
        
        unset($_POST['kaydet']);
        
        $_POST['username'] = trim(@$_POST['username']);
        $kadi_kontrol = mc_kadi_kontrol($_POST['username']);        
        if(!$kadi_kontrol[0]){ mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>".$kadi_kontrol[1]); }
        
        $_POST['email'] = trim(@$_POST['email']);
        $mail_kontrol = mc_mail_kontrol($_POST['email']);        
        if(!$mail_kontrol[0]){ mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>".$mail_kontrol[1]); }
        
        $sifre_kontrol = mc_sifre_kontrol(@$_POST['password'], @$_POST['repassword']);        
        if(!$sifre_kontrol[0]){ mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>".$sifre_kontrol[1]); }
        
        $_POST['name'] = trim(@$_POST['name']);
        $_POST['surname'] = trim(@$_POST['surname']);
        if(strlen($_POST['name'])<2 || strlen($_POST['surname'])<2){ mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>".mc_dil('as_enaz2')); }
        
        $_POST['grup'] = intval(@$_POST['grup']);        
        if($mc_oturum->grup > $_POST['grup']){ mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>Üst seviye kullanıcı eklenemez"); }
        
        if(count($m_vt->select()->from("kullanicilar")->where("kadi",$_POST['username'])->where("mail",$_POST['email'],"=","OR")->result()) > 0){
            mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>Aynı bilgilerde kullanıcı kaydı mevcut");
        }
        
        $_POST['sex'] = intval(@$_POST['sex']); 
        if($_POST['sex'] < 0 || $_POST['sex'] > 2){ $_POST['sex'] = 0; }
        
        if(empty($_POST['yayin'])){ $_POST['yayin'] = 0; }else{ $_POST['yayin'] = 1; }
        
        if(empty($_POST['profil'])){ $_POST['profil'] = 0; }else{ $_POST['profil'] = intval($_POST['profil']); }
        
        $mc_kaydet = $m_vt->ekle([
            'table'=>"kullanicilar",
            'values'=>[
                'kadi' => $_POST['username'],
                'grup' =>$_POST['grup'],
                'mail' => $_POST['email'],
                'sifre' => $sifre_kontrol[2],
                'ad' => $_POST['name'],
                'soyad' => $_POST['surname'],
                'resim' => $_POST['profil']
            ]
        ])['sonuc'];
        
        if($mc_kaydet){
            mc_uyari(-1,"<b>".mc_dil('basarili')."</b>Yeni kullanıcı oluşturuldu");
        }else{
            mc_uyari(-4,"<b>".mc_dil('basarili')."</b>Kullanıcı bilinmeyen bir hatadan dolayı oluşturulamadı.");
        }
        
    }
    
    $mc_title = mc_dil('kullanici_ekle');