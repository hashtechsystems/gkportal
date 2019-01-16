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
	$SQL=mysql_query("SELECT o.order_id, o.pos_orderId, o.terminal_id, o.date_time, o.order_final_total FROM `tbl_orders` o INNER JOIN `tbl_terminal` t  ON o.terminal_id = t.terminal_id WHERE t.customer_id = '".$_SESSION['user_id']."' order by o.order_id DESC");
	$cnt = 0;
	$data = array();
	while($DATA=mysql_fetch_array($SQL))
	{
		$data[$cnt]['Terminal ID'] = $DATA['terminal_id'];
		$data[$cnt]['Order ID'] = $DATA['order_id'];
		$data[$cnt]['Pos Order ID'] = $DATA['pos_orderId'];
		$data[$cnt]['Order Amount'] = '$'.number_format($DATA['order_final_total'], 2);
		$data[$cnt]['Date Time'] = $DATA['date_time'];
		$cnt++;
	}
	return $data;
}   

?>