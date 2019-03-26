<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2><?=mc_dil('kurulum_p4')?><small><?=mc_dil('kurulum_p5')?>!</small></h2>
            </div>
            <div class="body">
                <table class="table">
                    <tbody>
                        <tr>
                            <th scope="row" style="border-top: none;"><?=mc_dil('vt_turu')?></th>
                            <td style="border-top: none;"><?=isset($mc_vt_suruculer[mdb_driver])?$mc_vt_suruculer[mdb_driver]:$mc_vt_suruculer['mysql']?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?=mc_dil('vt_surucusu')?></th>
                            <td>PDO <?=isset($mc_vt_suruculer[mdb_driver])?mdb_driver:'mysql'?> driver</td>
                        </tr>
                        <tr>
                            <th scope="row"><?=mc_dil('vt_sunucusu')?></th>
                            <td><?=mdb_port>0?mdb_server.':'.mdb_port:mdb_server?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?=mc_dil('vt_ismi')?></th>
                            <td><?=mdb_name?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?=mc_dil('vt_kadi')?></th>
                            <td><?=mdb_user?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?=mc_dil('vt_sifreniz')?></th>
                            <td>
                                <button type="button" class="btn btn-warning btn-xs waves-effect" data-trigger="focus" data-container="body" data-toggle="popover" data-placement="top" title="" data-content="<?=!empty(mdb_pass)?mdb_pass:mc_dil('sifre_belirlenmemis')?>" data-original-title="<?=mc_dil('vt_sifreniz')?>">
                                    <?=mc_dil('goster')?>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?=mc_dil('kullanici_adi')?></th>
                            <td><?=$_SESSION['name']?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?=mc_dil('email_adresi')?></th>
                            <td><?=$_SESSION['mail']?></td>
                        </tr>
                        <tr>
                            <th scope="row" style="border-bottom: none;"><?=mc_dil('kullanici_sifreniz')?></th>
                            <td style="border-bottom: none;">
                                <button type="button" class="btn btn-warning btn-xs waves-effect" data-trigger="focus" data-container="body" data-toggle="popover" data-placement="top" title="" data-content="<?=$_SESSION['pass']?>" data-original-title="<?=mc_dil('kullanici_sifreniz')?>">
                                    <?=mc_dil('goster')?>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group form-float">
                    <p><?=mc_dil('kurulum_p6')?>.</p>
                </div>                
                <a href="<?=$mc_kurulum_url?>?adim=3" class="btn btn-default m-t-10 waves-effect"><?=mc_dil('geri')?></a>
                <a href="<?=$mc_kurulum_url?>?adim=5" class="btn btn-primary m-t-10 waves-effect"><?=mc_dil('kurulumu_tamamla')?></a>                
            </div>
        </div>
    </div>
</div>