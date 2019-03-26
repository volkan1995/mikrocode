<?php
    if(!isset($_POST['tip'])){ exit; }
    
    require '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'yonetici' . DIRECTORY_SEPARATOR . 'loader.php';
    
    $tip_dizi = array("Yüklemeler","Görseller","Videolar","Sesler","Arşivler","Belgeler","Belgeler");

    $tip_kisadizi = array("dosya","görsel","video","ses","arşiv","belge");
    
    if(!isset($tip_dizi[$_POST['tip']])){ exit; }

    $tip_isim = $tip_dizi[$_POST['tip']];
    
    if(isset($_POST['gorev'])){
        
        if(!isset($_POST['target'])){ $_POST['target'] = "dir"; }
        
        if($_POST['gorev'] == "onizle"){
            
            if($_POST['target'] == "file"){
                
                require 'popup_onizle.php';
                
            }else{
                
                require 'popup_duzenle.php';
                
            }

            exit;

        }elseif($_POST['gorev'] == "yukle"){

            require 'popup_yukle.php';

            exit;

        }elseif($_POST['gorev'] == "yeni"){

            require 'popup_yeni.php';

            exit;

        }elseif($_POST['gorev'] == "json"){

            require 'popup_json.php';

            exit;

        }
    }
    
    $klasor_id = 0;
    
    if(isset($_POST['klasor'])){
        
        $klasor_sec = $m_vt->select()
            ->from("klasorler")
            ->where('id',$_POST['klasor'])
            ->result();
        
        if(count($klasor_sec)){
            
            $klasor_sec = $klasor_sec[0];
            
            $klasor_id = $klasor_sec->id;
            
        }
        
    }
    
    $klasor_tara = $m_vt->select()
            ->from("klasorler")
            ->where('ust',$klasor_id)
            ->result();
    
    if($mc_oturum->grup > 2 && m_jsonAl($m_ayarlar->ayar,"mcsyde") == 1){
        
        $dosya_tara = $m_vt->select()->from("dosyalar")->where('klasor',$klasor_id)->where('ekleyen', mc_oturum_id);
        
    }else{
        
        $dosya_tara = $m_vt->select()->from("dosyalar")->where('klasor',$klasor_id);
        
    }
    
    if($_POST['tip'] > 0){
        $dosya_tara = $dosya_tara->where('tip',$_POST['tip']);
    }
    
    $dosya_tara = $dosya_tara->result();
    
    
    if(isset($_POST['hazirla'])){
        
        require 'popup_header.php';
        
        echo '<div class="mc_dosya_sag"></div><div class="mc_dosya_sol">';
        
        require 'popup_body.php';
        
        echo '</div>';
         
        require 'popup_footer.php';
        
    }else{
        
        require 'popup_body.php';
        
    }