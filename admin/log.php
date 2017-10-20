<?php
  $page_title = 'Logs';
  require_once('../includes/load.php');
  include_once('../layouts/header.php');
  $logs = paginate('logs',10);
?>

  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th> Log History </th>
                <th class="text-center" style="width: 15%;"> Date </th>
             </tr>
            </thead>
           <tbody>
            <?php if(!empty($logs['list'])): ?>
              <?php foreach ($logs['list'] as $log):?>
               <tr>
                 <td><?php echo htmlspecialchars_decode($log['name']); ?></td>
                 <td class="text-center"><?php echo date("m/d/y H:i A", strtotime($log['created'])); ?></td>

               </tr>
              <?php endforeach;?>
            <?php endif; ?>
           </tbody>
         </table>
        </div>
        <?php if(!empty($logs['list'])): ?>
        <div class="panel-footer">
          <div class="row">
            <div class="col col-xs-4">Page  <?php echo $logs['page']==0 ? 1 : $logs['page'] ; ?> of <?php echo $logs['count']; ?></div>
            <div class="col col-xs-8">
                <ul class="pagination hidden-xs pull-right">   
                  <?php for($i=1; $i<=$logs['count']; $i++): ?>
                      <li><a href="log.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
