<?php
    if(!defined('m_guvenlik')) { exit; }
?>
<div class="col-md-4 setting_left">
    <b>Sitenin sayfa sınırı</b>
</div>
<div class="col-md-8 setting_right">
    <div class="form-group">
        <div class="form-line">
            <input type="number" class="form-control" name="sinir_site" placeholder="Sayı giriniz" value="<?=$m_site_sinir?>" min="5" max="100"/>
        </div>
    </div>
</div>

<div class="col-md-4 setting_left">
    <b>Panelin sayfa sınırı</b>
</div>
<div class="col-md-8 setting_right">
    <div class="form-group">
        <div class="form-line">
            <input type="number" class="form-control" name="sinir_panel" placeholder="Sayı giriniz" value="<?=$m_panel_sinir?>" min="10" max="200"/>
        </div>
    </div>
</div>