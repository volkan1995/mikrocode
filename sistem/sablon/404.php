<?php
if (!defined('m_guvenlik')) {
    define("m_guvenlik", true);
}
require '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'index.php';
if (file_exists(m_temalar . mt_isim . DIRECTORY_SEPARATOR . "404.php")) {
    require m_temalar . mt_isim . DIRECTORY_SEPARATOR . "404.php";
    exit;
} else if (file_exists(m_temalar . mt_isim . DIRECTORY_SEPARATOR . "404.html")) {
    require m_temalar . mt_isim . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . "404.html";
    exit;
} else if (file_exists(m_temalar . mt_isim . "404.htm")) {
    require m_temalar . mt_isim . DIRECTORY_SEPARATOR . "404.html";
    exit;
}
$mc_sablon = mc_sistem . "sablon/";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
        <title>404 Sayfa Bulunamadı</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css" />
        <link href="<?= $mc_sablon ?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet" />        
        <link href="<?= $mc_sablon ?>plugins/node-waves/waves.css" rel="stylesheet" />    
        <link href="<?= $mc_sablon ?>css/style.css" rel="stylesheet">
    </head>
    <body class="four-zero-four">
    <div class="four-zero-four-container">
        <div class="error-code">404</div>
        <div class="error-message">Aradığınız sayfa bulunamadı</div>
        <div class="button-place">
            <a href="/" class="btn btn-default btn-lg waves-effect">Anasayfa'ya Dön</a>
        </div>
    </div>
    <script src="<?= $mc_sablon ?>plugins/jquery/jquery.min.js"></script>
    <script src="<?= $mc_sablon ?>plugins/bootstrap/js/bootstrap.js"></script>
    <script src="<?= $mc_sablon ?>plugins/node-waves/waves.js"></script>
</body>
</html>