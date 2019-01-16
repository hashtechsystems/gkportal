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
  <div  class="w100" style="text-align:center;">
  <img src="images/ghrap.jpg" width="100%" style="margin:auto;"  alt=""/> </div>
  <div  class="w98">
  <h3 class="sectionhead">Overview</h3>
  <hr>
  
  </div>
  <div class="row" style="background:#fff; display:block; margin:0;  ">
  <div class="col-md-4 w32" style="text-align:center; margin:1% 0;">
  <div class="easy-pie-chart percentage" data-percent="55" data-color="#27c6a0" style="height: 75px; width: 75px; line-height: 74px; color: rgb(135, 206, 235);">
													<span class="percent">55</span>%
												<canvas height="158" width="158"></canvas></div><br>
                                                <div class="infobox-data">
												<span class="infobox-text">Product Sales</span>

												<div class="infobox-content">
													<span class="bigger-110">S6,6900</span>
													$8,900
												</div>
											</div>

  </div>
  <div class="col-md-4 w32" style="text-align:center;margin:1% 0;"">
  <div class="easy-pie-chart percentage" data-percent="55" data-color="#078184" style="height: 75px; width: 75px; line-height: 74px; color: rgb(135, 206, 235);">
													<span class="percent">20</span>%
												<canvas height="158" width="158"></canvas></div><br>
                                                <div class="infobox-data">
												<span class="infobox-text">Tax Sales</span>

												<div class="infobox-content">
													<span class="bigger-110">S6,6900</span>
													$8,900
												</div>
											</div>

  </div>
  <div class="col-md-4 w32" style="text-align:center; margin:1% 0;"">
  <div class="easy-pie-chart percentage" data-percent="80" data-color="#a5ead8" style="height: 75px; width: 75px; line-height: 74px; color: rgb(135, 206, 235);">
													<span class="percent">55</span>%
												<canvas height="158" width="158"></canvas></div><br>
                                                <div class="infobox-data">
												<span class="infobox-text">Product Sales</span>

												<div class="infobox-content">
													<span class="bigger-110">S6,6900</span>
													$8,900
												</div>
											</div>

  </div>
  <div class="clearfix" style="display: -webkit-box;"></div>
  
  
  
  </div>
  <div  class="w98">
  <h3 class="sectionhead">all sale summary reports</h3>
  <hr>
  
  </div>
  <div  class="w100">
  <form action="" method="post">
  <div class="col-md-6"> <div class="input-group" style="width:155px; float:left"> 
                  <input class="form-control date-picker dateinput" id="fromDate" name="fromDate" type="text" value="<?php if(isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != '') { echo $_REQUEST['fromDate'];}?>" placeholder="FROM" data-date-format="yyyy-mm-dd"/ >
                  <span class="input-group-addon" style="border:none; background:none;"> <i class="fa"> <img src="images/date.jpg" alt=""/></i> </span> </div>  
  <div class="input-group" style="width:155px; float:left">
                  <input class="form-control date-picker dateinput" id="toDate" name="toDate" type="text" value="<?php if(isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') { echo $_REQUEST['toDate'];}?>" placeholder="TO" data-date-format="yyyy-mm-dd"/ >
                  <span class="input-group-addon" style="border:none; background:none;"> <i class="fa "> <img src="images/date.jpg" alt=""/></i> </span> </div> </div>
                  
                  
                   <div class="col-md-6">
																<form name="sortForm" id="sortForm" action="index.php?action=employee_list" method="post">
																<select id="order_by" name="order_by" class="form-control selectboxg fleft" style="max-width:200px;" onchange="javascript: sortForm.submit();">
																<option value="default">Default</option>
																<option value="recent" selected="">Recent</option>
                                                                <option value="ename_asc">A-Z</option>
																<option value="ename_desc">Z-A</option>		
															</select>&nbsp;&nbsp;&nbsp; <input type="submit" name="btnSearch" class="search" value="SEARCH" />
															</form>
															
  </div>
  
  
  <div class="clearfix" style="display: -webkit-box;"> </div>
  
 <div class="tableout" style="display: -webkit-box; width:97%; position:relative; margin:30px auto 0 auto;padding-top: 38px;">
  <table cellpadding="0" cellspacing="0" width="100%" align="center" class="table ">
    <tr class="tbg">
      <th class="stat" align="">Terminal Id</th>
      <th class="stat" align="">Cart Total</th>      
      <th class="stat" align="">Tax Total</th>
      <th class="stat" align="">Total Sales</th>
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
      <td class="stat"><?php echo $DATA_ACCOUNT['terminal_id']; ?></td>
      <td class="stat" align="">$<?php echo number_format($CardTotal, 2);?></td>
      <td class="stat" align="">$<?php echo number_format($TaxTotal, 2); ?></td>
      <td class="stat" align="">$<?php echo number_format($TotalSale, 2); ?></td>
    </tr>
    <?php
	$cnt++;
	}
	?>
   <tr style="font-weight:bold; background-color:#EBEBEB;">
      <td class="stat">Totals</td>
      <td class="stat" align="">$<?php echo number_format($CardTotal_Final, 2);?></td>
      <td class="stat" align="">$<?php echo number_format($TaxTotal_Final, 2); ?></td>
      <td class="stat" align="">$<?php echo number_format($TotalSale_Final, 2); ?></td>
    </tr>
  </table>
  </div>
 
