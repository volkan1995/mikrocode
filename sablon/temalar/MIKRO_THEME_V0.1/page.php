<section class="banner-area relative back-img" id="home" style="background-image: url('<?=$cover_img?>')">	
    <div class="overlay overlay-bg"></div>
    <div class="container">				
        <div class="row d-flex align-items-center justify-content-center">
            <div class="about-content col-lg-12">
                <h1 class="text-white">
                    <?= $sayfa->baslik ?>				
                </h1>	
                <p class="text-white link-nav"><a href="/"><?= mt_dil('anasayfa') ?> </a>  <span class="lnr lnr-arrow-right"></span>  <a href="#"> <?= $sayfa->baslik ?></a></p>
            </div>	
        </div>
    </div>
</section>
<section class="post-content-area">
    <div class="container">
        <div class="row align-items-top">
            <div class="sidebar-widgets col-lg-4">
                <div class="widget-wrap">
                    <div class="single-sidebar-widget post-category-widget">
                        <h4 class="category-title"><?= $sayfa->baslik ?></h4>
                        <ul class="cat-list">
                            <?php
                            foreach ($sayfalar as $key) {
                                if($key->tip == "yonlendir"){
                                    $sayfa_url = $key->icerik;
                                }else{
                                    $sayfa_url = "/{$sef}/{$key->sef}";
                                }
                                ?>
                                <li>
                                    <a href="<?= $sayfa_url ?>" class="d-flex justify-content-between">
                                        <p><?= $key->baslik ?></p>
                                    </a>
                                </li>	
                            <?php }
                            ?>								
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <?php
                    echo htmlspecialchars_decode($sayfa->icerik);
                    
                    if (count($galeri)) {
                        echo '<div class="row mt-30">';
                        foreach ($galeri as $key => $resim) {
                            $resim_url = m_resim($resim);
                            echo '<div class="col-sm-4 col-xs-2 mb-30"><a href="'.$resim_url.'" class="image-link"><img class="thumbnail" src="'.m_resim($resim_url, 250, 250, 1).'"/></div>';
                        }
                        echo '</div>';
                    }
                    
                ?>
            </div>
        </div>
    </div>	
</section>
<style> .thumbnail{width:100%;} </style>
<script>
    hazir(function () {
        if ($('.image-link').length > 0) {
            $('.image-link').magnificPopup({type: 'image', gallery: {
                enabled: true
            }});
        }
    });
</script>