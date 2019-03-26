<?php
    require m_sistem."diller/index.php";
    
    @date_default_timezone_set($mc_diller->{$mc_dil}->timezone);
    
    @setlocale(LC_TIME, $mc_diller->{$mc_dil}->lc_time);
    
    @setlocale(LC_ALL, $mc_diller->{$mc_dil}->lc_all);
    
    if((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off') || $_SERVER['SERVER_PORT']==443){        
        $_SERVER['HTTPS'] = 'on';        
        define("m_domain", "https://".$_SERVER['HTTP_HOST']);
    }else{        
        define("m_domain", "http://".$_SERVER['HTTP_HOST']);
    }

    define("m_url", m_domain.$_SERVER['REQUEST_URI']);
    
    define("mc_sistem", m_domain."/sistem/");
    
    if(!defined('m_kurulum')){ m_git(mc_sistem."kurulum/?adim=2"); }
    
    $mc_kurulum_vtb = false;
    $mc_kurulum_kk = false;
    $mc_kurulum_son = 6;
    if(file_exists(m_depo."veritabani.php")){
        require m_depo."veritabani.php";
        try {            
            if(defined('mdb_server') && defined('mdb_name') && defined('mdb_user') && defined('mdb_pass') && defined('mdb_driver') && defined('mdb_ctype') && defined('mdb_port')){
                if(mdb_port > 0){ $mc_kurulum_port = ";port=".mdb_port; }else{ $mc_kurulum_port = null; }             
                $m_baglan = new PDO(mdb_driver.":host=".mdb_server.$mc_kurulum_port.";dbname=".mdb_name, mdb_user, mdb_pass);
                $m_baglan->exec("SET NAMES 'utf8'; SET CHARSET 'utf8'; SET COLLATION_CONNECTION = 'utf8_general_ci'; SET sql_mode=''");
                $mc_tsorgu_kk = $m_baglan->prepare("SHOW TABLES LIKE ?");
                if($mc_tsorgu_kk->execute(['kullanicilar'])){
                    if ($mc_tsorgu_kk->fetch(PDO::FETCH_NUM)[0]){
                        $mc_sorgu_kk = $m_baglan->query("SELECT * FROM `kullanicilar` WHERE `grup` = 1 OR `grup` = 2");
                        if($mc_sorgu_kk && $mc_sorgu_kk->rowCount()>0){ $mc_kurulum_kk = true; }
                    }
                }
                $mc_kurulum_vtb = true;
            }else{
                $mc_kurulum_vtb = false;
                if(!isset($mc_kurulum_adim) || (isset($mc_kurulum_adim) && $mc_kurulum_adim > 2)){
                    m_git(mc_sistem."kurulum/?adim=2");
                }
            }            
        }catch(Exception $ex){
            $mc_kurulum_vtb = false;
            if(!isset($mc_kurulum_adim) || (isset($mc_kurulum_adim) && $mc_kurulum_adim > 2)){
                m_git(mc_sistem."kurulum/?adim=2");
            }
        }
    }

    define("mc_update", "https://update.mikrocode.net");
    define("mc_panel", m_domain."/yonetici/");
    define("mc_css", mc_sistem."sablon/css/");
    define("mc_js", mc_sistem."sablon/js/");
    define("mc_fonts", mc_sistem."sablon/fonts/");
    define("mc_img", mc_sistem."sablon/resimler/");
    define("mc_plugins", mc_sistem."sablon/plugins/");
    
    $mc_vt_suruculer = [
        'mysql'   => "MySQL (".mc_dil('varsayilan').")",
        'pgsql'   => "PostgreSQL",
        'oci'     => "Oracle",
        'dblib'   => "MSSQL",
        'cubrid'  => "CUBRID",
        'odbc'    => "ODBC & DB2"
    ];
    
    require 'sql.php';
    
    function mc_degisken($yazi){
        $dizi1 = array("İ","Ş"," ","Ü","Ç","G","Ö","ı","ş","ü","ç","g","ö");
        $dizi2 = array("I","S","_","U","C","G","O","i","s","u","c","g","o");
        $yazi = str_replace($dizi1,$dizi2,$yazi);
        $yazi = preg_replace("@[^A-Za-z0-9\-_]+@i","",$yazi);
        $yazi = strtolower($yazi);
        $onay = false;
        do{
           if(strlen($yazi)==0){break;}
           $ilkkarakter=$yazi[0];
           if(!is_numeric($ilkkarakter)){
               if($ilkkarakter=="_"){
                   $yazi =  ltrim($yazi,$ilkkarakter);
                   continue;
               }
               $onay=true;break;}
           $yazi =  ltrim($yazi,$ilkkarakter);
           
        }while($onay==false);
        return($yazi);
    }