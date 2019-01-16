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
if(isset($_REQUEST['selTerminal']))
{
	$where  = " AND t.terminal_id = '".mysql_real_escape_string($_REQUEST['selTerminal'])."'";
}	
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
		$search .= " AND STR_TO_DATE(ServerDateTime, '%Y-%m-%d %H:%i') BETWEEN '".$fromDate." 00:00:00' AND '".$ToDate." 23:59:59' ";	
	}
			
	if($search != '')
	{
		$where = $search;
	}
}

?>

<div class="" id="container" style="margin-top:20px;">
  <div  class="w100" style="text-align:center;">
 <!--  <img src="images/ghrap.jpg"  class="img-responsive" style="margin:auto;"  alt=""/> 
  <div id="curve_chart" style="width: 900px; height: 500px"></div>
  -->
  </div>
  <div  class="w98">
  <h3 class="sectionhead">Total Tax reports</h3>
  <hr>
  
  </div>
  <div class="clearfix" style="display: -webkit-box;"> </div>
 <div class="tableout tpos rwebkit" style="display: -webkit-box; width:100%; position:relative; margin:;padding-top: 38px;">
  <table cellpadding="0" cellspacing="0" width="100%" align="center" class="table ">
    <tr class="tbg">
      <th class="stat" align="">Terminal Id</th>
      <th class="stat" align="">Total Orders </th>      
      <th class="stat" align="">Total Tax</th>
	  <th class="stat" align="">Action</th>
    </tr>    
    <?php	
	$SQL_ACCOUNT= mysql_query("SELECT t.id, t.terminal_id, count(order_total) as orders, sum(tax) as tax FROM `tbl_orders` o INNER JOIN tbl_terminal t ON t.terminal_id = o.terminal_id WHERE t.customer_id = '".mysql_real_escape_string($_SESSION['user_id'])."' GROUP BY o.terminal_id");
	
	while($DATA_ACCOUNT=mysql_fetch_array($SQL_ACCOUNT))
	{
	
		
	?>
    <tr>
      <td class="stat"><?php echo $DATA_ACCOUNT['terminal_id']; ?></td>
      <td class="stat" align=""><?php echo $DATA_ACCOUNT['orders']; ?></td>
      <td class="stat" align="">$<?php echo $DATA_ACCOUNT['tax']; ?></td>
	  <td class="stat" align="center"><a href="index.php?action=tax_report_details&id=<?=$DATA_ACCOUNT['id'];?>"><img src="images/view-icon.png"   alt=""/></a></td>
    </tr>
    <?php
	
	}
	?>
   
  </table>
  </div>
 