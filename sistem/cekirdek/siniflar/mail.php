<?php

$m_mail['durum'] = false;
$m_mail['sonuc'] = null;
if (!class_exists('PHPMailer') && isset($m_mail['baslik']) && isset($m_mail['mesaj']) && isset($m_mail['mail']) && !is_bool($m_mail['mail']) && function_exists('m_jsonAl') && isset($m_ayarlar)) {
    $m_mail_user = m_jsonAl($m_ayarlar->ayar, "mail_user", null);
    $m_mail_pass = m_jsonAl($m_ayarlar->ayar, "mail_pass", null);
    $m_mail_host = m_jsonAl($m_ayarlar->ayar, "mail_host", null);
    $m_mail_port = m_jsonAl($m_ayarlar->ayar, "mail_port", 0);
    if (!empty($m_mail_user) && !empty($m_mail_pass) && !empty($m_mail_host) && $m_mail_port > 0) {
        $m_mail_securty = m_jsonAl($m_ayarlar->ayar, "mail_securty", null);
        require mc_yardimcilar . "mail" . DIRECTORY_SEPARATOR . "class.phpmailer.php";
        $mail = new PHPMailer();
        $mail->IsSMTP();
        if(m_gelistirici > 0){
            $mail->SMTPDebug = 2;
        }else{
            $mail->SMTPDebug = 0;
        }
        $mail->CharSet = "utf-8";
        $mail->Host = $m_mail_host;
        $mail->Port = $m_mail_port;
        if (m_jsonAl($m_ayarlar->ayar, "mail_smtp") == 1) {
            $mail->SMTPAuth = true;
        }
        if (m_jsonAl($m_ayarlar->ayar, "mail_html") == 1) {
            $mail->IsHTML(true);
        }
        if (!empty($m_mail_securty)) {
            $mail->SMTPSecure = $m_mail_securty;
        }
        $mail->Username = $m_mail_user;
        $mail->Password = $m_mail_pass;
        if (isset($m_mail['gonderen']['mail']) && isset($m_mail['gonderen']['isim'])) {
            $mail->SetFrom($m_mail['gonderen']['mail'], $m_mail['gonderen']['isim']);
        } else {
            if (!isset($m_baslik)) {
                $m_baslik = m_host;
            }
            $mail->SetFrom(m_jsonAl($m_ayarlar->ayar, "mail_mail", "mail@" . m_host), m_jsonAl($m_ayarlar->ayar, "mail_head", $m_baslik));
        }
        //Gönderilecek Kişiler
        if (is_string($m_mail['mail'])) {
            if (filter_var($m_mail['mail'], FILTER_VALIDATE_EMAIL)) {
                $mail->AddAddress($m_mail['mail']);
            }
        } else {
            foreach ($m_mail['mail'] as $m) {
                if (filter_var($m, FILTER_VALIDATE_EMAIL)) {
                    $mail->AddAddress($m);
                }
            }
        }
        $mail->Subject = $m_mail['baslik'];
        $mail->Body = $m_mail['mesaj'];
        if (!$mail->Send()) {
            $m_mail['durum'] = false;
            $m_mail['sonuc'] = $mail->ErrorInfo;
        } else {
            $m_mail['durum'] = true;
        }
    }
}