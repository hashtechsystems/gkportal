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
if($_SESSION['AssignedPOS'] == "Green Bits")
{
	$search = " AND pos_orderId !='' ";
}

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
                 <span class="input-group-addon" style="border:none; background:none;"> <i class="fa"> <img src="images/date.jpg" alt=""/></i> </span> </div>
    
     </div>
    
    <div class="col-md-3">  
    <select name="selTer" class="selectboxg lright">
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
                </select>&nbsp;&nbsp;&nbsp;<input type="submit" name="btnSearch" value="SEARCH" class="search" />
    
    </div>
    
   
   </form>
   <form method="POST" action="download_order_transactions_report.php">
    <input type="submit" name="downloadExcel" class="search" value="Excel" />
  </form>
  
  </div>
<div class="tpos rwebkit" style="display: -webkit-box; width:100%; position:relative; margin:;padding-top: 38px;">  <table cellpadding="0" cellspacing="0" width="100%" align="center" class="table">
   <tr class="tbg">
      <th class="stat" align="left">Terminal Id</th>  
	  <th class="stat" align="right">Order Id</th>
	  <th class="stat" align="right">Pos Order Id</th>
      <th class="stat" align="right">Order Amount</th>
      <th class="stat" align="right">Date Time</th>
	  <th class="stat" align="right">Action</th>
    </tr>    
    <?php	
	$PAGESQL=mysql_query("SELECT o.order_id, o.terminal_id, o.pos_orderId, o.date_time, o.order_final_total FROM `tbl_orders` o INNER JOIN `tbl_terminal` t  ON o.terminal_id = t.terminal_id WHERE t.customer_id = '".$_SESSION['user_id']."' $search order by o.order_id DESC");
	$total_rows = mysql_num_rows($PAGESQL);
										  
	$pages = new Paginator;  
	$pages->items_total = $total_rows;  
	$pages->mid_range = 9;  
	$pages->paginate();
	
	$SQL=mysql_query("SELECT o.order_id, o.pos_orderId, o.terminal_id, o.date_time, o.order_final_total FROM `tbl_orders` o INNER JOIN `tbl_terminal` t  ON o.terminal_id = t.terminal_id WHERE t.customer_id = '".$_SESSION['user_id']."' $search order by o.order_id DESC".$pages->limit);
		
	while($DATA=mysql_fetch_array($SQL))
	{
		
	?>
    <tr>
      <td align="left" class="stat"><em><?php echo $DATA['terminal_id']; ?></em></td>
	  <td align="left" class="stat"><em><?php echo $DATA['order_id']; ?></em></td>
	  <td align="left" class="stat"><em><?php echo $DATA['pos_orderId']; ?></em></td>
      <td class="stat" align="left">$<?php echo number_format($DATA['order_final_total'], 2);?></td>
      <td class="stat" align="left"><?php echo $DATA['date_time'] ?></td>
      <td class="stat" align="center"><a href="index.php?action=order_details_report&id=<?=$DATA['order_id'];?>&page=<?=$_REQUEST['page'];?>&ipp=<?=$_REQUEST['ipp'];?>"><img src="images/view-icon.png"   alt=""/></a></td>
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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<?php
$to_date = date('Y-m-d');
$from_date = date('Y-m-1');

$query=mysql_query("SELECT count(o.order_id) as total_order, STR_TO_DATE(date_time,'%m/%d/%Y') as date_time FROM tbl_orders o INNER JOIN tbl_terminal t ON o.terminal_id = t.terminal_id WHERE t.customer_id = '".$_SESSION['user_id']."' AND STR_TO_DATE(date_time, '%m/%d/%Y %H:%i') BETWEEN '".$from_date." 00:00:00' AND '".$to_date." 23:59:59' GROUP BY STR_TO_DATE(date_time,'%m/%d/%Y') ORDER BY date_time ASC");
$chart_cur = array();
while($data=mysql_fetch_array($query))
{
	$day = date('d', strtotime($data['date_time']));
	if(isset($chart_cur[$day])){
		$chart_cur[$day] = $chart_cur[$day] + $data['total_order'];
	}
	else{
		$chart_cur[$day] = $data['total_order'];
	}
}

$firstD = new DateTime("first day of last month");
$lastD = new DateTime("last day of last month");
$from_date =  $firstD->format('Y-m-d');
$to_date = $lastD->format('Y-m-d');
$query=mysql_query("SELECT count(o.order_id) as total_order, STR_TO_DATE(date_time,'%m/%d/%Y') as date_time FROM tbl_orders o INNER JOIN tbl_terminal t ON o.terminal_id = t.terminal_id WHERE t.customer_id = '".$_SESSION['user_id']."' AND STR_TO_DATE(date_time, '%m/%d/%Y %H:%i') BETWEEN '".$from_date." 00:00:00' AND '".$to_date." 23:59:59' GROUP BY STR_TO_DATE(date_time,'%m/%d/%Y') ORDER BY date_time ASC");
$chart_pre = array();
while($data=mysql_fetch_array($query))
{
	$day = date('d', strtotime($data['date_time']));
	if(isset($chart_pre[$day])){
		$chart_pre[$day] = $chart_pre[$day] + $data['total_order'];
	}
	else{
		$chart_pre[$day] = $data['total_order'];
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
          title: 'Transaction Performance',
         // curveType: 'function',
		  hAxis: {
                  title: 'Days'
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