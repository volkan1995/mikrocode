<?php if (isset($index_kurumsal->durum) && $index_kurumsal->durum == 1) { ?>
    <section id="divider">
        <div class="container">
            <div class="row"><?= $index_kurumsal->icerik ?></div>
        </div>
    </section>
<?php } ?>