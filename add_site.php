<?
ob_start();
if($_REQUEST['submit'])
{
	$error = NULL;
	$name= $_REQUEST['name'];
	$account= $_REQUEST['account'];
		
	if($name == '')
		$error[] = "Please enter the name.";
		
		if($account == '')
		$error[] = "Please enter the account.";
		
		
	
		
	if(count($error) < 1)
	{
		mysql_query("INSERT INTO `tbl_sites` (`name`,`account_id`,`time_zone`,`max_charge`,`site_id`,`contact_name`,`contact_phone`,`contact_email`,`billing_terms`,`billing_address`,`shipping_address`)VALUES('".$_REQUEST['name']."','".$_REQUEST['account']."','".$_REQUEST['time_zone']."','".$_REQUEST['max_charge']."','".$_REQUEST['site_id']."','".$_REQUEST['contact_name']."','".$_REQUEST['contact_phone']."','".$_REQUEST['contact_email']."','".$_REQUEST['billing_term']."','".$_REQUEST['billing_address']."','".$_REQUEST['shipping_address']."')");			
		echo "<script> document.location.href='index.php?action=site_list'</script>";		
	}
}

?>

<div class="page-header" style="margin-top:20px;">
  <h1> Add Site</h1>
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
                        <tr>
                          <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="left" class="text">
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Name</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="name"></td>
                              </tr>
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
                                <td align="left" class="form-t">Time Zone</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><select name="time_zone" id="time_zone" class="ddl">
                                    <option selected="selected" value="Dateline Standard Time">(UTC-12:00) International Date Line West</option>
                                    <option value="UTC-11">(UTC-11:00) Coordinated Universal Time-11</option>
                                    <option value="Hawaiian Standard Time">(UTC-10:00) Hawaii</option>
                                    <option value="Alaskan Standard Time">(UTC-09:00) Alaska</option>
                                    <option value="Pacific Standard Time (Mexico)">(UTC-08:00) Baja California</option>
                                    <option value="Pacific Standard Time">(UTC-08:00) Pacific Time (US &amp; Canada)</option>
                                    <option value="US Mountain Standard Time">(UTC-07:00) Arizona</option>
                                    <option value="Mountain Standard Time (Mexico)">(UTC-07:00) Chihuahua, La Paz, Mazatlan</option>
                                    <option value="Mountain Standard Time">(UTC-07:00) Mountain Time (US &amp; Canada)</option>
                                    <option value="Central America Standard Time">(UTC-06:00) Central America</option>
                                    <option value="Central Standard Time">(UTC-06:00) Central Time (US &amp; Canada)</option>
                                    <option value="Central Standard Time (Mexico)">(UTC-06:00) Guadalajara, Mexico City, Monterrey</option>
                                    <option value="Canada Central Standard Time">(UTC-06:00) Saskatchewan</option>
                                    <option value="SA Pacific Standard Time">(UTC-05:00) Bogota, Lima, Quito, Rio Branco</option>
                                    <option value="Eastern Standard Time">(UTC-05:00) Eastern Time (US &amp; Canada)</option>
                                    <option value="US Eastern Standard Time">(UTC-05:00) Indiana (East)</option>
                                    <option value="Venezuela Standard Time">(UTC-04:30) Caracas</option>
                                    <option value="Paraguay Standard Time">(UTC-04:00) Asuncion</option>
                                    <option value="Atlantic Standard Time">(UTC-04:00) Atlantic Time (Canada)</option>
                                    <option value="Central Brazilian Standard Time">(UTC-04:00) Cuiaba</option>
                                    <option value="SA Western Standard Time">(UTC-04:00) Georgetown, La Paz, Manaus, San Juan</option>
                                    <option value="Pacific SA Standard Time">(UTC-04:00) Santiago</option>
                                    <option value="Newfoundland Standard Time">(UTC-03:30) Newfoundland</option>
                                    <option value="E. South America Standard Time">(UTC-03:00) Brasilia</option>
                                    <option value="Argentina Standard Time">(UTC-03:00) Buenos Aires</option>
                                    <option value="SA Eastern Standard Time">(UTC-03:00) Cayenne, Fortaleza</option>
                                    <option value="Greenland Standard Time">(UTC-03:00) Greenland</option>
                                    <option value="Montevideo Standard Time">(UTC-03:00) Montevideo</option>
                                    <option value="Bahia Standard Time">(UTC-03:00) Salvador</option>
                                    <option value="UTC-02">(UTC-02:00) Coordinated Universal Time-02</option>
                                    <option value="Mid-Atlantic Standard Time">(UTC-02:00) Mid-Atlantic - Old</option>
                                    <option value="Azores Standard Time">(UTC-01:00) Azores</option>
                                    <option value="Cape Verde Standard Time">(UTC-01:00) Cabo Verde Is.</option>
                                    <option value="Morocco Standard Time">(UTC) Casablanca</option>
                                    <option value="UTC">(UTC) Coordinated Universal Time</option>
                                    <option value="GMT Standard Time">(UTC) Dublin, Edinburgh, Lisbon, London</option>
                                    <option value="Greenwich Standard Time">(UTC) Monrovia, Reykjavik</option>
                                    <option value="W. Europe Standard Time">(UTC+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
                                    <option value="Central Europe Standard Time">(UTC+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
                                    <option value="Romance Standard Time">(UTC+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                                    <option value="Central European Standard Time">(UTC+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
                                    <option value="W. Central Africa Standard Time">(UTC+01:00) West Central Africa</option>
                                    <option value="Namibia Standard Time">(UTC+01:00) Windhoek</option>
                                    <option value="Jordan Standard Time">(UTC+02:00) Amman</option>
                                    <option value="GTB Standard Time">(UTC+02:00) Athens, Bucharest</option>
                                    <option value="Middle East Standard Time">(UTC+02:00) Beirut</option>
                                    <option value="Egypt Standard Time">(UTC+02:00) Cairo</option>
                                    <option value="Syria Standard Time">(UTC+02:00) Damascus</option>
                                    <option value="E. Europe Standard Time">(UTC+02:00) E. Europe</option>
                                    <option value="South Africa Standard Time">(UTC+02:00) Harare, Pretoria</option>
                                    <option value="FLE Standard Time">(UTC+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>
                                    <option value="Turkey Standard Time">(UTC+02:00) Istanbul</option>
                                    <option value="Israel Standard Time">(UTC+02:00) Jerusalem</option>
                                    <option value="Kaliningrad Standard Time">(UTC+02:00) Kaliningrad (RTZ 1)</option>
                                    <option value="Libya Standard Time">(UTC+02:00) Tripoli</option>
                                    <option value="Arabic Standard Time">(UTC+03:00) Baghdad</option>
                                    <option value="Arab Standard Time">(UTC+03:00) Kuwait, Riyadh</option>
                                    <option value="Belarus Standard Time">(UTC+03:00) Minsk</option>
                                    <option value="Russian Standard Time">(UTC+03:00) Moscow, St. Petersburg, Volgograd (RTZ 2)</option>
                                    <option value="E. Africa Standard Time">(UTC+03:00) Nairobi</option>
                                    <option value="Iran Standard Time">(UTC+03:30) Tehran</option>
                                    <option value="Arabian Standard Time">(UTC+04:00) Abu Dhabi, Muscat</option>
                                    <option value="Azerbaijan Standard Time">(UTC+04:00) Baku</option>
                                    <option value="Russia Time Zone 3">(UTC+04:00) Izhevsk, Samara (RTZ 3)</option>
                                    <option value="Mauritius Standard Time">(UTC+04:00) Port Louis</option>
                                    <option value="Georgian Standard Time">(UTC+04:00) Tbilisi</option>
                                    <option value="Caucasus Standard Time">(UTC+04:00) Yerevan</option>
                                    <option value="Afghanistan Standard Time">(UTC+04:30) Kabul</option>
                                    <option value="West Asia Standard Time">(UTC+05:00) Ashgabat, Tashkent</option>
                                    <option value="Ekaterinburg Standard Time">(UTC+05:00) Ekaterinburg (RTZ 4)</option>
                                    <option value="Pakistan Standard Time">(UTC+05:00) Islamabad, Karachi</option>
                                    <option value="India Standard Time">(UTC+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                                    <option value="Sri Lanka Standard Time">(UTC+05:30) Sri Jayawardenepura</option>
                                    <option value="Nepal Standard Time">(UTC+05:45) Kathmandu</option>
                                    <option value="Central Asia Standard Time">(UTC+06:00) Astana</option>
                                    <option value="Bangladesh Standard Time">(UTC+06:00) Dhaka</option>
                                    <option value="N. Central Asia Standard Time">(UTC+06:00) Novosibirsk (RTZ 5)</option>
                                    <option value="Myanmar Standard Time">(UTC+06:30) Yangon (Rangoon)</option>
                                    <option value="SE Asia Standard Time">(UTC+07:00) Bangkok, Hanoi, Jakarta</option>
                                    <option value="North Asia Standard Time">(UTC+07:00) Krasnoyarsk (RTZ 6)</option>
                                    <option value="China Standard Time">(UTC+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                                    <option value="North Asia East Standard Time">(UTC+08:00) Irkutsk (RTZ 7)</option>
                                    <option value="Singapore Standard Time">(UTC+08:00) Kuala Lumpur, Singapore</option>
                                    <option value="W. Australia Standard Time">(UTC+08:00) Perth</option>
                                    <option value="Taipei Standard Time">(UTC+08:00) Taipei</option>
                                    <option value="Ulaanbaatar Standard Time">(UTC+08:00) Ulaanbaatar</option>
                                    <option value="Tokyo Standard Time">(UTC+09:00) Osaka, Sapporo, Tokyo</option>
                                    <option value="Korea Standard Time">(UTC+09:00) Seoul</option>
                                    <option value="Yakutsk Standard Time">(UTC+09:00) Yakutsk (RTZ 8)</option>
                                    <option value="Cen. Australia Standard Time">(UTC+09:30) Adelaide</option>
                                    <option value="AUS Central Standard Time">(UTC+09:30) Darwin</option>
                                    <option value="E. Australia Standard Time">(UTC+10:00) Brisbane</option>
                                    <option value="AUS Eastern Standard Time">(UTC+10:00) Canberra, Melbourne, Sydney</option>
                                    <option value="West Pacific Standard Time">(UTC+10:00) Guam, Port Moresby</option>
                                    <option value="Tasmania Standard Time">(UTC+10:00) Hobart</option>
                                    <option value="Magadan Standard Time">(UTC+10:00) Magadan</option>
                                    <option value="Vladivostok Standard Time">(UTC+10:00) Vladivostok, Magadan (RTZ 9)</option>
                                    <option value="Russia Time Zone 10">(UTC+11:00) Chokurdakh (RTZ 10)</option>
                                    <option value="Central Pacific Standard Time">(UTC+11:00) Solomon Is., New Caledonia</option>
                                    <option value="Russia Time Zone 11">(UTC+12:00) Anadyr, Petropavlovsk-Kamchatsky (RTZ 11)</option>
                                    <option value="New Zealand Standard Time">(UTC+12:00) Auckland, Wellington</option>
                                    <option value="UTC+12">(UTC+12:00) Coordinated Universal Time+12</option>
                                    <option value="Fiji Standard Time">(UTC+12:00) Fiji</option>
                                    <option value="Kamchatka Standard Time">(UTC+12:00) Petropavlovsk-Kamchatsky - Old</option>
                                    <option value="Tonga Standard Time">(UTC+13:00) Nuku'alofa</option>
                                    <option value="Samoa Standard Time">(UTC+13:00) Samoa</option>
                                    <option value="Line Islands Standard Time">(UTC+14:00) Kiritimati Island</option>
                                  </select></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Max Charge</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="max_charge"></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Site Id</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="site_id"></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Contact Name</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="contact_name"></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Contact Phone</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="contact_phone"></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Billing Term</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><select name="billing_term" id="billing_term">
                                    <option selected="selected" value="PRE">Pre-paid</option>
                                    <option value="N10">Net 10</option>
                                    <option value="N15">Net 15</option>
                                    <option value="N30">Net 30</option>
                                    <option value="N45">Net 45</option>
                                    <option value="N60">Net 60</option>
                                  </select></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Billing Address</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><textarea name="billing_address"></textarea></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Shipping Address</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><textarea name="shipping_address"></textarea></td>
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
