<style>
tr td {
    font-weight: 500;
    color: #07586b;
    font-size: 15px;
    padding: 15px 5px !important;
    border-bottom: solid 1px #E8E6E6;}
</style>


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
	include("sendEmail_GreenBits.php");
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
			include("sendEmail_GreenBits.php");
		}
		echo "<script>alert('Orders Added To Pos Sucessfully')</script>";
	}
}
?>
<script>
function single_pos(order_id){	
	var form;
	form = '<form method="POST">';
	form += '<table class="table"><thead><td>For Order '+order_id+' -:<\/td><td><input type="text" name="pos_order" placeholder="Pos Order No."><input type="hidden" name="order" value="'+order_id+'"><\/td><\/tr> <\/thead>';
	form += '<tbody><tr style="text-align: left; "> <td style="border-bottom:none !important; "><input type="submit" name="push_to_pos_single" value="Push TO Pos" class="btn btn-info btn-sm"><\/td><\/tr><\/tbody><\/table>';
	form += '<\/form>';
	
	$("#PushToPos").html(form);
}

function multi_pos(){
	if($(':checkbox:checked').length > 0){
		var form;
		form = '<form method="POST"><table class="table"><thead>';
		$(':checkbox:checked').each(function(i){
		  var order_id = $(this).val();
		  form += '<td>For Order '+order_id+' -:<\/td>';
		  form += '<td><input type="hidden" name="order_ids[]" value="'+order_id+'" ><input type="text" name="pos_order'+order_id+'" placeholder="Pos Order No."><\/td>';
		  form += '<\/tr>';
		});
		form += '<\/thead><tbody><tr style="text-align: left; "><td style="border-bottom:none !important; "><input type="submit" name="push_to_pos_multi" value="Push TO Pos" class="btn btn-info btn-sm"><\/td><\/tr><\/tbody><\/table>';
		form += '<\/form>';
		$("#PushToPos").html(form);
	}
	else{
		$("#PushToPos").html('Please Check atleast One Order');
	}
}

function print_order(){
//	w=window.open();
	$('.nonprintable').hide();
//	w.document.write($('.printable').html());
//	w.print();
//	w.close();
	window.print();
	$('.nonprintable').show();
}
</script>
<div class="" id="container" style="margin-top:20px;">
  <div  class="page-header tbg2 heauto">
  <h1 class="sectionhead">Unpushed Orders
</h1>
  <hr> 
  </div>
  <div class="clearfix" style="width:100%; display: -webkit-box;"></div>
<div class="tpos rwebkit" style="width:100%;  margin:;padding-top: 38px;">
<div class="" style="width:100%; ">
<div class="col-md-6" style="text-align:center;"><button type="button" class="btn btn-info btn-sm nonprintable" data-toggle="modal" data-target="#myModal" onclick="multi_pos()" style="float:left;">Push Order To Pos</button></div>
<div class="col-md-6"><input type="button" value="Print Unpushed Orders" class="btn btn-info btn-sm nonprintable" style="float:right;" onclick="print_order()"></div>
</div>	
<div class="clearfix" style="display: -webkit-box;padding-top: 41px;"></div>
<div style="width:100%;">
	<?php
		$cnt = 0;
		$SQL=mysql_query("SELECT o.order_id, o.ConsumerId, c.id as consumer_id, c.first_name, c.last_name, o.tax, o.order_final_total, o.date_time FROM `tbl_orders` o INNER JOIN `tbl_terminal` t  ON o.terminal_id = t.terminal_id INNER JOIN tbl_greenbits_customers c ON o.ConsumerId = c.c_id WHERE t.customer_id = '".$_SESSION['user_id']."' AND pos_orderId = '' order by o.order_id DESC");
		while($DATA=mysql_fetch_array($SQL))
		{
			$cnt++;
	?>
<table class="table" style="width:98%; margin:auto;">	
	<tr class="" style="background:#ECECEC;">
	<td class=""><span style="font-size:20px; font-weight:600;"><input class="nonprintable" type="checkbox" value="<?= $DATA['order_id'] ?>" >&nbsp;Order #<?= $DATA['order_id'] ?></span><br><?= $DATA['date_time'] ?></td>
	<td class="" style="text-align: center; ">
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
	<td class="col-md-4" style="text-align:right;"><button type="button" class="btn btn-info btn-sm nonprintable" data-toggle="modal" data-target="#myModal" onclick="single_pos(<?= $DATA['order_id'] ?>)">Mark Order Push</button></td>
	</tr>
	<tr class="tbg" >
	  <th class="" style="width:80%; padding-bottom:0 !important;">Product Name</th>
	  <th class="" style="text-align:right;padding-bottom:0 !important;"> Qty</th>
	  <th class="" style="text-align:right;padding-bottom:0 !important;"> Amount</th>
	  </tr>
<?php
	 $PRSQL = mysql_query("SELECT p.product_name, p.sku, op.quantity, op.total_amount FROM tbl_order_products op INNER JOIN tbl_greenbits_inventory p ON p.id = op.product_id WHERE op.order_id = '".$DATA['order_id']."'");
	 while($PRDATA=mysql_fetch_array($PRSQL))
	{
?>
	<tr class="" >
		<td class="">
			<div style="text-align:left">
			<img alt="" src="barcode_generator/barcode.php?text=<?= $PRDATA['sku']?>" /><br>
			<?= $PRDATA['product_name'] ?>
			</div>
		</td>
		<td class="" style="text-align:right;"><?= $PRDATA['quantity'] ?></td>
		<td class="" style="text-align:right;"><?= $PRDATA['total_amount'] ?></td>
	</tr>
	
<?php
	}
?>
	<tr class="">
		<td class=""></td>
		<td class="" style="text-align:right; font-weight:600;">Tax</td>
		<td class="" style="text-align:right; font-weight:600;"><?= $DATA['tax'] ?></td>
	</tr>
	<tr class="">
		<td class=""></td>
		<td class="" style="text-align:right; font-weight:600;">Total</td>
		<td class="" style="text-align:right; font-weight:600;"><?= $DATA['order_final_total'] ?></td>
	</tr>
</table>	
<div style="padding:10px 0;"> </div>
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