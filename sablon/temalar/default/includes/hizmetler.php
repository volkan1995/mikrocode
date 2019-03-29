<?php
$fr = true;
foreach ($hizmetler as $hizmet) {
    if ($fr) {
        ?>
        <section id="feature">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 wow fadeInLeft" data-wow-delay="0.6s">
                        <h2 class="text-uppercase"><?= $hizmet->baslik ?></h2>
                        <?= $hizmet->icerik ?>
                    </div>
                    <div class="col-md-6 wow fadeInRight" data-wow-delay="0.6s">
                        <img src="<?= m_resim($hizmet->resim, 640, 420) ?>" class="img-responsive" alt="<?= $hizmet->baslik ?>" />
                    </div>
                </div>
            </div>
        </section>
        <?php
        $fr = false;
    } else {
        $fr = true;
        ?>
        <section id="feature1">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                        <img src="<?= m_resim($hizmet->resim, 640, 420) ?>" class="img-responsive" alt="<?= $hizmet->baslik ?>" />
                    </div>
                    <div class="col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                        <h2 class="text-uppercase"><?= $hizmet->baslik ?></h2>
                        <?= $hizmet->icerik ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}
?>