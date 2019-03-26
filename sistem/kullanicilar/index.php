<?php
    if(!defined('m_sistem_header')) { define("m_sistem_header", true); }
    require '../../yonetici/loader.php';
    $mc_kullanicilar = new mc_liste();
    $mc_kullanicilar->gorsel = true;
    $mc_kullanicilar->durum = true;
    $mc_kullanicilar->menu = "genel";
    $mc_kullanicilar->tablo = "kullanicilar";
    $mc_kullanicilar->araclar = ['duzenle', 'sil', 'yayin'];
    $mc_kullanicilar->baslik = "kadi";
    $mc_kullanicilar->aciklama = "mail";
    $mc_kullanicilar->tarih = "etarih";
    $mc_kullanicilar->veriler = $m_vt
            ->select()
            ->from("kullanicilar")
            ->inwhere('grup',$mc_grupdizi)
            ->in("AND")
                ->where('id', mc_oturum_id)
                ->where('grup', 1, "<>", "OR")
            ->out()
            ->result();

    echo '<div class="row clearfix">';
    $mc_kullanicilar->olustur();
    echo '</div>';
    require_once mc_sablon.'footer.php';