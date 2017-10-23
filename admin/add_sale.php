<?php
    $page_title = 'Add Sale';
    require_once('../includes/load.php'); 
    include_once('../layouts/header.php'); 
    if(isset($_POST['add_sale'])){
    $req_fields = array('s_id','quantity','price','total', 'date' );
    validate_fields($req_fields);
      if(empty($errors)){
          $p_id      = (int)$_POST['s_id'];
          $s_qty     = (int)$_POST['quantity'];
          $s_total   = $_POST['total'];
          $date      = $_POST['date'];
          $result =checkQty($p_id);
          if($s_qty <= 0){
            $session->msg('d','Quantity must be greater than 0!');
            redirect('/admin/add_sale/', false);
          }
          if($s_qty > $result){
            $session->msg('d','Not enough stock!');
            redirect('/admin/add_sale/', false);
          }
          $database->query("INSERT INTO sales (product_id,quantity,price,created) VALUES('{$p_id}','{$s_qty}','{$s_total}','{$date}')");
          if($database->execute()){
              $prod_name = update_product_qty($s_qty,$p_id);
              log_history('Sales Product '.$prod_name.' with quantity '.$s_qty.', and total of &#8369;'.$s_total.' has been added');
              $session->msg('s',"Sale added. ");
              redirect('/admin/add_sale/', false);
          }else {
            $session->msg('d',' Sorry failed to add!');
            redirect('/admin/add_sale/', false);
          }
      }else {
          $session->msg("d", $errors);
          redirect('/admin/add_sale/',false);
      }
    }
?>
<div class="row">
  <div class="col-md-6">
   <?php echo display_msg($msg); ?>
    <form method="post" action="/admin/ajax.php" autocomplete="off" id="sug-form">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary">Search</button>
            </span>
            <input type="text" id="sug_input" class="form-control" name="title"  placeholder="Product name">
         </div>
         <div id="result" class="list-group"></div>
        </div>
    </form>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <i class="glyphicon glyphicon-ruble"></i>
          <span>Sales Edit</span>
       </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="/admin/add_sale/">
         <table class="table table-bordered">
           <thead>
            <th> Item </th>
            <th> Price </th>
            <th> Qty </th>
            <th> Total </th>
            <th> Date</th>
            <th> Action</th>
           </thead>
             <tbody  id="product_info"> </tbody>
         </table>
       </form>
      </div>
    </div>
  </div>
</div>

<?php include_once('../layouts/footer.php'); ?>
