<?php
    if(!defined('m_guvenlik')) { exit; }    
    if(isset($_POST['id'])){ $klasor_id = intval($_POST['id']); }else{ $klasor_id = 0; }    
    $klasor_bul = $m_vt->select()
        ->from("klasorler")
        ->where('id', $klasor_id)
        ->result();    
    if(!count($klasor_bul)){
        echo "<b>Bir sorun oluştu</b>";
        exit;
    }    
    $klasor_bul = $klasor_bul[0];
    
?>
<b>Klasör detayları</b>
<div class="form-group">
    <div class="form-line m-t-10">
        <input type="text" class="form-control" name="klasor_isim" id="klasor_isim" placeholder="Yeni Klasör" value="<?=$klasor_bul->baslik?>" required=""/>
    </div>
</div>
<input type="hidden" name="tip" value="<?=$klasor_bul->tip?>"/>
<button type="submit" class="btn btn-default waves-effect m-t-10">Yeniden Adlandır</button>
<button type="button" class="btn btn-danger waves-effect m-t-10">Sil</button>