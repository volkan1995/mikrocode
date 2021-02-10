<?php
    $m_rota->sablonDosyalar(
        [
            'functions/template/header.php',
            'template/components/header.php'
        ],[
            'template/components/footer.php'
        ],
        false
    );
    
    $m_rota->dil = TRUE;
    
    $m_rota->get('/', "index.php");
    $m_rota->get('/iletisim', "contact.php");

    $m_rota->post('/gonder', "functions/post/send-message.php");
    $m_rota->import('/css/template.css', "template/css.color.php");

    /* Ürünler TR */    
    $m_rota->get('/urunler', "categories.php");    
    $m_rota->get('/urunler/###', "products.php", function($kategori_sef){ return get_defined_vars(); });
    $m_rota->get('/urunler/###/###', "product.php", function($kategori_sef, $sef){ return get_defined_vars(); });
    /* Ürünler EN */
    $m_rota->get('/products', "categories.php");    
    $m_rota->get('/products/###', "products.php", function($kategori_sef){ return get_defined_vars(); });
    $m_rota->get('/products/###/###', "product.php", function($kategori_sef, $sef){ return get_defined_vars(); });
    /* Ürünler FR */
    $m_rota->get('/produits', "categories.php");    
    $m_rota->get('/produits/###', "products.php", function($kategori_sef){ return get_defined_vars(); });
    $m_rota->get('/produits/###/###', "product.php", function($kategori_sef, $sef){ return get_defined_vars(); });
    /* Ürünler AR */
    $m_rota->get('/lmntg-t', "categories.php");    
    $m_rota->get('/lmntg-t/###', "products.php", function($kategori_sef){ return get_defined_vars(); });
    $m_rota->get('/lmntg-t/###/###', "product.php", function($kategori_sef, $sef){ return get_defined_vars(); });
    
    /* Haberler */
    $m_rota->get('/haberler', "news.php");    
    $m_rota->get('/haberler/###-###', "new.php", function($sef,$id){ return get_defined_vars(); });
    
    /* Kataloglar */
    $m_rota->get('/kataloglar', "catalogs.php");    
    $m_rota->url('/kataloglar/###', "catalog/index.php", function($sef){ return get_defined_vars(); });   
    
    $m_rota->get('/kilavuzlar', "guidecategories.php");    
    $m_rota->get('/kilavuzlar/###', "guides.php", function($kategori_sef){ return get_defined_vars(); });
    
    
    /* QR yazdırma sayfası (6 lı) */
    $m_rota->url('/export', "qr/create.php");
    
    /* Arama */
    $m_rota->get('/qr-tara', "qr/index.php");
    $m_rota->get('/ara', "search.php");
    
    /* Hiçbir içerik yoksa 404'a at */    
    $m_rota->get('/404', "404.php");
    
    /* QR sorgulaması */
    $m_rota->url('/qr/###/###', "qr.php", function($dil,$id){ return get_defined_vars(); });
    
    /* Varsayılan yönlendirme */    
    $m_rota->get('/###', "page.php", function($sef){ return get_defined_vars(); });    
    $m_rota->get('/###/###', "page.php", function($sef, $altsayfa){ return get_defined_vars(); });     
    $m_rota->get('/###/###/###', "page.php", function($sef, $altsayfa, $enaltsayfa){ return get_defined_vars(); });
    
    