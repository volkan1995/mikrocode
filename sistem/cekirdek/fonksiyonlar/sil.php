<?php

function m_sqliteKaydet($dizi = array()) {
    if (!defined('mc_oturum_id') || !isset($dizi['tablo']) || !is_array($dizi)) {
        return false;
    }
    if (isset($dizi['data']) && (is_array($dizi['data'])) && isset($dizi['data'][0]['id'])) {
        $msl3_baglan = new SQLite3(m_depo . "sqlite" . DIRECTORY_SEPARATOR . mdb_name . ".db");
        $result_dizi = array();
        foreach ($dizi['data'] as $data) {
            $data['sql3_tarih'] = date("Y-m-d H:i:s");
            $data['sql3_kullanici'] = mc_oturum_id;
            $data['sql3_ip'] = m_getip();
            $msl3_tablo = $msl3_baglan->query("SELECT COUNT(*) as count FROM '{$dizi['tablo']}' WHERE id = {$data['id']};");
            $msl3_result = $msl3_tablo->fetchArray();
            $msl3_rows = $msl3_result['count'];
            if ($msl3_rows > 0) {
                $result_dizi[] = $data['id'];
                continue;
            }
            $msl3_columns = implode(",", array_keys($data));
            $msl3_glues = null;
            foreach ($data as $key => $value) {
                $msl3_glues .= ":$key,";
            }
            $msl3_glues = rtrim($msl3_glues, ",");
            $msl3_insert = $msl3_baglan->prepare("INSERT INTO '{$dizi['tablo']}' ({$msl3_columns}) VALUES ({$msl3_glues})");
            $msl3_sayac = 1;
            foreach ($data as $key => $value) {
                $msl3_insert->bindValue(":$key", $value, SQLITE3_TEXT);
                $msl3_sayac++;
            }
            if ($msl3_insert->execute()) {
                $result_dizi[] = $data['id'];
            }
        }
        $msl3_baglan->close();
        unset($msl3_baglan);
        return $result_dizi;
    } else {
        return false;
    }
}

function m_xmlKaydet($dizi = array()) {
    if (!defined('mc_oturum_id') || !isset($dizi['tablo']) || !is_array($dizi)) {
        return false;
    }
    if (!mc_klasor_olustur(m_depo . "cop-kutusu" . DIRECTORY_SEPARATOR) || !mc_klasor_olustur(m_depo . "cop-kutusu" . DIRECTORY_SEPARATOR . "yazilar")) {
        return false;
    }
    $xml_knm = m_depo . "cop-kutusu" . DIRECTORY_SEPARATOR . "yazilar" . DIRECTORY_SEPARATOR . $dizi['tablo'] . ".xml";
    if (!mc_dosya_olustur($xml_knm, '<?xml version="1.0" encoding="UTF-8"?><values></values>')) {
        return false;
    }
    if (isset($dizi['id']) && isset($dizi['data']) && (is_array($dizi['data']))) {
        $dizi['data']['xml_tarih'] = date("Y-m-d H:i:s");
        $dizi['data']['xml_kullanici'] = mc_oturum_id;
        $dizi['data']['xml_ip'] = m_getip();
        $xml = simplexml_load_file($xml_knm);
        $xml_tf = false;
        foreach ($xml->value as $v) {
            if ($v['id'] == $dizi['id']) {
                foreach ($dizi['data'] as $k => $v1) {
                    $v->$k = $v1;
                }
                $xml_tf = true;
                break;
            }
        }
        if (!$xml_tf) {
            $xml = new SimpleXMLElement($xml->asXML());
            $tum_base64 = array("aciklama", "icerik", "eklenti");
            foreach ($dizi['data'] as $key => $value) {
                if (!$xml_tf) {
                    $xml_addurl = $xml->addChild('value');
                    $xml_addurl->addAttribute('id', $dizi['id']);
                    $xml_tf = true;
                }
                if (in_array($key, $tum_base64)) {
                    $xml_addurl->addChild($key, base64_encode($value));
                } else {
                    $xml_addurl->addChild($key, $value);
                }
            }
        }
        $xml->asXML($xml_knm);
        return true;
    } else {
        return false;
    }
}