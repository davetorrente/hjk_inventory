<?php
    require_once('../includes/load.php');;
    $categorie = find_by_id('categories',(int)$_GET['id']);
    if(!$categorie){
      $session->msg("d","Missing Categorie id.");
      redirect('/admin/category/');
    }
    $delete_id = delete_by_id('categories',(int)$categorie['id']);
    if($delete_id){
        log_history('Category '.$categorie['name'].' has been deleted');
        $session->msg("s","Category deleted.");
        redirect('/admin/category/');
    } else {
        $session->msg("d","Category deletion failed.");
        redirect('/admin/category/');
    }
?>
