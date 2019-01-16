<? 
session_start();
if($_SESSION['islogin']=="")
{
#	echo "In If";
?>
<script type="text/javascript">
document.location.href='login.php';
</script>
<?
}
else
{
#	echo "In Else";
}

if(isset($_REQUEST['submit']))
{
	#echo"<pre>";print_r($_REQUEST);exit;
	$campagianid=$_REQUEST['campagianid'];
	$statId=$_REQUEST['statId'];
	$network=$_REQUEST['network'];
	$ListName=$_REQUEST['ListName'];
	if($network=="novadash")
	{
		$getOfferDetails=mysql_fetch_array(mysql_query("SELECT * FROM tbl_novadash WHERE `campaign_id`='".$campagianid."'"));
		mysql_query("INSERT INTO `match_table`(`stat_id`,`network`,`campaignid`, `list_name`,`offer_number`,`offer_name`)VALUES('".$statId."','".$network."','".$campagianid."','".$ListName."','".$getOfferDetails['offer_id']."','".$getOfferDetails['offer_name']."')");
	}
	else
	{
		mysql_query("INSERT INTO `match_table`(`stat_id`,`network`,`campaignid`, `list_name`)VALUES('".$statId."','".$network."','".$campagianid."','".$ListName."')");
	}
	mysql_query("UPDATE `stats` SET campagian_assined=1 WHERE `id`='".$statId."'");
}
	
$result = " where 1";
if(isset($_REQUEST['Search']))
{
	
	$from="";
	$to="";
	if($_REQUEST['fromdate']!="")
	{
		$from=$_REQUEST['fromdate'];	
	}
	else
	{
		$from=date('d/m/Y');
	}
	
	if($_REQUEST['todate']!="")
	{
		$to=$_REQUEST['todate'];	
	}
	else
	{
		$to=date('d/m/Y');
	}
$result = " where sent_date BETWEEN '".$from."' AND '".$to."' "; 
}
if(isset($_REQUEST['order_by']))
{
	$orderBy=" ORDER BY ".$_REQUEST['field']." ".$_REQUEST['order_by'];
	$result .=$orderBy;
}
?>

<div class="" id="container" style="margin-top:20px;">
<div class="row" style="background:#fff;display: -webkit-box; margin:0 0 50px 0;  ">
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
  <div class="clearfix" style="display: -webkit-box;"></div>
  <div style="width:100%;">
  
   <div class="col-md-4 addproduct" style="text-align:center;">
   <a href="index.php?action=add_product" > 
<div style="text-align:center;">

  <img src="images/add-products.jpg"  alt=""/><br>
<h4 class="bigfont">Add new<br>
product</h4>
 </div></a>


  </div>
  
   <div class="col-md-4 addproduct" style="text-align:center;">
   <a href="index.php?action=add_customer_no_pos" > 
<div style="text-align:center;">

  <img src="images/add-new-customer.jpg"  alt=""/><br>
<h4 class="bigfont">Add new<br>

customer</h4>
 </div>
</a>

  </div>
   <div class="col-md-4 addproduct" style="text-align:center;">
   <a href="index.php?action=add_employee">
<div style="text-align:center;">

  <img src="images/add-new-emp.jpg"  alt=""/><br>
<h4 class="bigfont">Add new<br>
employee</h4>
 </div></a>


  </div>
  
  </div>
 
 
 
</div>
