<section id="pricing">
    <div class="container">
        <div class="row">
            <div class="col-md-12 wow bounceIn">
                <h2 class="text-uppercase">Fiyat Listesi</h2>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <?php
                    $syc = 0;
                    foreach ($hizmetler as $hizmet) {
                        $fiyatlar = $m_vt->select()->from("yazilar")->where("kategori", $hizmet->id)->where('durum', 1)->result();
                        if(!count($fiyatlar)){ continue; }
                        ?>
                        <div class="col-md-4 wow fadeIn" data-wow-delay="0.6s">
                            <div class="pricing text-uppercase">
                                <div class="pricing-title">
                                    <h4><?=$hizmet->baslik?></h4>
                                    <small class="text-lowercase"><?=$hizmet->aciklama?></small>
                                </div>
                                <ul>
                                    <?php
                                        foreach ($fiyatlar as $fiyat) {
                                            echo '<li>'.$fiyat->baslik . ' <span class="ml-fiyat">' . $fiyat->aciklama .'</span></li>';
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <?php
                        $syc++;
                        if ($syc >= 3) {
                            $syc = 0;
                            echo '</div></div><div class="col-md-12"><div class="row">';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>