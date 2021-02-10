<?php 
    $title = $m_baslik;
    
    $urunler = $m_vt->select()->from('yazilar')->where('tip', 0)->where('durum', 1)->where('vurgula', 1)->where('dil', $mt_dil)->limit(9)->result();

    $kategoriler = $m_vt->select()->from('kategoriler')->where('tip', 0)->where('durum', 1)->where('dil', $mt_dil)->orderby("sira")->result();
    
    $index_link = m_ekyaz('index_link_' . $mt_dil, true);

    $index_banner = m_ekyaz('index_banner_' . $mt_dil, true);
    
    
    $sef_kategori = array();
    foreach ($kategoriler as $kategori){
        $sef_kategori[$kategori->id] = $kategori;
    }