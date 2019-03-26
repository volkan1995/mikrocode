<?php

if (!defined('mdb_guvenlik')) {
    define("mdb_guvenlik", true);
}

require 'mc.baglan.php';

$mc_mesajlar = $m_vt->select()->from(mdt_messages)->where(mdt_messages_uniq, $_POST['giris_kapisi'])->orderby(mdt_messages_id, "ASC")->result();

$mc_kullanicilar = array();

foreach ($mc_mesajlar as $mc_mesaj) {
    if ($mc_mesaj->{mdt_messages_user} == $_POST['kullanici_id']) {
        echo "<div class='mc_sohbet_right'><p class='mc_sohbet_mesaj'>" . mc_htmlCevir($mc_mesaj->{mdt_messages_text}) . "</p><small>" . mc_zamanHesapla($mc_mesaj->{mdt_messages_datetime}) . "</small></div>";
    } else {
        if (!isset($mc_kullanicilar[$mc_mesaj->{mdt_messages_user}])) {
            $kullanici_sor = $m_vt->select()->from(mdt_users)->where(mdt_users_id, $mc_mesaj->{mdt_messages_user})->result();
            if (!count($kullanici_sor)) {
                $mc_kullanicilar[$mc_mesaj->{mdt_messages_user}]['kadi'] = "Silinen Kullanıcı";
            } else {
                $mc_kullanicilar[$mc_mesaj->{mdt_messages_user}]['kadi'] = $kullanici_sor[0]->{mdt_users_name};
            }
        }
        echo "<div class='mc_sohbet_left'><b>" . $mc_kullanicilar[$mc_mesaj->{mdt_messages_user}]['kadi'] . "</b><p class='mc_sohbet_mesaj'>" .  mc_htmlCevir($mc_mesaj->{mdt_messages_text}) . "</p><small>" . mc_zamanHesapla($mc_mesaj->{mdt_messages_datetime}) . "</small></div>";
    }
}