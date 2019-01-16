<?
ob_start();
if($_REQUEST['submit'])
{
	$error = NULL;
	$address= $_REQUEST['address'];
		
	//if($address == '')
	//	$error[] = "Please enter the address.";
	
		
	if(count($error) < 1)
	{
		$count=mysql_num_rows(mysql_query("SELECT ID FROM `tbl_terminal`"));
		$count=$count;
		$terminalId=$_REQUEST['type']."-".$count;
#		echo "INSERT INTO `tbl_terminal` (`terminal_id`,`type`,`address`)VALUES('".$terminalId."','".$_REQUEST['type']."','".$_REQUEST['address']."')";
#		exit();
		mysql_query("UPDATE `tbl_terminal` SET `terminal_id`='".$terminalId."',`type`='".$_REQUEST['type']."',`account_id`='".$_REQUEST['account']."',`site_id`='".$_REQUEST['site']."',`terminal_name`='".$_REQUEST['terminal_name']."',`matrix`='".$_REQUEST['matrix']."',`street`='".$_REQUEST['street']."',`city`='".$_REQUEST['city']."',`state`='".$_REQUEST['state']."',`zip`='".$_REQUEST['zip']."',`tax`='".$_REQUEST['tax']."' WHERE `id`='".$_REQUEST['id']."'");			
		echo "<script> document.location.href='index.php?action=terminal_list'</script>";		
	}
}
$getDetails=mysql_fetch_array(mysql_query("SELECT * FROM tbl_terminal WHERE `id`='".$_REQUEST['id']."'"));
?>

<div class="page-header" style="margin-top:20px;">
  <h1> Edit Terminal</h1>
</div>
<div class="container" id="container">  
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
                                <td height="40" class="textbox-bg2" align="left">
                                	<input type="text" name="terminal_name" value="<?=$getDetails['terminal_name'];?>">
                                    
                                </td>
                              </tr>
                              
                              <tr>
                                <td align="left" class="form-t">Account</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<select name="account" id="account" onChange="LoadSites()">
                                    	<? 
										$query=mysql_query("SELECT * FROM `tbl_accounts`");
										while($data=mysql_fetch_array($query))
										{
											?>
                                            	<option value="<?=$data['id'];?>" <? if($data['id']==$getDetails['account_id']){ ?>s selected <? }?>><?=$data['name'];?> </option>
                                            <?
										}
										?>
                                    </select>
                                    <input type="hidden" name="id" value="<?=$_REQUEST['id'];?>">
                                </td>
                              </tr>
                              <tr>
                              	<td colspan="3">
                                <div id="Sites_Div">
                                	<table cellpadding="0" cellspacing="0" align="center" width="100%">	
                                    	<tr>	
                                        	<td width="395" align="left" class="form-t">&nbsp;Site</td>
                                            <td width="23">:</td>
                                            <td width="601" height="40" align="left" class="textbox-bg2">
                                                <select name="site" id="site">
												<? 
                                                $query=mysql_query("SELECT * FROM `tbl_sites` WHERE `account_id`='".$getDetails['account_id']."'");
                                                while($data=mysql_fetch_array($query))
                                                {
                                                    ?>
                                                    <option value="<?=$data['id'];?>">
                                                    <?=$data['name'];?>
                                                    </option>
                                                    <?
                                                }
                                                ?>
                                              </select>
                                                
                                            </td>
                                        </tr>
                                    </table>
                                    </div>
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Street</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="street" value="<?=$getDetails['street'];?>"></td>
                              </tr>
                              
                              <tr>
                                <td align="left" class="form-t">City</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="city" value="<?=$getDetails['city'];?>"></td>
                              </tr>
                              
                              <tr>
                                <td align="left" class="form-t">State</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="state" value="<?=$getDetails['state'];?>"></td>
                              </tr>
                              
                              <tr>
                                <td align="left" class="form-t">Zip</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="zip" value="<?=$getDetails['zip'];?>"></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Tax</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="tax" value="<?=$getDetails['tax'];?>"></td>
                              </tr>
                              <!--<tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Address</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<textarea name="address"><?=$getDetails['address'];?></textarea>
                                    <input type="hidden" name="id" value="<?=$_REQUEST['id'];?>">
                                </td>
                              </tr>-->
                              <tr>
                                <td align="left" class="form-t">Type</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><select name="type" onChange="LoadMatrix()">
                                    <option value="LK" <? if($getDetails['type']=="LK"){ ?> selected <? } ?>>Locker</option>
                                    <option value="ST" <? if($getDetails['type']=="ST"){ ?> selected <? } ?>>Store</option>
                                    <option value="VM" <? if($getDetails['type']=="VM"){ ?> selected <? } ?>>Vending Machine</option>
                                    </select></td>
                              </tr>
                              
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
                              	<td colspan="3">
                                <div id="Matrix_Div" <? if($getDetails['type']=="ST"){ ?>style="display:none"  <? } ?>>
                                	<table cellpadding="0" cellspacing="0" align="center" width="100%">	
                                    	<tr>	
                                        	<td width="397" align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Matrix</td>
                                            <td width="20">:</td>
                                            <td width="602" height="40" align="left" class="textbox-bg2">
                                                <select name="matrix" id="matrix">
                                                   <option value="6 By 6" <? if($getDetails['matrix']=="6 By 6"){ ?> selected <? } ?>>6 By 6</option>
                                                   <option value="6 By 10" <? if($getDetails['matrix']=="6 By 10"){ ?> selected <? } ?>>6 By 10</option>
                                                </select>
                                                
                                            </td>
                                        </tr>
                                    </table>
                                    </div>
                                </td>
                              </tr>
                              
                              <tr align="left">
                                <td height="35" colspan="">&nbsp;</td>
                                <td width="20"></td>
                                <td height="40" colspan=""><input id="cmdCheck" name="submit" value="Update" type="submit" class="button"/>
                                  &nbsp;&nbsp;<a href="index.php?action=terminal_list" >
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
