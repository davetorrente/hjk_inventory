<?php
    require_once('../includes/load.php');;
    $media = find_by_id('medias',(int)$_GET['id']);
    if(!$media){
      $session->msg("d","Missing Media id.");
      redirect('media.php');
    }
    $delete_id = delete_by_id('medias',(int)$media['id']);
    if($delete_id){
        unlink('../assets/images/products/'.$media['file_name']);
        log_history($media['file_name'].' has been deleted');
        $session->msg("s","Media deleted.");
        redirect('media.php');
    } else {
        $session->msg("d","Media deletion failed.");
        redirect('media.php');
    }
?>
