<?php
if(isset($_REQUEST['downloadExcel'])){
	$filename = "product_list.xls";		 
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
	$SQL_ACCOUNT=mysql_query("SELECT * FROM `tbl_greenbits_inventory`");
	$data = array();
	$cnt = 0;
	while($DATA_ACCOUNT=mysql_fetch_array($SQL_ACCOUNT))
	{
		$data[$cnt]['Product Name'] = $DATA_ACCOUNT['product_name'];
	//	$data[$cnt]['Row'] = $DATA_ACCOUNT['row'];
	//	$data[$cnt]['Column'] = $DATA_ACCOUNT['col'];
	//	$data[$cnt]['Category'] = $DATA_ACCOUNT['product_type'];
	//	$data[$cnt]['Strain Name'] = $DATA_ACCOUNT['strain_name'];
		$data[$cnt]['Price'] = $DATA_ACCOUNT['product_sell_price'];
		$data[$cnt]['Weight'] = $DATA_ACCOUNT['product_weight_value'];
		$data[$cnt]['Quantity'] = $DATA_ACCOUNT['product_quantity'];
	//	$data[$cnt]['THC'] = $DATA_ACCOUNT['thc_percentage'];
		$data[$cnt]['Featured'] = $DATA_ACCOUNT['featured']==1?'Y':'N';
		$data[$cnt]['New'] = $DATA_ACCOUNT['new']==1?'Y':'N';
		$data[$cnt]['Popular'] = $DATA_ACCOUNT['popular']==1?'Y':'N';
		$cnt++;
	}
	return $data;
}   

?>