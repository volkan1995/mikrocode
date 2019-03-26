<?php
if (!defined('m_sistem_header')) {
    define("m_sistem_header", true);
}
require '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'yonetici' . DIRECTORY_SEPARATOR . 'loader.php';
$mc_simgeler = [
    'kapak.png', 'kapak.jpg', 'kapak.jpeg',
    'screenshot.png', 'screenshot.jpg', 'screenshot.jpeg'
];
$mc_gelistiriciler = [
    'https://mikrobilisim.net', 'http://mikrobilisim.net', '//mikrobilisim.net',
    'https://mikrocode.net', 'http://mikrocode.net', '//mikrocode.net'
];
echo '<div class="row clearfix">';
if (defined("mt_isim") && !empty(mt_isim) && file_exists(m_temalar . mt_isim)) {
    $mc_simge = mc_img . "varsayilan.png";
    foreach ($mc_simgeler as $simge) {
        if (file_exists(m_temalar . mt_isim . "/$simge")) {
            $mc_simge = m_domain . "/sablon/temalar/" . mt_isim . "/$simge";
            break;
        }
    }
    $mc_bilgiler = ['version' => 0, 'published' => "#", 'website' => "javascript:void(0);", 'sefsite' => "javascript:void(0);"];
    if (file_exists(m_temalar . mt_isim . "/info.xml")) {
        $xml = simplexml_load_file(m_temalar . mt_isim . "/info.xml");
        if (isset($xml->version)) {
            $mc_bilgiler['version'] = $xml->version;
        }
        if (isset($xml->published)) {
            $mc_bilgiler['published'] = $xml->published;
        }
        if (isset($xml->website)) {
            $mc_bilgiler['sefsite'] = $xml->website;
            $mc_bilgiler['website'] = $xml->website . "?ref=" . m_domain;
        }
    }
    ?>
    <div class="col-xs-6 col-sm-4 col-md-3" style="margin-bottom: 15px;text-align: center">
        <div class="thumbnail mc_tema_gorsel" id="mc_tema_<?= m_url_duzelt(mt_isim) ?>">
            <img src="<?= m_resim($mc_simge, 300, 200, 2) ?>" />
            <div class="caption">
                <h3><?= mt_isim ?> <small>V <?= $mc_bilgiler['version'] ?></small></h3>
                <p>
                    <a href="<?= $mc_bilgiler['website'] ?>" target="_blank"><?= $mc_bilgiler['published'] ?>
                        <?php if (in_array(rtrim($mc_bilgiler['sefsite'], "/"), $mc_gelistiriciler)) { ?>
                            <i title="Onaylanmış Yayıncı" style="font-size: 20px;position: absolute;margin-left: 5px;" class="material-icons col-blue">check_circle</i>
                        <?php } ?>
                    </a>
                </p>
                <button data-name="<?= mt_isim ?>" data-type="aktif" class="mct_aktifetbtn btn btn-default waves-effect"><b>Yenile</b></button>
                <div class="btn-group dropup">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Diğer <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="javascript:void(0);" data-name="<?= mt_isim ?>" data-type="kur" class="mct_kurbtn waves-block waves-effect">Yapılandır</a>
                        </li>
                        <?php if ($mc_oturum->grup < 2) { ?>
                            <li>
                                <a class="waves-block waves-effect" href="<?= mc_sistem ?>temalar/duzenle.php">Düzenle</a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="javascript:void(0);" class="waves-block waves-effect col-indigo" onclick="tema_iframe_al('<?= mt_isim ?>');"><?= mc_dil('ekran_alintisi') ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php
}
$mc_temalar = array_diff(scandir(m_temalar), array('..', '.', 'loader.php'));
foreach ($mc_temalar as $tema) {
    if ($tema == mt_isim || !is_dir(m_temalar . $tema)) {
        continue;
    }
    $mc_simge = mc_img . "varsayilan.png";
    foreach ($mc_simgeler as $simge) {
        if (file_exists(m_temalar . $tema . "/$simge")) {
            $mc_simge = m_domain . "/sablon/temalar/$tema/$simge";
            break;
        }
    }
    $mc_bilgiler = ['version' => 0, 'published' => "#", 'website' => "javascript:void(0);", 'sefsite' => "javascript:void(0);"];
    if (file_exists(m_temalar . $tema . "/info.xml")) {
        $xml = simplexml_load_file(m_temalar . $tema . "/info.xml");
        if (isset($xml->version)) {
            $mc_bilgiler['version'] = $xml->version;
        }
        if (isset($xml->published)) {
            $mc_bilgiler['published'] = $xml->published;
        }
        if (isset($xml->website)) {
            $mc_bilgiler['sefsite'] = $xml->website;
            $mc_bilgiler['website'] = $xml->website . "?ref=" . m_domain;
        }
    }
    ?>
    <div class="col-xs-6 col-sm-4 col-md-3" style="margin-bottom: 15px;text-align: center" id="mct_id_<?= $tema ?>">
        <div class="thumbnail mc_tema_gorsel" id="mc_tema_<?= m_url_duzelt($tema) ?>">
            <img src="<?= m_resim($mc_simge, 300, 200, 2) ?>" />
            <div class="caption">
                <h3><?= $tema ?> <small>V <?= $mc_bilgiler['version'] ?></small></h3>
                <p>
                    <a href="<?= $mc_bilgiler['website'] ?>" target="_blank"><?= $mc_bilgiler['published'] ?>
                        <?php if (in_array(rtrim($mc_bilgiler['sefsite'], "/"), $mc_gelistiriciler)) { ?>
                            <i title="Onaylanmış Yayıncı" style="font-size: 20px;position: absolute;margin-left: 5px;" class="material-icons col-blue">check_circle</i>
                        <?php } ?>
                    </a>
                </p>
                <button data-name="<?= $tema ?>" data-type="aktif" class="mct_aktifetbtn btn btn-default waves-effect" role="button"><b>Aktif Et</b></button>
                <div class="btn-group dropup">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Diğer <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="javascript:void(0);" data-name="<?= $tema ?>" data-type="kur" class="mct_kurbtn waves-block waves-effect">Kur</a>
                        </li>
                        <?php if ($mc_oturum->grup < 2) { ?>
                            <li>
                                <a class="waves-block waves-effect" href="<?= mc_sistem ?>temalar/duzenle.php?tema=<?= $tema ?>">Düzenle</a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="javascript:void(0);" data-name="<?= $tema ?>" data-type="sil" class="mct_silbtn waves-block waves-effect col-red">Sil</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<div class="col-xs-6 col-sm-4 col-md-3" style="margin-bottom: 15px;text-align: center">
    <a href="<?= mc_sistem ?>temalar/ekle.php" class="thumbnail col-theme" style="border-style: dashed; border-width: 2px;">
        <img style="opacity:.5; background-image: url('<?= mc_img ?>temaekle.gif');background-size: contain;background-repeat: no-repeat" src="<?= m_resim(mc_img . "bos.png", 300, 200, 1) ?>">

            <div class="caption">
                <h3>Yeni tema yükleyin</h3>
                <p>veya indirin</p>
                <button class="btn btn-default waves-effect"><b><?= mc_dil('tema_ekle') ?></b></button>
            </div>
    </a>
</div>
<script type="text/javascript">
    function tema_iframe_al(tema){
        $('.page-loader-wrapper').fadeIn();
        var ifr = $('<iframe/>', {
            id:'site_onizleme',
            src:'<?=m_domain?>',
            style:'display:none;width:1800px;height:700px',
            load:function(){
                $(this).show();
                tema_al(tema);
            }
        });
        $('#mc_m_dyc').html(ifr);
    }

    function tema_al(tema){
        $("#mc_m_dy").modal('show');
        mc_loadJs(mc_plugins + "html2canvas/html2canvas.min.js").done(function () {
            var datacrop = $("#site_onizleme").contents().find('html').find("body");
            var settime = 3500;
            setTimeout(function(){
            datacrop.animate({ scrollTop: 2000 }, 500);
            $('#mc_m_dyc').animate({ scrollLeft: 1800, scrollTop: 2000 }, 500);
            }, 1000);
            setTimeout(function(){
            datacrop.animate({ scrollTop: 0 }, 500);
            $('#mc_m_dyc').animate({ scrollLeft: 0, scrollTop: 0  }, 500);
            }, 2000);
            setTimeout(function(){
            datacrop = datacrop[0];
            }, (settime - 500));
            setTimeout(function(){
                html2canvas(datacrop).then(canvas => {
                    $("body").append('<canvas id="mc_canvas_tema_kapak_olustur" width="600" height="400" style="display:none"></canvas>');
                    var canvas_1 = document.getElementById('mc_canvas_tema_kapak_olustur');
                    var context = canvas_1.getContext('2d');
                    var imageObj = new Image();
                    imageObj.onload = function() {
                        var sourceX = 0;
                        var sourceY = 0;
                        var sourceWidth = 1800;
                        var sourceHeight = 1200;
                        var destWidth = 600;
                        var destHeight = 400;
                        var destX = 0;
                        var destY = 0;
                        context.drawImage(imageObj, sourceX, sourceY, sourceWidth, sourceHeight, destX, destY, destWidth, destHeight);
                    };
                    imageObj.src = canvas.toDataURL("image/png");
                    $('#mc_m_dyc').empty();
                    $("#mc_m_dy").modal('hide');
                    setTimeout(function(){
                        $.post(mc_sistem + "temalar/kapak.php", {kaydet: "onay", tema: tema, resim: canvas_1.toDataURL("image/png").split(",")[1]},
                        function (data) {
                        $('#post_sonuc').append(data);
                            $('.page-loader-wrapper').fadeOut();
                            $('#mc_canvas_tema_kapak_olustur').remove();
                        });
                    }, 500);
                });
            }, settime);
        });
    }
</script>
<?php
echo '</div>';
require mc_sablon . 'footer.php';
?>        
<script>
    mc_hazir(function () {
    if (typeof mc_temaislemler == "undefined") {
    mc_temaislemler = true;
            $(document).on('click', '.mct_aktifetbtn, .mct_kurbtn, .mct_silbtn', function (e) {
    var mct_btn = $(this);
            var mct_btn_t = mct_btn.text();
            mct_btn.text(mcd_lutfen_bekleyiniz + "...");
            $.post(mc_sistem + "temalar/index.php", {kaydet: "onay", tema: $(this).data("name"), gorev: $(this).data("type")},
                    function (data) {
                    mct_btn.text(mct_btn_t);
                            $('#post_sonuc').append(data);
                    });
            return false;
    });
    }
    });
</script>