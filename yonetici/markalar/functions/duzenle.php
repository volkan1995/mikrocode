<?php
    if(!defined('m_guvenlik')) { exit; }
    
    require 'ayar.php';
    
    if(isset($_POST['kaydet'])){
        
        $_POST['id'] = intval(@$_POST['id']);
        $post_kategori = $m_vt->select()->from($mc_modul_ayar['tablo'])->where("id",$_POST['id'])->result();
        if(count($post_kategori) == 0){
            mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>İçerik kaydı bulunamadı");
        }
        
        $yetki = mc_yetki($mc_modul_ayar['menu'], 2, false, false);
        if($post_kategori[0]->{$mc_modul_ayar['ust']} > 0){
            $get_kategori = $m_vt->select()->from($mc_modul_ayar['ust_tablo'])->where("id",$post_kategori[0]->{$mc_modul_ayar['ust']})->result();
            if(count($get_kategori)){
                if(!$yetki){
                    if($get_kategori[0]->ekleyen != mc_oturum_id){
                        $yetki = mc_ozel_yetki([$mc_modul_ayar['ust_tablo'] => $get_kategori[0]->id, $mc_modul_ayar['tablo'] => $_POST['id']], false, false); 
                    }else{
                        $yetki = true;
                    }
                }
            }else{
                mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>".mc_dil('kategori_seciniz'));
            }
        }
        if(!$yetki){ mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>Bu işlem için yetkiniz yok."); }
        
        if(empty($_POST['baslik'])){ mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>".mc_dil('bos_alanlar_var')); }
        
        if(isset($mc_modul_ayar['tasarim']['kategori']) && $mc_modul_ayar['tasarim']['kategori']){
            if(empty($_POST['kategori']) || intval($_POST['kategori']) <= 0){ mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>".mc_dil('kategori_seciniz')); }
            $get_kategori = $m_vt->select()->from($mc_modul_ayar['ust_tablo'])->where("id",$_POST['kategori'])->result();
            if(count($get_kategori) && $get_kategori[0]->ekleyen != mc_oturum_id){
                mc_ozel_yetki([$mc_modul_ayar['ust_tablo'] => $get_kategori[0]->id, $mc_modul_ayar['tablo'] => $_POST['id']]);
            }
        }else{
            $_POST['kategori'] = 0;
        }
        
        if(empty($_POST['sef'])){ $_POST['sef'] = $_POST['baslik']; } $_POST['sef'] = mc_sefurl($_POST['sef']);       
        
        if(count($m_vt->select()->from($mc_modul_ayar['tablo'])
                ->in()->where("sef",$_POST['sef'])->where("tip",$mc_modul_ayar['tip'])->where($mc_modul_ayar['ust'], $_POST['kategori'])
                ->out()->where("id",$_POST['id'],"<>")
                ->result()) > 0){
            mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>Zaten benzer bir içerik kaydı mevcut");
        }
        
        if(!isset($_POST['m_editor'])){ $_POST['m_editor'] = null; }
        
        if(!isset($_POST['aciklama'])){ $_POST['aciklama'] = null; }
        
        if(!isset($_POST['kapak'])){ $_POST['kapak'] = 0; }else{ $_POST['kapak'] = intval($_POST['kapak']); }
        
        if(isset($mc_modul_ayar['tasarim']['yayin']) && $mc_modul_ayar['tasarim']['yayin']){
            if(!isset($_POST['yayin'])){ $_POST['yayin'] = 0; }else{ $_POST['yayin'] = intval($_POST['yayin']); }
        }else{
            $_POST['yayin'] = 1;
        }
        
        if(!isset($_POST['vurgula'])){ $_POST['vurgula'] = 0; }else{ $_POST['vurgula'] = intval($_POST['vurgula']); }
        
        $mc_json = array();
        
        if(isset($_POST['galeri']) && !empty($_POST['galeri'])){ $mc_json['galeri'] = $_POST['galeri']; }        
        if(isset($_POST['video']) && $_POST['video'] > 0){ $mc_json['video'] = $_POST['video']; }        
        if(isset($_POST['ek']) && !empty($_POST['ek'])){ $mc_json['ek'] = $_POST['ek']; }        
        if(isset($_POST['ek_b'])){ $mc_json['ek_b'] = $_POST['ek_b']; }
        if(isset($_POST['ek_a'])){ $mc_json['ek_a'] = $_POST['ek_a']; }
        if(isset($_POST['ek_u'])){ $mc_json['ek_u'] = $_POST['ek_u']; }
        if(isset($_POST['ek_y'])){ $mc_json['ek_y'] = $_POST['ek_y']; } 
        
        $mc_json = json_encode($mc_json);
        
        $mc_kaydet = $m_vt->guncelle([
            'table'=>$mc_modul_ayar['tablo'],
            'values'=>[
                'baslik' => $_POST['baslik'],
                'sef' => $_POST['sef'],
                'aciklama' => $_POST['aciklama'],
                'icerik' => $_POST['m_editor'],
                'tip' => $mc_modul_ayar['tip'],
                $mc_modul_ayar['ust'] => $_POST['kategori'],
                'durum' => $_POST['yayin'],
                'vurgula' => $_POST['vurgula'],
                'duzenleyen' => mc_oturum_id,
                'resim' => $_POST['kapak'],
                'eklenti' => $mc_json
            ],
            'where' => ['id'=>$_POST['id']]
        ])['sonuc'];
        
        if($mc_kaydet){
            if($mc_oturum->grup < 3){
                if(isset($_POST['izinler']) && is_array($_POST['izinler'])){
                    foreach ($m_vt->select("`id`,`izinler`,`grup`,`kadi`")->from('kullanicilar')->like('izinler', $_POST['id'])->result() as $kullanici) {
                        $kullanici->izinler = json_decode($kullanici->izinler, true);
                        if(isset($kullanici->izinler[$mc_modul_ayar['tablo']]) && in_array($_POST['id'], $kullanici->izinler[$mc_modul_ayar['tablo']])){
                            if(in_array($kullanici->id, $_POST['izinler'])){ continue; }
                            $key = array_search($_POST['id'], $kullanici->izinler[$mc_modul_ayar['tablo']]);
                            unset($kullanici->izinler[$mc_modul_ayar['tablo']][$key]);
                            $mc_kaydet = $m_vt->guncelle([
                                'table'=>"kullanicilar",
                                'values'=>[ 'izinler' => json_encode($kullanici->izinler) ],
                                'where' => ['id'=> $kullanici->id]
                            ])['sonuc'];
                        }
                    }
                    foreach ($_POST['izinler'] as $k_id) {                    
                        $k_sorgu = $m_vt->select("`id`,`izinler`,`grup`,`kadi`")->from('kullanicilar')->where('id', $k_id)->result();
                        if(count($k_sorgu) && $k_sorgu[0]->grup > 2){
                            $k_sorgu[0]->izinler = json_decode($k_sorgu[0]->izinler, true);
                            if(isset( $k_sorgu[0]->izinler[$mc_modul_ayar['tablo']]) && in_array($_POST['id'], $k_sorgu[0]->izinler[$mc_modul_ayar['tablo']])){ continue; }
                            $k_sorgu[0]->izinler[$mc_modul_ayar['tablo']][] = $_POST['id'];
                            if(isset($k_sorgu[0]->izinler['moduler'][$mc_modul_ayar['yetki']])){
                                $k_sorgu[0]->izinler['moduler'][$mc_modul_ayar['yetki']] = "1111";
                            }
                            $mc_kaydet = $m_vt->guncelle([
                                'table' => "kullanicilar",
                                'values' => [ 'izinler' => json_encode($k_sorgu[0]->izinler) ],
                                'where' => [ 'id'=> $k_id ]
                            ])['sonuc'];
                            if(!$mc_kaydet){
                                mc_uyari(3,"<b>İzin ayarlanamadı</b>".$k_sorgu[0]->kadi." kullanıcısının izni ayarlanırken bir sorun oluştu.");
                            }
                        }
                    }
                }else{
                    foreach ($m_vt->select("`id`,`izinler`,`grup`,`kadi`")->from('kullanicilar')->like('izinler', $_POST['id'])->result() as $kullanici) {
                        $kullanici->izinler = json_decode($kullanici->izinler, true);
                        if(isset($kullanici->izinler[$mc_modul_ayar['tablo']]) && in_array($_POST['id'], $kullanici->izinler[$mc_modul_ayar['tablo']])){
                            $key = array_search($_POST['id'], $kullanici->izinler[$mc_modul_ayar['tablo']]);
                            unset($kullanici->izinler[$mc_modul_ayar['tablo']][$key]);
                            $mc_kaydet = $m_vt->guncelle([
                                'table'=>"kullanicilar",
                                'values'=>[ 'izinler' => json_encode($kullanici->izinler) ],
                                'where' => ['id'=> $kullanici->id]
                            ])['sonuc'];
                        }
                    }
                }
            }
            mc_uyari(-1,"<b>".mc_dil('basarili')."</b>İçerik düzenlendi");            
        }else{
            mc_uyari(-4,"<b>".mc_dil('basarili')."</b>İçerik bilinmeyen bir hatadan dolayı düzenlenemedi.");
        }      
    }
    
    if(!isset($_GET['id'])){ exit; }
    
    $get_yazi = $m_vt->select()->from($mc_modul_ayar['tablo'])->where('tip', $mc_modul_ayar['tip'])->where("id",$_GET['id'])->result();
    
    if(!count($get_yazi)){ exit; }
    
    $get_yazi = $get_yazi[0];
    
    $get_kategori = $m_vt->select()->from($mc_modul_ayar['ust_tablo'])->where("id",$get_yazi->{$mc_modul_ayar['ust']})->result();
    
    $yetki = mc_yetki($mc_modul_ayar['menu'], 2, false, false);    
    if(count($get_kategori)){
        if($get_yazi->ekleyen != mc_oturum_id && $get_kategori[0]->ekleyen != mc_oturum_id){
            $yetki = mc_ozel_yetki([$mc_modul_ayar['ust_tablo'] => $get_kategori[0]->id, $mc_modul_ayar['tablo'] => $_GET['id']], false, false);
        }else{
            $yetki = true;
        }
    }
    if(!$yetki){ mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>Bu işlem için yetkiniz yok."); }
    
    if(strlen($get_yazi->eklenti) > 3){ $get_yazi->eklenti = json_decode($get_yazi->eklenti); }
    
    if(isset($mc_modul_ayar['tasarim']['ek']) && $mc_modul_ayar['tasarim']['ek']){        
        $m_ekid['b'] = m_jsonAl($get_yazi->eklenti,'ek_b');
        $m_ekid['a'] = m_jsonAl($get_yazi->eklenti,'ek_a');
        $m_ekid['u'] = m_jsonAl($get_yazi->eklenti,'ek_u');
        $m_ekid['y'] = m_jsonAl($get_yazi->eklenti,'ek_y');        
    }
    
    $mc_title = mc_dil('duzenle').": ".$get_yazi->baslik;