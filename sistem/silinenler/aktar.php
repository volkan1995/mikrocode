<?php

if (empty($_POST['mcp_adres']) || empty($_POST['mcp_tip'])) {
    exit;
}

require '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'yonetici' . DIRECTORY_SEPARATOR . 'loader.php';

$mc_post['mcp_adres'] = $_POST['mcp_adres'];

$mc_post['mcp_tip'] = $_POST['mcp_tip'];

unset($_POST['mcp_adres'], $_POST['mcp_tip']);

if (isset($_POST['kaydet'])) {

    if (file_exists(m_sistem . "silinenler" . DIRECTORY_SEPARATOR . "functions" . DIRECTORY_SEPARATOR . $mc_post['mcp_adres'] . ".php")) {

        unset($_POST['kaydet']);

        require m_sistem . "silinenler" . DIRECTORY_SEPARATOR . "functions" . DIRECTORY_SEPARATOR . $mc_post['mcp_adres'] . ".php";

        exit;
    }
}

if (file_exists(m_sistem . "silinenler" . DIRECTORY_SEPARATOR . $mc_post['mcp_adres'] . ".php")) {

    $mc_ayar_kayit_btn = true;

    require m_sistem . "silinenler" . DIRECTORY_SEPARATOR . $mc_post['mcp_adres'] . ".php";

    if ($mc_ayar_kayit_btn == true) {
        echo '<script> $(".settings-footer").html("<button type=\"submit\" class=\"btn btn-sm btn-theme waves-effect\">' . mc_dil('kaydet') . '</button>"); </script>';
    } else {
        echo '<script> $(".settings-footer").empty(); </script>';
    }
} else {

    echo "<p class='col-red m-t-10'><b>" . $mc_post['mcp_adres'] . ".php dosyası silinenler konumunda bulunamadı!</b></p>";

    echo '<script> $(".settings-footer").empty(); </script>';
}

exit;
