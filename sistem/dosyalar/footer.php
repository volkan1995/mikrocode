<?php
if(!defined('m_guvenlik')) { exit; }
if(isset($_POST['aktar'])){
    echo '<input type="hidden" id ="mcd_aktar_id" value="'.$_POST['aktar'].'"/>';
}
?>   
        </div>
    </div>                
</div>
<script>
    mc_hazir(function(){
        mc_loadCss("<?=mc_js?>pages/files/file.css?v=7");
        mc_loadJs("<?=mc_js?>pages/files/file.js?v=7");
    });
</script>