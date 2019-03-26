<?php
$mc_menuler['markalar']['baslik'] = "markalar";

$mc_menuler['markalar']['ikon'] = "business";

$mc_menuler['markalar']['gorev'][] = [
    'baslik'=>"tum_markalar",
    'ikon'=>"business",
    'gorev'=>"markalar/"
];

$mc_menuler['markalar']['gorev'][] = [
    'baslik'=>"yeni_marka_ekle",
    'ikon'=>"add",
    'gorev'=>"markalar/ekle.php"
];

$mc_menuler['markalar']['gorev'][] = [
    'baslik'=>"markalari_sirala",
    'ikon'=>"format_line_spacing",
    'gorev'=>"markalar/sirala.php",
    'gizlilik' => 1
];