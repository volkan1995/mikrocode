<?php
    if(!defined('m_guvenlik')) { exit; }
    
    require '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'yonetici' . DIRECTORY_SEPARATOR . 'loader.php'; 
        
    require 'turler.php'; 

    $mc_db['baslik'] = $_FILES['dosya']['name'];

    $mc_db['isim'] = mc_sef($mc_db['baslik']);

    $mc_db['tip'] = $_FILES['dosya']['type'];

    $mc_db['klasor'] = 0;

    $mc_db['gecici'] = "";

    $mc_db['boyut'] = $_FILES['dosya']['size'];

    $mc_dy = array('t' => 0, 'k' => "y");

    if(in_array($mc_db['tip'], $g_format)) {
        if(in_array ($mc_db['tip'], $r_format)) {
            $mc_dy['t'] = 1;
            $mc_dy['k'] = "g";
        }elseif(in_array ($mc_db['tip'], $v_format)) {
            $mc_dy['t'] = 2;
            $mc_dy['k'] = "v";
        }elseif(in_array ($mc_db['tip'], $m_format)){
            $mc_dy['t'] = 3;
            $mc_dy['k'] = "s";
        }elseif(in_array ($mc_db['tip'], $a_format)){
            $mc_dy['t'] = 4;
            $mc_dy['k'] = "a";
        }elseif(in_array($mc_db['tip'], $pdf_format) || in_array($mc_db['tip'], $txt_format)) {
            $mc_dy['t'] = 5;
            $mc_dy['k'] = "b";
        }elseif(in_array($mc_db['tip'], $word_format) || in_array($mc_db['tip'], $excel_format) || in_array($mc_db['tip'], $access_format) || in_array($mc_db['tip'], $powerpoint_format)) {
            $mc_dy['t'] = 6;
            $mc_dy['k'] = "b";
        }

        $mc_db['konum'] = "../../dosyalar/".$mc_dy['k']."/";
        if(isset($_POST['klasor']) && !empty($_POST['klasor'])){                
            $klasor_sec = $m_vt->select()
                ->from("klasorler")
                ->where('id',$_POST['klasor'])
                ->result();                
            if(count($klasor_sec)){                    
                $mc_db['klasor'] = $klasor_sec[0]->id;                    
                $mc_db['gecici'] = $klasor_sec[0]->id."/";
                $mc_dongu = true;
                while($mc_dongu){
                    if($klasor_sec[0]->ust > 0){
                        $klasor_sec = $m_vt->select()
                        ->from("klasorler")
                        ->where('id',$klasor_sec[0]->ust)
                        ->result();
                        if(count($klasor_sec) < 1){ $mc_dongu = false; break; }
                        $mc_db['gecici'] = $klasor_sec[0]->id."/".$mc_db['gecici'];
                    }else{ $mc_dongu = false; break; }
                }                
            }                
        }
        if(mc_klasor_olustur($mc_db['konum'].$mc_db['gecici'])){
            $mc_db['sef'] = mc_dosya_ismi($mc_db['isim'], false, true);                    
            $mc_db['uzanti'] = mc_dosya_ismi($mc_db['isim'],true);
            $mc_db['isim'] = $mc_db['sef'].".".$mc_db['uzanti'];
            $mc_db['tamkonum'] = $mc_db['konum'].$mc_db['gecici'].$mc_db['isim'];            
            $mc_dongu = true; 
            $mc_dongu_syc = 0;            
            while($mc_dongu){
                if(file_exists($mc_db['tamkonum'])){                    
                    $mc_dongu_syc += 1;
                    $mc_db['isim'] = $mc_db['sef'].".".$mc_dongu_syc.".".$mc_db['uzanti'];
                    $mc_db['tamkonum'] = $mc_db['konum'].$mc_db['gecici'].$mc_db['isim'];
                }else{ $mc_dongu = false; break; }
            }

            if(@move_uploaded_file($_FILES['dosya']['tmp_name'], $mc_db['tamkonum'])){

            $mc_db['yeni'] = "/".$mc_dy['k']."/".$mc_db['gecici'].$mc_db['isim'];

            $mc_kaydet = $m_vt->ekle(['table'=>"dosyalar",'values'=>[
                'baslik' => $mc_db['baslik'],
                'tip' => $mc_dy['t'],
                'klasor' => $mc_db['klasor'],
                'ekleyen'=> mc_oturum_id,
                'boyut' => $mc_db['boyut'],
                'konum' => $mc_db['yeni']
            ]])['sonuc'];

            if($mc_kaydet){
                mc_uyari(1,"<b>Başarılı</b>".$mc_db['baslik']." dosyası yüklendi"); 
                if(isset($_POST['idyaz']) && $_POST['idyaz'] == "onay"){
                    $mt_sec = $m_vt->select()->from("dosyalar")->where('konum', $mc_db['yeni'])->result();
                    if(count($mt_sec)){
                        echo '<input type="hidden" value="'.$mt_sec[0]->id.'" name="tema">';
                        echo "Aşağıdaki dosya kullanılacak<br/><b>".$mc_db['baslik']."</b>";
                    }
                }
            }else{
                unlink($mc_db['tamkonum']);
                mc_uyari(4,"<b>Başarısız</b>".$mc_db['baslik']." dosyası bilinmeyen bir sebepten dolayı yüklenemedi");
            }

        }
        }
    }else{
        mc_uyari(3,"<b>Başarısız</b>".$mc_db['baslik']." dosyası yükleme izni alamıyor!");
    }