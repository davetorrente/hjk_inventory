<?php
  $page_title = 'Edit product';
  require_once('../includes/load.php');
  include_once('../layouts/header.php');
  $product = find_by_id('products',(int)$_GET['id']);
  $all_categories = find_all('categories');
  $all_photo = find_all('medias');
  if(!$product){
    $session->msg("d","Missing product id.");
    redirect('product.php');
  }

  if(isset($_POST['product'])){
     $req_fields = array('product-name','product-category','product-quantity','buying-price', 'sale-price' );
      validate_fields($req_fields);

    if(empty($errors)){
      $p_name  = remove_junk($_POST['product-name']);
      $p_cat   = (int)$_POST['product-category'];
      $p_qty   = remove_junk($_POST['product-quantity']);
      $p_buy   = remove_junk($_POST['buying-price']);
      $p_sale  = remove_junk($_POST['sale-price']);
      $p_photo = '';
      if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
        $media_id = '0';
      } else {
        $media_id = remove_junk($_POST['product-photo']);
        $media = find_by_id('medias',$media_id);
        $p_photo = $media['file_name'];
      }
      $db_photo = !empty($p_photo) ? ' and photo '.$p_photo.' ' : ' ';
      $database->query("SELECT name FROM products WHERE name='$p_name'");
      $db_prod = $database->resultset();
      if(empty($db_prod)){
        $sql   = "UPDATE products SET";
        $sql  .=" name ='{$p_name}', quantity ='{$p_qty}',";
        $sql  .=" buy_price ='{$p_buy}', sale_price ='{$p_sale}', category_id ='{$p_cat}',media_id='{$media_id}'";
        $sql  .=" WHERE id ='{$product['id']}'";
        $database->query($sql);
        $database->execute();
        if($database->rowCount() === 1) {
          log_history($product['name'].' has been updated to '.$p_name. ' under category '.$p_cat.' with quantity'.$p_qty.', buying price of &#8369;'.$p_buy.' selling price of &#8369;'.$p_sale.$db_photo );
          $session->msg("s", "Successfully updated Product");
          redirect('product.php',false);
        }else {
          $session->msg('d',' Sorry failed to updated!');
          redirect('edit_product.php?id='.$product['id'], false);
        }
      }else{
        if($db_prod[0]['name'] == $product['name']){
          $sql   = "UPDATE products SET";
          $sql  .=" name ='{$p_name}', quantity ='{$p_qty}',";
          $sql  .=" buy_price ='{$p_buy}', sale_price ='{$p_sale}', category_id ='{$p_cat}',media_id='{$media_id}'";
          $sql  .=" WHERE id ='{$product['id']}'";
          $database->query($sql);
          $database->execute();
          if($database->rowCount() === 1) {
            log_history($product['name'].' has been updated to '.$p_name. ' under category '.$p_cat.' with quantity'.$p_qty.', buying price of &#8369;'.$p_buy.' selling price of &#8369;'.$p_sale.$db_photo);
            $session->msg("s", "Successfully updated Product");
            redirect('product.php',false);
          }
          $session->msg("s", "Successfully updated Product");
          redirect('product.php',false);
        }else{
          $session->msg("d", 'Product Name already exists');
          redirect('edit_product.php?id='.$product['id'], false);
        }
      }
      
    }else{
       $session->msg("d", $errors);
       redirect('edit_product.php?id='.$product['id'], false);
    }
  }

?>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Add New Product</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-7">
           <form method="post" action="edit_product.php?id=<?php echo (int)$product['id'] ?>">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-name" value="<?php echo remove_junk($product['name']);?>">
               </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <select class="form-control" name="product-category">
                    <option value=""> Select a categorie</option>
                   <?php  foreach ($all_categories as $cat): ?>
                     <option value="<?php echo (int)$cat['id']; ?>" <?php if($product['category_id'] === $cat['id']): echo "selected"; endif; ?> >
                       <?php echo remove_junk($cat['name']); ?></option>
                   <?php endforeach; ?>
                 </select>
                  </div>
                  <div class="col-md-6">
                    <select class="form-control" name="product-photo">
                      <option value=""> No image</option>
                      <?php  foreach ($all_photo as $photo): ?>
                        <option value="<?php echo (int)$photo['id'];?>" <?php if($product['media_id'] === $photo['id']): echo "selected"; endif; ?> >
                          <?php echo $photo['file_name'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Quantity</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                       <i class="glyphicon glyphicon-shopping-cart"></i>
                      </span>
                      <input type="number" class="form-control" name="product-quantity" value="<?php echo remove_junk($product['quantity']); ?>">
                   </div>
                  </div>
                 </div>
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Buying price</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="number" class="form-control" name="buying-price" value="<?php echo remove_junk($product['buy_price']);?>">
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
                 </div>
                  <div class="col-md-4">
                   <div class="form-group">
                     <label for="qty">Selling price</label>
                     <div class="input-group">
                       <span class="input-group-addon">
                         <i class="glyphicon glyphicon-usd"></i>
                       </span>
                       <input type="number" class="form-control" name="sale-price" value="<?php echo remove_junk($product['sale_price']);?>">
                       <span class="input-group-addon">.00</span>
                    </div>
                   </div>
                  </div>
               </div>
              </div>
              <button type="submit" name="product" class="btn btn-danger">Update</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('../layouts/footer.php'); ?>
