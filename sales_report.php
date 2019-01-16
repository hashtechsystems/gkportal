<?php
if($_SESSION['islogin']=="")
{
?>
	<script type="text/javascript">
    document.location.href='login.php';
    </script>
<?
}

/*
$hrSql = mysql_query("SELECT count(order_id) as count, STR_TO_DATE(date_time,'%H') as time FROM tbl_orders o INNER JOIN tbl_terminal t ON o.terminal_id = t.terminal_id WHERE t.customer_id = '".$_SESSION['user_id']."' GROUP BY STR_TO_DATE(date_time,'%H') ORDER BY count(order_id) DESC");
$data_arr = array();$i=0;
while($hrData=mysql_fetch_array($hrSql))
{
	$data_arr[$i]['count'] = $hrData['count'];
	$data_arr[$i]['time'] = $hrData['time'];
	$i++;
}
$hi = $data_arr[0]['time'];
$diff = '';$index;
for($i=1;$i<count($data_arr);$i++){
	if($i == 1){
		$diff = $data_arr[0]['count'] - $data_arr[$i]['count'];
	}
	else{
		$temp = $data_arr[$i-1]['count'] - $data_arr[$i]['count'];
		if(($diff * 2) < $temp){
			$index = $i-1;
			break;
		}
	}
}

$lw = $data_arr[$index]['time'];
if($hi < $lw){
	$temp = $lw;
	$lw = $hi;
	$hi = $temp;
}
$hi = str_replace(":00:00","",$hi);
$lw = str_replace(":00:00","",$lw);
*/

if(isset($_REQUEST['downloadExcel'])){
	$filename = "dd.xls";		 
    header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=\"$filename\"");
	$data = array( 0 => array( 'Name' => 'Parvez Alam', 'Age' => '21','Gender' => 'Male'));
	ExportFile($data);
	exit();
}
function ExportFile($records) {
	$heading = false;
		if(!empty($records))
		  foreach($records as $row) {
			if(!$heading) {
			  // display field/column names as a first row
			  echo implode("\t", array_keys($row)) . "\n";
			  $heading = true;
			}
			echo implode("\t", array_values($row)) . "\n";
		  }
		exit;
}


$where = '';

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
		$where = $search;
	}
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
 <!--  <img src="images/ghrap.jpg"  class="img-responsive" style="margin:auto;"  alt=""/>  -->
  <div id="curve_chart" style="width: 900px; height: 500px"></div>
  </div>
  
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
                  <span class="input-group-addon" style="border:none; background:none;"> <i class="fa "> <img src="images/date.jpg" alt=""/></i> </span> </div>
				   <input type="submit" name="btnSearch" class="search" value="SEARCH" />
				  </div>
    </form>              
       <!--           
                   <div class="col-md-3">
					<form name="sortForm" id="sortForm" action="index.php?action=employee_list" method="post">
					<select id="order_by" name="order_by" class="form-control selectboxg fleft" style="max-width:200px;" onchange="javascript: sortForm.submit();">
					<option value="default">Default</option>
					<option value="recent" selected="">Recent</option>
					<option value="ename_asc">A-Z</option>
					<option value="ename_desc">Z-A</option>		
					</select>&nbsp;&nbsp;&nbsp; <input type="submit" name="btnSearch" class="search" value="SEARCH" />
					</form>
																
					</div>
	-->
	<form name="searchByTime" action="" method="post">
   <div class="col-md-3"> 
		<select name="selTime" class="selectboxg lright" onchange="javascript: searchByTime.submit();">
            <option value="none">Select Period</option>
			<option value="daily" <?php if(isset($_REQUEST['selTime']) && $_REQUEST['selTime'] == "daily") { echo 'selected';}?>>Daily</option>
			<option value="weekly" <?php if(isset($_REQUEST['selTime']) && $_REQUEST['selTime'] == "weekly") { echo 'selected';}?>>Weekly</option>
			<option value="monthly" <?php if(isset($_REQUEST['selTime']) && $_REQUEST['selTime'] == "monthly") { echo 'selected';}?>>Monthly</option>
			<option value="yearly" <?php if(isset($_REQUEST['selTime']) && $_REQUEST['selTime'] == "yearly") { echo 'selected';}?>>Yearly</option>
            </select>&nbsp;&nbsp;&nbsp;  
   </div>
   </form>
  <form method="POST" action="download_sales_report.php">
  <input type="submit" name="downloadExcel" class="search" value="Excel" />
  </form>
  <div class="clearfix" style="display: -webkit-box;"> </div>
  
 <div class="tableout tpos rwebkit" style="display: -webkit-box; width:100%; position:relative; margin:;padding-top: 38px;">
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
		//echo "SELECT order_total, tax, order_final_total FROM `tbl_orders` WHERE terminal_id = '".$DATA_ACCOUNT['terminal_id']."' ".$where;exit;
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
