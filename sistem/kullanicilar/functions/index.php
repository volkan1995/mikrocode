<?php
    if($mc_oturum->grup > 2){
        m_git("/404");
    }

    $mc_title = "Kullanıcılar";
    
    $mc_gruplar = $m_vt->select("id")->from("gruplar")->where('panel',1)->result();
    $mc_grupdizi = array();
    if(count($mc_gruplar)){
        foreach ($mc_gruplar as $v) { $mc_grupdizi[] = $v->id; }
    }