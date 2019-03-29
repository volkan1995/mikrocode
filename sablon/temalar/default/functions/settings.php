<?php
    $m_rota->sablonDosyalar(
        [
            'helper/header.php',
            'template/header.php'
        ],[
            'template/footer.php'
        ]
    );
    
    $m_rota->get('/', "index.php", null, false);
    $m_rota->get('/404', "404.php");
    $m_rota->post('/gonder', "functions/post/send-message.php", null, false);
    $m_rota->import('/css/template.css', "template/css.color.php");