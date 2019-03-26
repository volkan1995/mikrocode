<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2><?=mc_dil('guncellemeye_basla')?><small><?=mc_dil('mp_hosgeldiniz')?>!</small></h2>
            </div>
            <div class="body">
                <div class="form-group form-float">
                    <p><?=mc_dil('guncelleme_p1')?>!</p>
                    <p><?=mc_dil('guncelleme_p3')?>.</p>
                </div>
                <form method="post" action="<?=$mc_kurulum_url?>">
                    <div class="form-group form-float">
                        <select name="dil" class="form-control show-tick  m-t-30" required="" onchange="this.form.submit()">
                            <option value="">-- <?=mc_dil('kurulum_sb')?> --</option>
                            <?php
                                $mc_secili_dil = false;
                                foreach ($mc_diller as $key => $value){
                                    if($mc_dil == $key && isset($_SESSION['dil'])){ echo "<option value='$key' selected>".$value['dil']."</option>"; $mc_secili_dil = true; }
                                    else{ echo "<option value='$key'>".$value['dil']."</option>"; }
                                }
                            ?>
                        </select>
                    </div>
                    <?php if(isset($_SESSION['dil']) && !empty($_SESSION['dil']) && $mc_secili_dil) { ?>
                    <a href="<?=$mc_kurulum_url?>?adim=2" class="btn btn-primary m-t-15 waves-effect"><?=mc_dil('ileri')?></a>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>