<?php
if(isset($_REQUEST['downloadExcel'])){
	$filename = "sales_report.xls";		 
    header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=\"$filename\"");
	$data = get_data();
	ExportFile($data);
	exit();
}
function ExportFile($records) {
	$heading = false;
		if(!empty($records))
		  foreach($records as $row) {
			if(!$heading) {
			  // display field/column names as a first row
			  echo implode("\t", array_keys($row)) . "\n";
			  $heading = true;
			}
			echo implode("\t", array_values($row)) . "\n";
		  }
		exit;
}

function get_data(){
	session_start();
	include('DatabaseControl/dbConnect.php');
	$SQL_ACCOUNT=mysql_query("SELECT id, terminal_id FROM `tbl_terminal` WHERE customer_id = ".$_SESSION['user_id']);
	
	$CardTotal_Final = 0;
	$TaxTotal_Final = 0;
	$TotalSale_Final = 0;
	$data = array();
	$cnt = 0;
	while($DATA_ACCOUNT=mysql_fetch_array($SQL_ACCOUNT))
	{
		$query1=mysql_query("SELECT order_total, tax, order_final_total FROM `tbl_orders` WHERE terminal_id = '".$DATA_ACCOUNT['terminal_id']."' ".$where);
		$CardTotal = 0;
		$TaxTotal = 0;
		$TotalSale=0;
		while($data1=mysql_fetch_array($query1))
		{
			$CardTotal = $CardTotal + $data1['order_total'];
			$TaxTotal = $TaxTotal + $data1['tax'];
			$TotalSale = $TotalSale + $data1['order_final_total'];
		}
		
		$data[$cnt]['Terminal Id'] = $DATA_ACCOUNT['terminal_id'];
		$data[$cnt]['Cart Total'] = '$'.number_format($CardTotal, 2);
		$data[$cnt]['Tax Total'] = '$'.number_format($TaxTotal, 2);
		$data[$cnt]['Total Sales'] = '$'.number_format($TotalSale, 2);
		$cnt++;
	}
	return $data;
}   

?>