<?php
    if(!defined('m_guvenlik')) { exit; }
    
    function HttpStatus($code) {
	$status = array(
        0 => 'Başarılı',  
        1 => 'Yetkisiz Erişim',  
        2 => 'Yetkisiz İşlem',
        3 => 'Hatalı İstek');   
        return $status[$code] ? $status[$code] : $status[500];
    }
    
    $mapi_dil[0] = "Bilinmeyen istek türü";
    $mapi_dil[1] = "Geçersiz kimlik bilgileri";
    $mapi_dil[2] = "Saatlik işlem limitine ulaşıldı";
    $mapi_dil[3] = "Kalan süre";
    $mapi_dil[4] = "Bu hizmet geçici olarak kullanımdan kaldırıldı";
    $mapi_dil[5] = "Geçersiz alan adı veya kullanıcı adı";
    $mapi_dil[6] = "Select sorgusu için istenen veriler sağlanamadı";
    $mapi_dil[7] = "Select sorgusu sağlanamadı";
    $mapi_dil[8] = "Kullanıcılar tablosuna erişim yetkiniz yok";
    $mapi_dil[9] = "Tüm sütunlar çekilemez, lütfen çekmek istediğiniz sütunları belirtiniz";
    $mapi_dil[10] = "Şifre verilerine erişim yapılamaz";
    $mapi_dil[11] = "dk";
    $mapi_dil[12] = "Eğer bu mesajı alıyorsanız API hizmetiniz çalışıyordur";
    $mapi_dil[13] = "Bu hizmete erişim yetkiniz yok";