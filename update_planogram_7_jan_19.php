<? 
if($_SESSION['islogin']=="")
{
#	echo "In If";
?>
<script type="text/javascript">
document.location.href='login.php';
</script>
<?
}
else
{
#	echo "In Else";
}

$query=mysql_query("SELECT id, terminal_id, planogram FROM `tbl_terminal` WHERE id = ".$_REQUEST['id']);
$data=mysql_fetch_array($query);

$Metrix = explode("x", $data['planogram']);
$rows = $Metrix[0];
$cols = $Metrix[1];

if(isset($_REQUEST['btnUpdate']))
{
	#echo "<pre>";
	#print_r($_REQUEST);
	#exit();
	$terminal_id = $_REQUEST['terminal_id'];
	$location = $_REQUEST['location'];
	$selProduct = $_REQUEST['selProduct'.$location];
	
	$SP = explode("|", $selProduct);
	$ProductId = $SP[0];
	$ProductName = $SP[1];
	
	$minQty = $_REQUEST['minQty'.$location];
	$Qty = $_REQUEST['Qty'.$location];
	
	
	$arr=explode("_",$location);

	$getPos=mysql_fetch_array(mysql_query("SELECT tbl_customers.pos_assigned FROM `tbl_terminal` LEFT JOIN `tbl_customers` ON tbl_terminal.customer_id=tbl_customers.id WHERE tbl_terminal.id='".$terminal_id."'"));
	$POS=$getPos['pos_assigned'];
	
	if($POS=="MJ Freeway")
	{
		$getCurrentLocationOfProduct=mysql_query("SELECT `location` FROM `tbl_planogram` WHERE `terminal_id`='".$terminal_id."' AND `product_id`='".$ProductId."' ORDER BY id Asc");
		$rowStr="";
		$colStr="";
		$cnt=0;
		while($getCurrentLocationOfProductData=mysql_fetch_array($getCurrentLocationOfProduct))
		{
			$arr3=explode("_",$getCurrentLocationOfProductData['location']);
			if($cnt==0)
			{
				$rowStr.=$arr3[0];
				$colStr.=$arr3[1];
			}
			else
			{
				$rowStr.=",".$arr3[0];
				$colStr.=",".$arr3[1];
			}
			$cnt++;
		}
		if($cnt==0)
		{
				$rowStr.=$arr[0];
				$colStr.=$arr[1];
		}
		else		
		{
			$rowStr.=",".$arr[0];
			$colStr.=",".$arr[1];
		}
		mysql_query("UPDATE `mj_freeway_products` SET `row`='".$rowStr."',`col`='".$colStr."' WHERE id='".$ProductId."'");			
	}
	else
	if($POS=="Treez")
	{
		$getCurrentLocationOfProduct=mysql_query("SELECT `location` FROM `tbl_planogram` WHERE `terminal_id`='".$terminal_id."' AND `product_id`='".$ProductId."' ORDER BY id Asc");
		$rowStr="";
		$colStr="";
		$cnt=0;
		while($getCurrentLocationOfProductData=mysql_fetch_array($getCurrentLocationOfProduct))
		{
			$arr3=explode("_",$getCurrentLocationOfProductData['location']);
			if($cnt==0)
			{
				$rowStr.=$arr3[0];
				$colStr.=$arr3[1];
			}
			else
			{
				$rowStr.=",".$arr3[0];
				$colStr.=",".$arr3[1];
			}
			$cnt++;
		}
		if($cnt==0)
		{
				$rowStr.=$arr[0];
				$colStr.=$arr[1];
		}
		else		
		{
			$rowStr.=",".$arr[0];
			$colStr.=",".$arr[1];
		}
		mysql_query("UPDATE `tbl_products_treez` SET `row`='".$rowStr."',`col`='".$colStr."' WHERE pid='".$ProductId."'");			
	}
	else
	if($POS=="No Pos")
	{
		$getCurrentLocationOfProduct=mysql_query("SELECT `location` FROM `tbl_planogram` WHERE `terminal_id`='".$terminal_id."' AND `product_id`='".$ProductId."' ORDER BY id Asc");
		$rowStr="";
		$colStr="";
		$cnt=0;
		while($getCurrentLocationOfProductData=mysql_fetch_array($getCurrentLocationOfProduct))
		{
			$arr3=explode("_",$getCurrentLocationOfProductData['location']);
			if($cnt==0)
			{
				$rowStr.=$arr3[0];
				$colStr.=$arr3[1];
			}
			else
			{
				$rowStr.=",".$arr3[0];
				$colStr.=",".$arr3[1];
			}
			$cnt++;
		}
		if($cnt==0)
		{
				$rowStr.=$arr[0];
				$colStr.=$arr[1];
		}
		else		
		{
			$rowStr.=",".$arr[0];
			$colStr.=",".$arr[1];
		}
		mysql_query("UPDATE `tbl_products` SET `row`='".$rowStr."',`col`='".$colStr."' WHERE product_id='".$ProductId."'");	
	}
	$SQL_CHK_P = mysql_query("SELECT * FROM tbl_planogram WHERE terminal_id = '".$terminal_id."' AND location = '".$location."' ");
	if(mysql_num_rows($SQL_CHK_P) > 0)
	{
		$DATA_PL = mysql_fetch_assoc($SQL_CHK_P);
		$current_qty = $DATA_PL['current_qty'] + abs($DATA_PL['avail_qty'] - $Qty); 
		mysql_query("UPDATE `tbl_planogram` SET `location` = '".$location."', `product_id` = '".$ProductId."', `product_name` = '".$ProductName."', `min_qty` = '".$minQty."', `avail_qty` = '".$Qty."', `current_qty` = '".$current_qty."' WHERE `id` = ".$DATA_PL['id']);
		
	}
	else
	{
		mysql_query("INSERT INTO `tbl_planogram`(`terminal_id`, `location`, `product_id`, `product_name`, `min_qty`, `avail_qty`, `current_qty`) VALUES ('".$terminal_id."', '".$location."', '".$ProductId."', '".$ProductName."', '".$minQty."', '".$Qty."', '".$Qty."')");
	}
}
?>
<script type="text/javascript">
function validatePlanForm(location)
{
	var err = '';
	var prod = document.getElementById('selProduct'+location).value;
	var minQty = document.getElementById('minQty'+location).value;
	var Qty = document.getElementById('Qty'+location).value;
	
	//alert("location : "+location+" |prod : "+prod+" |minQty : "+minQty+" |Qty : "+Qty); 
	
	if(prod == "select")
	{
		//alert("Please select the product.");
		document.getElementById('ErrProduct'+location).innerHTML = "Required";
		err = 'Error';
	}
	
	if(minQty == "")
	{
		//alert("Please enter the minimum quantity.");
		document.getElementById('ErrMQ'+location).innerHTML = "Required";
		err = 'Error';
	}
	
	
	if(Qty == "")
	{
		//alert("Please enter the assigned quantity.");
		document.getElementById('ErrQ'+location).innerHTML = "Required";
		err = 'Error';
	}
	
	
	if(err == '')
	{
		return true;
	}
	else
	{
		return false;
	}
}
</script>
<div class="" id="container" style="margin-top:20px;">
  <div class="page-header">
    <h1> Update Planogram </h1>
  </div>
  <a href="index.php?action=manage_planogram" style="float:right;">Back</a>
  <p><strong>Terminal Id : <?php echo $data['terminal_id']; ?></strong></p>
  <p><strong>Planogram Metrix : <?php echo $data['planogram']; ?></strong></p>
  <br />
  <table cellpadding="5" cellspacing="5" width="90%" align="center">
    <?php
	for($ir = 0; $ir <= $rows-1; $ir++)
	{
		echo "<tr style='vertical-align:top;'>";
		for($ic = 0; $ic <= $cols-1; $ic++)
		{
			$product_table = "tbl_products";
			$id = "product_id";
			$small_image_path = "product_small_img";
			$large_image_path = "product_img";
			if($_SESSION['user_id'] == '1'){
				$product_table = "mj_freeway_products";
				$id = "id";
				$small_image_path = "small_image";
				$large_image_path = "orignal_image";
			}
			elseif($_SESSION['user_id'] == '2'){
				$product_table = "tbl_products_treez";
				$id = "pid";
				$small_image_path = "small_image";
				$large_image_path = "orignal_image";
			}
			
			$location = $ir."_".$ic;
			#echo "SELECT * FROM tbl_planogram WHERE terminal_id = '".$data['terminal_id']."' AND location = '".$location."' ";
			#echo "SELECT pl.*, p.$small_image_path as small_image, p.$large_image_path as large_image FROM tbl_planogram pl INNER JOIN $product_table p ON p.$id = pl.product_id WHERE pl.terminal_id = '".$data['id']."' AND location = '".$location."' ";
			#echo "<br>";
			$SQL_CHK_P = mysql_query("SELECT pl.*, p.$small_image_path as small_image, p.$large_image_path as large_image FROM tbl_planogram pl INNER JOIN $product_table p ON p.$id = pl.product_id WHERE pl.terminal_id = '".$data['id']."' AND location = '".$location."' ");
			
			if(mysql_num_rows($SQL_CHK_P) > 0)
			{
				$DATA_PL = mysql_fetch_assoc($SQL_CHK_P);
				
				?>
    <td style="vertical-align:top;"><div style='border: solid 1px #ccc; padding: 2%;margin: 2%;    min-height: 159px;'>
          <?php
						 $img = "";
						 if(!empty($DATA_PL['small_image'])){
							 if($_SESSION['user_id'] != '3'){ 
							   $img = "product_images/".$DATA_PL['small_image'];
							 } else{
								$img = $DATA_PL['small_image'];
							 }
						 }
						 else if(!empty($DATA_PL['large_image'])){
							 if($_SESSION['user_id'] != '3'){ 
							   $img = "product_images/".$DATA_PL['large_image'];
							 } else{
								$img = $DATA_PL['large_image'];
							 }
						 }
						 if(!empty($img)){
						 ?>
          <img src="<?= $img ?>" height="50" />
          <?
						 }
						 ?>
          <strong>Location :
          <?=$location;?>
          </strong> <br />
          Product :
          <?=$DATA_PL['product_name'];?>
          <br />
          Assigned Quantity :
          <?=$DATA_PL['avail_qty'];?>
          <br />
          Min Quantity :
          <?=$DATA_PL['min_qty'];?>
          <br />
          <a href="#"  data-toggle="modal" data-target="#myModal<?=$location;?>">Update</a>&nbsp;&nbsp;<a href="index.php?action=remove_planogram_item&id=<?=$_REQUEST['id'];?>&pid=<?=$DATA_PL['product_id'];?>&location=<?=$location;?>" onclick="return confirm('Are you really want to remove this item?')">Remove</a> </div>
        <div id="myModal<?=$location;?>" class="modal fade" role="dialog" style="z-index:500000000;">
          <div class="modal-dialog" style="margin: 132px auto 30px;">
            <!-- Modal content-->
            <div class="modal-content" style="width:600px;">
              <button type="button" class="close" style="position:absolute; top:0; right:5px; z-index:50000;" data-dismiss="modal">&times;</button>
              <div class="modal-body" style="position:relative;">
                <form name="frm<?=$location;?>" onsubmit="return validatePlanForm('<?=$location;?>')" method="post">
                  <input type="hidden" name="terminal_id" value="<?=$data['id'];?>" />
                  <input type="hidden" name="location" value="<?=$location;?>" />
                  <p>Select Product <span style="color:#B40003;" id="ErrProduct<?=$location;?>"></span><br />
                    <select name="selProduct<?=$location;?>" id="selProduct<?=$location;?>">
                      <option value="select">Select</option>
                      <?php
							if($_SESSION['AssignedPOS'] == "MJ Freeway")
   							{
								$SQL_PROD = mysql_query("SELECT id as Pid, name as PName FROM `mj_freeway_products` WHERE isDeleted = '0'");
							}
							else
							if($_SESSION['AssignedPOS'] == "Treez")
   							{
								$SQL_PROD = mysql_query("SELECT pid as Pid, product_name as PName FROM `tbl_products_treez` WHERE isDeleted = '0'");
							}							
							else
							if($_SESSION['AssignedPOS'] == "No Pos")
   							{
								$SQL_PROD = mysql_query("SELECT product_id as Pid, product_name as PName FROM `tbl_products` WHERE isDeleted = '0' AND customer_id = ".$_SESSION['user_id']);
							}
							
							while($DATA_PROD = mysql_fetch_assoc($SQL_PROD))
							{
							?>
                      <option value="<?=$DATA_PROD['Pid']."|".$DATA_PROD['PName'];?>" <?php if($DATA_PROD['Pid'] == $DATA_PL['product_id']) { echo "SELECTED";}?>>
                      <?=$DATA_PROD['PName'];?>
                      </option>
                      <?php	
							}
							?>
                    </select>
                  </p>
                  <p>Assigned Quantity <span style="color:#B40003;" id="ErrQ<?=$location;?>"></span><br />
                    <input type="text" name="Qty<?=$location;?>" id="Qty<?=$location;?>" value="<?=$DATA_PL['avail_qty'];?>" />
                  </p>
                  <p>Minimum Quantity <span style="color:#B40003;" id="ErrMQ<?=$location;?>"></span><br />
                    <input type="text" name="minQty<?=$location;?>" id="minQty<?=$location;?>" value="<?=$DATA_PL['min_qty'];?>" />
                  </p>
                  <p>&nbsp;<br />
                    <input type="submit" name="btnUpdate" value="Update" />
                  </p>
                </form>
              </div>
            </div>
          </div>
        </div>
        <?php
			}
			else
			{
				?>
      <td style="vertical-align:top;"><div style='border: solid 1px #ccc; padding: 2%;margin: 2%;    min-height: 159px;'> <strong>Location :
          <?=$location;?>
          </strong> <br />
          Product : Not Assigned <br />
          Assigned Quantity : 0 <br />
          Min Quantity : 0 <br />
          <a href="#"  data-toggle="modal" data-target="#myModal<?=$location;?>">Update</a> </div>
        <div id="myModal<?=$location;?>" class="modal fade" role="dialog" style="z-index:500000000;">
          <div class="modal-dialog" style="margin: 132px auto 30px;">
            <!-- Modal content-->
            <div class="modal-content" style="width:600px;">
              <button type="button" class="close" style="position:absolute; top:0; right:5px; z-index:50000;" data-dismiss="modal">&times;</button>
              <div class="modal-body" style="position:relative;">
                <form name="frm<?=$location;?>" onsubmit="return validatePlanForm('<?=$location;?>')" method="post">
                  <input type="hidden" name="terminal_id" id="terminal_id" value="<?=$data['id'];?>" />
                  <input type="hidden" name="location" id="location" value="<?=$location;?>" />
                  <p>Select Product <span style="color:#B40003;" id="ErrProduct<?=$location;?>"></span><br />
                    <select name="selProduct<?=$location;?>" id="selProduct<?=$location;?>">
                      <option value="select">Select</option>
                      <?php
							if($_SESSION['AssignedPOS'] == "MJ Freeway")
   							{
								$SQL_PROD = mysql_query("SELECT id as Pid, name as PName FROM `mj_freeway_products` WHERE isDeleted = '0'");
							}
							else
							if($_SESSION['AssignedPOS'] == "Treez")
   							{
								$SQL_PROD = mysql_query("SELECT pid as Pid, product_name as PName FROM `tbl_products_treez` WHERE isDeleted = '0'");
							}							
							else
							if($_SESSION['AssignedPOS'] == "No Pos")
   							{
								$SQL_PROD = mysql_query("SELECT product_id as Pid, product_name as PName FROM `tbl_products` WHERE isDeleted = '0' AND customer_id = ".$_SESSION['user_id']);
							}
							
							while($DATA_PROD = mysql_fetch_assoc($SQL_PROD))
							{
							?>
                      <option value="<?=$DATA_PROD['Pid']."|".$DATA_PROD['PName'];?>">
                      <?=$DATA_PROD['PName'];?>
                      </option>
                      <?php	
							}
							?>
                    </select>
                  </p>
                  <p>Assigned Quantity <span style="color:#B40003;" id="ErrQ<?=$location;?>"></span><br />
                    <input type="text" name="Qty<?=$location;?>" id="Qty<?=$location;?>" />
                  </p>
                  <p>Minimum Quantity <span style="color:#B40003;" id="ErrMQ<?=$location;?>"></span><br />
                    <input type="text" name="minQty<?=$location;?>" id="minQty<?=$location;?>" />
                  </p>
                  <p>&nbsp;<br />
                    <input type="submit" name="btnUpdate" value="Update" />
                  </p>
                </form>
              </div>
            </div>
          </div>
        </div>
        <?php
			}
			
			echo "</td>";
		}
		echo "</tr>";
		
	}
	?>
  </table>
</div>
