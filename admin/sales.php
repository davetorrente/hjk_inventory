<?php
  $page_title = 'All sale';
  require_once('../includes/load.php');
  include_once('../layouts/header.php');
  $sales = find_all_sale('sales');
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
            <i class="glyphicon glyphicon-ruble"></i>
            <span>All Sales</span>
          </strong>
          <div class="pull-right">
            <a href="/admin/add_sale/" class="btn btn-primary">Add sale</a>
          </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Product name </th>
                <th class="text-center" style="width: 15%;"> Quantity</th>
                <th class="text-center" style="width: 15%;"> Total </th>
                <th class="text-center" style="width: 15%;"> Date </th>
                <th class="text-center" style="width: 100px;"> Actions </th>
             </tr>
            </thead>
           <tbody>
            <?php if(!empty($sales['list'])): ?>
              <?php foreach ($sales['list'] as $sale):?>
               <tr>
                 <td class="text-center" style="width:8%"><?php echo $sale['id'];?></td>
                 <td style="width:35%"><?php echo remove_junk($sale['name']); ?></td>
                 <td class="text-center"><?php echo (int)$sale['quantity']; ?></td>
                 <td class="text-center"><?php echo remove_junk($sale['price']); ?></td>
                 <td class="text-center" style="width: 20%"><?php echo date("M j, Y g:i a",strtotime($sale['created']));?></td>
                 <td class="text-center">
                    <div class="btn-group">
                       <a href="/admin/edit_sale/?id=<?php echo (int)$sale['id'];?>" class="btn btn-warning btn-xs"  title="Edit" data-toggle="tooltip">
                         <span class="glyphicon glyphicon-edit"></span>
                       </a>
                       <a href="/admin/delete_sale/?id=<?php echo (int)$sale['id'];?>" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                         <span class="glyphicon glyphicon-trash"></span>
                       </a>
                    </div>
                 </td>
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
                      <li><a href="/admin/sales/?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
