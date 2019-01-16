<?php
if($_SESSION['islogin']=="")
{
?>
	<script type="text/javascript">
    document.location.href='login.php';
    </script>
<?
}
$search = '';
if(isset($_REQUEST['push_to_pos_single']))
{
	$pos_order = trim($_REQUEST['pos_order']);
	$order = trim($_REQUEST['order']);
	mysql_query("UPDATE tbl_orders SET pos_orderId  = '".mysql_real_escape_string($pos_order)."' where order_id = '".mysql_real_escape_string($order)."'");
	echo "<script>alert('Orders Added To Pos Sucessfully')</script>";
}	
if(isset($_REQUEST['push_to_pos_multi']))
{
	if(isset($_POST['order_ids'])) {
		//$cat = $_POST['multi_cat'];
		$order_ids = $_POST['order_ids'];
		foreach($order_ids as $order){
			$pos_order_name = "pos_order".$order;
			$pos_order = $_POST[$pos_order_name];
			mysql_query("UPDATE tbl_orders SET pos_orderId  = '".mysql_real_escape_string($pos_order)."' where order_id = '".mysql_real_escape_string($order)."'");
		}
		echo "<script>alert('Orders Added To Pos Sucessfully')</script>";
	}
}
?>
<script>
function single_pos(order_id){	
	var form;
	form = '<form method="POST">';
	form += '<table><thead><th>For Order '+order_id+' -:<\/th><th><input type="text" name="pos_order" placeholder="Pos Order No."><input type="hidden" name="order" value="'+order_id+'"><\/th><\/tr> <\/thead>';
	form += '<tbody><tr><td><input type="submit" name="push_to_pos_single" value="Push TO Pos"><\/td><\/tr><\/tbody><\/table>';
	form += '<\/form>';
	
	$("#PushToPos").html(form);
}

function multi_pos(){
	if($(':checkbox:checked').length > 0){
		var form;
		form = '<form method="POST"><table><thead>';
		$(':checkbox:checked').each(function(i){
		  var order_id = $(this).val();
		  form += '<tr><th>For Order '+order_id+' -:<\/th>';
		  form += '<th><input type="hidden" name="order_ids[]" value="'+order_id+'" ><input type="text" name="pos_order'+order_id+'" placeholder="Pos Order No."><\/th>';
		  form += '<\/tr>';
		});
		form += '<\/thead><tbody><tr><td><input type="submit" name="push_to_pos_multi" value="Push TO Pos"><\/td><\/tr><\/tbody><\/table>';
		form += '<\/form>';
		$("#PushToPos").html(form);
	}
	else{
		$("#PushToPos").html('Please Check atleast One Order');
	}
}
</script>
<div class="" id="container" style="margin-top:20px;">
  <div  class="w98">
  <h3 class="sectionhead">Overview</h3>
  <hr> 
  </div>
  <div class="clearfix" style="width:100%; display: -webkit-box;"></div>
<div class="tpos rwebkit" style="width:100%;  margin:;padding-top: 38px;">
<div class="" style="width:100%;display: -webkit-box; ">
<div class="col-md-3" style="text-align:center;"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal" onclick="multi_pos()">Push Order To Pos</button></div>
<div class="col-md-3" style="text-align:center;"><input type="button" value="Print Unpushed Orders"></div>
</div>	
<div class="clearfix" style="display: -webkit-box;"></div>
<div class=""  style="width:94%;  padding:3%">
	<?php
		$cnt = 0;
		$SQL=mysql_query("SELECT o.order_id, o.ConsumerId, c.id as consumer_id, c.first_name, c.last_name, o.tax, o.order_final_total FROM `tbl_orders` o INNER JOIN `tbl_terminal` t  ON o.terminal_id = t.terminal_id INNER JOIN tbl_greenbits_customers c ON o.ConsumerId = c.c_id WHERE t.customer_id = '".$_SESSION['user_id']."' order by o.order_id DESC");
		while($DATA=mysql_fetch_array($SQL))
		{
			$cnt++;
	?>

<table class="" style="border: 2px solid black; padding:5px">	
	<tr class="">
	<td class=""><input type="checkbox" value="<?= $DATA['order_id'] ?>" >&nbsp;Order #<?= $DATA['order_id'] ?></td>
	<td class="" style="border: 1px solid black;text-align: center;">
	<?php
		$customer = "";
		if(isset($DATA['first_name']) && $DATA['first_name'] != ""){
			$customer = $DATA['first_name']." ";
		}
		$customer .= $DATA['last_name'];
	?>
		<img alt="" src="barcode_generator/barcode.php?text=<?= $customer ?>" /><br>
		<?= $customer ?>
	</td>
	<td class="col-md-4" style="text-align:right;"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal" onclick="single_pos(<?= $DATA['order_id'] ?>)">Mark Order Push</button></td>
	</tr>
<?php
	 $PRSQL = mysql_query("SELECT p.product_name, p.sku, op.quantity, op.total_amount FROM tbl_order_products op INNER JOIN tbl_greenbits_inventory p ON p.id = op.product_id WHERE op.order_id = '".$DATA['order_id']."'");
	 while($PRDATA=mysql_fetch_array($PRSQL))
	{
?>
	<tr class="" style="margin:2px">
		<td class="col-md-8">
			<div style="border: 1px solid black;text-align:center">
			<img alt="" src="barcode_generator/barcode.php?text=<?= $PRDATA['sku']?>" /><br>
			<?= $PRDATA['product_name'] ?>
			</div>
		</td>
		<td class="col-md-2"><?= $PRDATA['quantity'] ?></td>
		<td class="col-md-2"><?= $PRDATA['total_amount'] ?></td>
	</tr>
	<hr>
<?php
	}
?>
	<tr class="">
		<td class=""></td>
		<td class="col-md-2">Tax</td>
		<td class="col-md-2"><?= $DATA['tax'] ?></td>
	</tr>
	<tr class="">
		<td class="col-md-8"></td>
		<td class="col-md-2">Total</td>
		<td class="col-md-2"><?= $DATA['order_final_total'] ?></td>
	</tr>
</table>	
	<?php
		}
	?>
</div>
 </div>
 <!---   Pop Up ---->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Pos Order Number</h4>
      </div>
      <div class="modal-body" id="PushToPos">
     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!---->
</div>