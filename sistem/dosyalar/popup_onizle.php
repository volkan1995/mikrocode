<?php 
    if(!defined('m_guvenlik')) { exit; }    
    if(!isset($_POST['id']) || empty($_POST['id'])){ exit; }

    $dosya_id = intval($_POST['id']);
    
    $dosya_bul = $m_vt->select()
        ->from("dosyalar")
        ->where('tip', $_POST['tip'])
        ->where('id', $dosya_id)
        ->result();
    
    if(!count($dosya_bul)){
        echo "<b>Bir sorun oluştu</b>";
        exit;
    }
    
    $dosya_bul = $dosya_bul[0];
    
?>
<script>
    var mcdp_co = $("#mcd_coklu_o").val();
    var mcdp_mcds = "#mcds_" + $("#mcd_aktar_id").val();
    mcdp_tf = true;
    $(mcdp_mcds + " .mcd_values").each(function(i){
        if($(this).val() == $('.mcd_sid').val()){
            $("#mcd_sec_btn").text("Kaldır");
            mcdp_tf = false;
        }
    });
</script>
<form id="mc_dosya_form" onsubmit="mc_dosyaform(); return false;" method="post">
    <i class="material-icons mc_dosyasil_i col-red">delete</i>
    <b class="mc_dosyabaslik_b"><?=$dosya_bul->baslik?></b>
    <?php if($dosya_bul->tip == 1){ ?>
        <div class="thumbnail m-t-10">
            <img src="<?=m_resim($dosya_bul->konum,220,150,2)?>" class="img-responsive">
        </div>
    <?php }elseif($dosya_bul->tip == 2){ ?>
        <video controls preload="metadata" poster="" class="m-t-10" style="width:100%;">
            <source src="<?=m_domain."/dosyalar".$dosya_bul->konum?>" type="video/mp4">Tarayıcı desteği yok
        </video>
    <?php }elseif($dosya_bul->tip == 3){ ?>
        <audio preload="metadata" src="<?=m_domain."/dosyalar".$dosya_bul->konum?>">Desteklenmiyor</audio>
    <?php } ?>
    <div class="form-group">
        <div class="form-line m-t-10">
            <input type="text" class="form-control" name="dosya_isim" id="dosya_isim" placeholder="Dosya ismi" value="<?=  mc_dosya_ismi($dosya_bul->baslik)?>" required=""/>
        </div>
        <button type="submit" id="mcd_sec_btn" class="btn btn-theme waves-effect m-t-15">Seç</button>
    </div>
    <input type="hidden" name="id" class="mcd_sid" value="<?=$dosya_bul->id?>"/>
</form>