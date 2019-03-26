<?php

require 'ayar.php';

$mc_title = mc_dil($mc_modul_ayar['baslik']);

if (mc_yetki($mc_modul_ayar['yetki'])) {

    $tum_kategoriler = $m_vt->select()->from($mc_modul_ayar['tablo'])->where('tip', $mc_modul_ayar['tip'])->groupby('grup')->result();

    if ($mc_oturum->grup > 2 && isset($mc_modul_ayar['tasarim']['izinler']) && $mc_modul_ayar['tasarim']['izinler']) {
        /* Eğer ayar.php dosyasında belirtilen izinler ayarı açık ise olacak işlemler */
        $izinli_kategoriler = array();
        if (isset($mc_oturum->izinler[$mc_modul_ayar['tablo']])) {
            /* İlgili tablonun izinlerde karşılığı varsa döngü ile oturum açmış kullanıcının izinlerinde kontrol et ve izinli olanları diziye aktar */
            foreach ($tum_kategoriler as $value) {
                if (in_array($value->id, $mc_oturum->izinler[$mc_modul_ayar['tablo']])) {
                    $izinli_kategoriler[] = $value->id;
                }
            }
        }
        if (count($izinli_kategoriler)) {
            /* Hem kullanıcının ekledikleri hemde izinli olduklarını listele */
            $tum_kategoriler = $m_vt->select()->from($mc_modul_ayar['tablo'])->where('tip', $mc_modul_ayar['tip'])
                    ->in('AND')
                    ->where('ekleyen', mc_oturum_id)
                    ->inwhere('id', $izinli_kategoriler, "OR")
                    ->out()
                    ->groupby('grup')
                    ->result();
        }else{
            /* Kullanıcının eklediklerini listele */
            $tum_kategoriler = $m_vt->select()->from($mc_modul_ayar['tablo'])->where('tip', $mc_modul_ayar['tip'])->where('ekleyen', mc_oturum_id)->groupby('grup')->result();
        }
    }
}