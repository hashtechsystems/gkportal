<?php
if(isset($_POST['UpdateProduct'])){
require_once('DatabaseControl/dbConnect.php');
mysql_query("CREATE TABLE `tbl_greenbits_inventory_backup` LIKE `tbl_greenbits_inventory`");
mysql_query("INSERT INTO `tbl_greenbits_inventory_backup` SELECT * FROM `tbl_greenbits_inventory`");
$offset = 0;
while(1){
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.greenbits.com/api/v2/inventory_items?limit=50&offset=$offset&sellable=true",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "authorization: Token Wb3vY2xUhkAz6TrsmnXisg",
    "cache-control: no-cache",
    "content-type: application/json",
	"X-GB-Client: herer-web 0.0.0",
    "postman-token: 45c169be-6305-467f-a37d-e633607e45ca"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

 $res= json_decode($response);
 $products = $res->inventory_items;
// print_r($products);exit;
 if(empty($products)){
	 break;
 }
 foreach($res->inventory_items as $r)
 {
 	#echo "<pre>";
	#print_r($r);
 	#exit();
 	$inventory_id=mysql_real_escape_string($r->id);
	$sku=mysql_real_escape_string($r->sku);
	$quantity=mysql_real_escape_string($r->quantity->value);
	$weight=mysql_real_escape_string($r->weight);
	$purchase_price=mysql_real_escape_string($r->purchase_price);
	$lot_number=mysql_real_escape_string($r->lot_number);
	$sell_type=mysql_real_escape_string($r->sell_type);
	$sample=mysql_real_escape_string($r->sample);
	$transferred_out=mysql_real_escape_string($r->transferred_out);
	$received_at=mysql_real_escape_string($r->received_at);
	$metadata=mysql_real_escape_string($r->metadata);
	$test_results_thc=mysql_real_escape_string($r->test_results_thc);
	$test_results_cbd=mysql_real_escape_string($r->test_results_cbd);
	$product_id=mysql_real_escape_string($r->product->id);
	$product_name=mysql_real_escape_string($r->product->name);
	$product_sell_price=mysql_real_escape_string($r->product->sell_price);
	$product_sell_price = bcdiv($product_sell_price, '100', 2);  
	$product_collect_excise_tax=mysql_real_escape_string($r->product->collect_excise_tax);
	$product_quantity=mysql_real_escape_string($r->product->quantity->value);
	$product_pricing_type=mysql_real_escape_string($r->product->pricing_type);
	$product_vendor=mysql_real_escape_string($r->product->vendor);
	$product_active=mysql_real_escape_string($r->product->active);
	$product_latest_sku=mysql_real_escape_string($r->product->latest_sku);
	$product_weight_value=mysql_real_escape_string($r->product->weight->value);
	$product_weight_unit=mysql_real_escape_string($r->product->weight->unit);
	$product_tags=mysql_real_escape_string($r->product->tags);
	$product_description=mysql_real_escape_string($r->product->description);
	$product_internal_notes=mysql_real_escape_string($r->product->internal_notes);
	$product_metadata=mysql_real_escape_string($r->product->metadata);
	$product_test_results_thc=mysql_real_escape_string($r->product->test_results_thc);
	$product_test_results_cbd=mysql_real_escape_string($r->product->test_results_cbd);
	$product_flower_type=mysql_real_escape_string($r->product->flower_type);
	$product_concentrate_type=mysql_real_escape_string($r->product->concentrate_type);
	$product_category_id=mysql_real_escape_string($r->product->category_id);
	$product_brand_id=mysql_real_escape_string($r->product->brand_id);
	$product_strain_id=mysql_real_escape_string($r->product->strain_id);
	$product_type_id=mysql_real_escape_string($r->product->product_type_id);	
	
	$check=mysql_num_rows(mysql_query("SELECT * FROM `tbl_greenbits_inventory` WHERE `sku`='".$sku."'"));
	if($check==0)
	{
		mysql_query("INSERT INTO `tbl_greenbits_inventory` (`inventory_id`, `sku`, `quantity`, `weight`, `purchase_price`, `lot_number`, `sell_type`, `sample`, `transferred_out`, `received_at`, `metadata`, `test_results_thc`, `test_results_cbd`, `product_id`, `product_name`, `product_sell_price`, `product_collect_excise_tax`, `product_quantity`, `product_pricing_type`, `product_vendor`, `product_active`, `product_latest_sku`, `product_weight_value`, `product_weight_unit`, `product_tags`, `product_description`, `product_internal_notes`, `product_metadata`, `product_test_results_thc`, `product_test_results_cbd`, `product_flower_type`, `product_concentrate_type`, `product_category_id`, `product_brand_id`, `product_strain_id`, `product_type_id`) VALUES ('".$inventory_id."', '".$sku."', '".$quantity."', '".$weight."', '".$purchase_price."', '".$lot_number."', '".$sell_type."', '".$sample."', '".$transferred_out."', '".$received_at."', '".$metadata."', '".$test_results_thc."', '".$test_results_cbd."', '".$product_id."', '".$product_name."', '".$product_sell_price."', '".$product_collect_excise_tax."', '".$product_quantity."', '".$product_pricing_type."', '".$product_vendor."', '".$product_active."', '".$product_latest_sku."', '".$product_weight_value."', '".$product_weight_unit."', '".$product_tags."', '".$product_description."', '".$product_internal_notes."', '".$product_metadata."', '".$product_test_results_thc."', '".$product_test_results_cbd."', '".$product_flower_type."', '".$product_concentrate_type."', '".$product_category_id."', '".$product_brand_id."', '".$product_strain_id."', '".$product_type_id."')");
	}
	else
	{
		mysql_query("UPDATE `tbl_greenbits_inventory` SET `inventory_id`='".$inventory_id."', `quantity`='".$quantity."', `weight`='".$weight."', `purchase_price`='".$purchase_price."', `lot_number`='".$lot_number."', `sell_type`='".$sell_type."', `sample`='".$sample."', `transferred_out`='".$transferred_out."', `received_at`='".$received_at."', `metadata`='".$metadata."', `test_results_thc`='".$test_results_thc."', `test_results_cbd`='".$test_results_cbd."', `product_id`='".$product_id."', `product_name`='".$product_name."', `product_sell_price`='".$product_sell_price."', `product_collect_excise_tax`='".$product_collect_excise_tax."', `product_quantity`='".$product_quantity."', `product_pricing_type`='".$product_pricing_type."', `product_vendor`='".$product_vendor."', `product_active`='".$product_active."', `product_latest_sku`='".$product_latest_sku."', `product_weight_value`='".$product_weight_value."', `product_weight_unit`='".$product_weight_unit."', `product_tags`='".$product_tags."', `product_description`='".$product_description."', `product_internal_notes`='".$product_internal_notes."', `product_metadata`='".$product_metadata."', `product_test_results_thc`='".$product_test_results_thc."', `product_test_results_cbd`='".$product_test_results_cbd."', `product_flower_type`='".$product_flower_type."', `product_concentrate_type`='".$product_concentrate_type."', `product_category_id`='".$product_category_id."', `product_brand_id`='".$product_brand_id."', `product_strain_id`='".$product_strain_id."', `product_type_id`='".$product_type_id."' WHERE `sku`='".$sku."'");
	}
	
 }
 $offset = $offset + 50;
}
}
header('Location: index.php?action=product_greenbits_list');
?>
