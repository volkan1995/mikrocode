<?php
    if(!defined('m_sistem_header')) { define("m_sistem_header", true); }    
    require '../../yonetici/loader.php';
    $mc_gruplar = $m_vt->select()->from("gruplar")->where('panel',1)->where('id',$mc_oturum->grup,">=")->result();   
?>  
<form class="row clearfix" id="content-form">
    <div class="col-md-9 col-sm-8 col-xs-12">
        <div class="card">
            <div class="header">
                <h2><?=mc_ustmenu("genel",$mc_headtitle, true)?></h2>
            </div>
            <div class="body">                
                <div class="row clearfix">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control" name="username" placeholder="Kullanıcı Adı" minlength="3" required=""/>
                            </div>
                            <small class="col-grey">Sadece &nbsp; <b>_</b> &nbsp; özel karakteri kullanılabilir</small>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="email" class="form-control" name="email" placeholder="E-posta adresi" required=""/>
                            </div>
                        </div> 
                    </div> 
                </div>
                
                <div class="row clearfix"> 
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control" name="name" placeholder="Adı" value="" minlength="2" required=""/>
                            </div>
                        </div>  
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control" name="surname" placeholder="Soyadı" value="" minlength="2" required=""/>
                            </div>
                        </div>  
                    </div>
                </div>
                
                <div class="row clearfix">   
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="password" class="form-control" name="password" placeholder="Şifreyi giriniz" minlength="5" required=""/>
                            </div>
                            <small class="col-grey">En az 6 karakter, özel karakter ve rakam içermeli</small>
                        </div> 
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="password" class="form-control" name="repassword" confirm = "password" placeholder="Şifreyi tekrar giriniz" minlength="5" required=""/>
                            </div>
                            <small class="col-grey">Güvenlik için şifreyi tekrar giriniz</small>
                        </div> 
                    </div>
                </div>   
                
                
                <div class="row clearfix"> 
                    <div class="col-md-6 col-sm-6 col-xs-12">
                       <select name="sex" required="" class="form-control show-tick">
                            <option value="0">Belirtmek İstemiyor</option>
                            <option value="1">Kadın</option>
                            <option value="2">Erkek</option>
                        </select>
                        <small class="col-grey">Cinsiyet seçiniz</small>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select name="grup" required="" class="form-control show-tick">
                            <?php foreach ($mc_gruplar as $grup) { echo "<option value='".$grup->id."'>".mc_dil($grup->baslik)."</option>"; } ?>
                        </select>
                        <small class="col-grey">Yetki grubunu seçiniz</small>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-4 col-xs-12">
        <div class="card">
            <div class="body">
                <button type="submit" class="btn btn-sm btn-theme waves-effect"><?=mc_dil('kaydet')?></button>
                <div class="switch m-t-20">
                    <b>Durum</b>
                    <label><input name="yayin" type="checkbox" checked/><span class="lever switch-col-theme"></span></label>
                </div>  
                <div class='m-t-20'>
                    <?=mc_dosya("gorsel", 0, "profil", ['baslik' => "Profil Resmi", 'style' => "width:100%;"])?>
                </div>
            </div>
        </div>
    </div>
</form>
<script>

</script>
<?php require_once mc_sablon.'footer.php';