<?php
if(isset($_REQUEST['downloadExcel'])){
	$filename = "product_sales_report.xls";		 
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
	$FinalQty = 0;
	$FinalSales = 0;
	$TerminalIds = '';
	$cnt = 0;
	$data = array();
	while($DATA_ACCOUNT=mysql_fetch_array($SQL_ACCOUNT))
	{		
		$query2=mysql_query("SELECT count(`order_id`) as totProd, sum(`order_final_total`) as totPrice, `order_id`, `terminal_id` FROM tbl_orders WHERE terminal_id = '".$DATA_ACCOUNT['terminal_id']."' GROUP BY `terminal_id` ");
		$cnt=0;
		$PriceTotal2=0;
		$TotalQty2=0;
		while($data2=mysql_fetch_array($query2))
		{
			if($TerminalIds == '')
			{
				$TerminalIds = $data2['terminal_id'];
			}
			else
			{
				$TerminalIds = $TerminalIds .", ". $data2['terminal_id'];
			}
			
			$terminal_id = $data2['terminal_id'];
			$PriceTotal2=$PriceTotal2+$data2['totPrice'];
			$TotalQty2=$TotalQty2+$data2['totProd'];
		}
		$data[$cnt]['Terminal ID'] = $terminal_id;
		$data[$cnt]['Number of Sales'] = $TotalQty2;
		$data[$cnt]['Value of Sales'] = '$'.number_format($PriceTotal2, 2);
		$cnt++;
	}
	return $data;
}   

?>