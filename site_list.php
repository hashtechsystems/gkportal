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
    <h1> Sites </h1>
  </div>
  <a href="index.php?action=add_site" style="float:right; cursor:pointer; text-decoration:none; padding:4px 7px; background-color:#1473B8; color:#FFFFFF;">Add New Site</a>
  <table cellpadding="5" cellspacing="5" width="90%" align="center" class="table table-bordered">
    <tr>
      <th class="stat">Id</th>
      <th class="stat">Account Name</th>
      <th class="stat"><strong>Site Name</strong></th>
      <th class="stat">Time Zone</th>
      <th class="stat">Max Charge</th>      
      <th class="value">Action</th>
    </tr>
    <?php	
	#echo "SELECT *,tbl_accounts.name,tbl_sites.id as site_id as account_name FROM `tbl_sites` LEFT JOIN `tbl_accounts` ON tbl_sites.account_id=tbl_accounts.id";
	$query=mysql_query("SELECT *,tbl_sites.name as site_name,tbl_accounts.name as account_name,tbl_sites.id as site_id  FROM `tbl_sites` LEFT JOIN `tbl_accounts` ON tbl_sites.account_id=tbl_accounts.id". $result);
	$cnt=0;
	while($data=mysql_fetch_array($query))
	{
		$cnt++;
	?>
    <tr>
      <td class="stat"><em> <?php echo $cnt; ?></em></td>
      <td class="stat"><em><?php echo $data['account_name']; ?></em></td>
      <td class="stat"><em><?=$data['site_name'];?></em></td>
      <td class="stat"><em><?php echo $data['time_zone']; ?></em></td>
      <td class="stat"><em><?=$data['max_charge'];  ?></em></td>      
      <td> <a href="index.php?action=edit_site&id=<?=$data['site_id'];?>">Edit</a></td>
    </tr>
    <?php
	}
	?>
  </table>
</div>
