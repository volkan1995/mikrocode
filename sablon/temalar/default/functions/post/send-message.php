<?php
if(!isset($_POST['name']) || empty($_POST['name'])){ echo "İsim alanını boş bırakmayınız!"; exit; }
if(!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){ echo "Geçerli bir e-posta adresi giriniz!"; exit; }
if(!isset($_POST['subject']) || strlen($_POST['subject']) < 3){ echo "Konu en az 3 karakterden oluşmalı!"; exit; }
if(!isset($_POST['message']) || strlen($_POST['message']) < 5){ echo "Mesaj en az 5 karakterden oluşmalı!"; exit; }
$mc_kaydet = $m_vt->ekle([
    'table'=>"mesajlar",
    'values'=>[
        'baslik' => $_POST['subject'],
        'isim' => $_POST['name'],
        'icerik' => $_POST['message'],
        'gonderen' => $_POST['email'],
        'alici' => m_domain,
        'ip' => m_getip()
    ]
])['sonuc'];
if($mc_kaydet){
    echo "<b>Başarılı, </b>Mesajınız gönderildi!";        
    $m_mail['baslik'] = $_POST['subject'];
    $m_mail['mesaj'] = $_POST['message'];
    $m_mail['mail'] = explode(",", m_jsonAl($m_ayarlar->ayar, "mail_list", null));
    $m_mail['gonderen']['mail'] = $_POST['email'];
    $m_mail['gonderen']['isim'] = $_POST['name'];
    require m_cekirdek."siniflar/mail.php";        
}else{
    echo "<b>Başarısız, </b>Mesajınız bilinmeyen bir sebepten dolayı gönderilemedi!";
}