<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2><?=mc_dil('ko_p1')?><small><?=mc_dil('ko_p2')?>!</small></h2>
            </div>
            <div class="body">
                <form onsubmit="kurulum3(); return false;" id="kurulum3_form" method="post">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" name="name" value="<?=isset($_SESSION['name'])?$_SESSION['name']:null?>" class="form-control" autocomplete="off" required="" />
                            <label class="form-label"><?=mc_dil('kullanici_adi')?></label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="email" name="mail" value="<?=isset($_SESSION['mail'])?$_SESSION['mail']:null?>" class="form-control" autocomplete="off" required="" />
                            <label class="form-label"><?=mc_dil('email_adresi')?></label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="password" name="pass" value="<?=isset($_SESSION['pass'])?$_SESSION['pass']:null?>" class="form-control" autocomplete="off" required="" />
                            <label class="form-label"><?=mc_dil('yeni_sifre')?></label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="password" name="passr" value="" class="form-control" autocomplete="off" required="" />
                            <label class="form-label"><?=mc_dil('sifreyi_tekrarla')?></label>
                        </div>
                    </div>
                    <a href="<?=$mc_kurulum_url?>?adim=2" class="btn btn-default m-t-15 waves-effect"><?=mc_dil('geri')?></a>
                    <button type="submit" id="kurulum3btn" class="btn btn-primary m-t-15 waves-effect"><?=mc_dil('olustur')?></button>
                    <?php if(isset($_SESSION['name']) && isset($_SESSION['mail']) && isset($_SESSION['pass'])) { ?>
                    <a href="<?=$mc_kurulum_url?>?adim=4" class="btn btn-default m-t-15 waves-effect"><?=mc_dil('ileri')?></a>
                    <?php } ?>
                    <div id="kurulum3_rapor" style="display:none;"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    
    var kurulum3_btn;
    var kurulum3_onay = true;
    function kurulum3(){
        kurulum3_btn = $('#kurulum3btn');
        if(kurulum3_onay === true){
            kurulum3_btn.text('<?=mc_dil('bekleyiniz')?>...');
            kurulum3_onay = false;
            $.post("<?=$mc_kurulum_url?>",
                $("#kurulum3_form").serialize(),
                function(d){
                    setTimeout(function(){ $("#kurulum3_rapor").html(d); }, 1000);   
                }
            );
        }        
    }
    
</script>