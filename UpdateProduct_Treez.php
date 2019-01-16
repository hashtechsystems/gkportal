<?php
ob_start();
error_reporting(0);
if(isset($_POST['UpdateProduct'])){
include('DatabaseControl/dbConnect.php');

//$auth = "apikey=kaefeVienguathaec0LaoC9ai&client_id=AAjdAW8XczLIrPg2wBaIlHUaG8ZTxtgd";
$auth = 'apikey=WB68UGpswqFVxypFsxXqBsNVt&client_id=h2JwESfGYfXbIiZdG8n94hxGHacbw1rI';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://treez-test.apigee.net/v1.0/dispensary/grasshopper/config/api/gettokens");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS,$auth);
$headers_auth = array();
$headers_auth[] = "Content-Type: application/x-www-form-urlencoded";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_auth);
$result = curl_exec($ch);
$res= json_decode($result,true);
$access_token = $res['access_token'];
curl_close($ch);


$url = "https://treez-test.apigee.net/v1.0/dispensary/grasshopper/menu/product_list?type=all&offset=0&limit=600&stock=all";
//$url = "https://api.treez.io/v1.0/dispensary/testenv10/menu/product_list?type=all&offset=0&limit=600&stock=all";
$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	'Accept: application/json',
	'Content-Type: application/json',
	'Authorization: Bearer '.$access_token.''
));


$resp = curl_exec($curl);
curl_close($curl);

$Data = json_decode($resp, true);

echo "<pre>";
//print_r($Data);exit;
if(!empty($Data)){
//mysql_query("TRUNCATE TABLE  tbl_products_treez");
//mysql_query("TRUNCATE TABLE  tbl_products_size_treez_test");
foreach($Data['product_list'] as $ProductList)
{		
	$product_id = $ProductList['product_id'];
	$product_name = $ProductList['product_name'];
	$product_type = $ProductList['type'];
	
	foreach($ProductList['classifications'] as $PClassification)
	{
		$classifications = $PClassification;
	}
	
	$brand = $ProductList['brand'];
	$totalCannabinoids = $ProductList['totalCannabinoids'];
	$description = $ProductList['description'];
	$active = $ProductList['active'];
	$taxRate = $ProductList['taxRate'];
	$test_result_url = $ProductList['test_result_url'];	
		
	$total_doses = $ProductList['attributes']['total_doses'];
	$mg_dose = $ProductList['attributes']['mg_dose'];
	$cbd_ratio = $ProductList['attributes']['cbd_ratio'];
	$total_cannabinoids_percentage = $ProductList['attributes']['total_cannabinoids_percentage'];
	$thc_percentage = $ProductList['attributes']['thc_percentage'];
	$cbd_percentage = $ProductList['attributes']['cbd_percentage'];
	$terpenes_percentage = $ProductList['attributes']['terpenes_percentage'];
	$size = $ProductList['attributes']['size'];
	$medium = $ProductList['attributes']['medium'];
	
	$large_image = $ProductList['images']['large_image'];
	$cropped_image = $ProductList['images']['cropped_image'];
	
	$back_stock_inventory_quantity = $ProductList['back_stock_inventory_quantity'];
	$menu_title = $ProductList['menu_title'];
	$sub_types = $ProductList['sub_types'][0];
	$last_update_date = $ProductList['last_update_date'];
	$secondary_tax_rate = $ProductList['secondary_tax_rate'];
	$live_inventory_quantity = $ProductList['live_inventory_quantity'];
	
	foreach($ProductList['size_list'] as $size_list)
	{
		$barcode = $size_list['barcodes'][0];
		$type = $size_list['type'];
		$size_id = $size_list['size_id'];
		$product_size = $size_list['size'];
		$size_live_inventory_quantity = $size_list['live_inventory_quantity'];
		$product_size_name = $size_list['product_size_name'];
		$product_unit = $size_list['product_unit'];
		$primary_tax_rate = $size_list['primary_tax_rate'];
		$price_sell = $size_list['price_sell'];	
		
		$CheckSql = mysql_query("SELECT pid FROM tbl_products_treez WHERE product_id = '".mysql_real_escape_string($product_id)."' AND size_id = '".mysql_real_escape_string($size_id)."'");
		if(mysql_num_rows($CheckSql) == 0){
		$SQL_INSERT_PRODUCT = mysql_query("INSERT INTO `tbl_products_treez`(`product_id`, `product_name_common`, `product_type`, `classifications`, `brand`, `totalCannabinoids`, `description`, `active`, `taxRate`, `test_result_url`, `total_doses`, `mg_dose`, `cbd_ratio`, `total_cannabinoids_percentage`, `thc_percentage`, `cbd_percentage`, `terpenes_percentage`, `size`, `medium`, `large_image`, `cropped_image`, `back_stock_inventory_quantity`, `menu_title`, `last_update_date`, `secondary_tax_rate`, `product_live_inventory_quantity`,`sub_types`,`default_price`,`size_id`,`product_name`,`product_size`,`primary_tax_rate`,`live_inventory_quantity`,`gk_inventory_quantity`,`barcode`,`product_unit`) VALUES ('".mysql_real_escape_string($product_id)."', '".mysql_real_escape_string($product_name)."', '".mysql_real_escape_string($product_type)."', '".mysql_real_escape_string($classifications)."', '".mysql_real_escape_string($brand)."', '".mysql_real_escape_string($totalCannabinoids)."', '".mysql_real_escape_string($description)."', '".mysql_real_escape_string($active)."', '".mysql_real_escape_string($taxRate)."', '".mysql_real_escape_string($test_result_url)."', '".mysql_real_escape_string($total_doses)."', '".mysql_real_escape_string($mg_dose)."', '".mysql_real_escape_string($cbd_ratio)."', '".mysql_real_escape_string($total_cannabinoids_percentage)."', '".mysql_real_escape_string($thc_percentage)."', '".mysql_real_escape_string($cbd_percentage)."', '".mysql_real_escape_string($terpenes_percentage)."', '".mysql_real_escape_string($size)."', '".mysql_real_escape_string($medium)."', '".mysql_real_escape_string($large_image)."', '".mysql_real_escape_string($cropped_image)."', '".mysql_real_escape_string($back_stock_inventory_quantity)."', '".mysql_real_escape_string($menu_title)."', '".mysql_real_escape_string($last_update_date)."', '".mysql_real_escape_string($secondary_tax_rate)."', '".mysql_real_escape_string($live_inventory_quantity)."', '".mysql_real_escape_string($sub_types)."', '".mysql_real_escape_string($price_sell)."','".mysql_real_escape_string($size_id)."','".mysql_real_escape_string($product_size_name)."','".mysql_real_escape_string($product_size)."','".mysql_real_escape_string($primary_tax_rate)."','".mysql_real_escape_string($size_live_inventory_quantity)."','".mysql_real_escape_string($size_live_inventory_quantity)."','".mysql_real_escape_string($barcode)."','".mysql_real_escape_string($product_unit)."')");
		}
		else{
			$pidRs = mysql_fetch_assoc($CheckSql);
			$pid = $pidRs['pid'];
			$assign_qtySql = mysql_fetch_assoc(mysql_query("SELECT SUM(avail_qty) as sum FROM tbl_planogram p INNER JOIN tbl_terminal t ON p.terminal_id = t.id  INNER JOIN tbl_customers c ON c.id=t.customer_id WHERE p.product_id='".$pid."' AND c.pos_assigned = 'Treez'"));
			$assign_qty = $assign_qtySql['sum'];
			$gk_qty = $size_live_inventory_quantity - $assign_qty;
			mysql_query("UPDATE `tbl_products_treez` SET `product_id` = '".mysql_real_escape_string($product_id)."', `product_name_common` = '".mysql_real_escape_string($product_name)."', `product_type` = '".mysql_real_escape_string($product_type)."', `classifications` = '".mysql_real_escape_string($classifications)."', `brand` = '".mysql_real_escape_string($brand)."', `totalCannabinoids` = '".mysql_real_escape_string($totalCannabinoids)."', `description` = '".mysql_real_escape_string($description)."', `active` = '".mysql_real_escape_string($active)."', `taxRate` = '".mysql_real_escape_string($taxRate)."', `test_result_url` = '".mysql_real_escape_string($test_result_url)."', `total_doses` = '".mysql_real_escape_string($total_doses)."', `mg_dose` = '".mysql_real_escape_string($mg_dose)."', `cbd_ratio` = '".mysql_real_escape_string($cbd_ratio)."', `total_cannabinoids_percentage` = '".mysql_real_escape_string($total_cannabinoids_percentage)."', `thc_percentage` = '".mysql_real_escape_string($thc_percentage)."', `cbd_percentage` = '".mysql_real_escape_string($cbd_percentage)."', `terpenes_percentage` = '".mysql_real_escape_string($terpenes_percentage)."', `size` = '".mysql_real_escape_string($size)."', `medium` = '".mysql_real_escape_string($medium)."', `large_image` = '".mysql_real_escape_string($large_image)."', `cropped_image` = '".mysql_real_escape_string($cropped_image)."', `back_stock_inventory_quantity` = '".mysql_real_escape_string($back_stock_inventory_quantity)."', `menu_title` = '".mysql_real_escape_string($menu_title)."', `last_update_date` = '".mysql_real_escape_string($last_update_date)."', `secondary_tax_rate` = '".mysql_real_escape_string($secondary_tax_rate)."', `product_live_inventory_quantity` = '".mysql_real_escape_string($live_inventory_quantity)."',`sub_types` = '".mysql_real_escape_string($sub_types)."',`default_price` = '".mysql_real_escape_string($price_sell)."',`size_id` = '".mysql_real_escape_string($size_id)."',`product_name` = '".mysql_real_escape_string($product_size_name)."',`product_size` = '".mysql_real_escape_string($product_size)."',`primary_tax_rate` = '".mysql_real_escape_string($primary_tax_rate)."',`live_inventory_quantity` = '".mysql_real_escape_string($size_live_inventory_quantity)."',`gk_inventory_quantity` = '".mysql_real_escape_string($gk_qty)."',`barcode` = '".mysql_real_escape_string($barcode)."',`product_unit` = '".mysql_real_escape_string($product_unit)."' WHERE product_id = '".mysql_real_escape_string($product_id)."' AND size_id = '".mysql_real_escape_string($size_id)."'");
		}
				
	}
}
}
}
echo "<script>alert('Product DEtails are Successfully Updated')</script>";
header('Location: index.php?action=product_treez_list');
?>