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
  <div class="page-header">
    <h1> Product Sales Report </h1>
  </div>
  <form action="" method="post">
  <table cellpadding="0" cellspacing="0" border="0" width="99%" style="border:1px solid #8A8A8A;">
  	<tr>
    	<td style="padding:15px; background-color:#00b2a9; color:#ffffff;"><strong>Search Filters</strong></td>
    </tr>
    <tr>
    	<td style="padding:15px;">
        <table width="100%">        	            
            <tr>
            	<td align="right" style="width:200px; padding-right:15px;" height="40">Search By Terminal : </td>
                <td align="left">
                <select name="selMachine">
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
                </select>
                </td>
            </tr>
            <tr>
            	<td align="right" style="width:200px; padding-right:15px;" height="40">Search By Dates : </td>
                <td align="left">
                <div>
               <div class="input-group" style="width:21%; float:left"> 
                  <input class="form-control date-picker" id="fromDate" name="fromDate" type="text" value="<?php if(isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != '') { echo $_REQUEST['fromDate'];}?>" placeholder="From Date" data-date-format="yyyy-mm-dd" />
                  <span class="input-group-addon"> <i class="fa fa-calendar bigger-110"></i> </span> </div>
                  &nbsp;&nbsp;
               <div class="input-group" style="width:21%; float:left">
                  <input class="form-control date-picker" id="toDate" name="toDate" type="text" value="<?php if(isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') { echo $_REQUEST['toDate'];}?>" placeholder="To Date" data-date-format="yyyy-mm-dd" />
                  <span class="input-group-addon"> <i class="fa fa-calendar bigger-110"></i> </span> </div>
                </div>              
                </td>
            </tr>
            <tr>
            	<td align="right" style="width:200px; padding-right:15px;" height="40">&nbsp;</td>
                <td align="left">
               <input type="submit" name="btnSearch" value="SEARCH" />
                </td>
            </tr>
        </table>
        </td>
    </tr>
  </table>
  </form>
  <br />
  <table cellpadding="5" cellspacing="5" width="90%" align="center" class="table table-bordered">
    <tr style="background-color:#00b2a9; color:#ffffff;">
      <th class="stat">Terminal Id</th>
      <th class="stat" align="right">Number of Sales</th>      
      <th class="stat" align="right">Value of Sales</th>
    </tr>
    <?php	
	$SQL_ACCOUNT=mysql_query("SELECT id, terminal_id FROM `tbl_terminal` WHERE customer_id = ".$_SESSION['user_id']);
	$FinalQty = 0;
	$FinalSales = 0;
	$TerminalIds = '';
	while($DATA_ACCOUNT=mysql_fetch_array($SQL_ACCOUNT))
	{		
		$query2=mysql_query("SELECT count(`terminal_id`) as totProd, sum(`order_final_total`) as totPrice, `order_id`, `terminal_id` FROM tbl_orders ". $where. " AND terminal_id = '".$DATA_ACCOUNT['terminal_id']."' GROUP BY `terminal_id` ");
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
          <td class="stat"><?php echo $terminal_id;?></td>
          <td class="stat" align="right"><?php echo $TotalQty2; ?></td>
          <td class="stat" align="right">$<?php echo number_format($PriceTotal2, 2); ?></td>    
        </tr>
        <?php
		$FinalQty = $FinalQty + $TotalQty2;
		$FinalSales = $FinalSales + $PriceTotal2;
	}
	?>    
   <tr style="background-color:#00b2a9; font-weight:bold;">
      <td class="stat">Total </td>
      <td class="stat" align="right"><?php echo $FinalQty; ?></td>
      <td class="stat" align="right">$<?php echo number_format($FinalSales, 2); ?></td>    
    </tr>
  </table>
  <br />
    
  <table cellpadding="5" cellspacing="5" width="90%" align="center" class="table table-bordered">
    <tr style="background-color:#00b2a9; color:#ffffff;">
      <th class="stat">Product Name</th>
      <th class="stat" align="right">Number of Sales</th>      
      <th class="stat" align="right">Value of Sales</th>
    </tr>
    
    
    <?php	
	
	$SQL1=mysql_query("SELECT count(`product_name`) as totProd, sum(`total_amount`) as totPrice, `product_name` FROM tbl_order_products ". $where ."  group by `product_name` ");
	$total_rows = mysql_num_rows($SQL1);
										  
	$pages = new Paginator;  
	$pages->items_total = $total_rows;  
	$pages->mid_range = 9;  
	$pages->paginate();
	
	$query=mysql_query("SELECT count(`product_name`) as totProd, sum(`total_amount`) as totPrice, `product_name` FROM tbl_order_products ". $where ." group by `product_name` ".$pages->limit);
	
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
      <td class="stat"><?php echo $data['product_name']; ?></td>
      <td class="stat" align="right"><?php echo $data['totProd']; ?></td>
      <td class="stat" align="right">$<?php echo number_format($data['totPrice'], 2); ?></td>    
    </tr>
    <?php
	$cnt++;
	}
	}
	?>
   <tr style="background-color:#00b2a9; font-weight:bold;">
      <td class="stat">Total </td>
      <td class="stat" align="right"><?php echo $TotalQty; ?></td>
      <td class="stat" align="right">$<?php echo number_format($PriceTotal, 2); ?></td>    
    </tr>
    <tr style="background-color:#e4e4e4;">
        <td class="listData_First" align="left" height="30" >
            <?php echo '<strong>Total Records</strong> = '.$total_rows; ?>
        </td>
        <td align="right" class="" height="30" colspan="11" style="padding-right:8px;">
            <?php echo "<strong>Page</strong> $pages->current_page of $pages->num_pages&nbsp;&nbsp;";  echo $pages->display_pages();?>
        </td>
    </tr>
  </table>
 
</div>