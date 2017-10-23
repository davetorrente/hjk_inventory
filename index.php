<?php
    ob_start();
    require_once('includes/load.php');
    if($session->isUserLoggedIn(true)){
        redirect('/admin/dashboard/', false);
    }else{
        redirect('/auth/login/', false);
    }
?>
