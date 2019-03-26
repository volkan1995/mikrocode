<?php
    if(!defined('m_guvenlik')) { exit; }
    if($mc_oturum->grup < 3  || m_jsonAl($m_ayarlar->ayar,"mcykoe") != 1){
        if(isset($_POST['klasor'])){ $klasor_id = intval($_POST['klasor']); }else{ $klasor_id = 0; }

        function klasor_listele($ust = 0, $sec = 0, $syc = 0){
            global $m_vt;
            $klasorler= $m_vt->select()
                ->from("klasorler")
                ->where('ust',$ust)
                ->result();
            if(count($klasorler)){
                foreach ($klasorler as $klasor){
                    $yaz = null;
                    for ($i = 0; $i < $syc; $i++) { $yaz.= "&nbsp; &nbsp; &nbsp; "; }
                    if($sec == $klasor->id){
                        echo '<option value="'.$klasor->id.'" selected>'.$yaz.$klasor->baslik.'</option>';
                    }else{
                        echo '<option value="'.$klasor->id.'">'.$yaz.$klasor->baslik.'</option>';                
                    }
                    klasor_listele($klasor->id, $sec, $syc + 1);
                }
            }
        }

    
    ?>    
        <form id="mc_yeniklasor_form" onsubmit="mc_yeniklasor(); return false;" method="post">
            <b>Yeni Klasör Oluştur</b>
            <select name="ust_klasor" id="ust_klasor" class="form-control show-tick m-t-10" data-live-search = "true" style="width: 100%;">
                <option value="0">Ana Dizin</option>
                <?php klasor_listele(0,$klasor_id); ?>
            </select>
            <div class="form-group">
                <div class="form-line m-t-10">
                    <input type="text" class="form-control" name="klasor_isim" id="klasor_isim" placeholder="Yeni Klasör" required=""/>
                </div>
            </div>
            <input type="hidden" name="tip" value="<?=$_POST['tip']?>"/>
            <button type="submit" class="btn btn-default waves-effect">Oluştur</button>
        </form>
    <?php
    }else{
        echo "<p><u>Yeni klasör</u> oluşturma kullanıcılara yasaklanmıştır.<br/>Eğer ilgili klasör yok ise sistem yöneticinize bildiriniz.</p>";
    }