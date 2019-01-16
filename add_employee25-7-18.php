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

<div class="page-header" style="margin-top:20px;">
  <h1> Add Employee </h1>
</div>
<div class="container" id="container">
  <? $campaignid=$_REQUEST['campaignid']; 
	$report=$_REQUEST['report'];
	
?>
  <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="bo02">
    <tr>
      <td class="des-bg2" ><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bo3">
          <tr>
            <td valign="top" bgcolor=""><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td valign="top"><form action="" name="kiosk"  method="post" >
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
                        <? if(isset($_REQUEST['s']))
					  {
						  ?>
                        <tr>
                          <td style="color:#990000;padding-left:15px;" align="left"> Password updated successfully. </td>
                        </tr>
                        <?
					  }
					  ?>
                        <tr>
                          <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="left" class="text">
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;First Name</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="first_name">
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Middle Name</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="middle_name">
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Last Name</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="last_name">
                                </td>
                              </tr>
							  <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Email</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="email" name="email_address">
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Birth Date</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="date" name="birth_date">
                                </td>
                              </tr>      
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
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;"></span>&nbsp;Joining Date</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="date" name="joining_date">
                                </td>
                              </tr> 
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;"></span>&nbsp;Leaving Date</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="date" name="leaving_date">
                                </td>
                              </tr>     
                                                     
                              <tr align="left">
                                <td height="35" colspan="">&nbsp;</td>
                                <td width="20"></td>
                                <td height="40" colspan=""><input id="cmdCheck" name="submit" value="Add" type="submit" class="button"/>
                                  &nbsp;&nbsp;<a href="index.php?action=employee_list" >
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
