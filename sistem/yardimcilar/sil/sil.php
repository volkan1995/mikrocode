<?php
    if(empty($_POST['tablo']) && empty($_POST['id'])){ exit; }    
    require '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'yonetici' . DIRECTORY_SEPARATOR . 'loader.php';
    
    require m_cekirdek.'fonksiyonlar' . DIRECTORY_SEPARATOR . 'sil.php';
    
    if(!is_numeric($_POST['id'])){
        $mc_dataid = $_POST['id'];
        if(!is_array($mc_dataid)){ $_POST['id'] = json_decode($_POST['id']); }
        if(count($_POST['id']) > 1){
            if(isset($_POST['onay']) && $_POST['onay'] == "onay"){      
                $silme_syc = 15;              
                $mc_bul = $m_vt->select()->from($_POST['tablo'])->inwhere('id', $_POST['id'])->result(false);
                if(count($mc_bul) && extension_loaded('sqlite3')){
                    if(array_key_exists('kategori', $mc_bul[0])){                        
                        $post_kat_dizi = array();
                        $izinsiz = array();
                        foreach ($mc_bul as $v) { if(!in_array('kategori', $post_kat_dizi)){ $post_kat_dizi[] = $v['kategori']; } }
                        if(count($post_kat_dizi)){
                            foreach ($m_vt->select()->from('kategoriler')->inwhere('id', $post_kat_dizi)->result() as $v) {
                                if(array_key_exists('izinler', $v)){
                                    if(!mc_ic_yetki($v->izinler, 2, false, false)){ $izinsiz[] = $v->id; }
                                }                                
                            }
                        }
                        if(count($izinsiz)){
                            foreach ($mc_bul as $k => $v) {
                                if(in_array($v['kategori'], $izinsiz)){
                                    if(array_key_exists('baslik', $v)){
                                        mc_uyari(3, "<b>".mc_dil('yetkisiz_islem')."</b>".$v['baslik']." verisini silmek için yetkiniz yok!");
                                    }else{
                                        mc_uyari(3, "<b>".mc_dil('yetkisiz_islem')."</b>".$v['id']." numaralı veriyi silmek için yetkiniz yok");
                                    }
                                    unset($mc_bul[$k]);                                    
                                }
                            }
                        }
                    }
                    $sqlite3_id = m_sqliteKaydet([
                        'tablo' => $_POST['tablo'],
                        'data' => $mc_bul
                    ]);
                    if($sqlite3_id != false && count($sqlite3_id)){
                        $_POST['id'] = $sqlite3_id;
                        if($m_vt->select()->from($_POST['tablo'])->inwhere('id', $_POST['id'])->delete()){
                            echo "<script>";
                            foreach ($_POST['id']  as $value) {
                                echo "setTimeout(function(){ $('#mc_liste_{$value}').animate({'margin-left':'-300px','opacity':0}, 400); setTimeout(function(){ $('#mc_liste_{$value}').remove(); }, 350); }, {$silme_syc});";
                                $silme_syc += 15;
                            }
                            echo "</script>";                
                            mc_uyari(-2, '<b>Başarılı!</b>'.mc_dil($_POST['tablo']).' silindi');
                        }
                    }
                }                     
                echo "<script>$('.mc_liste_coklug, .mcd_coklusilbtn').fadeOut(300); </script>";
            }else{
                mc_uyari(-3, '<b>Siliniyor!</b>'.mc_dil($_POST['tablo']).' siliniyor<br/><a class="btn btn-sm btn-danger waves-effect m-t-10 sil-onay" data-notify="dismiss" data-tablo="'.$_POST['tablo'].'" data-id="'.$mc_dataid.'">Devam Et</a> <a class="btn btn-sm btn-default waves-effect m-t-10 alert-onay" data-notify="dismiss">Vazgeç</a>', 20000);
            }            
        }else if(count($_POST['id']) <= 0){ exit; }
        $_POST['id'] = $_POST['id'][0];
    }
    if(!isset($_POST['baslik'])){ exit; }
    $mc_sil_bul = $m_vt->select()->from($_POST['tablo'])->where('id', $_POST['id'])->result();    
    if(!count($mc_sil_bul)){ mc_uyari(-4, "<b>Veri bulunamadı</b>Silmek istediğiniz veri bulunamadı"); }
    $mc_sil_bul = $mc_sil_bul[0];
    $mc_databaslik = $_POST['baslik'];
    if(empty($_POST['baslik']) || !isset($mc_sil_bul->{$_POST['baslik']})){ $_POST['baslik'] = "Veri"; }else{ $_POST['baslik'] = $mc_sil_bul->{$_POST['baslik']}; }
    if(isset($_POST['onay']) && $_POST['onay'] == "onay"){        
        $mc_bul = $m_vt->select()->from($_POST['tablo'])->where('id', $_POST['id'])->result(false);
        $mc_sil = false;
        if(count($mc_bul) && extension_loaded('sqlite3')) {
            if(array_key_exists('kategori', $mc_bul[0])){
                $izin_kat = $m_vt->select()->from('kategoriler')->where('id', $mc_bul[0]['kategori'])->result();
                if(count($izin_kat) && array_key_exists('izinler', $izin_kat[0])){
                    mc_ic_yetki($izin_kat[0]->izinler, 2, true);
                }
            }
            $sqlite3_id = m_sqliteKaydet([
                'tablo' => $_POST['tablo'],
                'data' => $mc_bul
            ]);
            if($sqlite3_id != false && count($sqlite3_id)){
                $_POST['id'] = $sqlite3_id[0];
                $mc_sil = $m_vt->select()->from($_POST['tablo'])->where('id', $_POST['id'])->delete();
            }
        }
        if(!$mc_sil){ mc_uyari(-4, '<b>Başarılı!</b>'.$_POST['baslik'].' silinemedi'); }
        echo "<script>$('#mc_liste_{$mc_sil_bul->id}').animate({'margin-left':'-300px','opacity':0}, 400); setTimeout(function(){ $('#mc_liste_{$mc_sil_bul->id}').remove(); }, 350); $('.mc_liste_coklug, .mcd_coklusilbtn').fadeOut(300); </script>";
        mc_uyari(-2, '<b>Başarılı!</b>'.$_POST['baslik'].' silindi');
    }else{
        mc_uyari(-3, '<b>Siliniyor!</b>'.$_POST['baslik'].' siliniyor<br/><a class="btn btn-sm btn-danger waves-effect m-t-10 sil-onay" data-notify="dismiss" data-tablo="'.$_POST['tablo'].'" data-baslik="'.$mc_databaslik.'" data-id="'.$_POST['id'].'">Devam Et</a> <a class="btn btn-sm btn-default waves-effect m-t-10 alert-onay" data-notify="dismiss">Vazgeç</a>', 20000);
    }
    
    exit;