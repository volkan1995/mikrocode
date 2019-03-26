<?php
    if(!defined('m_sistem_header')) { define("m_sistem_header", true); }    
    require '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'yonetici' . DIRECTORY_SEPARATOR . 'loader.php';
?>
<div class="row clearfix">    
    <div class="col-md-7 col-sm-6 col-xs-12">
        <div class="card">
            <div class="header">
                <h2><?=mc_ustmenu("ayarlar",$mc_headtitle, true)?></h2>
            </div>
            <div class="body">
                <form action="<?=mc_sistem?>dosyalar/islevler.php" id="mcdosyayukle" class="dropzone" method="post" enctype="multipart/form-data">
                    <div class="dz-message">
                        <div class="drag-icon-cph">
                            <i class="material-icons">touch_app</i>
                        </div>
                        <h3>Arşivi(.zip) sürükleyin veya dokunun</h3>
                        <em>(Arşiv anında <strong>yüklenmeye</strong> başlayacaktır)</em>
                    </div>
                    <div class="fallback">
                        <input name="file" type="file" multiple />
                    </div>
                </form>
            </div>
        </div>
    </div>    
    <form class="col-md-5 col-sm-6 col-xs-12" id="content-form">
        <div class="card">
            <div class="body">
                <button type="submit" class="btn btn-sm btn-theme waves-effect"><?=mc_dil('kaydet')?></button>
                <div class="switch m-t-20"> 
                    <table class="table">
                        <tr>
                            <td><b>Aktifleştir</b></td>
                            <td><label><input name="yayin" type="checkbox" checked/><span class="lever switch-col-theme"></span></label></td>
                        </tr>
                        <tr>
                            <td><b>Yapılandır</b></td>
                            <td><label><input name="yapilandir" type="checkbox" checked/><span class="lever switch-col-theme"></span></label></td>
                        </tr>
                        <tr>
                            <td><b>Kurulum dosyasını sil</b></td>
                            <td><label><input name="kurulumsil" type="checkbox" checked/><span class="lever switch-col-theme"></span></label></td>
                        </tr>
                    </table>
                </div>
                <div class="p-l-10 p-r-10" id="post_sonuc_r"><small>Lütfen .zip formatında tema dosyası yükleyiniz</small></div>
            </div>
        </div>
    </form>
 </div>
<?php require_once mc_sablon.'footer.php'; ?>
<script>
    mc_loadCss("<?=mc_plugins?>dropzone/dropzone.min.css");    
    mc_loadJs("<?=mc_plugins?>dropzone/dropzone.min.js").done(function() {
        Dropzone.options.mcdosyayukle = {
            paramName: "dosya",
            maxFilesize: 64,
            parallelUploads: 1,
            uploadMultiple: false,
            acceptedFiles: "application/zip, .zip",
            dictDefaultMessage: "Drop files here to upload",
            dictFallbackMessage: "Your browser does not support drag'n'drop file uploads.",
            dictFallbackText: "Please use the fallback form below to upload your files like in the olden days.",
            dictFileTooBig: "Dosya ({{filesize}} MB) yüklenme sınırını aşıyor. Sınır: {{maxFilesize}} MB.",
            dictInvalidFileType: "Geçersiz dosya tipi",
            dictResponseError: "Server responded with {{statusCode}} code.",
            dictCancelUpload: "Yüklemeyi iptal et",
            dictCancelUploadConfirmation: "Yüklemeyi iptal etmek istediğinize emin misiniz?",
            dictRemoveFile: "Remove file",
            dictRemoveFileConfirmation: null,
            dictMaxFilesExceeded: "You can not upload any more files.",
            params:{idyaz:'onay'},
            ozel: function(data){ $('#post_sonuc_r').html(data); }
        };
        Dropzone._autoDiscoverFunction();
    });
</script>