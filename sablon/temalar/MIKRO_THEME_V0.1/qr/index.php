<section class="banner-area relative back-img" id="home" style="background-image: url('<?=$cover_img?>')">	
    <div class="overlay overlay-bg"></div>
    <div class="container">				
        <div class="row d-flex align-items-center justify-content-center">
            <div class="about-content col-lg-12">
                <h1 class="text-white"><?= mt_dil('qr_tara') ?></h1>	
                <p class="text-white link-nav"><a href="/"><?= mt_dil('anasayfa') ?> </a>  <span class="lnr lnr-arrow-right"></span>  <a href="#"> <?= mt_dil('qr_tara') ?></a></p>
            </div>	
        </div>
    </div>
</section>
<style>
    @-moz-keyframes mc_fade { 10%  {opacity: 1;} 30%  {opacity: .4;} 80%  {opacity: .4;} }
    @-webkit-keyframes mc_fade { 10%  {opacity: 1;} 30%  {opacity: .4;} 80%  {opacity: .4;} }
    @keyframes mc_fade { 10%  {opacity: 1;} 30%  {opacity: .4;} 80%  {opacity: .4;} }
    .kamera_body{  }
    .kamera_canvas{
        background-image: url('img/loader.gif');
        background-repeat: no-repeat; background-size: auto; background-position: center center;
        width: 100%;
        position: relative;
    }
    .kamera_canvas_our{
        position: relative;
    }
    .kamera_canvas_after{
        display:none;
        position: absolute;
        top: 50%;
        left:50%;
        transform: translate(-50%,-50%);
        border: 2px dashed #f9e02f;
        height:40%;
        width:60%;
        z-index: 1;
         -webkit-animation: mc_fade 1.5s linear infinite;
        -moz-animation: mc_fade 1.5s linear infinite;
        animation: mc_fade 1.5s linear infinite;
    }
    .qr-image{ max-width: 300px; }
    .qr-sonokunma{ display:none; }
</style>
<section class="about-video-area section-gap">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 kamera_body text-center mb-5">
                <h2><?= mt_dil('kamera_ile_tarayin') ?></h2>
                <div class="form-group mt-4" style="display:none">
                    <select id="inversion-mode-select" class="form-control">
                        <option value="original">Orjinali tara (parlak arka planda koyu QR kodu)</option>
                        <option value="invert">Ters renklerle tarayın (koyu arka plan üzerinde parlak QR kodu)</option>
                        <option value="both" selected>İkisini de tara</option>
                    </select>
                </div>
                <div class="kamera_canvas_our mt-4 mb-5">
                <span class="kamera_canvas_after"></span>
                <video muted playsinline id="qr-video" class="kamera_canvas"></video>
                </div>
            </div>
            <div class="qrfile_body col-sm-6 text-center mb-5">
                <h2><?= mt_dil('cihazinizdan_secin') ?></h2>
                <div class="form-group mt-4">
                    <input type="file" id="file-selector" class="form-control" accept="image/*" onchange="loadFile(event)"/>
                </div>
                <img id="imgqrprew" class="qr-image"/>
            </div>
            <div class="col-sm-12 text-center">
                <p><b><?= mt_dil('son_okunan_veri') ?>: </b><span id="qr-result"></span></p>
                <p class="qr-sonokunma"><b>Son okunma: </b><span id="cam-qr-result-timestamp"></span></p>
            </div>
        </div>
    </div>	
</section>	

<script>
    if (location.protocol != 'https:'){
        location.href = 'https:' + window.location.href.substring(window.location.protocol.length);
    }
    var loadFile = function (event) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.getElementById('imgqrprew');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    };
    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };
</script>
<script type="module">
    import QrScanner from "<?= mt_tema . "qr/" ?>qr-scanner.min.js";
    QrScanner.WORKER_PATH = '<?= mt_tema . "qr/" ?>qr-scanner-worker.min.js';

    const video = document.getElementById('qr-video');
    const QrResult = document.getElementById('qr-result');
    const camQrResultTimestamp = document.getElementById('cam-qr-result-timestamp');
    const fileSelector = document.getElementById('file-selector');

    function isURL(str) {
        var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.?)+[a-z]{2,}|'+ // domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
        '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
        '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
        return pattern.test(str);
    }

    function setResult(label, result) {
        label.textContent = result;
        camQrResultTimestamp.textContent = new Date().toString();
        label.style.color = 'teal';
        clearTimeout(label.highlightTimeout);
        label.highlightTimeout = setTimeout(() => label.style.color = 'inherit', 100);
        if(isURL(result) == true){
            var js_url = document.createElement('a');
            js_url.href = result;
            if(js_url.hostname == window.location.hostname || "www." + js_url.hostname == window.location.hostname || js_url.hostname ==  "www." + window.location.hostname){
                window.open(result, '_self');
            }
        }
    }
    
    function hazirla(durum){
        if(durum && isMobile.any()) {
            $('.kamera_canvas').height("80vh");
            $('.kamera_canvas_after').delay(2000).fadeIn(100);
            var sp_offset = $('.kamera_canvas_our').offset();
            $("html, body").animate({ scrollTop: (sp_offset.top - 70) }, "slow");  
        }
        return durum;
    }

    QrScanner.hasCamera().then(
        hasCamera => hazirla(hasCamera)
    );
    
    const scanner = new QrScanner(video, result => setResult(QrResult, result));
    scanner.start();

    document.getElementById('inversion-mode-select').addEventListener('change', event => {
    scanner.setInversionMode(event.target.value);
    });

    fileSelector.addEventListener('change', event => {
    const file = fileSelector.files[0];
    if (!file) {
    return;
    }
    QrScanner.scanImage(file)
    .then(result => setResult(QrResult, result))
    .catch(e => setResult(QrResult, e || '<?= mt_dil('qr_kodu_hatali') ?>.'));
    });
</script>

