<?php
    if(!defined('m_guvenlik')) { exit; }    
    if(isset($_POST['kaydet'])){
        if(!empty($_POST['tema']) && !empty($_POST['gorev'])){
            $tema = $_POST['tema'];
            if(!is_dir(m_temalar.$tema)){ exit;  }
            if($_POST['gorev'] == "aktif"){
                $mc_vtd = '<?php '."\n"
                . 'if(!defined(\'m_guvenlik\')){ exit; }'."\n"
                . 'define("mdb_driver", "'.mdb_driver.'");'."\n"
                . 'define("mdb_ctype", "'.mdb_ctype.'");'."\n"
                . 'define("mdb_server", "'.mdb_server.'");'."\n"
                . 'define("mdb_port", "'.mdb_port.'");'."\n"
                . 'define("mdb_name", "'.mdb_name.'");'."\n"
                . 'define("mdb_user", "'.mdb_user.'");'."\n"
                . 'define("mdb_pass", "'.mdb_pass.'");'."\n"
                . 'define("mt_isim", "'.$tema.'");'."\n"   
                . 'define("m_firma", "'.m_firma.'");'."\n"
                . 'define("m_firma_url", "'.m_firma_url.'");';      
                $mc_vta = fopen(m_depo."veritabani.php","w");            
                if(!$mc_vta){ exit; }
                flock ($mc_vta, 2); 
                fwrite($mc_vta,$mc_vtd);
                flock ($mc_vta, 3); 
                fclose($mc_vta);
                echo "<script> $.mcPanel.post.yukle(window.location.href); </script>";
                mc_uyari(-1,"<b>".mc_dil('basarili')."</b>".mc_dil('tema_dosyasi_aktif_edildi'));                
            }else if($_POST['gorev'] == "kur"){
                $mc_vtd = '<?php '."\n"
                . 'if(!defined(\'m_guvenlik\')){ exit; }'."\n"
                . 'define("mdb_driver", "'.mdb_driver.'");'."\n"
                . 'define("mdb_ctype", "'.mdb_ctype.'");'."\n"
                . 'define("mdb_server", "'.mdb_server.'");'."\n"
                . 'define("mdb_port", "'.mdb_port.'");'."\n"
                . 'define("mdb_name", "'.mdb_name.'");'."\n"
                . 'define("mdb_user", "'.mdb_user.'");'."\n"
                . 'define("mdb_pass", "'.mdb_pass.'");'."\n"
                . 'define("mt_isim", "'.$tema.'");'."\n"   
                . 'define("m_firma", "'.m_firma.'");'."\n"
                . 'define("m_firma_url", "'.m_firma_url.'");';      
                $mc_vta = fopen(m_depo."veritabani.php","w");            
                if(!$mc_vta){ exit; }
                flock ($mc_vta, 2); 
                fwrite($mc_vta,$mc_vtd);
                flock ($mc_vta, 3); 
                fclose($mc_vta);
                if(file_exists(m_temalar.$tema."/settings.xml")){
                    $xml = @simplexml_load_file(m_temalar.$tema."/settings.xml");
                    if(count($xml)){
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
                   }
                }                
                echo "<script> $.mcPanel.post.yukle(window.location.href); </script>";
                mc_uyari(-1,"<b>".mc_dil('basarili')."</b>".mc_dil('tema_dosyasi_ayarlandi'));                
            }else if($_POST['gorev'] == "sil"){
                if($tema == mt_isim){ exit; }
                $mct_sil = mc_klasorsil(m_temalar.$tema);
                if($mct_sil){
                    echo "<script>$('#mct_id_{$tema}').animate({'margin-left':'-300px','opacity':0}, 400); setTimeout(function(){ $('#mct_id_{$tema}').remove(); }, 350);</script>";
                    mc_uyari(-1,"<b>".mc_dil('basarili')."</b>".mc_dil('tema_dosyasi_silindi'));   
                }else{
                    mc_uyari(-4,"<b>".mc_dil('basarisiz')."</b>".mc_dil('tema_dosyasi_silinemedi'));   
                }
            }            
        }        
        exit;
    }

    $mc_title = mc_dil('temalar');
    