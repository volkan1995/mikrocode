<?php

$mc_muzikler = explode(",", m_jsonAl($mc_oturum->eklenti, "muzikler"));
if (count($mc_muzikler) > 0) {
    $muzik_bul = $m_vt->select()->from("dosyalar")->where('tip', 3)->inwhere('id', $mc_muzikler)->orderby('id', $mc_muzikler)->result();
} else {
    $muzik_bul = array();
}
if (count($muzik_bul)) {
    $mc_muzikcalar_list = null;
    $mc_muzikcalar = true;
    foreach ($muzik_bul as $muzik) {
        $mc_muzikcalar_list = $mc_muzikcalar_list . '{file:"' . m_domain . '/dosyalar' . $muzik->konum . '",trackName:"' . $muzik->baslik . '"},';
    }
}