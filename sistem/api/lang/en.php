<?php
    if(!defined('m_guvenlik')) { exit; }
    
    function HttpStatus($code) {
	$status = array(
        0 => 'Success',  
        1 => 'Unauthorized Access',  
        2 => 'Unauthorized Transaction',
        3 => 'Bad Request');   
        return $status[$code] ? $status[$code] : $status[500];
    }
    
    $mapi_dil[0] = "Unknown request type";
    $mapi_dil[1] = "Invalid identification information";
    $mapi_dil[2] = "Hourly trading limit reached";
    $mapi_dil[3] = "Remaining time";
    $mapi_dil[4] = "This service has been temporarily removed from use";
    $mapi_dil[5] = "Invalid domain name or username";
    $mapi_dil[6] = "The requested data was not provided for the Select query";
    $mapi_dil[7] = "Select query not provided";
    $mapi_dil[8] = "We do not have access to the users table";
    $mapi_dil[9] = "All columns can not be withdrawn, please specify the columns you wish to withdraw";
    $mapi_dil[10] = "Password access is not allowed";
    $mapi_dil[11] = "min";
    $mapi_dil[12] = "If you are receiving this message, your API service is running";
    $mapi_dil[13] = "We do not have access to this service";
    $mapi_dil[14] = "To access the API service from 3rd party applications, turn on developer mode.";