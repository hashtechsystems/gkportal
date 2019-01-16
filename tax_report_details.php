<?php
if($_SESSION['islogin']=="")
{
?>
	<script type="text/javascript">
    document.location.href='login.php';
    </script>
<?
}


if(isset($_REQUEST['btnSearch']))
{
	
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
<div class="page-header tbg2" style="margin-top:20px;">
  <div class="col-md-8">
  <h1> Tax Details</h1>
  </div>
   <div class="col-md-4" style="text-align:right;"> <a href="index.php?action=total_tax_report" class="greenbtn1">Previous Page</a> </div>
</div>
  <div  class="w100">
   <form action="" method="post">
    <div class="col-md-6">  
     <div class="input-group" style="width:155px; float:left"> 
                  <input class="form-control date-picker dateinput" id="fromDate" name="fromDate" type="text" value="<?php if(isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != '') { echo $_REQUEST['fromDate'];}?>" placeholder="From" data-date-format="yyyy-mm-dd"/>
                 <span class="input-group-addon" style="border:none; background:none;"> <i class="fa"> <img src="images/date.jpg" alt=""/></i> </span></div>
                  
      <div class="input-group" style="width:155px; float:left">
                  <input class="form-control date-picker dateinput" id="toDate" name="toDate" type="text" value="<?php if(isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') { echo $_REQUEST['toDate'];}?>" placeholder="To" data-date-format="yyyy-mm-dd"/>
                 <span class="input-group-addon" style="border:none; background:none;"> <i class="fa"> <img src="images/date.jpg" alt=""/></i> </span> </div>
				<input type="submit" name="btnSearch" class="search" value="SEARCH" />
     </div>
   
   </form>
  
  
  </div>
<div class="tpos rwebkit" style="display: -webkit-box; width:100%; position:relative; margin:;padding-top: 38px;">  <table cellpadding="0" cellspacing="0" width="100%" align="center" class="table">
   <tr class="tbg">
      <th class="stat" align="left">Terminal Id</th>  
	  <th class="stat" align="right">Order Id</th>
      <th class="stat" align="right">Order Amount</th>
	  <th class="stat" align="right">Tax</th>
    </tr>    
    <?php	
	$PAGESQL=mysql_query("SELECT o.order_id, o.terminal_id, o.tax, o.order_final_total FROM `tbl_orders` o INNER JOIN `tbl_terminal` t  ON o.terminal_id = t.terminal_id WHERE t.customer_id = '".$_SESSION['user_id']."' AND t.id = '".mysql_real_escape_string($_REQUEST['id'])."' $search order by o.order_id DESC");
	$total_rows = mysql_num_rows($PAGESQL);
										  
	$pages = new Paginator;  
	$pages->items_total = $total_rows;  
	$pages->mid_range = 9;  
	$pages->paginate();
	
	$SQL=mysql_query("SELECT o.order_id, o.terminal_id, o.tax, o.order_final_total FROM `tbl_orders` o INNER JOIN `tbl_terminal` t  ON o.terminal_id = t.terminal_id WHERE t.customer_id = '".$_SESSION['user_id']."' AND t.id = '".mysql_real_escape_string($_REQUEST['id'])."' $search order by o.order_id DESC".$pages->limit);
		
	while($DATA=mysql_fetch_array($SQL))
	{
		
	?>
    <tr>
      <td align="left" class="stat"><em><?php echo $DATA['terminal_id']; ?></em></td>
	  <td align="left" class="stat"><em><?php echo $DATA['order_id']; ?></em></td>
      <td class="stat" align="left">$<?php echo number_format($DATA['order_final_total'], 2);?></td>
      <td class="stat" align="left">$<?php echo $DATA['tax'] ?></td>
    </tr>
    <?php
	}
	?>
	<tr style="background-color:#EBEBEB;">
        <td class="listData_First" align="left" height="30">
            <?php echo '<strong>Total Records</strong> = '.$total_rows; ?>
        </td>
        <td align="right" class="" height="30" colspan="5" style="padding-right:8px;">
            <?php echo "<strong>Page</strong> $pages->current_page of $pages->num_pages&nbsp;&nbsp;";  echo $pages->display_pages();?>
        </td>
    </tr>
  </table>
 </div>
</div>

 