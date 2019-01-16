<?php
if($_SESSION['islogin']=="")
{
?>
	<script type="text/javascript">
    document.location.href='login.php';
    </script>
<?
}
?>
<div class="" id="container" style="margin-top:20px;">
  <div class="page-header tbg heauto">
  <div class="col-md-8 p40"> <h1 class="">  Order Details </h1></div>
  <div class="col-md-4 textleft" style="text-align:right;">  <a href="index.php?action=order_transactions_report&page=<?=$_REQUEST['page'];?>&ipp=<?=$_REQUEST['ipp'];?>" class="greenbtn1">Previous Page</a></div>
   
   
  </div>

<?php
$query=mysql_query("SELECT * FROM `tbl_orders` WHERE order_id = '".mysql_real_escape_string($_REQUEST['id'])."'");
$datao=mysql_fetch_array($query);

$order_id = $datao['order_id'];
$posorder_id = $datao['pos_orderId'];
$terminal_id = $datao['terminal_id'];
$date_time = $datao['date_time'];
$order_total = $datao['order_total'];	
$order_tax = $datao['tax'];
$order_final_total = $datao['order_final_total'];
$consumer_id = $datao['ConsumerId'];

if($_SESSION['user_id'] == '1' && !empty($consumer_id)){
	
	$sql = mysql_query("SELECT first_name, middle_name, last_name FROM tbl_consumer_mjfreeway WHERE consumer_id = '".mysql_real_escape_string($consumer_id)."'");
	$datac=mysql_fetch_array($sql);
	$consumer = $datac['first_name'];
	if(!empty($datac['middle_name']));
		$consumer .= " ".$datac['middle_name'];
	
	$consumer .= " ".$datac['last_name'];

}
elseif(($_SESSION['user_id'] == '3' || $_SESSION['user_id'] == '5') && !empty($consumer_id)){
	$sql = mysql_query("SELECT ConsumerName FROM tbl_customers_no_pos WHERE id = '".mysql_real_escape_string($consumer_id)."'");
	$datac=mysql_fetch_array($sql);
	$consumer = $datac['ConsumerName'];
}
elseif($_SESSION['AssignedPOS'] == "Green Bits" && $consumer_id != "" ){
	$sql = mysql_query("SELECT first_name, last_name FROM tbl_greenbits_customers WHERE c_id = '".mysql_real_escape_string($consumer_id)."'");
	$datac=mysql_fetch_array($sql);
	if($datac['first_name'] != "");
		$consumer .= " ".$datac['first_name'];
	
	$consumer .= " ".$datac['last_name'];

}
elseif($_SESSION['AssignedPOS'] == "Treez" && $consumer_id != "" ){
	$sql = mysql_query("SELECT first_name, last_name FROM tbl_customers_treez WHERE id = '".mysql_real_escape_string($consumer_id)."'");
	$datac=mysql_fetch_array($sql);
	if($datac['first_name'] != "");
		$consumer .= " ".$datac['first_name'];
	
	$consumer .= " ".$datac['last_name'];

}

?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="left" class="text">
	  <tr>
		<td align="left" width="200"><b>Order Id</b></td>
		<td width="50">:</td>
		<td height="40" class="textbox-bg2" align="left"><?= $order_id ?></td>
	  </tr>
	  <tr>
		<td align="left" width="200"><b>Pos Order Id</b></td>
		<td width="50">:</td>
		<td height="40" class="textbox-bg2" align="left"><?= $posorder_id ?></td>
	  </tr>
	  <tr>
		<td align="left" width="200"><b>Consumer Name</b></td>
		<td width="50">:</td>
		<td height="40" class="textbox-bg2" align="left"><?= $consumer ?></td>
	  </tr>
	  <tr>
		<td align="left" width="200"><b>Terminal Id</b></td>
		<td width="50">:</td>
		<td height="40" class="textbox-bg2" align="left"><?= $terminal_id ?></td>
	  </tr>
	  <tr>
		<td align="left" width="200"><b>Order Date</b></td>
		<td width="50">:</td>
		<td height="40" class="textbox-bg2" align="left"><?= $date_time ?></td>
	  </tr>
	  <tr>
		<td align="left" width="200"><b>Order Amount</b></td>
		<td width="50">:</td>
		<td height="40" class="textbox-bg2" align="left"><?= $order_total ?></td>
	  </tr>
	  <tr>
		<td align="left" width="200"><b>Tax</b></td>
		<td width="50">:</td>
		<td height="40" class="textbox-bg2" align="left"><?= $order_tax ?></td>
	  </tr>
	  <tr>
		<td align="left" width="200"><b>Order Final Amount</b></td>
		<td width="50">:</td>
		<td height="40" class="textbox-bg2" align="left"><?= $order_final_total ?></td>
	  </tr>
	  <tr>
		<td height="40" align="left" width="200"><b>Ordered Product</b></td>
		<td width="50">:-</td>
        <td width="" class="textbox-bg2"> </td>
	  </tr>
       <tr >
		<td height="30" align="left" width="200" style="border-bottom:none !important;"></td>
		<td width="50" style="border-bottom:none !important;"></td>
        <td width="" class="" style="border-bottom:none !important;"> </td>
	  </tr>
	  <tr>
     
	  <table cellpadding="0" cellspacing="0" width="90%" align="center" class="table">
      
		<tr class="tbg">
		  <th class="stat">Id</th>
		  <th class="stat">Product Name</th>
		  <th class="stat">Product Price</th>
		  <th class="stat">Quantity</th>
		  <th class="stat">Total Price</th>
		</tr>
		<?php	
		$product_table = "tbl_products";$id = "product_id";$name = "product_name";$price = "price";
		if($_SESSION['user_id'] == '1'){
			$product_table = "mj_freeway_products";
			$id = "id";
			$name = "name";
			$price = "default_price";
		}
		elseif($_SESSION['user_id'] == '2'){
			$product_table = "tbl_products_treez";
			$id = "pid";
			$price = "default_price";
		}
	
		$query=mysql_query("SELECT op.product_id, p.$name as product, op.product_unit_price as product_price, op.quantity, op.total_amount FROM `tbl_order_products` op INNER JOIN $product_table p ON op.product_id = p.$id WHERE op.order_id = '".mysql_real_escape_string($_REQUEST['id'])."'");
		$cnt=0;$total = 0;
		while($data=mysql_fetch_array($query))
		{	
		$cnt++;	
		$total = $total + $data['total_amount'];
		?>
		<tr>
		  <td class="stat"><?php echo $cnt; ?></td>
		  <td class="stat"><?php echo $data['product'] ?></a></td>
		  <td class="stat"><?php echo $data['product_price'] ?></a></td>
		  <td class="stat"><?php echo $data['quantity'] ?></a></td>
		  <td class="stat"><?php echo $data['total_amount'] ?></a></td>
		</tr>
		<?php
		}
		?>
		<tr style="background-color:#EBEBEB;">
		  <td colspan="4" class="stat" align="right"><b>Total Amount</b></td>
		  <td class="stat"><?= number_format($total,2); ?></td>
		</tr>
	  </table>
      
	 <tr align="left">
		<td >&nbsp;</td>
		<td width="20"></td>
		<td>&nbsp;</td>
		<td width="20"></td>
	  </tr>
	</table>
                       
</div>