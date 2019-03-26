<?php
    if(!defined('m_guvenlik')) { exit; }
    
    require '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'yonetici' . DIRECTORY_SEPARATOR . 'loader.php';
        
    //$mc_dtd = array("y","g","v","s","a","b");

    if(empty(trim($_POST['klasor_isim']))){
        mc_uyari(-3,"<b>Başarısız</b>Lütfen klasör ismi giriniz");
    }

    $klasor_bul = $m_vt->select()
        ->from("klasorler")
        ->where('ust', $_POST['ust_klasor'])
        ->where('baslik', $_POST['klasor_isim'])
        ->result();

    if(count($klasor_bul)){
        mc_uyari(3,"<b>Başarısız</b>Aynı isimde klasör mevcut");
        exit;
    }

    $mc_kaydet = $m_vt->ekle(['table'=>"klasorler",'values'=>[
        'baslik'=>$_POST['klasor_isim'],
        'ust'=>$_POST['ust_klasor']
    ]])['sonuc'];

    if($mc_kaydet){
        echo '<script>if($("#mc_yeniklasor_btn").lenght > 0){ $("#mc_yeniklasor_btn").trigger("click"); }else{ { $("#m_yeniklasor_btn").trigger("click"); } } </script>';
        $klasor_bul = $m_vt->select()
            ->from("klasorler")
            ->where('ust', $_POST['ust_klasor'])
            ->where('baslik', $_POST['klasor_isim'])
            ->result();
        if(count($klasor_bul)){
            $klasor_bul = $klasor_bul[0];
            ?>
            <div class="mc_klasor_list m_klasor_list">
                <a href="#" target="dir" data-id="<?=$klasor_bul->id?>" data-isim="<?=$klasor_bul->baslik?>" data-tip="<?=$klasor_bul->tip?>" class="oge col-blue-grey">
                    <div class="dosya_simge"><i class="material-icons"><?php
                        if($klasor_bul->tip == 1){
                            echo 'photo_library';
                        }elseif($klasor_bul->tip == 2){
                            echo 'video_library';
                        }elseif($klasor_bul->tip == 3){
                            echo 'library_music';
                        }elseif($klasor_bul->tip == 5){
                            echo 'library_books';
                        }else{
                            echo 'folder_open';
                        }  
                    ?></i></div>
                    <div class="dosya_isim"><?=$klasor_bul->baslik?></div>
                </a>
            <a href="javascript:void(0);" class="sag_menu waves-effect waves-orange waves-circle" data-id="<?=$klasor_bul->id?>" data-tip="<?=$klasor_bul->tip?>"><i class="material-icons">more_horiz</i></a>
            </div>
            <?php
            mc_uyari(1,"<b>Başarılı</b>Yeni klasör oluşturuldu");
            exit;
        }
    }

    mc_uyari(4,"<b>Başarısız</b>Yeni klasör bir sebepten dolayı oluşturulamadı");

    exit;