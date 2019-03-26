<?php
if (!defined('m_sistem_header')) {
    define("m_sistem_header", true);
}
require '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'yonetici' . DIRECTORY_SEPARATOR . 'loader.php';
if($mc_oturum->grup > 2){
    m_git("/404");
}
$msl3_result = array();
$msl3_tables = array();
$msl3_columns_name = array();
$msl3_tables_cont = array("ayarlar", "ip", "klasorler", "bildirimler");
if (extension_loaded('sqlite3')) {
    $msl3_baglan = new SQLite3(m_depo . "sqlite" . DIRECTORY_SEPARATOR . mdb_name . ".db");
    foreach ($m_vt->sorgu("SHOW TABLES", [], "FETCH_COLUMN") as $mcs_tablo) {
        if (in_array($mcs_tablo, $msl3_tables_cont)) {
            continue;
        }
        $msl3_sor = $msl3_baglan->query("PRAGMA table_info('{$mcs_tablo}')");
        if (is_array($msl3_sor->fetchArray(SQLITE3_ASSOC))) {
            $msl3_tables[] = $mcs_tablo;
        }
    }
}
$msl3_columns = array('id' => "ID", 'baslik' => "Başlık", 'silinme' => "Silinme Tarihi");
$msl3_orderby = array('asc' => "Artan", 'desc' => "Azalan");
if (empty($_GET['table']) || !in_array($_GET['table'], $msl3_tables)) {
    $_GET['table'] = "yazilar";
}
if (empty($_GET['column']) || !isset($msl3_columns[$_GET['column']])) {
    $_GET['column'] = "silinme";
}
if (empty($_GET['orderby']) || !isset($msl3_orderby[$_GET['orderby']])) {
    $_GET['orderby'] = "desc";
}
if (!isset($_GET['q'])) {
    $_GET['q'] = null;
}
if (extension_loaded('sqlite3')) {
    $sql3_columns = array('id' => "id", 'baslik' => "baslik", 'silinme' => "sql3_tarih");
    if (empty($_GET['q'])) {
        $msl3_tablo = $msl3_baglan->query("SELECT * FROM {$_GET['table']} ORDER BY {$sql3_columns[$_GET['column']]} " . strtoupper($_GET['orderby']));
    } else {
        $msl3_tablo = $msl3_baglan->prepare("SELECT * FROM {$_GET['table']} WHERE baslik LIKE :likevalue ORDER BY {$sql3_columns[$_GET['column']]} " . strtoupper($_GET['orderby']));
        $msl3_tablo->bindValue(":likevalue", "%" . $_GET['q'] . "%", SQLITE3_TEXT);
        $msl3_tablo = $msl3_tablo->execute();
    }
    while ($msl3_result_row = $msl3_tablo->fetchArray(SQLITE3_ASSOC)) {
        $msl3_result[] = $msl3_result_row;
    }
    $msl3_sor = $msl3_baglan->query("PRAGMA table_info('{$_GET['table']}')");
    while ($tablo = $msl3_sor->fetchArray(SQLITE3_ASSOC)) {
        $msl3_columns_name[$tablo['name']] = $tablo['type'];
    }
}
$mc_s_dil['sql3_tarih'] = "ST";
$mc_s_dil['sql3_kullanici'] = "SK";
$mc_s_dil['sql3_ip'] = "SI";
?>
<div class="row clearfix">
    <form class="col-md-9 col-xs-12" method="POST" id="settings-form" data-dir="ayarlar">
        <div class="settings-div">
            <div class="col-md-12 col-xs-12 settings-head"><h4>Geri Dönüşüm <small>(<?=mc_dil($_GET['table'])?>)</small></h4></div>
            <div class="col-md-12 col-xs-12 settings-body">
                <small><b>Not: Geri dönüşümde bulunan silinmiş veriler veritabanında yer tutmaz.</b><br/>
                    Bu bölüm geliştirilme aşamasındadır. Verileri kurtarma yada kalıcı silme işlemi henüz yapılmamaktadır.</small>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead>
                            <tr>
                                <?php
                                foreach ($msl3_columns_name as $key => $value) {
                                    echo '<th title="'.$key.'">' . mc_dil($key) . '</th>';
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (is_array($msl3_result) && count($msl3_result)) {
                                foreach ($msl3_result as $values) {
                                    echo '<tr>';
                                    foreach ($values as $key => $value) {
                                        if (strlen($value) > 50) {
                                            $value = m_kisalt($value, 50);
                                        }
                                        echo '<td>' . htmlspecialchars($value) . '</td>';
                                    }
                                    echo '</tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>



            </div>
            <div class="col-md-12 col-xs-12 settings-footer"></div>
        </div>
    </form>

    <div class="col-md-3 col-xs-12">
        <form class="settings-body" method="GET">
            <b class="m-t-10">Detaylı Arama</b>
            <div class="form-group">
                <div class="form-line m-t-10">
                    <input type="text" class="form-control" name="q" placeholder="Arama terimi giriniz" value="<?= htmlspecialchars($_GET['q']) ?>"/>
                </div>
            </div>

            <select name="table" required="" class="form-control show-tick  m-t-20">
                <?php
                foreach ($msl3_tables as $msl3_table) {
                    if ($_GET['table'] == $msl3_table) {
                        echo "<option value='$msl3_table' selected>" . mc_dil($msl3_table) . "</option>";
                        continue;
                    }
                    echo "<option value='$msl3_table'>" . mc_dil($msl3_table) . "</option>";
                }
                ?>
            </select>

            <select name="column" required="" class="form-control show-tick m-t-20">
                <?php
                foreach ($msl3_columns as $key => $msl3_column) {
                    if ($_GET['column'] == $key) {
                        echo "<option value='$key' selected>" . mc_dil($msl3_column) . "</option>";
                        continue;
                    }
                    echo "<option value='$key'>" . mc_dil($msl3_column) . "</option>";
                }
                ?>
            </select>

            <select name="orderby" required="" class="form-control show-tick m-t-20">
                <?php
                foreach ($msl3_orderby as $key => $msl3_order) {
                    if ($_GET['orderby'] == $key) {
                        echo "<option value='$key' selected>" . mc_dil($msl3_order) . "</option>";
                        continue;
                    }
                    echo "<option value='$key'>" . mc_dil($msl3_order) . "</option>";
                }
                ?>
            </select>

            <input type="submit" value="Bul" class="btn btn-theme m-t-20 waves-effect m-b-10"/>

        </form>
    </div>
</div>
<?php
require mc_sablon . 'footer.php';
?>
<script>
    mc_hazir(function () {
        mc_loadCss(mc_plugins + "jquery-datatable/css/dataTables.bootstrap.min.css");
        mc_loadJs(mc_plugins + "jquery-datatable/jquery.dataTables.js?v=2").done(function () {
            $('.js-basic-example').DataTable({
                responsive: true, paging: false, searching: false, bInfo: false
            });
        });
    });
</script>