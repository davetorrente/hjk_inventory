<?php
  $page_title = 'Daily Sales';
  require_once('../includes/load.php');
  include_once('../layouts/header.php');
  $year  = date('Y');
  $month = date('m');
  $sales = dailySales($year,$month,'sales');
?>

<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Daily Sales</span>
          </strong>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Product name </th>
                <th class="text-center" style="width: 15%;"> Quantity sold</th>
                <th class="text-center" style="width: 15%;"> Total </th>
                <th class="text-center" style="width: 15%;"> Date </th>
             </tr>
            </thead>
            <tbody>
            <?php if(!empty($sales['list'])): ?>
              <?php foreach ($sales['list'] as $sale):?>
                <tr>
                  <td class="text-center"><?php echo count_id();?></td>
                  <td><?php echo remove_junk($sale['name']); ?></td>
                  <td class="text-center"><?php echo (int)$sale['total_qty']; ?></td>
                  <td class="text-center"><?php echo remove_junk($sale['total_saleing_price']); ?></td>
                  <td class="text-center"><?php echo date("M d, Y",strtotime($sale['created'])); ?></td>
                </tr>
              <?php endforeach;?>
            <?php endif; ?>
           </tbody>
         </table>
        </div>
        <?php if(!empty($sales['list'])): ?>
        <div class="panel-footer">
          <div class="row">
            <div class="col col-xs-4">Page  <?php echo $sales['page']==0 ? 1 : $sales['page'] ; ?> of <?php echo $sales['count']; ?></div>
            <div class="col col-xs-8">
                <ul class="pagination hidden-xs pull-right">   
                  <?php for($i=1; $i<=$sales['count']; $i++): ?>
                      <li><a href="daily_sales.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
