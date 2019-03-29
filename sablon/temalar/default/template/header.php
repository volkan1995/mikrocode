<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8"/>
        <title><?= $title ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="keywords" content="<?= $keywords ?>"/>
        <meta name="description" content="<?= $description ?>"/>
        <link rel="stylesheet" href="css/animate.min.css?v=<?=$onbellek?>" />
        <link rel="stylesheet" href="css/bootstrap.min.css?v=<?=$onbellek?>" />
        <link rel="stylesheet" href="css/font-awesome.min.css?v=<?=$onbellek?>"/>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700,800' rel='stylesheet' type='text/css' />
        <link rel="stylesheet" href="/css/template.css?v=<?=$onbellek?>" />
    </head>
    <body>
    <div class="preloader">
        <div class="sk-spinner sk-spinner-rotating-plane"></div>
    </div>
    <nav class="navbar navbar-default navbar-fixed-top templatemo-nav" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon icon-bar"></span>
                    <span class="icon icon-bar"></span>
                    <span class="icon icon-bar"></span>
                </button>
                <a href="/" class="navbar-brand">
                    <?php
                    if ($m_logo['tr'] > 0) {
                        echo '<img src="' . m_resim($m_logo['tr'], 160, 40, 2) . '"/>';
                    } else {
                        echo $m_baslik;
                    }
                    ?>
                </a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right text-uppercase">
                    <li><a href="#home">Anasayfa</a></li>
                    <li><a href="#divider">Hakkımızda</a></li>
                    <li><a href="#feature">Hizmetlerimiz</a></li>
                    <li><a href="#pricing">Fiyat Listesi</a></li>
                    <li><a href="#contact">Bize Ulaşın</a></li>
                </ul>
            </div>
        </div>
    </nav>