<?php
    if(!defined('m_guvenlik')) { exit; }
    
    require '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'yonetici' . DIRECTORY_SEPARATOR . 'loader.php';
    
    if(!isset($_POST['id']) || empty($_POST['id'])){ exit; }
    if(!isset($_POST['aktarid']) || empty($_POST['aktarid'])){ exit; }
    if(!isset($_POST['aktarname']) || empty($_POST['aktarname'])){ exit; }
    
    if(!is_numeric($_POST['id'])){
        if(!is_array($_POST['id'])){ $_POST['id'] = json_decode($_POST['id']); }
    
        $dosya_bul = $m_vt->select()
            ->from("dosyalar")
            ->inwhere('id', $_POST['id'])
            ->result();
        
    }else{
        $dosya_id = intval($_POST['id']);
    
        $dosya_bul = $m_vt->select()
            ->from("dosyalar")
            ->where('id', $dosya_id)
            ->result();
    }

    if(!count($dosya_bul)){ echo "Dosya bulunamadı"; exit; }
    
    foreach ($dosya_bul as $dosya) {
        if($mcd_coklu == 1){
            $mcd_cs_rg = "215";
            echo '<li class="mc_surukleb_item mcd_secili_'.$dosya->id.'"><div class="mcd_secili">';
            if(isset($_POST['detay']) && $_POST['detay'] == 1){
                echo '<div class="mcd_gd"><button class="btn btn-xs btn-default waves-effect" role="button" data-toggle="collapse" href="#mc_gdty'.$dosya->id.'" aria-expanded="false" aria-controls="mc_gdty'.$dosya->id.'">
                    <i class="material-icons">drag_handle</i></button><div class="collapse" id="mc_gdty'.$dosya->id.'" aria-expanded="false">
                    <input type="text" class="form-control" style="margin-bottom:3px;" name="'.$_POST['aktarname'].'['.$dosya->id.'][b]" placeholder="Başlık"/>
                    <input type="text" class="form-control" style="margin-bottom:3px;" name="'.$_POST['aktarname'].'['.$dosya->id.'][a]" placeholder="Açıklama"/>
                    <input type="text" class="form-control" style="margin-bottom:3px;" name="'.$_POST['aktarname'].'['.$dosya->id.'][u]" placeholder="Adres"/>
                    <input type="text" class="form-control" name="'.$_POST['aktarname'].'['.$dosya->id.'][y]" placeholder="Adres Yazısı"/>
                    </div></div>';
            }else{
                $_POST['detay'] = 0;
            }
        }else{
            $mcd_cs_rg = "250";
            echo '<div class="mcd_secili mcd_secili_'.$dosya->id.'">';        
        }
        echo '<div class="mcd_baslik"><span title="'.$dosya->baslik.'">'.$dosya->baslik.'</span><i class="mcd_kapat material-icons">close</i></div>';
        if($dosya->tip == 1){ ?>
            <div style="text-align: center">
                <img src="<?=m_resim($dosya->konum,$mcd_cs_rg,175,2)?>" class="img-responsive">
            </div>
        <?php }elseif($dosya->tip == 2){ ?>
            <video controls preload="metadata" poster="" class="m-t-5" style="width:100%;">
                <source src="<?=m_domain."/dosyalar".$dosya->konum?>" type="video/mp4">Tarayıcı desteği yok
            </video>
        <?php }elseif($dosya->tip == 3){ ?>
            <audio preload="metadata" src="<?=m_domain."/dosyalar".$dosya->konum?>">Desteklenmiyor</audio>
        <?php }
        if($mcd_coklu == 1){
            if($_POST['detay'] == 0){
                echo '<input type="hidden" class="mcd_values" name="'.$_POST['aktarname'].'['.$dosya->id.']" value="'.$dosya->id.'"/></div></li>';
            }
        }else{
            echo '<input type="hidden" class="mcd_values" name="'.$_POST['aktarname'].'" value="'.$dosya->id.'"/></div>';
        }
    }
    exit;