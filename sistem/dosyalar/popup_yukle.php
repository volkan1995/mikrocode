<?php
    if(!defined('m_guvenlik')) { exit; }
    if(isset($_POST['klasor'])){ $mc_klasoryukle = intval($_POST['klasor']); }else{ $mc_klasoryukle = 0; }
    if($mc_klasoryukle <= 0 && $mc_oturum->grup > 2 && m_jsonAl($m_ayarlar->ayar,"mcddye") == 1){
        $uyari = "Ana dizine dosya yüklenmesi sistem yöneticisi tarafından engellendi.";
        echo "<h4>{$uyari}</h4>";
        if(m_jsonAl($m_ayarlar->ayar,"mcykoe") == 1){
            echo "<p>Ayrıca <u>yeni klasör</u> oluşturma kullanıcılara yasaklanmıştır.</p><p>Eğer ilgili klasör yok ise sistem yöneticinize bildiriniz.</p>";
        }
        mc_uyari(-3, "<b>".mc_dil('yetkisiz_islem')."</b>".$uyari);
    }
?>    
<form action="<?=mc_sistem?>dosyalar/islevler.php" id="mcdosyayukle" class="dropzone" method="post" enctype="multipart/form-data">
    <div class="dz-message">
        <div class="drag-icon-cph">
            <i class="material-icons">touch_app</i>
        </div>
        <h3>Dosyaları sürükleyin veya dokunun</h3>
        <em>(Dosyalar anında <strong>yüklenmeye</strong> başlayacaktır)</em>
    </div>
    <div class="fallback">
        <input name="file" type="file" multiple />
    </div>
</form>
<script>
    mc_loadCss("<?=mc_plugins?>dropzone/dropzone.min.css");    
    mc_loadJs("<?=mc_plugins?>dropzone/dropzone.min.js").done(function() {
        Dropzone.options.mcdosyayukle = {
            paramName: "dosya",
            maxFilesize: 64,
            parallelUploads: 2,
            uploadMultiple: false,
            dictDefaultMessage: "Drop files here to upload",
            dictFallbackMessage: "Your browser does not support drag'n'drop file uploads.",
            dictFallbackText: "Please use the fallback form below to upload your files like in the olden days.",
            dictFileTooBig: "Dosya ({{filesize}} MB) yüklenme sınırını aşıyor. Sınır: {{maxFilesize}} MB.",
            dictInvalidFileType: "You can't upload files of this type.",
            dictResponseError: "Server responded with {{statusCode}} code.",
            dictCancelUpload: "Yüklemeyi iptal et",
            dictCancelUploadConfirmation: "Yüklemeyi iptal etmek istediğinize emin misiniz?",
            dictRemoveFile: "Remove file",
            dictRemoveFileConfirmation: null,
            dictMaxFilesExceeded: "You can not upload any more files.",
            params:{klasor:'<?=$mc_klasoryukle?>'},
            ozel: function(data){ $('#post_sonuc').append(data); }
        };
        Dropzone._autoDiscoverFunction();
    });
</script>
