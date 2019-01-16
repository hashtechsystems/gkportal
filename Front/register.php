<?php
if(isset($_REQUEST['btnRegister']))
{
	$Error = 0;
	
	$Err_txtCustomerName = '';
	$Err_txtBusinessName = '';
	$Err_txtEamil = '';
	$Err_txtVATNo = '';
	$Err_txtCompanyNumber = '';
	$Err_txtPhoneLandline = '';
	$Err_txtPhoneMobile = '';
	$Err_txtAddress1 = '';
	$Err_txtPostcode = '';
	$Err_chckTerms = '';
	
	$txtCustomerName = $_REQUEST['txtCustomerName'];
	$txtBusinessName = $_REQUEST['txtBusinessName'];
	$txtEamil = $_REQUEST['txtEamil'];
	$txtVATNo = $_REQUEST['txtVATNo'];
	$txtCompanyNumber = $_REQUEST['txtCompanyNumber'];
	$txtPhoneLandline = $_REQUEST['txtPhoneLandline'];
	$txtPhoneMobile = $_REQUEST['txtPhoneMobile'];
	$txtAddress1 = $_REQUEST['txtAddress1'];
	$txtAddress2 = $_REQUEST['txtAddress2'];
	$txtCity = $_REQUEST['txtCity'];
	$txtCounty = $_REQUEST['txtCounty'];
	$txtPostcode = $_REQUEST['txtPostcode'];
	
	if($txtCustomerName == "")
	{
		$Error = 1;
		$Err_txtCustomerName = 'Required';
	}
	else
	{
		if(!preg_match("/^[a-zA-Z' ]*$/",$txtCustomerName))
		{
			$Error = 1;
			$Err_txtCustomerName = "Please enter valid inputs.";
		}
	}
	
	if($txtBusinessName == "")
	{
		$Error = 1;
		$Err_txtBusinessName = 'Required';
	}
	
	if($txtEamil == "")
	{
		$Error = 1;
		$Err_txtEamil = 'Required';
	}
	else
    {
        if(preg_match('|^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$|i', $txtEamil))
        {
        	/*$QUERY_CHK_EMAIL_AVAILABILITY = mysql_query("SELECT `pid` FROM `tbl_patients` WHERE patient_email = '".$patient_email."' ");
				
			if(mysql_num_rows($QUERY_CHK_EMAIL_AVAILABILITY) > 0)
			{
				$Error = 1;
				$Err_txtEamil = "This email ID is already registered with us. Please try another.";
			}*/
        }
        else
        {
            $Error = 1;
            $Err_txtEamil = "Please enter valid email.";
        }
    }
	
	if($txtCustomerName == "")
	{
		$Error = 1;
		$Err_txtCustomerName = 'Required';
	}
	
	if($txtCompanyNumber == "")
	{
		$Error = 1;
		$Err_txtCompanyNumber = 'Required';
	}
	
	if($txtAddress1 == "")
	{
		$Error = 1;
		$Err_txtAddress1 = 'Required';
	}
	
	
	if(isset($_REQUEST['chckTerms']))
	{
	}
	else
	{
		$Error = 1;
		$Err_chckTerms = 'Please accept the terms and conditions.';
	}
	
	if($Error==0)
	{
		$checkEmailAlreadyRegister=mysql_num_rows(mysql_query("SELECT `email_id` FROM tbl_customers WHERE `email_id`='".$txtEamil."'"));
		if($checkEmailAlreadyRegister==0)
		{
			mysql_query("INSERT INTO `tbl_customers`(`customer_name`,`business_name`,`email_id`,`vat_no`,`company_no`,`phone_landline`,`phone_mobile`,`address_1`,`address_2`,`city`,`county`,`postcode`,`area_of_intrest`,`joining_date`)VALUES('".$txtCustomerName."')");
		}
	}
	
}
?>
<ol class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li class="active">Registration</li>
</ol>
<div class="clearfix"></div>
<div class="men-wear" style="padding:30px 0;">
  <div class="container" style="margin-left: 2.5%;">
    <div class="registration">
      <h2 style="margin-top:3px !important;">Customer Registration Form</span></h2>
      <br>
      <h5 style="font-size:15px; font-weight:normal;"> Please fill out the form below & return it to DPR Wholesalers accompanied by a recent invoice (originals only) from
        a reputable trade supplier, which has been addressed to the business & address that you are applying for</h5>
      <form name="frmRegister" method="post" action="">
        <div class="register">
        <div class="register-top-grid"> <br>
          <br>
          <div> <span>Customer Name* <span style="color:Red;">
            <?php if(isset($Err_txtCustomerName) && $Err_txtCustomerName != "") { echo $Err_txtCustomerName;} ?>
            </span></span>
            <input name="txtCustomerName" type="text" maxlength="50" id="txtCustomerName" value="<?php if(isset($txtCustomerName) && $txtCustomerName != "") { echo $txtCustomerName;} ?>">
          </div>
          
          <!--<div>

						<span>Last Name* <span style="color:Red;"></span></span>

						<input name="txtLastName" type="text" maxlength="50" id="txtLastName" value="">

					 </div>-->
          
          <div> <span>Business Name* <span style="color:Red;">
            <?php if(isset($Err_txtBusinessName) && $Err_txtBusinessName != "") { echo $Err_txtBusinessName;} ?>
            </span></span>
            <input name="txtBusinessName" type="text" maxlength="50" id="txtBusinessName" value="<?php if(isset($txtBusinessName) && $txtBusinessName != "") { echo $txtBusinessName;} ?>">
          </div>
          <div> <span>Email Address* <span style="color:Red;">
            <?php if(isset($Err_txtEamil) && $Err_txtEamil != "") { echo $Err_txtEamil;} ?>
            </span></span>
            <input name="txtEamil" type="text" maxlength="50" id="txtEamil" value="<?php if(isset($txtEamil) && $txtEamil != "") { echo $txtEamil;} ?>">
          </div>
          <div> <span>VAT Reg. Number <span style="color:Red;">
            <?php if(isset($Err_txtVATNo) && $Err_txtVATNo != "") { echo $Err_txtVATNo;} ?>
            </span></span>
            <input name="txtVATNo" type="text" maxlength="50" id="txtVATNo" value="<?php if(isset($txtVATNo) && $txtVATNo != "") { echo $txtVATNo;} ?>">
          </div>
          <div> <span>Company Number* <span style="color:Red;">
            <?php if(isset($Err_txtCompanyNumber) && $Err_txtCompanyNumber != "") { echo $Err_txtCompanyNumber;} ?>
            </span></span>
            <input name="txtCompanyNumber" type="text" maxlength="50" id="txtCompanyNumber" value="<?php if(isset($Err_txtCompanyNumber) && $Err_txtCompanyNumber != "") { echo $Err_txtCompanyNumber;} ?>">
          </div>
          <div> <span>Phone No. (landline)<span style="color:Red;">
            <?php if(isset($Err_txtPhoneLandline) && $Err_txtPhoneLandline != "") { echo $Err_txtPhoneLandline;} ?>
            </span></span>
            <input name="txtPhoneLandline" type="text" maxlength="50" id="txtPhoneLandline" value="<?php if(isset($txtPhoneLandline) && $txtPhoneLandline != "") { echo $txtPhoneLandline;} ?>">
          </div>
          <div> <span>Phone No.(mobile) <span style="color:Red;">
            <?php if(isset($Err_txtPhoneMobile) && $Err_txtPhoneMobile != "") { echo $Err_txtPhoneMobile;} ?>
            </span></span>
            <input name="txtPhoneMobile" type="text" maxlength="50" id="txtPhoneMobile" value="<?php if(isset($Err_txtPhoneMobile) && $Err_txtPhoneMobile != "") { echo $Err_txtPhoneMobile;} ?>">
          </div>
          <div> <span>Address line 1 *<span style="color:Red;">
            <?php if(isset($Err_txtAddress1) && $Err_txtAddress1 != "") { echo $Err_txtAddress1;} ?>
            </span></span>
            <input name="txtAddress1" type="text" maxlength="50" id="txtAddress1" value="<?php if(isset($txtAddress1) && $txtAddress1 != "") { echo $txtAddress1;} ?>">
          </div>
          <div> <span>Address line 2 <span style="color:Red;"></span></span>
            <input name="txtAddress2" type="text" maxlength="50" id="txtAddress2" value="<?php if(isset($txtAddress2) && $txtAddress2 != "") { echo $txtAddress2;} ?>">
          </div>
          <div> <span>City / Town<span style="color:Red;"></span></span>
            <input name="txtCity" type="text" maxlength="50" id="txtCity" value="<?php if(isset($txtCity) && $txtCity != "") { echo $txtCity;} ?>">
          </div>
          <div> <span>County <span style="color:Red;"></span></span>
            <input name="txtCounty" type="text" maxlength="50" id="txtCounty" value="<?php if(isset($txtCounty) && $txtCounty != "") { echo $txtCounty;} ?>">
          </div>
          <div> <span>Postcode <span style="color:Red;">
            <?php if(isset($Err_txtPostcode) && $Err_txtPostcode != "") { echo $Err_txtPostcode;} ?>
            </span></span>
            <input name="txtPostcode" type="text" maxlength="50" id="txtPostcode" value="<?php if(isset($txtPostcode) && $txtPostcode != "") { echo $txtPostcode;} ?>">
          </div>
          <div class="clearfix" style="clear:both;"></div>
          <div> </div>
          <div class="register-top-grid2" style="width:98%;">
            <h4 style="display:block; width:100%; clear:both; padding:0px 0px 0px 0px;">Areas of Interest </h4>
            <div class="col-md-2">
              <div class="col-md-12">
                <label class="checkbox">
                  <input type="checkbox" style="width:auto !important;" name="chckTerms[]" value="Seasonal" >
                  Seasonal </label>
              </div>
              <div class="clearfix" style="clear:both; width:100%;"></div>
              <div class="col-md-12">
                <label class="checkbox">
                  <input type="checkbox" style="width:auto !important;" name="chckTerms[]" value="Tools">
                  Tools </label>
              </div>
              <div class="clearfix" style="clear:both; width:100%; padding:0; margin:0;"></div>
              <div class="col-md-12">
                <label class="checkbox">
                  <input type="checkbox" style="width:auto !important;" name="chckTerms[]" value="Party">
                  Party </label>
              </div>
              <div class="clearfix" style="clear:both; width:100%; padding:0; margin:0;"></div>
              <div class="col-md-12">
                <label class="checkbox">
                  <input type="checkbox" style="width:auto !important;" name="chckTerms[]" value="Electricals">
                  Electricals </label>
              </div>
              <div class="clearfix" style="clear:both; width:100%; padding:0; margin:0;"></div>
            </div>
            <div class="col-md-2">
              <div class="col-md-12">
                <label class="checkbox">
                  <input type="checkbox" style="width:auto !important;" name="chckTerms[]" value="Gifts & Frames" >
                  Gifts & Frames </label>
              </div>
              <div class="clearfix" style="clear:both; width:100%;"></div>
              <div class="col-md-12">
                <label class="checkbox">
                  <input type="checkbox" style="width:auto !important;" name="chckTerms[]" value="Gardening" >
                  Gardening </label>
              </div>
              <div class="clearfix" style="clear:both; width:100%; padding:0; margin:0;"></div>
              <div class="col-md-12">
                <label class="checkbox">
                  <input type="checkbox" style="width:auto !important;" name="chckTerms[]" value="Plastics">
                  Plastics </label>
              </div>
              <div class="clearfix" style="clear:both; width:100%; padding:0; margin:0;"></div>
              <div class="col-md-12">
                <label class="checkbox">
                  <input type="checkbox" style="width:auto !important;" name="chckTerms[]" value="Hardware" >
                  Hardware </label>
              </div>
              <div class="clearfix" style="clear:both; width:100%; padding:0; margin:0;"></div>
              <div class="clearfix" style="clear:both; width:100%; padding:0; margin:0;"></div>
            </div>
            <div class="col-md-2">
              <div class="col-md-12">
                <label class="checkbox">
                  <input type="checkbox" style="width:auto !important;" name="chckTerms[]" value="Kitchen" >
                  Kitchen </label>
              </div>
              <div class="clearfix" style="clear:both; width:100%;"></div>
              <div class="col-md-12">
                <label class="checkbox">
                  <input type="checkbox" style="width:auto !important;" name="chckTerms[]" value="Toys" >
                  Toys </label>
              </div>
              <div class="clearfix" style="clear:both; width:100%; padding:0; margin:0;"></div>
              <div class="col-md-12">
                <label class="checkbox">
                  <input type="checkbox" style="width:auto !important;" name="chckTerms[]" value="Glassware" >
                  Glassware </label>
              </div>
              <div class="clearfix" style="clear:both; width:100%; padding:0; margin:0;"></div>
              <div class="col-md-12">
                <label class="checkbox">
                  <input type="checkbox" style="width:auto !important;" name="chckTerms[]" value="Pet Care" >
                  Pet Care </label>
              </div>
              <div class="clearfix" style="clear:both; width:100%; padding:0; margin:0;"></div>
              <div class="clearfix" style="clear:both; width:100%; padding:0; margin:0;"></div>
            </div>
            <div class="col-md-2">
              <div class="col-md-12">
                <label class="checkbox">
                  <input type="checkbox" style="width:auto !important;" name="chckTerms[]" value="Home" >
                  Home </label>
              </div>
              <div class="clearfix" style="clear:both; width:100%;"></div>
              <div class="col-md-12">
                <label class="checkbox">
                  <input type="checkbox" style="width:auto !important;" name="chckTerms[]" value="Stationery">
                  Stationery </label>
              </div>
              <div class="clearfix" style="clear:both; width:100%; padding:0; margin:0;"></div>
              <div class="col-md-12">
                <label class="checkbox">
                  <input type="checkbox" style="width:auto !important;" name="chckTerms[]" value="Soft Toys">
                  Soft Toys </label>
              </div>
              <div class="clearfix" style="clear:both; width:100%; padding:0; margin:0;"></div>
              <div class="col-md-12">
                <label class="checkbox">
                  <input type="checkbox" style="width:auto !important;" name="chckTerms[]" value="Candles" >
                  Candles </label>
              </div>
              <div class="clearfix" style="clear:both; width:100%; padding:0; margin:0;"></div>
              <div class="clearfix" style="clear:both; width:100%; padding:0; margin:0;"></div>
            </div>
            <div class="col-md-2">
              <div class="col-md-12">
                <label class="checkbox">
                  <input type="checkbox" style="width:auto !important;" name="chckTerms[]" value="Disposables" >
                  Disposables </label>
              </div>
              <div class="clearfix" style="clear:both; width:100%;"></div>
              <div class="col-md-12">
                <label class="checkbox">
                  <input type="checkbox" style="width:auto !important;" name="chckTerms[]" value="Appliances" >
                  Appliances </label>
              </div>
              <div class="clearfix" style="clear:both; width:100%; padding:0; margin:0;"></div>
              <div class="col-md-12">
                <label class="checkbox">
                  <input type="checkbox" style="width:auto !important;" name="chckTerms[]" value="Baby" >
                  Baby </label>
              </div>
              <div class="clearfix" style="clear:both; width:100%; padding:0; margin:0;"></div>
              <div class="col-md-12">
                <label class="checkbox">
                  <input type="checkbox" style="width:auto !important;" name="chckTerms[]" value="Floristry & Baskets" >
                  Floristry & Baskets </label>
              </div>
              <div class="clearfix" style="clear:both; width:100%; padding:0; margin:0;"></div>
              <div class="clearfix" style="clear:both; width:100%; padding:0; margin:0;"></div>
            </div>
          </div>
          <a class="news-letter" href="#"></a>
          <div class="clearfix" style="clear:both; width:100%;"> </div>
          <div class="register-top-grid" style="width:100%; margin-left:30px;"> <a class="news-letter">
            <label class="checkbox">
              <input type="checkbox" style="width:auto !important;" name="chckTerms" >
              <i> </i>I accept the  terms and condition</label>
            </a> <br>
            <span style="color:Red;">
            <?php if(isset($Err_chckTerms) && $Err_chckTerms != "") { echo $Err_chckTerms; }?>
            </span>
            <div class="clearfix"> </div>
            <a class="news-letter" href="#"> 
            
            <!--<label class="checkbox"><input type="checkbox" name="checkbox" checked=""><i> </i>I accept the  terms and condition</label>--> 
            
            </a> </div>
          <div style="clear:both; width:100%;"> </div>
          <div class="register-but">
            <input type="submit"  style="margin-left:0; background:#fdae38;" name="btnRegister" class="orangebtn" value="Register">
            <div class="clearfix"> </div>
            <br>
            <br>
            <br>
            <br>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
