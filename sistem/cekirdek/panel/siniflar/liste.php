<?php

class mc_liste {

    public $coklusecim = true;
    public $araclar = false;
    public $menu = false;
    public $veriler = array();
    public $tablo = null;
    public $id = true;
    public $baslik = true;
    public $aciklama = true;
    public $sekme = 1;
    public $tarih = true;
    public $durum = false;
    public $gorsel = false;
    public $detay = false;
    private $tip = null;

    public function __construct($tip = "veritabanı") {
        $this->tip = $tip;
    }

    public function olustur() {
        switch ($this->tip) {
            case "veritabanı":
                $this->db_olustur();
                break;
            case "sirala":
                $this->sira_olustur();
                break;
            default:
                echo mc_dil('tanimsiz_veri');
                exit;
        }
    }

    private function db_olustur() {
        $params = array('menu' => false, 'baslik' => false, 'aciklama' => false, 'tarih' => false, 'gorsel' => false, 'pathname' => dirname($_SERVER["PHP_SELF"]) . "/", 'getsep' => "?");
        if (count($this->veriler)) {
            if (isset($GLOBALS['mc_this_path'])) {
                $params['pathname'] = mc_panel . "modul.php?tema=" . $GLOBALS['mc_this_path_array']['dirname'] . "/";
                $params['getsep'] = "&";
            }
            if ($this->menu != false && is_string($this->menu)) {
                $params['menu'] = true;
                echo '<div class="col-md-9 col-sm-12 col-xs-12"><div class="clearfix mc_listeler" id="yazdir_alan">';
            }
            $devam = true;
            if ($this->baslik === true || is_string($this->baslik)) {
                if (property_exists($this->veriler[0], $this->baslik)) {
                    $params['baslik'] = true;
                } else if ($this->baslik === true && property_exists($this->veriler[0], 'baslik')) {
                    $this->baslik = "baslik";
                    $params['baslik'] = true;
                } else {
                    $devam = false;
                    $hata = mc_dil('baslik');
                }
            }
            if ($this->aciklama === true || is_string($this->aciklama)) {
                if (property_exists($this->veriler[0], $this->aciklama)) {
                    $params['aciklama'] = true;
                } else if ($this->aciklama === true && property_exists($this->veriler[0], 'aciklama')) {
                    $this->aciklama = "aciklama";
                    $params['aciklama'] = true;
                } else {
                    $devam = false;
                    $hata = mc_dil('aciklama');
                }
            }
            if ($this->tarih == true || is_string($this->tarih)) {
                if (isset($this->veriler[0]->{$this->tarih})) {
                    $params['tarih'] = true;
                } else if ($this->tarih == true && isset($this->veriler[0]->tarih)) {
                    $this->tarih = "tarih";
                    $params['tarih'] = true;
                } else {
                    $devam = false;
                    $hata = mc_dil('tarih');
                }
            }
            if ($this->gorsel == true || is_string($this->gorsel)) {
                if (isset($this->veriler[0]->{$this->gorsel})) {
                    $params['gorsel'] = true;
                } else if ($this->gorsel == true && isset($this->veriler[0]->resim)) {
                    $this->gorsel = "resim";
                    $params['gorsel'] = true;
                } else {
                    $devam = false;
                    $hata = mc_dil('gorsel');
                }
            }
            if ($devam) {
                echo "<input type='hidden' id='mc_liste_tablo' value='{$this->tablo}'/>";
                if ($params['baslik']) {
                    echo "<input type='hidden' id='mc_liste_baslik' value='{$this->baslik}'/>";
                }
                foreach ($this->veriler as $veri) {
                    if ($this->id == true) {
                        echo '<div class="card mc_liste mc_liste_cbx" id="mc_liste_' . $veri->id . '">';
                    } else {
                        echo '<div class="card mc_liste mc_liste_cbx">';
                    }
                    /* Sütun 1 */
                    if ($this->coklusecim == true || $this->gorsel != false) {
                        if ($this->coklusecim == true) {
                            echo '<span class="mc_chk_list"><input type="checkbox" class="chk-col-theme" data-id="' . $veri->id . '" id="inputid_' . $veri->id . '"><label for="inputid_' . $veri->id . '"></label></span>';
                        }
                        echo '<div class="mc_sutun_1">';
                        if ($params['gorsel'] == true) {
                            echo '<img class="m-r-5 otoload" data-src="' . m_resim($veri->{$this->gorsel}, 60, 60) . '"/>';
                        }
                        echo '</div>';
                    }
                    /* Sütun 2 */
                    if ($params['baslik'] || $params['aciklama']) {
                        $baslik = strip_tags($veri->{$this->baslik});
                        echo '<div class="mc_sutun_2">';
                        if ($params['baslik']) {
                            echo '<b title="' . $baslik . '">' . $baslik . '</b>';
                        }
                        if ($params['aciklama']) {
                            echo '<span>' . strip_tags($veri->{$this->aciklama}) . '</span>';
                        }
                        echo '</div>';
                    }
                    /* Sütun 4 */
                    if ($params['tarih'] || $this->araclar != false) {
                        echo '<div class="mc_sutun_4">';
                        if ($params['tarih']) {
                            echo '<small>' . $veri->{$this->tarih} . '</small>';
                        }
                        if (is_array($this->araclar) && count($this->araclar)) {
                            echo '<div class="mc_satir">';
                            if (in_array("duzenle", $this->araclar)) {
                                echo '<a class="col-theme" href="' . $params['pathname'] . "duzenle.php" . $params['getsep'] . "id=" . $veri->id . '">' . mc_dil('duzenle') . '</a>';
                            }
                            if (in_array("goruntule", $this->araclar)) {
                                echo '<a class="col-theme" href="' . $params['pathname'] . 'goruntule.php?id=' . $veri->id . '">' . mc_dil('goruntule') . '</a>';
                            }
                            if ($this->tablo != null && in_array("sil", $this->araclar)) {
                                echo '<a class="col-red satir-sil" href="javascript:void(0);" data-id="' . $veri->id . '">' . mc_dil('sil') . '</a>';
                            }
                            echo '</div>';
                        }
                        echo '</div>';
                    }
                    /* Sütun 3 */
                    if ($this->durum != false || $this->detay != false) {
                        echo '<div class="mc_sutun_3">';
                        if ($this->durum != false && isset($veri->durum)) {
                            echo '<span>' . mc_dil('durum') . ': ';
                            if ($veri->durum == 1) {
                                echo mc_dil('aktif');
                            } else {
                                echo mc_dil('pasif');
                            }
                            echo '</span>';
                        }
                        if ($this->detay != false && isset($veri->{$this->detay})) {
                            echo '<div class="mc_satir">' . $veri->{$this->detay} . '</div>';
                        }
                        echo '</div>';
                    }
                    echo '</div>';
                }
            } else {
                echo "<h3>" . mc_dil('tanimsiz_veri') . "!</h3><h4>" . mc_dil('hata_raporu') . ":<br/><small>" . mc_dil('veri_bulunamadi') . " ({$hata})</small></h4>";
            }
            if ($params['menu']) {
                echo '</div></div><div class="col-md-3 col-sm-4 col-xs-12"><div class="card"><div class="header">';
                global $mc_headtitle;
                echo mc_ustmenu($this->menu, $mc_headtitle);
                echo '</div><form class="body" method="GET">';
                $menu_syc = 0;
                if ($this->coklusecim == true) {
                    echo '<span><input type="checkbox" class="chk-col-theme" id="mc_liste_tumunu_sec"><label for="mc_liste_tumunu_sec">' . mc_dil('tumunu_sec') . ' (<span class="mc_liste_ss">0</span>)</label></span>';
                    echo '<div class="mc_liste_coklug m-b-10">';
                    if ($this->tablo != null && in_array("sil", $this->araclar)) {
                        echo '<span class="btn btn-xs btn-danger waves-effect" id="mc_liste_coklusilbtn"><i class="material-icons">delete_sweep</i> <span>' . mc_dil('sil') . '</span></span>';
                    }
                    echo '</div>';
                }

                if (isset($_GET['p'])) {
                    echo '<input type="hidden" name="p" value="' . intval($_GET['p']) . '">';
                }

                if (is_array($this->araclar) && in_array("arama", $this->araclar)) {
                    if (!isset($_GET['q'])) {
                        $_GET['q'] = null;
                    } else {
                        $_GET['q'] = m_tirnak_temizle(strip_tags($_GET['q']), 2);
                    }
                    echo '<div class="m-t-20"><b>' . mc_dil('ara') . '</b><div class="form-group"><div class="form-line"><input type="text" class="form-control" name="q" placeholder="' . mc_dil('arama_terimi_giriniz') . '" value="' . $_GET['q'] . '"></div></div></div>';
                    $menu_syc += 1;
                }

                if (is_array($this->araclar) && in_array("tarih", $this->araclar)) {
                    if (!isset($_GET['t1']) || empty($_GET['t1'])) {
                        $_GET['t1'] = null;
                    } else {
                        $_GET['t1'] = date("Y-m-d", strtotime($_GET['t1']));
                    }
                    if (!isset($_GET['t2']) || empty($_GET['t2'])) {
                        $_GET['t2'] = null;
                    } else {
                        $_GET['t2'] = date("Y-m-d", strtotime($_GET['t2']));
                    }
                    echo '<div class="m-t-20"><b>' . mc_dil('tarih') . '</b>';
                    echo '<div class="row">
                        <div class="col-md-6">                    
                            <div class="form-group m-b-0">
                                <div class="form-line">
                                  <input type="text" class="datetimepicker1 form-control" name="t1" value="' . $_GET['t1'] . '" placeholder="' . mc_dil('baslangic') . '"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">                    
                            <div class="form-group m-b-0">
                                <div class="form-line">
                                  <input type="text" class="datetimepicker2 form-control" name="t2" value="' . $_GET['t2'] . '" placeholder="' . mc_dil('bitis') . '"/>
                                </div>
                            </div>
                        </div>
                    </div>';
                    echo '<link href="' . mc_plugins . 'bm-datetimepicker/style.css" rel="stylesheet" /><script>
                        mc_hazir(function(){
                            mc_loadJs("' . mc_plugins . 'momentjs/moment.js").done(function(){
                                mc_loadJs("' . mc_plugins . 'bm-datetimepicker/datetimepicker.js").done(function(){
                                    $(".datetimepicker1, .datetimepicker2").bootstrapMaterialDatePicker({
                                        format: \'YYYY-M-D\',
                                        clearButton: true,
                                        weekStart: 1,
                                        time: false
                                    });
                                });
                            });
                        });
                    </script></div>';
                    $menu_syc += 1;
                }

                if (is_array($this->araclar) && in_array("yayin", $this->araclar)) {
                    if (!isset($_GET['yayin'])) {
                        $_GET['yayin'] = 2;
                    }
                    $yayin_dizi = [2 => mc_dil('tumu'), 1 => mc_dil('aktif'), 0 => mc_dil('pasif')];
                    echo '<div class="m-t-20"><b>' . mc_dil('yayin') . '</b><select name="yayin" class="form-control show-tick">';
                    foreach ($yayin_dizi as $key => $val) {
                        if ($key == $_GET['yayin']) {
                            echo '<option value="' . $key . '" selected>' . $val . '</option>';
                            continue;
                        }
                        echo '<option value="' . $key . '">' . $val . '</option>';
                    }
                    echo '</select></div>';
                    $menu_syc += 1;
                }

                if (is_array($this->araclar) && in_array("durum", $this->araclar)) {
                    if (!isset($_GET['durum'])) {
                        $_GET['durum'] = 2;
                    }
                    $durum_dizi = [2 => mc_dil('tumu'), 1 => mc_dil('okunmus'), 0 => mc_dil('okunmamis')];
                    echo '<div class="m-t-20"><b>' . mc_dil('durum') . '</b><select name="durum" class="form-control show-tick">';
                    foreach ($durum_dizi as $key => $val) {
                        if ($key == $_GET['durum']) {
                            echo '<option value="' . $key . '" selected>' . $val . '</option>';
                            continue;
                        }
                        echo '<option value="' . $key . '">' . $val . '</option>';
                    }
                    echo '</select></div>';
                    $menu_syc += 1;
                }

                if (is_array($this->araclar) && in_array("vurgula", $this->araclar)) {
                    if (!isset($_GET['vurgula'])) {
                        $_GET['vurgula'] = 2;
                    }
                    $vurgula_dizi = [2 => mc_dil('tumu'), 1 => mc_dil('evet'), 0 => mc_dil('hayir')];
                    echo '<div class="m-t-20"><b>' . mc_dil('vurgula') . ' / ' . mc_dil('manset') . ' / ' . mc_dil('menu') . '</b><select name="vurgula" class="form-control show-tick">';
                    foreach ($vurgula_dizi as $key => $val) {
                        if ($key == $_GET['vurgula']) {
                            echo '<option value="' . $key . '" selected>' . $val . '</option>';
                            continue;
                        }
                        echo '<option value="' . $key . '">' . $val . '</option>';
                    }
                    echo '</select></div>';
                    $menu_syc += 1;
                }

                if (is_array($this->araclar) && in_array("siralama", $this->araclar)) {
                    if (!isset($_GET['sutun'])) {
                        $_GET['sutun'] = $this->tarih;
                    }
                    if (!isset($_GET['sira'])) {
                        $_GET['sira'] = "desc";
                    }
                    $sutun_dizi = [$this->baslik => mc_dil('baslik'), $this->tarih => mc_dil('tarih')];
                    if ($this->tablo != "mesajlar") {
                        $sutun_dizi['sira'] = mc_dil('ozel_sira');
                    }
                    echo '<div class="m-t-20"><b>' . mc_dil('siralama') . '</b><select name="sutun" class="form-control show-tick">';
                    foreach ($sutun_dizi as $key => $val) {
                        if ($key == $_GET['sutun']) {
                            echo '<option value="' . $key . '" selected>' . $val . '</option>';
                            continue;
                        }
                        echo '<option value="' . $key . '">' . $val . '</option>';
                    }
                    echo '</select><select name="sira" class="form-control show-tick m-t-10">';
                    if ("asc" == strtolower($_GET['sira'])) {
                        echo '<option value="asc" selected>' . mc_dil('artan') . '</option><option value="desc">' . mc_dil('azalan') . '</option>';
                    } else {
                        echo '<option value="asc">' . mc_dil('artan') . '</option><option value="desc" selected>' . mc_dil('azalan') . '</option>';
                    }
                    echo '</select></div>';
                    $menu_syc += 1;
                }

                if (is_array($this->araclar) && isset($this->araclar['filtre'])) {
                    $filtre = $this->araclar['filtre'];
                    if (!isset($filtre['tablo'])) {
                        $filtre['tablo'] = $this->tablo;
                    }
                    if (isset($_GET['filtre'])) {
                        $filtre['sec'] = $_GET['filtre'];
                    }
                    echo '<div class="m-t-20"><b>' . mc_dil('filtre') . '</b><select name="filtre" class="form-control show-tick">';
                    echo mc_kategoriler($filtre, true);
                    echo '</select></div>';
                    $menu_syc += 1;
                }

                if (is_array($this->araclar) && in_array("resim", $this->araclar)) {
                    if (!isset($_GET['resim'])) {
                        $_GET['resim'] = 2;
                    }
                    $resim_dizi = [2 => mc_dil('tumu'), 1 => mc_dil('var'), 0 => mc_dil('yok')];
                    echo '<div class="m-t-20"><b>' . mc_dil('resim') . '</b><select name="resim" class="form-control show-tick">';
                    foreach ($resim_dizi as $key => $val) {
                        if ($key == $_GET['resim']) {
                            echo '<option value="' . $key . '" selected>' . $val . '</option>';
                            continue;
                        }
                        echo '<option value="' . $key . '">' . $val . '</option>';
                    }
                    echo '</select></div>';
                    $menu_syc += 1;
                }

                if ($menu_syc > 0) {
                    echo '<button class="m-t-20 btn btn-info">' . mc_dil('listele') . '</button></form></div></div>';
                }
            }
        } else {
            echo "<h4>" . mc_dil('uyari') . " !</h4>" . mc_dil('hic_veri_bulunamadi') . ", <b><a class='col-theme' href='" . $params['pathname'] . "ekle.php'>" . mc_dil('yeni_icerik_ekleyebilirsiniz') . "</a></b>.";
        }
    }

    private function sira_olustur($sql = array(), $syc = 0) {
        $syc += 1;
        if ($syc > $this->sekme) {
            return true;
        }
        $params = array('baslik' => false, 'aciklama' => false);
        global $m_vt;
        if (!count($sql)) {
            $this_veriler = $this->veriler;
        } else {
            $this_veriler = $sql;
        }
        $this->veriler = $m_vt->sec($this_veriler);
        if (count($this->veriler)) {
            $devam = true;
            if (!count($sql)) {
                if ($this->baslik == true || strlen($this->baslik)) {
                    if (isset($this->veriler[0]->{$this->baslik})) {
                        $params['baslik'] = true;
                    } else if ($this->baslik == true && isset($this->veriler[0]->baslik)) {
                        $this->baslik = "baslik";
                        $params['baslik'] = true;
                    } else {
                        $devam = false;
                        $hata = mc_dil('baslik');
                    }
                }
                if ($this->aciklama == true || strlen($this->aciklama)) {
                    if (isset($this->veriler[0]->{$this->aciklama})) {
                        $params['aciklama'] = true;
                    } else if ($this->aciklama == true && isset($this->veriler[0]->aciklama)) {
                        $this->aciklama = "aciklama";
                        $params['aciklama'] = true;
                    } else {
                        $devam = false;
                        $hata = mc_dil('aciklama');
                    }
                }
            }
            if ($devam) {
                echo '<ol class="dd-list">';
                foreach ($this->veriler as $veri) {
                    echo '<li class="dd-item dd3-item" data-id="' . $veri->id . '">';
                    echo '<div class="dd-handle"><i class="material-icons">drag_handle</i></div>';
                    echo '<div class="dd3-content">' . $veri->{$this->baslik};
                    if ($this->aciklama != false && $veri->{$this->aciklama}) {
                        echo ' / <small>' . $veri->{$this->aciklama};
                    }
                    echo '</small></div>';
                    $this_veriler['where']['ust'] = $veri->id;
                    $this->sira_olustur($this_veriler, $syc);
                    echo '</li>';
                }
                echo '</ol>';
            } else {
                echo "<h3>" . mc_dil('tanimsiz_veri') . "!</h3><h4>" . mc_dil('hata_raporu') . ":<br/><small>" . mc_dil('veri_bulunamadi') . " ({$hata})</small></h4>";
            }
        }
    }

}
