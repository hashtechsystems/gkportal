<?
ob_start();
if($_REQUEST['submit'])
{
	$error = NULL;
	$name= $_REQUEST['name'];
	$username= $_REQUEST['username'];
	$password= $_REQUEST['password'];
		
	if($name == '')
		$error[] = "Please enter the name.";
		
		if($username == '')
		$error[] = "Please enter the username.";
		
		if($password == '')
		$error[] = "Please enter the password.";
		
		
	
		
	if(count($error) < 1)
	{
		mysql_query("INSERT INTO `tbl_customers` (`name`,`username`,`password`,`city`,`state`,`zip`,`pos_assigned`)VALUES('".$_REQUEST['name']."','".$_REQUEST['username']."','".$_REQUEST['password']."','".$_REQUEST['city']."','".$_REQUEST['state']."','".$_REQUEST['zip']."','".$_REQUEST['pos']."')");			
		echo "<script> document.location.href='index.php?action=customers_list'</script>";		
	}
}

?>

<div class="page-header" style="margin-top:20px;">
  <h1> Add Customer </h1>
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
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Name</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="name">
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Username</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="username">
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Password</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="password">
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;City</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="city">
                                </td>
                              </tr>      
							  <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;State</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="state">
                                </td>
                              </tr>      
							  <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Zip</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="zip">
                                </td>
                              </tr>      
							  <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;POS</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<select name="pos">
										<option value="None">None</option>
										<option value="MJ Freeway">MJ Freeway</option>
										<option value="Treez">Treez</option>
										<option value="Baker">Baker</option>
										<option value="GK">GK</option>
										<option value="COVA">COVA</option>										
									</select>
                                </td>
                              </tr>                              
                              <tr align="left">
                                <td height="35" colspan="">&nbsp;</td>
                                <td width="20"></td>
                                <td height="40" colspan=""><input id="cmdCheck" name="submit" value="Add" type="submit" class="button"/>
                                  &nbsp;&nbsp;<a href="index.php" >
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
