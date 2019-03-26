<?php

class mc_arsivle extends ZipArchive {

    protected $isim;
    protected $atla = array();
    protected $dizinler = array();
    protected $izinliex = array();
    protected $yasakliex = array();
    public $anaDizin = null;

    public function __construct() {
        
    }

    public function altDizinler($altDizinler = array()) {
        if (is_array($altDizinler)) {
            $this->dizinler = $altDizinler;
        }
    }

    public function izinli($izinliler = array()) {
        if (is_array($izinliler)) {
            $this->izinliex = $izinliler;
        }
    }

    public function yasakli($yasaklilar = array()) {
        if (is_array($yasaklilar)) {
            $this->yasakliex = $yasaklilar;
        }
    }

    public function atla($atla = array()) {
        if (is_array($atla)) {
            foreach ($atla as $yol) {
                $this->atla[] = str_replace(["/", DIRECTORY_SEPARATOR], DIRECTORY_SEPARATOR, $yol);
            }
        }
    }

    function zipOlustur($ad) {
        $this->isim = $ad;
        $this->sil();
        $this->open($ad . '.zip', ZipArchive::CREATE);
    }

    public function arsivle($altdizin = false) {
        if (is_bool($altdizin) && $altdizin === false) {
            if (count($this->dizinler)) {
                $dizinler = $this->dizinler;
            } else {
                $dizinler[] = null;
            }
        } else {
            $dizinler[] = $altdizin;
        }
        foreach ($dizinler as $dizin_al) {
            if(is_dir($this->anaDizin . $dizin_al)){
                $dizin = scandir(rtrim($this->anaDizin . $dizin_al, DIRECTORY_SEPARATOR));
                unset($dizin[array_search('.', $dizin, true)]);
                unset($dizin[array_search('..', $dizin, true)]);
                if (count($dizin) < 1) {
                    return;
                }
            }else{
                $dizin[] = $dizin_al;
                $dizin_al = null;
            }
            if (strlen($dizin_al) > 0) {
                $dizin_al = $dizin_al . DIRECTORY_SEPARATOR;
            }
            foreach ($dizin as $dosya) {
                $altyol = $dizin_al . $dosya;
                $tamyol = $this->anaDizin . $altyol;
                if(is_array($this->atla) && count($this->atla)){
                    if(in_array($altyol, $this->atla)){
                        continue;
                    }
                }
                if (is_dir($tamyol)) {
                    $this->arsivle($altyol);
                } elseif (is_file($tamyol)) {
                    $fpi = pathinfo($tamyol);
                    if (!isset($fpi["extension"])) {
                        $fpi["extension"] = null;
                    }
                    if (count($this->izinliex)) {
                        if (!in_array($fpi["extension"], $this->izinliex)) {
                            continue;
                        }
                    }
                    if (count($this->yasakliex)) {
                        if (in_array($fpi["extension"], $this->yasakliex)) {
                            continue;
                        }
                    }
                    $this->addFile($tamyol, $altyol);
                }
            }
        }
    }

    public function sil() {
        @unlink($this->isim . '.zip');
    }

}
