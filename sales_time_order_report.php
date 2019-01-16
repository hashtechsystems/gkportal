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
  <div  class="w100" style="text-align:center;">
  <!-- <img src="images/ghrap.jpg" width="" class="img-responsive" style="margin:auto;"  alt=""/> -->
  <div id="curve_chart" style="width: 900px; height: 500px"></div>
   </div>
  <div  class="w98">
  <h3 class="sectionhead">Overview</h3>
  <hr>
  
  </div>
  <div  class="w100">
   <form action="" method="post">
    <div class="col-md-6">  
     <div class="input-group" style="width:155px; float:left"> 
                  <input class="form-control date-picker dateinput" id="fromDate" name="fromDate" type="text" value="<?php if(isset($_REQUEST['fromDate']) && $_REQUEST['fromDate'] != '') { echo $_REQUEST['fromDate'];}?>" placeholder="From" data-date-format="yyyy-mm-dd"/>
                 <span class="input-group-addon" style="border:none; background:none;"> <i class="fa"> <img src="images/date.jpg" alt=""/></i> </span></div>
                  
      <div class="input-group" style="width:155px; float:left">
                  <input class="form-control date-picker dateinput" id="toDate" name="toDate" type="text" value="<?php if(isset($_REQUEST['toDate']) && $_REQUEST['toDate'] != '') { echo $_REQUEST['toDate'];}?>" placeholder="To" data-date-format="yyyy-mm-dd"/>
                 <span class="input-group-addon" style="border:none; background:none;"> <i class="fa"> <img src="images/date.jpg" alt=""/></i> </span></div>
    <input type="submit" name="btnSearch" class="search" value="SEARCH" />
     </div> 
   </form>
  
  
  </div>
<div class="tpos rwebkit" style="display: -webkit-box; width:100%; position:relative; margin:;padding-top: 38px;">  <table cellpadding="0" cellspacing="0" width="100%" align="center" class="table">
   <tr class="tbg">
      <th class="stat" align="left">Time Slot</th>  
	  <th class="stat" align="right">Total Orders</th>
	  <th class="stat" align="right">Total Order Amount</th>
    </tr>    
    <?php	
	$time_slot = array('09'=>'12','12'=>'15','15'=>'18','18'=>'21','21'=>'24','00'=>'03','03'=>'06','06'=>'09');
	$total_rows = 0; $total_amount = 0;
	foreach($time_slot as $from => $to){
	  $SQL=mysql_query("SELECT count(o.order_id) as total_order, sum(o.order_final_total) as total_amount FROM tbl_orders o INNER JOIN tbl_terminal t ON o.terminal_id = t.terminal_id WHERE t.customer_id = '".$_SESSION['user_id']."' AND STR_TO_DATE(date_time, '%H') BETWEEN '".$from."' AND '".$to."' $search");
	  
	while($DATA=mysql_fetch_array($SQL))
	{
		$total_rows = $total_rows + $DATA['total_order'];
		$total_amount = $total_amount + $DATA['total_amount'];
	?>
    <tr>
      <td align="left" class="stat"><em><?php echo $from."-".$to; ?></em></td>
	  <td align="left" class="stat"><em><?php echo $DATA['total_order']; ?></em></td>
	  <td align="left" class="stat">$<em><?php echo $DATA['total_amount']; ?></em></td>
    </tr>
    <?php
	}
	}
	?>
	<tr style="background-color:#EBEBEB;">
        <td class="listData_First" align="right" height="30">
            <?php echo '<strong>Total Orders</strong> =' ?>
        </td>
		<td><?= $total_rows; ?></td>
        <td>
            <?php echo "<strong>Total Amount </strong> = \$$total_amount" ?>
        </td>
    </tr>
  </table>
 </div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<?php
$to_date = date('Y-m-d');
$from_date = date('Y-m-1');
$firstD = new DateTime("first day of last month");
$lastD = new DateTime("last day of last month");
$from_date_p =  $firstD->format('Y-m-d');
$to_date_p = $lastD->format('Y-m-d');
$chart_cur = array();
$chart_pre = array();
foreach($time_slot as $from => $to){
	
	$key = "$from-$to";
	
	$query=mysql_query("SELECT count(o.order_id) as total_order FROM tbl_orders o INNER JOIN tbl_terminal t ON o.terminal_id = t.terminal_id WHERE t.customer_id = '".$_SESSION['user_id']."' AND STR_TO_DATE(date_time, '%H') BETWEEN '".$from."' AND '".$to."' AND STR_TO_DATE(date_time, '%m/%d/%Y %H:%i') BETWEEN '".$from_date." 00:00:00' AND '".$to_date." 23:59:59'");
	while($data=mysql_fetch_array($query))
	{
	    $chart_cur[$key] = $data['total_order'];
	}
	if(!isset($chart_cur[$key])){
		$chart_cur[$key] = 0;
	}
	
	$query=mysql_query("SELECT count(o.order_id) as total_order FROM tbl_orders o INNER JOIN tbl_terminal t ON o.terminal_id = t.terminal_id WHERE t.customer_id = '".$_SESSION['user_id']."' AND STR_TO_DATE(date_time, '%H') BETWEEN '".$from."' AND '".$to."' AND STR_TO_DATE(date_time, '%m/%d/%Y %H:%i') BETWEEN '".$from_date_p." 00:00:00' AND '".$to_date_p." 23:59:59' ");
	
	while($data=mysql_fetch_array($query))
	{
		$chart_pre[$key] = $data['total_order'];
	}
	if(!isset($chart_pre[$key])){
		$chart_pre[$key] = 0;
	}
}

?>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Current Month', 'Past Month'],
          ['09-12',  <?= $chart_cur['09-12'] ?>, <?= $chart_pre['09-12'] ?>],
          ['12-15',  <?= $chart_cur['12-15'] ?>, <?= $chart_pre['12-15'] ?>],
          ['15-18',  <?= $chart_cur['15-18'] ?>, <?= $chart_pre['15-18'] ?>],
          ['18-21',  <?= $chart_cur['18-21'] ?>, <?= $chart_pre['18-21'] ?>],
		  ['21-24',  <?= $chart_cur['21-24'] ?>, <?= $chart_pre['21-24'] ?>],
          ['00-03',  <?= $chart_cur['00-03'] ?>, <?= $chart_pre['00-03'] ?>],
		  ['03-06',  <?= $chart_cur['03-06'] ?>, <?= $chart_pre['03-06'] ?>],
          ['06-09',  <?= $chart_cur['06-09'] ?>, <?= $chart_pre['06-09'] ?>],
        ]);

        var options = {
          title: 'Transaction Performance',
         // curveType: 'function',
		  hAxis: {
                  title: 'Time Slot'
		  },
		  vAxis: {
                  title: 'Number of Transaction'
		  },
		  width:1000,
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
</script>