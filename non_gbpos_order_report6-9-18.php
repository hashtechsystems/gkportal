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
	
if(isset($_REQUEST['btnSearch']))
{
	if(isset($_REQUEST['selTer']) && $_REQUEST['selTer'] != 'all')
	{
		$search .= " AND o.terminal_id = '".$_REQUEST['selTer']."'";	
	}
	
	if(isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != '')
	{
		$fromDate = $_REQUEST['fromDate'];
		
		if(isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '')
		{
			$ToDate = $_REQUEST['toDate'];	
		}
		else
		{
			$ToDate = date('Y-m-d H:i:s');	
		}		
		$search .= " AND STR_TO_DATE(o.date_time, '%m/%d/%Y %H:%i') BETWEEN '".$fromDate." 00:00:00' AND '".$ToDate." 23:59:59' ";	
	}
}
?>
<div class="" id="container" style="margin-top:20px;">
  <div  class="w98">
  <h3 class="sectionhead">Overview</h3>
  <hr> 
  </div>
<div class="tpos rwebkit" style="display: -webkit-box; width:100%; position:relative; margin:;padding-top: 38px;">
<div class="row">
<div class="col-md-6"></div>
<div class="col-md-3"><input type="button" value="Push Order To Pos"></div>
<div class="col-md-3"><input type="button" value="Print Unpushed Orders"></div>
</div>	
<div class="row">
	<?php
		$cnt = 0;
		$SQL=mysql_query("SELECT o.order_id, o.ConsumerId, c.id as consumer_id, c.first_name, c.last_name, o.tax, o.order_final_total FROM `tbl_orders` o INNER JOIN `tbl_terminal` t  ON o.terminal_id = t.terminal_id INNER JOIN tbl_greenbits_customers c ON o.ConsumerId = c.c_id WHERE t.customer_id = '".$_SESSION['user_id']."' order by o.order_id DESC");
		while($DATA=mysql_fetch_array($SQL))
		{
			$cnt++;
	?>
<div class="col-md-2"></div>	
<div class="col-md-8" style="border: 2px solid black; padding:5px">	
	<div class="col-md-12" style="margin-bottom:5px;">
	<div class="col-md-2"><input type="checkbox">&nbsp;Order #<?= $cnt ?></div>
	<div class="col-md-6" style="border: 1px solid black;text-align: center;">
	<?php
		$customer = "";
		if(isset($DATA['first_name']) && $DATA['first_name'] != ""){
			$customer = $DATA['first_name']." ";
		}
		$customer .= $DATA['last_name'];
	?>
		<img alt="" src="barcode_generator/barcode.php?text=<?= $customer ?>" /><br>
		<?= $customer ?>
	</div>
	<div class="col-md-4" style="text-align:right;"><input type="button" value="Mark Order Push"></div>
	</div>
<?php
	 $PRSQL = mysql_query("SELECT p.product_name, p.sku, op.quantity, op.total_amount FROM tbl_order_products op INNER JOIN tbl_greenbits_inventory p ON p.id = op.product_id WHERE op.order_id = '".$DATA['order_id']."'");
	 while($PRDATA=mysql_fetch_array($PRSQL))
	{
?>
	<div class="col-md-12" style="margin:2px">
		<div class="col-md-8">
			<div class="col-md-10" style="border: 1px solid black;text-align:center">
			<img alt="" src="barcode_generator/barcode.php?text=<?= $PRDATA['sku']?>" /><br>
			<?= $PRDATA['product_name'] ?>
			</div>
		</div>
		<div class="col-md-2"><?= $PRDATA['quantity'] ?></div>
		<div class="col-md-2"><?= $PRDATA['total_amount'] ?></div>
	</div>
	<hr>
<?php
	}
?>
	<div class="col-md-12">
		<div class="col-md-8"></div>
		<div class="col-md-2">Tax</div>
		<div class="col-md-2"><?= $DATA['tax'] ?></div>
	</div>
	<div class="col-md-12">
		<div class="col-md-8"></div>
		<div class="col-md-2">Total</div>
		<div class="col-md-2"><?= $DATA['order_final_total'] ?></div>
	</div>
</div>	
	<?php
		}
	?>
</div>
 </div>
</div>