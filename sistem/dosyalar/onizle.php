<?php
if (!defined('m_guvenlik')) {
    exit;
}
if (!isset($_POST['id']) || empty($_POST['id'])) {
    exit;
}

$dosya_id = intval($_POST['id']);

$dosya_bul = $m_vt->select()
        ->from("dosyalar")
        ->where('tip', $_POST['tip'])
        ->where('id', $dosya_id)
        ->result();

if (!count($dosya_bul)) {
    echo "<b>Bir sorun oluştu</b>";
    exit;
}
$dosya_bul = $dosya_bul[0];

$mc_dosyatk = str_replace("\\", "/", m_dosyalar . ltrim($dosya_bul->konum, "/"));

if (!file_exists($mc_dosyatk)) {
    echo "Dosya konumunda bulunamadı.<br/>" . $mc_dosyatk;
    exit;
}

$mc_ekleyenbul = $m_vt->select()->from('kullanicilar')
        ->where('id', $dosya_bul->ekleyen)
        ->in("AND")
        ->where('id', mc_oturum_id)
        ->where('grup', 1, "<>", "OR")
        ->out()
        ->result();

require mc_yardimcilar . 'getid3' . DIRECTORY_SEPARATOR . 'getid3.php';
$mc_getid3Class = new getID3();
$mc_getid3 = $mc_getid3Class->analyze($mc_dosyatk);
?>
<script>$('title').text("<?= mc_dosya_ismi($dosya_bul->baslik) ?>");</script>
<div class="col-md-4 col-sm-5">
    <div class="input-group">
        <div class="form-line">
            <input type="text" class="form-control" placeholder="Dosya ismi" value="<?= mc_dosya_ismi($dosya_bul->baslik) ?>"/>
        </div>
        <span class="input-group-addon">
            <button type="submit" class="btn btn-default btn-circle-xs waves-effect"><i class="material-icons">check</i></button>
        </span>
    </div>
    <table class="table">
        <tbody>
            <tr><th scope="row">Dosya tipi</th><td><?= $mc_getid3['mime_type'] ?></td></tr>
            <tr><th scope="row">Uzantı</th><td><?= mc_dosya_ismi($dosya_bul->baslik, true) ?></td></tr>
            <tr><th scope="row">Boyut</th><td><?= mc_boyutyaz($dosya_bul->boyut) ?></td></tr>
            <?php
            if ($dosya_bul->tip == 1) {
                $mc_resim = getimagesize($mc_dosyatk);
                echo '<tr><th scope="row">Genişlik</th><td>' . $mc_resim[0] . ' px</td></tr>';
                echo '<tr><th scope="row">Yükseklik</th><td>' . $mc_resim[1] . ' px</td></tr>';
                $mc_bitH = (string) ((int) @$mc_resim['channels'] * (int) @$mc_resim['bits']) . " Bit";
                echo '<tr><th scope="row">Bit Derinliği</th><td>' . $mc_bitH . '</td></tr>';
            } else if ($dosya_bul->tip == 2) {
                echo '<tr><th scope="row">Süre</th><td>' . $mc_getid3['playtime_string'] . '</td></tr>';
                echo '<tr><th scope="row">Çözünürlük</th><td>' . $mc_getid3['video']['resolution_x'] . ' X ' . $mc_getid3['video']['resolution_y'] . '</td></tr>';
                echo '<tr><th scope="row">Bit Hızı</th><td>' . mc_bityaz($mc_getid3['bitrate']) . '</td></tr>';
                echo '<tr><th scope="row">Ses</th><td>';
                if (isset($mc_getid3['audio']['channelmode'])) {
                    echo $mc_getid3['audio']['channelmode'];
                } else {
                    echo "Sessiz";
                }
                echo '</td></tr>';
            } else if ($dosya_bul->tip == 3) {
                echo '<tr><th scope="row">Süre</th><td>' . $mc_getid3['playtime_string'] . '</td></tr>';
                echo '<tr><th scope="row">Bit Hızı</th><td>' . mc_bityaz($mc_getid3['bitrate']) . '</td></tr>';
                echo '<tr><th scope="row">Kanal</th><td>';
                if (isset($mc_getid3['audio']['channelmode'])) {
                    echo $mc_getid3['audio']['channelmode'];
                } else {
                    echo "Sessiz";
                }
                echo '</td></tr>';
            }
            ?>
            <tr><th scope="row">Yükleyen</th><td><?php if (count($mc_ekleyenbul)) {
        echo '<a href="' . mc_sistem . 'kullanicilar/duzenle.php?id=' . $dosya_bul->ekleyen . '">@' . $mc_ekleyenbul[0]->kadi;
    } else {
        echo "@" . mc_dil('tanimsiz');
    } ?></td></tr>
            <tr><th scope="row">İşlemler</th><td>
        <input type="hidden" name="id" value="<?= $dosya_bul->id ?>"/>
        <a href="javascript:void(0);" data-toggle="modal" data-target="#dosyalinkModal"><i class="material-icons col-grey">content_copy</i></a>
        <a href="javascript:void(0);"><i class="material-icons col-blue">share</i></a>
        <a href="javascript:void(0);"><i class="material-icons col-red">delete</i></a>
        </td></tr>
        </tbody>
    </table>    
</div>
<div class="col-md-8 col-sm-7">
<?php if ($dosya_bul->tip == 1) { ?>
        <div class="thumbnail m-t-10">
            <img src="<?= m_resim($dosya_bul->konum, 720, false, 3) ?>" class="img-responsive">
        </div>
<?php } elseif ($dosya_bul->tip == 2) { ?>
        <video controls preload="metadata" poster="" class="m-t-10" style="width:100%;">
            <source src="<?= m_domain . "/dosyalar" . $dosya_bul->konum ?>">Tarayıcı desteği yok
        </video>
<?php } elseif ($dosya_bul->tip == 3) { ?>
        <audio preload="metadata" controls src="<?= m_domain . "/dosyalar" . $dosya_bul->konum ?>">Desteklenmiyor</audio>
<?php } ?>
</div>
<div class="modal fade" id="dosyalinkModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adresi Kopyala</h4>
            </div>
            <div class="modal-body">
                <div class="input-group m-t-20">
                    <div class="form-line">
                        <input type="text" class="form-control adreskopyala" placeholder="İndirme Adresi" readonly="readonly" value="<?= m_domain . "/dosyalar" . $dosya_bul->konum ?>"/>
                    </div>
                    <span class="input-group-addon">
                        <button class="btn btn-default btn-xs waves-effect"><i class="material-icons kopyala" data-yazi=".adreskopyala">content_copy</i></button>
                    </span>
                </div>                           
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>