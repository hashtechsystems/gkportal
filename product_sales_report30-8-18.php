<?php 
if($_SESSION['islogin']=="")
{
?>
<script type="text/javascript">
document.location.href='login.php';
</script>
<?php
}

	
$where = " WHERE 1";
if(isset($_REQUEST['btnSearch']))
{
	$search = '';
		
	if(isset($_REQUEST['selMachine']) && $_REQUEST['selMachine'] != 'all')
	{
		$search .= " AND machine = '".$_REQUEST['selMachine']."'";	
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
		$search .= " AND STR_TO_DATE(date_time, '%m/%d/%Y %H:%i') BETWEEN '".$fromDate." 00:00:00' AND '".$ToDate." 23:59:59' ";	
	}
	
	if($search != '')
	{
		$where = " WHERE 1 " . $search;
	}
}
?>

<div class="" id="container" style="margin-top:20px;">

<div  class="w100" style="text-align:center;">
  <img src="images/ghrap.jpg" width="" style="margin:auto;"  alt=""/> </div>
  <div  class="w98">
  <h3 class="sectionhead">Overview</h3>
  <hr>
  
  </div>
   <div  class="w100">
   <form action="" method="post">
   <div class="col-md-6"> 
    <div class="input-group" style="width:155px; float:left"> 
                  <input class="form-control date-picker dateinput" id="fromDate" name="fromDate" type="text" value="<?php if(isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != '') { echo $_REQUEST['fromDate'];}?>" placeholder="From" data-date-format="yyyy-mm-dd" />
                  <span class="input-group-addon" style="border:none; background:none;"> <i class="fa"> <img src="images/date.jpg" alt=""/></i> </span> </div>
                  
        <div class="input-group" style="width:155px; float:left">
                  <input class="form-control date-picker dateinput" id="toDate" name="toDate" type="text" value="<?php if(isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') { echo $_REQUEST['toDate'];}?>" placeholder="To " data-date-format="yyyy-mm-dd" />
                  <span class="input-group-addon" style="border:none; background:none;"> <i class="fa"> <img src="images/date.jpg" alt=""/></i> </span></div>
                  
                  
   
   
   </div>
      <div class="col-md-6"><select name="selMachine" class="selectboxg lright">
                	<option value="all">ALL</option>
					<?php
					$SQL_MACHINE = mysql_query("SELECT id, terminal_id FROM `tbl_terminal` WHERE customer_id = ".$_SESSION['user_id']);
					while($DATA_MACHINE = mysql_fetch_assoc($SQL_MACHINE))
					{
						?>
                        <option value="<?php echo $DATA_MACHINE['terminal_id'];?>" <?php if(isset($_REQUEST['selMachine']) && $_REQUEST['selMachine'] == $DATA_MACHINE['terminal_id']) { echo 'selected';}?> ><?php echo $DATA_MACHINE['terminal_id'];?></option>
                        <?php
					}
					?>
                </select>&nbsp;&nbsp;&nbsp; <input type="submit" name="btnSearch" class="search" value="SEARCH" /></div> 
   
   
   </form>
   
   </div>
   <div class="clearfix" style="display: -webkit-box;"></div>
  <div class="" style="display: -webkit-box; width:97%; position:relative; margin:30px auto 0 auto;padding-top: 38px; ">
  <table cellpadding="0" cellspacing="0" width="100%" align="center" class="table ">
    <tr class="tbg">
      <th class="stat">Terminal Id</th>
      <th class="stat" align="">Number of Sales</th>      
      <th class="stat" align="">Value of Sales</th>
    </tr>
    <?php	
	$SQL_ACCOUNT=mysql_query("SELECT id, terminal_id FROM `tbl_terminal` WHERE customer_id = ".$_SESSION['user_id']);
	$FinalQty = 0;
	$FinalSales = 0;
	$TerminalIds = '';
	while($DATA_ACCOUNT=mysql_fetch_array($SQL_ACCOUNT))
	{		
		$query2=mysql_query("SELECT count(`order_id`) as totProd, sum(`order_final_total`) as totPrice, `order_id`, `terminal_id` FROM tbl_orders ". $where. " AND terminal_id = '".$DATA_ACCOUNT['terminal_id']."' GROUP BY `terminal_id` ");
		$cnt=0;
		$PriceTotal2=0;
		$TotalQty2=0;
		while($data2=mysql_fetch_array($query2))
		{
			if($TerminalIds == '')
			{
				$TerminalIds = $data2['terminal_id'];
			}
			else
			{
				$TerminalIds = $TerminalIds .", ". $data2['terminal_id'];
			}
			
			$terminal_id = $data2['terminal_id'];
			$PriceTotal2=$PriceTotal2+$data2['totPrice'];
			$TotalQty2=$TotalQty2+$data2['totProd'];
			$cnt++;
		}	
		?>
        <tr>
          <td align="left" class="stat"><?php echo $terminal_id;?></td>
          <td class="stat" align="left"><?php echo $TotalQty2; ?></td>
          <td class="stat" align="left">$<?php echo number_format($PriceTotal2, 2); ?></td>    
        </tr>
        <?php
		$FinalQty = $FinalQty + $TotalQty2;
		$FinalSales = $FinalSales + $PriceTotal2;
	}
	?>    
  <tr style="font-weight:bold; background-color:#EBEBEB;">
      <td align="left" class="stat">TOTAL </td>
      <td class="stat" align="left"><?php echo $FinalQty; ?></td>
      <td class="stat" align="left">$<?php echo number_format($FinalSales, 2); ?></td>    
    </tr>
  </table>
  </div>
  <hr>
    <div class="tableout" style="display: -webkit-box; width:97%; position:relative; margin:30px auto 0 auto;padding-top: 0;">
  <table cellpadding="0" cellspacing="0" width="100%" align="center" class="table ">
     <tr class="tbg">
      <th class="stat">Product Name</th>
      <th class="stat" align="">Number of Sales</th>      
      <th class="stat" align="">Value of Sales</th>
    </tr>
    
    
    <?php	
	$product_name; $product_tbl; $product_id;
	if($_SESSION['AssignedPOS'] == 'MJ Freeway'){
		$product_name = 'name';
		$product_tbl = 'mj_freeway_products';
		$product_id = 'id';
	}
	elseif($_SESSION['AssignedPOS'] == 'Green Bits'){
		$product_name = 'name';
		$product_tbl = 'tbl_greenbits_products';
		$product_id = 'p_id';
	}
	elseif($_SESSION['AssignedPOS'] == 'Treez'){
		$product_name = 'product_name';
		$product_tbl = 'tbl_products_treez';
		$product_id = 'pid';
	}
	else{
		$product_name = 'product_name';
		$product_tbl = 'tbl_products';
		$product_id = 'product_id';
	}
	
	$SQL1=mysql_query("SELECT count(op.product_id) as totProd, sum(op.total_amount) as totPrice, p.$product_name FROM tbl_order_products op INNER JOIN tbl_orders o ON o.order_id = op.order_id INNER JOIN tbl_terminal t ON o.terminal_id = t.terminal_id INNER JOIN $product_tbl p ON op.product_id = p.$product_id ". $where ." AND t.customer_id = '".$_SESSION['user_id']."' group by `product_name` ");
	$total_rows = mysql_num_rows($SQL1);
										  
	$pages = new Paginator;  
	$pages->items_total = $total_rows;  
	$pages->mid_range = 9;  
	$pages->paginate();
	
	$query=mysql_query("SELECT count(op.product_id) as totProd, sum(op.total_amount) as totPrice, p.$product_name as product_name FROM tbl_order_products op INNER JOIN tbl_orders o ON o.order_id = op.order_id INNER JOIN tbl_terminal t ON o.terminal_id = t.terminal_id INNER JOIN $product_tbl p ON op.product_id = p.$product_id ". $where ." AND t.customer_id = '".$_SESSION['user_id']."' group by `product_name` ".$pages->limit);
	
	$cnt=0;
	$PriceTotal=0;
	$TotalQty=0;
	if($total_rows > 0)
	{
	  if(isset($_REQUEST['page']))
	  {
		  $j = ($_REQUEST['page'] - 1) * 10;
	  }
	  else
		  $j = 0;
		  
	  $cnt = $j + 1;
	while($data=mysql_fetch_array($query))
	{
		$PriceTotal=$PriceTotal+$data['totPrice'];
		$TotalQty=$TotalQty+$data['totProd'];
		
	?>
    <tr>
      <td align="left" class="stat"><?php echo $data['product_name']; ?></td>
      <td class="stat" align="left"><?php echo $data['totProd']; ?></td>
      <td class="stat" align="left">$<?php echo number_format($data['totPrice'], 2); ?></td>    
    </tr>
    <?php
	$cnt++;
	}
	}
	?>
   <tr style="background-color:#EBEBEB; font-weight:bold;">
      <td align="left" class="stat">Total </td>
      <td class="stat" align="left"><?php echo $TotalQty; ?></td>
      <td class="stat" align="left">$<?php echo number_format($PriceTotal, 2); ?></td>    
    </tr>
    <tr style="background-color:#EBEBEB;">
        <td class="listData_First" align="left" height="30" >
            <?php echo '<strong>Total Records</strong> = '.$total_rows; ?>
        </td>
        <td align="right" class="" height="30" colspan="11" style="padding-right:8px;">
            <?php echo "<strong>Page</strong> $pages->current_page of $pages->num_pages&nbsp;&nbsp;";  echo $pages->display_pages();?>
        </td>
    </tr>
  </table>
  </div>
 
</div>