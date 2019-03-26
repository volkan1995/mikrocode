<?php
    $m_iz = explode(" ", microtime());
    $m_iz = doubleval($m_iz[1]) + doubleval($m_iz[0]);
    if(!isset($_POST['tablo'])){
        echo json_encode([
            'hareket' => "Geçersiz İşlem",
            'rapor' => "<p>Geçersiz İşlem</p>",
            'tablo' => null,
            'yuzde' => 100
            ]);
        exit;
    }
    $mc_tablo = intval($_POST['tablo']);
    $mc_tablo1 = $mc_tablo + 1;
    $mc_yuzde = ($mc_tablo * round(100 / count($mc_tablolar))) - 3;
    if(isset($_POST['yuzde'])){ $mc_yuzde2 = intval($_POST['yuzde']); }else{ $mc_yuzde2 = $mc_yuzde; }
    if($mc_tablo > count($mc_tablolar)){
        require m_cekirdek."fonksiyonlar/temel.php";       
        require m_cekirdek."siniflar/veritabani.php";        
        $m_vt = new m_baglan();        
        if($m_vt->kontrol){
            $lisans_sql = $m_vt->sec(['table'=>"ayarlar",'where'=>['id' => 1]]);
            if(count($lisans_sql)){
                $lisans_sql = $lisans_sql[0];
                $lisans_sql->lisans = json_decode($lisans_sql->lisans, true);
                if(!isset($lisans_sql->lisans['l']) || strlen($lisans_sql->lisans['l']) != 41){
                    $fgcld = array();
                    if(isset($lisans_sql->lisans['k'])){ $fgcld['id'] = $lisans_sql->lisans['k']; }
                    if (ini_get('allow_url_fopen')){
                        $donus = json_decode(m_file_get_contents(base64_decode("aHR0cHM6Ly9ndW5jZWxsZS5taWtyb2JpbGlzaW0ubmV0L3lvbmV0aWNpL3BhbmVsbGVyL2theWl0LnBocA=="), $fgcld));
                    }elseif(function_exists('curl_version')) {
                        $donus = json_decode(m_curl(base64_decode("aHR0cHM6Ly9ndW5jZWxsZS5taWtyb2JpbGlzaW0ubmV0L3lvbmV0aWNpL3BhbmVsbGVyL2theWl0LnBocA=="), $fgcld));
                    }
                    if(isset($donus->status) && $donus->status){
                        $lisans_sql->lisans['l'] = $donus->kod;
                        $mc_kaydet = $m_vt->guncelle(['table'=>'ayarlar', 'values'=>['lisans' => json_encode($lisans_sql->lisans)],'where' => ['id'=>1] ])['sonuc'];
                    }
                }
            }
        }
        if(isset($_SESSION['gecici'])){ $_SESSION['gecici'] = false; }        
        if(isset($_SESSION['kuruluyor'])){ unset($_SESSION['kuruluyor']); }        
        $mc_kurulumRapor['hareket'] = mc_dil('kurulum_hazir_1').".";        
        $mc_kurulumRapor['rapor'] = "<p>".$mc_kurulumRapor['hareket']."</p>";        
        $mc_kurulumRapor['rapor'] .= "<p>".mc_dil('kurulum_hazir_2').".</p>";        
        $mc_kurulumRapor['rapor'] .= "<a href='".mc_panel."' class='btn btn-primary m-t-15 waves-effect'>".mc_dil('panele_git')."</a>";        
        $mc_yuzde = 100;        
    }else if($mc_yuzde2 >= 98){        
        require m_cekirdek."siniflar/veritabani.php";        
        $m_vt = new m_baglan();
        if($m_vt->kontrol){
            $mc_kurulumRapor['hareket'] = null;
            $mc_hazirla = array();
            if(count($m_vt->select()->from("klasorler")->where("baslik","Panel")->where("tip",1)->where("ust",0)->result()) == 0){
                $mc_hazirla[] = $m_vt->ekle(['table'=>"klasorler",'values'=>['baslik' => 'Panel', 'tip' => 1]])['sonuc'];
            }
            if(count($m_vt->select()->from("klasorler")->where("baslik","Site")->where("tip",1)->where("ust",0)->result()) == 0){
                $mc_hazirla[] = $m_vt->ekle(['table'=>"klasorler",'values'=>['baslik' => 'Site', 'tip' => 1]])['sonuc'];
            }
            if(count($m_vt->select()->from("klasorler")->where("baslik","Slayt Resimleri")->where("tip",1)->where("ust",2)->result()) == 0){
                $mc_hazirla[] = $m_vt->ekle(['table'=>"klasorler",'values'=>['baslik' => 'Slayt Resimleri', 'tip' => 1, 'ust' => 2]])['sonuc'];
            }
            if(count($m_vt->sec(['table'=>"ayarlar",'where'=>['id' => 1]])) == 0){
                $mc_bilgi = ['baslik' => "Site Başlığı", 'aciklama' => "Web sitemize hoş geldiniz", 'anahtar' => null];
                $mc_lD = explode("-",wordwrap(strtoupper(time().(md5(sha1($_SERVER['HTTP_HOST'].time())))),5,'-',true));
                $mc_lisans['k'] = $mc_lD[4]."-".$mc_lD[1]."-".$mc_lD[2]."-".$mc_lD[0]."-".$mc_lD[count($mc_lD)-1].rand(100,999);
                $mc_hazirla[] = $m_vt->ekle(['table'=>"ayarlar",'values'=>['id' => 1,'erisim' => 1, 'lisans'=>json_encode($mc_lisans), 'bilgi'=>json_encode($mc_bilgi)]])['sonuc'];
            }
            if(count($m_vt->sec(['table'=>"gruplar",'where'=>['baslik' => 'kurucu']])) == 0){
                $mc_hazirla[] = $m_vt->ekle(['table'=>"gruplar",'values'=>['baslik' => 'kurucu', 'yetki'=>null, 'panel' => 1, 'site' => 1]])['sonuc'];
            }
            if(count($m_vt->sec(['table'=>"gruplar",'where'=>['baslik' => 'yonetici']])) == 0){
                $mc_hazirla[] = $m_vt->ekle(['table'=>"gruplar",'values'=>['baslik' => 'yonetici', 'yetki'=>null, 'panel' => 1, 'site' => 1]])['sonuc'];
            }
            if(!$mc_kurulum_kk){
                if(count($m_vt->sec(['table'=>"kullanicilar",'where'=>['grup' => '1']])) == 0){
                    if(isset($_SESSION['name']) && $_SESSION['mail'] && $_SESSION['pass']){
                        $mc_hazirlaD = ['kadi' => $_SESSION['name'],'mail' => $_SESSION['mail'],'sifre' => sha1(md5($_SESSION['pass'])),'grup' => '1',];                
                        $mc_hazirla[] = $m_vt->ekle(['table'=>"kullanicilar",'values'=>$mc_hazirlaD])['sonuc'];
                        $mc_kurucuSec = $m_vt->sec(['table'=>"kullanicilar",'where'=>['kadi' => $_SESSION['name'],'grup' => '1']]);
                        if(count($mc_kurucuSec)){
                            $_SESSION['kullanici']['id'] = $mc_kurucuSec[0]->id;
                            $_SESSION['kullanici']['sifre'] = $mc_kurucuSec[0]->sifre;
                            @setcookie("kullanici_id", "", time() - (3600 * 24));    
                            @setcookie("kullanici_sifre", "", time() - (3600 * 24));
                        }
                    }
                    unset($_SESSION['name'],$_SESSION['mail'],$_SESSION['pass']);
                }
            }          
        }
        if (!file_exists(m_dosyalar)) { @mkdir(m_dosyalar); }
        if (!file_exists(m_dosyalar . "a")) { @mkdir(m_dosyalar . "a"); }
        if (!file_exists(m_dosyalar . "b")) { @mkdir(m_dosyalar . "b"); }
        if (!file_exists(m_dosyalar . "g")) { @mkdir(m_dosyalar . "g"); }
        if (!file_exists(m_dosyalar . "s")) { @mkdir(m_dosyalar . "s"); }
        if (!file_exists(m_dosyalar . "v")) { @mkdir(m_dosyalar . "v"); }
        if (!file_exists(m_dosyalar . "y")) { @mkdir(m_dosyalar . "y"); }
        if (!file_exists(m_depo)) { @mkdir(m_depo); }
        if (!file_exists(m_depo . "sqlite/")) { @mkdir(m_depo . "sqlite/"); }
        if (!file_exists(m_depo . "onbellek/")) { @mkdir(m_depo . "onbellek/"); }
        foreach ($mc_hazirla as $value) {
            if(!$value){
                $mc_kurulumRapor['hareket'] = mc_dil('veriler_hata1').".<br/>";
                break;
            }
        }     
        $mc_kurulumRapor['hareket'] .= mc_dil('kurulum_tamamlaniyor')."...";        
        $mc_kurulumRapor['rapor'] = "<p>".mc_dil('kurulum_tamamlaniyor')."...</p>";        
        $mc_yuzde = 99;
    }else{
        $mc_kurulumRapor['hareket'] = null;
        if(isset($mc_tablolar[$mc_tablo])){
            $m_tabloEkle = false;
            $m_tabloAd = $mc_tablolar[$mc_tablo];
            $m_sqlite3 = false;          
            $mc_tabloSor = $m_baglan->prepare("SHOW TABLES LIKE :tablo_sor");
            $mc_tabloSor->bindParam(":tablo_sor", $m_tabloAd, PDO::PARAM_STR);
            
            if($mc_tabloSor->execute()){
                if ($mc_tabloSor->fetch(PDO::FETCH_NUM)[0]){ $m_tabloEkle = true; }
            }
            if(!$m_tabloEkle){
                try{
                    $m_baglan->exec("CREATE TABLE IF NOT EXISTS `$m_tabloAd` (`id` int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");
                    $mc_tabloSor = $m_baglan->prepare("SHOW TABLES LIKE :tablo_sor");
                    $mc_tabloSor->bindParam(":tablo_sor", $m_tabloAd, PDO::PARAM_STR);
                    if($mc_tabloSor->execute()){
                        if ($mc_tabloSor->fetch(PDO::FETCH_NUM)[0]){ $m_tabloEkle = true; }
                    }
                }catch(Exception $e){ $m_tabloEkle = false; }
            }
            if($m_tabloEkle){
                if(isset($mc_sql[$m_tabloAd])){
                    $mc_mevcutSutunlar = array();
                    $mc_mevcutSutunS = $m_baglan->prepare("SHOW fields FROM `$m_tabloAd`");
                    $mc_mevcutSutunS->execute();
                    foreach ($mc_mevcutSutunS->fetchAll(PDO::FETCH_ASSOC) as $key => $value) {
                        if(isset($value['Field'])){ $mc_mevcutSutunlar[$value['Field']] = 1; }
                    }
                    $mc_sutunlar = $mc_sql[$m_tabloAd];
                    if(is_array($mc_sutunlar)){
                        foreach ($mc_sutunlar as $key => $value) {
                            if(!isset($mc_mevcutSutunlar[$key]) || $mc_mevcutSutunlar[$key] != 1){
                                $mc_sutunEkle = $m_baglan->prepare("ALTER TABLE `$m_tabloAd` ADD `$key` $value");
                                if(!$mc_sutunEkle->execute()){
                                    $m_tabloEkle = false;
                                    $mc_kurulumRapor['hareket'].= mc_dil('islem_detay_5').": $m_tabloAd &#62; $key <br/>";
                                }
                            }
                        }
                    }
                    if(extension_loaded('sqlite3')){
                        if (!file_exists(m_depo."sqlite/")) { @mkdir(m_depo."sqlite/"); }
                        $msl3_baglan = new SQLite3(m_depo."sqlite/".mdb_name.".db");
                        $msl3_baglan->exec("CREATE TABLE IF NOT EXISTS '{$m_tabloAd}' (id INTEGER)");                        
                        if(is_array($mc_sutunlar)){                        
                            $msl3_sor = $msl3_baglan->query("PRAGMA table_info('{$m_tabloAd}')");    
                            $msl3_columns = array();                            
                            while($tablo = $msl3_sor->fetchArray(SQLITE3_ASSOC)) {
                                $msl3_columns[$tablo['name']] = $tablo['type'];
                            }
                            $msl3_int = array("ekleyen","resim","durum","sira","vurgula","sql3_kullanici");
                            $msl3_var = array("baslik","sef","aciklama","tip","ust","sql3_tarih","sql3_ip");
                            $mc_sutunlar['sql3_tarih'] = null;
                            $mc_sutunlar['sql3_kullanici'] = null;
                            $mc_sutunlar['sql3_ip'] = null;
                            foreach ($mc_sutunlar as $key => $value) {
                                if(isset($msl3_columns[$key]) || $key == 'id'){ continue; }
                                if(in_array($key, $msl3_int)){ $value = "INTEGER"; }
                                else if(in_array($key, $msl3_var)){ $value = "VARCHAR"; }
                                else{ $value = "TEXT"; }
                                $mc_sutunEkle = $msl3_baglan->prepare("ALTER TABLE '{$m_tabloAd}' ADD '{$key}' {$value}");                
                                $mc_sutunEkle->execute();
                            }
                        }                        
                    }                    
                }else{
                    $m_tabloEkle = false;
                    $mc_kurulumRapor['hareket'].= mc_dil('islem_detay_4').".<br/>";
                }               
            }
            
            $mc_bz = explode (" ",microtime());
            $mc_bz = doubleval ($mc_bz[1]) + doubleval ($mc_bz[0]);
            $mc_sz = round(abs($mc_bz - $m_iz),2);
            $mc_sz_ms = ($mc_sz * 1000);
            if($mc_sz_ms > 999) { $mc_zy = "($mc_sz sn)"; }else{ $mc_zy = "($mc_sz_ms ms)"; }
            if($m_tabloEkle){
                $mc_kurulumRapor['hareket'] .= mc_dil('islem_detay_2').": ".ucfirst($m_tabloAd)." $mc_zy <br/><br/>";
            }else{
                $mc_kurulumRapor['hareket'] .= mc_dil('islem_detay_3').": ".ucfirst($m_tabloAd)." $mc_zy <br/><br/>";
            }
        }
        if(isset($mc_tablolar[$mc_tablo1])){
            $mc_kurulumRapor['hareket'] .= mc_dil('islem_detay_1').": ".ucfirst($mc_tablolar[$mc_tablo1]);
            $mc_kurulumRapor['rapor'] = "<p>".mc_dil('islem_detay_1').": ".ucfirst($mc_tablolar[$mc_tablo1])."</p>";
        }else{
            $mc_yuzde = 98;
            $mc_kurulumRapor['hareket'] .= mc_dil('veriler_hazirlaniyor')."...";
            $mc_kurulumRapor['rapor'] = "<p>".mc_dil('veriler_hazirlaniyor')."...</p>";
        }
    }
    $mc_yuzde1 = ($mc_tablo1 * round(100 / count($mc_tablolar))) - 3;
    if($mc_yuzde >= 98) { $mc_yuzde1 = $mc_yuzde; }else if($mc_yuzde1 < 2) { $mc_yuzde1 = 2; }else if($mc_yuzde1 > 100) { $mc_yuzde1 = 100; }
    $mc_kurulumRapor['yuzde'] = $mc_yuzde1;
    $mc_kurulumRapor['tablo'] = $mc_tablo1;
    echo json_encode($mc_kurulumRapor);