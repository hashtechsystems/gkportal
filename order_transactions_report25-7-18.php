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
  <div class="page-header">
    <h1> Transaction Report </h1>
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
				
            	<td align="right" style="width:200px; padding-right:15px;" height="40">Search By Terminal Id : </td>
                <td align="left">
                <select name="selTer">
                	<option value="all">ALL</option>
					<?php
					$SQL_TER= mysql_query("SELECT terminal_id FROM `tbl_terminal` WHERE customer_id = '".$_SESSION['user_id']."'");
					while($DATA_TER = mysql_fetch_assoc($SQL_TER))
					{
						?>
                        <option value="<?php echo $DATA_TER['terminal_id'];?>" <?php if(isset($_REQUEST['selTer']) && $_REQUEST['selTer'] == $DATA['terminal_id']) { echo 'selected';}?> ><?php echo $DATA_TER['terminal_id'];?></option>
                        <?php
					}
					?>
                </select>
                </td>
        
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
				 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="btnSearch" value="SEARCH" />
                </div>
				</td>
         
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
	  <th class="stat" align="right">Order Id</th>
      <th class="stat" align="right">Order Amount</th>
      <th class="stat" align="right">Date Time</th>
	  <th class="stat" align="right">Action</th>
    </tr>    
    <?php	
	$PAGESQL=mysql_query("SELECT o.order_id, o.terminal_id, o.date_time, o.order_final_total FROM `tbl_orders` o INNER JOIN `tbl_terminal` t  ON o.terminal_id = t.terminal_id WHERE t.customer_id = '".$_SESSION['user_id']."' $search order by o.order_id DESC");
	$total_rows = mysql_num_rows($PAGESQL);
										  
	$pages = new Paginator;  
	$pages->items_total = $total_rows;  
	$pages->mid_range = 9;  
	$pages->paginate();
	
	$SQL=mysql_query("SELECT o.order_id, o.terminal_id, o.date_time, o.order_final_total FROM `tbl_orders` o INNER JOIN `tbl_terminal` t  ON o.terminal_id = t.terminal_id WHERE t.customer_id = '".$_SESSION['user_id']."' $search order by o.order_id DESC".$pages->limit);
		
	while($DATA=mysql_fetch_array($SQL))
	{
		
	?>
    <tr>
      <td class="stat"><em><?php echo $DATA['terminal_id']; ?></em></td>
	  <td class="stat"><em><?php echo $DATA['order_id']; ?></em></td>
      <td class="stat" align="right">$<?php echo number_format($DATA['order_final_total'], 2);?></td>
      <td class="stat" align="right"><?php echo $DATA['date_time'] ?></td>
      <td class="stat" align="right"><a href="index.php?action=order_details_report&id=<?=$DATA['order_id'];?>&page=<?=$_REQUEST['page'];?>&ipp=<?=$_REQUEST['ipp'];?>">View Details</a></td>
    </tr>
    <?php
	}
	?>
	<tr style="background-color:#e4e4e4;">
        <td class="listData_First" align="left" height="30">
            <?php echo '<strong>Total Records</strong> = '.$total_rows; ?>
        </td>
        <td align="right" class="" height="30" colspan="5" style="padding-right:8px;">
            <?php echo "<strong>Page</strong> $pages->current_page of $pages->num_pages&nbsp;&nbsp;";  echo $pages->display_pages();?>
        </td>
    </tr>
  </table>
 
</div>