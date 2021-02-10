<?php
    $limit = 6;

    if(empty($_GET['urunler'])){
        echo '<h4>QR kodu oluşturulacak ürünlerin kodlarını giriniz. <i>Örn: (G 941 R)</i></h4><p><b>Not: </b>Büyük harf kullanımı önerilir.</p><form method="GET" action="/export"><table>';
        for ($i = 0; $i < $limit; $i++) {
            echo '<tr><td style="padding:5px 5px;"><b>Ürün '. ( $i + 1 ) .': </b></td><td style="padding:5px 5px;"><input type="text" name="urunler[]"></td></tr>';
        }
        echo '<tr><td></td><td style="padding:5px 5px;"><input type="submit" value="QR Oluştur"/></td></tr></table></form>';
        
        exit;
    }
    
    function mc_urun_sef($m = null) {
        $e = array("I", "Ğ", "Ü", "Ş", "İ", "Ö", "Ç", "Q", "W", "E", "R", "T", "Y", "U", "O", "P", "A", "S", "D", "F", "G", "H", "J", "K", "L", "Z", "X", "C", "V", "B", "N", "M", "ı", "ğ", "ü", "ş", "ö", "ç", "â");
        $y = array("i", "g", "u", "s", "i", "o", "c", "q", "w", "e", "r", "t", "y", "u", "o", "p", "a", "s", "d", "f", "g", "h", "j", "k", "l", "z", "x", "c", "v", "b", "n", "m", "i", "g", "u", "s", "o", "c", "a");
        $m = str_replace($e, $y, $m);
        $m = mb_strtolower($m, 'UTF-8');
        $m = preg_replace('#[^-a-zA-Z0-9_ ]#', '', $m);
        $m = trim($m);
        $m2 = "";
        $m = str_replace("-", " ", $m);
        $k = explode(" ", $m);
        foreach ($k as $v) {
            if ($v != "") {
                $m2 .= $v . " ";
            }
        }
        $m = $m2;
        $m = trim($m);
        $m = str_replace(" ", "-", $m);
        return trim($m);
    }
    
    $urun_liste = array();
    
    foreach ($_GET['urunler'] as $qr_urun){
        
        if(!empty($qr_urun)){
            
           $urun_liste[] = mc_urun_sef($qr_urun);
            
        }
        
    }
    
    if(empty($urun_liste)){
        
        exit("Lütfen geçerli ürün kodu giriniz!");
        
    }
    
    $urunler = $m_vt->select()->from('yazilar')->inwhere('sef', $urun_liste)->limit($limit)->where('dil', 'tr')->result();
    $orta_resim = m_resim(m_ekyaz('qrcreate_img', 'resim'), 80, 80, 2);
?>

<html>
    <head>

        <style>
            body{
                width: 21.6cm;
                height: 32cm;
            }
            .block{
                width: 9.3cm;
                height: 9cm;
                border: 0.5mm dashed #222;
                margin: 6mm 7mm 10mm 7mm;
                float: left;
                text-align: center;
            }
            .block h2{
                text-align: center;
                font-size: 8mm;
                padding: 3mm 0 6mm 0;
                margin: 0;
            }
            .block img{
                margin: 3mm 0;
                
            }
            .block_in{
                display: inline-block;
                overflow: hidden;
            }
        </style>
    </head>
    <body>
            <?php
                foreach ($urunler as $no => $urun) {
                    $urun_kat = $m_vt->select()->from('kategoriler')->where('id', $urun->kategori)->result();
                    if(!count($urun_kat)){
                        continue;
                    }
                    echo '<div class="block"><h2>'.$urun->baslik.'</h3><input type="hidden" id="qrval'.$no.'" value="http://flatelli.com/urunler/'.$urun_kat[0]->sef.'/'.$urun->sef.'" /><div class="block_in" id="qrimg'.$no.'"></div></div>';
                }
            ?>
    </body>    
    <script src="<?=mt_tema?>js/easy.qrcode.min.js" type="text/javascript" charset="utf-8"></script>
    <script>        
        function showQr() {
            var i;
            for (i = 0; i < <?=count($urunler)?>; i++) {
                new QRCode(document.getElementById("qrimg" + i), {
                    text: document.getElementById("qrval" + i).value,
                    width: 200,
                    height: 200,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    logo: "<?= $orta_resim ?>",
                    logoWidth: 80,
                    logoHeight: 80,
                    logoBgColor: '#ffffff',
                    logoBgTransparent: false,
                    correctLevel: QRCode.CorrectLevel.H
                });
            }
        }
        showQr();        
    </script>
</html>