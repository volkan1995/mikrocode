<?php
if (isset($index_slayt->durum) && $index_slayt->durum == 1) {
    $index_slayt->eklenti = json_decode($index_slayt->eklenti);
    ?>
    <section id="home" style="background:url('<?= m_resim($index_slayt->resim, 1920, 1024, 1, 100) ?>') no-repeat;">
        <div class="overlay">
            <div class="container">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10 wow fadeIn" data-wow-delay="0.3s">
                        <h1 class="text-upper"><?= $index_slayt->baslik ?></h1>
                        <p class="tm-white"><?= $index_slayt->aciklama ?></p>
                        <?php if (isset($index_slayt->eklenti->adres) && isset($index_slayt->eklenti->adresy) && !empty($index_slayt->eklenti->adresy)) { ?>
                            <h3 class="tm-white"><a href="<?= $index_slayt->eklenti->adres ?>"><?= $index_slayt->eklenti->adresy ?></a></h3>
                        <?php } ?>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>