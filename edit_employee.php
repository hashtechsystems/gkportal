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
		//mysql_query("UPDATE `tbl_emploee` SET `first_name`='".$_REQUEST['first_name']."',`middle_name`='".$_REQUEST['middle_name']."',`last_name`='".$_REQUEST['last_name']."',`email_address`='".$_REQUEST['email_address']."',`birth_date`='".$_REQUEST['birth_date']."',`total_points`='".$_REQUEST['total_points']."',`physician_name`='".$_REQUEST['physician_name']."',`physician_license`='".$_REQUEST['physician_license']."',`physician_address`='".$_REQUEST['physician_address']."',`type`='".$_REQUEST['type']."' WHERE id='".$_REQUEST['id']."'");	
		mysql_query("UPDATE `tbl_emploee` SET `first_name`='".$_REQUEST['first_name']."',`middle_name`='".$_REQUEST['middle_name']."',`last_name`='".$_REQUEST['last_name']."',`email_address`='".$_REQUEST['email_address']."',`birth_date`='".$_REQUEST['birth_date']."', `joining_date` = '".$_REQUEST['joining_date']."', `leaving_date` ='".$_REQUEST['leaving_date']."' WHERE id='".$_REQUEST['id']."'");	
				
		echo "<script> document.location.href='index.php?action=employee_list'</script>";		
	}
}
$getEmployee=mysql_fetch_array(mysql_query("SELECT * FROM `tbl_emploee` WHERE `id`='".$_REQUEST['id']."'"));
?>

<div class="page-header" style="margin-top:20px;">
  <h1> Edit Employee </h1>
</div>
<div class="container" id="container">
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
                                	<input type="hidden" name="id" value="<?=$getEmployee['id'];?>">
									<input class="textbox6" type="text" name="first_name" value="<?=$getEmployee['first_name'];?>">
                                </div>
                              </div>
							  
							  <div class="clearfix gap1"> </div> 
                              <div class="w100">
							  <div class="col-md-12"> <label class="flebal"> Middle Name </label></div>
                                <div class="col-md-12">
                                	<input class="textbox6" type="text" name="middle_name" value="<?=$getEmployee['middle_name'];?>">
                                </div>
                              </div>
							 
							  <div class="clearfix gap1"> </div> 
                             <div class="w100">
							 <div class="col-md-12"> <label class="flebal"> Last Name </label></div>
                                <div class="col-md-12">
                                	<input class="textbox6" type="text" name="last_name" value="<?=$getEmployee['last_name'];?>">
                                </div>
                              </div>
							 
							 <div class="clearfix gap1"> </div> 
							 <div class="w100">
							 <div class="col-md-12"> <label class="flebal"> Email </label></div>
                                <div class="col-md-12">
                                	<input class="textbox6" type="email" name="email_address" value="<?=$getEmployee['email_address'];?>">
                                </div>
                             </div>
							  
							   <div class="clearfix gap1"> </div> 
                              <div class="w100">
							  <div class="col-md-12"> <label class="flebal"> Birth Date </label></div>
                                <div class="col-md-12">
									<input class="textbox6" type="date" name="birth_date" value="<?=$getEmployee['birth_date'];?>">
                                </div>
                              </div>      
							  <!--<tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Total Points</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="total_points" value="<?=$getEmployee['total_points'];?>">
                                </td>
                              </tr>      
							  <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Physician Name</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="physician_name" value="<?=$getEmployee['physician_name'];?>">
                                </td>
                              </tr>      
							  <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Physician License</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="physician_license" value="<?=$getEmployee['physician_license'];?>">
                                </td>
                              </tr>
							  <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Physician Address</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="physician_address" value="<?=$getEmployee['physician_address'];?>">
                                </td>
                              </tr>
							  <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Type</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="type" value="<?=$getEmployee['type'];?>">
                                </td>
                              </tr>--> 
							   <div class="clearfix gap1"> </div> 
                              <div class="w100">
							  <div class="col-md-12"> <label class="flebal"> Joining Date </label></div>
                                <div class="col-md-12">
									<input class="textbox6" type="date" name="joining_date" value="<?=$getEmployee['joining_date'];?>">
                                </div>
                              </div> 
							  
							   <div class="clearfix gap1"> </div> 
                              <div class="w100">
							  <div class="col-md-12"> <label class="flebal">Leaving Date </label></div>
                                <div class="col-md-12">
									<input class="textbox6" type="date" name="leaving_date" value="<?=$getEmployee['leaving_date'];?>">
                                </div>
                              </div> 
							  
							   <div class="clearfix gap1"> </div> 
                               <div class="w100">
                                 <div class="col-md-12">
								 <input id="cmdCheck" name="submit" value="Update" type="submit"  class="greenbtn2"/>
                                  &nbsp;&nbsp;<a href="index.php?action=employee_list" >
                                  <input type="button" value="Cancel"  class="greenbtn2"/>
                                 </div>
							  </div>
  </div>                            
</form>

