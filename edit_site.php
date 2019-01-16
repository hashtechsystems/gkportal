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
		mysql_query("UPDATE `tbl_sites`  SET `name`='".$_REQUEST['name']."',`account_id`='".$_REQUEST['account']."',`time_zone`='".$_REQUEST['time_zone']."',`max_charge`='".$_REQUEST['max_charge']."',`site_id`='".$_REQUEST['site_id']."',`contact_name`='".$_REQUEST['contact_name']."',`contact_phone`='".$_REQUEST['contact_phone']."',`contact_email`='".$_REQUEST['contact_email']."',`billing_terms`='".$_REQUEST['billing_term']."',`billing_address`='".$_REQUEST['billing_address']."',`shipping_address`='".$_REQUEST['shipping_address']."' WHERE `id`='".$_REQUEST['id']."'");			
		echo "<script> document.location.href='index.php?action=site_list'</script>";		
	}
}
$getSiteDetails=mysql_fetch_array(mysql_query("SELECT * FROM `tbl_sites` WHERE `id`='".$_REQUEST['id']."'"));

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
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="name" value="<?=$getSiteDetails['name'];?>"></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Account</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                <input type="hidden" name="id" value="<?=$getSiteDetails['id'];?>">
                                <select name="account">
                                    <? 
										$query=mysql_query("SELECT * FROM `tbl_accounts`");
										while($data=mysql_fetch_array($query))
										{
											?>
                                    <option value="<?=$data['id'];?>" <? if($data['id']==$getSiteDetails['account_id']){ ?> selected <? }?>>
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
                                    <option <? if($getSiteDetails['time_zone']=="Dateline Standard Time"){ ?> selected="selected" <? } ?> value="Dateline Standard Time">(UTC-12:00) International Date Line West</option>
                                    <option value="UTC-11" <? if($getSiteDetails['time_zone']=="UTC-11"){ ?> selected="selected" <? } ?>>(UTC-11:00) Coordinated Universal Time-11</option>
                                    <option value="Hawaiian Standard Time" <? if($getSiteDetails['time_zone']=="Hawaiian Standard Time"){ ?> selected="selected" <? } ?>>(UTC-10:00) Hawaii</option>
                                    <option value="Alaskan Standard Time" <? if($getSiteDetails['time_zone']=="Alaskan Standard Time"){ ?> selected="selected" <? } ?>>(UTC-09:00) Alaska</option>
                                    <option value="Pacific Standard Time (Mexico)" <? if($getSiteDetails['time_zone']=="Pacific Standard Time (Mexico)"){ ?> selected="selected" <? } ?>>(UTC-08:00) Baja California</option>
                                    <option value="Pacific Standard Time" <? if($getSiteDetails['time_zone']=="Pacific Standard Time"){ ?> selected="selected" <? } ?>>(UTC-08:00) Pacific Time (US &amp; Canada)</option>
                                    <option value="US Mountain Standard Time" <? if($getSiteDetails['time_zone']=="US Mountain Standard Time"){ ?> selected="selected" <? } ?>>(UTC-07:00) Arizona</option>
                                    <option value="Mountain Standard Time (Mexico)" <? if($getSiteDetails['time_zone']=="Mountain Standard Time (Mexico)"){ ?> selected="selected" <? } ?>>(UTC-07:00) Chihuahua, La Paz, Mazatlan</option>
                                    <option value="Mountain Standard Time" <? if($getSiteDetails['time_zone']=="Mountain Standard Time"){ ?> selected="selected" <? } ?>>(UTC-07:00) Mountain Time (US &amp; Canada)</option>
                                    <option value="Central America Standard Time" <? if($getSiteDetails['time_zone']=="Central America Standard Time"){ ?> selected="selected" <? } ?>>(UTC-06:00) Central America</option>
                                    <option value="Central Standard Time" <? if($getSiteDetails['time_zone']=="Central Standard Time"){ ?> selected="selected" <? } ?>>(UTC-06:00) Central Time (US &amp; Canada)</option>
                                    <option value="Central Standard Time (Mexico)" <? if($getSiteDetails['time_zone']=="Central Standard Time (Mexico)"){ ?> selected="selected" <? } ?>>(UTC-06:00) Guadalajara, Mexico City, Monterrey</option>
                                    <option value="Canada Central Standard Time" <? if($getSiteDetails['time_zone']=="Canada Central Standard Time"){ ?> selected="selected" <? } ?>>(UTC-06:00) Saskatchewan</option>
                                    <option value="SA Pacific Standard Time" <? if($getSiteDetails['time_zone']=="SA Pacific Standard Time"){ ?> selected="selected" <? } ?>>(UTC-05:00) Bogota, Lima, Quito, Rio Branco</option>
                                    <option value="Eastern Standard Time" <? if($getSiteDetails['time_zone']=="Eastern Standard Time"){ ?> selected="selected" <? } ?>>(UTC-05:00) Eastern Time (US &amp; Canada)</option>
                                    <option value="US Eastern Standard Time" <? if($getSiteDetails['time_zone']=="US Eastern Standard Time"){ ?> selected="selected" <? } ?>>(UTC-05:00) Indiana (East)</option>
                                    <option value="Venezuela Standard Time" <? if($getSiteDetails['time_zone']=="Venezuela Standard Time"){ ?> selected="selected" <? } ?>>(UTC-04:30) Caracas</option>
                                    <option value="Paraguay Standard Time" <? if($getSiteDetails['time_zone']=="Paraguay Standard Time"){ ?> selected="selected" <? } ?>>(UTC-04:00) Asuncion</option>
                                    <option value="Atlantic Standard Time" <? if($getSiteDetails['time_zone']=="Atlantic Standard Time"){ ?> selected="selected" <? } ?>>(UTC-04:00) Atlantic Time (Canada)</option>
                                    <option value="Central Brazilian Standard Time" <? if($getSiteDetails['time_zone']=="Central Brazilian Standard Time"){ ?> selected="selected" <? } ?>>(UTC-04:00) Cuiaba</option>
                                    <option value="SA Western Standard Time" <? if($getSiteDetails['time_zone']=="SA Western Standard Time"){ ?> selected="selected" <? } ?>>(UTC-04:00) Georgetown, La Paz, Manaus, San Juan</option>
                                    <option value="Pacific SA Standard Time" <? if($getSiteDetails['time_zone']=="Pacific SA Standard Time"){ ?> selected="selected" <? } ?>>(UTC-04:00) Santiago</option>
                                    <option value="Newfoundland Standard Time" <? if($getSiteDetails['time_zone']=="Newfoundland Standard Time"){ ?> selected="selected" <? } ?>>(UTC-03:30) Newfoundland</option>
                                    <option value="E. South America Standard Time" <? if($getSiteDetails['time_zone']=="E. South America Standard Time"){ ?> selected="selected" <? } ?>>(UTC-03:00) Brasilia</option>
                                    <option value="Argentina Standard Time" <? if($getSiteDetails['time_zone']=="Argentina Standard Time"){ ?> selected="selected" <? } ?> >(UTC-03:00) Buenos Aires</option>
                                    <option value="SA Eastern Standard Time" <? if($getSiteDetails['time_zone']=="SA Eastern Standard Time"){ ?> selected="selected" <? } ?> >(UTC-03:00) Cayenne, Fortaleza</option>
                                    <option value="Greenland Standard Time" <? if($getSiteDetails['time_zone']=="Greenland Standard Time"){ ?> selected="selected" <? } ?> >(UTC-03:00) Greenland</option>
                                    <option value="Montevideo Standard Time" <? if($getSiteDetails['time_zone']=="Montevideo Standard Time"){ ?> selected="selected" <? } ?> >(UTC-03:00) Montevideo</option>
                                    <option value="Bahia Standard Time" <? if($getSiteDetails['time_zone']=="Bahia Standard Time"){ ?> selected="selected" <? } ?> >(UTC-03:00) Salvador</option>
                                    <option value="UTC-02" <? if($getSiteDetails['time_zone']=="UTC-02"){ ?> selected="selected" <? } ?> >(UTC-02:00) Coordinated Universal Time-02</option>
                                    <option value="Mid-Atlantic Standard Time" <? if($getSiteDetails['time_zone']=="Mid-Atlantic Standard Time"){ ?> selected="selected" <? } ?> >(UTC-02:00) Mid-Atlantic - Old</option>
                                    <option value="Azores Standard Time" <? if($getSiteDetails['time_zone']=="Azores Standard Time"){ ?> selected="selected" <? } ?> >(UTC-01:00) Azores</option>
                                    <option value="Cape Verde Standard Time" <? if($getSiteDetails['time_zone']=="Cape Verde Standard Time"){ ?> selected="selected" <? } ?> >(UTC-01:00) Cabo Verde Is.</option>
                                    <option value="Morocco Standard Time" <? if($getSiteDetails['time_zone']=="Morocco Standard Time"){ ?> selected="selected" <? } ?> >(UTC) Casablanca</option>
                                    <option value="UTC" <? if($getSiteDetails['time_zone']=="UTC"){ ?> selected="selected" <? } ?> >(UTC) Coordinated Universal Time</option>
                                    <option value="GMT Standard Time" <? if($getSiteDetails['time_zone']=="GMT Standard Time"){ ?> selected="selected" <? } ?> >(UTC) Dublin, Edinburgh, Lisbon, London</option>
                                    <option value="Greenwich Standard Time" <? if($getSiteDetails['time_zone']=="Greenwich Standard Time"){ ?> selected="selected" <? } ?> >(UTC) Monrovia, Reykjavik</option>
                                    <option value="W. Europe Standard Time" <? if($getSiteDetails['time_zone']=="W. Europe Standard Time"){ ?> selected="selected" <? } ?> >(UTC+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
                                    <option value="Central Europe Standard Time" <? if($getSiteDetails['time_zone']=="Central Europe Standard Time"){ ?> selected="selected" <? } ?> >(UTC+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
                                    <option value="Romance Standard Time" <? if($getSiteDetails['time_zone']=="Romance Standard Time"){ ?> selected="selected" <? } ?> >(UTC+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                                    <option value="Central European Standard Time" <? if($getSiteDetails['time_zone']=="Central European Standard Time"){ ?> selected="selected" <? } ?> >(UTC+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
                                    <option value="W. Central Africa Standard Time" <? if($getSiteDetails['time_zone']=="W. Central Africa Standard Time"){ ?> selected="selected" <? } ?> >(UTC+01:00) West Central Africa</option>
                                    <option value="Namibia Standard Time" <? if($getSiteDetails['time_zone']=="Namibia Standard Time"){ ?> selected="selected" <? } ?> >(UTC+01:00) Windhoek</option>
                                    <option value="Jordan Standard Time" <? if($getSiteDetails['time_zone']=="Jordan Standard Time"){ ?> selected="selected" <? } ?> >(UTC+02:00) Amman</option>
                                    <option value="GTB Standard Time" <? if($getSiteDetails['time_zone']=="GTB Standard Time"){ ?> selected="selected" <? } ?> >(UTC+02:00) Athens, Bucharest</option>
                                    <option value="Middle East Standard Time" <? if($getSiteDetails['time_zone']=="Middle East Standard Time"){ ?> selected="selected" <? } ?> >(UTC+02:00) Beirut</option>
                                    <option value="Egypt Standard Time" <? if($getSiteDetails['time_zone']=="Egypt Standard Time"){ ?> selected="selected" <? } ?> >(UTC+02:00) Cairo</option>
                                    <option value="Syria Standard Time" <? if($getSiteDetails['time_zone']=="Syria Standard Time"){ ?> selected="selected" <? } ?> >(UTC+02:00) Damascus</option>
                                    <option value="E. Europe Standard Time" <? if($getSiteDetails['time_zone']=="E. Europe Standard Time"){ ?> selected="selected" <? } ?> >(UTC+02:00) E. Europe</option>
                                    <option value="South Africa Standard Time" <? if($getSiteDetails['time_zone']=="South Africa Standard Time"){ ?> selected="selected" <? } ?> >(UTC+02:00) Harare, Pretoria</option>
                                    <option value="FLE Standard Time" <? if($getSiteDetails['time_zone']=="FLE Standard Time"){ ?> selected="selected" <? } ?> >(UTC+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>
                                    <option value="Turkey Standard Time" <? if($getSiteDetails['time_zone']=="Turkey Standard Time"){ ?> selected="selected" <? } ?> >(UTC+02:00) Istanbul</option>
                                    <option value="Israel Standard Time" <? if($getSiteDetails['time_zone']=="Israel Standard Time"){ ?> selected="selected" <? } ?> >(UTC+02:00) Jerusalem</option>
                                    <option value="Kaliningrad Standard Time" <? if($getSiteDetails['time_zone']=="Kaliningrad Standard Time"){ ?> selected="selected" <? } ?> >(UTC+02:00) Kaliningrad (RTZ 1)</option>
                                    <option value="Libya Standard Time" <? if($getSiteDetails['time_zone']=="Libya Standard Time"){ ?> selected="selected" <? } ?> >(UTC+02:00) Tripoli</option>
                                    <option value="Arabic Standard Time" <? if($getSiteDetails['time_zone']=="Arabic Standard Time"){ ?> selected="selected" <? } ?> >(UTC+03:00) Baghdad</option>
                                    <option value="Arab Standard Time" <? if($getSiteDetails['time_zone']=="Arab Standard Time"){ ?> selected="selected" <? } ?> >(UTC+03:00) Kuwait, Riyadh</option>
                                    <option value="Belarus Standard Time" <? if($getSiteDetails['time_zone']=="Belarus Standard Time"){ ?> selected="selected" <? } ?> >(UTC+03:00) Minsk</option>
                                    <option value="Russian Standard Time" <? if($getSiteDetails['time_zone']=="Russian Standard Time"){ ?> selected="selected" <? } ?> >(UTC+03:00) Moscow, St. Petersburg, Volgograd (RTZ 2)</option>
                                    <option value="E. Africa Standard Time" <? if($getSiteDetails['time_zone']=="E. Africa Standard Time"){ ?> selected="selected" <? } ?> >(UTC+03:00) Nairobi</option>
                                    <option value="Iran Standard Time" <? if($getSiteDetails['time_zone']=="Iran Standard Time"){ ?> selected="selected" <? } ?> >(UTC+03:30) Tehran</option>
                                    <option value="Arabian Standard Time" <? if($getSiteDetails['time_zone']=="Arabian Standard Time"){ ?> selected="selected" <? } ?> >(UTC+04:00) Abu Dhabi, Muscat</option>
                                    <option value="Azerbaijan Standard Time" <? if($getSiteDetails['time_zone']=="Azerbaijan Standard Time"){ ?> selected="selected" <? } ?> >(UTC+04:00) Baku</option>
                                    <option value="Russia Time Zone 3" <? if($getSiteDetails['time_zone']=="Russia Time Zone 3"){ ?> selected="selected" <? } ?> >(UTC+04:00) Izhevsk, Samara (RTZ 3)</option>
                                    <option value="Mauritius Standard Time" <? if($getSiteDetails['time_zone']=="Mauritius Standard Time"){ ?> selected="selected" <? } ?> >(UTC+04:00) Port Louis</option>
                                    <option value="Georgian Standard Time" <? if($getSiteDetails['time_zone']=="Georgian Standard Time"){ ?> selected="selected" <? } ?> >(UTC+04:00) Tbilisi</option>
                                    <option value="Caucasus Standard Time" <? if($getSiteDetails['time_zone']=="Caucasus Standard Time"){ ?> selected="selected" <? } ?> >(UTC+04:00) Yerevan</option>
                                    <option value="Afghanistan Standard Time" <? if($getSiteDetails['time_zone']=="Afghanistan Standard Time"){ ?> selected="selected" <? } ?> >(UTC+04:30) Kabul</option>
                                    <option value="West Asia Standard Time" <? if($getSiteDetails['time_zone']=="West Asia Standard Time"){ ?> selected="selected" <? } ?> >(UTC+05:00) Ashgabat, Tashkent</option>
                                    <option value="Ekaterinburg Standard Time" <? if($getSiteDetails['time_zone']=="Ekaterinburg Standard Time"){ ?> selected="selected" <? } ?> >(UTC+05:00) Ekaterinburg (RTZ 4)</option>
                                    <option value="Pakistan Standard Time" <? if($getSiteDetails['time_zone']=="Pakistan Standard Time"){ ?> selected="selected" <? } ?> >(UTC+05:00) Islamabad, Karachi</option>
                                    <option value="India Standard Time" <? if($getSiteDetails['time_zone']=="India Standard Time"){ ?> selected="selected" <? } ?> >(UTC+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                                    <option value="Sri Lanka Standard Time" <? if($getSiteDetails['time_zone']=="Sri Lanka Standard Time"){ ?> selected="selected" <? } ?> >(UTC+05:30) Sri Jayawardenepura</option>
                                    <option value="Nepal Standard Time" <? if($getSiteDetails['time_zone']=="Nepal Standard Time"){ ?> selected="selected" <? } ?> >(UTC+05:45) Kathmandu</option>
                                    <option value="Central Asia Standard Time" <? if($getSiteDetails['time_zone']=="Central Asia Standard Time"){ ?> selected="selected" <? } ?> >(UTC+06:00) Astana</option>
                                    <option value="Bangladesh Standard Time" <? if($getSiteDetails['time_zone']=="Bangladesh Standard Time"){ ?> selected="selected" <? } ?> >(UTC+06:00) Dhaka</option>
                                    <option value="N. Central Asia Standard Time" <? if($getSiteDetails['time_zone']=="N. Central Asia Standard Time"){ ?> selected="selected" <? } ?> >(UTC+06:00) Novosibirsk (RTZ 5)</option>
                                    <option value="Myanmar Standard Time" <? if($getSiteDetails['time_zone']=="Myanmar Standard Time"){ ?> selected="selected" <? } ?> >(UTC+06:30) Yangon (Rangoon)</option>
                                    <option value="SE Asia Standard Time" <? if($getSiteDetails['time_zone']=="SE Asia Standard Time"){ ?> selected="selected" <? } ?> >(UTC+07:00) Bangkok, Hanoi, Jakarta</option>
                                    <option value="North Asia Standard Time" <? if($getSiteDetails['time_zone']=="North Asia Standard Time"){ ?> selected="selected" <? } ?> >(UTC+07:00) Krasnoyarsk (RTZ 6)</option>
                                    <option value="China Standard Time" <? if($getSiteDetails['time_zone']=="China Standard Time"){ ?> selected="selected" <? } ?> >(UTC+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                                    <option value="North Asia East Standard Time" <? if($getSiteDetails['time_zone']=="North Asia East Standard Time"){ ?> selected="selected" <? } ?> >(UTC+08:00) Irkutsk (RTZ 7)</option>
                                    <option value="Singapore Standard Time" <? if($getSiteDetails['time_zone']=="Singapore Standard Time"){ ?> selected="selected" <? } ?> >(UTC+08:00) Kuala Lumpur, Singapore</option>
                                    <option value="W. Australia Standard Time" <? if($getSiteDetails['time_zone']=="W. Australia Standard Time"){ ?> selected="selected" <? } ?> >(UTC+08:00) Perth</option>
                                    <option value="Taipei Standard Time" <? if($getSiteDetails['time_zone']=="Taipei Standard Time"){ ?> selected="selected" <? } ?> >(UTC+08:00) Taipei</option>
                                    <option value="Ulaanbaatar Standard Time" <? if($getSiteDetails['time_zone']=="Ulaanbaatar Standard Time"){ ?> selected="selected" <? } ?> >(UTC+08:00) Ulaanbaatar</option>
                                    <option value="Tokyo Standard Time" <? if($getSiteDetails['time_zone']=="Tokyo Standard Time"){ ?> selected="selected" <? } ?> >(UTC+09:00) Osaka, Sapporo, Tokyo</option>
                                    <option value="Korea Standard Time" <? if($getSiteDetails['time_zone']=="Korea Standard Time"){ ?> selected="selected" <? } ?> >(UTC+09:00) Seoul</option>
                                    <option value="Yakutsk Standard Time" <? if($getSiteDetails['time_zone']=="Yakutsk Standard Time"){ ?> selected="selected" <? } ?> >(UTC+09:00) Yakutsk (RTZ 8)</option>
                                    <option value="Cen. Australia Standard Time" <? if($getSiteDetails['time_zone']=="Cen. Australia Standard Time"){ ?> selected="selected" <? } ?> >(UTC+09:30) Adelaide</option>
                                    <option value="AUS Central Standard Time" <? if($getSiteDetails['time_zone']=="AUS Central Standard Time"){ ?> selected="selected" <? } ?> >(UTC+09:30) Darwin</option>
                                    <option value="E. Australia Standard Time" <? if($getSiteDetails['time_zone']=="E. Australia Standard Time"){ ?> selected="selected" <? } ?> >(UTC+10:00) Brisbane</option>
                                    <option value="AUS Eastern Standard Time" <? if($getSiteDetails['time_zone']=="AUS Eastern Standard Time"){ ?> selected="selected" <? } ?> >(UTC+10:00) Canberra, Melbourne, Sydney</option>
                                    <option value="West Pacific Standard Time" <? if($getSiteDetails['time_zone']=="West Pacific Standard Time"){ ?> selected="selected" <? } ?> >(UTC+10:00) Guam, Port Moresby</option>
                                    <option value="Tasmania Standard Time" <? if($getSiteDetails['time_zone']=="Tasmania Standard Time"){ ?> selected="selected" <? } ?> >(UTC+10:00) Hobart</option>
                                    <option value="Magadan Standard Time" <? if($getSiteDetails['time_zone']=="Magadan Standard Time"){ ?> selected="selected" <? } ?> >(UTC+10:00) Magadan</option>
                                    <option value="Vladivostok Standard Time" <? if($getSiteDetails['time_zone']=="Vladivostok Standard Time"){ ?> selected="selected" <? } ?> >(UTC+10:00) Vladivostok, Magadan (RTZ 9)</option>
                                    <option value="Russia Time Zone 10" <? if($getSiteDetails['time_zone']=="Russia Time Zone 10"){ ?> selected="selected" <? } ?> >(UTC+11:00) Chokurdakh (RTZ 10)</option>
                                    <option value="Central Pacific Standard Time" <? if($getSiteDetails['time_zone']=="Central Pacific Standard Time"){ ?> selected="selected" <? } ?> >(UTC+11:00) Solomon Is., New Caledonia</option>
                                    <option value="Russia Time Zone 11" <? if($getSiteDetails['time_zone']=="Russia Time Zone 11"){ ?> selected="selected" <? } ?> >(UTC+12:00) Anadyr, Petropavlovsk-Kamchatsky (RTZ 11)</option>
                                    <option value="New Zealand Standard Time" <? if($getSiteDetails['time_zone']=="New Zealand Standard Time"){ ?> selected="selected" <? } ?> >(UTC+12:00) Auckland, Wellington</option>
                                    <option value="UTC+12" <? if($getSiteDetails['time_zone']=="UTC+12"){ ?> selected="selected" <? } ?> >(UTC+12:00) Coordinated Universal Time+12</option>
                                    <option value="Fiji Standard Time" <? if($getSiteDetails['time_zone']=="Fiji Standard Time"){ ?> selected="selected" <? } ?> >(UTC+12:00) Fiji</option>
                                    <option value="Kamchatka Standard Time" <? if($getSiteDetails['time_zone']=="Kamchatka Standard Time"){ ?> selected="selected" <? } ?> >(UTC+12:00) Petropavlovsk-Kamchatsky - Old</option>
                                    <option value="Tonga Standard Time" <? if($getSiteDetails['time_zone']=="Tonga Standard Time"){ ?> selected="selected" <? } ?> >(UTC+13:00) Nuku'alofa</option>
                                    <option value="Samoa Standard Time" <? if($getSiteDetails['time_zone']=="Samoa Standard Time"){ ?> selected="selected" <? } ?> >(UTC+13:00) Samoa</option>
                                    <option value="Line Islands Standard Time" <? if($getSiteDetails['time_zone']=="Line Islands Standard Time"){ ?> selected="selected" <? } ?> >(UTC+14:00) Kiritimati Island</option>
                                  </select></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Max Charge</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="max_charge"  value="<?=$getSiteDetails['max_charge'];?>"></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Site Id</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="site_id" value="<?=$getSiteDetails['site_id'];?>"></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Contact Name</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="contact_name" value="<?=$getSiteDetails['contact_name'];?>"></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Contact Phone</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="contact_phone" value="<?=$getSiteDetails['contact_phone'];?>"></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Billing Term</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><select name="billing_term" id="billing_term">
                                    <option selected="selected" value="PRE">Pre-paid</option>
                                    <option value="N10" <? if($getSiteDetails['billing_address']=="N10"){ ?> selected <? } ?>>Net 10</option>
                                    <option value="N15" <? if($getSiteDetails['billing_address']=="N15"){ ?> selected <? } ?>>Net 15</option>
                                    <option value="N30" <? if($getSiteDetails['billing_address']=="N30"){ ?> selected <? } ?>>Net 30</option>
                                    <option value="N45" <? if($getSiteDetails['billing_address']=="N45"){ ?> selected <? } ?>>Net 45</option>
                                    <option value="N60" <? if($getSiteDetails['billing_address']=="N60"){ ?> selected <? } ?>>Net 60</option>
                                  </select></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Billing Address</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><textarea name="billing_address"><?=$getSiteDetails['billing_address'];?></textarea></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Shipping Address</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><textarea name="shipping_address"><?=$getSiteDetails['shipping_address'];?></textarea></td>
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
