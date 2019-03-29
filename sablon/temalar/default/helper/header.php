<?php

$iletisim['email'] = m_jsonAl($m_ayarlar->iletisim, 'email');
$iletisim['telefon1'] = m_jsonAl($m_ayarlar->iletisim, 'telefon1');
$iletisim['telefon2'] = m_jsonAl($m_ayarlar->iletisim, 'telefon2');
$onbellek = m_jsonAl($m_ayarlar->eklenti, 'onbellek', 1);
        
$index_iletisim = m_ekyaz('iletisim', true);

if (isset($m_ayarlar->medya->logo_tr)) {
    $m_logo['tr'] = $m_ayarlar->medya->logo_tr;
} else {
    $m_logo['tr'] = 0;
}

$hizmetler = $m_vt->select()->from("kategoriler")->where("tip", 10)->where('durum', 1)->orderby('sira')->result();
