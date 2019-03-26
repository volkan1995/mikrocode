<?php if(!defined('m_guvenlik')) { exit; } ?>    
<ol id="mc_dosya_agac" class="breadcrumb breadcrumb-bg-<?=$mc_oturum->tema->renk?>">
    <li class="no_pre" style="display: none">
        <a href="#" class="btn-circle-xs waves-effect waves-circle waves-float m-t--5">
            <i class="material-icons" style="line-height: 32px">arrow_back</i>
        </a>
    </li>
    <li class="agac"><a href="javascript:void(0);" target="dir" data-tip="<?=$_POST['tip']?>" data-id="0"><i class="material-icons">home</i> <?=$tip_isim?></a></li>
</ol>
<div class="ust_sag_menu dropdown">
    <a href="javascript:void(0);" class="col-white m-r-20 mcd_coklusilbtn"><i class="material-icons">delete_sweep</i></a>  
    <a href="javascript:void(0);" class="dropdown-toggle col-white m-r-20 mc_sag_iptal"><i class="material-icons">subdirectory_arrow_right</i></a>    
    <?php if($mc_oturum->grup < 3 || m_jsonAl($m_ayarlar->ayar,"mcykoe") != 1){ ?>
    <a href="javascript:void(0);" class="dropdown-toggle col-white" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="material-icons">more_vert</i></a>
    <ul class="dropdown-menu pull-right">
        <li><a href="javascript:void(0);" id="mc_yeniklasor_btn" class="waves-effect waves-block">Yeni Klasör</a></li>
    </ul>
    <?php } ?>
</div>
<div class="modal-body" id="mc_dosyamodal">
    <input type='hidden' id='mc_liste_tablo' value='dosyalar'/>
    <input type='hidden' id='mc_liste_baslik' value='baslik'/>