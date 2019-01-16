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
		for($i=1;$i<=$_REQUEST['Total'];$i++)
		{
			if($_REQUEST['prd'.$i]!="")
			{
				mysql_query("INSERT INTO `tbl_assigned_products`(`product_id`,`terminal_id`)VALUES('".$_REQUEST['prd2']."','".$_REQUEST['terminal']."')");
			}
		}
	header("Location:index.php?action=product_list&s=1");		
}
?>

<div class="" id="container" style="margin-top:20px;">
  <div class="page-header">
    <h1> Assigned Products </h1>
  </div>
  <!--<form action="" method="post">
  <table cellpadding="5" cellspacing="5" width="90%" align="center" class="table table-bordered">
  	<tr>
    	<td>
        	<input type="text" name="search" placeholder="Search" value="<?=$_REQUEST['search'];?>">&nbsp;&nbsp;&nbsp;<input type="submit" value="Search">
        </td>
    </tr>
  </table>
  </form>-->
  <form action="" method="post">
    
  <table cellpadding="5" cellspacing="5" width="90%" align="center" class="table table-bordered">
    <tr>
      <th class="stat"></th>
      <th class="stat">SKU</th>
      <th class="stat">Product Name</th>
      <th class="stat">Terminal</th>
      <th class="stat">Type</th>      
      <th class="value">Action</th>
    </tr>
    <tr>
    
    </tr>
    <?php	
	$query=mysql_query("SELECT * FROM `tbl_assigned_products`". $where);
	$cnt=0;
	while($data=mysql_fetch_array($query))
	{
		$getProductDetails=mysql_fetch_array(mysql_query("SELECT * FROM `tbl_products` WHERE `product_id`='".$data['product_id']."'"));
		$getTerminalDetails=mysql_fetch_array(mysql_query("SELECT * FROM `tbl_terminal` WHERE `id`='".$data['terminal_id']."'"));
		$cnt++;
	?>
    <tr>
      <td class="stat"><em><?=$cnt;?></em></td>
      <td class="stat"><em><?php echo $getProductDetails['product_sku']; ?></em></td>
      <td class="stat"><em><?php echo $getProductDetails['product_name']; ?></em></td>
      <td class="stat"><em><?php echo $getTerminalDetails['terminal_id']; ?></em></td>
      <td class="stat"><em><?php echo $getProductDetails['product_type']; ?></em></td>
      <td> 
      <? $checkIfStock=mysql_fetch_array(mysql_query("SELECT * FROM `tbl_terminal_stock` WHERE `terminal_id`='".$data['terminal_id']."' AND `product_id`='".$data['product_id']."'"));
	  if($checkIfStock)
	  {
		  ?>
          	<input type="text" disabled value="<?=$checkIfStock['capacity'];?>" max="4" size="4">&nbsp;&nbsp;<input type="text" disabled value="<?=$checkIfStock['fill_quantity'];?>" max="4" size="4">&nbsp;&nbsp;<input type="text" disabled value="<?=$checkIfStock['current_stock'];?>" max="4" size="4">
         <a href="index.php?action=place&id=<?=$data['id'];?>">Adjust Stock</a>
          <?
	  }
	  else
	  {
	  ?>
      <a href="index.php?action=place&id=<?=$data['id'];?>">Place Product In Matrix</a>
      <?
	  }
	  ?>
      &nbsp;&nbsp;&nbsp;<a href="index.php?action=remove_assign&id=<?=$data['id'];?>">Remove</a></td>
    </tr>
    <?php
	}
	?>
    <input type="hidden" name="Total" value="<?=$cnt;?>">
  </table>
  </form>
</div>
