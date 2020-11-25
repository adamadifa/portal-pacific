<?php

function check_login(){

    $CI             = & get_instance();
    $namalengkap    = $CI->session->userdata('nama_lengkap');
    $level_user     = $CI->session->userdata('level_user');
    
    if(empty($level_user)){
        
        redirect('auth/login');
    }
    

}



function check_log(){

    $CI         = & get_instance();
    $session    = $CI->session->userdata('level_user');
    if (!empty($session)){
        //echo $session;
        redirect('dashboard');
    }

}




