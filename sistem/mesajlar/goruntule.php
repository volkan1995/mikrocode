<?php
if (!defined('m_sistem_header')) {
    define("m_sistem_header", true);
}
require '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'yonetici' . DIRECTORY_SEPARATOR . 'loader.php';
?>  
<div class="row clearfix">
    <div class="col-md-9 col-sm-8 col-xs-12">
        <div class="card">
            <div class="header"><?= mc_ustmenu("mesajlar", $mc_headtitle, true) ?></div>
            <div class="body" id="yazdir_alan">
                <blockquote>
                    <p><b><?=mc_dil('gonderen')?>: </b><?= $get_mesajlar->isim ?></p>
                    <footer><cite><a href="mailto:<?= $get_mesajlar->gonderen ?>"><?= $get_mesajlar->gonderen . "</a> &raquo; <a href='mailto:{$get_mesajlar->alici}'>" . $get_mesajlar->alici ?></a></cite></footer>
                </blockquote>
                <p class="m-t-30"><b><?= $get_mesajlar->baslik ?></b></p>
                <p class="m-t-10"><?= $get_mesajlar->aciklama ?></p>
                <?= $get_mesajlar->icerik ?>
                <blockquote class="m-t-30 blockquote-reverse">
                    <footer><?= date('d', $tarih) . " " . m_ay_ismi(date('m', $tarih)) . " " . date('Y H:i:s', $tarih) ?></footer>
                    <footer><cite><?= $get_mesajlar->ip ?></cite></footer>
                </blockquote>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-4 col-xs-12">
        <div class="card">
            <div class="body">
                <a href="mailto:<?= $get_mesajlar->gonderen ?>" class="btn btn-block btn-default waves-effect"><?=mc_dil('yanitla')?></a>
                <input type="hidden" name="id" value="<?= $get_mesajlar->id ?>" />             
            </div>
        </div>
    </div>
</div>
<?php
if($mc_mesaj_okundu){
    ?>
    <script>
        var mc_mesajlar_alan = $('.navbar .mc_mesajlar_sayac');
        var mc_mesajlar_sayac = parseInt(mc_mesajlar_alan.text()) - 1 ;
        if(mc_mesajlar_sayac < 0){ mc_mesajlar_sayac = 0; }
        mc_mesajlar_alan.text( mc_mesajlar_sayac );
        var mc_mesaj_alan = $('.navbar li.mc_mesaj_id_<?= $get_mesajlar->id ?>');
        if(mc_mesaj_alan.length > 0){
            mc_mesaj_alan.remove();
        }
    </script>
    <?php
}
require mc_sablon . 'footer.php';
