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

<div class="page-header" style="margin-top:20px;">
  <h1> Add Consumers</h1>
</div>
<div class="container" id="container">
  <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="bo02">
    <tr>
      <td class="des-bg2" ><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bo3">
          <tr>
            <td valign="top" bgcolor=""><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td valign="top"><form action="" name="kiosk"  method="post" enctype="multipart/form-data">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td style="color:#990000;padding-left:15px;" align="left"><?php
							if(isset($error) && count($error) > 0)
							{
								echo '<div class="error-div">';
								for($i = 0; $i < count($error); $i++)
								{
									echo '<li>'.$error[$i]."</li>";
								}
								echo "</div>";
							}
							?></td>
                        </tr>
                        <!--<tr>
                          <td colspan="3" height="40"><strong>Product General Details</strong></td>
                        </tr>-->
                        <tr>
                          <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="left" class="text">
                              <tr>
                                <td align="left" class="form-t">Name</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="ConsumerName" name="ConsumerName" placeholder="Consumer Name">
                                  &nbsp;
                                  <?php if(isset($ConsumerNameError) && $ConsumerNameError != "") { echo "<span style='color: #ff0000;'>".$ConsumerNameError."</span>";}?></td>
                              </tr>
							  <tr>
                                <td align="left" class="form-t">Email</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="Email" name="Email" placeholder="Email">
                                  &nbsp;
                                  <?php if(isset($EmailError) && $EmailError != "") { echo "<span style='color: #ff0000;'>".$EmailError."</span>";}?></td>
                              </tr>
							  <tr>
                                <td align="left" class="form-t">Consumer Driver License Mag Stripe Data</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="ConsumerDriverLicenseMagStripeData" name="ConsumerDriverLicenseMagStripeData" placeholder="Consumer Driver License Mag Stripe Data">
                                  &nbsp;
                                  <?php if(isset($Err_txtName) && $Err_txtName != "") { echo "<span style='color: #ff0000;'>".$Err_txtName."</span>";}?></td>
                              </tr>
							  <tr>
                                <td align="left" class="form-t">Consumer Driver License Bar Code Data</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="ConsumerDriverLicenseBarCodeData" name="ConsumerDriverLicenseBarCodeData" placeholder="Consumer Driver License Bar Code Data">
                                  &nbsp;
                                  <?php if(isset($Err_txtName) && $Err_txtName != "") { echo "<span style='color: #ff0000;'>".$Err_txtName."</span>";}?></td>
                              </tr>
							  <tr>
                                <td align="left" class="form-t">Consumer Driver Licnese Data Stripped</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="ConsumerDriverLicneseDataStripped" name="ConsumerDriverLicneseDataStripped" placeholder="Consumer Driver Licnese Data Stripped">
                                  &nbsp;
                                  <?php if(isset($Err_txtName) && $Err_txtName != "") { echo "<span style='color: #ff0000;'>".$Err_txtName."</span>";}?></td>
                              </tr>
							  <tr>
                                <td align="left" class="form-t">Consumer Total Daily Limit GM</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="ConsumerTotalDailyLimitGM" name="ConsumerTotalDailyLimitGM" placeholder="Consumer Total Daily Limit GM">
                                  &nbsp;
                                  <?php if(isset($Err_txtName) && $Err_txtName != "") { echo "<span style='color: #ff0000;'>".$Err_txtName."</span>";}?></td>
                              </tr>
							  <tr>
                                <td align="left" class="form-t">Consumer Daily Limit Used GM</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="ConsumerDailyLimitUsedGM" name="ConsumerDailyLimitUsedGM" placeholder="Consumer Daily Limit Used GM">
                                  &nbsp;
                                  <?php if(isset($Err_txtName) && $Err_txtName != "") { echo "<span style='color: #ff0000;'>".$Err_txtName."</span>";}?></td>
                              </tr>
							  <tr>
                                <td align="left" class="form-t">Consumer Total Daily Limit OUNCE</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="ConsumerTotalDailyLimitOUNCE" name="ConsumerTotalDailyLimitOUNCE" placeholder="ConsumerTotalDailyLimitOUNCE">
                                  &nbsp;
                                  <?php if(isset($Err_txtName) && $Err_txtName != "") { echo "<span style='color: #ff0000;'>".$Err_txtName."</span>";}?></td>
                              </tr>
							  <tr>
                                <td align="left" class="form-t">Consumer Daily Limit Used OUNCE</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="ConsumerDailyLimitUsedOUNCE" name="ConsumerDailyLimitUsedOUNCE" placeholder="Consumer Daily Limit Used OUNCE">
                                  &nbsp;
                                  <?php if(isset($Err_txtName) && $Err_txtName != "") { echo "<span style='color: #ff0000;'>".$Err_txtName."</span>";}?></td>
                              </tr>
                              <tr align="left">
                                <td height="35" colspan="">&nbsp;</td>
                                <td width="20"></td>
                                <td height="40" colspan=""><input id="cmdCheck" name="btnSubmit" value="Add" type="submit" class="button"/>
                                  &nbsp;&nbsp;<a href="index.php?action=customer_list_no_pos" >
                                  <input type="button" value="Cancel" class="button"/>
                                  </a></td>
                              </tr>
                              <tr align="left">
                                <td >&nbsp;</td>
                                <td width="20"></td>
                                <td>&nbsp;</td>
                                <td width="20"></td>
                              </tr>
                            </table></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                      </table>
                    </form></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
          </tr>
        </table></td>
    </tr>
  </table>
</div>
