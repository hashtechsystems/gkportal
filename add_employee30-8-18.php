<?
ob_start();
if($_REQUEST['submit'])
{
	$error = NULL;
	$first_name= $_REQUEST['first_name'];
	$last_name= $_REQUEST['last_name'];
	$email_address= $_REQUEST['email_address'];
		
	if($first_name == '')
		$error[] = "Please enter the first name.";
		
		if($last_name == '')
		$error[] = "Please enter the last name.";
		
		if($email_address == '')
		$error[] = "Please enter the email address.";
		
		
	
		
	if(count($error) < 1)
	{
		//mysql_query("INSERT INTO `tbl_emploee` (`first_name`,`middle_name`,`last_name`,`email_address`,`birth_date`,`total_points`,`physician_name`,`physician_license`,`physician_address`,`type`)VALUES('".$_REQUEST['first_name']."','".$_REQUEST['middle_name']."','".$_REQUEST['last_name']."','".$_REQUEST['email_address']."','".$_REQUEST['birth_date']."','".$_REQUEST['total_points']."','".$_REQUEST['physician_name']."','".$_REQUEST['physician_license']."','".$_REQUEST['physician_address']."','".$_REQUEST['type']."')");	
		mysql_query("INSERT INTO `tbl_emploee` (`first_name`, `middle_name`, `last_name`, `email_address`, `birth_date`, `total_points`, `physician_name`, `physician_license`, `physician_address`, `type`, `joining_date`, `leaving_date`) VALUES ('".$_REQUEST['first_name']."', '".$_REQUEST['middle_name']."', '".$_REQUEST['last_name']."', '".$_REQUEST['email_address']."', '".$_REQUEST['birth_date']."', '".$_REQUEST['joining_date']."', '".$_REQUEST['leaving_date']."')");		
		echo "<script> document.location.href='index.php?action=employee_list'</script>";		
	}
}

?>

<div class="page-header tbg2" style="margin-top:20px;">
<div class="col-md-8">
  <h1> Add Employee </h1> </div>
  <div class="col-md-4" style="text-align:right;"><a href="index.php?action=employee_list&<?=$_REQUEST['page'];?>&ipp=<?=$_REQUEST['ipp'];?>" class="greenbtn1">Previous Page</a> </div>
  <div class="clearfix" style="display: -webkit-box;"></div>
</div>
<div class="" id="">
  <? $campaignid=$_REQUEST['campaignid']; 
	$report=$_REQUEST['report'];
	
?>
  <form action="" name="kiosk"  method="post" >
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
								<div class="col-md-12"> <label class="flebal"> First Name </label></div>
                                <div class="col-md-12">
                                	<input class="textbox6" type="text" name="first_name">
                                </div>
                              </div>
							  
							  <div class="clearfix gap1"> </div> 
                              <div class="w100">
								<div class="col-md-12"> <label class="flebal"> Middle Name </label></div>
                                <div class="col-md-12">
                                	<input class="textbox6" type="text" name="middle_name">
                                </div>
                              </div>
							  
							  <div class="clearfix gap1"> </div> 
                              <div class="w100">
								<div class="col-md-12"> <label class="flebal"> Last Name </label></div>     
								<div class="col-md-12">
                                	<input class="textbox6" type="text" name="last_name">
                                </div>
                              </div>
							  
							 <div class="clearfix gap1"> </div> 
							 <div class="w100">
								<div class="col-md-12"> <label class="flebal"> Email </label></div>
                                <div class="col-md-12">
                                	<input class="textbox6" type="email" name="email_address">
                                </div>
                             </div>
							 
							<div class="clearfix gap1"> </div> 
                             <div class="w100">
								<div class="col-md-12"> <label class="flebal"> Birth Date </label></div>
                                <div class="col-md-12">
                                	<input class="textbox6" type="date" name="birth_date">
                                </div>
                             </div>      
							  <!--<tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Total Points</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="total_points">
                                </td>
                              </tr>      
							  <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Physician Name</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="physician_name">
                                </td>
                              </tr>      
							  <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Physician License</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="physician_license">
                                </td>
                              </tr>
							  <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Physician Address</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="physician_address">
                                </td>
                              </tr>
							  <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Type</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="type">
                                </td>
                              </tr>     -->  
							  <div class="clearfix gap1"> </div> 
                              <div class="w100">
								<div class="col-md-12"><label class="flebal"> Joining Date </label></div>
                                <div class="col-md-12">
                                	<input class="textbox6" type="date" name="joining_date">
                                </div>
                              </div> 
							  
							 <div class="clearfix gap1"> </div> 
                             <div class="w100">
								<div class="col-md-12"> <label class="flebal"> Leaving Date </label></div>
                                <div class="col-md-12">
                                	<input class="textbox6" type="date" name="leaving_date">
                                </div>
                             </div>     
                             
							<div class="clearfix gap1"> </div> 							 
                             <div class="w100">
                                <div class="col-md-12"><input id="cmdCheck" name="submit" value="Add" type="submit" class="greenbtn2"/>
                                  &nbsp;&nbsp;<a href="index.php?action=employee_list" >
                                  <input type="button" value="Cancel" class="greenbtn2"/>
                                  </a>
                              </div>
							</div>
               
</div>
 </form>
