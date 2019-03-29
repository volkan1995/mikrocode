<?php
if(!defined('m_guvenlik')) { exit; }
if(isset($_POST['aktar'])){
    echo '<input type="hidden" id ="mcd_aktar_id" value="'.$_POST['aktar'].'"/>';
}
$mcd_coklu = 0;
if(isset($_POST['coklu']) && $_POST['coklu'] == 1){
    $mcd_coklu = 1;
    if(isset($_POST['detay']) && $_POST['detay'] == 1){ $mcd_detay = 1; }else{ $mcd_detay = 0; }
    echo '<input type="hidden" id="mcd_detay_d" value="'.$mcd_detay.'"/>';
}
?>   
<input type="hidden" id ="mcd_coklu_o" value="<?=$mcd_coklu?>"/>
</div>
<div class="modal-footer">
    <?php if($mcd_coklu == 1){ echo '<button type="button" class="btn btn-link waves-effect" id="mcd_coklusec_btn">Seçimi Tamamla</button>'; } ?>
    <button type="button" class="btn btn-link waves-effect" id="mc_dosyayukle_btn">Dosya Yükle</button>
    <button type="button" class="btn btn-link waves-effect" onclick="return mc_dosyakapat();">Kapat</button>
</div>
<script>
    mc_loadCss("<?=mc_js?>pages/files/popup.css?v=14");
    mc_loadJs("<?=mc_js?>pages/files/popup.js?v=20");
</script>