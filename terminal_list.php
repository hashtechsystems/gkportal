<? if($_SESSION['islogin']=="")
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
  <div class="page-header">
    <h1> Terminals </h1>
  </div>
  <a href="index.php?action=add_terminal" style="float:right; cursor:pointer; text-decoration:none; padding:4px 7px; background-color:#1473B8; color:#FFFFFF;">Add New Terminal</a>
  <table cellpadding="5" cellspacing="5" width="90%" align="center" class="table table-bordered">
    <tr>
      <th class="stat">Id</th>
      <th class="stat">Name</th>
      <th class="stat">Terminal Id</th>
      <th class="stat">Account</th>
      <th class="stat">Site</th>
      <th class="stat">Type</th>
      <!--<th class="stat">Address</th>      -->
      <th class="value">Action</th>
    </tr>
    <?php	
	$query=mysql_query("SELECT * FROM `tbl_terminal`". $result);
	$cnt=0;
	while($data=mysql_fetch_array($query))
	{
		#echo "SELECT * FROM `tbl_accounts` WHERE `id`='".$data['account_id']."'";
		$accountDetails=mysql_fetch_array(mysql_query("SELECT * FROM `tbl_accounts` WHERE `id`='".$data['account_id']."'"));
		$siteDetails=mysql_fetch_array(mysql_query("SELECT * FROM `tbl_sites` WHERE `id`='".$data['site_id']."'"));
		$cnt++;
	?>
    <tr>
      <td class="stat"><em> <?php echo $cnt; ?></em></td>
      <td class="stat"><em><?php echo $data['terminal_name']; ?></em></td>
      <td class="stat"><em><?php echo $data['terminal_id']; ?></em></td>
      <td class="stat"><em><?=$accountDetails['name'];?></em></td>
      <td class="stat"><em><?=$siteDetails['name'];?></em></td>
      
      <td class="stat"><em><?php  
	  if($data['type']=="ST")
	  {
		  echo "Store";
	  }
	  if($data['type']=="LK")
	  {
		  echo "Locker";
	  }
	  if($data['type']=="VM")
	  {
		  echo "Vending Machine";
	  }
	  ?></em></td>
      <!--<td class="stat"><em><?php echo $data['address']; ?></em></td>-->
      <td> <a href="index.php?action=edit_terminal&id=<?=$data['id'];?>">Edit</a></td>
    </tr>
    <?php
	}
	?>
  </table>
</div>
