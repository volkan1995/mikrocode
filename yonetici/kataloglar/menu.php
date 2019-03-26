<?php
$mc_menuler['kataloglar']['baslik'] = "kataloglar";

$mc_menuler['kataloglar']['ikon'] = "view_quilt";

$mc_menuler['kataloglar']['gorev'][] = [
    'baslik'=>"tum_kataloglar",
    'ikon'=>"view_quilt",
    'gorev'=>"kataloglar/"
];

$mc_menuler['kataloglar']['gorev'][] = [
    'baslik'=>"yeni_katalog_ekle",
    'ikon'=>"add",
    'gorev'=>"kataloglar/ekle.php"
];

$mc_menuler['kataloglar']['gorev'][] = [
    'baslik'=>"kataloglari_sirala",
    'ikon'=>"format_line_spacing",
    'gorev'=>"kataloglar/sirala.php",
    'gizlilik' => 1
];