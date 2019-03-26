<?php
    if(!defined('m_guvenlik')) { exit; }   
?>
<style>
    .panel-title { position: relative; }
    .panel-title .switch { position: absolute; right: 0; top: 8px; }
</style>
<div class="panel-group" id="zg_" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="zg_dk>">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#zg_" href="#zgi_dk" aria-expanded="false" aria-controls="zgi_dk" class="collapsed"><?=mc_dil('dakikalik_gorevler')?></a>
                <div class="switch">
                    <label><input name="zg_dk" type="checkbox"/><span class="lever switch-col-theme"></span></label>
                </div>
            </h4>
        </div>
        <div id="zgi_dk" class="panel-collapse collapse" role="tabpanel" aria-labelledby="zg_dk" aria-expanded="false" style="height: 0px;">
            <div class="panel-body"> 
                <p class="m-b-10"><b>Belirlenen dakika aralığında çalışacak görevler</b></p>                
                <div class="col-md-12 m-b-20"> 
                    <div class="demo-checkbox">                        
                        <input type="checkbox" id="zd_dk_mt" name="zd_dk_mt" class="chk-col-theme"/>
                        <label for="zd_dk_mt">Yeni modülleri tara</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
     <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="zg_sa>">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#zg_" href="#zgi_sa" aria-expanded="false" aria-controls="zgi_sa" class="collapsed"><?=mc_dil('saatlik_gorevler')?></a>
                <div class="switch">
                    <label><input name="zg_sa" type="checkbox"/><span class="lever switch-col-theme"></span></label>
                </div>
            </h4>
        </div>
        <div id="zgi_sa" class="panel-collapse collapse" role="tabpanel" aria-labelledby="zg_sa" aria-expanded="false" style="height: 0px;">
            <div class="panel-body">
                <p class="m-b-10"><b>Belirlenen saat aralığında çalışacak görevler</b></p>  
                <div class="col-md-12 m-b-20">   
                    <div class="demo-checkbox">                        
                        <input type="checkbox" id="zd_sa_dgc" name="zd_sa_dgc" class="chk-col-theme"/>
                        <label for="zd_sa_dgc">Dakikalık görevlerde seçilenleri çalıştır</label>
                    </div>  
                    <div class="demo-checkbox">                        
                        <input type="checkbox" id="zd_sa_evg" name="zd_sa_evg" class="chk-col-theme"/>
                        <label for="zd_sa_evg">Eklenti verilerini güncelleştir</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="zg_gn>">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#zg_" href="#zgi_gn" aria-expanded="false" aria-controls="zgi_gn" class="collapsed"><?=mc_dil('gunluk_gorevler')?></a>
                <div class="switch">
                    <label><input name="zg_gn" type="checkbox"/><span class="lever switch-col-theme"></span></label>
                </div>
            </h4>
        </div>
        <div id="zgi_gn" class="panel-collapse collapse" role="tabpanel" aria-labelledby="zg_gn" aria-expanded="false" style="height: 0px;">
            <div class="panel-body">
                <p class="m-b-10"><b>Belirlenen gün aralığında çalışacak görevler</b></p>  
                <div class="col-md-12 m-b-20">
                    <div class="demo-checkbox">                        
                        <input type="checkbox" id="zd_gn_sgc" name="zd_gn_sgc" class="chk-col-theme"/>
                        <label for="zd_gn_sgc">Saatlik görevlerde seçilenleri çalıştır</label>
                    </div>
                    <div class="demo-checkbox">                        
                        <input type="checkbox" id="zd_gn_gkk" name="zd_gn_gkk" class="chk-col-theme"/>
                        <label for="zd_gn_gkk">Güncelleştirmeleri kontrol et</label>
                    </div>
                    <div class="demo-checkbox">                        
                        <input type="checkbox" id="zd_gn_git" name="zd_gn_git" class="chk-col-theme"/>
                        <label for="zd_gn_git">Gereksiz ip kayıtlarını temizle</label>
                    </div>
                    <div class="demo-checkbox">                        
                        <input type="checkbox" id="zd_gn_gae" name="zd_gn_gae" class="chk-col-theme"/>
                        <label for="zd_gn_gae">Günü analiz et</label>
                    </div>
                    <div class="demo-checkbox">                        
                        <input type="checkbox" id="zd_gn_shd" name="zd_gn_shd" class="chk-col-theme"/>
                        <label for="zd_gn_shd">Site haritasını denetle</label>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="zg_hf>">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#zg_" href="#zgi_hf" aria-expanded="false" aria-controls="zgi_hf" class="collapsed"><?=mc_dil('haftalik_gorevler')?></a>
                <div class="switch">
                    <label><input name="zg_hf" type="checkbox"/><span class="lever switch-col-theme"></span></label>
                </div>
            </h4>
        </div>
        <div id="zgi_hf" class="panel-collapse collapse" role="tabpanel" aria-labelledby="zg_hf" aria-expanded="false" style="height: 0px;">
            <div class="panel-body">
                <p class="m-b-10"><b>Belirlenen hafta aralığında çalışacak görevler</b></p>  
                <div class="col-md-12 m-b-20">
                    <div class="demo-checkbox">                        
                        <input type="checkbox" id="zd_hf_ggc" name="zd_hf_ggc" class="chk-col-theme"/>
                        <label for="zd_hf_ggc">Günlük görevlerde seçilenleri çalıştır</label>
                    </div>
                    <div class="demo-checkbox">                        
                        <input type="checkbox" id="zd_hf_soc" name="zd_hf_soc" class="chk-col-theme"/>
                        <label for="zd_hf_soc">Seo ve Optimizasyon ayarlarını çalıştır</label>
                    </div>
                    <div class="demo-checkbox">                        
                        <input type="checkbox" id="zd_hf_vdd" name="zd_hf_vdd" class="chk-col-theme"/>
                        <label for="zd_hf_vdd">Veritabanını denetle / düzelt</label>
                    </div>
                    <div class="demo-checkbox">                        
                        <input type="checkbox" id="zd_hf_sya" name="zd_hf_sya" class="chk-col-theme"/>
                        <label for="zd_hf_sya">Sistem yedeğini al</label>
                    </div>
                    <div class="demo-checkbox">                        
                        <input type="checkbox" id="zd_hf_obt" name="zd_hf_obt" class="chk-col-theme"/>
                        <label for="zd_hf_obt">Ön belleği temizle</label>
                    </div>
                    <div class="demo-checkbox">                        
                        <input type="checkbox" id="zd_hf_ckb" name="zd_hf_ckb" class="chk-col-theme"/>
                        <label for="zd_hf_ckb">Çöp kutusunu boşalt (1 haftadan eski olanlar)</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="zg_ay>">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#zg_" href="#zgi_ay" aria-expanded="false" aria-controls="zgi_ay" class="collapsed"><?=mc_dil('aylik_gorevler')?></a>
                <div class="switch">
                    <label><input name="zg_ay" type="checkbox"/><span class="lever switch-col-theme"></span></label>
                </div>
            </h4>
        </div>
        <div id="zgi_ay" class="panel-collapse collapse" role="tabpanel" aria-labelledby="zg_ay" aria-expanded="false" style="height: 0px;">
            <div class="panel-body">
                <p class="m-b-10"><b>Belirlenen ay aralığında çalışacak görevler</b></p>  
                <div class="col-md-12 m-b-20">
                    <div class="demo-checkbox">                        
                        <input type="checkbox" id="zd_ay_agc" name="zd_ay_agc" class="chk-col-theme"/>
                        <label for="zd_ay_agc">Haftalık görevlerde seçilenleri çalıştır</label>
                    </div>
                    <div class="demo-checkbox">                        
                        <input type="checkbox" id="zd_ay_gbc" name="zd_ay_gbc" class="chk-col-theme"/>
                        <label for="zd_ay_gbc">Gizli bakımı çalıştır</label>
                    </div>
                    <div class="demo-checkbox">                        
                        <input type="checkbox" id="zd_ay_ysb" name="zd_ay_ysb" class="chk-col-theme"/>
                        <label for="zd_ay_ysb">Eski yedekleri sil, yeni yedek başlat</label>
                    </div>
                    <div class="demo-checkbox">                        
                        <input type="checkbox" id="zd_ay_pku" name="zd_ay_pku" class="chk-col-theme"/>
                        <label for="zd_ay_pku">En az 25 gün pasif olan kullanıcılara mail gönder</label>
                    </div>
                    <div class="demo-checkbox">                        
                        <input type="checkbox" id="zd_ay_srs" name="zd_ay_srs" class="chk-col-theme"/>
                        <label for="zd_ay_srs">Sistem raporunu sil</label>
                    </div>
                    <div class="demo-checkbox">                        
                        <input type="checkbox" id="zd_ay_ike" name="zd_ay_ike" class="chk-col-theme"/>
                        <label for="zd_ay_ike">İndex açıklarını kontrol et</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

