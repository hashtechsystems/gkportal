<?
ob_start();
if($_REQUEST['submit'])
{
	$error = NULL;
	$rack= $_REQUEST['rack'];
		
	if($rack == '')
		$error[] = "Please enter the rack.";
	
		
	if(count($error) < 1)
	{
		$num=mysql_num_rows(mysql_query("SELECT * FROM `tbl_terminal_stock` WHERE `terminal_id`='".$_REQUEST['terminal_id']."' AND `rack_name`='".$_REQUEST['rack']."'"));
		if($num==0)
		{
			mysql_query("INSERT INTO `tbl_terminal_stock` (`terminal_id`,`rack_name`,`capacity`,`fill_quantity`,`commission`,`product_id`,`current_stock`)VALUES('".$_REQUEST['terminal_id']."','".$_REQUEST['rack']."','".$_REQUEST['capacity']."','".$_REQUEST['minimum_level']."','".$_REQUEST['commission']."','".$_REQUEST['product_id']."','".$_REQUEST['current_stock']."')");			
		}
		else
		{
			mysql_query("UPDATE `tbl_terminal_stock` SET `capacity`='".$_REQUEST['capacity']."',`fill_quantity`='".$_REQUEST['minimum_level']."',`commission`='".$_REQUEST['commission']."',`product_id`='".$_REQUEST['product_id']."',`current_stock`='".$_REQUEST['current_stock']."' WHERE `terminal_id`='".$_REQUEST['terminal_id']."' AND `rack_name`='".$_REQUEST['rack']."'");
		}
		echo "<script> document.location.href='index.php?action=assigned_products&a=1'</script>";		
	}
}
$getProductAndMachineDetails=mysql_fetch_array(mysql_query("SELECT tbl_terminal.id, tbl_products.product_id,tbl_products.product_name,tbl_terminal.terminal_name,tbl_terminal.matrix FROM `tbl_assigned_products`,tbl_products,tbl_terminal WHERE tbl_assigned_products.terminal_id=tbl_terminal.id AND tbl_products.product_id=tbl_assigned_products.product_id AND tbl_assigned_products.id='".$_REQUEST['id']."'"));
#echo "<pre>";
#print_r($getProductAndMachineDetails);
$getCurrentStock=mysql_fetch_array(mysql_query("SELECT * FROM `tbl_terminal_stock` WHERE `terminal_id`='".$getProductAndMachineDetails['id']."' AND `product_id`='".$getProductAndMachineDetails['product_id']."'"));
?>

<div class="page-header" style="margin-top:20px;">
  <h1> Add Site</h1>
</div>
<div class="container" id="container">
  <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="bo02">
    <tr>
      <td class="des-bg2" ><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bo3">
          <tr>
            <td valign="top" bgcolor=""><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td valign="top"><form action="" name="kiosk"  method="post" >
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
                                <td align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Product</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><?=$getProductAndMachineDetails['product_name'];?>
                                <input type="hidden" name="product_id" value="<?=$getProductAndMachineDetails['product_id'];?>">
                                </td>
                              </tr>
                              
                              <tr>
                                <td align="left" class="form-t">Terminal</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">&nbsp;<?=$getProductAndMachineDetails['terminal_name'];?>
                                <input type="hidden" name="terminal_id" value="<?=$getProductAndMachineDetails['id'];?>">
                                </td>
                              </tr>
                              <script type="application/javascript">
							  	function setRack(i,j)
								{
									document.getElementById('rack').value=i+""+j;
								}
							  </script>
                              <tr>
                                <td align="left" class="form-t">Matrix</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left">
                                	<table width="90%" align="left" border="1" cellpadding="5" cellspacing="5">
                                    	<? if($getProductAndMachineDetails['matrix']=="6 By 6")
										{
											for($i=1;$i<=6;$i++)
											{
											?>
                                                <tr>
                                                	<?
													for($j=1;$j<=6;$j++)
													{
														?>
                                                    	<td align="center" height="40"><a href="#1" onClick="setRack(<?=$i;?>,<?=$j;?>)"><? echo $i.$j; ?></a></td>
                                                        <?
													}
													?>
                                                </tr>
                                                <?
											}
										}
										else
										if($getProductAndMachineDetails['matrix']=="6 By 10")
										{
											for($i=1;$i<=6;$i++)
											{
											?>
                                                <tr>
                                                	<?
													for($j=1;$j<=10;$j++)
													{
														?>
                                                    	<td align="center" height="40"><a href="#1" onClick="setRack(<?=$i;?>,<?=$j;?>)"><? echo $i.$j; ?></a></td>
                                                        <?
													}
													?>
                                                </tr>
                                                <?
											}
										}
										?>
                                    </table>
                                </td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Selected Rack</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="rack" id="rack" value="<?=$getCurrentStock['rack_name'];?>"></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Capacity</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="capacity" value="<?=$getCurrentStock['capacity'];?>"></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Fill quantity</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="minimum_level" value="<?=$getCurrentStock['fill_quantity'];?>"></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Current Stock</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="current_stock" value="<?=$getCurrentStock['current_stock'];?>"></td>
                              </tr>
                              <tr>
                                <td align="left" class="form-t">Commission</td>
                                <td width="20">:</td>
                                <td height="40" class="textbox-bg2" align="left"><input type="text" name="commission" value="<?=$getCurrentStock['commission'];?>"></td>
                              </tr>
                              <tr>
                             
                              <tr align="left">
                                <td height="35" colspan="">&nbsp;</td>
                                <td width="20"></td>
                                <td height="40" colspan=""><input id="cmdCheck" name="submit" value="Add" type="submit" class="button"/>
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
