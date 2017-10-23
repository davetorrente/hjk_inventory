<?php
  $page_title = 'All Product';
  require_once('../includes/load.php');
  include_once('../layouts/header.php');
  $products = join_product_table('products');
?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <div class="pull-right">
          <a href="/admin/add_product/" class="btn btn-primary">Add New</a>
        </div>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <thead>
            <tr id="product-col">
              <th class="text-center" style="width: 50px;">#</th>
              <th> Photo</th>
              <th> Product Name </th>
              <th class="text-center"> Category </th>
              <th class="text-center"> Instock </th>
              <th class="text-center"> Buying Price </th>
              <th class="text-center"> Selling Price </th>
              <th class="text-center"> Product Added </th>
              <th class="text-center"> Actions </th>
            </tr>
          </thead>
          <tbody>
          <?php if(!empty($products['list'])): ?>
            <?php foreach ($products['list'] as $product):?>
              <tr>
                <td class="text-center"><?php echo $product['id'];?></td>
                <td class="text-center">
                  <?php if($product['media_id'] === '0'): ?>
                    <img class="img-avatar img-circle" src="/assets/images/products/default_product.png" alt="">
                  <?php else: ?>
                  <img class="img-avatar img-circle" src="/assets/images/products/<?php echo $product['image']; ?>" alt="">
                <?php endif; ?>
                </td>
                <td> <?php echo remove_junk($product['name']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['category']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['quantity']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['buy_price']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['sale_price']); ?></td>
                <td class="text-center"> <?php echo date("M j, Y g:i a",strtotime($product['created'])); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="/admin/edit_product/?id=<?php echo (int)$product['id'];?>/" class="btn btn-info btn-xs"  title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="/admin/delete_product/?id=<?php echo (int)$product['id'];?>/" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
             <?php endforeach; ?>
          <?php endif; ?>
          </tbody>
        </table>
      </div>   
      <?php if(!empty($products['list'])): ?>
        <div class="panel-footer">
          <div class="row">
            <div class="col col-xs-4">Page  <?php echo $products['page']==0 ? 1 : $products['page'] ; ?> of <?php echo $products['count']; ?></div>
            <div class="col col-xs-8">
                <ul class="pagination hidden-xs pull-right">   
                  <?php for($i=1; $i<=$products['count']; $i++): ?>
                      <li><a href="/admin/product/?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                  <?php endfor ?>
                </ul>
                <ul class="pagination visible-xs pull-right">
                    <li><a href="#">«</a></li>
                    <li><a href="#">»</a></li>
                </ul>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>

</div>
<?php include_once('../layouts/footer.php'); ?>