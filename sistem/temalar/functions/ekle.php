<?php
    if(!defined('m_guvenlik')) { exit; }    
    if(isset($_POST['kaydet'])){
        mc_yetki("temalar",1);
        unset($_POST['kaydet']);        
        if(empty($_POST['tema'])){ mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>".mc_dil('lutfen_tema_seciniz')); }        
        $mt_sec = $m_vt->select()->from("dosyalar")->where('id', $_POST['tema'])->result();        
        if(!count($mt_sec)){ mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>".mc_dil('lutfen_gecerli_tema_seciniz')); }        
        $zip = new ZipArchive;        
        $tema_ac = $zip->open(m_dosyalar.ltrim($mt_sec[0]->konum,"/"));        
        if($tema_ac != true){ mc_uyari(-3,"<b>".mc_dil('basarisiz')."</b>".mc_dil('tema_dosyasi_acilamadı')); }        
        $tema_isim = mc_dosya_ismi(basename($mt_sec[0]->konum));        
        $zip->extractTo(m_temalar.$tema_isim);         
        $zip->close();
        if(isset($_POST['kurulumsil']) && $_POST['kurulumsil'] == 1){
            $m_vt->select()->from("dosyalar")->where('id', $mt_sec[0]->id)->delete();             
        }
        if(isset($_POST['yayin']) && $_POST['yayin'] == 1){            
            $mc_vtd = '<?php '."\n"
            . 'if(!defined(\'m_guvenlik\')){ exit; }'."\n"
            . 'define("mdb_driver", "'.mdb_driver.'");'."\n"
            . 'define("mdb_ctype", "'.mdb_ctype.'");'."\n"
            . 'define("mdb_server", "'.mdb_server.'");'."\n"
            . 'define("mdb_port", "'.mdb_port.'");'."\n"
            . 'define("mdb_name", "'.mdb_name.'");'."\n"
            . 'define("mdb_user", "'.mdb_user.'");'."\n"
            . 'define("mdb_pass", "'.mdb_pass.'");'."\n"
            . 'define("mt_isim", "'.$tema_isim.'");'."\n"   
            . 'define("m_firma", "'.m_firma.'");'."\n"
            . 'define("m_firma_url", "'.m_firma_url.'");';      
            $mc_vta = fopen(m_depo."veritabani.php","w");            
            if(!$mc_vta){ }
            flock ($mc_vta, 2); 
            fwrite($mc_vta,$mc_vtd);
            flock ($mc_vta, 3); 
            fclose($mc_vta);        
            if(isset($_POST['yapilandir']) && $_POST['yapilandir'] == 1){
                if(file_exists(m_temalar.$tema_isim."/settings.xml")){
                    $xml = simplexml_load_file(m_temalar.$tema_isim."/settings.xml");
                    foreach ($xml as $tn => $tv) {
                        if(is_object($tv)){
                            foreach ($tv as $k => $v) {
                                if(count($v) == 0){
                                    if(count($m_vt->select()->from("ekler")->where('sef', $k)->result()) == 0){
                                        $m_vt->ekle(['table'=>"ekler",'values'=>['baslik' => $v, 'sef' => $k]]);
                                    }
                                }
                            }
                        }
                    }
                    mc_uyari(-1,"<b>".mc_dil('basarili')."</b>".mc_dil('tema_dosyasi_ayarlandi'));
                }
            }            
            mc_uyari(-1,"<b>".mc_dil('basarili')."</b>".mc_dil('tema_dosyasi_aktif_edildi'));
        }else{
            mc_uyari(-1,"<b>".mc_dil('basarili')."</b>".mc_dil('tema_dosyasi_yuklendi'));
        }        
        exit;        
    }
    $mc_title = mc_dil('tema_yukle');