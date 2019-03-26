<style>
    .progress-bar {
        -webkit-transition: width .4s ease;
        -o-transition: width .4s ease;
        transition: width .4s ease;
    }
    #kurulum5_1_rapor > div {max-height: 250px;overflow:hidden;overflow-y: auto;}
</style>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2><?=mc_dil('mc_kuruluyor')?><small><?=mc_dil('kurulum_p7')?>!</small></h2>
            </div>
            <div class="body">                
                <div class="progress">
                    <div id="mc_kurulumBar" class="progress-bar bg-light-blue progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div>
                </div>
                <div id="kurulum5_rapor"><p><?=mc_dil('kurulum_basliyor')?>...</p></div>
                <div class="row m-t-20">
                    <div class="col-sm-12">
                        <span class="btn btn-default waves-effect" type="button" data-toggle="collapse" data-target="#kurulum5_1_rapor" aria-expanded="false" aria-controls="kurulum5_1_rapor"><?=mc_dil('surec_detayi')?></span>
                    </div>
                    <div class="collapse" id="kurulum5_1_rapor">
                        <div class="col-sm-12"><p><?=mc_dil('kurulum_basliyor')?>...</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var mc_kurulumUrl = "<?=$mc_kurulum_url?>?adim=<?=$mc_kurulum_son?>";
    var mc_kurulumAdim1 = "<p><?=mc_dil('islem_detay_1').': '.ucfirst($mc_tablolar[0])?></p>";
    var mc_kurulum_it = new Date();
    var mc_kurulum_st = new Date();
    window.onload = function(){
        setTimeout(function(){ $.mcKurulum.basla.aktif(); }, 1000);
    };
</script>