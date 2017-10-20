<?php
session_start();
$rows = $_SESSION['csv'];

function total_price($totals){
   $sum = 0;
   $sub = 0;
   foreach($totals as $total ){
     $sum += $total['total_saleing_price'];
     $sub += $total['total_buying_price'];
     $profit = $sum - $sub;
   }
   return array($sum,$profit);
}
header('Content-Type: application/x-excel');
header('Content-Disposition: attachment; filename="Sales.csv"');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
$salesReport = array('Sales Report');
$monthOf = array(date("M-d-Y", strtotime($_SESSION['start_date'])).' '. 'to '.date("M-d-Y", strtotime($_SESSION['end_date'])));
echo(implode(',',$salesReport));
echo("\n");
echo(implode(',',$monthOf));
echo("\n");
echo("\n");
$headers=array('Date','Product Title','Buying Price','Selling Price','Total Qty','Total');
echo(implode(',',$headers));
echo("\n");
foreach($rows as $row){
	$arrayCSV = array($row['created'], $row['name'], $row['buy_price'],$row['sale_price'],$row['total_sales'],$row['total_saleing_price']);
	echo(implode(',',$arrayCSV));
	echo("\n");
}


$grandFormat = str_replace(',', '', number_format(total_price($rows)[0], 2));
$profitFormat = number_format(total_price($rows)[1], 2);
if( strpos($grandFormat, ',') !== false )
{
  $grandTotal= array(",,,,Grand Total,". "{$grandFormat}");
  $grandWord = preg_replace('/,([^,]*)$/', '\1', $grandTotal[0]);
  $grandTotal[0] = $grandWord;
}else{
  $grandTotal= array(",,,,Grand Total,". "{$grandFormat}");
}
if( strpos($profitFormat, ',') !== false )
{
  $profit= array(",,,,PROFIT,". "{$profitFormat}");
  $profitWord = preg_replace('/,([^,]*)$/', '\1', $profit[0]);
  $profit[0] = $profitWord;
}else{
  $profit= array(",,,,PROFIT,". "{$profitFormat}");
}
  
echo(implode('", "', $grandTotal));
echo("\n");
echo(implode(',',$profit));



