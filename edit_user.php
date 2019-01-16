<?
ob_start();
if($_REQUEST['submit'])
{
	$error = NULL;
	$username= $_REQUEST['username'];
	$password= $_REQUEST['password'];
	$first_name= $_REQUEST['first_name'];
	$last_name= $_REQUEST['last_name'];
		
	if($username == '')
		$error[] = "Please enter the username.";
		
		if($password == '')
		$error[] = "Please enter the password.";
		
		if($first_name == '')
		$error[] = "Please enter the first name.";
		
		if($last_name == '')
		$error[] = "Please enter the last name.";
	
		
	if(count($error) < 1)
	{
		$count=mysql_num_rows(mysql_query("SELECT ID FROM `tbl_terminal`"));
		$count=$count+1;
		$terminalId=$_REQUEST['type']."-".$count;
		#echo "<pre>";
		#print_r($_REQUEST);
#		echo "INSERT INTO `tbl_terminal` (`terminal_id`,`type`,`address`)VALUES('".$terminalId."','".$_REQUEST['type']."','".$_REQUEST['address']."')";
#		exit();
#echo "UPDATE `tbl_users` SET `first_name`='".$_REQUEST['first_name']."',`last_name`='".$_REQUEST['last_name']."',`username`='".$_REQUEST['username']."',`password`='".$_REQUEST['password']."' WHERE `id`='".$_REQUEST['id']."'";
#exit();
		mysql_query("UPDATE `tbl_users` SET `first_name`='".$_REQUEST['first_name']."',`last_name`='".$_REQUEST['last_name']."',`username`='".$_REQUEST['username']."',`password`='".$_REQUEST['password']."',`account_id`='".$_REQUEST['account']."' WHERE `id`='".$_REQUEST['id']."'");			
		echo "<script> document.location.href='index.php?action=user_list'</script>";		
	}
}
$getDetails=mysql_fetch_array(mysql_query("SELECT * FROM `tbl_users` WHERE `id`='".$_REQUEST['id']."'"));
?>

<div class="page-header" style="margin-top:20px;">
  <h1> Edit User</h1>
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
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Account</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><select name="account">
                                    <? 
										$query=mysql_query("SELECT * FROM `tbl_accounts`");
										while($data=mysql_fetch_array($query))
										{
											?>
                                    <option value="<?=$data['id'];?>" <? if($data['id']==$getDetails['account_id']){ ?>s selected <? }?>>
                                    <?=$data['name'];?>
                                    </option>
                                    <?
										}
										?>
                                  </select></td>
                              </tr>
                              
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Username</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="username" value="<?=$getDetails['username'];?>">
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Password</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="password" value="<?=$getDetails['password'];?>">
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;First Name</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="first_name" value="<?=$getDetails['first_name'];?>">
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Last Name</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="last_name" value="<?=$getDetails['last_name'];?>">
                                </td>
                              </tr>
                              <tr align="left">
                                <td height="35" colspan="">&nbsp;</td>
                                <td width="20"></td>
                                <td height="40" colspan=""><input id="cmdCheck" name="submit" value="Update" type="submit" class="button"/>
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
