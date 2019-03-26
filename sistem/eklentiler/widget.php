<?php

if (!isset($_POST['id']) || empty($_POST['id'])) {
    exit;
}
if (!defined('m_baglanti')) {
    define("m_baglanti", true);
}
if (!defined('m_panel')) {
    define("m_panel", true);
}
if (!defined('m_guvenlik')) {
    define("m_guvenlik", true);
}
require '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'index.php';

function m_widget_yukle($mc_widget_yol = null) {
    if (file_exists($mc_widget_yol)) {
        global $m_vt;
        //extract($GLOBALS);
        include $mc_widget_yol;
    }
}
$mc_widget_anayol = null;

if (is_numeric($_POST['id'])) {
    $mc_widget = $m_vt->select()->from('eklentiler')->where('durum', 1)->where('tip', "index")->where('id', $_POST['id'])->result();
    if(count($mc_widget)){
        $mc_widget = $mc_widget[0];        
        if($mc_widget->tabloid == 0){
            $mc_widget_anayol = m_moduller;
        }
        m_widget_yukle($mc_widget_anayol . $mc_widget->icerik . DIRECTORY_SEPARATOR . "plugins" . DIRECTORY_SEPARATOR . "index" . DIRECTORY_SEPARATOR . $mc_widget->tabload. ".php");
    }   
}