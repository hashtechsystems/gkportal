<?php
ob_start();

if($_REQUEST['btnSubmit'])
{
	$Error = 0;
	
	$Err_txtName = '';
	$Err_selCat = '';
	$Err_price = '';
	$Err_largeImage = '';
	
	$txtName = $_REQUEST['txtName'];
	$selCat = $_REQUEST['selCat'];	
	$description = $_REQUEST['description'];
	$strain_name = $_REQUEST['strain_name'];
	$price = $_REQUEST['price'];
	$gm = $_REQUEST['gm'];
	$ounce = $_REQUEST['ounce'];
	$thc = $_REQUEST['thc'];
	$row = $_REQUEST['row'];		
	$col = $_REQUEST['col'];	

	
	if($txtName == "")
	{
		$Error = 1;
		$Err_txtName = 'Please enter the name.';
	}

	if($selCat == "")
	{
		$Error = 1;
		$Err_selCat = 'Please select the category';
	}
	
		
	if($price == "")
	{
		$Error = 1;
		$Err_txtCalories = 'Please enter the product price.';
	}
	
	$largeProductImg = '';
		
	if(is_uploaded_file($_FILES['largeImg']['tmp_name']))
	{		
		$largeProductImg = "product_images/".$_SESSION['user_id']."_large_".trim($_FILES['largeImg']['name']);
		move_uploaded_file($_FILES['largeImg']['tmp_name'],$largeProductImg);		
	}
	
	if(is_uploaded_file($_FILES['smallImg']['tmp_name']))
	{		
		$smallProductImg = "product_images/".$_SESSION['user_id']."_small_".trim($_FILES['smallImg']['name']);
		move_uploaded_file($_FILES['smallImg']['tmp_name'],$smallProductImg);		
	}
		  
	if($Error == 0)
	{
		$DateAdded = date("Y-m-d H:i:s");
		$INSERT_PRODUCT = mysql_query("INSERT INTO `tbl_products` (`customer_id`, `product_name`, `product_category`, `description`, `strain_name`, `price`, `gm`, `ounce`, `thc`, `product_img`, `product_small_img`, `date_added`, `isDeleted`,`row`,`col`) VALUES ('".$_SESSION['user_id']."', '".mysql_real_escape_string($txtName)."', '".mysql_real_escape_string($selCat)."', '".mysql_real_escape_string($description)."', '".mysql_real_escape_string($strain_name)."', '".mysql_real_escape_string($price)."', '".mysql_real_escape_string($gm)."', '".mysql_real_escape_string($ounce)."', '".mysql_real_escape_string($thc)."', '".mysql_real_escape_string($largeProductImg)."', '".mysql_real_escape_string($smallProductImg)."', '".mysql_real_escape_string($DateAdded)."', 0,'".$row."','".$col."')");
		
		$productId=mysql_insert_id();
		#Update Planogram
		$customerId=$_SESSION['user_id'];
		$getTerminalId=mysql_fetch_array(mysql_query("SELECT id FROM `tbl_terminal` WHERE `customer_id`='".$customerId."'"));
		$terminalId=$getTerminalId['id'];		
		$location=$_REQUEST['row']."_".$_REQUEST['col'];
		
		$check=mysql_query("SELECT * FROM `tbl_planogram` WHERE `terminal_id`='".$terminalId."' AND product_id='".$productId."'");
		$num=mysql_num_rows($check);
		if($num>0)
		{			
			mysql_query("UPDATE `tbl_planogram` SET `location`='".$location."' WHERE `terminal_id`='".$terminalId."' AND product_id='".$productId."'");
		}
		else
		{
			mysql_query("INSERT INTO `tbl_planogram` (`terminal_id`,`product_id`,`location`,`product_name`)VALUES('".$terminalId."','".$productId."','".$location."','".mysql_real_escape_string($txtName)."')");
		}	
		
	echo "<script> document.location.href='index.php?action=product_list&a=1'</script>";		
	}

}

?>

<div class="page-header" style="margin-top:20px;">
  <h1> Add Product</h1>
</div>
<div class="container" id="container">
  <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="bo02">
    <tr>
      <td class="des-bg2" ><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bo3">
          <tr>
            <td valign="top" bgcolor=""><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td valign="top"><form action="" name="kiosk"  method="post" enctype="multipart/form-data">
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
                        
                        <tr>
                          <td colspan="3" height="40"><strong>Product General Details</strong></td>
                        </tr>
                        <tr>
                          <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="left" class="text">
                              <tr>
                                <td align="left" class="form-t">Name</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="txtName" name="txtName" placeholder="Name">
                                  &nbsp;
                                  <?php if(isset($Err_txtName) && $Err_txtName != "") { echo "<span style='color: #ff0000;'>".$Err_txtName."</span>";}?></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Product Category </td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><select name="selCat">
                                    <option value="select"> -- SELECT -- </option>
                                    <option value="Flower">Flower</option>
                                    <option value="Edible">Edible</option>
                                    <option value="Topical">Topical</option>
                                    <option value="Pre-roll">Pre-roll</option>
                                    <option value="Cartridge">Cartridge</option>
                                    <option value="Meal">Meal</option>
                                    <option value="Concentrate">Concentrate</option>
                                    <option value="Other">Other</option>
                                  </select>&nbsp;
                                  <?php if(isset($Err_selCat) && $Err_selCat != "") { echo "<span style='color: #ff0000;'>".$Err_selCat."</span>";}?></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Description </td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><textarea name="description" rows="5" cols="10" style="width:200px;" ></textarea></td>
                              </tr>
							  <tr>
                                <td align="left" class="form-t">Row</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="row" value="<?=$row;?>">
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Col</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="col" value="<?=$col;?>">
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Strain Name </td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><select name="strain_name">
                                    <option value=""> -- SELECT -- </option>
                                    <option value="SATIVA">SATIVA</option>
                                    <option value="INDICA">INDICA</option>
                                    <option value="HYBRID">HYBRID</option>
                                    <option value="CBD">CBD</option>
                                  </select>&nbsp;
                                </td>
                              </tr>                       
                              
                              <tr>
                                <td align="left" class="form-t">Price </td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" class="box" id="price" name="price" size="5"> <?php if(isset($Err_price) && $Err_price != "") { echo "<span style='color: #ff0000;'>".$Err_price."</span>";}?></td>
                              </tr>
                              
                              <tr>
                                <td align="left" class="form-t">GM </td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="gm" name="gm"></td>
                              </tr>
                              
                              <tr>
                                <td align="left" class="form-t">Ounce</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="ounce" name="ounce"></td>
                              </tr>
                              
                              <tr>
                                <td align="left" class="form-t">THC </td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="thc" name="thc"></td>
                              </tr>
                             
                              
                              <tr>
                                <td align="left" valign="top" class="form-t">Product Large Image</td>
                                <td width="20" valign="top">:</td>
                                <td height="40" class="textbox-bg2" align="left"><div class="col-md-2"  style="width:13%">
                                    <input type="file" id="largeImg" name="largeImg">                                    
                                  </div>
                              </tr>
                              
                              <tr>
                                <td align="left" valign="top" class="form-t">Product Small Image</td>
                                <td width="20" valign="top">:</td>
                                <td height="40" class="textbox-bg2" align="left"><div class="col-md-2"  style="width:13%">
                                    <input type="file" id="smallImg" name="smallImg">                                    
                                  </div>
                              </tr>
                              
                              
                              <tr align="left">
                                <td height="35" colspan="">&nbsp;</td>
                                <td width="20"></td>
                                <td height="40" colspan=""><input id="cmdCheck" name="btnSubmit" value="Add" type="submit" class="button"/>
                                  &nbsp;&nbsp;<a href="index.php?action=product_list" >
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
