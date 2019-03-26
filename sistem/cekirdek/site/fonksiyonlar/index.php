<?php

function mt_konum($d = null) {
    return mt_isim . '/' . ltrim($d, '/');
}

function mt_dil($yaz = null, $on_ek = "mtd_", $tip = "define"){
    $ful_yaz = $on_ek.$yaz;
    if($tip == "define"){
        if(!empty($ful_yaz) && defined($ful_yaz)){
            return constant($ful_yaz);
        }else{
            return $yaz;
        }
    }
}