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
  <h3 class="sectionhead">Uptime / Usage reports</h3>
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
    <form name="searchByTerminal" action="" method="post">
   <div class="col-md-3"> 
		<select name="selTerminal" class="selectboxg lright" onchange="javascript: searchByTerminal.submit();">
            <option value="none">Select Terminal</option>
			<?php
			$SQL_MACHINE = mysql_query("SELECT id, terminal_id FROM `tbl_terminal` WHERE customer_id = ".$_SESSION['user_id']);
			while($DATA_MACHINE = mysql_fetch_assoc($SQL_MACHINE))
			{
				?>
				<option value="<?php echo $DATA_MACHINE['terminal_id'];?>" <?php if(isset($_REQUEST['selTerminal']) && $_REQUEST['selTerminal'] == $DATA_MACHINE['terminal_id']) { echo 'selected';}?> ><?php echo $DATA_MACHINE['terminal_id'];?></option>
				<?php
			}
			?>
		</select>
   </div>
   </form>
	
  </div>
  <div class="clearfix" style="display: -webkit-box;"> </div>
 <div class="tableout tpos rwebkit" style="display: -webkit-box; width:100%; position:relative; margin:;padding-top: 38px;">
  <table cellpadding="0" cellspacing="0" width="100%" align="center" class="table ">
    <tr class="tbg">
      <th class="stat" align="">Terminal Id</th>
      <th class="stat" align="">Server Date Time </th>      
      <th class="stat" align="">Terminal Status</th>
    </tr>    
    <?php	
	$SQL_ACCOUNT=mysql_query("SELECT t.terminal_id, h.ServerDateTime, h.TerminalStatus FROM `tbl_heart_beat` h INNER JOIN `tbl_terminal` t ON t.terminal_id = h.TerminalId WHERE t.customer_id = '".$_SESSION['user_id']."' $where Order By ServerDateTime DESC");
	
	while($DATA_ACCOUNT=mysql_fetch_array($SQL_ACCOUNT))
	{
	
		
	?>
    <tr>
      <td class="stat"><?php echo $DATA_ACCOUNT['terminal_id']; ?></td>
      <td class="stat" align=""><?php echo $DATA_ACCOUNT['ServerDateTime']; ?></td>
      <td class="stat" align=""><?php echo $DATA_ACCOUNT['TerminalStatus']; ?></td>
    </tr>
    <?php
	
	}
	?>
   
  </table>
  </div>
 