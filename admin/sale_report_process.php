<?php
$page_title = 'Sales Report';
$results = '';
  require_once('../includes/load.php');
  if(isset($_POST['submit'])){
    $req_dates = array('start-date','end-date');
    validate_fields($req_dates);
    if(empty($errors)):
      $start_date   = remove_junk($_POST['start-date']);
      $end_date     = remove_junk($_POST['end-date']);
      $results      = find_sale_by_dates($start_date,$end_date);
      $_SESSION['csv'] = $results;
      $_SESSION['start_date'] = $start_date;
      $_SESSION['end_date']   = $end_date;
    else:
      $session->msg("d", $errors);
      redirect('sales_report.php', false);
    endif;
  }else {
    $session->msg("d", "Select dates");
    redirect('sales_report.php', false);
  }
?>
<!DOCTYPE html>
<html lang="en">
 <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>Sales Report</title>
     <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css"/>
     <link rel="stylesheet" href="/assets/css/report.css"/>
</head>
<body>
  <?php if($results): ?>
  <form name="getcvs" action="sale_report_csv.php" method="POST"> 
    <div class="page-break">
    <div class="pull-right">
       <div class="sale-head ">
           <h1>Sales Report</h1>
           <strong><?php if(isset($start_date)){ echo date("M d, Y", strtotime($start_date));}?> To <?php if(isset($end_date)){echo date("M d, Y", strtotime($end_date));}?> </strong>
           
       </div>
       <div id="reportBtn">
       <input type="submit" name="submit" value="Download CSV file" class="input-button btn btn-warning" /> 
       </div>
     </div>
      <table class="table table-border">
        <thead>
          <tr>
              <th>Date</th>
              <th>Product Title</th>
              <th>Buying Price</th>
              <th>Selling Price</th>
              <th>Total Qty</th>
              <th>Total</th>
          </tr>
        </thead>
        <tbody id="treportbody">
          <?php foreach($results as $result): ?>
           <tr>
              <td><?php echo remove_junk(date("M d, Y", strtotime($result['created'])));?></td>
              <td class="desc">
                <h6><?php echo remove_junk(ucfirst($result['name']));?></h6>
              </td>
              <td class="text-right"><?php echo remove_junk($result['buy_price']);?></td>
              <td class="text-right"><?php echo remove_junk($result['sale_price']);?></td>
              <td class="text-right"><?php echo remove_junk($result['total_sales']);?></td>
              <td class="text-right"><?php echo remove_junk($result['total_saleing_price']);?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
         <tr class="text-right">
           <td colspan="4"></td>
           <td colspan="1">Grand Total</td>
           <td> &#8369;
           <?php echo number_format(total_price($results)[0], 2);?>
          </td>
         </tr>
         <tr class="text-right">
           <td colspan="4"></td>
           <td colspan="1">Profit</td>
           <td> &#8369;<?php echo number_format(total_price($results)[1], 2);?></td>
         </tr>
        </tfoot>
      </table>
    </div>
  </form>
  <?php
    else:
        $session->msg("d", "Sorry no sales has been found. ");
        redirect('sales_report.php', false);
     endif;
  ?>
</body>
</html>
