<?php
    if(!defined('m_guvenlik')) { exit; }
    
    if(!isset($_GET['id'])){ exit; }
    
    $get_mesajlar = $m_vt->select()->from("mesajlar")->where("id",$_GET['id'])->result();
    
    if(!count($get_mesajlar)){ exit; }
    
    $get_mesajlar = $get_mesajlar[0];
    
    $mc_title = mc_dil('goruntule').": ".$get_mesajlar->baslik;
    
    $tarih = strtotime($get_mesajlar->tarih);
    
    $mc_mesaj_okundu = false;
    if($mc_grup->id != 1 && $get_mesajlar->durum == 0){
        $mc_mesaj_okundu = $m_vt->guncelle([ 'table'=> "mesajlar", 'values'=>[ 'durum' => 1 ], 'where' => [ 'id'=> $get_mesajlar->id ] ])['sonuc'];
    }