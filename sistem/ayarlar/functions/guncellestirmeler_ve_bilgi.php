<?php
    if(!defined('m_guvenlik')) { exit; }
    
    if(isset($_POST['guncelle'])){
        
        $m_ayarlar->lisans = m_jsonDegistir($m_ayarlar->lisans, 't', date('Y-m-d H:i:s'), false);
    
        $mc_values['lisans'] = $m_ayarlar->lisans;

        $m_ayarlar->lisans = json_decode($m_ayarlar->lisans);
        
        $mc_kaydet = @$m_vt->guncelle(['table'=>"ayarlar",'values'=>$mc_values,'where' => ['id'=>1]]);
        
        $data_get = array('id' => "8A9D7A2218", 'key' => "79A244F8EDBF24ACBF83", 'use' => "license", 'lang'=>"tr");
        
        $data_post = array('k' => $m_ayarlar->lisans->k);
        
        $donus = json_decode(m_file_get_contents(mc_update."/sistem/api/index.php", $data_get, $data_post));
        
        if(isset($donus->status)){
            
            $guncelleme_konum = m_dosyalar."update.zip";
            
            $guncelleme_kopyala = copy($donus->download, $guncelleme_konum);
            
            if($guncelleme_kopyala){
                
                $m_zip = new ZipArchive;
                
                $m_zip_open = $m_zip->open($guncelleme_konum);
                
                if ($m_zip_open === TRUE){
                    
                    $m_zip->extractTo(m_dizin);
                    
                    $m_zip->close();
                    
                    echo "Güncelleme tamamlandı";
                    
                    unlink($guncelleme_konum);
                    
                }
                
            }
            
        }
        
        exit;
        
    }elseif(isset($_POST['yeni_test'])){           
        $m_mc_uyum = 100; /* Toplam Puan */
        
        /* --- 51 -- php_versiyon -------- (<5.4 - 51, <5.6 - 25) ---------------- 5.6.x */
        $m_php_ver = floatval(phpversion()); 
        if($m_php_ver < 5.4){ $m_mc_uyum -= 51; }else if($m_php_ver < 5.6){ $m_mc_uyum -= 25; }
        
        /* --- 17 -- mysql_version ------- (<5.5) -------------------------------- 5.7.x */
        $m_vt_ver = floatval($m_vt->sorgu("SHOW VARIABLES LIKE 'version'")[0]->Value);  
        if($m_vt_ver < 5.5){ $m_mc_uyum -= 17; } 
        
        /* --- 8 --- zip ----------------- (off) --------------------------------- on */
        if (!extension_loaded('zip')) { $m_mc_uyum -= 8; } 
        
        /* --- 2 --- curl ---------------- (off) --------------------------------- on */
        if (!function_exists('curl_version')) { $m_mc_uyum -= 2; }  
        
        /* --- 2 --- safe_mode ----------- (off) --------------------------------- on */
        if (ini_get('safe_mode')) { $m_mc_uyum -= 2; }  
        
        /* --- 2 --- allow_url_fopen ----- (off) --------------------------------- on
           --- 2 --- file_get_contents --- (off) --------------------------------- on */
        if (!ini_get('allow_url_fopen')) { $m_mc_uyum -= 4; } 
        
        /* --- 2 --- memory_limit -------- (<2M-2, >8M-1) ------------------------ 4M */
        $m_ini_ver = ini_get("upload_max_filesize");    
        $m_ini_tip = ucwords(substr($m_ini_ver, -1));    
        $m_ini_byt = intval($m_ini_ver); 
        if($m_ini_tip != "G" && $m_ini_tip != "P" && $m_ini_tip != "T"){
            if($m_ini_byt < 2){ $m_mc_uyum -= 2; }else if($m_ini_byt > 8){ $m_mc_uyum -= 1; }
        }
        
        /* --- 3 --- post_max_size ------- (<256K - 1, 128K-2, 64K-3) ------------ 256K */
        $m_ini_ver = ini_get("post_max_size");    
        $m_ini_tip = ucwords(substr($m_ini_ver, -1));    
        $m_ini_byt = intval($m_ini_ver); 
        if($m_ini_tip != "G" && $m_ini_tip != "P" && $m_ini_tip != "T" && $m_ini_tip != "M"){
            if($m_ini_byt < 64){ $m_mc_uyum -= 3; }else if($m_ini_byt < 128){ $m_mc_uyum -= 2; }else if($m_ini_byt < 256){ $m_mc_uyum -= 1; }
        }        
        
        /* -- 3 --- upload_max_filesize -- (<32M - 3, <128M - 2, <256M - 1) ------ 256M */
        $m_ini_ver = ini_get("upload_max_filesize");    
        $m_ini_tip = ucwords(substr($m_ini_ver, -1));    
        $m_ini_byt = intval($m_ini_ver); 
        if($m_ini_tip != "G" && $m_ini_tip != "P" && $m_ini_tip != "T"){
            if($m_ini_byt < 32){ $m_mc_uyum -= 3; }else if($m_ini_byt < 128){ $m_mc_uyum -= 2; }else if($m_ini_byt < 256){ $m_mc_uyum -= 1; }
        }
        
        /* --- 3 --- max_execution_time -- (<30 - 1, >120 - 2, >300 -3) ---------- 60 */
        $m_ini_byt = intval(ini_get("max_execution_time"));
        if($m_ini_byt < 30){ $m_mc_uyum -= 1; }else if($m_ini_byt > 300){ $m_mc_uyum -= 3; }else if($m_ini_byt > 120){ $m_mc_uyum -= 2; }
        
        /* --- 5 --- mail ---------------- (off) --------------------------------- on */
        $mail_test_msj = "Sistem performansını ölçmek için test amaçlı yollanmıştır. Performans Ölçümü: {$m_mc_uyum}, Testi yapan istemci: ".m_domain;
        if(!@mail("test_to@mikrocode.net","Mail Test Mesajı",$mail_test_msj, "From:test_from@mikrocode.net")){ $m_mc_uyum -= 5; }
        
        /* Ölçümü Başlat */
        $rtn = $m_mc_uyum."% <small><i>";
        if($m_mc_uyum == 100){
            $rtn .= "Çok iyi!";
        }else if($m_mc_uyum >= 95){
            $rtn .= "Bu iyi!";
        }else if($m_mc_uyum >= 70){
            $rtn .= "Pek iyi sayılmaz!";
        }else if($m_mc_uyum >= 50){
            $rtn .= "Pek kötü sayılmaz!";
        }else{
            $rtn .= "Çok kötü!";
        }
        echo $rtn."</i></small>";
        
        $m_ayarlar->sistem = m_jsonDegistir($m_ayarlar->sistem, 'puan', $m_mc_uyum, false);
    
        $mc_values['sistem'] = $m_ayarlar->sistem;

        $mc_kaydet = @$m_vt->guncelle(['table'=>"ayarlar",'values'=>$mc_values,'where' => ['id'=>1]]);
        
        exit;
    }elseif(isset($_POST['oto_g'])){
        
        $m_ayarlar->sistem = m_jsonDegistir($m_ayarlar->sistem, 'oto_g', intval($_POST['oto_g']), false);
    
        $mc_values['sistem'] = $m_ayarlar->sistem;

        $mc_kaydet = $m_vt->guncelle(['table'=>"ayarlar",'values'=>$mc_values,'where' => ['id'=>1]])['sonuc'];

        mc_uyari($mc_kaydet,["<b>Başarılı</b>Ayarlarınız kaydedildi","<b>Başarısız</b>Ayarlarınız bilinmeyen bir sebepten dolayı kaydedilemedi"]);
       
        exit;
    }
        
   