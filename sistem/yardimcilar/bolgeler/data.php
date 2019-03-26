<?php
    if(isset($_POST['livepost']) && isset($_POST['data'])){
        
        if(is_numeric($_POST['data'])){
            
            if(file_exists($_POST['livepost']."_ilce.php")){
                
                include $_POST['livepost']."_ilce.php";
                
                if(isset($m_ilceler[$_POST['data']])){

                    if(isset($_GET['tum_ilceler']) && $_GET['tum_ilceler'] == "on"){

                        echo '<option value="">Tüm İlçeler</option>';

                    }

                    foreach ($m_ilceler[$_POST['data']] as $key => $value) {
                        
                        echo '<option value="'.$key.'">'.$value.'</option>';
                        
                    }
                    
                }
                
            }
            
        }else{

            if(isset($_GET['tum_ilceler']) && $_GET['tum_ilceler'] == "on"){

                echo '<option value="">İl Seçiniz</option>';

            }

        }
        
    }