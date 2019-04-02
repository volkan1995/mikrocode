<?php

class mc_menu {

    protected $menu = array();

    public function __construct($menuDizi = array()) {
        if (is_array($menuDizi) && !empty($menuDizi)) {
            $this->menu = $menuDizi;
        } else {
            if (!m_gelistirici && file_exists(m_depo . "panel-menu.php")) {
                require m_depo . "panel-menu.php";
                if (isset($mc_menuStr)) {
                    $this->menu = json_decode($mc_menuStr);
                }
            } else {
                $this->menu_tara();
                if (file_exists(m_depo . "panel-menu.php")) {
                    require m_depo . "panel-menu.php";
                    if (isset($mc_menuStr)) {
                        $this->menu = json_decode($mc_menuStr);
                    }
                }
            }
        }
        if (isset($GLOBALS['m_vt'])) {
            $sorgu = $GLOBALS['m_vt']->select()->from("gruplar")->where('id', $GLOBALS['mc_oturum']->grup)->result();
            if (!count($sorgu)) {
                m_git("/yonetici/cikis.php");
                exit;
            }
            $this->yetki[0] = $sorgu[0]->yetki;
            $this->yetki[1] = m_jsonAl($GLOBALS['mc_oturum']->izinler, 'moduler');
        }
    }

    public function menu_sec($menusec = null) {
        if (is_array($menusec)) {
            $menuCikar = $this->menu;
            foreach ($menusec as $m) {
                if (isset($menuCikar->gorev[$m])) {
                    $menuCikar = $menuCikar->gorev[$m];
                } else if (isset($menuCikar->{$m})) {
                    $menuCikar = $menuCikar->{$m};
                } else {
                    break;
                }
            }
        } else if (isset($this->menu->{$menusec})) {
            $menuCikar = $this->menu->{$menusec};
        } else {
            $menuCikar = array();
        }
        return (object)$menuCikar;
    }

    public function menu_tara($al = false) {
        $mc_menuler = [
            'genel' => [
                'baslik' => "genel", 'ikon' => "home",
                'gorev' => [
                    ['baslik' => "siteyi_goruntule", 'ikon' => "home", 'adres' => "/", 'target' => "_blank"],
                    ['baslik' => "giris_sayfasi", 'ikon' => "home", 'gorev' => "../yonetici"],
                    ['baslik' => "kullanicilar", 'ikon' => "people", 'gorev' => "kullanicilar", 'adres' => mc_sistem . "kullanicilar/", 'admin' => true],
                    ['baslik' => "kullanici_ekle", 'ikon' => "person_add", 'gorev' => "kullanicilar/ekle.php", 'adres' => mc_sistem . "kullanicilar/ekle.php", 'admin' => true],
                    ['baslik' => "gruplar", 'ikon' => "security", 'gorev' => "gruplar", 'adres' => mc_sistem . "gruplar/", 'admin' => true],
                    ['baslik' => "grup_ekle", 'ikon' => "person_add", 'gorev' => "gruplar/ekle.php", 'adres' => mc_sistem . "gruplar/ekle.php", 'admin' => true]
                ]
            ],
            'ayarlar' => [
                'baslik' => "ayarlar", 'ikon' => "settings", 'gizlilik' => 0, 'admin' => true,
                'gorev' => [
                    ['baslik' => "genel_ayarlar", 'ikon' => "device_hub", 'adres' => mc_sistem . "ayarlar/#temel_ayarlar", 'gizlilik' => 0,
                        'gorev' => [
                            ['baslik' => "temel_ayarlar", 'ikon' => "apps", 'gorev' => "ayarlar/#temel_ayarlar", 'admin' => true],
                            ['baslik' => "sayfa_ayarlari", 'ikon' => "pages", 'gorev' => "ayarlar/#sayfa_ayarlari", 'admin' => true],
                            ['baslik' => "kisisel_ayarlar", 'ikon' => "person", 'gorev' => "ayarlar/#kisisel_ayarlar"],
                            ['baslik' => "gelismis_ayarlar", 'ikon' => "perm_data_setting", 'gorev' => "ayarlar/#gelismis_ayarlar", 'admin' => true],
                            ['baslik' => "optimizasyon_ve_yedekleme", 'ikon' => "timeline", 'gorev' => "ayarlar/#optimizasyon_ve_yedekleme", 'gelistirici' => true, 'admin' => true],
                            ['baslik' => "iletisim_ve_sosyal_medya", 'ikon' => "share", 'gorev' => "ayarlar/#iletisim_ve_sosyal_medya", 'admin' => true],
                            ['baslik' => "smtp_mail_ayarlari", 'ikon' => "email", 'gorev' => "ayarlar/#smtp_mail_ayarlari", 'admin' => true],
                            ['baslik' => "izin_ayarlari", 'ikon' => "security", 'gorev' => "ayarlar/#izin_ayarlari", 'admin' => true],
                            ['baslik' => "zamanlanmis_gorevler", 'ikon' => "access_time", 'gorev' => "ayarlar/#zamanlanmis_gorevler", 'gelistirici' => true, 'admin' => true],
                            ['baslik' => "diller", 'ikon' => "translate", 'gorev' => "ayarlar/#diller", 'admin' => true],
                            ['baslik' => "guncellestirmeler_ve_bilgi", 'ikon' => "update", 'gorev' => "ayarlar/#guncellestirmeler_ve_bilgi", 'admin' => true]
                        ]
                    ],
                    ['baslik' => "temalar", 'ikon' => "view_quilt", 'gorev' => "temalar", 'adres' => mc_sistem . "temalar"],
                    ['baslik' => "tema_ekle", 'ikon' => "add_to_queue", 'gorev' => "temalar/ekle.php", 'adres' => mc_sistem . "temalar/ekle.php", 'gelistirici' => true],
                    ['baslik' => "eklentiler", 'ikon' => "widgets", 'gorev' => "eklentiler", 'adres' => mc_sistem . "eklentiler", 'admin' => true],
                    ['baslik' => "eklenti_ekle", 'ikon' => "unarchive", 'gorev' => "eklentiler/ekle.php", 'adres' => mc_sistem . "eklentiler/ekle.php", 'gelistirici' => true],
                    ['baslik' => "api_listesi", 'ikon' => "apps", 'gorev' => "m-api", 'adres' => mc_sistem . "m-api/"],
                    ['baslik' => "api_olustur", 'ikon' => "leak_add", 'gorev' => "m-api/ekle.php", 'adres' => mc_sistem . "m-api/ekle.php"],
                    ['baslik' => "ek_ozellikler", 'ikon' => "link", 'gorev' => "ekler", 'adres' => mc_sistem . "ekler/", 'gizlilik' => 2],
                    ['baslik' => "ek_ozellik_olustur", 'ikon' => "add", 'gorev' => "ekler/ekle.php", 'adres' => mc_sistem . "ekler/ekle.php", 'gizlilik' => 2]
                ]
            ],
            'dosyalar' => [
                'baslik' => "dosyalar", 'ikon' => "folder_open",
                'gorev' => [
                    ['baslik' => "tum_dosyalar", 'ikon' => "folder_open", 'adres' => mc_sistem . "dosyalar", 'izin' => "dosyalar"],
                    ['baslik' => "yeni_dosya_yukle", 'ikon' => "file_upload", 'adres' => mc_sistem . "dosyalar/yukle.php", 'izin' => "dosyalar"]
                ]
            ],
            'mesajlar' => [
                'baslik' => "mesajlar", 'ikon' => "email",
                'gorev' => [
                    ['baslik' => "tum_mesajlar", 'ikon' => "email", 'adres' => mc_sistem . "mesajlar"]
                ]
            ],
        ];

        $moduller = array_diff(scandir(m_moduller), array('..', '.'));
        foreach ($moduller as $modul) {
            if (is_dir(m_moduller . $modul) && file_exists(m_moduller . $modul . DIRECTORY_SEPARATOR . "menu.php")) {
                include m_moduller . $modul . DIRECTORY_SEPARATOR . "menu.php";
            }
        }

        $tema_plugins = m_tema . "plugins" . DIRECTORY_SEPARATOR . "yonetici" . DIRECTORY_SEPARATOR;
        if (file_exists($tema_plugins)) {
            $tema_moduller = array_diff(scandir($tema_plugins), array('..', '.'));
            foreach ($tema_moduller as $tema_modul) {
                if (is_dir($tema_plugins . $tema_modul) && file_exists($tema_plugins . $tema_modul . DIRECTORY_SEPARATOR . "menu.php")) {
                    include $tema_plugins . $tema_modul . DIRECTORY_SEPARATOR . "menu.php";
                    $tum_anahtarlar = array_keys($mc_menuler);
                    $son_anahtar = end($tum_anahtarlar);
                    $mc_menuler[$son_anahtar]['tema'] = true;
                }
            }
        }
        $dosya = fopen(m_depo . "panel-menu.php", "w");
        fwrite($dosya, '<?php ' . "if(!defined('m_guvenlik')) { exit; }\r\n" . '$mc_menuStr = \'' . json_encode($mc_menuler) . '\';');
        fclose($dosya);
    }

    public function sol_menu($ic = array()) {
        $rtn = null;
        if (is_array($ic) && !empty($ic)) {
            $donguMenu = $ic;
            $rtn .= '<ul class="ml-menu">';
            $ic_menu = true;
            $dis_li = "ic_menu";
        } else {
            $donguMenu = $this->menu;
            $ic_menu = false;
            $dis_li = "dis_menu";
        }
        foreach ($donguMenu as $sef => $menu) {
            if (isset($menu->gizlilik) && $menu->gizlilik == 1) {
                continue;
            }
            if (!m_gelistirici && isset($menu->gelistirici) && $menu->gelistirici == true) {
                continue;
            }
            if (isset($menu->admin) && $menu->admin && $GLOBALS['mc_oturum']->grup > 2) {
                continue;
            }
            if ($GLOBALS['mc_oturum']->grup > 2 && isset($menu->izin)) {
                if (mc_izin_hazirla(m_jsonAl($this->yetki[0], $menu->izin))[0] == 0 && mc_izin_hazirla(m_jsonAl($this->yetki[1], $menu->izin))[0] == 0) {
                    continue;
                }
            }
            if (isset($menu->baslik)) {
                if ($sef != "genel" && $menu->baslik != "genel" && $GLOBALS['mc_oturum']->grup > 2 && !isset($menu->izin) && !$ic_menu) {
                    if (mc_izin_hazirla(m_jsonAl($this->yetki[0], $menu->baslik))[0] == 0 && mc_izin_hazirla(m_jsonAl($this->yetki[1], $menu->baslik))[0] == 0) {
                        continue;
                    }
                }
                if (isset($GLOBALS['mc_s_dil'][$menu->baslik])) {
                    $menu_baslik = $GLOBALS['mc_s_dil'][$menu->baslik];
                } else {
                    $menu_baslik = $menu->baslik;
                }
            } else {
                $menu_baslik = mc_dil('isimsiz_menu');
            }
            if (!$ic_menu) {
                if (!isset($menu->ikon)) {
                    $menu->ikon = "list";
                }
                $menu_baslik = '<i class="material-icons">' . $menu->ikon . '</i><span>' . $menu_baslik . '</span>';
            }
            if (isset($menu->target)) {
                $menu_target = ' target = "' . $menu->target . '"';
            } else {
                $menu_target = null;
            }
            if (isset($menu->adres)) {
                $rtn .= '<li class="' . $dis_li . '">';
                if (isset($menu->adres)) {
                    $rtn .= '<a href="' . $menu->adres . '"' . $menu_target . '>' . $menu_baslik . '</a>';
                } else {
                    $rtn .= '<a href="javascript:void(0);">' . $menu_baslik . '</a>';
                }
                $rtn .= '</li>';
            } else if (isset($menu->gorev)) {
                if (is_array($menu->gorev)) {
                    $rtn .= '<li class="' . $dis_li . '"><a href="javascript:void(0);" class="menu-toggle">' . $menu_baslik . '</a>';
                    if (isset($menu->tema) && $menu->tema) {
                        $menu->gorev['tema'] = true;
                    }
                    $rtn .= $this->sol_menu($menu->gorev);
                } else {
                    if ($menu->gorev == "/") {
                        $menu_gorev = mc_panel;
                    } else if ((isset($ic['tema']) && $ic['tema']) || (isset($menu->tema) && $menu->tema)) {
                        $menu_gorev = mc_panel . "modul.php?tema=" . $menu->gorev;
                    } else {
                        $menu_gorev = mc_panel . $menu->gorev;
                    }

                    if ($menu_gorev == m_url || $menu_gorev == rtrim(m_url, "/") || m_url == rtrim($menu_gorev, "/") . "/index.php") {
                        $rtn .= '<li class="active ' . $dis_li . '">';
                    } else {
                        $rtn .= '<li class="' . $dis_li . '">';
                    }
                    $rtn .= '<a href="' . $menu_gorev . '"' . $menu_target . '>' . $menu_baslik . '</a>';
                }
                $rtn .= '</li>';
            }
        }
        if ($ic_menu) {
            $rtn .= '</ul>';
        }
        return $rtn;
    }

}
