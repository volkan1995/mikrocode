<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2><?=mc_dil('vt_p1')?><small><?=mc_dil('vt_p2')?>!</small></h2>
            </div>
            <div class="body">
                <form onsubmit="kurulum2(); return false;" id="kurulum2_form" method="post">
                    <div class="row clearfix m-t-15">
                        <div class="col-sm-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="db_server" class="form-control" value="<?=defined('mdb_server')?mdb_server:'localhost'?>" autocomplete="off" required="" />
                                    <label class="form-label"><?=mc_dil('vt_sunucusu')?></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="db_name" value="<?=defined('mdb_name')?mdb_name:null?>" class="form-control" autocomplete="off" required="" />
                                    <label class="form-label"><?=mc_dil('vt_ismi')?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="db_user" class="form-control" value="<?=defined('mdb_user')?mdb_user:null?>" autocomplete="off" required="" />
                                    <label class="form-label"><?=mc_dil('vt_kadi')?></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="db_pass" value="<?=defined('mdb_pass')?mdb_pass:null?>" class="form-control" autocomplete="off" />
                                    <label class="form-label"><?=mc_dil('vt_sifreniz')?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 p-b-10">
                            <span class="waves-effect" type="button" data-toggle="collapse" data-target="#gelismisAyarlar" aria-expanded="false" aria-controls="gelismisAyarlar"><?=mc_dil('gelismis_ayarlar')?></span>
                        </div>
                        <div class="collapse" id="gelismisAyarlar">                            
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="m_firma" class="form-control" value="<?=defined('m_firma')?m_firma:null?>" autocomplete="off"/>
                                        <label class="form-label"><?=mc_dil('firma')." <small>(".mc_dil('zorunlu_degil').")</small>"?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="m_firma_url" class="form-control" value="<?=defined('m_firma_url')?m_firma_url:null?>" autocomplete="off"/>
                                        <label class="form-label"><?=mc_dil('firma_url')." <small>(".mc_dil('zorunlu_degil').")</small>"?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <select class="form-control show-tick" name="db_driver">
                                    <option value="">-- <?=mc_dil('vt_turu')?> --</option>
                                    <?php
                                        if(!defined('mdb_driver') || !isset($mc_vt_suruculer[mdb_driver])){
                                            echo "<option value=\"mysql\" selected>".$mc_vt_suruculer['mysql']."</option>";
                                            unset($mc_vt_suruculer['mysql']);
                                        }else if(defined('mdb_driver') && isset($mc_vt_suruculer[mdb_driver])){
                                            echo "<option value=\"".mdb_driver."\" selected>".$mc_vt_suruculer[mdb_driver]."</option>";
                                            unset($mc_vt_suruculer[mdb_driver]);
                                        }
                                        foreach ($mc_vt_suruculer as $key => $value) {
                                            echo "<option value=\"$key\">$value</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="db_port" class="form-control" value="<?=defined('mdb_port')?mdb_port:null?>" autocomplete="off"/>
                                        <label class="form-label"><?=mc_dil('port')." <small>(".mc_dil('zorunlu_degil').")</small>"?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="<?=$mc_kurulum_url?>?adim=1" class="btn btn-default m-t-15 waves-effect"><?=mc_dil('geri')?></a>                    
                    <button type="submit" id="kurulum2btn" class="btn btn-primary m-t-15 waves-effect"><?=mc_dil('baglan')?></button>
                    <?php if($mc_kurulum_vtb) { ?>
                    <a href="<?=$mc_kurulum_url?>?adim=3" class="btn btn-default m-t-15 waves-effect"><?=mc_dil('ileri')?></a>
                    <?php } ?>
                    <div id="kurulum2_rapor" style="display:none;"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    
    var kurulum2_btn;
    var kurulum2_onay = true;
    function kurulum2(){
        kurulum2_btn = $('#kurulum2btn');
        if(kurulum2_onay === true){
            kurulum2_btn.text('<?=mc_dil('baglaniliyor')?>...');
            kurulum2_onay = false;
            $.post("<?=$mc_kurulum_url?>",
                $("#kurulum2_form").serialize(),
                function(d){
                    setTimeout(function(){ $("#kurulum2_rapor").html(d); }, 1000);   
                }
            );
        }        
    }
    
</script>