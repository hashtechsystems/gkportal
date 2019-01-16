<?
ob_start();
$ServerPath = 'http://hashtech.us/grasshopper_admin/';
if($_REQUEST['btnSubmit'])
{
	$Error = 0;
	
	$Err_txtName = '';
	$Err_txtSKU = '';
	$Err_selProdType = '';
	$Err_txtCalories = '';
	$Err_txtServing = '';
	$Err_showCombo = '';
	$Err_smallImage = '';
	$Err_largeImage = '';
	$Err_shelfImage = '';
	$Err_nutritionImage = '';
	
	$txtName = $_REQUEST['txtName'];
	$txtSKU = $_REQUEST['txtSKU'];
	$selProdType = $_REQUEST['selProdType'];
	
	$txtPickerDesc = $_REQUEST['txtPickerDesc'];
	$txtFullDesc = $_REQUEST['txtFullDesc'];
	$txtCalories = $_REQUEST['txtCalories'];
	$txtServing = $_REQUEST['txtServing'];
	$txtTotalCal = $_REQUEST['txtTotalCal'];
	$txtOrder = $_REQUEST['txtOrder'];
	//$showCombo = $_REQUEST['showCombo'];
	
	if($txtName == "")
	{
		$Error = 1;
		$Err_txtName = 'Please enter the name.';
	}
#	exit();
	if($txtSKU == "")
	{
		$Error = 1;
		$Err_txtSKU = 'Please enter the product id / sku.';
	}
	
	if($selProdType == "select")
	{
		$Error = 1;
		$Err_selProdType = 'Please select the product type.';
	}
	
	/*if($txtCalories == "")
	{
		$Error = 1;
		$Err_txtCalories = 'Please enter the calories value.';
	}
	
	if($txtServing == "")
	{
		$Error = 1;
		$Err_txtServing = 'Please enter the serving value.';
	}
	
	if(isset($_REQUEST['showCombo']))
	{
		$showCombo = $_REQUEST['showCombo'];
	}
	else
	{
		$Error = 1;
		$Err_showCombo = 'Please select the show type.';
	}*/
	
	$FilePrefix = $txtSKU."_".date('Ymdhis');
	
	$smallProductImg = '';
	$largeProductImg = '';
	$shelfProductImg = '';
	$nutritionProductImg = '';	
	
	if(is_uploaded_file($_FILES['smallImg']['tmp_name']))
	{
		if($_FILES['smallImg']["type"] == "image/png")
		{
			$smallProductImg = "prod_img/".$FilePrefix."_small_".$_FILES['smallImg']['name'];
			
			$INSERT_PRODUCT = mysql_query("UPDATE `tbl_products` SET `product_small_img`='".mysql_real_escape_string($smallProductImg)."' WHERE `product_id`='".$_REQUEST['id']."'");
			
			move_uploaded_file($_FILES['smallImg']['tmp_name'],$smallProductImg);
		}
		else
		{
			$Error = 1;
			$Err_smallImage = "This file format is not allowed";
		}
	}
	
	if(is_uploaded_file($_FILES['largeImg']['tmp_name']))
	{		
		if($_FILES['largeImg']["type"] == "image/png")
		{
			$largeProductImg = "prod_img/".$FilePrefix."_large_".$_FILES['largeImg']['name'];
			$INSERT_PRODUCT = mysql_query("UPDATE `tbl_products` SET `product_large_img`='".mysql_real_escape_string($largeProductImg)."' WHERE `product_id`='".$_REQUEST['id']."'");
			move_uploaded_file($_FILES['largeImg']['tmp_name'],$largeProductImg);
		}
		else
		{
			$Error = 1;
			$Err_largeImage = "This file format is not allowed";
		}

	}
	
	if(is_uploaded_file($_FILES['shelfImg']['tmp_name']))
	{
		if($_FILES['shelfImg']["type"] == "image/png")
		{
			$shelfProductImg = "prod_img/".$FilePrefix."_shelf_".$_FILES['shelfImg']['name'];
			$INSERT_PRODUCT = mysql_query("UPDATE `tbl_products` SET `shelf_img`='".mysql_real_escape_string($shelfProductImg)."' WHERE `product_id`='".$_REQUEST['id']."'");
			move_uploaded_file($_FILES['shelfImg']['tmp_name'],$shelfProductImg);
		}
		else
		{
			$Error = 1;
			$Err_shelfImage = "This file format is not allowed";
		}

	}
	
	if(is_uploaded_file($_FILES['nutriImg']['tmp_name']))
	{
		
		if($_FILES['nutriImg']["type"] == "image/png")
		{
			$nutritionProductImg = "prod_img/".$FilePrefix."_nutrition_".$_FILES['nutriImg']['name'];
			$INSERT_PRODUCT = mysql_query("UPDATE `tbl_products` SET `nutrition_img`='".mysql_real_escape_string($nutritionProductImg)."' WHERE `product_id`='".$_REQUEST['id']."'");
			move_uploaded_file($_FILES['nutriImg']['tmp_name'],$nutritionProductImg);
		}
		else
		{
			$Error = 1;
			$Err_nutritionImage = "This file format is not allowed";
		}
	}
	
	  
	if($Error == 0)
	{
		$DateAdded = date("Y-m-d H:i:s");
		
		$INSERT_PRODUCT = mysql_query("UPDATE `tbl_products` SET `product_sku`='".mysql_real_escape_string($txtSKU)."', `product_name`='".mysql_real_escape_string($txtName)."', `product_type`='".mysql_real_escape_string($selProdType)."', `meal_comp_desc`='".mysql_real_escape_string($txtPickerDesc)."', `full_desc`='".mysql_real_escape_string($txtFullDesc)."', `product_calories`='".mysql_real_escape_string($txtCalories)."', `product_servings`='".mysql_real_escape_string($txtServing)."', `total_calories`='".mysql_real_escape_string($txtTotalCal)."', `product_order`='".mysql_real_escape_string($txtOrder)."', `show_in_combo`='".mysql_real_escape_string($showCombo)."',`manufacturer`='".$_REQUEST['manufacturer']."',`size_1`='".$_REQUEST['size_1']."',`size_2`='".$_REQUEST['size_2']."',`size_3`='".$_REQUEST['size_3']."',`product_price`='".$_REQUEST['price']."',`cost`='".$_REQUEST['cost']."',`brand`='".$_REQUEST['brand']."',`group_id`='".$_REQUEST['group_id']."',`upc`='".$_REQUEST['upc']."',`nutrition`='".$_REQUEST['nutrition']."',`dispense_size`='".$_REQUEST['dispense_size']."' WHERE `product_id`='".$_REQUEST['id']."'");
		/*$mailHTML = '<div>
		<div class="" style="margin-top:0;width:100%;padding:1%; font-family:arial;	background:#86a2c5;font-size:20px;color:#fff;margin-top:30px;"> Product General Details</div>
<table width="100%" border="0" cellspacing="0" cellpadding="10" style="font-family:arial;">
 <tr>
   <td width="260" style="color:#8A8A8A; border-bottom:solid 1px #ccc;">Name</td>
   <td width="10" style="border-bottom:solid 1px #ccc;">:</td>
   <td style="border-bottom:solid 1px #ccc;">'.$txtName.'</td>
 </tr>
 <tr>
   <td style="color:#8A8A8A; border-bottom:solid 1px #ccc;">SKU / Product Id</td>
   <td style="border-bottom:solid 1px #ccc;">:</td>
   <td style="border-bottom:solid 1px #ccc;">'.$txtSKU.'</td>
 </tr>
 <tr>
   <td style="color:#8A8A8A; border-bottom:solid 1px #ccc;">Product Type</td>
   <td style="border-bottom:solid 1px #ccc;">:</td>
   <td style="border-bottom:solid 1px #ccc;">'.$selProdType.'</td>
 </tr>
</table>

<div class="" style="margin-top:0;width:100%;padding:1%; font-family:arial;	background:#86a2c5;font-size:20px;color:#fff;margin-top:30px;"> Product Info</div>
<table width="100%" border="0" cellspacing="0" cellpadding="10" style="font-family:arial;">
 <tr>
   <td width="260" style="color:#8A8A8A; border-bottom:solid 1px #ccc;">Meal Component Picker Desc</td>
   <td width="10" style="border-bottom:solid 1px #ccc;">:</td>
   <td style="border-bottom:solid 1px #ccc;">'.$txtPickerDesc.'</td>
 </tr>
 <tr>
   <td style="color:#8A8A8A; border-bottom:solid 1px #ccc;">Full Description</td>
   <td style="border-bottom:solid 1px #ccc;">:</td>
   <td style="border-bottom:solid 1px #ccc;">'.$txtFullDesc.'</td>
 </tr>
 <tr>
   <td style="color:#8A8A8A; border-bottom:solid 1px #ccc;">Calories</td>
   <td style="border-bottom:solid 1px #ccc;">:</td>
   <td style="border-bottom:solid 1px #ccc;">'.$txtCalories.'</td>
 </tr>
  <tr>
   <td style="color:#8A8A8A; border-bottom:solid 1px #ccc;">Servings</td>
   <td style="border-bottom:solid 1px #ccc;">:</td>
   <td style="border-bottom:solid 1px #ccc;">'.$txtServing.'</td>
 </tr>
  <tr>
   <td style="color:#8A8A8A; border-bottom:solid 1px #ccc;">Total Calories</td>
   <td style="border-bottom:solid 1px #ccc;">:</td>
   <td style="border-bottom:solid 1px #ccc;">'.$txtTotalCal.'</td>
 </tr>
  <tr>
   <td style="color:#8A8A8A; border-bottom:solid 1px #ccc;">Order</td>
   <td style="border-bottom:solid 1px #ccc;">:</td>
   <td style="border-bottom:solid 1px #ccc;">'.$txtOrder.'</td>
 </tr>
  <tr>
   <td style="color:#8A8A8A; border-bottom:solid 1px #ccc;">Only Show In Combos</td>
   <td style="border-bottom:solid 1px #ccc;">:</td>
   <td style="border-bottom:solid 1px #ccc;">'.$showCombo.'</td>
 </tr>
</table>

<div class="" style="margin-top:0;width:100%;padding:1%; font-family:arial;	background:#86a2c5;font-size:20px;color:#fff;margin-top:30px;"> Product Images</div>
<table width="100%" border="0" cellspacing="0" cellpadding="10" style="font-family:arial;">
 <tr>
   <td width="260" style="color:#8A8A8A; border-bottom:solid 1px #ccc;">Product Small Image</td>
   <td width="10" style="border-bottom:solid 1px #ccc;">:</td>
   <td style="border-bottom:solid 1px #ccc;">';
   if($smallProductImg == '')
   {
	   $mailHTML .= 'No Image Uploaded.';
   }
   else
   {
	   $mailHTML .= '<a href="'.$ServerPath.$smallProductImg.'" target="_blank">View Product Small Image</a>';
   }
   
   $mailHTML .= '</td>
 </tr>
 <tr>
   <td style="color:#8A8A8A; border-bottom:solid 1px #ccc;">Product Large Image</td>
   <td style="border-bottom:solid 1px #ccc;">:</td>
   <td style="border-bottom:solid 1px #ccc;">';
   if($largeProductImg == '')
   {
	   $mailHTML .= 'No Image Uploaded.';
   }
   else
   {
	   $mailHTML .= '<a href="'.$ServerPath.$largeProductImg.'" target="_blank">View Product Large Image</a>';
   }
   
   $mailHTML .= '</td>
 </tr>
 <tr>
   <td style="color:#8A8A8A; border-bottom:solid 1px #ccc;">Shelf Image</td>
   <td style="border-bottom:solid 1px #ccc;">:</td>
   <td style="border-bottom:solid 1px #ccc;">';
   if($shelfProductImg == '')
   {
	   $mailHTML .= 'No Image Uploaded.';
   }
   else
   {
	   $mailHTML .= '<a href="'.$ServerPath.$shelfProductImg.'" target="_blank">View Product Shelf Image</a>';
   }
   $mailHTML .= '</td>
 </tr>
 <tr>
   <td style="color:#8A8A8A; border-bottom:solid 1px #ccc;">Nutrition Image</td>
   <td style="border-bottom:solid 1px #ccc;">:</td>
   <td style="border-bottom:solid 1px #ccc;">';
   if($nutritionProductImg == '')
   {
	   $mailHTML .= 'No Image Uploaded.';
   }
   else
   {
	   $mailHTML .= '<a href="'.$ServerPath.$nutritionProductImg.'" target="_blank">View Product Nutrition Image</a>';
   }
   $mailHTML .= '</td>
 </tr>
</table>
</div>';*/
	/*$to = "karan@hashtech.com";		
	$subject = 'Add Product Info';
	$message = "Hi, <br /><br />New product data has been added in system.<br /><br /><br />";
	
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	
	// More headers
	$headers .= 'From: <info@hashtech.com>' . "\r\n";
	//$headers .= 'Cc: myboss@example.com' . "\r\n";
	
	mail($to,$subject,$message,$headers);	*/
	}
echo "<script> document.location.href='index.php?action=product_list&u=1'</script>";
}
#header("Location:index.php?action=product_list");

$getproductDetails=mysql_fetch_array(mysql_query("SELECT * FROM `tbl_products` WHERE `product_id`='".$_REQUEST['id']."'"));

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
                          <td colspan="3" height="40"><strong>Product General Details</strong></td>
                        </tr>
                        <tr>
                          <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="left" class="text">
                              <tr>
                                <td align="left" class="form-t">Name</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                <input type="hidden" name="id" value="<?=$getproductDetails['product_id'];?>">
                                <input type="text" id="txtName" name="txtName" placeholder="Name" value="<?=$getproductDetails['product_name'];?>">
                                  &nbsp;
                                  <?php if(isset($Err_txtName) && $Err_txtName != "") { echo "<span style='color: #ff0000;'>".$Err_txtName."</span>";}?></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">SKU/Item ID</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="txtSKU" name="txtSKU" placeholder="SKU / Product ID" value="<?=$getproductDetails['product_sku'];?>" >
                                  &nbsp;
                                  <?php if(isset($Err_txtSKU) && $Err_txtSKU != "") { echo "<span style='color: #ff0000;'>".$Err_txtSKU."</span>";}?></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Product Type </td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><select name="selProdType">
                                    <option value="select"> -- SELECT -- </option>
                                    <option value="Flower" <? if($getproductDetails['product_type']=="Flower"){ ?> selected <? } ?>>Flower</option>
                                    <option value="Edible" <? if($getproductDetails['product_type']=="Edible"){ ?> selected <? } ?>>Edible</option>
                                    <option value="Topical" <? if($getproductDetails['product_type']=="Topical"){ ?> selected <? } ?>>Topical</option>
                                    <option value="Pre-roll" <? if($getproductDetails['product_type']=="Pre-roll"){ ?> selected <? } ?>>Pre-roll</option>
                                    <option value="Cartridge" <? if($getproductDetails['product_type']=="Cartridge"){ ?> selected <? } ?>>Cartridge</option>
                                    <option value="Meal" <? if($getproductDetails['product_type']=="Meal"){ ?> selected <? } ?>>Meal</option>
                                    <option value="Concentrate" <? if($getproductDetails['product_type']=="Concentrate"){ ?> selected <? } ?>>Concentrate</option>
                                    <option value="Other" <? if($getproductDetails['product_type']=="Other"){ ?> selected <? } ?>>Other</option>
                                  </select></td>
                              </tr>
                              
                              <tr>
                                <td align="left" class="form-t">Manufacturer </td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input id="manufacturer" name="manufacturer" type="text" value="<?=$getproductDetails['manufacturer'];?>"></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Brand </td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input id="brand" name="brand" type="text" value="<?=$getproductDetails['brand'];?>"></td>
                              </tr>
                              
                              <tr>
                                <td align="left" class="form-t">Group </td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<select name="group">
                                    <?
										$getGroups=mysql_query("SELECT * FROM `tbl_groups`");
										while($getGroupDetails=mysql_fetch_array($getGroups))
										{
											?>
                                    	<option value="<?=$getGroupDetails['id'];?>"><?=$getGroupDetails['name'];?></option>
                                        <?
										}
										?>
                                    </select>
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Size </td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input id="size_1" name="size_1" type="text" class="box largerInput" value="<?=$getproductDetails['size_1'];?>">
                                  <select name="size_2" id="size_2" class="ddl">
                                    <option value="fl. oz." <? if($getproductDetails['size_2']=="fl. oz."){ ?> selected <? } ?>>fl. oz.</option>
                                    <option value="oz." <? if($getproductDetails['size_2']=="oz."){ ?> selected <? } ?>>oz.</option>
                                    <option value="g" <? if($getproductDetails['size_2']=="g"){ ?> selected <? } ?>>g</option>
                                    <option value="mL" <? if($getproductDetails['size_2']=="mL"){ ?> selected <? } ?>>mL</option>
                                    <option value="L" <? if($getproductDetails['size_2']=="L"){ ?> selected <? } ?>>L</option>
                                    <option value="lbs." <? if($getproductDetails['size_2']=="lbs."){ ?> selected <? } ?>>lbs.</option>
                                    <option value="kg" <? if($getproductDetails['size_2']=="kg"){ ?> selected <? } ?>>kg</option>
                                    <option value="cnt" <? if($getproductDetails['size_2']=="cnt"){ ?> selected <? } ?>>cnt</option>
                                    <option value="pk" <? if($getproductDetails['size_2']=="pk"){ ?> selected <? } ?>>pk</option>
                                  </select>
                                  <select name="size_3" id="size_3" class="ddl">
                                    <option value="ALL" <? if($getproductDetails['size_3']=="ALL"){ ?> selected <? } ?>>None</option>
                                    <option value="BOT" <? if($getproductDetails['size_3']=="BOT"){ ?> selected <? } ?>>Bottle</option>
                                    <option value="CAN" <? if($getproductDetails['size_3']=="CAN"){ ?> selected <? } ?>>Can</option>
                                  </select></td>
                              </tr>                              
                              
                              <tr>
                                <td align="left" class="form-t">Price </td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" class="box" id="price" name="price" size="5" value="<?=$getproductDetails['product_price'];?>"></td>
                              </tr>
                              
                              <tr>
                                <td align="left" class="form-t">Cost </td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="cost" name="cost" size="5" value="<?=$getproductDetails['cost'];?>"></td>
                              </tr>
                              
                              <tr>
                                <td align="left" class="form-t">UPC </td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="upc" name="upc" value="<?=$getproductDetails['upc'];?>"></td>
                              </tr>
                              
                              <tr>
                                <td align="left" class="form-t">Nutrition </td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="nutrition" name="nutrition" value="<?=$getproductDetails['nutrition'];?>"></td>
                              </tr>
                              
                              <tr>
                                <td align="left" class="form-t">Dispense Size </td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><!--<input type="text" id="dispense_size" name="dispense_size" value="<?=$getproductDetails['dispense_size'];?>">-->
                                
                                 <select name="dispense_size" id="dispense_size" class="ddl">
	<option <? if($getproductDetails['dispense_size']=="small"){ ?> selected="selected" <? } ?> value="small">Small</option>
	<option <? if($getproductDetails['dispense_size']=="Medium"){ ?> selected="selected" <? } ?> value="medium">Medium</option>
	<option <? if($getproductDetails['dispense_size']=="Large"){ ?> selected="selected" <? } ?> value="large">Large</option>

</select>
                                
                                </td>
                              </tr>
                              
                              
                              <tr>
                                <td colspan="3" height="40"><strong>Product Info</strong></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Meal Component Picker Desc</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="txtPickerDesc" name="txtPickerDesc" placeholder="Meal Component Picker Desc" value="<?=$getproductDetails['meal_comp_desc'];?>"></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Full Description</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><textarea id="txtFullDesc" name="txtFullDesc" placeholder="Full Description" ><?=$getproductDetails['full_desc'];?>
</textarea></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Calories</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="txtCalories" name="txtCalories" placeholder="Calories" value="<?=$getproductDetails['product_calories'];?>">
                                  &nbsp;
                                  <?php if(isset($Err_txtCalories) && $Err_txtCalories != "") { echo "<span style='color: #ff0000;'>".$Err_txtCalories."</span>";}?></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Servings</td>
                                <td width="20">:</td>
                                <td height="50" class="textbox-bg2" align="left"><input type="text" id="txtServing" name="txtServing" placeholder="Servings" value="<?=$getproductDetails['product_servings'];?>" >
                                  &nbsp;
                                  <?php if(isset($Err_txtServing) && $Err_txtServing != "") { echo "<span style='color: #ff0000;'>".$Err_txtServing."</span>";}?></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">&nbsp;Total Calories</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" id="txtTotalCal" name="txtTotalCal" placeholder="Total Calories" value="<?=$getproductDetails['total_calories'];?>"></td>
                              </tr>
                              <tr>
                                <td align="left" valign="top" class="form-t">Order</td>
                                <td width="20" valign="top">:</td>
                                <td height="40" class="textbox-bg2" align="left"><div class="col-md-2"  style="width:13%">
                                    <input type="text" id="txtOrder" name="txtOrder" placeholder="Order" value="<?=$getproductDetails['product_order'];?>" >
                                  </div>
                              </tr>
                              <tr>
                                <td align="left" valign="top" class="form-t">Only Show In Combos</td>
                                <td width="20" valign="top">:</td>
                                <td height="40" class="textbox-bg2" align="left"><div class="col-md-2"  style="width:13%">
                                    <input type="radio" style="width:20px; height:10px;" id="showYes" name="showCombo" value="Yes" <? if($getproductDetails['show_in_combo']=="Yes"){?> checked <? } ?>>
                                    Yes
                                    <input type="radio" style="width:20px; height:10px"  id="showNo" name="showCombo" value="No" <? if($getproductDetails['show_in_combo']=="No"){?> checked <? } ?>>
                                    No &nbsp;
                                    <?php if(isset($Err_showCombo) && $Err_showCombo != "") { echo "<span style='color: #ff0000;'>".$Err_showCombo."</span>";}?>
                                  </div>
                              </tr>
                              <tr>
                                <td colspan="3" height="40"><strong>Product Images</strong></td>
                              </tr>
                              <tr>
                                <td align="left" valign="top" class="form-t">Small Product Image</td>
                                <td width="20" valign="top">:</td>
                                <td height="40" class="textbox-bg2" align="left"><div class="col-md-2"  style="width:13%">
                                    <input type="file" id="smallImg" name="smallImg">
                                    &nbsp;
                                    <?php if(isset($Err_smallImage) && $Err_smallImage != "") { echo "<span style='color: #ff0000;'>".$Err_smallImage."</span>";}?>
                                  </div>
                                  <img src="<?=$getproductDetails['product_small_img'];?>" width="100">
                              </tr>
                              <tr>
                                <td colspan="3">Required Image Size : 191 x 163 , Accept only .png file.</td>
                              </tr>
                              <tr>
                                <td align="left" valign="top" class="form-t">Large Product Image</td>
                                <td width="20" valign="top">:</td>
                                <td height="40" class="textbox-bg2" align="left"><div class="col-md-2"  style="width:13%">
                                    <input type="file" id="largeImg" name="largeImg">
                                    &nbsp;
                                    <?php if(isset($Err_largeImage) && $Err_largeImage != "") { echo "<span style='color: #ff0000;'>".$Err_largeImage."</span>";}?>
                                  </div>
                                  <img src="<?=$getproductDetails['product_large_img'];?>" width="100">
                              </tr>
                              <tr>
                                <td colspan="3">Required Image Size : 420 x 420 , Accept only .png file.</td>
                              </tr>
                              <tr>
                                <td align="left" valign="top" class="form-t">Shelf Image</td>
                                <td width="20" valign="top">:</td>
                                <td height="40" class="textbox-bg2" align="left"><div class="col-md-2"  style="width:13%">
                                    <input type="file" id="shelfImg" name="shelfImg">
                                    &nbsp;
                                    <?php if(isset($Err_shelfImage) && $Err_shelfImage != "") { echo "<span style='color: #ff0000;'>".$Err_shelfImage."</span>";}?>
                                  </div>
                                  <img src="<?=$getproductDetails['shelf_img'];?>" width="100">
                              </tr>
                              <tr>
                                <td colspan="3">Required Image Size : 205 x 235 , Accept only .png file.</td>
                              </tr>
                              <tr>
                                <td align="left" valign="top" class="form-t">Nutrition Image</td>
                                <td width="20" valign="top">:</td>
                                <td height="40" class="textbox-bg2" align="left"><div class="col-md-2"  style="width:13%">
                                    <input type="file" id="nutriImg" name="nutriImg">
                                    &nbsp;
                                    <?php if(isset($Err_nutritionImage) && $Err_nutritionImage != "") { echo "<span style='color: #ff0000;'>".$Err_nutritionImage."</span>";}?>
                                  </div>
                                  <img src="<?=$getproductDetails['nutrition_img'];?>" width="100">
                              </tr>
                              <tr>
                                <td colspan="3">Accept only .png file.</td>
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
