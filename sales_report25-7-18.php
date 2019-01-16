<?php
if($_SESSION['islogin']=="")
{
?>
	<script type="text/javascript">
    document.location.href='login.php';
    </script>
<?
}
$where = '';
	
if(isset($_REQUEST['btnSearch']))
{
	$search = '';
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
		$where = $search;
	}
}
?>

<div class="" id="container" style="margin-top:20px;">
  <div class="page-header">
    <h1> Sales Summary Report </h1>
  </div>
  <form action="" method="post">
  <table cellpadding="0" cellspacing="0" border="0" width="99%" style="border:1px solid #8A8A8A;">
  	<tr>
    	<td style="padding:15px; background-color:#00b2a9;"><strong>Search Filters</strong></td>
    </tr>
    <tr>
    	<td style="padding:15px;">
        <table width="100%">
        	<tr>
            	<td align="right" style="width:200px; padding-right:15px;" height="40">Search By Dates : </td>
                <td align="left">
                <div>
               <div class="input-group" style="width:21%; float:left"> 
                  <input class="form-control date-picker" id="fromDate" name="fromDate" type="text" value="<?php if(isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != '') { echo $_REQUEST['fromDate'];}?>" placeholder="From Date" data-date-format="yyyy-mm-dd"/>
                  <span class="input-group-addon"> <i class="fa fa-calendar bigger-110"></i> </span> </div>
                  &nbsp;&nbsp;
               <div class="input-group" style="width:21%; float:left">
                  <input class="form-control date-picker" id="toDate" name="toDate" type="text" value="<?php if(isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') { echo $_REQUEST['toDate'];}?>" placeholder="To Date" data-date-format="yyyy-mm-dd"/>
                  <span class="input-group-addon"> <i class="fa fa-calendar bigger-110"></i> </span> </div>
                </div>&nbsp;&nbsp;&nbsp;
                <input type="submit" name="btnSearch" value="SEARCH" /></td>
            </tr>           
        </table>
        </td>
    </tr>
  </table>
  </form>
   <br />
  <table cellpadding="5" cellspacing="5" width="90%" align="center" class="table table-bordered">
    <tr style="background-color:#00b2a9;">
      <th class="stat" align="left">Terminal Id</th>
      <th class="stat" align="right">Card Total</th>      
      <th class="stat" align="right">Tax Total</th>
      <th class="stat" align="right">Total Sales</th>
    </tr>    
    <?php	
	$SQL_ACCOUNT=mysql_query("SELECT id, terminal_id FROM `tbl_terminal` WHERE customer_id = ".$_SESSION['user_id']);
	
	$CardTotal_Final = 0;
	$TaxTotal_Final = 0;
	$TotalSale_Final = 0;
		
	while($DATA_ACCOUNT=mysql_fetch_array($SQL_ACCOUNT))
	{
		$query1=mysql_query("SELECT order_total, tax, order_final_total FROM `tbl_orders` WHERE terminal_id = '".$DATA_ACCOUNT['terminal_id']."' ".$where);
		$CardTotal = 0;
		$TaxTotal = 0;
		$TotalSale=0;
		while($data1=mysql_fetch_array($query1))
		{
			$CardTotal = $CardTotal + $data1['order_total'];
			$TaxTotal = $TaxTotal + $data1['tax'];
			$TotalSale = $TotalSale + $data1['order_final_total'];
		}
		
		$CardTotal_Final = $CardTotal_Final + $CardTotal;
		$TaxTotal_Final = $TaxTotal_Final + $TaxTotal;
		$TotalSale_Final = $TotalSale_Final + $TotalSale;
		
	?>
    <tr>
      <td class="stat"><em><?php echo $DATA_ACCOUNT['terminal_id']; ?></em></td>
      <td class="stat" align="right">$<?php echo number_format($CardTotal, 2);?></td>
      <td class="stat" align="right">$<?php echo number_format($TaxTotal, 2); ?></td>
      <td class="stat" align="right">$<?php echo number_format($TotalSale, 2); ?></td>
    </tr>
    <?php
	$cnt++;
	}
	?>
   <tr style="font-weight:bold; background-color:#00b2a9;">
      <td class="stat"><em>Totals</em></td>
      <td class="stat" align="right">$<?php echo number_format($CardTotal_Final, 2);?></td>
      <td class="stat" align="right">$<?php echo number_format($TaxTotal_Final, 2); ?></td>
      <td class="stat" align="right">$<?php echo number_format($TotalSale_Final, 2); ?></td>
    </tr>
  </table>
 
</div>