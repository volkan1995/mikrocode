<?php

if (!defined('m_guvenlik')) {
    exit;
}

if (isset($_POST['mail_test'])) {
    if (empty($_POST['mail_host']) || empty($_POST['mail_user']) || empty($_POST['mail_pass']) || empty($_POST['mail_port'])) {
        echo "SMTP (Kullanıcı adı, şifresi, sunucusu veya port) bilgilerinin tam girilmesi gerekiyor.";
        exit;
    }
    if (!isset($_POST['mail_list']) || empty($_POST['mail_list'])) {
        echo "Test için en az bir iletilecek mail adresi tanımlayınız";
        exit;
    }
    $_POST['mail_list'] = explode(",", $_POST['mail_list']);
    if (!count($_POST['mail_list'])) {
        echo "Test için en az bir iletilecek mail adresi tanımlayınız";
        exit;
    }
    $_POST['mail_list'] = $_POST['mail_list'][0];
    if (!filter_var($_POST['mail_list'], FILTER_VALIDATE_EMAIL)) {
        echo "İletilecek mail adresi geçerli değil.";
        exit;
    }
    if (!isset($_POST['mail_smtp'])) {
        $_POST['mail_smtp'] = 0;
    } else {
        $_POST['mail_smtp'] = intval($_POST['mail_smtp']);
    }
    if (!isset($_POST['mail_html'])) {
        $_POST['mail_html'] = 0;
    } else {
        $_POST['mail_html'] = intval($_POST['mail_html']);
    }
    if (!isset($_POST['mail_securty'])) {
        $_POST['mail_securty'] = null;
    }
    if (!isset($_POST['mail_mail']) || !filter_var($_POST['mail_mail'], FILTER_VALIDATE_EMAIL)) {
        $_POST['mail_mail'] = "smtp@" . m_host;
    }
    if (!isset($_POST['mail_head']) || empty($_POST['mail_head'])) {
        $_POST['mail_head'] = $m_baslik;
    }
    require mc_yardimcilar . "mail/class.phpmailer.php";
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->CharSet = "utf-8";
    /* $mail->SetLanguage("tr", "phpmailer/language"); */
    /* Kontrol Edilecekler */
    $mail->Host = $_POST['mail_host'];
    $mail->Port = $_POST['mail_port'];
    $mail->Username = $_POST['mail_user'];
    $mail->Password = $_POST['mail_pass'];
    if ($_POST['mail_smtp'] == 1) {
        $mail->SMTPAuth = true;
    }
    if ($_POST['mail_html'] == 1) {
        $mail->IsHTML(true);
    }
    if (!empty($_POST['mail_securty'])) {
        $mail->SMTPSecure = $_POST['mail_securty'];
    }
    /* Gönderici ve Alıcı Bilgileri */
    $mail->SetFrom($_POST['mail_mail'], $_POST['mail_head']);
    $mail->AddAddress($_POST['mail_list']);
    /* İçeriği oluştur ve gönder */
    $mail->Subject = "SMTP Test Mesajı";
    $mail->Body = "SMTP ayarlarının testi için yollanmıştır.<br/>Testi yapan istemci: " . m_domain;
    echo "<b>Sınama Tamamlandı!</b> ";
    if (!$mail->Send()) {
        echo "Mail ayarlarında sorun var.<br/><b>Ayrıntılar;</b><br/>" . $mail->ErrorInfo;
    } else {
        echo "Mail ayarlarınız çalışıyor, lütfen e-postanızın <b>Gelen</b> bölümünü kontrol ediniz.";
    }
    exit;
}

foreach ($_POST as $key => $value) {
    $m_ayarlar->ayar = m_jsonDegistir($m_ayarlar->ayar, $key, $value, false);
}

$mc_values['ayar'] = $m_ayarlar->ayar;

$mc_kaydet = $m_vt->guncelle(['table' => "ayarlar", 'values' => $mc_values, 'where' => ['id' => 1]])['sonuc'];

mc_uyari($mc_kaydet, ["<b>Başarılı</b>Ayarlarınız kaydedildi", "<b>Başarısız</b>Ayarlarınız bilinmeyen bir sebepten dolayı kaydedilemedi"]);
