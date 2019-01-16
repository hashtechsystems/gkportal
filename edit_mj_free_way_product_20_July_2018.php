<?
ob_start();
if($_REQUEST['submit'])
{
	$error = NULL;
	$name= $_REQUEST['name'];
		
	if($name == '')
		$error[] = "Please enter the name.";
		
	if(count($error) < 1)
	{
		mysql_query("UPDATE `mj_freeway_products` SET `name`='".$_REQUEST['name']."',`description`='".$_REQUEST['description']."',`category_name`='".$_REQUEST['category_name']."',`row`='".$_REQUEST['row']."',`col`='".$_REQUEST['col']."',`strain_name`='".$_REQUEST['strain_name']."',`default_price`='".$_REQUEST['default_price']."',`discount`='".$_REQUEST['discount']."',`gm`='".$_REQUEST['gm']."',`ounce`='".$_REQUEST['ounce']."',`thc`='".$_REQUEST['thc']."' WHERE id='".$_REQUEST['id']."'");	
		
		if($_FILES['orignal_image']['name']!="")
		{
			$imageName="mj_free_way-".$_REQUEST['id'].".png";
			move_uploaded_file($_FILES['orignal_image']['tmp_name'], "product_images/".$imageName);
			mysql_query("UPDATE `mj_freeway_products` SET `orignal_image`='".$imageName."' WHERE id='".$_REQUEST['id']."'");			
		}
		
		if($_FILES['small_image']['name']!="")
		{
			$imageName="mj_free_way-small-".$_REQUEST['id'].".png";
			move_uploaded_file($_FILES['small_image']['tmp_name'], "product_images/".$imageName);
			mysql_query("UPDATE `mj_freeway_products` SET `small_image`='".$imageName."' WHERE id='".$_REQUEST['id']."'");			
		}
		$customerId=$_SESSION['user_id'];
		$getTerminalId=mysql_fetch_array(mysql_query("SELECT id FROM `tbl_terminal` WHERE `customer_id`='".$customerId."'"));
		$terminalId=$getTerminalId['id'];
		#Update Planogram
		$location=$_REQUEST['row']."_".$_REQUEST['col'];
		$check=mysql_query("SELECT * FROM `tbl_planogram` WHERE `terminal_id`='".$terminalId."' AND product_id='".$_REQUEST['id']."'");
		$num=mysql_num_rows($check);
		if($num>0)
		{			
			mysql_query("UPDATE `tbl_planogram` SET `location`='".$location."' WHERE `terminal_id`='".$terminalId."' AND product_id='".$_REQUEST['id']."'");
		}
		else
		{
			mysql_query("INSERT INTO `tbl_planogram` (`terminal_id`,`product_id`,`location`)VALUES('".$terminalId."','".$_REQUEST['id']."','".$location."')");
		}		
		echo "<script> document.location.href='index.php?action=product_mj_freeway_list'</script>";		
	}
}

$data=mysql_fetch_array(mysql_query("SELECT * FROM `mj_freeway_products` WHERE `id`='".$_REQUEST['id']."'"));
?>

<div class="page-header" style="margin-top:20px;">
  <h1> Edit Product </h1>
</div>
<div class="container" id="container">
  <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="bo02">
    <tr>
      <td class="des-bg2" ><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bo3">
          <tr>
            <td valign="top" bgcolor=""><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td valign="top"><form action="" name="kiosk"  method="post"  enctype="multipart/form-data">
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
                                <td height="40" class="textbox-bg2" align="left"><input type="hidden" name="id" value="<?=$data['id'];?>">
                                  <input type="text" name="name" value="<?=$data['name'];?>">
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Row</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="row" value="<?=$data['row'];?>">
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Col</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="col" value="<?=$data['col'];?>">
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Category</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="category_name" value="<?=$data['category_name'];?>">
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Description</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><textarea name="description" ><?=$data['description'];?>
</textarea>
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Strain Name</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><select name="strain_name">
                                    <option value=""> -- SELECT -- </option>
                                    <option value="SATIVA" <?php if($data['strain_name'] == "SATIVA") { echo "SELECTED";}?>>SATIVA</option>
                                    <option value="INDICA" <?php if($data['strain_name'] == "INDICA") { echo "SELECTED";}?>>INDICA</option>
                                    <option value="HYBRID" <?php if($data['strain_name'] == "HYBRID") { echo "SELECTED";}?>>HYBRID</option>
                                    <option value="CBD" <?php if($data['strain_name'] == "CBD") { echo "SELECTED";}?>>CBD</option>
                                  </select>
                                  &nbsp; </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Product Price</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="default_price" value="<?=$data['default_price'];?>">
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Discount</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="discount" value="<?=$data['discount'];?>">
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Gm</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="gm" value="<?=$data['gm'];?>">
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Ounce</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="ounce" value="<?=$data['ounce'];?>">
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;THC</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="thc" value="<?=$data['thc'];?>">
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Image</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="file" name="orignal_image" />
                                  <? if($data['orignal_image']!="")
								{
								?>
                                  <img src="product_images/<?php echo $data['orignal_image'];?>" height="50" />
                                  <?
								 }
								 ?>
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Small Image</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="file" name="small_image" />
                                  <? if($data['small_image']!="")
								{
								?>
                                  <img src="product_images/<?php echo $data['small_image'];?>" height="50" />
                                  <?
								 }
								 ?>
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
