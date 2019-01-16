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
		mysql_query("INSERT INTO `tbl_customers_no_pos`(`customer_id`,`email`,`ConsumerName`,`ConsumerTotalDailyLimitGM`,`ConsumerDailyLimitUsedGM`,`ConsumerTotalDailyLimitOUNCE`,`ConsumerDailyLimitUsedOUNCE`,`ConsumerDriverLicenseMagStripeData`,`ConsumerDriverLicenseBarCodeData`,`ConsumerDriverLicneseDataStripped`)VALUES('".$_SESSION['user_id']."','".$_REQUEST['Email']."','".$_REQUEST['ConsumerName']."','".$_REQUEST['ConsumerTotalDailyLimitGM']."','".$_REQUEST['ConsumerDailyLimitUsedGM']."','".$_REQUEST['ConsumerTotalDailyLimitOUNCE']."','".$_REQUEST['ConsumerDailyLimitUsedOUNCE']."','".$_REQUEST['ConsumerDriverLicenseMagStripeData']."','".$_REQUEST['ConsumerDriverLicenseBarCodeData']."','".$_REQUEST['ConsumerDriverLicneseDataStripped']."')");
		
	echo "<script> document.location.href='index.php?action=customer_list_no_pos&a=1'</script>";		
	}

}

?>

<div class="page-header tbg2" style="margin-top:20px;">
<div class="col-md-8">
  <h1> Add Consumers</h1> </div>
  <div class="col-md-4" style="text-align:right;"><a href="index.php?action=customer_list_no_pos" class="greenbtn1">Previous Page</a> </div>
  <div class="clearfix" style="display: -webkit-box;"></div>
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
                                <div class="col-md-12"> <label class="flebal"> Name </label></div>
                                <div class="col-md-12">
								<input class="textbox6" type="text" id="ConsumerName" name="ConsumerName" placeholder="Consumer Name">
                                  &nbsp;
                                  <?php if(isset($ConsumerNameError) && $ConsumerNameError != "") { echo "<span style='color: #ff0000;'>".$ConsumerNameError."</span>";}?>
								</div>
							</div>
							
							<div class="clearfix gap1"> </div>
							<div class="w100">
                                <div class="col-md-12"> <label class="flebal"> Email </label></div>
                                <div class="col-md-12">
								<input class="textbox6" type="text" id="Email" name="Email" placeholder="Email">
                                  &nbsp;
                                  <?php if(isset($EmailError) && $EmailError != "") { echo "<span style='color: #ff0000;'>".$EmailError."</span>";}?>
								</div>
							</div>
							  
							  <div class="clearfix gap1"> </div>
							  <div class="w100">
                                <div class="col-md-12"> <label class="flebal">Consumer Driver License Mag Stripe Data</label></div>
                                <div class="col-md-12">
								<input class="textbox6" type="text" id="ConsumerDriverLicenseMagStripeData" name="ConsumerDriverLicenseMagStripeData" placeholder="Consumer Driver License Mag Stripe Data">
								 </div>
                              </div>
							  
							  <div class="clearfix gap1"> </div>
							  <div class="w100">
                                <div class="col-md-12"><label class="flebal">Consumer Driver License Bar Code Data</label></div>
                                <div class="col-md-12">
								<input class="textbox6" type="text" id="ConsumerDriverLicenseBarCodeData" name="ConsumerDriverLicenseBarCodeData" placeholder="Consumer Driver License Bar Code Data">
								</div>
                              </div>
							  
							  <div class="clearfix gap1"> </div>
							  <div class="w100">
                                <div class="col-md-12"> <label class="flebal">Consumer Driver Licnese Data Stripped</label></div>
                                <div class="col-md-12">
								<input class="textbox6" type="text" id="ConsumerDriverLicneseDataStripped" name="ConsumerDriverLicneseDataStripped" placeholder="Consumer Driver Licnese Data Stripped">
								</div>
                              </div>
							  
							  <div class="clearfix gap1"> </div>
							 <div class="w100">
                                <div class="col-md-12"> <label class="flebal">Consumer Total Daily Limit GM</label></div>
                                <div class="col-md-12">
								<input class="textbox6" type="text" id="ConsumerTotalDailyLimitGM" name="ConsumerTotalDailyLimitGM" placeholder="Consumer Total Daily Limit GM">
								</div>
                             </div>
							
							<div class="clearfix gap1"> </div>
							<div class="w100">
                                <div class="col-md-12"> <label class="flebal">Consumer Daily Limit Used GM</label></div>
                                <div class="col-md-12">
								<input class="textbox6" type="text" id="ConsumerDailyLimitUsedGM" name="ConsumerDailyLimitUsedGM" placeholder="Consumer Daily Limit Used GM">
								</div>
                            </div>
							 
							<div class="clearfix gap1"> </div>
							<div class="w100">
                                <div class="col-md-12"> <label class="flebal">Consumer Total Daily Limit OUNCE</label></div>
                                <div class="col-md-12">
								<input class="textbox6" type="text" id="ConsumerTotalDailyLimitOUNCE" name="ConsumerTotalDailyLimitOUNCE" placeholder="ConsumerTotalDailyLimitOUNCE">
                                 </div>
                            </div>
							 
							<div class="clearfix gap1"> </div>
							 <div class="w100">
                                <div class="col-md-12"> <label class="flebal">Consumer Daily Limit Used OUNCE</label></div>
                                <div class="col-md-12">
								<input class="textbox6" type="text" id="ConsumerDailyLimitUsedOUNCE" name="ConsumerDailyLimitUsedOUNCE" placeholder="Consumer Daily Limit Used OUNCE">
                                </div>
                             </div>
							 
							 <div class="clearfix gap1"> </div>
                              <div class="w100">
                                <div class="col-md-12">
								<input id="cmdCheck" name="btnSubmit" value="Add" type="submit" class="greenbtn2"/>
                                  &nbsp;&nbsp;<a href="index.php?action=customer_list_no_pos" >
                                  <input type="button" value="Cancel" class="greenbtn2"/>
                                </div>
                              </div>
</div>
</form>
</div>
