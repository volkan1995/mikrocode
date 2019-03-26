<?php
    if(!defined('m_sistem_header')) { define("m_sistem_header", true); }    
    require '../../yonetici/loader.php';
?>  
<form class="row clearfix" id="content-form">
    <div class="col-md-9 col-sm-8 col-xs-12">
        <div class="card">
            <div class="header">
                <h2><?=mc_ustmenu("gruplar",$mc_headtitle, true)?></h2>
            </div>
            <div class="body">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="baslik" placeholder="Başlık" value="<?=$mc_veri->baslik?>"/>
                    </div>
                </div>
                <style>
                    .panel-title { position: relative; }
                    .panel-title .switch { position: absolute; right: 0; top: 8px; }
                </style>
                <div class="panel-group" id="mc_grupayarlar" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="gih_">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#mc_grupayarlar" href="#gia_" aria-expanded="false" aria-controls="gia_" class="collapsed">İzinler</a>
                            </h4>
                        </div>
                        <div id="gia_" class="panel-collapse collapse" role="tabpanel" aria-labelledby="gih_" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                                <?php foreach($moduller as $modul) {
                                    $modul = str_replace('-', '_', $modul);
                                    $modul_i = mc_izin_hazirla(m_jsonAl($mc_veri->yetki,$modul));
                                    ?>
                                <div class="col-md-12 m-b-20">
                                    <p class="m-b-10"><b><?=mc_dil($modul)?></b></p>       
                                    <div class="demo-checkbox">                        
                                        <input type="checkbox" id="<?=$modul?>_i_0" name="<?='izinler['.$modul?>][0]" class="chk-col-theme"<?=$modul_i[0]==1?" checked":null?>/>
                                        <label for="<?=$modul?>_i_0"><?=mc_dil('goruntule')?></label>
                                        <input type="checkbox" id="<?=$modul?>_i_1" name="<?='izinler['.$modul?>][1]" class="chk-col-theme"<?=$modul_i[1]==1?" checked":null?>/>
                                        <label for="<?=$modul?>_i_1"><?=mc_dil('ekle')?></label>
                                        <input type="checkbox" id="<?=$modul?>_i_2" name="<?='izinler['.$modul?>][2]" class="chk-col-theme"<?=$modul_i[2]==1?" checked":null?>/>
                                        <label for="<?=$modul?>_i_2"><?=mc_dil('duzenle')?></label>
                                        <input type="checkbox" id="<?=$modul?>_i_3" name="<?='izinler['.$modul?>][3]" class="chk-col-theme"<?=$modul_i[3]==1?" checked":null?>/>
                                        <label for="<?=$modul?>_i_3"><?=mc_dil('sil')?></label>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-4 col-xs-12">
        <div class="card">
            <div class="body">
                <button type="submit" class="btn btn-sm btn-theme waves-effect"><?=mc_dil('kaydet')?></button>
                <input type="hidden" name="id" value="<?=$_GET['id']?>"/>
                <div class="switch m-t-20">
                    <b>Panel</b>
                    <label><input name="panel" type="checkbox"<?=$mc_veri->panel==1?' checked':null?>/><span class="lever switch-col-theme"></span></label>
                </div>
                <div class="switch m-t-20">
                    <b>Site</b>
                    <label><input name="site" type="checkbox"<?=$mc_veri->site==1?' checked':null?>/><span class="lever switch-col-theme"></span></label>
                </div> 
            </div>
        </div>
    </div>
</form>
<?php require_once mc_sablon.'footer.php';