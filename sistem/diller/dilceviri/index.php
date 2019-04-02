<?php
if(!defined('m_guvenlik')) { define("m_guvenlik", true); }

require $_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR.'index.php';

if(!defined("m_domain")){
    if((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off') || $_SERVER['SERVER_PORT']==443){        
        $_SERVER['HTTPS'] = 'on';        
        define("m_domain", "https://".$_SERVER['HTTP_HOST']);
    }else{        
        define("m_domain", "http://".$_SERVER['HTTP_HOST']);
    }
}

$dil_konum = m_sistem."diller".DIRECTORY_SEPARATOR;

$dillerDizi['tr'] = "Türkçe";
$dillerDizi['en'] = "İngilizce";
$dillerDizi['de'] = "Almanca";
$dillerDizi['ar'] = "Arapça";
$dillerDizi['fr'] = "Fransızca";
$dillerDizi['es'] = "İspanyolca";
$dillerDizi['it'] = "İtalyanca";
$dillerDizi['ru'] = "Rusça";
$dillerDizi['ja'] = "Japonca";
$dillerDizi['pt'] = "Portekizce";
$dillerDizi['hi'] = "Hintçe";
$dillerDizi['ms'] = "Malayca";
$dillerDizi['bn'] = "Bengalce";
$dillerDizi['cc'] = "Çince - Kanton Lehçesi (Güney)";
$dillerDizi['cm'] = "Çince - Mandarin Lehçesi (Kuzey)";

if(isset($_POST['mc_dildizin'])){    
    $dil_konumP = $dil_konum.$_POST['mc_dildizin'].DIRECTORY_SEPARATOR;
    echo "<option value=''>Dil Dosyası Seçiniz</option>";
    if(is_dir($dil_konumP)){
        if($handle = opendir($dil_konumP)){
            while(($file = readdir($handle)) !== false){
                if($file != "." && $file != ".." && $file != "Thumbs.db"){
                    $fileD = explode(".", $file);
                    if(count($fileD) && strtolower(end($fileD)) == "php"){
                        $key = strtolower($fileD[0]);
                        if(isset($dillerDizi[$key])){
                            echo "<option data-key = '$key' value='".$dil_konumP.$file."'>".strtoupper($key).".php (".$dillerDizi[$key].")</option>";
                        }                        
                    }
                }
            }
            closedir($handle);
        }
    }
    exit;
}

if(isset($_POST['mc_dilyukle'])){
    $dil_konum = $_POST['mc_dilyukle'];
    if(file_exists($dil_konum)){
        require $dil_konum;
        if(isset($mc_s_dil)){
            foreach ($mc_s_dil as $key => $value) {
                echo '<span class="satirdil"><dizi>$mc_s_dil[\'<anahtar>'.$key.'</anahtar>\']</dizi> = <span value="'.$value.'" id="'.$key.'" class="mc_ceviri"></span><dizi>;</dizi></span>';
                echo "<silik>/* $value */</silik><br/>";
            }
        }
    }
    exit;
}

if(isset($_POST['mc_ceviri'])){
    if(isset($_POST['cevir'])){
        function mc_ceviri($yazi,$dil="tr",$cvr="en"){
            $key = 'AIzaSyDDoCdzMXy-82XlPB-xALgIv8RMN6S2gKQ';
            $handle = curl_init();
            if(FALSE === $handle){
                return null;
            }else{
                curl_setopt($handle, CURLOPT_URL,'https://www.googleapis.com/language/translate/v2'); 
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1); 
                curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); 
                curl_setopt($handle, CURLOPT_POSTFIELDS, array( 'key'=> $key, 'q' => $yazi, 'source' => $dil, 'target' => $cvr )); 
                curl_setopt($handle,CURLOPT_HTTPHEADER,array('X-HTTP-Method-Override: GET')); 
                $response = curl_exec($handle); 
                $responseDecoded = json_decode($response, true);
                curl_close($handle); 
                if(isset($responseDecoded['data'])){
                    return $responseDecoded['data']['translations'][0]['translatedText'];
                }else{
                    if(isset($responseDecoded['error']['code'])){
                        return "(".$responseDecoded['error']['code'].") ".$responseDecoded['error']['message'];
                    }else{
                        return null;
                    }                    
                }
            }
        }
        $yeni_ceviri = mc_ceviri($_POST['cevir'],@$_POST['orjdil'],$_POST['mc_ceviri']);
        echo $yeni_ceviri;
    }else{
        echo null;
    }    
    exit;
}

$dil_dizinD = array('kurulum'=>"Kurulum",'yonetici'=>"Yönetici Paneli");

$dil_indexknm = m_domain."/sistem/diller/dilceviri/index.php";

?>
<html>
    <head>
        <script src="<?=m_domain?>/sistem/sablon/plugins/jquery/jquery.min.js" type="text/javascript"></script>
        <style>
            body {background-color: #fefefe;}
            .satirdil { line-height: 20px; color: #333; }
            .satirdil dizi { color:#025f53; font-weight: bold; }
            .satirdil anahtar { color:#943603; font-weight: normal;}
            .sutun { float: left; margin-right: 15px; }
            .sutun b{ line-height: 36px;font-size: 24px;}
            .sutun small {display: block; margin-bottom: 5px; text-align: left;}
            #ceviribtn{ }
            #gizlebtn{ color: #666; font-size: 12px; margin-top: 5px; display: block; cursor: pointer;}
            #gizlebtn:hover {color:#444;}
            #tumdiller silik {color:#999; font-style: italic; font-size: 12px; margin-left: 15px;}
        </style>
    </head>
    <body>
        <div style="width: 100%; float: left; margin: 10px 0 20px 0;">
            <h2 style="width: 100%; float: left; margin: 0 0 10px 0">Mikrocode Çeviri Motoru</h2>
            <div class="sutun">
                <small>Çeviri Bölümü</small>
                <select id="secdil" onchange="return dilsec();">
                    <option value=''>Çevrilecek Bölümü Seçiniz</option>
                    <?php
                    foreach ($dil_dizinD as $key => $value) {
                        echo "<option data-key = '$key' value='$key'>$value</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="sutun"><b> &rrarr; </b></div>
            <div class="sutun">
                <small>Çeviri Dosyası</small>
                <select id="aldil" onchange="return dilyukle();">
                    <option value=''>Çevrilecek Bölümü Seçiniz</option>
                </select>
            </div>
            <div class="sutun"><b> &rrarr; </b></div>
            <div class="sutun">
                <small>Çevrilecek Dil</small>
                <select id="cevirdil">
                    <option value=''>Dil Seçiniz</option>
                    <?php
                    foreach ($dillerDizi as $key => $value) {
                        echo "<option id='dil_opt_$key' value='$key'>".$dillerDizi[$key]."</option>";
                    }
                    ?>                    
                </select>
            </div>
            <div class="sutun">
                <button id="ceviribtn" onclick="return mc_ceviri_baslat();">Çeviriyi Başlat</button>
                <span id="gizlebtn" onclick="return mc_orj_toggle();">Orjinal Metinleri Gizle</span>
            </div>
        </div>
        <div id="tumdiller" style="width: 100%; float: left; margin: 10px 0 20px 0;"></div>
        <script>
            
        var cevirdil = "en";
        var mc_ceviris = 0;
        var tum_ogeler ;
        var orjmtn = true;
        var aldil = null;
        var secdil = null;
        
        function dilsec(){
            secdil = $("#secdil").val();
            if(secdil.length > 4){
                $.post("<?=$dil_indexknm?>",
                    {mc_dildizin:secdil},
                    function(d){
                        $('#tumdiller').empty();
                        $('#aldil').html(d);
                    }
                );
            }
        }
        
        function dilyukle(){
            aldil = $("#aldil").val();
            if(aldil.length > 4){
                $.post("<?=$dil_indexknm?>",
                    {mc_dilyukle:aldil},
                    function(d){
                        $('#tumdiller').html(d);
                        $('#cevirdil option').css({'display':'inherit'});
                        $('#cevirdil #dil_opt_' + $("#aldil option:selected").data('key')).css({'display':'none'});
                    }
                );
            }
        }
        
        function mc_ceviri_baslat(){
            if(aldil != null && aldil.length > 4){
                cevirdil = $("#cevirdil").val();
                if(cevirdil != null && cevirdil.length > 1){
                    tum_ogeler = $('.mc_ceviri');
                    $('#ceviribtn').text("Çeviri Yapılıyor...");
                    document.getElementById("ceviribtn").disabled = true;
                    document.getElementById("secdil").disabled = true;
                    document.getElementById("aldil").disabled = true;
                    document.getElementById("cevirdil").disabled = true;
                    mc_ceviri();
                }
            }
        }

        function mc_ceviri(){
            if(mc_ceviris < tum_ogeler.length) {
                var anlik_oge = $(tum_ogeler[mc_ceviris]);
                anlik_oge.html("<img src='<?=m_domain?>/sistem/diller/dilceviri/bekle.gif' height='10px'/>");
                $.post("<?=$dil_indexknm?>",
                    {mc_ceviri:cevirdil,orjdil:$("#aldil option:selected").data('key'),cevir:anlik_oge.attr('value')},
                    function(d){
                        anlik_oge.html('"' + d + '"');
                        mc_ceviri();
                        mc_ceviris = mc_ceviris + 1;
                    }
                );
            }else{
                $('#ceviribtn').text("Çeviriyi Başlat");
                document.getElementById("ceviribtn").disabled = false;
                document.getElementById("secdil").disabled = false;
                document.getElementById("aldil").disabled = false;
                document.getElementById("cevirdil").disabled = false;
                mc_ceviris = -1;
                alert("Çeviri Tamamlandı");
            }
        }
        
        function mc_orj_toggle(){
            if(orjmtn){
                $("#tumdiller silik").fadeOut(300);
                $('#gizlebtn').text("Orjinal Metinleri Göster");
                orjmtn = false;
            }else{
                $("#tumdiller silik").fadeIn(300);
                $('#gizlebtn').text("Orjinal Metinleri Gizle");
                orjmtn = true;
            }
        }

        </script>
    </body>
</html>
<?php