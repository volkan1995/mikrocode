<?php    
    require 'ayar.php';

    $mc_title = mc_dil($mc_modul_ayar['baslik']);
    
    $get_sayfalar = $m_vt->select()->from($mc_modul_ayar['tablo'])->where('id', 0, ">")->groupby('grup');
    
    if ($mc_oturum->grup > 2 && mc_yetki($mc_modul_ayar['yetki'])){
        /* Eğer kullanıcı admin değil ise izinler kontrolerine başla */
        if (isset($mc_modul_ayar['tasarim']['izinler']) && $mc_modul_ayar['tasarim']['izinler']) {
            /* Eğer ayar.php dosyasında belirtilen izinler ayarı açık ise olacak işlemler */
            /* İlgili kategorileri al */
            $mc_izinliler = array('ust' => array(), 'id' => array());
            if (isset($mc_oturum->izinler[$mc_modul_ayar['ust_tablo']])) {
                /* İlgili tablonun izinlerde karşılığı varsa döngü ile oturum açmış kullanıcının izinlerinde kontrol et ve izinli olanları diziye aktar */
                foreach ($m_vt->select()->from($mc_modul_ayar['ust_tablo'])->result() as $value) {
                    if (in_array($value->id, $mc_oturum->izinler[$mc_modul_ayar['ust_tablo']])) {
                        $mc_izinliler['ust'][] = $value->id;
                    }
                }
            }
            if (isset($mc_oturum->izinler[$mc_modul_ayar['tablo']])) {
                /* İlgili tablonun izinlerde karşılığı varsa döngü ile oturum açmış kullanıcının izinlerinde kontrol et ve izinli olanları diziye aktar */
                $mc_izinliler['id'] = $mc_oturum->izinler[$mc_modul_ayar['tablo']];
            }
            if (count($mc_izinliler['id']) && count($mc_izinliler['ust'])) {
                /* Hem kategorileri hemde içerikleri izinli olanları ve üyenin eklediklerini çek */
                $get_sayfalar->in("AND")->inwhere('id', $mc_izinliler['id'])->inwhere($mc_modul_ayar['ust'], $mc_izinliler['ust'], "OR")->where('ekleyen', mc_oturum_id, "=", "OR")->out();
            } else if (count($mc_izinliler['id'])) {
                /* İçerikleri izinli olanları ve üyenin eklediklerini al */
                $get_sayfalar->in("AND")->inwhere('id', $mc_izinliler['id'])->where('ekleyen', mc_oturum_id, "=", "OR")->out();
            } else if (count($mc_izinliler['ust'])) {
                /* Kategorileri izinli olanları ve üyenin eklediklerini al */
                $get_sayfalar->in("AND")->inwhere($mc_modul_ayar['ust'], $mc_izinliler['ust'])->where('ekleyen', mc_oturum_id, "=", "OR")->out();
            } else {
                /* Üyenin eklediklerini al */
                $get_sayfalar->where('ekleyen', mc_oturum_id);
            }
        } else {
            /* Üyenin eklediklerini al */
            $get_sayfalar->where('ekleyen', mc_oturum_id);
        }
        
    }else{
        if(isset($_GET['filtre'])){
            if($_GET['filtre'] >= 0){
                $get_sayfalar->where('ust' , $_GET['filtre']);
            }
        }else{
            $get_sayfalar->where('ust' , 0);
        }
    }
    
    if(isset($_GET['yayin']) && $_GET['yayin'] >= 0 && $_GET['yayin'] <= 1){
        $get_sayfalar->where('durum' , $_GET['yayin']);
    }
    
    if(isset($_GET['vurgula']) && $_GET['vurgula'] >= 0 && $_GET['vurgula'] <= 1){
         $get_sayfalar->where('menu' , $_GET['vurgula']);
    }
    
    if(isset($_GET['resim'])){
        if($_GET['resim'] == 0){
            $get_sayfalar->where('resim' , 0);
        }else if($_GET['resim'] == 1){
            $get_sayfalar->where('resim' , 0 , '>');
        }
    }
    
    if(isset($_GET['sutun'])){
        if(isset($_GET['sira']) && strtolower($_GET['sira']) == "asc"){ $_GET['sira'] = "ASC"; }else{ $_GET['sira'] = "DESC"; }
        $get_sayfalar->orderby($_GET['sutun'] , $_GET['sira']);
    }
     
    if(isset($_GET['q']) && !empty($_GET['q'])){
        $get_sayfalar->in("AND")->like('baslik' , $_GET['q'])->like('icerik' , $_GET['q'], "OR")->out();
    }
    
    $get_sayfalar_count = clone $get_sayfalar;
    
    $get_sayfalar_count = $get_sayfalar_count->count();
    
    if ($get_sayfalar_count > 0) {
        $get_sayfalar = $get_sayfalar->limit($mc_modul_ayar['limit'], 'p')->result();
    } else {
        $get_sayfalar = array();
    }
    
    