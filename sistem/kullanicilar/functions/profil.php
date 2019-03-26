<?php 
    $mc_title = mc_dil('profilim'); 
    
    $engelli_moduller = array( '..', '.','index.php', 'loader.php','giris.php', 'cikis.php','kullanicilar', 'tema-olustur', 'modul.php' ,'anketler_arge');
    $moduller = array_diff(scandir(m_moduller), $engelli_moduller);
    $moduller[] = "ek_ozellikler";
    $moduller[] = "m_api";
    $moduller[] = "mesajlar";
    $moduller[] = "dosyalar";
    $tema_modulleri = m_tema . "plugins" . DIRECTORY_SEPARATOR . "yonetici";
    if(file_exists($tema_modulleri) && is_dir($tema_modulleri)){
        $moduller = array_merge($moduller, array_diff(scandir($tema_modulleri), $engelli_moduller));
    }