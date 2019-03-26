<?php
    if(!defined('m_sistem_header')) { define("m_sistem_header", true); }
    require '../../yonetici/loader.php';  
?>
<style>
    .mc_profil_solbilgiler{border-left:1px solid #ddd;border-right:1px solid #ddd;padding-top:10px;padding-bottom:10px}
    .mc_profil_solbilgiler > span{float:left;width:100%;margin:3px 0}
    .mc_profil_solbilgiler > span > i{float:left;font-size:18px;line-height:24px;margin-right:10px}
    .mc_profil_solbilgiler > span > span{float:left;line-height:24px}
    .mc_profil_hakkinda_li{width:25%;text-align:center}
    .mc_profil_hakkinda .tab-content{padding:7px}
    .mc_profil_hakkinda .tab-content > .tab-pane {overflow-y: inherit; padding-bottom: 10px; padding-top: 10px;}
    .demo-checkbox label, .demo-radio-button label { min-width: 90px; width: 24%;}
</style>
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card mc_profil_hakkinda">
                <div class="header">
                    <h2><?=$get_kullanici->kadi?> bilgileri düzenleniyor</h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);" class=" waves-effect waves-block">Şikayet Et</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>                
                <ul class="nav nav-tabs p-l-5 p-r-5" role="tablist">
                    <li role="presentation" class="mc_profil_hakkinda_li active">
                        <a href="#profil_genel" data-toggle="tab" aria-expanded="true"><i class="material-icons">person</i> Genel Bilgiler</a>
                    </li>
                    <li role="presentation" class="mc_profil_hakkinda_li">
                        <a href="#profil_iletisim" data-toggle="tab" aria-expanded="false"><i class="material-icons">phone</i> İletişim</a>
                    </li>
                    <li role="presentation" class="mc_profil_hakkinda_li">
                        <a href="#profil_izinler" data-toggle="tab" aria-expanded="false"><i class="material-icons">security</i> İzinler</a>
                    </li>
                    <li role="presentation" class="mc_profil_hakkinda_li">
                        <a href="#profil_guvenlik" data-toggle="tab" aria-expanded="false"><i class="material-icons">vpn_key</i> Güvenlik</a>
                    </li>
                </ul>                
                <div class="tab-content">
                    <form class="tab-pane fade oto-form active in" id="profil_genel">
                        <div class="row clearfix">
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="name" placeholder="Adı" value="<?=$get_kullanici->ad?>" minlength="2" required=""/>
                                        </div>
                                    </div>  
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="surname" placeholder="Soyadı" value="<?=$get_kullanici->soyad?>" minlength="2" required=""/>
                                        </div>
                                    </div>  
                                </div>  
                            </div>
                            <div class="col-md-3 col-sm-4 col-xs-12">
                                <?=mc_dosya("gorsel", $get_kullanici->resim, "profil", ['baslik' => "Profil Resmi", 'style' => "width:100%;"])?>
                                <select name="sex" required="" class="form-control show-tick">
                                     <option value="0">Belirtmek İstemiyor</option>
                                     <option value="1">Kadın</option>
                                     <option value="2">Erkek</option>
                                 </select>
                                 <small class="col-grey">Cinsiyet seçiniz</small>
                            </div>
                        </div>
                        <div class="clearfix">
                            <div class="col-md-12 m-t-10">
                                <input type="hidden" name="id" value="<?= $get_kullanici->id ?>"/>
                                <input type="hidden" name="kayit_tip" value="genel"/>
                                <button type="submit" class="btn btn-theme waves-effect" notext="true"><?=mc_dil('kaydet')?></button>
                            </div>
                        </div>
                    </form>
                    <form class="tab-pane fade oto-form" id="profil_iletisim">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="email" class="form-control" name="email" placeholder="E-posta adresi" value="<?= $get_kullanici->mail ?>" required=""/>
                                </div>
                            </div> 
                        </div> 
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="tel" placeholder="Telefon" value="<?= m_jsonAl($get_kullanici->eklenti, "tel") ?>" minlength="3"/>
                                </div>
                            </div>  
                        </div>                  
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea class="form-control" name="adres" placeholder="Adres"><?= m_jsonAl($get_kullanici->eklenti, "adres") ?></textarea>
                                </div>
                            </div>  
                        </div> 
                        <div class="clearfix">
                            <div class="col-md-12 m-t-10">
                                <input type="hidden" name="id" value="<?= $get_kullanici->id ?>"/>
                                <input type="hidden" name="kayit_tip" value="iletisim"/>
                                <button type="submit" class="btn btn-theme waves-effect" notext="true"><?=mc_dil('kaydet')?></button>
                            </div>
                        </div>
                    </form>
                    <?php if(mc_oturum_id != $get_kullanici->id && $mc_oturum->grup < 3){ ?>
                    <form class="tab-pane fade oto-form" id="profil_izinler">
                        <?php foreach($moduller as $modul) {
                            $modul = str_replace('-', '_', $modul);
                            $modul_i = mc_izin_hazirla(m_jsonAl(m_jsonAl($get_kullanici->izinler,'moduler'),$modul));
                            ?>
                        <div class="col-sm-6 m-b-20">
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
                        <div class="clearfix">
                            <div class="col-md-12 m-t-10">
                                <input type="hidden" name="id" value="<?= $get_kullanici->id ?>"/>
                                <input type="hidden" name="kayit_tip" value="izinler"/>
                                <button type="submit" class="btn btn-theme waves-effect" notext="true"><?=mc_dil('kaydet')?></button>
                            </div>
                        </div>
                    </form>
                    <?php }else{
                        echo '<div class="tab-pane fade" id="profil_izinler"><div class="clearfix">';
                        if($get_kullanici->grup < 3){
                            foreach($moduller as $modul) {
                                $modul = str_replace('-', '_', $modul);                          
                                echo '<div class="col-md-6 m-b-10"><b>'.mc_dil($modul).' : </b>'.mc_dil('goruntule').', '.mc_dil('ekle').', '.mc_dil('duzenle').', '.mc_dil('sil').'</div>';
                            }
                        }else{
                            foreach($moduller as $modul) {
                                $modul = str_replace('-', '_', $modul);
                                $modul_i = mc_izin_hazirla(m_jsonAl(m_jsonAl($get_kullanici->izinler,'moduler'),$modul));                            
                                $modul_g = mc_izin_hazirla(m_jsonAl($mc_grup->yetki,$modul));                            
                                echo '<div class="col-md-6 m-b-10"><b>'.mc_dil($modul).' : </b>';
                                $izin_dizi = array();
                                if($modul_i[0] == 1 || $modul_g[0] == 1){ $izin_dizi[] = mc_dil('goruntule'); }
                                if($modul_i[1] == 1 || $modul_g[1] == 1){ $izin_dizi[] = mc_dil('ekle'); }
                                if($modul_i[2] == 1 || $modul_g[2] == 1){ $izin_dizi[] = mc_dil('duzenle'); }
                                if($modul_i[3] == 1 || $modul_g[3] == 1){ $izin_dizi[] = mc_dil('sil'); }
                                echo implode(", ", $izin_dizi).'</div>';
                            }
                        }
                        echo '</div></div>';     
                    } ?>
                    <form class="tab-pane fade oto-form" id="profil_guvenlik">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <b>Yeni Şifre</b>
                                    <input type="password" class="form-control" name="password" placeholder="Şifreyi Giriniz" minlength="3"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <b>Yeni Şifreyi tekrarlayınız</b>
                                    <input type="password" class="form-control" name="repassword" confirm = "password" placeholder="Şifreyi Tekrar Giriniz" minlength="3"/>
                                </div>
                            </div>
                        </div> 
                        <div class="clearfix">
                            <div class="col-md-12 m-t-10">
                                <input type="hidden" name="id" value="<?= $get_kullanici->id ?>"/>
                                <input type="hidden" name="kayit_tip" value="guvenlik"/>
                                <button type="submit" class="btn btn-theme waves-effect" notext="true"><?=mc_dil('kaydet')?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php require_once mc_sablon.'footer.php';