<?php 
    $page_title = 'Dashboard Page';
    require_once('../includes/load.php');
    if (!$session->isUserLoggedIn(true)) { redirect('../auth/login.php', false);}
    include_once('../layouts/header.php'); 
    $categoryCount   = countData('categories');
    $productCount    = countData('products');
    $saleCount       = countData('sales');
    $products_sold   = find_high_sell_product('3');
    $recent_sales    = find_high_sale('3');
    $recent_products = find_recent_prod('3');
?>
<div class="row">
   <div class="col-md-6">
     
   </div>
</div>
<div class="row">
  <div class="col-md-12">
      <?php echo display_msg($msg); ?>  
  </div>
   <div class="col-md-12">
      <div class="panel">
        <div class="jumbotron text-center">
          <div class="container">
            <div class="carousel slide" id="myCarousel" data-ride="carousel">
              <div class="carousel-inner">
              <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
                <li data-target="#myCarousel" data-slide-to="3"></li>
                 <li data-target="#myCarousel" data-slide-to="4"></li>
              </ol>
                <div class="item active" >
                  <img src="/assets/images/banner/hjk1.jpg" class="img-responsive col-md-12">
                  <!-- <div class="carousel-caption">
                    <h2>Yo ninjas adfasdfasdfasdf</h2>
                  </div> -->
                </div>
                <div class="item">
                  <img src="/assets/images/banner/hjk2.jpg" class="img-responsive col-md-12">
                  <!-- <div class="carousel-caption">
                    <h2>Yo ninjas adfasdfasdfasdf</h2>
                  </div> -->
                </div>
                <div class="item">
                  <img src="/assets/images/banner/hjk3.jpg" class="img-responsive col-md-12">
                  <!-- <div class="carousel-caption">
                    <h2>Yo ninjas adfasdfasdfasdf</h2>
                  </div> -->
                </div>  
                <div class="item">
                  <img src="/assets/images/banner/hjk4.jpg" class="img-responsive col-md-12">
                  <!-- <div class="carousel-caption">
                    <h2>Yo ninjas adfasdfasdfasdf</h2>
                  </div> -->
                </div>  
                <div class="item">
                  <img src="/assets/images/banner/hjk5.jpg" class="img-responsive col-md-12">
                 <!--  <div class="carousel-caption">
                    <h2>Yo ninjas adfasdfasdfasdf</h2>
                  </div> -->
                </div>  
              </div>  
              <a href="#myCarousel" class="right carousel-control" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
              </a>
              <a href="#myCarousel" class="left carousel-control" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
              </a>
          </div>
          </div>
        </div>
      </div>
   </div>
</div>
<div class="row">
  <div class="col-md-4">
     <div class="panel panel-box clearfix">
       <div class="panel-icon pull-left bg-red">
        <i class="fa fa-cubes"></i>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"><?php  echo !empty($categoryCount) ? $categoryCount : 0 ; ?></h2>
        <p class="text-muted">Categories</p>
      </div>
     </div>
  </div>
  <div class="col-md-4">
     <div class="panel panel-box clearfix">
       <div class="panel-icon pull-left bg-blue">
        <i class="glyphicon glyphicon-shopping-cart"></i>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"><?php  echo !empty($productCount) ? $productCount : 0 ; ?></h2>
        <p class="text-muted">Products</p>
      </div>
     </div>
  </div>
  <div class="col-md-4">
     <div class="panel panel-box clearfix">
       <div class="panel-icon pull-left bg-yellow">
        <i class="glyphicon">&#8369;</i>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"><?php echo !empty($saleCount) ? $saleCount : 0; ?></h2>
        <p class="text-muted">Sales</p>
      </div>
     </div>
  </div>
</div>
<div class="row">
   <div class="col-md-6">
     <div class="panel panel-default">
       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Best Selling Products</span>
         </strong>
       </div>
       <div class="panel-body">
         <table class="table table-striped table-bordered table-condensed">
          <thead>
           <tr>
             <th class="text-center">Product Name</th>
             <th class="text-center">Total Sold</th>
             <th class="text-center">Total Quantity</th>
           <tr>
          </thead>
          <tbody>
            <?php foreach ($products_sold as  $product_sold): ?>
              <tr>
                <td><?php echo remove_junk(first_character($product_sold['name'])); ?></td>
                <td class="text-center"><?php echo (int)$product_sold['totalSold']; ?></td>
                <td class="text-center"><?php echo (int)$product_sold['totalQty']; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
         </table>
       </div>
     </div>
   </div>
   <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>HIGHEST SALES</span>
          </strong>
        </div>
        <div class="panel-body">
          <table class="table table-striped table-bordered table-condensed">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                  <th class="text-center">Product Name</th>
                  <th class="text-center">Date</th>
                  <th class="text-center">Total Sale</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($recent_sales as  $recent_sale): ?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td>
                  <a href="/admin/edit_sale/?id=<?php echo (int)$recent_sale['id']; ?>">
                    <?php echo remove_junk(first_character($recent_sale['name'])); ?>
                  </a>
                </td>
                <td class="text-center"><?php echo remove_junk(ucfirst($recent_sale['created'])); ?></td>
                <td class="text-center">&#8369;<?php echo remove_junk(first_character($recent_sale['price'])); ?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>New Added Products</span>
          </strong>
        </div>
        <div class="panel-body">
          <table class="table table-striped table-bordered table-condensed">
            <thead>
              <tr>
                <th class="text-center">Photo</th>
                  <th class="text-center">Product Name</th>
                  <th class="text-center">Category</th>
                  <th class="text-center">Price</th>
              </tr>
            </thead>
            <tbody>
                <?php foreach ($recent_products as  $recent_prod): ?>
                 <tr>
                   <td class="text-center">
                     <?php if($recent_prod['media_id'] === '0'): ?>
                        <img style="height:100px width:auto" class="img-avatar img-circle" src="/assets/images/products/default_product.png" alt="">
                      <?php else: ?>
                      <img style="height:100px; width:auto;" class="img-avatar img-circle" src="/assets/images/products/<?php echo $recent_prod['image'];?>" alt="" />
                    <?php endif;?>
                   </td>
                   <td class="text-center" style="width:250px;position: relative; top: 30px;">
                    <a href="/admin/edit_product/?id=<?php echo (int)$recent_prod['id']; ?>">
                     <?php echo remove_junk(first_character($recent_prod['name'])); ?>
                   </a>
                   </td>
                   <td class="text-center" style="width:200px; position: relative; top: 30px;"><?php echo remove_junk(ucfirst($recent_prod['category'])); ?></td>
                   <td class="text-center" style="width:150px; position: relative; top: 30px;">&#8369;<?php echo remove_junk(first_character($recent_prod['sale_price'])); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
  </div>
</div>
<div class="row">

</div>

<?php include_once('../layouts/footer.php'); ?>
<script type="text/javascript">
    $(function(){
      $('.carousel').carousel({
        interval: 2500,
        // pause: false,
        //wrap: false, //di na babalik sa unang slide
        keyboard:true
      })
    })
</script>
<style>
img.img-responsive.col-md-12{
  height: 100% !important;
  width: 100% !important;
}
.item{
  height: 300px !important;
}
</style>