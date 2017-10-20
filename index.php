<?php
    ob_start();
    require_once('includes/load.php');
    if($session->isUserLoggedIn(true)){
        redirect('./admin/dashboard.php', false);
    }else{
        redirect('./auth/login.php', false);
    }
?>
