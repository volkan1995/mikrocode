<?php
if (isset($index_iletisim->durum) && $index_iletisim->durum == 1) {
    $back_img = null;
    if ($index_iletisim->resim > 0) {
        $back_img = ' style="background:url(\'' . m_resim($index_iletisim->resim, 1920, 1024, 1, 100) . '\') no-repeat;"';
    }
    ?>
    <section id="contact"<?= $back_img ?>>
        <div class="overlay">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                        <h2 class="text-uppercase"><?= $index_iletisim->baslik ?></h2>
                        <?= $index_iletisim->icerik ?>
                        <address>
                            <p><i class="fa fa-map-marker"></i><?= m_jsonAl($m_ayarlar->iletisim, 'adres') . " / " . m_jsonAl($m_ayarlar->iletisim, 'bolge') ?></p>
                            <p><i class="fa fa-phone"></i> <?php
                            echo $iletisim['telefon1'];
                            if (!empty($iletisim['telefon2'])) {
                                echo " / " . $iletisim['telefon2'];
                            }
                            ?></p>
                            <p><i class="fa fa-envelope-o"></i> <?= $iletisim['email'] ?></p>
                        </address>
                    </div>
                    <div class="col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="contact-form">
                            <form class="oto_form" action="/gonder" method="post" data-result=".sonuc_alan">
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Adınız" required=""/>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email" class="form-control" placeholder="E-posta" required=""/>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" name="subject" class="form-control" placeholder="Konu" required=""/>
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control" name="message" placeholder="Mesajınız" rows="4" required=""></textarea>
                                </div>
                                <div class="col-md-8">
                                    <input type="submit" class="form-control text-uppercase" value="Gönder" />
                                    <p class="sonuc_alan"></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>