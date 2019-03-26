<?php

if(!defined('m_tema_header')) { define("m_tema_header", true); }

require 'loader.php';

if(file_exists($mc_this_file)){
    
    include $mc_this_file;
    
}

require mc_sablon.'footer.php';