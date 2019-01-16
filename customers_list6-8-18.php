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

<div class="" id="container" >
  <div class="grybox" style="max-width:98% !important; padding:1%;display: -webkit-box; "></div>
  <div class="" style="display: -webkit-box; width:97%; position:relative; margin:-50px auto 0 auto;">
  <table cellpadding="" cellspacing="" width="100%" align="center" class="table">
    <tr>
      <th class="stat">Id</th>
      <th class="stat">Name</th>
      <th class="stat">Username</th>
      <th class="stat">Password</th> 
	  <th class="stat">Terminal Id</th>
	  <th class="stat">Location</th>
	  <th class="stat">Address</th>
      <th class="value">Action</th>
	  <th class="value">Terms</th>
    </tr>
    <?php	
	#echo "SELECT * FROM `tbl_customers` WHERE id='".$_SESSION['user_id']."'";
	$query=mysql_query("SELECT c.*,t.terminal_id, t.id as tid, t.location, t.Address FROM `tbl_customers` c LEFT JOIN `tbl_terminal` t ON c.id = t.customer_id WHERE c.id='".$_SESSION['user_id']."'");
	$cnt=0;
	while($data=mysql_fetch_array($query))
	{	
	$cnt++;	
	?>
    <tr>
	  <td class="stat"><em> <?php echo $cnt; ?></em></td>
	  <td class="stat"><em><?php echo $data['name']; ?></em></td> 
      <td class="stat"><em><?php echo $data['username']; ?></em></td>
      <td class="stat"><em><?php echo $data['password'];?></em></td>      
	  <td class="stat"><em><?php echo $data['terminal_id'];?></em></td>
	  <td class="stat"><em><?php echo $data['location'];?></em></td>
	  <td class="stat"><em><?php echo $data['Address'];?></em></td>
      <td> <a href="index.php?action=edit_customer&id=<?=$data['id'];?>"><img src="images/edit-icon.jpg" width="30"  alt=""/></a></td>
	  <td> <a href="index.php?action=edit_terms&tid=<?=$data['tid'];?>"><img src="images/reportsh-icon.jpg" width="30"  alt=""/></a></td>
    </tr>
    <?php
	}
	?>
  </table>
  </div>
</div>
