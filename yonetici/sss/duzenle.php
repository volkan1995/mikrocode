<?php
    if(!defined('m_panel_header')) { define("m_panel_header", true); }    
    require '..'.DIRECTORY_SEPARATOR.'loader.php';
?>
<form class="row clearfix" id="content-form">
    <div class="col-md-9 col-sm-8 col-xs-12">
        <div class="card">
            <div class="header"><?=mc_ustmenu($mc_modul_ayar['menu'],$mc_headtitle)?></div>
            <div class="body">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="baslik" placeholder="Başlık Giriniz" value="<?=$get_yazi->baslik?>" required/>
                    </div>
                </div>
                <?php if(isset($mc_modul_ayar['tasarim']['aciklama']) && $mc_modul_ayar['tasarim']['aciklama']){ ?>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="aciklama" placeholder="Açıklama Giriniz" value="<?=$get_yazi->aciklama?>"/>
                    </div>
                </div>
                <?php
                }
                if(isset($mc_modul_ayar['tasarim']['kategori']) && $mc_modul_ayar['tasarim']['kategori']){
                    echo '<div class="m-t-30"><select name="kategori" class="form-control show-tick">'.mc_kategoriler(['sec' => $get_yazi->{$mc_modul_ayar['ust']}, 'tip' => $mc_modul_ayar['kategori']]).'</select></div>';
                }
                if(isset($mc_modul_ayar['tasarim']['icerik']) && $mc_modul_ayar['tasarim']['icerik']){
                    echo '<div class="m-t-30">'.mc_editor($get_yazi->icerik).'</div>';
                }
                if(isset($mc_modul_ayar['tasarim']['galeri']) && $mc_modul_ayar['tasarim']['galeri']){
                    echo '<div class="m-t-30">'.mc_dosyalar("gorsel", m_jsonAl($get_yazi->eklenti,'galeri', []), "galeri", ['baslik' => "Galeri Resimleri Seç / Yükle"]).'</div>';
                }
                if(isset($mc_modul_ayar['tasarim']['ek']) && $mc_modul_ayar['tasarim']['ek']){
                    echo '<div class="m-t-30">'.mc_dosyalar("dosya", m_jsonAl($get_yazi->eklenti,'ek', []), "ek", ['baslik' => "Ek Seç / Yükle", 'detaylar' => $m_ekid]).'</div>';
                }
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-4 col-xs-12">
        <div class="card">
            <div class="body">
                <button type="submit" class="btn btn-sm btn-theme waves-effect"><?=mc_dil('kaydet')?></button>                
                <input type="hidden" name="id" value="<?=$get_yazi->id?>" />
                <?php if(isset($mc_modul_ayar['tasarim']['yayin']) && $mc_modul_ayar['tasarim']['yayin']){ ?>
                <div class="switch m-t-20">
                    <b class="mc_sw_b80"><?=mc_dil('yayin')?></b>
                    <label><input name="yayin" type="checkbox"<?=$get_yazi->durum==1?" checked":null?>/><span class="lever switch-col-theme"></span></label>
                </div>
                <?php } if(isset($mc_modul_ayar['tasarim']['vurgula']) && $mc_modul_ayar['tasarim']['vurgula']){ ?>
                <div class="switch m-t-15">
                    <b class="mc_sw_b80"><?=mc_dil('manset')?></b>
                    <label><input name="vurgula" type="checkbox"<?=$get_yazi->vurgula==1?" checked":null?>/><span class="lever switch-col-theme"></span></label>
                </div>
                <?php }
                if(isset($mc_modul_ayar['tasarim']['resim']) && $mc_modul_ayar['tasarim']['resim']){
                    echo '<div class="m-t-10">'.mc_dosya("gorsel", $get_yazi->resim, "kapak").'</div>';
                }
                if(isset($mc_modul_ayar['tasarim']['video']) && $mc_modul_ayar['tasarim']['video']){
                    echo '<div class="m-t-10">'.mc_dosya("video", m_jsonAl($get_yazi->eklenti,'video', 0), "video").'</div>';
                }
                if($mc_oturum->grup < 3 && isset($mc_modul_ayar['tasarim']['izinler']) && $mc_modul_ayar['tasarim']['izinler']){
                    echo '<div class="m-t-30"><b>Özel İzin</b></div><div class="m-t-10"><select id="optgroup" class="ms" multiple="multiple" name="izinler[]">';
                    foreach ($m_vt->select()->from("gruplar")->where('baslik',"kurucu","<>")->result() as $grup) {
                        echo '<optgroup label="'.$grup->baslik.'">';
                        foreach ($m_vt->select("`id`,`izinler`,`grup`,`kadi`")->from("kullanicilar")->where('grup',$grup->id)->result() as $kullanici) {
                            $kullanici->izinler = json_decode($kullanici->izinler, true);
                            if(isset($kullanici->izinler[$mc_modul_ayar['tablo']]) && in_array($get_yazi->id, $kullanici->izinler[$mc_modul_ayar['tablo']])){
                                echo '<option value="'.$kullanici->id.'" selected>'.$kullanici->kadi.'</option>';
                            }else{
                                echo '<option value="'.$kullanici->id.'">'.$kullanici->kadi.'</option>';
                            }
                        } 
                        echo '</optgroup>';
                    }   
                    echo "</select></div>";
                }
                ?>
            </div>
        </div>
    </div>
</form>
<?php require_once mc_sablon.'footer.php'; ?>
<link href="<?=mc_plugins?>multi-select/css/multi-select.css" rel="stylesheet" />
<script>
    mc_hazir(function(){
        mc_loadJs("<?=mc_plugins?>multi-select/js/jquery.multi-select.js").done(function(){
            $('#optgroup').multiSelect({ selectableOptgroup: true,selectableHeader:"Tüm Kullanıcılar", selectionHeader: "İzin Verilenler" });
        });
    });
</script>
