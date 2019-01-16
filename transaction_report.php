<? if($_SESSION['islogin']=="")
{
#	echo "In If";
?>
<script type="text/javascript">
document.location.href='login.php';
</script>
<?
}

	
$where = " where 1";
if(isset($_REQUEST['search']))
{
	$where.=" AND (`product_name` LIKE '%".$_REQUEST['search']."%' OR product_sku LIKE '%".$_REQUEST['search']."%')";
}
if(isset($_REQUEST['order_by']))
{
	$orderBy=" ORDER BY ".$_REQUEST['field']." ".$_REQUEST['order_by'];
	$where .=$orderBy;
}

if(isset($_REQUEST['Assign']))
{
		#echo "<pre>";
		#print_r($_REQUEST);
		#exit();
		for($i=1;$i<=$_REQUEST['Total'];$i++)
		{
			if($_REQUEST['prd'.$i]!="")
			{
				mysql_query("INSERT INTO `tbl_assigned_products`(`product_id`,`terminal_id`)VALUES('".$_REQUEST['prd'.$i]."','".$_REQUEST['terminal']."')");
			}
		}
	header("Location:index.php?action=product_list&s=1");		
}
?>

<div class="" id="container" style="margin-top:20px;">
  <div class="page-header">
    <h1> Transaction Report </h1>
  </div>
  <form action="" method="post">
  <table cellpadding="5" cellspacing="5" width="90%" align="center" class="table table-bordered">
  	
  </table>
  <? if(isset($_REQUEST['a']))
  {
	?>
    <span style="color:#FC070B">Product Added Successfully.</span>
    <?
  }
  if(isset($_REQUEST['u']))
  {
	?>
    <span style="color:#FC070B">Product Updated Successfully.</span>
    <?
  }
  ?>
  <?php
  $query1=mysql_query("SELECT * FROM `tbl_transactions`". $where);
	$priceTotal=0;
	$commissionTotal=0;
	while($data1=mysql_fetch_array($query1))
	{
		$commission=$data1['commission']*$data1['price'];
		$priceTotal=$priceTotal+$data1['price'];
		$commissionTotal=$commissionTotal+$commission;
	}
  
  ?><p>Transaction Total- $<?=$priceTotal;?></p><p>Commission Total- $<?=$commissionTotal;?></p>
  <table cellpadding="5" cellspacing="5" width="90%" align="center" class="table table-bordered">
    <tr>
      <th class="stat">Transaction Date</th>
      <th class="stat">Account</th>
      <th class="stat">Site</th>      
      <th class="stat">Machine</th>
      <th class="stat">Payment Type</th>
      <th class="stat">Slot</th>
      <th class="stat">Product Name</th>
      <th class="stat">Tax Rate</th>
      <th class="stat">Commission %</th>
      <th class="stat">Price</th>
      <th class="stat">Total Commission</th>
    </tr>
    <tr>
    
    </tr>
    
    <?	
	$query=mysql_query("SELECT * FROM `tbl_transactions`". $where);
	$cnt=0;
	$priceTotal=0;
	$commissionTotal=0;
	while($data=mysql_fetch_array($query))
	{
		$commission=$data['commission']*$data['price'];
		$priceTotal=$priceTotal+$data['price'];
		$commissionTotal=$commissionTotal+$commission;
		
	?>
    <tr>
      <td class="stat"><em><?php echo $data['trans_date']; ?></em></td>
      <td class="stat"><em><?php echo $data['account'];?></em></td>
      <td class="stat"><em><?php echo $data['site']; ?></em></td>
      <td class="stat"><em><?php echo $data['machine']; ?></em></td>
      <td class="stat"><em><?php echo $data['pay_type']; ?></em></td>
      <td class="stat"><em><?php echo $data['slot']; ?></em></td>
      <td class="stat"><em><?php echo $data['product_name']; ?></em></td>
      <td class="stat"><em><?php echo $data['tax_rate']; ?></em></td>
      <td class="stat"><em><?php echo $data['commission']; ?></em></td>
      <td class="stat"><em>$<?php echo $data['price']; ?></em></td>    
      <td class="stat"><em>$<?php echo $commission; ?></em></td>    
    </tr>
    <?php
	$cnt++;
	}
	?>
    <input type="hidden" name="Total" value="<?=$cnt;?>">
  </table>
  </form>
</div>
