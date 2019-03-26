<?php
    if(!defined('m_guvenlik')) { exit; }
    
    require 'ayar.php';
    
    if(isset($_POST['kaydet'])){
        
        if(empty($_POST['baslik'])){ mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>".mc_dil('bos_alanlar_var')); }
    
        $yetki = mc_yetki($mc_modul_ayar['menu'], 1, false, false);
        if(isset($mc_modul_ayar['tasarim']['kategori']) && $mc_modul_ayar['tasarim']['kategori']){
            if(empty($_POST['kategori']) || intval($_POST['kategori']) <= 0){ mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>".mc_dil('kategori_seciniz')); }
            $get_kategori = $m_vt->select()->from($mc_modul_ayar['ust_tablo'])->where("id", $_POST['kategori'])->result();
            if(count($get_kategori)){
                if($get_kategori[0]->ekleyen != mc_oturum_id){
                    mc_ozel_yetki([$mc_modul_ayar['ust_tablo'] => $get_kategori[0]->id]);    
                }
            }else{
                mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>".mc_dil('kategori_seciniz'));
            }
        }else{
            $_POST['kategori'] = 0;
        }
        if(!$yetki){ mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>Bu işlem için yetkiniz yok."); }
        
        if(empty($_POST['sef'])){ $_POST['sef'] = $_POST['baslik']; } $_POST['sef'] = mc_sefurl($_POST['sef']);        
        
        if(count($m_vt->select()->from($mc_modul_ayar['tablo'])->where("sef",$_POST['sef'])->where($mc_modul_ayar['ust'], $_POST['kategori'])->where("tip",$mc_modul_ayar['tip'])->result()) > 0){
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
        
        $mc_kaydet = $m_vt->ekle([
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
                'ekleyen' => mc_oturum_id,
                'resim' => $_POST['kapak'],
                'eklenti' => $mc_json
            ]
        ]);
        
        if($mc_kaydet['sonuc']){
            if($mc_oturum->grup < 3 && isset($_POST['izinler']) && is_array($_POST['izinler'])){
                foreach ($_POST['izinler'] as $k_id) {
                    $k_sorgu = $m_vt->select("`id`,`izinler`,`grup`,`kadi`")->from('kullanicilar')->where('id', $k_id)->result();
                    if(count($k_sorgu) && $k_sorgu[0]->grup > 2){
                        $k_sorgu[0]->izinler = json_decode($k_sorgu[0]->izinler, true);
                        if(isset( $k_sorgu[0]->izinler[$mc_modul_ayar['tablo']]) && in_array($mc_kaydet['id'], $k_sorgu[0]->izinler[$mc_modul_ayar['tablo']])){ continue; }
                        $k_sorgu[0]->izinler[$mc_modul_ayar['tablo']][] = $mc_kaydet['id'];
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
            }
            mc_uyari(-1,"<b>".mc_dil('basarili')."</b>Yeni içerik oluşturuldu");
        }else{
            mc_uyari(-4,"<b>".mc_dil('basarili')."</b>İçerik bilinmeyen bir hatadan dolayı oluşturulamadı.");
        }
        
    }

    $mc_title = mc_dil($mc_modul_ayar['ekle']);