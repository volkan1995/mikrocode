<?php
    if(!defined('m_guvenlik')) { exit; }
    $iletisimCount = m_jsonAl($m_ayarlar->ayar,"mcis",1);
    $haritaCount = m_jsonAl($m_ayarlar->ayar,"mchs",1);
?>
<div class="panel-group" id="mc_iletisimayarlar" role="tablist" aria-multiselectable="true">
    <?php for ($i = 1; $i <= $iletisimCount; $i++){ if($i > 1){ $ek_yaz = "_$i"; }else{  $ek_yaz = null; } ?>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="ia_tab1<?=$ek_yaz?>">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#mc_iletisimayarlar" href="#iaa_tab1<?=$ek_yaz?>" aria-expanded="false" aria-controls="iaa_tab1<?=$ek_yaz?>" class="collapsed">İletişim Bilgileri<?=$i>0&&$iletisimCount>1?" $i":null?></a>
            </h4>
        </div>
        <div id="iaa_tab1<?=$ek_yaz?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ia_tab1<?=$ek_yaz?>" aria-expanded="false">
            <div class="panel-body">                
                <div class="col-md-3 setting_left"><b>Telefon 1</b></div>
                <div class="col-md-9 setting_right">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" placeholder="+0 000 000 0000" name="telefon1<?=$ek_yaz?>" value="<?=m_jsonAl($m_ayarlar->iletisim, 'telefon1'.$ek_yaz)?>"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 setting_left"><b>Telefon 2</b></div>
                <div class="col-md-9 setting_right">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" placeholder="+0 000 000 0000" name="telefon2<?=$ek_yaz?>" value="<?=m_jsonAl($m_ayarlar->iletisim, 'telefon2'.$ek_yaz)?>"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 setting_left"><b>Telefon 3</b></div>
                <div class="col-md-9 setting_right">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" placeholder="+0 000 000 0000" name="telefon3<?=$ek_yaz?>" value="<?=m_jsonAl($m_ayarlar->iletisim, 'telefon3'.$ek_yaz)?>"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 setting_left"><b>FAX</b></div>
                <div class="col-md-9 setting_right">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" placeholder="+0 000 000 0000" name="fax<?=$ek_yaz?>" value="<?=m_jsonAl($m_ayarlar->iletisim, 'fax'.$ek_yaz)?>"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 setting_left"><b>E-posta Adresi</b></div>
                <div class="col-md-9 setting_right">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" placeholder="iletisim@<?=m_host?>" name="email<?=$ek_yaz?>" value="<?=m_jsonAl($m_ayarlar->iletisim, 'email'.$ek_yaz)?>"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 setting_left"><b>Açık Adres</b></div>
                <div class="col-md-9 setting_right">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" placeholder="Mahalle, Cadde, Sokak, No" name="adres<?=$ek_yaz?>" value="<?=m_jsonAl($m_ayarlar->iletisim, 'adres'.$ek_yaz)?>"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 setting_left"><b>İlçe / İl</b></div>
                <div class="col-md-9 setting_right">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" placeholder="Kadıköy / İstanbul" name="bolge<?=$ek_yaz?>" value="<?=m_jsonAl($m_ayarlar->iletisim, 'bolge'.$ek_yaz)?>"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } for ($i = 1; $i <= $haritaCount; $i++){ if($i > 1){ $ek_yaz = "_$i"; }else{ $ek_yaz = null; } ?>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="ia_tab3<?=$ek_yaz?>">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#mc_iletisimayarlar" href="#iaa_tab3<?=$ek_yaz?>" aria-expanded="false" aria-controls="iaa_tab3<?=$ek_yaz?>" class="collapsed">Harita Bilgileri<?=$i>0&&$haritaCount>1?" $i":null?></a>
            </h4>
        </div>
        <div id="iaa_tab3<?=$ek_yaz?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ia_tab3<?=$ek_yaz?>" aria-expanded="false">
            <div class="panel-body">                
                <div class="col-md-3 setting_left"><b>Enlem</b></div>
                <div class="col-md-9 setting_right">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="lat<?=$ek_yaz?>" value="<?=m_jsonAl($m_ayarlar->iletisim, 'lat'.$ek_yaz)?>"/>
                            <label class="form-label">Lat, Latiude, Y Ekseni veya Yatay Eksen</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 setting_left"><b>Boylam</b></div>
                <div class="col-md-9 setting_right">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="lng<?=$ek_yaz?>" value="<?=m_jsonAl($m_ayarlar->iletisim, 'lng'.$ek_yaz)?>"/>
                            <label class="form-label">Lng, Longitude, X Ekseni veya Dikey Eksen</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 setting_left"><b>Yakınlık <font class="col-theme m-l-10"><span id="mapszoom"><?=m_jsonAl($m_ayarlar->iletisim, 'zoom'.$ek_yaz)?></span>x</font></b></div>
                <div class="col-md-9 setting_right">
                    <div class="form-group">
                        <input type="range" min="1" max="21" value="<?=m_jsonAl($m_ayarlar->iletisim, 'zoom')?>" class="mc_range_s" name="zoom<?=$ek_yaz?>" id="mc_zoomr"/>
                    </div>
                </div>
                <h4 class="col-md-12 text-center m-t-10 m-b-15">Veya</h4>
                <div class="col-md-3 setting_left"><b>Iframe Adresi</b></div>
                <div class="col-md-9 setting_right">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="map<?=$ek_yaz?>" value="<?=m_jsonAl($m_ayarlar->iletisim, 'map'.$ek_yaz)?>"/>
                            <label class="form-label">Harita için yerleştirme adresi</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>     
    <?php } ?>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="ia_tab2">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#mc_iletisimayarlar" href="#iaa_tab2" aria-expanded="false" aria-controls="iaa_tab2" class="collapsed">Sosyal Medya Bilgileri</a>
            </h4>
        </div>
        <div id="iaa_tab2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ia_tab2" aria-expanded="false">
            <div class="panel-body">                
                <div class="col-md-3 setting_left"><b>Facebook</b></div>
                <div class="col-md-9 setting_right">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="facebook" value="<?=m_jsonAl($m_ayarlar->iletisim, 'facebook')?>"/>
                            <label class="form-label">Facebook Kullanıcı Adı</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 setting_left"><b>Instagram</b></div>
                <div class="col-md-9 setting_right">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="instagram" value="<?=m_jsonAl($m_ayarlar->iletisim, 'instagram')?>"/>
                            <label class="form-label">Instagram Kullanıcı Adı</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 setting_left"><b>Twitter</b></div>
                <div class="col-md-9 setting_right">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="twitter" value="<?=m_jsonAl($m_ayarlar->iletisim, 'twitter')?>"/>
                            <label class="form-label">Twitter Kullanıcı Adı</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 setting_left"><b>Linkedin</b></div>
                <div class="col-md-9 setting_right">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="linkedin" value="<?=m_jsonAl($m_ayarlar->iletisim, 'linkedin')?>"/>
                            <label class="form-label">Linkedin Kullanıcı Adı</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 setting_left"><b>Google+</b></div>
                <div class="col-md-9 setting_right">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="googleplus" value="<?=m_jsonAl($m_ayarlar->iletisim, 'googleplus')?>"/>
                            <label class="form-label">Google+ Kullanıcı Adı</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 setting_left"><b>Youtube</b></div>
                <div class="col-md-9 setting_right">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="youtube" value="<?=m_jsonAl($m_ayarlar->iletisim, 'youtube')?>"/>
                            <label class="form-label">Youtube Kullanıcı Adı</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 setting_left"><b>Pinterest</b></div>
                <div class="col-md-9 setting_right">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="pinterest" value="<?=m_jsonAl($m_ayarlar->iletisim, 'pinterest')?>"/>
                            <label class="form-label">Pinterest Kullanıcı Adı</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 setting_left"><b>Skype</b></div>
                <div class="col-md-9 setting_right">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="skype" value="<?=m_jsonAl($m_ayarlar->iletisim, 'skype')?>"/>
                            <label class="form-label">Skype Kullanıcı Adı</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 setting_left"><b>Whatsapp</b></div>
                <div class="col-md-9 setting_right">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="whatsapp" value="whatsapp"/>
                            <label class="form-label">Whatsapp Telefon Numarası</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>document.getElementById("mc_zoomr").oninput = function() { $('#mapszoom').text(this.value); };</script>

