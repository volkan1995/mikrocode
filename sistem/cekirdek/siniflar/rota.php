<?php

class m_rota {

    protected $mevcutUrl; // Mevcut yolu tutar, string 
    protected $mevcutMetot; // Mevcut istek metodunu tutar, string
    protected $temaDizin; // Tema yolunu tutar, string
    protected $rotalar = []; // Tanımlanmış rotaları tutar, array
    protected $sayfa404; // 404 Sayfasını tutar, Closure|string
    protected $yeniDegiskenler = []; // yeni oluşan tutar
    protected $ilkDosyalar = []; // İlk include edilecek dosyaları tutar
    protected $rotaDosya = null; // İnclude edilecek dosyayı tutar, string
    protected $sonDosyalar = []; // Son include edilecek dosyaları tutar
    protected $metotURL = false; // Güncel metodu saklar, bool / str
    protected $baseURL = true; // Temalar için varsayılan include dizinini saklar, bool / str
    public $dil = null; // Kullanılacak dili saklar
    public $fonksiyonlar = "functions"; // fonksiyonlar sistemi hangi dizinden çalışacak, bool / str
    public $uyeler = false; /* üye sistemi çalışsın mı?, boolean */

    /* Rotacıyı başlatır */

    public function __construct($ayarlar = array()) {
        if (!isset($ayarlar['url'])) {
            $ayarlar['url'] = $_SERVER['REQUEST_URI'];
        }
        if (!isset($ayarlar['metot'])) {
            $ayarlar['metot'] = $_SERVER['REQUEST_METHOD'];
        }
        if (!isset($ayarlar['tema'])) {
            $ayarlar['tema'] = null;
        }

        $this->mevcutUrl = $ayarlar['url'];
        $this->mevcutMetot = $ayarlar['metot'];
        $this->temaDizin = rtrim($ayarlar['tema'], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        // Sayfa bulunamadı rotası
        $this->sayfa404 = function() {
            http_response_code(404);
            header('location: /404');
            exit;
        };
    }

    private function klasor_olustur($yol = null) { 
        $yol = explode(DIRECTORY_SEPARATOR, $yol);
        $ds = count($yol);
        $olustur = null;
        for ($x = 0; $x < $ds; $x++) {
            for ($i = 0; $i <= $x; $i++) {
                ($i !== 0) ? $olustur .= '/' . $yol[$i] : $olustur .= $yol[$i];
            }
            if (!is_dir($olustur)) {
                mkdir($olustur);
            }
            $olustur = '';
        }
        return 1;
    }

    /* import fonksiyonundan gelen dosyayı değişkene aktarır */

    public function include_to_var($d = null, $m = "css") {
        ob_start();
        header("Content-type: text/{$m}; X-Content-Type-Options: nosniff; charset: UTF-8");
        include($d);
        return ob_get_clean();
    }

    // Yeni bir GET rotası
    public function get($url, $dosyaCagir = null, $donus = null, $urlArg = true, $tema = true) {
        $this->rotalar[] = ['GET', $url, $dosyaCagir, $donus, $urlArg, $tema];
    }

    // Yeni bir POST rotası
    public function post($url, $dosyaCagir = null, $donus = null, $urlArg = true, $tema = false) {
        $this->rotalar[] = ['POST', $url, $dosyaCagir, $donus, $urlArg, $tema];
    }

    // Yeni bir URL rotası
    public function url($url, $dosyaCagir = null, $donus = null, $urlArg = true, $tema = false) {
        $this->rotalar[] = ['GET', $url, $dosyaCagir, $donus, $urlArg, $tema];
    }

    // Yeni bir CSS / JAVASCRIPT rotası
    public function import($url, $dosyaCagir = null, $type = "css") {
        $this->mevcutUrl = rtrim(parse_url($this->mevcutUrl)['path'], "/");
        $url = rtrim(parse_url($url)['path'], "/");
        if ($this->mevcutUrl == $url) {
            $onbellek = m_depo . "onbellek" . DIRECTORY_SEPARATOR . $this->temaDizin . ltrim($this->mevcutUrl, "/");
            if (file_exists($onbellek)) {
                echo $this->include_to_var($onbellek, $type);
                exit;
            }
        }
        $this->rotalar[] = [$type, $url, $dosyaCagir, null, true, false];
    }

    // Dosyayı aktar
    public function aktar($dosya) {
        if (file_exists($this->temaDizin . $dosya)) {
            include $this->temaDizin . $dosya;
        }
    }

    // Aktarılacak dosyaları al
    public function sablonDosyalar($ilk = array(), $son = array(), $baseUrl = true) {
        foreach ($ilk as $value) {
            if (strlen($value) > 2) {
                if (file_exists($this->temaDizin . $value)) {
                    $this->ilkDosyalar[] = $this->temaDizin . $value;
                }
            }
        }
        foreach ($son as $value) {
            if (strlen($value) > 2) {
                if (file_exists($this->temaDizin . $value)) {
                    $this->sonDosyalar[] = $this->temaDizin . $value;
                }
            }
        }
        $this->baseURL = $baseUrl;
    }

    // Rotalar tanımlandıktan sonra eşleşen rotayı bulup çalıştırır, return mixed
    public function calistir() {
        foreach ($this->rotalar as $rota) {
            list($metot, $url, $dosyaCagir, $donus, $urlArg, $tema) = $rota;
            $url = str_replace("###", "([-a-zA-Z0-9_]+)", rtrim($url, "/?") . "/?");
            /* :int :str :var */
            if ($urlArg) {
                $urlArg = "(\?.*?)?";
            } else {
                $urlArg = null;
            }
            if ($metot == "GET" || $metot == "POST") {
                $this->metotURL = $tema;
            } else {
                $this->metotURL = $metot;
                $metot = "GET";
            }
            if ($this->mevcutMetot == $metot && preg_match("~^{$url}{$urlArg}$~ixs", $this->mevcutUrl, $veriler)) {
                if (is_bool($this->metotURL)) {
                    array_shift($veriler);
                    if (is_object($donus) && count($veriler)) {
                        $this->yeniDegiskenler = call_user_func_array($donus, $veriler);
                    }
                    $this->yeniDegiskenler['m_donusler'] = $veriler;
                }
                if (strlen($dosyaCagir) > 2) {
                    if (file_exists($this->temaDizin . $dosyaCagir)) {
                        $this->rotaDosya = $dosyaCagir;
                        return true;
                    } else {
                        return call_user_func($this->sayfa404);
                    }
                } else {
                    return $this->yeniDegiskenler;
                }
            }
        }
        return call_user_func($this->sayfa404);
    }

    // Rotayı ekrana dök
    public function dosyalariAktar() {
        /* Fonksiyon dışından gelen verileri derle */
        unset($GLOBALS['m_rota']);
        extract($GLOBALS);
        extract($this->yeniDegiskenler);

        if (is_string($this->metotURL)) {
            /* CSS veya JAVASCRIPT dosyaları varsa aktar ve çık */
            $onbellek['klasor'] = pathinfo(m_depo . "onbellek" . DIRECTORY_SEPARATOR . $this->temaDizin . str_replace("/", DIRECTORY_SEPARATOR, ltrim($this->mevcutUrl, "/")))['dirname'];
            $onbellek['icerik'] = $this->include_to_var($this->temaDizin . $this->rotaDosya, $this->metotURL);
            $onbellek['durum'] = true;
            if (!file_exists($onbellek['klasor'])) {
                $onbellek['durum'] = $this->klasor_olustur($onbellek['klasor']);
            }
            if ($onbellek['durum']) {
                $onbellek['konum'] = m_depo . "onbellek" . DIRECTORY_SEPARATOR . $this->temaDizin . ltrim($this->mevcutUrl, "/");
                $onbellek['yaz'] = fopen($onbellek['konum'], "w");
                if ($onbellek['yaz']) {
                    fwrite($onbellek['yaz'], $onbellek['icerik']);
                    fclose($onbellek['yaz']);
                }
            }
            echo $onbellek['icerik'];
            return true;
        }
        $mt_dil = null;
        $mt_diller = array();
        if (!empty($this->dil)) {
            /* Dil desteği açılmış ise dil dosyasını aktar */     
            if (file_exists($this->temaDizin . "lang" . DIRECTORY_SEPARATOR . "index.php")) {
                include $this->temaDizin . "lang" . DIRECTORY_SEPARATOR . "index.php";
                require mt_fonksiyonlar . "dil.php";
            }
            if (file_exists($this->temaDizin . "lang" . DIRECTORY_SEPARATOR . $this->dil . ".php")) {
                include $this->temaDizin . "lang" . DIRECTORY_SEPARATOR . $this->dil . ".php";                
            }else{
                exit("Kritik dil dosyası hatası");
            }
            $mt_dil = $this->dil;
        }
        //define("mc_dil", $mt_dil);
        if ($this->uyeler == true) {
            /* Üyelik sistemi aktif ise oturum işlemlerini başlat */
            if (file_exists(m_cekirdek . "site" . DIRECTORY_SEPARATOR . "kullanici.php")) {
                require m_cekirdek . "site" . DIRECTORY_SEPARATOR . "kullanici.php";
            }
        }
        if ($this->fonksiyonlar != false && !empty($this->fonksiyonlar)) {
            /* Fonkisyonlar aktif edilmiş ve rotanın fonksiyonu var ise aktar */
            if (file_exists($this->temaDizin . $this->fonksiyonlar . DIRECTORY_SEPARATOR . $this->rotaDosya)) {
                require $this->temaDizin . $this->fonksiyonlar . DIRECTORY_SEPARATOR . $this->rotaDosya;
            }
        }
        /* Title, keywords ve description değerleri yok ise varsayılanları ata */
        if (!isset($title)) {
            $title = null;
        }
        if (!isset($keywords)) {
            $keywords = $m_anahtar;
        }
        if (!isset($description)) {
            $description = $m_aciklama;
        }
        if ($this->metotURL === false) {
            /* 5. argüman($tema) FALSE değeri taşıyor ise şablon kullanmadan dosyaları aktar */
            include $this->temaDizin . $this->rotaDosya;
        } else {
            /* GET metodu istenmiş ise şablon kullanarak aktar */
            if ($this->baseURL == true) {
                /* Ortam dosyaları için varsayılan konumu temanın dizini olarak ayarla */
                echo "<script>var mt_head = document.getElementsByTagName('head')[0]; mt_head.innerHTML += '<base href=\"" . mt_tema . "\"/>';</script>\n";
            }
            foreach ($this->ilkDosyalar as $ilk) {
                /* Rotadan önce yüklenmesi gerekenler */
                require $ilk;
            }

            /* Rotayı yükle */
            include $this->temaDizin . $this->rotaDosya;

            foreach ($this->sonDosyalar as $son) {
                /* Rotadan sonra yüklenmesi gerekenler */
                require $son;
            }
        }
    }

}
