<?php
  require_once('../includes/load.php');
?>
<?php
  $product = find_by_id('products',(int)$_GET['id']);
  if(!$product){
    $session->msg("d","Missing Product id.");
    redirect('/admin/product/');
  }
?>
<?php
  $delete_id = delete_by_id('products',(int)$product['id']);
  if($delete_id){
      log_history('Product '.$product['name'].' has been deleted');
      $session->msg("s","Products deleted.");
      redirect('/admin/product/');
  } else {
      $session->msg("d","Products deletion failed.");
      redirect('/admin/product/');
  }
?>
