<?
ob_start();
if($_REQUEST['submit'])
{
	$error = NULL;
	$address= $_REQUEST['address'];
	$terminal_name=$_REQUEST['terminal_name'];
	if($terminal_name == '')
		$error[] = "Please enter the name.";
		
	//if($address == '')
	//	$error[] = "Please enter the address.";
							
	if(count($error) < 1)
	{
		$count=mysql_num_rows(mysql_query("SELECT ID FROM `tbl_terminal`"));
		$count=$count+1;
		$terminalId=$_REQUEST['type']."-".$count;
#		echo "INSERT INTO `tbl_terminal` (`terminal_id`,`type`,`address`)VALUES('".$terminalId."','".$_REQUEST['type']."','".$_REQUEST['address']."')";
#		exit();
		mysql_query("INSERT INTO `tbl_terminal` (`terminal_name`,`terminal_id`,`type`,`account_id`,`site_id`,`matrix`,`street`,`city`,`state`,`zip`,`tax`)VALUES('".$_REQUEST['terminal_name']."','".$terminalId."','".$_REQUEST['type']."','".$_REQUEST['account']."','".$_REQUEST['site']."','".$_REQUEST['matrix']."','".$_REQUEST['street']."','".$_REQUEST['city']."','".$_REQUEST['state']."','".$_REQUEST['zip']."','".$_REQUEST['tax']."')");			
		echo "<script> document.location.href='index.php?action=terminal_list'</script>";		
	}
}

?>
<div class="page-header" style="margin-top:20px;">
  <h1> Add Terminal</h1>
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
                        <script type="text/javascript">
							function LoadSites()
							{
								var account_id=document.getElementById('account').value;
								var xmlhttp;
								if (window.XMLHttpRequest)
								{// code for IE7+, Firefox, Chrome, Opera, Safari
								xmlhttp=new XMLHttpRequest();
								}
								else{// code for IE6, IE5
								xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
								}
								xmlhttp.onreadystatechange=function()
								{
								if (xmlhttp.readyState==4 && xmlhttp.status==200)
								{	
									document.getElementById('Sites_Div').innerHTML = xmlhttp.responseText;
								}
								}
								xmlhttp.open("POST","load_sites.php?account_id="+account_id,false);
								xmlhttp.send();

							}
					  	
                      </script>
                        <tr>
                          <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="left" class="text">
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Terminal Name</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="terminal_name"></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Account</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><select name="account" id="account" onChange="LoadSites()">
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
                                <td colspan="3"><div id="Sites_Div">
                                    <table cellpadding="0" cellspacing="0" align="center" width="100%">
                                      <tr>
                                        <td width="396" align="left" class="form-t">Site</td>
                                        <td width="19">:</td>
                                        <td width="604" height="40" align="left" class="textbox-bg2"><select name="site" id="site">
                                            <option value="">Select</option>
                                          </select></td>
                                      </tr>
                                    </table>
                                  </div></td>
                              </tr>
                              
                              <tr>
                                <td align="left" class="form-t">Street</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="street"></td>
                              </tr>
                              
                              <tr>
                                <td align="left" class="form-t">City</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="city"></td>
                              </tr>
                              
                              <tr>
                                <td align="left" class="form-t">State</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="state"></td>
                              </tr>
                              
                              <tr>
                                <td align="left" class="form-t">Zip</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="zip"></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Tax</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="tax"></td>
                              </tr>
                              
                              <!--<tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Address</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><textarea name="address"></textarea></td>
                              </tr>-->
                              <script type="text/javascript">
							  	function LoadMatrix()
								{
									var type=document.getElementById('type').value; 
									if(type=="LK" || type=="VM")
									{
										document.getElementById('Matrix_Div').style.display='block';
									}
									else
									{
										document.getElementById('Matrix_Div').style.display='none';
									}
								}
							  </script>
                              <tr>
                                <td align="left" class="form-t">Type</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><select name="type" id="type" onChange="LoadMatrix()">
                                    <option value="">--Select--</option>
                                    <option value="LK">Locker</option>
                                    <option value="ST">Store</option>
                                    <option value="VM">Vending Machine</option>
                                  </select></td>
                              </tr>
                              <tr>
                                <td colspan="3"><div id="Matrix_Div" style="display:none" >
                                    <table cellpadding="0" cellspacing="0" align="center" width="100%">
                                      <tr>
                                        <td width="396" align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Matrix</td>
                                        <td width="22">:</td>
                                        <td width="601" height="40" align="left" class="textbox-bg2"><select name="matrix" id="matrix">
                                            <option value="6 By 6">6 By 6</option>
                                            <option value="6 By 10">6 By 10</option>
                                          </select></td>
                                      </tr>
                                    </table>
                                  </div></td>
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
