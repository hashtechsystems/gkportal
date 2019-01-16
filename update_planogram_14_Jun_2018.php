<? if($_SESSION['islogin']=="")
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
	$terminal_id = $_REQUEST['terminal_id'];
	$location = $_REQUEST['location'];
	$selProduct = $_REQUEST['selProduct'.$location];
	
	$SP = explode("|", $selProduct);
	$ProductId = $SP[0];
	$ProductName = $SP[1];
	
	$minQty = $_REQUEST['minQty'.$location];
	$Qty = $_REQUEST['Qty'.$location];
	
	$SQL_CHK_P = mysql_query("SELECT id FROM tbl_planogram WHERE terminal_id = '".$terminal_id."' AND location = '".$location."' ");
	
	if(mysql_num_rows($SQL_CHK_P) > 0)
	{
		$DATA_PL = mysql_fetch_assoc($SQL_CHK_P);
		
		mysql_query("UPDATE `tbl_planogram` SET `location` = '".$location."', `product_id` = '".$ProductId."', `product_name` = '".$ProductName."', `min_qty` = '".$minQty."', `avail_qty` = '".$Qty."' WHERE `id` = ".$DATA_PL['id']);
		
	}
	else
	{
		mysql_query("INSERT INTO `tbl_planogram`(`terminal_id`, `location`, `product_id`, `product_name`, `min_qty`, `avail_qty`) VALUES ('".$terminal_id."', '".$location."', '".$ProductId."', '".$ProductName."', '".$minQty."', '".$Qty."')");
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
	for($ir = 1; $ir <= $rows; $ir++)
	{
		echo "<tr>";
		for($ic = 1; $ic <= $cols; $ic++)
		{
			$location = $ir."_".$ic;
			
			$SQL_CHK_P = mysql_query("SELECT * FROM tbl_planogram WHERE terminal_id = '".$data['terminal_id']."' AND location = '".$location."' ");
			
			if(mysql_num_rows($SQL_CHK_P) > 0)
			{
				$DATA_PL = mysql_fetch_assoc($SQL_CHK_P);
				
				?>
                <td>
                    <div style='border: solid 1px #ccc; padding: 2%;margin: 2%;'>			
                        <strong>Location : <?=$location;?></strong>
                        <br />Product : <?=$DATA_PL['product_name'];?>
                        <br />Assigned Quantity : <?=$DATA_PL['avail_qty'];?>
                        <br />Min Quantity : <?=$DATA_PL['min_qty'];?>			
                        <br />
                        <a href="#"  data-toggle="modal" data-target="#myModal<?=$location;?>">Update</a>
                   </div> 
                   
                    <div id="myModal<?=$location;?>" class="modal fade" role="dialog" style="z-index:500000000;">
                      <div class="modal-dialog" style="margin: 132px auto 30px;"> 
                      <!-- Modal content-->
                          <div class="modal-content" style="width:600px;">   
                          <button type="button" class="close" style="position:absolute; top:0; right:5px; z-index:50000;" data-dismiss="modal">&times;</button>    
                          <div class="modal-body" style="position:relative;">     
                          <form name="frm<?=$location;?>" onsubmit="return validatePlanForm('<?=$location;?>')" method="post">
                          <input type="hidden" name="terminal_id" value="<?=$data['terminal_id'];?>" />
                          <input type="hidden" name="location" value="<?=$location;?>" />
                          <p>Select Product <span style="color:#B40003;" id="ErrProduct<?=$location;?>"></span><br />
                          <select name="selProduct<?=$location;?>" id="selProduct<?=$location;?>">
                          	<option value="select">Select</option>
                            <?php
							if($_SESSION['AssignedPOS'] == "MJ Freeway")
   							{
								$SQL_PROD = mysql_query("SELECT id as Pid, name as PName FROM `mj_freeway_products`");
							}
							else
							if($_SESSION['AssignedPOS'] == "Treez")
   							{
								$SQL_PROD = mysql_query("SELECT pid as Pid, product_name as PName FROM `tbl_products_treez`");
							}
							
							while($DATA_PROD = mysql_fetch_assoc($SQL_PROD))
							{
							?>
                            <option value="<?=$DATA_PROD['Pid']."|".$DATA_PROD['PName'];?>" <?php if($DATA_PROD['Pid'] == $DATA_PL['product_id']) { echo "SELECTED";}?>><?=$DATA_PROD['PName'];?></option>
                            <?php	
							}
							?>
                          </select>
                          </p>
                          
                          <p>Assigned Quantity  <span style="color:#B40003;" id="ErrQ<?=$location;?>"></span><br />
                          <input type="text" name="Qty<?=$location;?>" id="Qty<?=$location;?>" value="<?=$DATA_PL['avail_qty'];?>" />
                          </p>
                          
                          <p>Minimum Quantity  <span style="color:#B40003;" id="ErrMQ<?=$location;?>"></span><br />
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
                <td>
                    <div style='border: solid 1px #ccc; padding: 2%;margin: 2%;'>			
                        <strong>Location : <?=$location;?></strong>
                        <br />Product : Not Assigned
                        <br />Assigned Quantity : 0
                        <br />Min Quantity : 0			
                        <br />
                        <a href="#"  data-toggle="modal" data-target="#myModal<?=$location;?>">Update</a>
                   </div> 
                   
                    <div id="myModal<?=$location;?>" class="modal fade" role="dialog" style="z-index:500000000;">
                      <div class="modal-dialog" style="margin: 132px auto 30px;"> 
                      <!-- Modal content-->
                          <div class="modal-content" style="width:600px;">   
                          <button type="button" class="close" style="position:absolute; top:0; right:5px; z-index:50000;" data-dismiss="modal">&times;</button>    
                          <div class="modal-body" style="position:relative;">     
                          <form name="frm<?=$location;?>" onsubmit="return validatePlanForm('<?=$location;?>')" method="post">
                          <input type="hidden" name="terminal_id" id="terminal_id" value="<?=$data['terminal_id'];?>" />
                          <input type="hidden" name="location" id="location" value="<?=$location;?>" />
                          <p>Select Product <span style="color:#B40003;" id="ErrProduct<?=$location;?>"></span><br />
                          <select name="selProduct<?=$location;?>" id="selProduct<?=$location;?>">
                          	<option value="select">Select</option>
                            <?php
							if($_SESSION['AssignedPOS'] == "MJ Freeway")
   							{
								$SQL_PROD = mysql_query("SELECT id as Pid, name as PName FROM `mj_freeway_products`");
							}
							else
							if($_SESSION['AssignedPOS'] == "Treez")
   							{
								$SQL_PROD = mysql_query("SELECT pid as Pid, product_name as PName FROM `tbl_products_treez`");
							}
							
							while($DATA_PROD = mysql_fetch_assoc($SQL_PROD))
							{
							?>
                            <option value="<?=$DATA_PROD['Pid']."|".$DATA_PROD['PName'];?>"><?=$DATA_PROD['PName'];?></option>
                            <?php	
							}
							?>
                          </select>
                          </p>
                                                    
                          <p>Assigned Quantity  <span style="color:#B40003;" id="ErrQ<?=$location;?>"></span><br />
                          <input type="text" name="Qty<?=$location;?>" id="Qty<?=$location;?>" />
                          </p>
                          
                          <p>Minimum Quantity  <span style="color:#B40003;" id="ErrMQ<?=$location;?>"></span><br />
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
