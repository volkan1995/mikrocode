<?php
    if(!defined('m_guvenlik')) { exit; }
    if($mc_kurulum_kk && !isset($_SESSION['kuruluyor'])){
        if($mc_kurulum_adim == 2){
            if(isset($_POST['name']) && isset($_POST['pass'])){
                $mc_sorgu_kk = $m_baglan->prepare("SELECT * FROM `kullanicilar` WHERE (`kadi` = :namemail OR `mail` = :namemail) AND (`grup` = 1 OR `grup` = 2) AND `sifre` = :sifre");
                $mc_sorgu_kk->execute([':namemail'=>$_POST['name'],':sifre'=>sha1(md5($_POST['pass']))]);
                if($mc_sorgu_kk && $mc_sorgu_kk->rowCount() == 1){
                    $mc_sorgu_ks = $mc_sorgu_kk->fetchAll(PDO::FETCH_OBJ)[0];   
                    $_SESSION['gecici'] = true;
                    $_SESSION['kullanici']['id'] = $mc_sorgu_ks->id;
                    $_SESSION['kullanici']['sifre'] = $mc_sorgu_ks->sifre;                    
                    @setcookie("kullanici_id", "", time() - (3600 * 24));    
                    @setcookie("kullanici_sifre", "", time() - (3600 * 24));
                    echo "<script>setTimeout(function(){ kurulum1_btn.text(\"".mc_dil('bekleyiniz')."\"); setTimeout(function(){ $(window).attr('location', '".$mc_kurulum_url."?adim=".($mc_kurulum_adim + 1)."') }, 2000); }, 500); showNotification('alert-success','".mc_dil('basarili_s_adim')."','top','center','animated bounceInDown','animated bounceOutUp')</script>";
                }else{
                    $_SESSION['gecici'] = false;
                    echo "<script>setTimeout(function(){ kurulum1_btn.text(\"".mc_dil('kuruluma_basla')."\"); kurulum1_onay = true; }, 500); showNotification('alert-warning','".mc_dil('eslesme_bulunamadı').".<br/>".mc_dil('lutfen_b_kontrol')."','top','center','animated bounceInDown','animated bounceOutUp')</script>";
                }
            }
            exit;
        }else if($mc_kurulum_adim == $mc_kurulum_son && isset($_POST['yuzde'])){
            require_once $mc_kurulum_son.'.php';
            exit;
        }
    }else{
        if($mc_kurulum_adim == $mc_kurulum_son && isset($_POST['yuzde'])){
            require_once $mc_kurulum_son.'.php';
            exit;
        }if(isset($_POST['db_server'])){        
            try {            
                if(isset($_POST['db_port']) && $_POST['db_port'] > 0){ $mc_kurulum_port = ";port=".$_POST['db_port']; }else { $mc_kurulum_port = null; $_POST['db_port'] = null; }
                $m_baglan = new PDO($_POST['db_driver'].":host=".$_POST['db_server'].$mc_kurulum_port, $_POST['db_user'], $_POST['db_pass']);
                $m_baglan->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $m_baglan->query("CREATE DATABASE IF NOT EXISTS `".$_POST['db_name']."` CHARACTER SET utf8 COLLATE utf8_general_ci");            
                if(!$m_baglan->query("use `".$_POST['db_name']."`")){ $mc_kurulum_hata = mc_dil('vt_hata1'); }
                $m_baglan = null;
            }catch(PDOException $e){
                $mc_kurulum_hata = mc_dil('vt_hata1');       
            }
            if(isset($mc_kurulum_hata)){
                echo "<script>setTimeout(function(){ kurulum2_btn.text(\"".mc_dil('yeniden_baglan')."\"); kurulum2_onay = true; }, 500); showNotification('alert-danger','$mc_kurulum_hata','top','center','animated bounceInDown','animated bounceOutUp')</script>";
            }else{            
                if(empty($_POST['m_firma'])){ $_POST['m_firma'] = "Mikro Bilişim"; }
                if(empty($_POST['m_firma_url'])){ $_POST['m_firma_url'] = "https://mikrobilisim.net"; }
                $_POST['m_firma'] = str_replace(["`","'",'"'],"",$_POST['m_firma'] );
                $_POST['m_firma_url'] = str_replace(["`","'",'"'],"",$_POST['m_firma_url'] );
                $_POST['db_driver'] = str_replace(["`","'",'"'],"",$_POST['db_driver'] );
                $_POST['db_server'] = str_replace(["`","'",'"'],"",$_POST['db_server'] );
                $_POST['db_port'] = str_replace(["`","'",'"'],"",$_POST['db_port'] );
                $_POST['db_name'] = str_replace(["`","'",'"'],"",$_POST['db_name'] );
                $_POST['db_user'] = str_replace(["`","'",'"'],"",$_POST['db_user'] );
                $_POST['db_pass'] = str_replace(["`","'",'"'],"",$_POST['db_pass'] );                
                if(file_exists(m_depo."veritabani.php")){ include m_depo."veritabani.php"; unlink(m_depo."veritabani.php");}            
                if(!defined('mt_isim') || !mt_isim){ $mt_isim = null; }else{ $mt_isim = mt_isim; }
                $mc_vtd = '<?php '."\n"
                . 'if(!defined(\'m_guvenlik\')){ exit; }'."\n"
                . 'define("mdb_driver", "'.$_POST['db_driver'].'");'."\n"
                . 'define("mdb_ctype", "pdo");'."\n"
                . 'define("mdb_server", "'.$_POST['db_server'].'");'."\n"
                . 'define("mdb_port", "'.$_POST['db_port'].'");'."\n"
                . 'define("mdb_name", "'.$_POST['db_name'].'");'."\n"
                . 'define("mdb_user", "'.$_POST['db_user'].'");'."\n"
                . 'define("mdb_pass", "'.$_POST['db_pass'].'");'."\n"
                . 'define("mt_isim", "'.$mt_isim.'");'."\n"   
                . 'define("m_firma", "'.$_POST['m_firma'].'");'."\n"
                . 'define("m_firma_url", "'.$_POST['m_firma_url'].'");'; 
                if (!file_exists(m_depo)) { @mkdir(m_depo); }
                if (!file_exists(m_depo."sqlite/")) { @mkdir(m_depo."sqlite/"); }
                if (!file_exists(m_depo."onbellek/")) { @mkdir(m_depo."onbellek/"); }
                $mc_vta = fopen(m_depo."veritabani.php","w");            
                if($mc_vta){
                    flock ($mc_vta, 2); 
                    fwrite($mc_vta,$mc_vtd);
                    flock ($mc_vta, 3); 
                    fclose($mc_vta);
                    echo "<script>setTimeout(function(){ kurulum2_btn.text(\"".mc_dil('bekleyiniz')."\"); setTimeout(function(){ $(window).attr('location', '".$mc_kurulum_url."?adim=3') }, 2000); }, 500); showNotification('alert-success','".mc_dil('vt_tamam')."','top','center','animated bounceInDown','animated bounceOutUp')</script>";
                }else{
                    echo "<script>setTimeout(function(){ kurulum2_btn.text(\"".mc_dil('yeniden_baglan')."\"); kurulum2_onay = true; }, 500); showNotification('alert-danger','".mc_dil('vt_hata2')."','top','center','animated bounceInDown','animated bounceOutUp')</script>";
                }
            }        
            exit;        
        }else if(isset($_POST['name'])){
            $_POST['name'] = mc_degisken($_POST['name']);        
            if(empty($_POST['name']) || empty($_POST['mail']) || empty($_POST['pass']) || empty($_POST['passr'])){
                $mc_ko_hata = mc_dil('bos_alanlar_var');
            }else if(strlen($_POST['name'])<3){
                $mc_ko_hata = mc_dil('kullanici_adi_enaz3');            
            }else if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
                $mc_ko_hata = mc_dil('eposta_agd');            
            }else if(strlen($_POST['pass'])<5){
                $mc_ko_hata = mc_dil('sifre_enaz5');        
            }else if($_POST['pass'] != $_POST['passr']){
                $mc_ko_hata = mc_dil('sifreler_uyusmuyor');        
            }         
            if (isset($mc_ko_hata)){
                echo "<script>setTimeout(function(){ kurulum3_btn.text(\"".mc_dil('olustur')."\"); kurulum3_onay = true; }, 500); showNotification('alert-warning','".$mc_ko_hata."','top','center','animated bounceInDown','animated bounceOutUp')</script>";
                exit;
            }        
            $_SESSION['name'] = $_POST['name'];
            $_SESSION['mail'] = $_POST['mail'];
            $_SESSION['pass'] = $_POST['pass'];        
            echo "<script>setTimeout(function(){ kurulum3_btn.text(\"".mc_dil('bekleyiniz')."\"); setTimeout(function(){ $(window).attr('location', '".$mc_kurulum_url."?adim=4') }, 2000); }, 500); showNotification('alert-success','".mc_dil('basarili_s_adim')."','top','center','animated bounceInDown','animated bounceOutUp')</script>";
            exit;
        }
    }