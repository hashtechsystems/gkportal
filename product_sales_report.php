<?php 
if($_SESSION['islogin']=="")
{
?>
<script type="text/javascript">
document.location.href='login.php';
</script>
<?php
}

$where2 = '';
if(isset($_REQUEST['selCat']) && $_REQUEST['selCat'] != 'none')
{
	$search = '';
	$cat = trim($_REQUEST['selCat']);
	$pr_id;
	$sql;
	if($_SESSION['AssignedPOS'] == 'MJ Freeway'){
		$pr_id = 'id';
		$sql = "SELECT id as pid FROM mj_freeway_products WHERE category_name = '".mysql_real_escape_string($cat)."'";
	}
	elseif($_SESSION['AssignedPOS'] == 'Green Bits'){
		$pr_id = 'id';
		$sql = "SELECT p.id as pid FROM tbl_greenbits_inventory p INNER JOIN tbl_greenbits_product_type c ON p.product_type_id = c.id WHERE c.name = '".mysql_real_escape_string($cat)."'";
	}
	elseif($_SESSION['AssignedPOS'] == 'Treez'){
		$pr_id = 'pid';
		$sql = "SELECT pid as pid FROM tbl_products_treez WHERE product_type = '".mysql_real_escape_string($cat)."'";
	}
	else{
		$pr_id = 'product_id';
		$sql = "SELECT product_id as pid FROM tbl_products WHERE product_category = '".mysql_real_escape_string($cat)."'";
	}
	
	$ids = array();
	$IDSSQL = mysql_query($sql);
	while($DATA = mysql_fetch_assoc($IDSSQL))
	{
		$ids[] = $DATA['pid'];
	}
	if(!empty($ids)){
		$ids_str = implode(",",$ids);
		$ids_str = rtrim($ids_str,',');
		$where2 = " AND p.$pr_id in ($ids_str)";
	}
}

$where = " WHERE 1";
if(isset($_REQUEST['selTime']) && $_REQUEST['selTime'] != 'none')
{
	$search = '';
	$fromDate;
	if($_REQUEST['selTime'] == 'daily'){
		$fromDate = date('Y-m-d', strtotime('-1 days'));
	}
	
	if($_REQUEST['selTime'] == 'weekly'){
		$fromDate = date('Y-m-d', strtotime('-7 days'));
	}
	
	if($_REQUEST['selTime'] == 'monthly'){
		$fromDate = date('Y-m-d', strtotime('-30 days'));
	}
	
	if($_REQUEST['selTime'] == 'yearly'){
		$fromDate = date('Y-m-d', strtotime('-365 days'));
	}

	$ToDate = date('Y-m-d');

	if(isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '')
	{
		$ToDate = $_REQUEST['toDate'];	
	}
	else
	{
		$ToDate = date('Y-m-d H:i:s');	
	}		
	$search .= " AND STR_TO_DATE(date_time, '%m/%d/%Y %H:%i') BETWEEN '".$fromDate." 00:00:00' AND '".$ToDate." 23:59:59' ";
	
	if($search != '')
	{
		$where = " WHERE 1 " . $search;
	}
}

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
<!--
  <img src="images/ghrap.jpg" width="" class="img-responsive" style="margin:auto;"  alt=""/>
-->
<div id="curve_chart" style="width: 900px; height: 500px"></div>
</div>
  <div  class="w98">
  <h3 class="sectionhead">Overview</h3>
  <hr>
  
  </div>
   <div  class="w100">
   <form action="" method="post">
   <div class="col-md-5"> 
    <div class="input-group" style="width:155px; float:left"> 
                  <input class="form-control date-picker dateinput" id="fromDate" name="fromDate" type="text" value="<?php if(isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != '') { echo $_REQUEST['fromDate'];}?>" placeholder="From" data-date-format="yyyy-mm-dd" />
                  <span class="input-group-addon" style="border:none; background:none;"> <i class="fa"> <img src="images/date.jpg" alt=""/></i> </span> </div>
                  
        <div class="input-group" style="width:155px; float:left">
                  <input class="form-control date-picker dateinput" id="toDate" name="toDate" type="text" value="<?php if(isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') { echo $_REQUEST['toDate'];}?>" placeholder="To " data-date-format="yyyy-mm-dd" />
                  <span class="input-group-addon" style="border:none; background:none;"> <i class="fa"> <img src="images/date.jpg" alt=""/></i> </span></div>
                  
                  
   
   
   </div>
      <div class="col-md-3"><select name="selMachine" class="selectboxg lright">
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
   <form name="searchByTime" action="" method="post">
   <div class="col-md-3"> 
		<div class="col-md-3">
		<select name="selTime" class="selectboxg lright" onchange="javascript: searchByTime.submit();">
            <option value="none">Select Period</option>
			<option value="daily" <?php if(isset($_REQUEST['selTime']) && $_REQUEST['selTime'] == "daily") { echo 'selected';}?>>Daily</option>
			<option value="weekly" <?php if(isset($_REQUEST['selTime']) && $_REQUEST['selTime'] == "weekly") { echo 'selected';}?>>Weekly</option>
			<option value="monthly" <?php if(isset($_REQUEST['selTime']) && $_REQUEST['selTime'] == "monthly") { echo 'selected';}?>>Monthly</option>
			<option value="yearly" <?php if(isset($_REQUEST['selTime']) && $_REQUEST['selTime'] == "yearly") { echo 'selected';}?>>Yearly</option>
            </select>&nbsp;&nbsp;&nbsp; 
		</div> 
   </div>
   </form>
   <form method="POST" action="download_product_sales_report.php">
    <input type="submit" name="downloadExcel" class="search" value="Excel" />
  </form>
   </div>
   <div class="clearfix" style="display: -webkit-box;"></div>
  <div class="tpos rwebkit" style="display: -webkit-box; width:100%; position:relative; margin:0;padding-top: 38px; ">
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
   <form name="searchByCat" action="" method="post">
   <div class="col-md-3"> 
		<div class="col-md-3">
		<select name="selCat" class="selectboxg lright" onchange="javascript: searchByCat.submit();">
            <option value="none">Select Category</option>
<?php
$cat_sql;
	if($_SESSION['AssignedPOS'] == 'MJ Freeway'){
		$cat_sql = "SELECT DISTINCT category_name as cat FROM mj_freeway_products";
	}
	elseif($_SESSION['AssignedPOS'] == 'Green Bits'){
		$cat_sql = "SELECT DISTINCT name as cat FROM tbl_greenbits_product_type";
	}
	elseif($_SESSION['AssignedPOS'] == 'Treez'){
		$cat_sql = "SELECT DISTINCT product_type as cat FROM tbl_products_treez";
	}
	else{
		$cat_sql = "SELECT DISTINCT product_category as cat FROM tbl_products";
	}

	$CATSQL = mysql_query($cat_sql);
	while($DATA_CAT = mysql_fetch_assoc($CATSQL))
	{
		?>
		<option value="<?php echo $DATA_CAT['cat'];?>" <?php if(isset($_REQUEST['selCat']) && $_REQUEST['selCat'] == $DATA_CAT['cat']) { echo 'selected';}?> ><?php echo $DATA_CAT['cat'];?></option>
		<?php
	}
?>
            </select>&nbsp;&nbsp;&nbsp; 
		</div> 
   </div>
   </form>
  
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
		$product_name = 'product_name';
		$product_tbl = 'tbl_greenbits_inventory';
		$product_id = 'id';
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
	
	$SQL1=mysql_query("SELECT count(op.product_id) as totProd, sum(op.total_amount) as totPrice, p.$product_name FROM tbl_order_products op INNER JOIN tbl_orders o ON o.order_id = op.order_id INNER JOIN tbl_terminal t ON o.terminal_id = t.terminal_id INNER JOIN $product_tbl p ON op.product_id = p.$product_id ". $where ." ". $where2 ." AND t.customer_id = '".$_SESSION['user_id']."' group by `product_name` ");
	$total_rows = mysql_num_rows($SQL1);
										  
	$pages = new Paginator;  
	$pages->items_total = $total_rows;  
	$pages->mid_range = 9;  
	$pages->paginate();
	
	$query=mysql_query("SELECT sum(op.quantity) as totProd, sum(op.total_amount) as totPrice, p.$product_name as product_name FROM tbl_order_products op INNER JOIN tbl_orders o ON o.order_id = op.order_id INNER JOIN tbl_terminal t ON o.terminal_id = t.terminal_id INNER JOIN $product_tbl p ON op.product_id = p.$product_id ". $where ." ". $where2 ." AND t.customer_id = '".$_SESSION['user_id']."' group by `product_name` ".$pages->limit);

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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<?php
$to_date = date('Y-m-d');
$from_date = date('Y-m-1');
$query=mysql_query("SELECT o.order_final_total, date_time FROM tbl_orders o INNER JOIN tbl_terminal t ON o.terminal_id = t.terminal_id WHERE t.customer_id = '".$_SESSION['user_id']."' AND STR_TO_DATE(date_time, '%m/%d/%Y %H:%i') BETWEEN '".$from_date." 00:00:00' AND '".$to_date." 23:59:59' ORDER BY date_time ASC");
$chart_cur = array();
while($data=mysql_fetch_array($query))
{
	$day = date('d', strtotime($data['date_time']));
	if(isset($chart_cur[$day])){
		$chart_cur[$day] = $chart_cur[$day] + $data['order_final_total'];
	}
	else{
		$chart_cur[$day] = $data['order_final_total'];
	}
}

$firstD = new DateTime("first day of last month");
$lastD = new DateTime("last day of last month");
$from_date =  $firstD->format('Y-m-d');
$to_date = $lastD->format('Y-m-d');
$query=mysql_query("SELECT o.order_final_total, date_time FROM tbl_orders o INNER JOIN tbl_terminal t ON o.terminal_id = t.terminal_id WHERE t.customer_id = '".$_SESSION['user_id']."' AND STR_TO_DATE(date_time, '%m/%d/%Y %H:%i') BETWEEN '".$from_date." 00:00:00' AND '".$to_date." 23:59:59' ORDER BY date_time ASC");
$chart_pre = array();
while($data=mysql_fetch_array($query))
{
	$day = date('d', strtotime($data['date_time']));
	if(isset($chart_pre[$day])){
		$chart_pre[$day] = $chart_pre[$day] + $data['order_final_total'];
	}
	else{
		$chart_pre[$day] = $data['order_final_total'];
	}
}
$chart = array();
for($i = 1;$i<=31;$i++){
   if (array_key_exists($i,$chart_cur))
   {
	   $chart[$i]['c'] = $chart_cur[$i];
   }
   else{
	    $chart[$i]['c'] = 0;
   }
   if (array_key_exists($i,$chart_pre))
   {
	   $chart[$i]['p'] = $chart_pre[$i];
   }
   else{
	    $chart[$i]['p'] = 0;
   }
}
?>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Current Month', 'Past Month'],
          ['1',  <?= $chart[1]['c'] ?>, <?= $chart[1]['p'] ?>],
          ['2',  <?= $chart[2]['c'] ?>, <?= $chart[2]['p'] ?>],
          ['3',  <?= $chart[3]['c'] ?>, <?= $chart[3]['p'] ?>],
          ['4',  <?= $chart[4]['c'] ?>, <?= $chart[4]['p'] ?>],
		  ['5',  <?= $chart[5]['c'] ?>, <?= $chart[5]['p'] ?>],
          ['6',  <?= $chart[6]['c'] ?>, <?= $chart[6]['p'] ?>],
		  ['7',  <?= $chart[7]['c'] ?>, <?= $chart[7]['p'] ?>],
          ['8',  <?= $chart[8]['c'] ?>, <?= $chart[8]['p'] ?>],
		  ['9',  <?= $chart[9]['c'] ?>, <?= $chart[9]['p'] ?>],
          ['10',  <?= $chart[10]['c'] ?>,<?= $chart[10]['p'] ?>],
		  ['11',  <?= $chart[11]['c'] ?>, <?= $chart[11]['p'] ?>],
          ['12',  <?= $chart[12]['c'] ?>, <?= $chart[12]['p'] ?>],
          ['13',  <?= $chart[13]['c'] ?>, <?= $chart[13]['p'] ?>],
          ['14',  <?= $chart[14]['c'] ?>, <?= $chart[14]['p'] ?>],
		  ['15',  <?= $chart[15]['c'] ?>, <?= $chart[15]['p'] ?>],
          ['16',  <?= $chart[16]['c'] ?>, <?= $chart[16]['p'] ?>],
		  ['17',  <?= $chart[17]['c'] ?>, <?= $chart[17]['p'] ?>],
          ['18',  <?= $chart[18]['c'] ?>, <?= $chart[18]['p'] ?>],
		  ['19',  <?= $chart[19]['c'] ?>, <?= $chart[19]['p'] ?>],
          ['20',  <?= $chart[20]['c'] ?>,<?= $chart[20]['p'] ?>],
		  ['21',  <?= $chart[21]['c'] ?>, <?= $chart[21]['p'] ?>],
          ['22',  <?= $chart[22]['c'] ?>, <?= $chart[22]['p'] ?>],
          ['23',  <?= $chart[23]['c'] ?>, <?= $chart[23]['p'] ?>],
          ['24',  <?= $chart[24]['c'] ?>, <?= $chart[24]['p'] ?>],
		  ['25',  <?= $chart[25]['c'] ?>, <?= $chart[25]['p'] ?>],
          ['26',  <?= $chart[26]['c'] ?>, <?= $chart[26]['p'] ?>],
		  ['27',  <?= $chart[27]['c'] ?>, <?= $chart[27]['p'] ?>],
          ['28',  <?= $chart[28]['c'] ?>, <?= $chart[28]['p'] ?>],
		  ['29',  <?= $chart[29]['c'] ?>, <?= $chart[29]['p'] ?>],
          ['30',  <?= $chart[30]['c'] ?>,<?= $chart[30]['p'] ?>],
		  
        ]);

        var options = {
          title: 'Sales Performance',
         // curveType: 'function',
		  hAxis: {
                  title: 'Days'
		  },
		  vAxis: {
                  title: 'Total Sales in $'
		  },
		  width:1000,
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
</script>