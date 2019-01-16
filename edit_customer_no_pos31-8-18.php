<?php
ob_start();

if($_REQUEST['btnSubmit'])
{
	$Error = 0;
	
	$Err_txtName = '';
	$Err_selCat = '';
	$Err_price = '';
	$Err_largeImage = '';
	
	$ConsumerName = $_REQUEST['ConsumerName'];
	$Email = $_REQUEST['Email'];	
	
	
	if($ConsumerName == "")
	{
		$Error = 1;
		$ConsumerNameError = 'Please enter customer name';
	}

	if($Email == "")
	{
		$Error = 1;
		$EmailError = 'Please enter Email';
	}
	
		
	
		  
	if($Error == 0)
	{
		mysql_query("UPDATE `tbl_customers_no_pos` SET `customer_id`='".$_SESSION['user_id']."',`email`='".$_REQUEST['Email']."',`ConsumerName`='".$_REQUEST['ConsumerName']."',`ConsumerTotalDailyLimitGM`='".$_REQUEST['ConsumerTotalDailyLimitGM']."',`ConsumerDailyLimitUsedGM`='".$_REQUEST['ConsumerDailyLimitUsedGM']."',`ConsumerTotalDailyLimitOUNCE`='".$_REQUEST['ConsumerTotalDailyLimitOUNCE']."',`ConsumerDailyLimitUsedOUNCE`='".$_REQUEST['ConsumerDailyLimitUsedOUNCE']."',`ConsumerDriverLicenseMagStripeData`='".$_REQUEST['ConsumerDriverLicenseMagStripeData']."',`ConsumerDriverLicenseBarCodeData`='".$_REQUEST['ConsumerDriverLicenseBarCodeData']."',`ConsumerDriverLicneseDataStripped`='".$_REQUEST['ConsumerDriverLicneseDataStripped']."' WHERE `id`='".$_REQUEST['id']."'");
		
	echo "<script> document.location.href='index.php?action=customer_list_no_pos&u=1'</script>";		
	}
}
$getCustomer=mysql_fetch_array(mysql_query("SELECT * FROM `tbl_customers_no_pos` WHERE `id`='".$_REQUEST['id']."'"));
?>

<div class="page-header tbg2" style="margin-top:20px;">
<div class="col-md-8">
  <h1> Update Consumers</h1> </div>
  <div class="col-md-4" style="text-align:right;"><a href="index.php?action=customer_list_no_pos" class="greenbtn1">Previous Page</a> </div>
</div>
<div class="" id="">
<form action="" name="kiosk"  method="post" enctype="multipart/form-data">
 <div class="col-md-8">
                      <?php
							if(isset($error) && count($error) > 0)
							{
								echo '<div class="error-div">';
								for($i = 0; $i < count($error); $i++)
								{
									echo '<li>'.$error[$i]."</li>";
								}
								echo "</div>";
							}
							?>
                       
						<div class="w100">
                            <div class="col-md-12"><label class="flebal">Name</label></div>
							<div class="col-md-12">
							<input type="hidden" name="id" value="<?=$getCustomer['id'];?>" />
							<input class="textbox6" type="text" id="ConsumerName" value="<?=$getCustomer['ConsumerName'];?>" name="ConsumerName" placeholder="Consumer Name">
                                  &nbsp;
                                  <?php if(isset($ConsumerNameError) && $ConsumerNameError != "") { echo "<span style='color: #ff0000;'>".$ConsumerNameError."</span>";}?>
							</div>
                        </div>
							
						<div class="clearfix gap1"> </div>
							<div class="w100">
                                <div class="col-md-12"><label class="flebal">Email</label></div>
                               <div class="col-md-12">
							   <input class="textbox6" type="text" id="Email" value="<?=$getCustomer['email'];?>" name="Email" placeholder="Email">
                                  &nbsp;
                                  <?php if(isset($EmailError) && $EmailError != "") { echo "<span style='color: #ff0000;'>".$EmailError."</span>";}?>
								</div>
                            </div>
							 
						<div class="clearfix gap1"> </div>
							<div class="w100">
                                <div class="col-md-12"><label class="flebal">Consumer Driver License Mag Stripe Data</label></div>
								<div class="col-md-12">
								<input class="textbox6" type="text" id="ConsumerDriverLicenseMagStripeData" name="ConsumerDriverLicenseMagStripeData" placeholder="Consumer Driver License Mag Stripe Data" value="<?=$getCustomer['ConsumerDriverLicenseMagStripeData'];?>">
                                </div>
                            </div>
							
						<div class="clearfix gap1"> </div>
							<div class="w100">
                                <div class="col-md-12"><label class="flebal">Consumer Driver License Bar Code Data</label></div>
								<div class="col-md-12">
                                <input class="textbox6" type="text" id="ConsumerDriverLicenseBarCodeData" name="ConsumerDriverLicenseBarCodeData" placeholder="Consumer Driver License Bar Code Data" value="<?=$getCustomer['ConsumerDriverLicenseBarCodeData'];?>">
                                </div>
                            </div>
							
						<div class="clearfix gap1"> </div>
							<div class="w100">
                                <div class="col-md-12"><label class="flebal">Consumer Driver Licnese Data Stripped</label></div>
								<div class="col-md-12">
                                <input class="textbox6" type="text" id="ConsumerDriverLicneseDataStripped" name="ConsumerDriverLicneseDataStripped" placeholder="Consumer Driver Licnese Data Stripped" value="<?=$getCustomer['ConsumerDriverLicneseDataStripped'];?>">
                                </div>
                            </div>
							 
						<div class="clearfix gap1"> </div>
							 <div class="w100">
                                <div class="col-md-12"><label class="flebal">Consumer Total Daily Limit GM</label></div>
                                <div class="col-md-12">
								<input class="textbox6" type="text" value="<?=$getCustomer['ConsumerTotalDailyLimitGM'];?>" id="ConsumerTotalDailyLimitGM" name="ConsumerTotalDailyLimitGM" placeholder="Consumer Total Daily Limit GM">
                                </div>
                            </div>
							  
						<div class="clearfix gap1"> </div>
							 <div class="w100">
                                <div class="col-md-12"><label class="flebal">Consumer Daily Limit Used GM</label></div>
								<div class="col-md-12">
								<input class="textbox6" type="text" value="<?=$getCustomer['ConsumerDailyLimitUsedGM'];?>" id="ConsumerDailyLimitUsedGM" name="ConsumerDailyLimitUsedGM" placeholder="Consumer Daily Limit Used GM">
                                </div>
                            </div>
							  
						<div class="clearfix gap1"> </div>
							 <div class="w100">
                                <div class="col-md-12"><label class="flebal">Consumer Total Daily Limit OUNCE</label></div>
                                <div class="col-md-12">
								<input class="textbox6" type="text" value="<?=$getCustomer['ConsumerTotalDailyLimitOUNCE'];?>" id="ConsumerTotalDailyLimitOUNCE" name="ConsumerTotalDailyLimitOUNCE" placeholder="ConsumerTotalDailyLimitOUNCE">
                                </div>
                            </div>
							 
						<div class="clearfix gap1"> </div>
							 <div class="w100">
                                <div class="col-md-12"><label class="flebal">Consumer Daily Limit Used OUNCE</label></div>
                                <div class="col-md-12">
								<input class="textbox6" type="text"  value="<?=$getCustomer['ConsumerDailyLimitUsedOUNCE'];?>"id="ConsumerDailyLimitUsedOUNCE" name="ConsumerDailyLimitUsedOUNCE" placeholder="Consumer Daily Limit Used OUNCE">
                                </div>
                             </div>
							 
                        <div class="clearfix gap1"> </div>
							 <div class="w100">
							 <div class="col-md-12">
                                <input id="cmdCheck" name="btnSubmit" value="Update" type="submit" class="greenbtn2"/>
                                  &nbsp;&nbsp;<a href="index.php?action=customer_list_no_pos" >
                                <input type="button" value="Cancel" class="greenbtn2"/>
							</div>
							</div>
</div>                
</form>
</div>
