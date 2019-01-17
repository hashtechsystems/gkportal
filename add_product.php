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
	$popular = isset($_REQUEST['popular']) ? $_REQUEST['popular'] : 0;
	$new = isset($_REQUEST['new']) ? $_REQUEST['new'] : 0;
	$featured = isset($_REQUEST['featured']) ? $_REQUEST['featured'] : 0;
		
	if($txtName == "")
	{
		$Error = 1;
		$Err_txtName = 'Please enter the name.';
	}

	if($selCat == "select")
	{
		$Error = 1;
		$Err_selCat = 'Please select the category';
	}
		
	if($price == "")
	{
		$Error = 1;
		$Err_Price = 'Please enter the product price.';
	}
	
	$largeProductImg = '';
	if(empty($_FILES['largeImg']['tmp_name'])){
		$Error = 1;
		$Err_largeImg = "Please Upload the Large Product Image";
	}	
	elseif(is_uploaded_file($_FILES['largeImg']['tmp_name']))
	{	
		if ($_FILES["largeImg"]["size"] > 2000000) {
			$Error = 1;
			$Err_largeImg = "This file size should not be grater than 2mb";
		}
		else{
			if($_FILES['largeImg']["type"] == "image/png")
			{
				if($Error == 0){
					$largeProductImg = "product_images/".$_SESSION['user_id']."_large_".trim($_FILES['largeImg']['name']);
					move_uploaded_file($_FILES['largeImg']['tmp_name'],$largeProductImg);
				}
			}
			else
			{
				$Error = 1;
				$Err_largeImg = "This file format is not allowed";
			}
		}
	}
	
	if(is_uploaded_file($_FILES['smallImg']['tmp_name']))
	{	
		if ($_FILES["smallImg"]["size"] > 2000000) {
			$Error = 1;
			$Err_smallImg = "This file size should not be grater than 2mb";
		}
		else{
			if($_FILES['smallImg']["type"] == "image/png")
			{
				if($Error == 0){
					$smallProductImg = "product_images/".$_SESSION['user_id']."_small_".trim($_FILES['smallImg']['name']);
					move_uploaded_file($_FILES['smallImg']['tmp_name'],$smallProductImg);
				}
			}
			else
			{
				$Error = 1;
				$Err_smallImg = "This file format is not allowed";
			}
		}
	}
	
	$loc=$_REQUEST['row']."_".$_REQUEST['col'];
	$rcCheck = mysql_query("SELECT pl.id FROM tbl_planogram pl INNER JOIN tbl_terminal t ON pl.terminal_id = t.id WHERE pl.location = '".mysql_real_escape_string($loc)."' AND t.customer_id = '".mysql_real_escape_string($_SESSION['user_id'])."'");
	if(mysql_num_rows($rcCheck) > 0){
		$Err_row = "This row and cloumn is already assigned to another product";
		$Error = 1;
	}
		  
	if($Error == 0)
	{
		$DateAdded = date("Y-m-d H:i:s");
		$INSERT_PRODUCT = mysql_query("INSERT INTO `tbl_products` (`customer_id`, `product_name`, `product_category`, `description`, `strain_name`, `price`, `gm`, `ounce`, `thc`, `product_img`, `product_small_img`, `date_added`, `isDeleted`,`row`,`col`, `featured`, `new`, `popular`) VALUES ('".$_SESSION['user_id']."', '".mysql_real_escape_string($txtName)."', '".mysql_real_escape_string($selCat)."', '".mysql_real_escape_string($description)."', '".mysql_real_escape_string($strain_name)."', '".mysql_real_escape_string($price)."', '".mysql_real_escape_string($gm)."', '".mysql_real_escape_string($ounce)."', '".mysql_real_escape_string($thc)."', '".mysql_real_escape_string($largeProductImg)."', '".mysql_real_escape_string($smallProductImg)."', '".mysql_real_escape_string($DateAdded)."', 0,'".$row."','".$col."', '".mysql_real_escape_string($featured)."', '".mysql_real_escape_string($new)."', '".mysql_real_escape_string($popular)."')");
		
		$productId=mysql_insert_id();
		#Update Planogram
		$customerId=$_SESSION['user_id'];
		$getTerminalId=mysql_fetch_array(mysql_query("SELECT id FROM `tbl_terminal` WHERE `customer_id`='".$customerId."'"));
		$terminalId=$getTerminalId['id'];
		
		if(trim($_REQUEST['row']) != "" && trim($_REQUEST['col']) != ""){
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
<div class="page-header tbg2 heauto" style="margin-top:20px;">
<div class="col-md-8 p40">
  <h1> Add Product</h1> </div>
  <div class="col-md-4 textleft" style="text-align:right;"><a href="index.php?action=product_list" class="greenbtn1">Previous Page</a> </div>
  <div class="clearfix" style="display: -webkit-box;"></div>
</div>
<div class="" id="">
<form action="" name="kiosk"  method="post" enctype="multipart/form-data">
<div class="col-md-8">
<div class="w100">
<div class="col-md-12"> <label class="flebal"> Name </label> </div>
<div class="col-md-12"><input type="text" id="txtName" class="textbox6" name="txtName" placeholder="Name" value="<?=$txtName;?>">
                                  &nbsp;
                                  <?php if(isset($Err_txtName) && $Err_txtName != "") { echo "<span style='color: #ff0000;'>".$Err_txtName."</span>";}?>  </div>


</div>
<div class="clearfix gap1"> </div>
<div class="w100">
<div class="col-md-12"> <label class="flebal">Product Category </label> </div>
<div class="col-md-12"><select name="selCat" class="textbox6">
                                    <option value="select"> -- SELECT -- </option>
                                    <option value="Flower" <?php if(isset($_REQUEST['selCat']) && $_REQUEST['selCat'] == 'Flower') echo "selected = 'selected'" ?> >Flower</option>
                                    <option value="Edible" <?php if(isset($_REQUEST['selCat']) && $_REQUEST['selCat'] == 'Edible') echo "selected = 'selected'" ?> >Edible</option>
                                    <option value="Topical" <?php if(isset($_REQUEST['selCat']) && $_REQUEST['selCat'] == 'Topical') echo "selected = 'selected'" ?> >Topical</option>
                                    <option value="Pre-roll" <?php if(isset($_REQUEST['selCat']) && $_REQUEST['selCat'] == 'Pre-roll') echo "selected = 'selected'" ?> >Pre-roll</option>
                                    <option value="Cartridge" <?php if(isset($_REQUEST['selCat']) && $_REQUEST['selCat'] == 'Cartridge') echo "selected = 'selected'" ?> >Cartridge</option>
                                    <option value="Meal" <?php if(isset($_REQUEST['selCat']) && $_REQUEST['selCat'] == 'Meal') echo "selected = 'selected'" ?> >Meal</option>
                                    <option value="Concentrate" <?php if(isset($_REQUEST['selCat']) && $_REQUEST['selCat'] == 'Concentrate') echo "selected = 'selected'" ?> >Concentrate</option>
                                    <option value="Other" <?php if(isset($_REQUEST['selCat']) && $_REQUEST['selCat'] == 'Other') echo "selected = 'selected'" ?> >Other</option>
                                  </select>&nbsp;
                                  <?php if(isset($Err_selCat) && $Err_selCat != "") { echo "<span style='color: #ff0000;'>".$Err_selCat."</span>";}?>  </div>

</div>
<div class="clearfix gap1"> </div>
<div class="w100">
<div class="col-md-12"> <label class="flebal"> Description</label> </div>
<div class="col-md-12"> <textarea id="description" name="description" rows="5" cols="10" class="textbox6" onkeyup="countChar(this)" ><?php if(isset($_REQUEST['description']) ) echo $_REQUEST['description'] ?></textarea>
<span id="desc_cnt">1000 characters left</span><br>The coil end should be at 6 o'clock , Product must be loaded upside down
</div>
</div>
<div class="clearfix gap1"> </div>
<div class="w100">
<div class="col-md-12"> <label class="flebal"> Row</label> </div>
<div class="col-md-12"> 
<input type="text" name="row" class="textbox6" value="<?=$row;?>">
<?php if(isset($Err_row) && $Err_row != "") { echo "<span style='color: #ff0000;'>".$Err_row."</span>";}?>
</div>

</div>

<div class="clearfix gap1"> </div>
<div class="w100">
<div class="col-md-12"> <label class="flebal"> Col</label> </div>
<div class="col-md-12"> 
<input type="text" name="col" class="textbox6" value="<?=$col;?>">


</div>

</div>

<div class="clearfix gap1"> </div>
<div class="w100">
<div class="col-md-12"> <label class="flebal"> Strain Name</label>  </div>
<div class="col-md-12">
<select name="strain_name" class="textbox6">
                                    <option value=""> -- SELECT -- </option>
                                    <option value="SATIVA" <?php if(isset($_REQUEST['strain_name']) && $_REQUEST['strain_name'] == 'SATIVA') echo "selected = 'selected'" ?> >SATIVA</option>
                                    <option value="INDICA" <?php if(isset($_REQUEST['strain_name']) && $_REQUEST['strain_name'] == 'INDICA') echo "selected = 'selected'" ?> >INDICA</option>
                                    <option value="HYBRID" <?php if(isset($_REQUEST['strain_name']) && $_REQUEST['strain_name'] == 'HYBRID') echo "selected = 'selected'" ?> >HYBRID</option>
                                    <option value="CBD" <?php if(isset($_REQUEST['strain_name']) && $_REQUEST['strain_name'] == 'CBD') echo "selected = 'selected'" ?> >CBD</option>
                                  </select> 



</div>

</div>
<div class="clearfix gap1"> </div>
<div class="w100">
<div class="col-md-12"> <label class="flebal">Price </label>  </div>
<div class="col-md-12"> 
<input type="text" class="textbox6" id="price" name="price" size="5" value="<?= $price ?>"> <?php if(isset($Err_Price) && $Err_Price != "") { echo "<span style='color: #ff0000;'>".$Err_Price."</span>";}?>



</div>

</div>
<div class="clearfix gap1"> </div>
<div class="w100">
<div class="col-md-12"> <label class="flebal">GM </label>  </div>
<div class="col-md-12"> 
<input type="text" id="gm" name="gm" class="textbox6" value="<?= $gm ?>">



</div>

</div>
<div class="clearfix gap1"> </div>
<div class="w100">
<div class="col-md-12"> <label class="flebal">Ounce </label>  </div>
<div class="col-md-12"> 
<input type="text" id="ounce" name="ounce" class="textbox6" value="<?= $ounce ?>">


</div>

</div>
<div class="clearfix gap1"> </div>
<div class="w100">
<div class="col-md-12"> <label class="flebal">THC </label>  </div>
<div class="col-md-12"> 
<input type="text" id="thc" name="thc" class="textbox6" value="<?= $thc ?>">
</div>
</div>

<div class="clearfix gap1"> </div>
<div class="w100">
<div class="col-md-2"> <label class="flebal">Featured</label></div>
<div class="col-md-1"><input type="checkbox" class="" id="featured" name="featured" value="1" <?php if(isset($_REQUEST['featured'])) echo 'checked' ?> ></div>
</div>

<div class="clearfix gap1"> </div>
<div class="w100">
<div class="col-md-2"> <label class="flebal">NEW</label></div>
<div class="col-md-1"><input type="checkbox" class="" id="new" name="new" value="1" <?php if(isset($_REQUEST['new'])) echo 'checked' ?> ></div>
</div>

<div class="clearfix gap1"> </div>
<div class="w100">
<div class="col-md-2"> <label class="flebal">Popular</label></div>
<div class="col-md-1"><input type="checkbox" class="" id="popular" name="popular" value="1" <?php if(isset($_REQUEST['popular'])) echo 'checked' ?> ></div>
</div>

<div class="clearfix gap1"> </div>
<div class="w100">
<div class="col-md-12 p40 show991" style="padding-bottom:30px;"> <input id="cmdCheck" name="btnSubmit" value="Add" type="submit" class="greenbtn2"/>  <a href="index.php?action=product_list" >
                                  <input type="button" value="Cancel" class="greenbtn2"/>
                                  </a></div>
<div class="col-md-6"> 



</div>

</div>





</div>

<div class="col-md-4 ">
<div style="padding-bottom:20px;">
	<label for="largeImg"><img src="images/upload.jpg" alt=""/></label>
	<br>
	<?php if(isset($Err_largeImg) && $Err_largeImg != "") { echo "<span style='color: #ff0000;'>".$Err_largeImg."</span><br>";}?>
	<span style="font-size:10px;">
	Required Image Size : 420 x 420 , Accept only .png file.</span>
	<br><span id="largeImgname"></span>
	<input type="file" id="largeImg" name="largeImg" style="display:none" onchange="showfilename('largeImg')">
</div>
<div style="padding-bottom:20px;"> 
	<label for="smallImg"><img src="images/additional-photo.jpg" alt=""/></label>
   	<br>
	<?php if(isset($Err_smallImg) && $Err_smallImg != "") { echo "<span style='color: #ff0000;'>".$Err_smallImg."</span><br>";}?>
	<span style="font-size:10px;">
	Required Image Size : 205 x 235 , Accept only .png file.</span>
	<br><span id="smallImgname"></span>
	<input type="file" id="smallImg" name="smallImg" style="display:none" onchange="showfilename('smallImg')">
</div>
<div class="col-md-12 p40 hide991" style="padding-bottom:30px;"> <input id="cmdCheck" name="btnSubmit" value="Add" type="submit" class="greenbtn2"/>  <a href="index.php?action=product_list" >
                                  <input type="button" value="Cancel" class="greenbtn2"/>
                                  </a></div>

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
