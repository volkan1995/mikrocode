<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2><?=mc_dil('kullanici_kontrol')?><small><?=mc_dil('guncelleme_p1')?>!</small></h2>
            </div>
            <div class="body">
                <div class="form-group form-float">
                    <p><?=mc_dil('guncelleme_p2')?></p>
                </div>
                <form onsubmit="kurulum1(); return false;" id="kurulum1_form" method="post">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" name="name" value="" class="form-control" autocomplete="off" required="" />
                            <label class="form-label"><?=mc_dil('kullanici_adi')." / ".mc_dil('email_adresi')?></label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="password" name="pass" value="" class="form-control" autocomplete="off" required="" />
                            <label class="form-label"><?=mc_dil('kullanici_sifreniz')?></label>
                        </div>
                    </div>
                    <a href="<?=$mc_kurulum_url?>?adim=1" class="btn btn-default m-t-15 waves-effect"><?=mc_dil('geri')?></a>
                    <button type="submit" id="kurulum1btn" class="btn btn-primary m-t-15 waves-effect"><?=mc_dil('guncellemeye_basla')?></button>
                    <div id="kurulum1_rapor" style="display:none;"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    
    var kurulum1_btn;
    var kurulum1_onay = true;
    function kurulum1(){
        kurulum1_btn = $('#kurulum1btn');
        if(kurulum1_onay === true){
            kurulum1_btn.text('<?=mc_dil('kontrol_ediliyor')?>...');
            kurulum1_onay = false;
            $.post("<?=$mc_kurulum_url?>?adim=2",
                $("#kurulum1_form").serialize(),
                function(d){
                    setTimeout(function(){ $("#kurulum1_rapor").html(d); }, 1000);   
                }
            );
        }        
    }
    
</script>