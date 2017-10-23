<?php 
  
  $page_title = 'Add Product';
  require_once('../includes/load.php');
  include_once('../layouts/header.php');
  $all_categories = find_all('categories');
  $all_photos = find_all('medias');
  if(isset($_POST['add_product'])){
      $req_fields = array('product-name','product-category','product-quantity','buying-price', 'sale-price' );
      validate_fields($req_fields);
      if(empty($errors)){
        $p_name  = remove_junk($_POST['product-name']);
        $p_cat   = remove_junk($_POST['product-category']);
        $p_qty   = remove_junk($_POST['product-quantity']);
        $p_buy   = remove_junk($_POST['buying-price']);
        $p_sale  = remove_junk($_POST['sale-price']);
        $p_photo = '';
    
        if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
          $media_id = '0';
        }else {
          $media_id = remove_junk($_POST['product-photo']);
          $media = find_by_id('medias',$media_id);
          $p_photo = $media['file_name'];
        }
        $created   = make_date();
        $database->query("SELECT name FROM products WHERE name='$p_name'");
        $prod_name = $database->resultset();
        if(empty($prod_name)){
            $database->query("SELECT name FROM categories WHERE id='{$p_cat}'");
            $db_category = $database->resultset();
            $database->query("INSERT INTO products (name,quantity,buy_price,sale_price,category_id,media_id,created) VALUES('{$p_name}', '{$p_qty}', '{$p_buy}', '{$p_sale}', '{$p_cat}', '{$media_id}', '{$created}')
            ON DUPLICATE KEY UPDATE name='{$p_name}'");
            if($database->execute()){
              $db_photo = !empty($p_photo) ? ' and photo '.$p_photo.' ' : ' ';
              log_history('Product '.$p_name.' under category '.$db_category[0]['name'].' with quantity '.$p_qty.', buy price &#8369;'.$p_buy.', selling price of &#8369;'.$p_sale.$db_photo.'has been added');
              $session->msg("s", "Successfully Added Product");
              redirect('/admin/product/',false);
            }else {
              $session->msg('d',' Sorry failed to added!');
              redirect('/admin/product/', false);
             }
        }else{
            $session->msg("d", 'Product name already exists');
            redirect('/admin/add_product/',false);
        }
       
      }else{
        $session->msg("d", $errors);
        redirect('/admin/add_product/',false);
      }
  }
 
?>
<div class="row">
  <div class="row">
    <div class="col-md-12">
      <?php echo display_msg($msg); ?>
    </div>
  </div>
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Add New Product</span>
        </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-12">
          <form method="post" class="clearfix">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="glyphicon glyphicon-th-large"></i>
                </span>
                <input type="text" class="form-control" name="product-name" placeholder="Product Name" value="<?php echo isset($p_name) ? $p_name : '';?>">
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <select class="form-control" name="product-category">
                    <option value="">Select Product Category</option>
                      <?php if(!empty($all_categories)): ?>
                          <?php  foreach ($all_categories as $cat): ?>
                              <option value="<?php echo (int)$cat['id'] ?>">
                              <?php echo $cat['name'] ?></option>
                          <?php endforeach; ?>
                      <?php endif; ?>
                  </select>
                </div>
                <div class="col-md-6">
                  <select class="form-control" name="product-photo">
                    <option value="">Select Product Photo</option>
                      <?php if(!empty($all_photos)): ?>
                        <?php  foreach ($all_photos as $photo): ?>
                            <option value="<?php echo (int)$photo['id'] ?>">
                            <?php echo $photo['file_name'] ?></option>
                        <?php endforeach; ?>
                      <?php endif; ?>    
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                    </span>
                    <input type="number" class="form-control" name="product-quantity" placeholder="Product Quantity">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-group">
                    <span class="input-group-addon">
                      &#8369;
                    </span>
                    <input type="number" class="form-control" name="buying-price" placeholder="Buying Price">
                    <span class="input-group-addon">.00</span>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-group">
                    <span class="input-group-addon">
                      &#8369;
                    </span>
                    <input type="number" class="form-control" name="sale-price" placeholder="Selling Price">
                    <span class="input-group-addon">.00</span>
                  </div>
                </div>
              </div>
            </div>
            <button type="submit" name="add_product" class="btn btn-danger">Add product</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('../layouts/footer.php'); ?>
