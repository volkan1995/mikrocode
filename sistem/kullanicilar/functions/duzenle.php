<?php
    if(!defined('m_guvenlik')) { exit; }    
    if(isset($_POST['kaydet']) && isset($_POST['kayit_tip'])){
        
        $_POST['id'] = intval(@$_POST['id']);
        
        $post_kullanici = $m_vt->select()->from("kullanicilar")->where("id",$_POST['id'])->result();
        if(!count($post_kullanici) > 0){  mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>Kullanıcı kaydı bulunamadı"); }        
        $post_kullanici = $post_kullanici[0];
        
        if(($post_kullanici->id != mc_oturum_id && $mc_oturum->grup > 2) || ($mc_oturum->grup < 3 && $post_kullanici->grup < $mc_oturum->grup)){ mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>Bu kullanıcıyı düzenlemeye yetkiniz yok"); }
        
        $sorgu_where = array();
        
        if($_POST['kayit_tip'] == "genel"){
            
            if(empty($_POST['profil'])){ $sorgu_where['resim'] = 0; }else{ $sorgu_where['resim'] = intval($_POST['profil']); }
            
            $sorgu_where['ad'] = trim(@$_POST['name']);
            $sorgu_where['soyad'] = trim(@$_POST['surname']);
            if(strlen($sorgu_where['ad'])<2 || strlen($sorgu_where['soyad'])<2){ mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>".mc_dil('as_enaz2')); }
            
            $_POST['sex'] = intval(@$_POST['sex']); 
            if($_POST['sex'] < 0 || $_POST['sex'] > 2){ $_POST['sex'] = 0; }
            
        }else if($_POST['kayit_tip'] == "iletisim"){
            
            $sorgu_where['mail'] = trim(strip_tags(@$_POST['email']));
            $mail_kontrol = mc_mail_kontrol($sorgu_where['mail']);        
            if(!$mail_kontrol[0]){ mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>".$mail_kontrol[1]); }
            
            $post_kullanici->eklenti = m_jsonDegistir($post_kullanici->eklenti, 'tel', trim(m_tirnak_temizle(strip_tags(@$_POST['tel']))), false);
            
            $post_kullanici->eklenti = m_jsonDegistir($post_kullanici->eklenti, 'adres', trim(m_tirnak_temizle(strip_tags(@$_POST['adres']))), false);
            
        }else if($_POST['kayit_tip'] == "izinler"){            
            $modul_hash = null;
            if($mc_oturum->grup < 3 && isset($_POST['izinler'])){
                foreach ($_POST['izinler'] as $modul_key => $modul) {
                    if(isset($modul[0]) && $modul[0] == 1){ $modul_hash = "1"; }else{ $modul_hash = "0"; }
                    if(isset($modul[1]) && $modul[1] == 1){ $modul_hash .= "1"; }else{ $modul_hash .= "0"; }
                    if(isset($modul[2]) && $modul[2] == 1){ $modul_hash .= "1"; }else{ $modul_hash .= "0"; }
                    if(isset($modul[3]) && $modul[3] == 1){ $modul_hash .= "1"; }else{ $modul_hash .= "0"; }
                    $grup_dizi[$modul_key] = $modul_hash;
                }
                if(isset($grup_dizi)){
                    $sorgu_where['izinler'] = m_jsonDegistir($post_kullanici->izinler, 'moduler', $grup_dizi, false);
                }
            }          
        }else if($_POST['kayit_tip'] == "guvenlik"){
            if(!empty(trim(@$_POST['password']))) {
                $sifre_kontrol = mc_sifre_kontrol(@$_POST['password'], @$_POST['repassword']);
                if(!$sifre_kontrol[0]){
                    echo "<b>Başarısız!</b> ".$sifre_kontrol[1]; exit;
                }
                $sorgu_where['sifre'] = $sifre_kontrol[2];
            }
        }
        
        $sorgu_where['eklenti'] = $post_kullanici->eklenti;        
        $mc_kaydet = $m_vt->guncelle([
            'table'=>"kullanicilar",
            'values'=>$sorgu_where,
            'where' => ['id'=>$post_kullanici->id]
        ])['sonuc'];
        if($mc_kaydet){ mc_uyari(-1,"<b>".mc_dil('basarili')."</b>Kullanıcı düzenlendi"); }else{ mc_uyari(-4,"<b>".mc_dil('basarili')."</b>Kullanıcı bilinmeyen bir hatadan dolayı düzenlenemedi."); }     
    }
    
    if(!isset($_GET['id'])){ m_git("/404"); }
    
    if($mc_oturum->grup > 2){
        $get_kullanici = $m_vt->select()->from("kullanicilar")->where("id",$_GET['id'])->where("kadi",$_GET['id'],"=","OR")->result();
    }else{
        $get_kullanici = $m_vt->select()->from("kullanicilar")->in()
            ->where("id",$_GET['id'])->where("kadi",$_GET['id'],"=","OR")
            ->out()->where("grup",$mc_oturum->grup,">=")->result();
    }
    
    if(!count($get_kullanici)){ m_git("/404"); }    
    $get_kullanici = $get_kullanici[0];    
    $get_kullanici->eklenti = json_decode($get_kullanici->eklenti);        
    $mc_title = mc_dil('kullanici_duzenle');    
    $engelli_moduller = array( '..', '.','index.php', 'loader.php','giris.php', 'cikis.php','kullanicilar', 'tema-olustur', 'modul.php' ,'anketler_arge');
    $moduller = array_diff(scandir(m_moduller), $engelli_moduller);
    $moduller[] = "ek_ozellikler";
    $moduller[] = "m_api";
    $moduller[] = "mesajlar";
    $moduller[] = "dosyalar";
    $tema_modulleri = m_tema . "plugins" . DIRECTORY_SEPARATOR . "yonetici";
    if(file_exists($tema_modulleri) && is_dir($tema_modulleri)){
        $moduller = array_merge($moduller, array_diff(scandir($tema_modulleri), $engelli_moduller));
    }