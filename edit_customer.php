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
	
		mysql_query("UPDATE `tbl_customers` SET `name`='".$_REQUEST['name']."',`username`='".$_REQUEST['username']."',`password`='".$_REQUEST['password']."',`city`='".$_REQUEST['city']."',`state`='".$_REQUEST['state']."',`zip`='".$_REQUEST['zip']."' WHERE id='".$_REQUEST['id']."'");
 	
		 mysql_query("UPDATE `tbl_terminal` SET `terminal_id`='".$_REQUEST['terminal_id']."',`Address`='".$_REQUEST['address']."',`location`='".$_REQUEST['location']."' WHERE customer_id='".$_REQUEST['id']."' AND terminal_id = '".$_REQUEST['terminal_id_o']."'");
		 
		echo "<script> document.location.href='index.php?action=customers_list'</script>";		
	}
}

$data=mysql_fetch_array(mysql_query("SELECT c.*,t.terminal_id,t.location,t.Address FROM `tbl_customers` c LEFT JOIN `tbl_terminal` t ON t.customer_id = c.id WHERE c.id='".$_REQUEST['id']."'"));
?>

<div class="page-header tbg2" style="margin-top:20px;">
  <div class="col-md-8">
  <h1> Edit Customer </h1>
  </div>
   <div class="col-md-4" style="text-align:right;"> <a href="index.php?action=customers_list" class="greenbtn1">Previous Page</a> </div>
</div>
<div>
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
                        <? if(isset($_REQUEST['s']))
					  {
						  ?>
                          <span style="color:#990000;padding-left:15px;"> Password updated successfully. </span>
                        <?
					  }
					  ?>
                       
                              <div class="w100">
							    <div class="col-md-12"> <label class="flebal"> Name </label></div>
                                <div class="col-md-12">
									<input type="hidden" name="id" value="<?=$data['id'];?>">
                                	<input type="text" class="textbox6" name="name" value="<?=$data['name'];?>">
                                </div>
                              </div>
							  
							  <div class="clearfix gap1"> </div>
							  <div class="w100">
							    <div class="col-md-12"> <label class="flebal"> Username </label></div>
                                <div class="col-md-12">
									<input type="text" class="textbox6" name="username" value="<?=$data['username'];?>">
                                </div>
                              </div>
							  
							  <div class="clearfix gap1"> </div>
							  <div class="w100">
							    <div class="col-md-12"> <label class="flebal"> Password </label></div>
                                <div class="col-md-12">
									<input type="text" class="textbox6" name="password" value="<?=$data['password'];?>">
                                </div>
                              </div>
							  
							  <div class="clearfix gap1"> </div>
							  <div class="w100">
							    <div class="col-md-12"> <label class="flebal"> City </label></div>
                                <div class="col-md-12">
									<input type="text" class="textbox6" name="city" value="<?=$data['city'];?>">
                                </div>
                              </div> 

							  <div class="clearfix gap1"> </div>
							  <div class="w100">
							    <div class="col-md-12"> <label class="flebal"> State </label></div>
                                <div class="col-md-12">
									<input type="text" class="textbox6" name="state" value="<?=$data['state'];?>">
                                </div>
                              </div>      
							  
							  <div class="clearfix gap1"> </div>
							  <div class="w100">
							    <div class="col-md-12"> <label class="flebal"> Zip </label></div>
                                <div class="col-md-12">
									<input type="text" class="textbox6" name="zip" value="<?=$data['zip'];?>">
                                </div>
                              </div>  
							  
							  <div class="clearfix gap1"> </div>
							  <div class="w100">
							    <div class="col-md-12"> <label class="flebal"> Terminal Id </label></div>
                                <div class="col-md-12">
									<input type="text" class="textbox6" name="terminal_id" value="<?=$data['terminal_id'];?>">
									<input type="hidden" name="terminal_id_o" value="<?=$data['terminal_id'];?>">
                                </div>
                              </div> 

								<div class="clearfix gap1"> </div>
								<div class="w100">
							    <div class="col-md-12"> <label class="flebal"> Location </label></div>
                                <div class="col-md-12">
									<input type="text"  class="textbox6" name="location" value="<?=$data['location'];?>">
                                </div>
                              </div>
							  
							  <div class="clearfix gap1"> </div>
							  <div class="w100">
							    <div class="col-md-12"> <label class="flebal"> Address </label></div>
                                <div class="col-md-12">
									<input type="text" class="textbox6" name="address" value="<?=$data['Address'];?>">
                                </div>
                              </div>  
							  <!--<tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;POS</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<select name="pos">
										<option value="None" <? if($data['pos_assigned']=="None"){ ?> selected="selected" <? } ?>>None</option>
										<option value="MJ Freeway" <? if($data['pos_assigned']=="MJ Freeway"){ ?> selected="selected" <? } ?>>MJ Freeway</option>
										<option value="Treez" <? if($data['pos_assigned']=="Treez"){ ?> selected="selected" <? } ?>>Treez</option>
										<option value="Baker" <? if($data['pos_assigned']=="Baker"){ ?> selected="selected" <? } ?>>Baker</option>
										<option value="GK" <? if($data['pos_assigned']=="GK"){ ?> selected="selected" <? } ?>>GK</option>
										<option value="COVA" <? if($data['pos_assigned']=="COVA"){ ?> selected="selected" <? } ?>>COVA</option>										
									</select>
                                </td>
                              </tr>-->   
							 <div class="clearfix gap1"> </div>
                              <div class="w100">
							    <div class="col-md-12">
								  <input id="cmdCheck" name="submit" value="Update" type="submit" class="greenbtn2"/>
                                  &nbsp;&nbsp;<a href="index.php?action=customers_list" >
                                  <input type="button" value="Cancel" class="greenbtn2"/>
                                  </a>
								</div>
                              </div>
    </div>              
    </form>
</div>
