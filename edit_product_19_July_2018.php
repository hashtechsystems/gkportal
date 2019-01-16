<?php
ob_start();
$query=mysql_query("SELECT * FROM `tbl_products` WHERE product_id = ".$_REQUEST['id']);
$dataP=mysql_fetch_array($query);

$pid = $dataP['product_id'];
$txtName = $dataP['product_name'];
$selCat = $dataP['product_category'];	
$description = $dataP['description'];
$strain_name = $dataP['strain_name'];
$price = $dataP['price'];
$gm = $dataP['gm'];
$ounce = $dataP['ounce'];
$thc = $dataP['thc'];
$largeProductImg = $dataP['product_img'];		
$smallProductImg = $dataP['product_small_img'];	

if($_REQUEST['btnSubmit'])
{
	$Error = 0;
	
	$Err_txtName = '';
	$Err_selCat = '';
	$Err_price = '';
	$Err_largeImage = '';
	
	$pid = $_REQUEST['pid'];
	$largeProductImg = $_REQUEST['oldImg'];
	$smallProductImg = $_REQUEST['oldSImg'];	
	$txtName = $_REQUEST['txtName'];
	$selCat = $_REQUEST['selCat'];	
	$description = $_REQUEST['description'];
	$strain_name = $_REQUEST['strain_name'];
	$price = $_REQUEST['price'];
	$gm = $_REQUEST['gm'];
	$ounce = $_REQUEST['ounce'];
	$thc = $_REQUEST['thc'];
	
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
		$UPDATE_PRODUCT = mysql_query("UPDATE `tbl_products` SET `product_name` = '".mysql_real_escape_string($txtName)."', `product_category` = '".mysql_real_escape_string($selCat)."', `description` = '".mysql_real_escape_string($description)."', `strain_name` = '".mysql_real_escape_string($strain_name)."', `price` = '".mysql_real_escape_string($price)."', `gm` = '".mysql_real_escape_string($gm)."', `ounce` = '".mysql_real_escape_string($ounce)."', `thc` = '".mysql_real_escape_string($thc)."', `product_img` = '".mysql_real_escape_string($largeProductImg)."', `product_small_img` ='".mysql_real_escape_string($smallProductImg)."' WHERE product_id = ".$pid);
		
		echo "<script> document.location.href='index.php?action=product_list&a=1'</script>";		
	}
}

?>

<div class="page-header" style="margin-top:20px;">
  <h1> Update Product</h1>
</div>
<div class="container" id="container">
  <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="bo02">
    <tr>
      <td class="des-bg2" ><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bo3">
          <tr>
            <td valign="top" bgcolor=""><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td valign="top"><form action="" name="kiosk"  method="post" enctype="multipart/form-data">
                  <input type="hidden" name="pid" value="<?=$pid?>" />
                  <input type="hidden" name="oldImg" value="<?=$largeProductImg?>" />
                  <input type="hidden" name="oldSImg" value="<?=$smallProductImg?>" />
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
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="txtName" name="txtName" placeholder="Name" value="<?=$txtName;?>">
                                  &nbsp;
                                  <?php if(isset($Err_txtName) && $Err_txtName != "") { echo "<span style='color: #ff0000;'>".$Err_txtName."</span>";}?></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Product Category </td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><select name="selCat">
                                    <option value="select"> -- SELECT -- </option>
                                    <option value="Flower" <?php if($selCat == "Flower") { echo "SELECTED";}?>>Flower</option>
                                    <option value="Edible" <?php if($selCat == "Edible") { echo "SELECTED";}?>>Edible</option>
                                    <option value="Topical" <?php if($selCat == "Topical") { echo "SELECTED";}?>>Topical</option>
                                    <option value="Pre-roll" <?php if($selCat == "Pre-roll") { echo "SELECTED";}?>>Pre-roll</option>
                                    <option value="Cartridge" <?php if($selCat == "Cartridge") { echo "SELECTED";}?>>Cartridge</option>
                                    <option value="Meal" <?php if($selCat == "Meal") { echo "SELECTED";}?>>Meal</option>
                                    <option value="Concentrate" <?php if($selCat == "Concentrate") { echo "SELECTED";}?>>Concentrate</option>
                                    <option value="Other" <?php if($selCat == "Other") { echo "SELECTED";}?>>Other</option>
                                  </select>&nbsp;
                                  <?php if(isset($Err_selCat) && $Err_selCat != "") { echo "<span style='color: #ff0000;'>".$Err_selCat."</span>";}?></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Description </td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><textarea name="description" rows="5" cols="10" style="width:200px;" > <?=$description;?></textarea></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Strain Name </td>
                                <td width="20">:</td>
								<td height="40" class="textbox-bg2" align="left"><select name="strain_name">
                                    <option value=""> -- SELECT -- </option>
                                    <option value="SATIVA" <?php if($strain_name == "SATIVA") { echo "SELECTED";}?>>SATIVA</option>
                                    <option value="INDICA" <?php if($strain_name == "INDICA") { echo "SELECTED";}?>>INDICA</option>
                                    <option value="HYBRID" <?php if($strain_name == "HYBRID") { echo "SELECTED";}?>>HYBRID</option>
                                    <option value="CBD" <?php if($strain_name == "CBD") { echo "SELECTED";}?>>CBD</option>
                                  </select>&nbsp;
                                </td>
                              </tr>                       
                              
                              <tr>
                                <td align="left" class="form-t">Price </td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" class="box" id="price" name="price"  value="<?=$price;?>"> <?php if(isset($Err_price) && $Err_price != "") { echo "<span style='color: #ff0000;'>".$Err_price."</span>";}?></td>
                              </tr>
                              
                              <tr>
                                <td align="left" class="form-t">GM </td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="gm" name="gm" value="<?=$gm;?>"></td>
                              </tr>
                              
                              <tr>
                                <td align="left" class="form-t">Ounce</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="ounce" name="ounce" value="<?=$ounce;?>"></td>
                              </tr>
                              
                              <tr>
                                <td align="left" class="form-t">THC </td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="thc" name="thc" value="<?=$thc;?>"></td>
                              </tr>
                             
                              
                              <tr>
                                <td align="left" valign="top" class="form-t">Product Large Image</td>
                                <td width="20" valign="top">:</td>
                                <td height="40" class="textbox-bg2" align="left"><div class="col-md-2"  style="width:13%">
                                    <input type="file" id="largeImg" name="largeImg">                                    
                                  </div>
                                  <?php
								  if( $largeProductImg!=""){ ?> <br /><img src="<?php echo $largeProductImg;?>" height="50" /> <? } 
								  ?>
                              </tr>
                              
                              <tr>
                                <td align="left" valign="top" class="form-t">Product Small Image</td>
                                <td width="20" valign="top">:</td>
                                <td height="40" class="textbox-bg2" align="left"><div class="col-md-2"  style="width:13%">
                                    <input type="file" id="smallImg" name="smallImg">                                    
                                  </div>
                                  <?php
								  if( $smallProductImg!=""){ ?> <br /><img src="<?php echo $smallProductImg;?>" height="50" /> <? } 
								  ?>
                              </tr>
                              
                              
                              <tr align="left">
                                <td height="35" colspan="">&nbsp;</td>
                                <td width="20"></td>
                                <td height="40" colspan=""><input id="cmdCheck" name="btnSubmit" value="Update" type="submit" class="button"/>
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
