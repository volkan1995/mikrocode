<?php
if (!defined('m_guvenlik')) {
    exit;
}

foreach ($mc_diller as $key => $value) {
    ?>
    <div class="col-md-6 setting_left">
        <b><?= $value['dil'] ?> / </b><small><?= $value['lc_all'] ?></small>
    </div>
    <div class="col-md-6 setting_right">
        <div class="switch">
            <label>
                <input type="checkbox" name="diller[<?= $key ?>]"<?= isset($m_diller[$key]) ? " checked" : null ?>/>
                <span class="lever switch-col-theme"></span>
            </label>
        </div>
    </div>
    <?php
}
?>