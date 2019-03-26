<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2><?=mc_dil('kurulum_basliyor')?><small><?=mc_dil('mp_hosgeldiniz')?>!</small></h2>
            </div>
            <div class="body">
                <div class="form-group form-float">
                    <p><?=mc_dil('kurulum_p1')?>.<br/><?=mc_dil('kurulum_p2')?>.</p>
                </div>
                <div class="form-group form-float">
                    <ul>
                        <li><?=mc_dil('vt_turu')?></li>
                        <li><?=mc_dil('vt_sunucusu')?></li>
                        <li><?=mc_dil('vt_ismi')?></li>
                        <li><?=mc_dil('vt_kadi')?></li>
                        <li><?=mc_dil('vt_sifreniz')?></li>
                        <li><?=mc_dil('k_eposta')?></li>
                    </ul>
                </div>
                <div class="form-group form-float">
                <p class='m-b-40'><?=mc_dil('kurulum_p3')?>.</p>
                </div>
                <form method="post" action="<?=$mc_kurulum_url?>">
                    <div class="form-group form-float">
                        <select name="dil" class="form-control show-tick" required="" onchange="this.form.submit()">
                            <option value="<?=$mc_dil?>">-- <?=mc_dil('kurulum_sb')?> --</option>
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