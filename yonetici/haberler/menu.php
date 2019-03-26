<?php
$mc_menuler['haberler']['baslik'] = "haberler";

$mc_menuler['haberler']['ikon'] = "pages";

$mc_menuler['haberler']['gorev'][] = [
    'baslik'=>"tum_haberler",
    'ikon'=>"pages",
    'gorev'=>"haberler/"
];

$mc_menuler['haberler']['gorev'][] = [
    'baslik'=>"yeni_haber_ekle",
    'ikon'=>"add",
    'gorev'=>"haberler/ekle.php"
];

$mc_menuler['haberler']['gorev'][] = [
    'baslik'=>"haberleri_sirala",
    'ikon'=>"format_line_spacing",
    'gorev'=>"haberler/sirala.php",
    'gizlilik' => 1
];