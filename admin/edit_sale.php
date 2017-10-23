<?php
  $page_title = 'Edit sale';
  require_once('../includes/load.php');
  include_once('../layouts/header.php');
?>
<?php
$sale = find_by_id('sales',(int)$_GET['id']);
if(!$sale){
  $session->msg("d","Missing product id.");
  redirect('/admin/sales/');
}
?>
<?php $product = find_by_id('products',$sale['product_id']); ?>
<?php

  if(isset($_POST['update_sale'])){
    $req_fields = array('title','quantity','price','total', 'date' );
    validate_fields($req_fields);
        if(empty($errors)){
          $p_id      = (int)$product['id'];
          $s_qty     = (int)$_POST['quantity'];
          $s_total   = $_POST['total'];
          $date      = $_POST['date'];
          $s_date    = date("Y-m-d", strtotime($date));

          $sql  = "UPDATE sales SET";
          $sql .= " product_id= '{$p_id}',quantity={$s_qty},price='{$s_total}',created='{$s_date}'";
          $sql .= " WHERE id ='{$sale['id']}'";
          $result =checkQty($p_id);
          if($s_qty <= 0){
            $session->msg('d','Quantity must be greater than 0!');
            redirect('/admin/edit_sale/?id='.$sale['id'], false);
          }
          if($s_qty > $result && $s_qty != $sale['quantity'] ){
            $session->msg('d','Not enough stock!');
            redirect('/admin/edit_sale/?id='.$sale['id'], false);
          }
          $database->query($sql);
          $database->execute();
          if($database->rowCount() === 1){
            if($result == 0){
              $s_qty = 0;
            }
            $prod_name = update_product_qty($s_qty,$p_id);
            log_history('Sales Product '.$prod_name.' with quantity '.$s_qty.', and total of &#8369;'.$s_total.' has been added');
            $session->msg('s',"Sale updated.");
            redirect('/admin/sales/', false);
          } else {
            $session->msg('d',' Sorry failed to updated!');
            redirect('/admin/sales/', false);
          }
        } else {
           $session->msg("d", $errors);
           redirect('/admin/edit_sale/id='.(int)$sale['id'],false);
        }
  }

?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
  <div class="panel">
    <div class="panel-heading clearfix">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>All Sales</span>
     </strong>
     <div class="pull-right">
       <a href="/admin/sales/" class="btn btn-primary">Show all sales</a>
     </div>
    </div>
    <div class="panel-body">
       <table class="table table-bordered">
         <thead>
          <th> Product name </th>
          <th> Qty </th>
          <th> Price </th>
          <th> Total </th>
          <th> Date</th>
          <th> Action</th>
         </thead>
           <tbody  id="product_info">
              <tr>
              <form method="post" action="/admin/edit_sale/?id=<?php echo (int)$sale['id']; ?>">
                <td id="s_name">
                  <input type="text" class="form-control" id="sug_input" name="title" value="<?php echo remove_junk($product['name']); ?>">
                  <div id="result" class="list-group"></div>
                </td>
                <td id="s_qty">
                  <input type="text" class="form-control" name="quantity" value="<?php echo (int)$sale['quantity']; ?>">
                </td>
                <td id="s_price">
                  <input type="text" class="form-control" name="price" value="<?php echo remove_junk($product['sale_price']); ?>">
                </td>
                <td>
                  <input type="text" class="form-control" name="total" value="<?php echo remove_junk($sale['price']); ?>">
                </td>
                <td id="s_date">
                  <input type="date" class="form-control datepicker" name="date" data-date-format="" value="<?php echo remove_junk($sale['created']); ?>">
                </td>
                <td>
                  <button type="submit" name="update_sale" class="btn btn-primary">Update sale</button>
                </td>
              </form>
              </tr>
           </tbody>
       </table>

    </div>
  </div>
  </div>

</div>

<?php include_once('../layouts/footer.php'); ?>
