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
?>

<div class="" id="container" style="margin-top:20px;">
  <div class="page-header">
    <h1> Consumers </h1>
  </div>
  <a href="index.php?action=add_customer_no_pos" style="float:right; cursor:pointer; text-decoration:none; padding:4px 7px; background-color:#1473B8; color:#FFFFFF;">Add New Consumer</a>
  <table cellpadding="5" cellspacing="5" width="90%" align="center" class="table table-bordered">
    <tr>
	 <th class="stat">Id</th>  
      <th class="stat">Name</th>
      <th class="stat">Email</th>
      <th class="stat">Consumer Driver License Mag Stripe Data</th>
	  <th class="stat">Consumer Driver License Bar Code Data</th>
	  <th class="stat">Consumer Driver Licnese Data Stripped</th>
	  <th class="stat">Consumer Total Daily Limit GM</th>
      <th class="stat">Consumer Daily Limit Used GM</th>    
      <th class="value">Consumer Total Daily Limit OUNCE</th>
	  <th class="value">Consumer Daily Limit Used OUNCE</th>
	  <th class="value">Action</th>
    </tr>
    <?php		
	$query=mysql_query("SELECT * FROM `tbl_customers_no_pos` WHERE customer_id = ".$_SESSION['user_id']);
	$cnt=0;
	while($data=mysql_fetch_array($query))
	{	
	$cnt++;	
	?>
    <tr>
	  <td class="stat"><em> <?php echo $cnt; ?></em></td>
	  <td class="stat"><? echo $data['ConsumerName'];?></td>      
	  <td class="stat"><? echo $data['email'];?></td>      
	  <td class="stat"><em><?php echo $data['ConsumerDriverLicenseMagStripeData']; ?></em></td> 
	  <td class="stat"><em><?php echo $data['ConsumerDriverLicenseBarCodeData']; ?></em></td> 
	  <td class="stat"><em><?php echo $data['ConsumerDriverLicneseDataStripped']; ?></em></td> 
	  <td class="stat"><em><?php echo $data['ConsumerTotalDailyLimitGM']; ?></em></td> 
      <td class="stat"><em><?php echo $data['ConsumerDailyLimitUsedGM']; ?></em></td>
      <td class="stat" style="text-align:right;"><em><?php echo $data['ConsumerTotalDailyLimitOUNCE'];?></em></td>
	   <td class="stat" style="text-align:right;"><em><?php echo $data['ConsumerDailyLimitUsedOUNCE'];?></em></td>    	  
      <td> <a href="index.php?action=edit_customer_no_pos&id=<?=$data['id'];?>">Edit</a></td>
    </tr>
    <?php
	}
	?>
  </table>
</div>
