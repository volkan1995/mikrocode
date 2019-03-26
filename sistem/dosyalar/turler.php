<?php
if(!defined('m_guvenlik')) { exit; }

$mc_engelli_u = array("php","asp","aspx","ini","html","htm","dbd","class","ocx","ops","zix");

$r_format = array ("image/jpeg","image/jpg","image/pjpeg","image/png","image/gif","image/bmp"); 

$word_format = array ("application/vnd.openxmlformats-officedocument.wordprocessingml.template",
    "application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/msword");

$excel_format = array ("application/excel","application/vnd.ms-excel",
    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
    "application/vnd.openxmlformats-officedocument.spreadsheetml.template");

$powerpoint_format = array ("application/mspowerpoint","application/vnd.ms-powerpoint",
    "application/vnd.openxmlformats-officedocument.presentationml.template",
    "application/vnd.openxmlformats-officedocument.presentationml.slideshow",
    "application/vnd.openxmlformats-officedocument.presentationml.presentation");

$pdf_format = array ("application/pdf");

$txt_format = array ("text/plain");

$access_format = array ("application/x-msaccess","application/msaccess");

$y_format = array ("application/x-msdownload", "application/exe", "application/x-exe", "application/dos-exe","vms/exe",
    "application/x-winexe", "application/msdos-windows", "application/x-msdos-program","application/x-apple-diskimage",
    "application/vnd.apple.installer+xml", "application/x-debian-package", "application/vnd.android.package-archive");

$v_format = array ("video/avi","video/mp4","video/mpeg","video/x-flv","video/mpeg","video/x-mpeg","video/x-matroska","video/webm");

$m_format = array ("audio/mp4","audio/mpeg","audio/vnd.wave","audio/mpeg3","audio/x-mpeg-3","audio/mp3","audio/x-m4a","audio/aac");

$a_format = array ("application/x-troff-man","application/zip",'application/rar','rar',
    "application/x-zip-compressed","multipart/x-zip","application/x-compressed",
    "application/octet-stream","application/x-rar-compressed","compressed/rar","application/x-rar");

$g_format = array_merge($r_format, $y_format, $m_format, $v_format, $a_format, $txt_format,
        $access_format, $word_format, $excel_format, $powerpoint_format, $pdf_format);