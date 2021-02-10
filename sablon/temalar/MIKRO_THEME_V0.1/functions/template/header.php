<?php

$_rtl = false;
if(isset($m_diller[$mt_dil])){
    if(!empty($m_diller[$mt_dil]->hizala)){
       $_rtl = true;
    }
}

$iletisim['email'] = m_jsonAl($m_ayarlar->iletisim, 'email');
$iletisim['telefon1'] = m_jsonAl($m_ayarlar->iletisim, 'telefon1');
$iletisim['telefon2'] = m_jsonAl($m_ayarlar->iletisim, 'telefon2');
$iletisim['adres'] = m_jsonAl($m_ayarlar->iletisim, 'adres');
$iletisim['bolge'] = m_jsonAl($m_ayarlar->iletisim, 'bolge');
$iletisim['map'] = m_jsonAl($m_ayarlar->iletisim, 'map');


$iletisim['facebook'] = m_jsonAl($m_ayarlar->iletisim, 'facebook');
$iletisim['twitter'] = m_jsonAl($m_ayarlar->iletisim, 'twitter');
$iletisim['pinterest'] = m_jsonAl($m_ayarlar->iletisim, 'pinterest');
$iletisim['linkedin'] = m_jsonAl($m_ayarlar->iletisim, 'linkedin');

$m_logo['tr'] = m_resim(m_ekyaz('logo1_tr', 'resim'));
$f_logo['tr'] = m_resim(m_ekyaz('logo2_tr', 'resim'));
$h_logo['tr'] = m_resim(m_ekyaz('logo3_tr', 'resim'));

$footer_text = m_ekyaz('footer_text_' . $mt_dil, true);

$popup = m_ekyaz('popup_' . $mt_dil, true);    
$popup_durum = false;
if(!empty($popup->durum)){
    if(isset($_COOKIE["flatellipopup"])){
        if($_COOKIE["flatellipopup"] != $popup->baslik){
            setcookie("flatellipopup", $popup->baslik, time() + (3600 * 6 * 1));
            $popup_durum = true;
        }
    }else{
        setcookie("flatellipopup", $popup->baslik, time() + (3600 * 6 * 1));
        $popup_durum = true;
    }
}
function ust_menuyaz($dil = null){
    $rtn = null;
    global $m_vt;
    $sayfalar = $m_vt->select()->from('sayfalar')->where('ust', 0)->where('durum', 1)->where('menu', 1)->where('dil', $dil)->orderby('sira, baslik')->result();        
    foreach ($sayfalar as $sayfa) {
        $adres = null;
        $listele = false;
        $sekme = null;
        if($sayfa->tip == "yonlendir"){
            $adres = $sayfa->icerik;
            $sayfa->eklenti = json_decode($sayfa->eklenti);
            if(isset($sayfa->eklenti->sekme) && $sayfa->eklenti->sekme == 1){ $sekme = ' target="_blank"'; }
        }
        elseif($sayfa->tip == "yazi"){ $adres = "/".$sayfa->sef; }
        else{ $listele = true; $adres = "/".$sayfa->sef; }
        if($listele){
            $altsayfalar = $m_vt->select()->from($sayfa->tip)->where('dil', $dil)->orderby('sira, baslik');
            $whereal = explode(",", $sayfa->icerik);
            foreach($whereal as $whr){
                $whral = explode(":", $whr);
                if(count($whral) == 2){ $altsayfalar = $altsayfalar->where($whral[0], $whral[1]); }
            }
            $altsayfalar = $altsayfalar->where('durum', 1)->result();
            $rtn.='<li class="menu-has-children ust_menu_'.$sayfa->sef.'">';
            $rtn.='<a href="'.$adres.'"'.$sekme.'>'.$sayfa->baslik.'</a>';
            $rtn.='<ul>';
            foreach ($altsayfalar as $altsayfa){
                $altsayfa->eklenti = json_decode($altsayfa->eklenti);
                if(isset($altsayfa->eklenti->sekme) && $altsayfa->eklenti->sekme == 1){ $sekme1 = ' target="_blank"'; }else{ $sekme1 = null; }
                $rtn.='<li><a href="/'.$sayfa->sef.'/'.$altsayfa->sef.'"'.$sekme1.'>'.$altsayfa->baslik.'</a></li>';
            }
            $rtn.='</ul></li>';                
        }else{
            $altsayfalar = $m_vt->select()->from('sayfalar')->where('ust', $sayfa->id)->where('durum', 1)->where('menu', 1)->where('dil', $dil)->orderby('sira, baslik')->result();   
            if(!count($altsayfalar)){
                $rtn.='<li class="nav-menu"><a class="nav-link" href="'.$adres.'"'.$sekme.'>'.$sayfa->baslik.'</a></li>'; 
            }else{
                $rtn.='<li class="menu-has-children ust_menu_'.$sayfa->sef.'">';
                $rtn.='<a href="'.$adres.'">'.$sayfa->baslik.'</a>';
                $rtn.='<ul>';
                foreach ($altsayfalar as $altsayfa){
                    $adres = null;
                    $sekme = null;
                    if($altsayfa->tip == "yonlendir"){
                        $adres = $altsayfa->icerik;
                        $altsayfa->eklenti = json_decode($altsayfa->eklenti);
                        if(isset($altsayfa->eklenti->sekme) && $altsayfa->eklenti->sekme == 1){ $sekme = ' target="_blank"'; }
                    }
                    elseif($altsayfa->tip == "yazi"){ $adres = "/".$sayfa->sef."/".$altsayfa->sef; }
                    $rtn.='<li><a href="'.$adres.'"'.$sekme.'>'.$altsayfa->baslik.'</a></li>';
                }
                $rtn.='</ul></li>';
            }
        }
    }
    return $rtn;
}