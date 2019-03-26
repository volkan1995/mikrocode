<?php
    if(!defined('m_guvenlik')) { exit; }
    if(!isset($_POST['tip'])){ $_POST['tip'] = 0; }
    if(empty($_POST['tip']) && (!isset($_POST['klasor']) || empty($_POST['klasor']))){
        $mc_anadizinler = true;
        foreach ($tip_dizi as $dizinno => $anadizin){
            if($dizinno == 0){ continue; }
?>
        <div class="m_klasor_list">
            <a href="?tip=<?=$tip_kisadizi[$dizinno]?>" target="dir" class="oge col-blue-grey" data-id="0" data-isim="<?=$anadizin?>" data-tip="<?=$dizinno?>">
                <div class="dosya_simge"><i class="material-icons"><?php
                if($dizinno == 1){
                    echo '<i class="material-icons col-green">photo</i>';
                }elseif($dizinno == 2){
                    echo '<i class="material-icons col-red">movie</i>';
                }elseif($dizinno == 3){
                    echo '<i class="material-icons col-blue">music_note</i>';
                }elseif($dizinno == 5){
                    echo '<i class="material-icons col-grey">note</i>';
                }else{
                    echo '<i class="material-icons col-brown">folder_special</i>';
                }  
                ?></i></div>
                <div class="dosya_isim"><?=$anadizin?></div>
            </a>
        </div>
    <?php } }else{ $mc_anadizinler = false; } foreach ($klasor_tara as $klasor) { ?>
        <div class="m_klasor_list">
            <a href="?tip=<?=$tip_kisadizi[$_POST['tip']].'&klasor='.$klasor->id?>" target="dir" class="oge col-blue-grey" data-id="<?=$klasor->id?>" data-isim="<?=$klasor->baslik?>" data-tip="<?=$_POST['tip']?>">
                <div class="dosya_simge"><i class="material-icons"><?php
                        if($_POST['tip'] == 1){
                            echo 'photo_library';
                        }elseif($_POST['tip'] == 2){
                            echo 'video_library';
                        }elseif($_POST['tip'] == 3){
                            echo 'library_music';
                        }elseif($_POST['tip'] == 5){
                            echo 'library_books';
                        }else{
                            echo 'folder_open';
                        }  
                    ?></i></div>
                <div class="dosya_isim"><?=$klasor->baslik?></div>
            </a> 
            <a href="javascript:void(0);" class="sag_menu waves-effect waves-orange waves-circle" data-id="<?=$klasor->id?>" data-tip="<?=$_POST['tip']?>"><i class="material-icons">more_horiz</i></a>
        </div>
    <?php }  foreach ($dosya_tara as $dosya) { ?>
        <div class="m_klasor_list mc_liste_cbx" id="mc_liste_<?=$dosya->id?>">
            <span class="mc_chk_file"><input type="checkbox" class="chk-col-theme" data-id="<?=$dosya->id?>" id="file_cbx_<?=$dosya->id?>"/><label for="file_cbx_<?=$dosya->id?>"></label></span>
            <a href="#" target="file" class="oge col-blue-grey" data-id="<?=$dosya->id?>" data-tip="<?=$dosya->tip?>">
                <div class="dosya_simge">
                    <?php
                        if($dosya->tip == 1){
                            if(strstr($dosya->konum, '.') == ".gif"){
                                echo '<div><img class="otoload" data-src="'.m_resim($dosya->konum).'"></div>';
                            }else{
                                echo '<div><img class="otoload" data-src="'.m_resim($dosya->konum,150,70,2).'"></div>';
                            }
                        }elseif($dosya->tip == 2){
                            echo '<i class="material-icons col-red">movie</i>';
                        }elseif($dosya->tip == 3){
                            echo '<i class="material-icons col-blue">music_note</i>';
                        }else{
                            echo '<i class="material-icons col-grey">note</i>';
                        }
                    ?>
                </div>
                <div class="dosya_isim" title="<?=$dosya->baslik?>"><?=$dosya->baslik?></div>
            </a>        
        </div>
    <?php }
    if(!$mc_anadizinler && count($klasor_tara) + count($dosya_tara) == 0){
        echo "<p class='mc_dosyayok'>Bu klasörde ".$tip_kisadizi[$_POST['tip']]." yok</p>";
    }