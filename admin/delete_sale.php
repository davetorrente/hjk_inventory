<?php
  require_once('../includes/load.php');
  $d_sale = find_by_id('sales',(int)$_GET['id']);
  $d_product = find_by_id('products',(int)$d_sale['product_id'])['name'];
  if(!$d_sale){
    $session->msg("d","Missing sale id.");
    redirect('/admin/sales/');
  }
  $delete_id = delete_by_id('sales',(int)$d_sale['id']);
  if($delete_id){
      log_history('Sale of '.$d_product.' with quantity '.$d_sale['qty'].' and total of &#8369;'.$d_sale['price'].' has been deleted');
      $session->msg("s","sale deleted.");
      redirect('/admin/sales/');
  } else {
      $session->msg("d","sale deletion failed.");
      redirect('/admin/sales/');
  }
?>
