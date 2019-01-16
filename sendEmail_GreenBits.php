<?php
$OrderDetail = mysql_query("SELECT ConsumerId, pos_orderId,discount,tax,order_final_total FROM tbl_orders where order_id = '".mysql_real_escape_string($order)."'");
$date_time = date("m/d/Y h:i:sa");
$OrderDetail_data = mysql_fetch_assoc($OrderDetail);
$ConsumerId = $OrderDetail_data['ConsumerId'];
$PosOrderId = $OrderDetail_data['pos_orderId'];
$Discount = $OrderDetail_data['discount'];
$Tax = $OrderDetail_data['tax'];
$OrderFinalTotal = $OrderDetail_data['order_final_total'];
$posCustomer = mysql_fetch_assoc(mysql_query("SELECT name FROM tbl_customers WHERE id = '".mysql_real_escape_string($_SESSION['user_id'])."'"));
$posCustomerName = $posCustomer['name'];
$consumer_name = '';
$consumer_email = '';
/*
if($pos == "No Pos"){
	$conSql = mysql_query("SELECT ConsumerName,email FROM tbl_customers_no_pos WHERE id = '".mysql_real_escape_string($ConsumerId)."'");
	$conRow = mysql_fetch_assoc($conSql);
	$consumer_name = $conRow['ConsumerName'];
	$consumer_email = $conRow['email'];
}
elseif($pos == "MJ Freeway"){
	$conSql = mysql_query("SELECT first_name, last_name, email_address FROM tbl_consumer_mjfreeway WHERE cid = '".mysql_real_escape_string($ConsumerId)."'");
	$conRow = mysql_fetch_assoc($conSql);
	$consumer_name = $conRow['first_name']." ".$conRow['last_name'];
	$consumer_email = $conRow['email_address'];
}
elseif($pos == "Treez"){
	$conSql = mysql_query("SELECT first_name, last_name, email FROM tbl_customers_treez WHERE id = '".mysql_real_escape_string($ConsumerId)."'");
	$conRow = mysql_fetch_assoc($conSql);
	$consumer_name = $conRow['first_name']." ".$conRow['last_name'];
	$consumer_email = $conRow['email'];
}
elseif($pos == "Green Bits"){
*/
	$conSql = mysql_query("SELECT first_name, last_name, email, address_1,city,state,zip_code FROM tbl_greenbits_customers WHERE cid = '".mysql_real_escape_string($ConsumerId)."'");
	$conRow = mysql_fetch_assoc($conSql);
	$consumer_name = $conRow['first_name']." ".$conRow['last_name'];
	$consumer_email = $conRow['email'];
	$address = $conRow['address_1'];
	$city = $conRow['city'];
	$state = $conRow['state'];
	$zip = $conRow['zip_code'];

$message = '
<div style="width:700px;overflow:auto;margin:auto;border:solid 5px #00a19b;padding:0px;font-family:arial">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tbody>
			<tr>
				<td bgcolor="#00a19b" style="border-bottom:solid 5px #00a19b">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tbody>
							<tr>
								<td height="30" valign="middle"><h1 style="font-size:25px; color:#fff;">'.$posCustomerName.'</h1></td>
								<td align="right" valign="middle"><table width="60%" border="0" align="right" cellpadding="5" cellspacing="0" style="font-size:13px;color:#fff">
								  <tbody><tr>
								    <td align="left"><strong>Address </strong></td>
							      </tr>
								  <tr>
								    <td align="left">'.$address.'<br>
								      '.$city.' '.$state.' '.$zip.'</td>
							      </tr>
							    </tbody></table>&nbsp;</td>
						  </tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr style="border:solid 1px #ccc; ">
			  <td valign="top" ><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
			    <tbody>
			      <tr>
			        <td width="" height="15" bgcolor="#FFFFFF" style="border-bottom:solid 1px #fff; border-right:solid 1px #fff; font-size:15px;"><strong>Order No 	</strong>: '.$order.'</td>
		          </tr>
				  <tr>
			        <td width="" height="15" bgcolor="#FFFFFF" style="border-bottom:solid 1px #fff; border-right:solid 1px #fff; font-size:15px;"><strong>POS Ref No </strong>: '.$PosOrderId.'</td>
		          </tr>
			      <tr>
			        <td height="15" valign="top" bgcolor="#FFFFFF" style="border-bottom:solid 1px #ccc; font-size:13px;"> <span style="display:block;"> <strong>Date:</strong> '.$date_time.' </span>

&nbsp;</td>
		          </tr>
		        </tbody>
		      </table></td>
		  </tr>
			<tr style="border:solid 1px #ccc; ">
				<td valign="top" ><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
				  <tbody>
				  <tr>
				    <td height="22" colspan="4" bgcolor="#00a19b" style="border-bottom:solid 1px #ccc; font-size:20px; color:#fff;">Order Details</td>
				    </tr>
				  <tr>
				    <td width="64%" height="22" bgcolor="#FFFFFF" style="border-bottom:solid 1px #ccc; font-size:12px; border-right:solid 1px #ccc;"><strong>Products Name 
                    </strong></td>
				    <td width="9%" bgcolor="#FFFFFF" style="border-bottom:solid 1px #ccc; border-right:solid 1px #ccc; font-size:12px;"><strong>QTY</strong>&nbsp;</td>
				    <td width="15%" bgcolor="#FFFFFF" style="border-bottom:solid 1px #ccc; border-right:solid 1px #ccc; font-size:12px;"><strong>Unit Price</strong></td>
				    <td width="12%" bgcolor="#FFFFFF" style="border-bottom:solid 1px #ccc; font-size:12px;"><strong>Price</strong>&nbsp;</td>
				    </tr>';
$ordersProducts=mysql_query("SELECT * FROM `tbl_order_products` WHERE `order_id`='".mysql_real_escape_string($order)."'");
while($ordersProductsData=mysql_fetch_array($ordersProducts))
{
	$ProductID = $ordersProductsData['product_id'];
	$ProductQuantity = $ordersProductsData['quantity'];
	$ProductTotalPrice = $ordersProductsData['total_amount'];
	$ProductUnitPrice; $ProductName;
/*
	if($pos == "No Pos"){
		$PrSql = mysql_query("SELECT product_name, price FROM tbl_products WHERE product_id='".mysql_real_escape_string($ProductID)."'");
		$prRow = mysql_fetch_assoc($PrSql);
		$ProductName = $prRow['product_name'];
		$ProductUnitPrice = $prRow['price'];
	}
	elseif($pos == "MJ Freeway"){
		$PrSql = mysql_query("SELECT name, default_price FROM mj_freeway_products WHERE id='".mysql_real_escape_string($ProductID)."'");
		$prRow = mysql_fetch_assoc($PrSql);
		$ProductName = $prRow['name'];
		$ProductUnitPrice = $prRow['default_price'];
		
	}
	elseif($pos == "Treez"){
		$PrSql = mysql_query("SELECT product_name, default_price FROM tbl_products_treez WHERE pid='".mysql_real_escape_string($ProductID)."'");
		$prRow = mysql_fetch_assoc($PrSql);
		$ProductName = $prRow['product_name'];
		$ProductUnitPrice = $prRow['default_price'];
		
	}
	elseif($pos == "Green Bits"){
*/
		$PrSql = mysql_query("SELECT product_name, product_sell_price  FROM tbl_greenbits_inventory WHERE id='".mysql_real_escape_string($ProductID)."'");
		$prRow = mysql_fetch_assoc($PrSql);
		$ProductName = $prRow['product_name'];
		$ProductUnitPrice = $prRow['product_sell_price'];
	
	$message .= '<tr style="background:#fff;">
				 <td height="22" style="border-bottom:solid 1px #ccc;  border-right:solid 1px #ccc; font-size:12px;">'.$ProductName.'</td>
				 <td style="border-bottom:solid 1px #ccc;border-right:solid 1px #ccc; font-size:12px;">'.$ProductQuantity.'</td>
				 <td style="border-bottom:solid 1px #ccc;border-right:solid 1px #ccc; font-size:12px;">$'.$ProductUnitPrice.'</td>
				 <td style="border-bottom:solid 1px #ccc; font-size:12px;">$'.$ProductTotalPrice.'</td>
				 </tr>';
	
}					
		
	$message	.=	  '<tr style="background:#fff;">
				    <td height="22" colspan="4" align="right" style="border-bottom:solid 1px #ccc; font-size:15px; color:#5B5B5B; padding:0;"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
				      <tbody>
				        <tr style="background:#;">
				          <td height="2" colspan="2" align="right" bgcolor="#E5E5E5" style="border-bottom:solid 1px #ccc;   font-size:12px; height:2px;"></td>
			            </tr>
						<tr style="background:#fff;">
				          <td width="88%" height="22" align="right" style="border-bottom:solid 1px #ccc;   font-size:12px;"><strong>Total Discount :</strong></td>
				          <td style="border-bottom:solid 1px #ccc; font-size:12px;">[$'.$Discount.']</td>
			            </tr>
				        <tr style="background:#fff;">
				          <td width="88%" height="22" align="right" style="border-bottom:solid 1px #ccc;   font-size:12px;"><strong>Total Tax :</strong></td>
				          <td style="border-bottom:solid 1px #ccc; font-size:12px;">$'.$Tax.'</td>
			            </tr>
				        <tr style="background:#25c0a1;">
				          <td height="22" align="right" style="border-bottom:solid 1px #ccc; color:#fff;   font-size:20px;"><strong>Total :</strong>&nbsp;</td>
				          <td style="border-bottom:solid 1px #ccc; color:#fff; font-size:12px;">$ '.$OrderFinalTotal.'</td>
			            </tr>
			          </tbody>
			        </table></td>
				    </tr>
				  <tr style="background:#fff;">
				    <td height="22" colspan="4" align="center" style="border-bottom:solid 1px #ccc; font-size:30px; color:#323030;">Thank You</td>
				    </tr>
				  </tbody>
			  </table></td>
			</tr>
		</tbody>
	</table>
</div>';
$to = 'sg@hashtech.com,nitind@hashtech.com,'.$consumer_email;
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";	
$subject = 'Receipt for your recent purchase at '.$posCustomerName;
mail($to, $subject, $message, $headers);
?>