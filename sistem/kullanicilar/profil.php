<?php
    if(!defined('m_sistem_header')) { define("m_sistem_header", true); }    
    require '../../yonetici/loader.php';
?>
    <div class="row clearfix">
        <div class="col-md-3">
            <div class="card">
                <a href="javascript:void(0);">
                    <img src="<?=m_resim($mc_oturum->resim, 400, 400)?>" class="img-responsive">
                </a>
                <div class="col-md-12 mc_profil_solbilgiler">
                    <span><i class="material-icons">person</i> <span><?=$mc_oturum->kadi?></span></span>
                    <span><i class="material-icons">mood</i> <span><?=$mc_oturum->ad." ".$mc_oturum->soyad?></span></span>
                    <span><i class="material-icons">security</i> <span><?=ucfirst($mc_grup->baslik)?></span></span>
                    <span><i class="material-icons">email</i> <span><?=$mc_oturum->mail?></span></span>
                </div>
                <div class="list-group">
                    <a href="#hakkinda" class="list-group-item tabcontrol waves-effect">Hakkında</a>
                    <a style="display: none;" href="#icerikleri" class="list-group-item tabcontrol waves-effect">İçerikleri <span class="badge bg-red">3</span></a>
                    <a style="display: none;" href="#blogyazilari" class="list-group-item tabcontrol waves-effect">Blog Yazıları <span class="badge bg-red">4</span></a>
                    <a style="display: none;" href="#yorumlari" class="list-group-item tabcontrol waves-effect">Yorumları <span class="badge bg-red">2</span></a>
                    <a style="display: none;" href="#yukledikleri" class="list-group-item tabcontrol waves-effect">Yükledikleri <span class="badge bg-red">13</span></a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card mc_profil_hakkinda">
                <div class="header">
                    <h2>Hakkında</h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="<?=mc_sistem?>kullanicilar/duzenle.php?id=<?=mc_oturum_id?>" class=" waves-effect waves-block">Düzenle</a></li>
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
                        <a href="#profil_izinler" data-toggle="tab" aria-expanded="false"><i class="material-icons">format_align_left</i> İzinler</a>
                    </li>
                </ul>                
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade active in" id="profil_genel">
                        <div class="clearfix">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <p><b>Kullanıcı Adı : </b> <?=$mc_oturum->kadi?></p>
                                <p><b>Adı Soyadı: </b> <?=$mc_oturum->ad." ".$mc_oturum->soyad?></p>
                                <p><b>Cinsiyet : </b> </p>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="profil_iletisim">
                        <div class="clearfix">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <p><b>Mail Adresi : </b> <a href="mailto:<?=$mc_oturum->mail?>"><?=$mc_oturum->mail?></a></p>
                                <p><b>Telefon Numarası: </b> <?= m_jsonAl($mc_oturum->eklenti, "tel") ?></p>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <p><b>Adres : </b> <?= m_jsonAl($mc_oturum->eklenti, "adres") ?></p>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="profil_izinler">
                        <?php
                        echo '<div class="clearfix">';
                        if($mc_oturum->grup < 3){
                            foreach($moduller as $modul) {
                                $modul = str_replace('-', '_', $modul);                          
                                echo '<div class="col-md-12 m-b-5"><b>'.mc_dil($modul).' : </b>'.mc_dil('goruntule').', '.mc_dil('ekle').', '.mc_dil('duzenle').', '.mc_dil('sil').'</div>';
                            }
                        }else{
                            foreach($moduller as $modul) {
                                $modul = str_replace('-', '_', $modul);
                                $modul_i = mc_izin_hazirla(m_jsonAl(m_jsonAl($mc_oturum->izinler,'moduler'),$modul));                            
                                $modul_g = mc_izin_hazirla(m_jsonAl($mc_grup->yetki,$modul));                            
                                echo '<div class="col-md-12 m-b-5"><b>'.mc_dil($modul).' : </b>';
                                $izin_dizi = array();
                                if($modul_i[0] == 1 || $modul_g[0] == 1){ $izin_dizi[] = mc_dil('goruntule'); }
                                if($modul_i[1] == 1 || $modul_g[1] == 1){ $izin_dizi[] = mc_dil('ekle'); }
                                if($modul_i[2] == 1 || $modul_g[2] == 1){ $izin_dizi[] = mc_dil('duzenle'); }
                                if($modul_i[3] == 1 || $modul_g[3] == 1){ $izin_dizi[] = mc_dil('sil'); }
                                echo implode(", ", $izin_dizi).'</div>';
                            }
                        }
                        echo '</div>'; 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require mc_sablon.'footer.php';