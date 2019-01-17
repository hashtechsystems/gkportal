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
$live_inventory_quantity = $dataP['live_inventory_quantity'];
$gm = $dataP['gm'];
$ounce = $dataP['ounce'];
$thc = $dataP['thc'];
$row = $dataP['row'];		
$col = $dataP['col'];
$featured = $dataP['featured'];
$new = $dataP['new'];
$popular = $dataP['popular'];
$largeProductImg_o = $dataP['product_img'];
$smallProductImg_o = $dataP['product_small_img'];

if($_REQUEST['btnSubmit'])
{
	$Error = 0;
	
	$Err_txtName = '';
	$Err_selCat = '';
	$Err_price = '';
	$Err_largeImage = '';
	
	$pid = $_REQUEST['pid'];
	$row = $_REQUEST['row'];
	$col = $_REQUEST['col'];
	$largeProductImg = $_REQUEST['oldImg'];
	$smallProductImg = $_REQUEST['oldSImg'];	
	$txtName = $_REQUEST['txtName'];
	$selCat = $_REQUEST['selCat'];	
	$description = $_REQUEST['description'];
	$strain_name = $_REQUEST['strain_name'];
	$price = $_REQUEST['price'];
	$live_inventory_quantity = $_REQUEST['live_inventory_quantity'];
	$gm = $_REQUEST['gm'];
	$ounce = $_REQUEST['ounce'];
	$thc = $_REQUEST['thc'];
	$popular = isset($_REQUEST['popular']) ? $_REQUEST['popular'] : 0;
	$new = isset($_REQUEST['new']) ? $_REQUEST['new'] : 0;
	$featured = isset($_REQUEST['featured']) ? $_REQUEST['featured'] : 0;
	
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
		if ($_FILES["largeImg"]["size"] > 2000000) {
			$Error = 1;
			$Err_largeImg = "This file size should not be grater than 2mb";
		}
		elseif($_FILES['largeImg']["type"] != "image/png")
		{
			$Error = 1;
			$Err_largeImg = "This file format is not allowed";
		}
	}
	
	if(is_uploaded_file($_FILES['smallImg']['tmp_name']))
	{	
		if ($_FILES["smallImg"]["size"] > 2000000) {
			$Error = 1;
			$Err_smallImg = "This file size should not be grater than 2mb";
		}
		elseif($_FILES['smallImg']["type"] != "image/png")
		{
			$Error = 1;
			$Err_smallImg = "This file format is not allowed";
		}
	}
		  
	if($Error == 0)
	{
		$assign_qtySql = mysql_fetch_assoc(mysql_query("SELECT SUM(avail_qty) as sum FROM tbl_planogram p INNER JOIN tbl_terminal t ON p.terminal_id = t.id  INNER JOIN tbl_customers c ON c.id=t.customer_id WHERE p.product_id='".$pid."' AND c.pos_assigned = 'NO POS'"));
		$assign_qty = $assign_qtySql['sum'];
		$gk_inventory_quantity = $live_inventory_quantity - $assign_qty;
		
		$UPDATE_PRODUCT = mysql_query("UPDATE `tbl_products` SET `row`='".$row."',`col`='".$col."', `product_name` = '".mysql_real_escape_string($txtName)."', `product_category` = '".mysql_real_escape_string($selCat)."', `description` = '".mysql_real_escape_string($description)."', `strain_name` = '".mysql_real_escape_string($strain_name)."', `price` = '".mysql_real_escape_string($price)."', `gm` = '".mysql_real_escape_string($gm)."', `ounce` = '".mysql_real_escape_string($ounce)."', `thc` = '".mysql_real_escape_string($thc)."',  `featured` = '".mysql_real_escape_string($featured)."', `new` = '".mysql_real_escape_string($new)."', `popular` = '".mysql_real_escape_string($popular)."', `live_inventory_quantity` = '".mysql_real_escape_string($live_inventory_quantity)."', `gk_inventory_quantity` = '".mysql_real_escape_string($gk_inventory_quantity)."' WHERE product_id = ".$pid);
		
		if(is_uploaded_file($_FILES['largeImg']['tmp_name']))
		{
			$largeProductImg = "product_images/".$_SESSION['user_id']."_large_".trim($_FILES['largeImg']['name']);
			move_uploaded_file($_FILES['largeImg']['tmp_name'],$largeProductImg);
			$UPDATE_PRODUCT = mysql_query("UPDATE `tbl_products` SET  `product_img` = '".mysql_real_escape_string($largeProductImg)."' WHERE product_id = ".$pid);
		}
		
		if(is_uploaded_file($_FILES['smallImg']['tmp_name']))
		{
			$smallProductImg = "product_images/".$_SESSION['user_id']."_small_".trim($_FILES['smallImg']['name']);
			move_uploaded_file($_FILES['smallImg']['tmp_name'],$smallProductImg);	
			$UPDATE_PRODUCT = mysql_query("UPDATE `tbl_products` SET  `product_small_img` = '".mysql_real_escape_string($smallProductImg)."' WHERE product_id = ".$pid);
		}
		
		#Update Planogram
		if(trim($row) == "" && trim($col) == ""){
			$customerId=$_SESSION['user_id'];
			$getTerminalId=mysql_fetch_array(mysql_query("SELECT id FROM `tbl_terminal` WHERE `customer_id`='".$customerId."'"));
			$terminalId=$getTerminalId['id'];
			mysql_query("DELETE FROM `tbl_planogram` WHERE `terminal_id`='".$terminalId."' AND product_id='".$pid."'");
		}
		elseif(trim($row) != "" && trim($col) != ""){
			$arrRow=explode(",",$row);
			$arrCol=explode(",",$col);
			
			$cnt=0;
			foreach($arrRow as $r)
			{			
				$customerId=$_SESSION['user_id'];
				$getTerminalId=mysql_fetch_array(mysql_query("SELECT id FROM `tbl_terminal` WHERE `customer_id`='".$customerId."'"));
				$terminalId=$getTerminalId['id'];		
				$location=$r."_".$arrCol[$cnt];
				
				if(mysql_num_rows(mysql_query("SELECT * FROM `tbl_planogram` WHERE `terminal_id`='".$terminalId."' AND product_id='".$pid."' AND `location`='".$location."'")) >0)
				{			
					mysql_query("UPDATE `tbl_planogram` SET `location`='".$location."' WHERE `terminal_id`='".$terminalId."' AND product_id='".$pid."' AND `location`='".$location."'");
				}
				else
				{	
					mysql_query("INSERT INTO `tbl_planogram` (`terminal_id`,`product_id`,`location`,`product_name`)VALUES('".$terminalId."','".$pid."','".$location."','".mysql_real_escape_string($txtName)."')");
				}	
				$cnt++;
			}
		}
		echo "<script> document.location.href='index.php?action=product_list&a=1'</script>";		
	}
}

?>
<script>
function showfilename(img){
	var img_path = document.getElementById(img);
	var img_name = img_path.files[0].name;
    document.getElementById(img+"name").innerHTML = img_name;
}
</script>
<div class="page-header tbg2" style="margin-top:20px;">
<div class="col-md-8">
  <h1> Update Product</h1> </div>
  <div class="col-md-4" style="text-align:right;"> <a href="index.php?action=product_list" class="greenbtn1">Previous Page</a> </div>
</div>
<div class="" id="">

<form action="" name="kiosk"  method="post" enctype="multipart/form-data">
<div class="col-md-8">
                  <input type="hidden" name="pid" value="<?=$pid?>" />
                  <input type="hidden" name="oldImg" value="<?=$largeProductImg_o?>" />
                  <input type="hidden" name="oldSImg" value="<?=$smallProductImg_o?>" />
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
							  <div class="w100">
                                <div class="col-md-12"> <label class="flebal"> Name </label></div>
                                <div class="col-md-12"><input type="text" class="textbox6" id="txtName" name="txtName" placeholder="Name" value="<?=$txtName;?>">
                                  &nbsp;
                                  <?php if(isset($Err_txtName) && $Err_txtName != "") { echo "<span style='color: #ff0000;'>".$Err_txtName."</span>";}?>
								</div>
							  </div>
							  <div class="clearfix gap1"> </div>
                              <div class="w100">
                                <div class="col-md-12"> <label class="flebal">Product Category </label> </div>
								<div class="col-md-12">
								<select name="selCat" class="textbox6">
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
                                  <?php if(isset($Err_selCat) && $Err_selCat != "") { echo "<span style='color: #ff0000;'>".$Err_selCat."</span>";}?></div>
                              </div>
							  <div class="clearfix gap1"> </div>
                              <div class="w100">
                                <div class="col-md-12"> <label class="flebal"> Description</label> </div>
								<div class="col-md-12"> 
								<textarea name="description" class="textbox6" rows="5" cols="10" onkeyup="countChar(this)" ><?=$description;?></textarea>
								<span id="desc_cnt"><?= 1000-strlen($description) ?> characters left</span><br>The coil end should be at 6 o'clock , Product must be loaded upside down
								</div>
                              </div>
<!--
							  <div class="clearfix gap1"> </div>
							  <div class="w100">
							  <div class="col-md-12"> <label class="flebal"> Row</label> </div>
								<div class="col-md-12"> 
								<input type="text" class="textbox6" name="row" value="<?=$row;?>">
                                </div>
                              </div>
                              <div class="clearfix gap1"> </div>
							  <div class="w100">
                                <div class="col-md-12"> <label class="flebal"> Col</label> </div>
                                <div class="col-md-12"> 
								<input type="text" class="textbox6" name="col" value="<?=$col;?>">
                                </div>
                              </div>
-->
                              <div class="clearfix gap1"> </div>
							  <div class="w100">
                                <div class="col-md-12"> <label class="flebal"> Strain Name</label> </div>
								<div class="col-md-12">
								<select name="strain_name" class="textbox6">
                                    <option value=""> -- SELECT -- </option>
                                    <option value="SATIVA" <?php if($strain_name == "SATIVA") { echo "SELECTED";}?>>SATIVA</option>
                                    <option value="INDICA" <?php if($strain_name == "INDICA") { echo "SELECTED";}?>>INDICA</option>
                                    <option value="HYBRID" <?php if($strain_name == "HYBRID") { echo "SELECTED";}?>>HYBRID</option>
                                    <option value="CBD" <?php if($strain_name == "CBD") { echo "SELECTED";}?>>CBD</option>
                                  </select>&nbsp;
                                </div>
                              </div>                       
                              <div class="clearfix gap1"> </div>
                              <div class="w100">
                                <div class="col-md-12"> <label class="flebal">Price</label> </div>
                                <div class="col-md-12">
								<input type="text" class="textbox6" id="price" name="price"  value="<?=$price;?>"> <?php if(isset($Err_price) && $Err_price != "") { echo "<span style='color: #ff0000;'>".$Err_price."</span>";}?>
								</div>
                              </div>
							  
							  <div class="clearfix gap1"> </div>
                              <div class="w100">
                                <div class="col-md-12"> <label class="flebal">Live inventory quantity </label> </div>
                                <div class="col-md-12">
								<input type="text" class="textbox6" id="live_inventory_quantity" name="live_inventory_quantity"  value="<?=$live_inventory_quantity ;?>">
								</div>
                              </div>
							  
                              <div class="clearfix gap1"> </div>
                              <div class="w100">
                                <div class="col-md-12"> <label class="flebal">GM</label> </div>
                                <div class="col-md-12"> 
								<input type="text" class="textbox6" id="gm" name="gm" value="<?=$gm;?>">
								</div>
                              </div>
                              
                              <div class="clearfix gap1"> </div>
							  <div class="w100">
							  <div class="col-md-12"> <label class="flebal">Ounce</label> </div>
                               <div class="col-md-12"> 
                                <input type="text" class="textbox6" id="ounce" name="ounce" value="<?=$ounce;?>">
							  </div>
                              </div>
							  
                              <div class="clearfix gap1"> </div>
							  <div class="w100">
								<div class="col-md-12"> <label class="flebal">THC</label> </div>
	                            <div class="col-md-12"><input type="text" class="textbox6" id="thc" name="thc" value="<?=$thc;?>"></div>
                              </div>
							  
							   <div class="clearfix gap1"> </div>
							  <div class="w100">
								<div class="col-md-2"> <label class="flebal">Featured</label></div>
								<div class="col-md-1"><input type="checkbox" class="textbox6" id="featured" name="featured" <?= ($featured == 1) ? 'checked' : ''?> value="1"></div>
                              </div>
							  
							  <div class="clearfix gap1"> </div>
							  <div class="w100">
								<div class="col-md-2"> <label class="flebal">NEW</label></div>
	                            <div class="col-md-1"><input type="checkbox" class="textbox6" id="new" name="new" <?= ($new == 1) ? 'checked' : ''?> value="1"></div>
                              </div>
							  
							   <div class="clearfix gap1"> </div>
							  <div class="w100">
								<div class="col-md-2"> <label class="flebal">Popular</label></div>
								<div class="col-md-1"><input type="checkbox" class="textbox6" id="popular" name="popular" <?= ($popular == 1) ? 'checked' : ''?> value="1" ></div>
							  </div>
							  
                      
                             <div class="clearfix gap1"> </div> 
                              <div class="w100">
                                <div class="col-md-12"><input id="cmdCheck" name="btnSubmit" value="Update" type="submit" class="greenbtn2"/>
								<a href="index.php?action=product_list" >
                                  <input type="button" value="Cancel" class="greenbtn2"/>
                                  </a></div>
                              </div>
</div> 
<div class="col-md-4">
<div class="row">
<div style="padding-bottom:20px; float:left">
	<label for="largeImg"><img src="images/upload.jpg" alt=""/></label>
	<br>
	<?php if(isset($Err_largeImg) && $Err_largeImg != "") { echo "<span style='color: #ff0000;'>".$Err_largeImg."</span><br>";}?>
	<span style="font-size:10px;">
	Required Image Size : 420 x 420 , Accept only .png file.</span>
	<br><span id="largeImgname"></span>
	<input type="file" id="largeImg" name="largeImg" style="display:none" onchange="showfilename('largeImg')">
</div>
<div style="float:left;margin-left:10px">
<?php
if( $largeProductImg_o!=""){ ?><img src="<?php echo $largeProductImg_o;?>" height="100" /> <? } 
?>
</div>
</div>
<div class="row">
<div style="padding-bottom:20px;float:left"> 
	<label for="smallImg"><img src="images/additional-photo.jpg" alt=""/></label>
   	<br>
	<?php if(isset($Err_smallImg) && $Err_smallImg != "") { echo "<span style='color: #ff0000;'>".$Err_smallImg."</span><br>";}?>
	<span style="font-size:10px;">
	Required Image Size : 205 x 235 , Accept only .png file.</span>
	<br><span id="smallImgname"></span>
	<input type="file" id="smallImg" name="smallImg" style="display:none" onchange="showfilename('smallImg')">
</div>
<div style="float:left;margin-left:10px">
<?php
if( $smallProductImg_o!=""){ ?><img src="<?php echo $smallProductImg_o;?>" height="100" /> <? } 
?>
</div>
</div>
</div>                          
</form>
</div>
<script>
function countChar(val) {
	var len = val.value.length;
	var cnt = 1000 - len;
	if(cnt < 0)
		cnt = 0
	$('#desc_cnt').text(cnt + ' characters left');
	if (len >= 1000) {
		val.value = val.value.substring(0, 10);
	} 
}
</script>

