<?php
if (!defined('mdb_guvenlik')) {
    exit;
}
class m_select{
    /* SELECT columns FROM table where groupby orderby limit */    
    protected $baglan; // Bağlantıyı saklar
    protected $durum = null; // Akışı saklar
    protected $sart = null; // Şartı(where) saklar
    protected $veriler = array(); // Şart verilerini(values) saklar    
    protected $columns = null; // Sütunları(columns) saklar
    protected $frm = null; // Tabloyo(from) saklar
    protected $orb = null; // Sıralamayı(Order by) saklar
    protected $grb = null; // Gruplamayı(Group by) saklar
    protected $lmt = null; // Sınırı(limit) saklar
    protected $syc = 0; // Sınırı(limit) saklar
    
    public function __construct($a,$b = "*"){
        $this->baglan = $a;
        $this->columns = $b;
        if($this->columns == null){ $this->durum = "Çekilecek sütunların belirtilmesi gerekiyor"; }
    }
    
    public function __clone(){ }
    
    public function where($k = null, $v = null, $o = "=", $b = null){
        if($k != null && !is_null($v) && $o != null){
            if($b != null){ $b = " $b"; }else{ if(count($this->veriler) && substr($this->sart, -1) != "("){ $b = " AND"; } }
            $k = "`".str_replace(["`","'",'"','.'],"",$k)."`";
            $this->sart .= "$b $k $o ?";
            $this->veriler[] = $v;
        }else{ $this->durum = "Koşullarda, aşağıdaki özelliklerin eksiksiz sağlanması gerekiyor.<br/>1) Sütun ismi<br/>2) Karşılaştırılacak veri<br/>3) Karşılaştırma oparatörü"; }
        return $this;
    }
    
    public function inwhere($k = null, $v = null, $b = null){
        if($k != null && is_array($v)){
            if($b != null){ $b = " $b"; }else{ if(count($this->veriler) && substr($this->sart, -1) != "("){ $b = " AND"; } }
            $k = "`".str_replace(["`","'",'"','.'],"",$k)."`";
            $this->sart .= "$b $k IN (";
            foreach ($v as $s) {
                $this->sart .= "?,";
                $this->veriler[] = $s;
            }
            $this->sart = rtrim($this->sart, ",").")";
        }else{ $this->durum = "Koşullarda, aşağıdaki özelliklerin eksiksiz sağlanması gerekiyor.<br/>1) Sütun ismi<br/>2) Karşılaştırılacak veri<br/>3) Karşılaştırma oparatörü"; }
        return $this;
    }
    
    public function from($d = null){
        $this->frm = "`".str_replace(["`","'",'"','.'],"",$d)."`";
        return $this;
    }
    
    public function like($k = null, $v = null, $b = null){
        if($k != null && !is_null($v)){
            if($b != null){ $b = " $b"; }else{ if(count($this->veriler) && substr($this->sart, -1) != "("){ $b = " AND"; } }
            $k = "`".str_replace(["`","'",'"','.'],"",$k)."`";
            $this->sart .= "$b $k LIKE ?";
            $this->veriler[] = '%'.str_replace("%","",$v).'%';
        }else{ $this->durum = "Aramada, aşağıdaki özelliklerin eksiksiz sağlanması gerekiyor.<br/>1) Sütun ismi<br/>2) Aranacak veri"; }
        return $this;
    }
    
    public function notlike($k = null, $v = null, $b = null){
        if($k != null && !is_null($v)){
            if($b != null){ $b = " $b"; }else{ if(count($this->veriler) && substr($this->sart, -1) != "("){ $b = " AND"; } }
            $k = "`".str_replace(["`","'",'"','.'],"",$k)."`";
            $this->sart .= "$b $k NOT LIKE ?";
            $this->veriler[] = '%'.str_replace("%","",$v).'%';
        }else{ $this->durum = "Aramada, aşağıdaki özelliklerin eksiksiz sağlanması gerekiyor.<br/>1) Sütun ismi<br/>2) Aranacak veri"; }
        return $this;
    }
    
    public function groupby($d = null){
        if($d != null){
            $this->grb = " GROUP BY $d";
        }
        return $this;
    }
    
    public function orderby($d = null, $s = "ASC"){
        if($d != null){
            if(is_array($s)){
                $y = null;
                foreach ($s as $v){ $y = $y.intval($v).","; }
                $y = rtrim($y, ",");
                $this->orb = " ORDER BY FIELD(`$d`, $y)";
            }else{
                $this->orb = " ORDER BY $d $s";
            }            
        }
        return $this;
    }
    
    public function limit($d = null, $p = false){
        if(is_numeric($d) && $d > 0){
            if($p != false){
                if(isset($_GET[$p])){ $_GET[$p] = intval($_GET[$p]); }else{ $_GET[$p] = 0; }
                if($_GET[$p] > 0) { $_GET[$p] -= 1; }
                $d = ($d * $_GET[$p]).', '.$d;
            }
            $this->lmt = " LIMIT $d";            
        }
        return $this;
    }
    
    public function in($b = null){
        if($b != null){ $b = " $b "; }
        $this->sart .= "{$b}(";
        $this->syc += 1;
        return $this;
    }
    
    public function out(){
        $this->sart .= " )";
        $this->syc -= 1;
        return $this;
    }
    
    public function write($print = true){
        if($this->sart != null){ $this->sart = " WHERE ".$this->sart; }
        if($this->syc > 0){ for ($i = 0; $i < $this->syc; $i++) { $this->sart .= " )"; } }
        if($print){
            echo "SELECT ".$this->columns." FROM ".$this->frm.$this->sart.$this->grb.$this->orb.$this->lmt;
            echo "<br/><pre>";
            print_r($this->veriler);
            echo "</pre>";
            exit;
        }else{
            return array('q' => "SELECT ".$this->columns." FROM ".$this->frm.$this->sart.$this->grb.$this->orb.$this->lmt, 'v' => $this->veriler);
        }
    }
    
    public function result($obj = true){
        if($this->frm == null){ $this->durum = "Tablo ismi girilmesi gerekiyor"; }        
        if($this->durum == null){
            if($this->sart != null){ $this->sart = " WHERE ".$this->sart; }
            if($this->syc > 0){ for ($i = 0; $i < $this->syc; $i++) { $this->sart .= " )"; } }
            $sorgu = $this->baglan->prepare("SELECT ".$this->columns." FROM ".$this->frm.$this->sart.$this->grb.$this->orb.$this->lmt);
            $sorgu->execute($this->veriler);
            if($sorgu && $sorgu->rowCount()>0){
                if($obj){ return $sorgu->fetchAll(PDO::FETCH_OBJ); }
                else{ return $sorgu->fetchAll(PDO::FETCH_ASSOC); }
            }else{ return array(); }
        }else{
            echo "<p class='col-red'><b><i>SELECT</i> Sorgusu Hatası</b><br/></p><p class='m-t-5'>".$this->durum."</p>";
            exit;
        }
    }
    
    public function count(){
        if($this->frm == null){ $this->durum = "Tablo ismi girilmesi gerekiyor"; }        
        if($this->durum == null){
            if($this->sart != null){ $this->sart = " WHERE ".$this->sart; }
            if($this->syc > 0){ for ($i = 0; $i < $this->syc; $i++) { $this->sart .= " )"; } }
            $sorgu = $this->baglan->prepare("SELECT COUNT(`id`) as m_toplam FROM ".$this->frm.$this->sart.$this->grb.$this->orb.$this->lmt);
            $sorgu->execute($this->veriler);
            if($sorgu && $sorgu->rowCount()>0){ return $sorgu->fetchAll(PDO::FETCH_OBJ)[0]->m_toplam; }else{ return 0; }
        }else{
            echo "<p class='col-red'><b><i>SELECT</i> Sorgusu Hatası</b><br/></p><p class='m-t-5'>".$this->durum."</p>";
            exit;
        }
    }
    
    public function delete(){
        if($this->frm == null){ $this->durum = "Tablo ismi girilmesi gerekiyor"; }        
        if($this->durum == null){
            if($this->sart != null){ $this->sart = " WHERE ".$this->sart; }
            if($this->syc > 0){ for ($i = 0; $i < $this->syc; $i++) { $this->sart .= " )"; } }
            if($this->frm == "`dosyalar`"){
                $sorgusil = false;
                $sorgu = $this->baglan->prepare("SELECT * FROM ".$this->frm.$this->sart.$this->lmt);
                $sorgu->execute($this->veriler);
                if($sorgu && $sorgu->rowCount()>0){
                    $sorgusil = true;
                    foreach ($sorgu->fetchAll(PDO::FETCH_OBJ) as $dosya) {
                        $konum = m_dosyalar.ltrim($dosya->konum, DIRECTORY_SEPARATOR);
                        $silonay = true;
                        if(file_exists($konum) &&!unlink($konum)){ $silonay = false; } 
                        if($silonay && $sorgusil){
                            $sorgusil = $this->baglan->prepare("DELETE FROM `dosyalar` WHERE `id` = ?");
                            $sorgusil->execute([$dosya->id]);
                        }
                    }
                }
            }else{
                $sorgusil = $this->baglan->prepare("DELETE FROM ".$this->frm.$this->sart.$this->lmt);
                $sorgusil->execute($this->veriler); 
            }
            if($sorgusil){ return true; }
        }else{
            echo "<p class='col-red'><b><i>DELETE</i> Sorgusu Hatası</b><br/></p><p class='m-t-5'>".$this->durum."</p>";
            exit;
        }
        return false;
    }
}
class m_baglan{
    protected $baglan; // Bağlantıyı saklar
    protected $port = null; // portu tutar 
    public $durum = false; // Bağlantı durumu

    /* Bağlantıyı yap */
    public function __construct(){
        if(defined('mdb_server') && defined('mdb_name') && defined('mdb_user') && defined('mdb_pass') && defined('mdb_driver') && defined('mdb_ctype') && defined('mdb_port')){
            if(mdb_ctype == "pdo"){
                try {
                    if(mdb_port > 0){ $this->port = ";port=".mdb_port; }
                    $this->baglan = new PDO(mdb_driver.":host=".mdb_server.$this->port.";dbname=".mdb_name, mdb_user, mdb_pass);
                    $this->baglan->exec("SET NAMES 'utf8'; SET CHARSET 'utf8'; SET COLLATION_CONNECTION = 'utf8_general_ci'; SET sql_mode=''");  
                    $this->kontrol = true;
                }catch(PDOException $e){
                    $this->kontrol = false;
                    echo "PDO Hata: ".$e->getMessage();
                    return false;
                }
            }else if(mdb_ctype == "mysqli"){
                $this->kontrol = false;
                echo "Bağlanti tipi: ".mdb_ctype;
                return false;
            }else if(mdb_ctype == "mysql"){
                $this->kontrol = false;
                echo "Bağlanti tipi: ".mdb_ctype;
                return false;
            }else{
                $this->kontrol = false;
                echo "Bağlanti tipi tanınamadı: ".mdb_ctype;
                return false;
            }
        }else{
            $this->kontrol = false;
            return false;
        }
    }
    
    public function select($sutun = "*"){
        return new m_select($this->baglan, $sutun);
    }
    
    public function son_id(){
        return $this->baglan->lastInsertId();        
    }
    
    // Veri Çek
    public function sec($sorgu = array()){          
        $y = new m_select($this->baglan);
        if(isset($sorgu['columns'])){ $y->columns($sorgu['columns']); }
        if(isset($sorgu['table'])){ $y->from($sorgu['table']); }
        if(isset($sorgu['limit'])){ $y->limit($sorgu['limit']); }
        if(isset($sorgu['write'])){ $y->write($sorgu['write']); }
        if(isset($sorgu['orderby'])){ $y->orderby($sorgu['orderby']); }
        if(isset($sorgu['groupby'])){ $y->groupby($sorgu['groupby']); }
        if(isset($sorgu['where']) && is_array($sorgu['where'])){ foreach ($sorgu['where'] as $k => $v) { $y->where($k,$v); } }
        return $y->result();
    }
    
    // Veri Ekle
    public function ekle($sorgu = array()){
        $return = array('sonuc' => false, 'mesaj' => null, 'id' => 0);
        if(is_array($sorgu) && isset($sorgu['table']) && isset($sorgu['values']) && is_array($sorgu['values'])){
            $sql1 = null;
            $sql2 = null;
            foreach ($sorgu['values'] as $column => $value) {
                $sql1 .= "`".str_replace(["`","'",'"','.'],"",$column)."`, ";
                $sql2 .= ":$column, ";
            }
            $sql = "INSERT INTO `".str_replace(["`","'",'"','.'],"",$sorgu['table'])."` (".rtrim(rtrim($sql1),",").") VALUES (".rtrim(rtrim($sql2),",").")";
            $mc_sorgu = $this->baglan->prepare($sql);
            if($mc_sorgu->execute($sorgu['values'])){
                $return['id'] = $this->baglan->lastInsertId();
                $return['sonuc'] = true;
            }else{
                $return['mesaj'] = $this->baglan->errorInfo();                
            }
        }
        return $return;
    }
    
    // Veri Güncelle
    public function guncelle($sorgu = array()){
        $return = array('sonuc' => false, 'mesaj' => null);
        if(is_array($sorgu) && isset($sorgu['table']) && isset($sorgu['values']) && is_array($sorgu['values']) && isset($sorgu['where']) && is_array($sorgu['where'])){
            $sql1 = null;
            foreach ($sorgu['values'] as $column => $value) {
                $sql1 .= "`".str_replace(["`","'",'"','.'],"",$column)."` = :$column, ";
            }
            $where_key = null;
            $where_val = null;
            foreach ($sorgu['where'] as $key => $value) {
                $where_key = $key;
                $where_val = $value;
                break;
            }
            if(!isset($sorgu['sart'])){ $sorgu['sart'] = "="; }
            $sorgu['sart'] = str_replace(["`","'",'"','.'],"",$sorgu['sart']);
            $sorgu['values']['mcwheresart'] = $where_val;
            $sql = "UPDATE `".str_replace(["`","'",'"','.'],"",$sorgu['table'])."` SET ".rtrim(rtrim($sql1),",")." WHERE `".str_replace(["`","'",'"','.'],"",$where_key)."` ".$sorgu['sart']." :mcwheresart";
            $mc_sorgu = $this->baglan->prepare($sql);
            if($mc_sorgu->execute($sorgu['values'])){ $return['sonuc'] = true; }else{ $return['mesaj'] = $this->baglan->errorInfo(); }
        }
        return $return;
    }
    
    // Veri Ara
    public function ara(){}
    
    // Manuel Sorgu
    public function sorgu($sql = null, $val = array(), $obj = true){
        if(is_array($val) && count($val)){            
            $sorgu = $this->baglan->prepare($sql);
            $sorgu->execute($val);
        }else{
            if(is_bool($val)){ $obj = $val; }
            $sorgu = $this->baglan->query($sql);
        }
        if($sorgu && $sorgu->rowCount()>0){
            if($obj){ return $sorgu->fetchAll(PDO::FETCH_OBJ); }
            else{ return $sorgu->fetchAll(PDO::FETCH_ASSOC); }
        }else{ return array(); }
    }    
    
    public function sortby($sorgu = array()){
        $return = array('sonuc' => false, 'mesaj' => null);
        if(is_array($sorgu) && isset($sorgu['table']) && isset($sorgu['sort'])){
            $jsn = json_decode($sorgu['sort'],true);
            if(count($jsn)){
                $sorgu['table'] = str_replace(["`","'",'"','.'],"",$sorgu['table']);
                if(!isset($sorgu['id'])){ $sorgu['id'] = "id"; }else{ $sorgu['id'] = str_replace(["`","'",'"','.'],"",$sorgu['id']); }
                if(isset($sorgu['parent'])){ $sorgu['parent'] = str_replace(["`","'",'"','.'],"",$sorgu['parent']); $sorgu_prnt = true;}else{ $sorgu_prnt = false; }
                if(!isset($sorgu['order'])){ $sorgu['order'] = "sira"; }else{ $sorgu['order'] = str_replace(["`","'",'"','.'],"",$sorgu['order']); }
                if(!$sorgu_prnt){
                    $sql = "SELECT `{$sorgu['id']}`,`{$sorgu['order']}` FROM `{$sorgu['table']}`";
                }else{
                    $sql = "SELECT `{$sorgu['id']}`,`{$sorgu['parent']}`,`{$sorgu['order']}` FROM `{$sorgu['table']}`";
                }
                $sqlsorgu = $this->baglan->query($sql);
                if($sqlsorgu->rowCount()>0){
                    $fdb = array();
                    foreach ($sqlsorgu->fetchAll(PDO::FETCH_ASSOC) as $v) {
                        $fdb[$v['id']] = ['ust' => 0,'sira'=>$v[$sorgu['order']]];
                        if($sorgu_prnt){ $fdb[$v['id']]['ust'] = $v[$sorgu['parent']]; }
                    }
                    function sirala($dizi,$ust){ 
                        $rtn_dizi = array();     
                        foreach($dizi as $head => $body){
                            $head++;
                            $rtn_dizi[$body['id']] = ['ust'=>$ust,'sira'=>$head]; 
                            if(isset($body['children'])){ $rtn_dizi = $rtn_dizi + sirala($body['children'],$body['id']); }
                        }
                        return $rtn_dizi;
                    }
                
                    $pdb = sirala($jsn,'0');
                    $tdb = array();
                    foreach($pdb as $key => $value){
                        if(!array_key_exists($key,$fdb) || ($fdb[$key]['ust'] != $value['ust']) || ($fdb[$key]['sira'] != $value['sira'])){
                            $tdb[$key] = $value;
                        }   
                    }
                    if(count($tdb) > 0){
                        $q_ust = null;
                        $q = "UPDATE `{$sorgu['table']}`";
                        $q_sira = " SET `{$sorgu['order']}` = CASE `{$sorgu['id']}`";
                        if($sorgu_prnt){ $q_ust = " `{$sorgu['parent']}` = CASE `{$sorgu['id']}`"; }
                        $q_ids = " WHERE `{$sorgu['id']}` IN (".implode(", ",array_keys($tdb)).")";
                        foreach ($tdb as $id => $value){
                            $q_sira .= " WHEN ".$id." THEN ".$value['sira'];
                            if($sorgu_prnt){ $q_ust .= " WHEN ".$id." THEN ".$value['ust']; }                            
                        }
                        if($sorgu_prnt){ $q_sira .= " END,"; $q_ust .= " END"; }else{ $q_sira .= " END"; }
                        $q = $q.$q_sira.$q_ust.$q_ids;
                        $sqlsorgu = $this->baglan->query($q);
                        if($sqlsorgu){ $return['sonuc'] = true; }else{ $return['mesaj'] = $this->baglan->errorInfo(); }
                    }                
                }
            }else{
                $return['sonuc'] = true;
            }
            
        }
        return $return;
    }
}