<?
ob_start();
if($_REQUEST['submit'])
{
	$Error = 0;
	$name= $_REQUEST['name'];
	$popular = isset($_REQUEST['popular']) ? $_REQUEST['popular'] : 0;
	$new = isset($_REQUEST['new']) ? $_REQUEST['new'] : 0;
	$featured = isset($_REQUEST['featured']) ? $_REQUEST['featured'] : 0;
		
	if($name == ''){
		$Error = 1;
		$Err_txtName = 'Please enter the name.';
	}
	
	if($_FILES['orignal_image']['name']!="")
	{
		if ($_FILES["orignal_image"]["size"] > 2000000) {
			$Error = 1;
			$Err_largeImg = "This file size should not be grater than 2mb";
		}
		elseif($_FILES['orignal_image']["type"] != "image/png")
		{
			$Error = 1;
			$Err_largeImg = "This file format is not allowed";
		}
	}
		
	if($_FILES['small_image']['name']!="")
	{
		if ($_FILES["small_image"]["size"] > 2000000) {
			$Error = 1;
			$Err_smallImg = "This file size should not be grater than 2mb";
		}
		elseif($_FILES['small_image']["type"] != "image/png")
		{
			$Error = 1;
			$Err_smallImg = "This file format is not allowed";
		}
	}
		
	if($Error == 0)
	{
	//	echo "UPDATE `tbl_greenbits_inventory` SET `product_name`='".$_REQUEST['name']."',`product_description`='".$_REQUEST['description']."',`product_category_id`='".$_REQUEST['category_name']."',`product_strain_id`='".$_REQUEST['strain_name']."',`product_sell_price`='".$_REQUEST['sell_price']."',`product_weight_value`='".$_REQUEST['weight']."',`product_test_results_thc`='".$_REQUEST['thc']."' WHERE id='".$_REQUEST['id']."'";exit;
		mysql_query("UPDATE `tbl_greenbits_inventory` SET `product_name`='".$_REQUEST['name']."',`product_description`='".$_REQUEST['description']."',`row`='".$_REQUEST['row']."',`col`='".$_REQUEST['col']."',`product_category_id`='".$_REQUEST['category_name']."',`product_strain_id`='".$_REQUEST['strain_name']."',`product_sell_price`='".$_REQUEST['sell_price']."',`product_weight_value`='".$_REQUEST['weight']."',`product_test_results_thc`='".$_REQUEST['thc']."', `featured` = '".mysql_real_escape_string($featured)."', `new` = '".mysql_real_escape_string($new)."', `popular` = '".mysql_real_escape_string($popular)."' WHERE id='".$_REQUEST['id']."'");	
		
		if($_FILES['orignal_image']['name']!="")
		{
			$imageName="green_bits-".$_REQUEST['id'].".png";
			move_uploaded_file($_FILES['orignal_image']['tmp_name'], "../admin/product_images/".$imageName);
			mysql_query("UPDATE `tbl_greenbits_inventory` SET `product_orignal_image`='".$imageName."' WHERE id='".$_REQUEST['id']."'");
		}
		
		if($_FILES['small_image']['name']!="")
		{
			$SmimageName="green_bits-small-".$_REQUEST['id'].".png";
			move_uploaded_file($_FILES['small_image']['tmp_name'], "../admin/product_images/".$SmimageName);
			mysql_query("UPDATE `tbl_greenbits_inventory` SET `product_small_image`='".$SmimageName."' WHERE id='".$_REQUEST['id']."'");
		}
		
		
		$row = $_REQUEST['row'];
		$col = $_REQUEST['col'];
		#Update Planogram
		if(trim($row) == "" && trim($col) == "" ){
			$customerId=$_SESSION['user_id'];
			$getTerminalId=mysql_fetch_array(mysql_query("SELECT id FROM `tbl_terminal` WHERE `customer_id`='".$customerId."'"));
			$terminalId=$getTerminalId['id'];
			mysql_query("DELETE FROM `tbl_planogram` WHERE `terminal_id`='".$terminalId."' AND product_id='".$_REQUEST['id']."'");
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
				$check=mysql_query("SELECT * FROM `tbl_planogram` WHERE `terminal_id`='".$terminalId."' AND product_id='".$_REQUEST['id']."' AND `location`='".$location."'");
				$num=mysql_num_rows($check);
				if($num>0)
				{			
					mysql_query("UPDATE `tbl_planogram` SET `location`='".$location."' WHERE `terminal_id`='".$terminalId."' AND product_id='".$_REQUEST['id']."' AND `location`='".$location."'");
				}
				else
				{
					mysql_query("INSERT INTO `tbl_planogram` (`terminal_id`,`product_id`,`location`,`product_name`)VALUES('".$terminalId."','".$_REQUEST['id']."','".$location."','".$_REQUEST['name']."')");
				}
				$cnt++;		
			}
		}
		
		
		echo "<script> document.location.href='index.php?action=product_greenbits_list'</script>";		
	}
}
$data=mysql_fetch_array(mysql_query("SELECT * FROM `tbl_greenbits_inventory` WHERE `id`='".$_REQUEST['id']."'"));
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
  <h1> Edit Product </h1>
  </div>
  <div class="col-md-4" style="text-align:right;"> <a href="index.php?action=product_greenbits_list" class="greenbtn1">Previous Page</a> </div>
</div>
<form action="" name="kiosk"  method="post"  enctype="multipart/form-data">
<div class="col-md-8">          
                             <div class="w100">
                                <div class="col-md-12"> <label class="flebal"> Name </label></div>
                                <div class="col-md-12"><input type="hidden" name="id" value="<?=$data['id'];?>">
                                  <input class="textbox6" type="text" name="name" value="<?=$data['product_name'];?>">
								  <?php if(isset($Err_txtName) && $Err_txtName != "") { echo "<span style='color: #ff0000;'>".$Err_txtName."</span>";}?>
                                </div>
                              </div>
<!--			  
							  <div class="clearfix gap1"> </div>
                             <div class="w100">
								<div class="col-md-12"> <label class="flebal"> Row </label></div>
                                <div class="col-md-12">
                                <input class="textbox6" type="text" name="row" value="<?=$data['row'];?>">
                                </div>
                              </div>
							 
							<div class="clearfix gap1"> </div>
                              <div class="w100">
							    <div class="col-md-12"> <label class="flebal"> Col </label></div>
                                <div class="col-md-12">
                                <input class="textbox6" type="text" name="col" value="<?=$data['col'];?>">
                                </div>
                              </div>
--> 
							   <div class="clearfix gap1"> </div>
                              <div class="w100">
                                <div class="col-md-12"> <label class="flebal"> Category </label></div>
                                <div class="col-md-12">
									<input class="textbox6" type="text" name="category_name" value="<?=$data['product_category_id'];?>">
                                </div>
                              </div>
							 
							  <div class="clearfix gap1"> </div>
							  <div class="w100">
                                <div class="col-md-12"> <label class="flebal"> Description </label></div>
                                <div class="col-md-12">
									<textarea class="textbox6" name="description" ><?=$data['product_description'];?></textarea>
                                </div>
                              </div>
							  
							   <div class="clearfix gap1"> </div>
                              <div class="w100">
                                <div class="col-md-12"> <label class="flebal"> Strain Name </label></div>
                                <div class="col-md-12">
								<select class="textbox6" name="strain_name">
								<option value=""> -- SELECT -- </option>
                                    <option value="SATIVA" <?php if($data['strain_id'] == "SATIVA") { echo "SELECTED";}?>>SATIVA</option>
                                    <option value="INDICA" <?php if($data['strain_id'] == "INDICA") { echo "SELECTED";}?>>INDICA</option>
                                    <option value="HYBRID" <?php if($data['strain_id'] == "HYBRID") { echo "SELECTED";}?>>HYBRID</option>
                                    <option value="CBD" <?php if($data['strain_id'] == "CBD") { echo "SELECTED";}?>>CBD</option>
                                  </select>&nbsp;
                                </div>
                              </div>
							  
							   <div class="clearfix gap1"> </div>
                              <div class="w100">
                                <div class="col-md-12"> <label class="flebal"> Product Price </label></div>
                                <div class="col-md-12">
                                <input class="textbox6" type="text" name="sell_price" value="<?=$data['product_sell_price'];?>">
                                </div>
                              </div>
                     
							  <div class="clearfix gap1"> </div>
                              <div class="w100">
                                <div class="col-md-12"> <label class="flebal"> Weight </label></div>
                                <div class="col-md-12">
									<input class="textbox6" type="text" name="weight" value="<?=$data['product_weight_value'];?>">
                                </div>
                              </div>
							  
							   <div class="clearfix gap1"> </div>
                              <div class="w100">
                                <div class="col-md-12"> <label class="flebal"> THC </label></div>
                                <div class="col-md-12">
									<input class="textbox6" type="text" name="thc" value="<?=$data['product_test_results_thc'];?>">
                                </div>
                              </div>
							  
							  <div class="clearfix gap1"> </div>
							  <div class="w100">
								<div class="col-md-2"> <label class="flebal">Featured</label></div>
								<div class="col-md-1"><input type="checkbox" class="textbox6" id="featured" name="featured" <?= ($data['featured'] == 1) ? 'checked' : ''?> value="1"></div>
                            </div>
							  
							 <div class="clearfix gap1"> </div>
							  <div class="w100">
								<div class="col-md-2"> <label class="flebal">NEW</label></div>
	                            <div class="col-md-1"><input type="checkbox" class="textbox6" id="new" name="new" <?= ($data['new'] == 1) ? 'checked' : ''?> value="1"></div>
                            </div>
							  
							<div class="clearfix gap1"> </div>
							  <div class="w100">
								<div class="col-md-2"> <label class="flebal">Popular</label></div>
								<div class="col-md-1"><input type="checkbox" class="textbox6" id="popular" name="popular" <?= ($data['popular'] == 1) ? 'checked' : ''?> value="1" ></div>
							</div>
                              
							   <div class="clearfix gap1"> </div>
                              <div class="w100">
                                <div class="col-md-12"><input id="cmdCheck" name="submit" value="Update" type="submit" class="greenbtn2"/>
                                  &nbsp;&nbsp;<a href="index.php" >
                                  <input type="button" value="Cancel" class="greenbtn2"/>
                                  </a>
								  </div>
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
	<input type="file" id="largeImg" name="orignal_image" style="display:none" onchange="showfilename('largeImg')">
</div>
<div style="float:left;margin-left:10px">
<?php
if( $data['product_orignal_image']!=""){ ?><img src="../admin/product_images/<?php echo $data['product_orignal_image'];?>" height="100" /> <? } 
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
	<input type="file" id="smallImg" name="small_image" style="display:none" onchange="showfilename('smallImg')">
</div>
<div style="float:left;margin-left:10px">
<?php
if( $data['product_small_image']!=""){ ?><img src="../admin/product_images/<?php echo $data['product_small_image'];?>" height="100" /> <? } 
?>
</div>
</div>
</div> 						  
						  
</form>

