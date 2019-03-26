<?php
$mc_menuler['urunler']['baslik'] = "urunler";

$mc_menuler['urunler']['ikon'] = "shopping_cart";

$mc_menuler['urunler']['gorev'][] = [
    'baslik'=>"tum_urunler",
    'ikon'=>"shopping_cart",
    'gorev'=>"urunler/"
];

$mc_menuler['urunler']['gorev'][] = [
    'baslik'=>"yeni_urun_ekle",
    'ikon'=>"add",
    'gorev'=>"urunler/ekle.php"
];

$mc_menuler['urunler']['gorev'][] = [
    'baslik'=>"urunleri_sirala",
    'ikon'=>"format_line_spacing",
    'gorev'=>"urunler/sirala.php",
    'gizlilik' => 1
];