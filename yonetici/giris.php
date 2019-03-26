<?php
if (!defined('m_girisyap')) {
    define("m_girisyap", true);
}
require 'loader.php';
if (isset($_SESSION['kullanici'])) {
    if (isset($_SERVER["HTTP_REFERER"])) {
        if (@pathinfo(parse_url($_SERVER["HTTP_REFERER"])['path'])['basename'] == "giris.php") {
            $_SERVER["HTTP_REFERER"] = mc_panel;
        }
        m_git($_SERVER["HTTP_REFERER"]);
    } else {
        m_git(mc_panel);
    }
}
if (isset($_GET['get'])) {
    $mc_json64 = json_decode(base64_decode($_GET['get']));
} else {
    $mc_json64 = array();
}
if (!empty($_POST)) {
    require m_cekirdek . "panel" . DIRECTORY_SEPARATOR . "kullanici_post.php";
}
?>
﻿<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <title><?= mc_dil('giris_yap') ?></title>
    <link rel="icon" href="<?= mc_img ?>favicon.ico" type="image/x-icon" />
    <link href="<?= mc_plugins ?>bootstrap/css/bootstrap.css" rel="stylesheet" />
    <link href="<?= mc_plugins ?>node-waves/waves.min.css" rel="stylesheet" />
    <link href="<?= mc_plugins ?>animate-css/animate.css" rel="stylesheet" />
    <link href="<?= mc_css ?>style.css?v=25" rel="stylesheet" />
    <link href="<?= mc_css ?>themes/light.css" rel="stylesheet" />
    <style>
        .login-page{background-image: url('<?= mc_img ?>arkaplan.jpg');background-repeat: no-repeat;padding-left:0;max-width:360px;margin:5% auto;overflow-x:hidden}
        .login-page .login-box .msg{color:#555;margin-bottom:20px;text-align:center}
        .login-page .login-box a{font-size:14px;text-decoration:none;color:#00BCD4}
        .login-page .login-box .logo{margin-bottom:20px}
        .login-page .login-box .logo a{font-size:36px;display:block;width:100%;text-align:center;color:#fff}
        .login-page .login-box .logo small{display:block;width:100%;text-align:center;color:#fff;margin-top:-5px}
    </style>
</head>
<body class="login-page">
<div class="login-box">
    <div class="logo">
        <a href="javascript:void(0);"><?= $m_baslik ?></a>
        <small>&copy; <script type="text/javascript">var year = new Date();document.write(year.getFullYear());</script> <?= m_firma ?></small>
    </div>
    <div class="card">
        <div class="body">
            <form onsubmit="giris_yap(); return false;" method="POST" id="giris_yap_form">
                <div class="msg" id="giris_yap_rapor"><?= mc_dil('yetkihata_1') ?>!</div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">person</i>
                    </span>
                    <div class="form-line">
                        <input type="text" class="form-control" name="name" placeholder="<?= mc_dil('kullanici_adi') . " / " . mc_dil('email_adresi') ?>" required autofocus />
                    </div>
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock</i>
                    </span>
                    <div class="form-line">
                        <input type="password" class="form-control" name="pass" placeholder="<?= mc_dil('sifre') ?>" required />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <select name="hatirla" class="form-control show-tick">
                            <?php
                            echo '<option value="0">' . mc_dil('beni_hatirlama') . '</option>';
                            for ($i = 1; $i <= 9; $i += 2) {
                                echo '<option value="$i">' . $i . ' ' . mc_dil('gun') . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-6 align-right">
                        <button class="btn bg-cyan waves-effect" id="giris_yapbtn" type="submit"><?= mc_dil('giris_yap') ?></button>
                    </div>
                </div>
            </form>
            <form method="POST">
                <div class="row m-t-20">
                    <div class="col-xs-4">
                        <select name="dil" class="form-control show-tick" required="" onchange="this.form.submit()">
                            <?php
                            $mc_secili_dil = false;
                            foreach ($mc_diller as $key => $value) {
                                if ($mc_dil == $key && isset($_SESSION['dil'])) {
                                    $_SESSION['dil'] = $key;
                                    echo "<option value='$key' selected>" . $value['dil'] . "</option>";
                                    $mc_secili_dil = true;
                                } else {
                                    echo "<option value='$key'>" . $value['dil'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-8 align-right m-t-10">
                        <a href="#sifremi_unuttum" style="display:none"><?= mc_dil('sifremi_unuttum') ?></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<link href="<?= mc_plugins ?>bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<script src="<?= mc_plugins ?>jquery/jquery.min.js"></script>

<script src="<?= mc_plugins ?>bootstrap/js/bootstrap.js"></script>

<script src="<?= mc_plugins ?>node-waves/waves.min.js"></script>

<script src="<?= mc_js ?>giris.js"></script>

<script src="<?= mc_js ?>pages/ui/animations.js"></script>

<script src="<?= mc_plugins ?>bootstrap-select/js/bootstrap-select.min.js"></script>

<script>
    var giris_yap_btn;
    var giris_yap_onay = true;
    function giris_yap() {
        giris_yap_btn = $('#giris_yapbtn');
        if (giris_yap_onay === true) {
            giris_yap_btn.text('<?= mc_dil('kontrol_ediliyor') ?>...');
            giris_yap_onay = false;
            $.post("<?= m_url ?>",
                    $("#giris_yap_form").serialize(),
                    function (d) {
                        setTimeout(function () {
                            $("#giris_yap_rapor").html(d);
                        }, 700);
                    }
            );
        }
    }

</script>
<link href="<?= mc_plugins ?>material-fonts/css/font.css?v=2" rel="stylesheet" type="text/css" />    
</body>
</html>