<?php

require 'ayar.php';
$mc_title = mc_dil($mc_modul_ayar['baslik']);

/* ayar.php dosyasında bulunan ayarlara göre veritabanındaki tabloya bağlan */
$mc_sorgu = $m_vt->select()->from($mc_modul_ayar['tablo'])->where('tip', $mc_modul_ayar['tip']);

if ($mc_oturum->grup > 2 && mc_yetki($mc_modul_ayar['yetki'])){
    /* Eğer kullanıcı admin değil ise izinler kontrolerine başla */
    if (isset($mc_modul_ayar['tasarim']['izinler']) && $mc_modul_ayar['tasarim']['izinler']) {
        /* Eğer ayar.php dosyasında belirtilen izinler ayarı açık ise olacak işlemler */
        /* İlgili kategorileri al */
        $mc_izinliler = array('ust' => array(), 'id' => array());
        if (isset($mc_oturum->izinler[$mc_modul_ayar['ust_tablo']])) {
            /* İlgili tablonun izinlerde karşılığı varsa döngü ile oturum açmış kullanıcının izinlerinde kontrol et ve izinli olanları diziye aktar */
            foreach ($m_vt->select()->from($mc_modul_ayar['ust_tablo'])->where('tip', $mc_modul_ayar['kategori'])->result() as $value) {
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
            $mc_sorgu->in("AND")->inwhere('id', $mc_izinliler['id'])->inwhere($mc_modul_ayar['ust'], $mc_izinliler['ust'], "OR")->where('ekleyen', mc_oturum_id, "=", "OR")->out();
        } else if (count($mc_izinliler['id'])) {
            /* İçerikleri izinli olanları ve üyenin eklediklerini al */
            $mc_sorgu->in("AND")->inwhere('id', $mc_izinliler['id'])->where('ekleyen', mc_oturum_id, "=", "OR")->out();
        } else if (count($mc_izinliler['ust'])) {
            /* Kategorileri izinli olanları ve üyenin eklediklerini al */
            $mc_sorgu->in("AND")->inwhere($mc_modul_ayar['ust'], $mc_izinliler['ust'])->where('ekleyen', mc_oturum_id, "=", "OR")->out();
        } else {
            /* Üyenin eklediklerini al */
            $mc_sorgu->where('ekleyen', mc_oturum_id);
        }
    } else {
        /* Üyenin eklediklerini al */
        $mc_sorgu->where('ekleyen', mc_oturum_id);
    }
}
if (isset($_GET['yayin']) && $_GET['yayin'] >= 0 && $_GET['yayin'] <= 1) {
    /* Yayın durumuna göre filtrele */
    $mc_sorgu->where('durum', $_GET['yayin']);
}
if (isset($_GET['vurgula']) && $_GET['vurgula'] >= 0 && $_GET['vurgula'] <= 1) {
    /* Vurgulanma durumuna filtrele */
    $mc_sorgu->where('vurgula', $_GET['vurgula']);
}
if (isset($_GET['resim'])) {
    /* Resim durumuna göre filtrele */
    if ($_GET['resim'] == 0) {
        $mc_sorgu->where('resim', 0);
    } else if ($_GET['resim'] == 1) {
        $mc_sorgu->where('resim', 0, '>');
    }
}
if (isset($_GET['filtre']) && $_GET['filtre'] > 0) {
    /* Kategori veya üst durumuna göre filtrele */
    $mc_sorgu->where($mc_modul_ayar['ust'], $_GET['filtre']);
}
if (isset($_GET['sutun'])) {
    /* Sıralamayı ayarla */
    if (isset($_GET['sira']) && strtolower($_GET['sira']) == "asc") {
        $_GET['sira'] = "ASC";
    } else {
        $_GET['sira'] = "DESC";
    }
    $mc_sorgu->orderby($_GET['sutun'], $_GET['sira']);
} else {
    $mc_sorgu->orderby('id', "DESC");
}
if (isset($_GET['q']) && !empty($_GET['q'])) {
    /* Aranan kelimeye göre filtrele */
    $mc_sorgu->in("AND")->like('baslik', $_GET['q'])->like('aciklama', $_GET['q'], "OR")->like('icerik', $_GET['q'], "OR")->out();
}

/* Buraya kadar oluşturulan sql kodunu kopyala ve verilerin satır sayısını al */
$mc_sorgu_say = clone $mc_sorgu;
$mc_sorgu_say = $mc_sorgu_say->count();

/* Eğer veri var ise al, yok ise boş dizi tanımla */
if ($mc_sorgu_say > 0) {
    $mc_sorgu = $mc_sorgu->limit($mc_modul_ayar['limit'], 'p')->result();
} else {
    $mc_sorgu = array();
}