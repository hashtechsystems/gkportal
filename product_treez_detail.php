<?php 
session_start();
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

$PRODUCT = mysql_fetch_assoc(mysql_query("SELECT * FROM `tbl_products_treez` WHERE pid = ".$_REQUEST['id']));
?>
<a href="index.php?action=product_treez_list"><< Back</a>
<div class="" id="container" style="margin-top:20px;">
  <div class="page-header">
    <h1> Product Detail</h1>
  </div>
  <table>
  	<tr>
    	<td style="height:35px; text-align:left; width:120px;">Product Id</td>
        <td style="height:35px; text-align:left;"><?=$PRODUCT['product_id'];?></td>
    </tr>
    <tr>
    	<td style="height:35px; text-align:left; width:120px;">Product Name</td>
        <td style="height:35px; text-align:left;"><?=$PRODUCT['product_name'];?></td>
    </tr>
    <tr>
    	<td style="height:35px; text-align:left; width:120px;">Product Type</td>
        <td style="height:35px; text-align:left;"><?=$PRODUCT['product_type'];?></td>
    </tr>
    <tr>
    	<td style="height:35px; text-align:left; width:120px;">Classification</td>
        <td style="height:35px; text-align:left;"><?=$PRODUCT['classifications'];?></td>
    </tr>
    <tr>
    	<td style="height:35px; text-align:left; width:120px;">Brand</td>
        <td style="height:35px; text-align:left;"><?=$PRODUCT['brand'];?></td>
    </tr>
    <tr>
    	<td style="height:35px; text-align:left; width:120px;">Total Cannabinoids</td>
        <td style="height:35px; text-align:left;"><?=$PRODUCT['totalCannabinoids'];?></td>
    </tr>
    <tr>
    	<td style="height:35px; text-align:left; width:120px;">Description</td>
        <td style="height:35px; text-align:left;"><?=$PRODUCT['description'];?></td>
    </tr>
    <tr>
    	<td style="height:35px; text-align:left; width:120px;">Active</td>
        <td style="height:35px; text-align:left;"><?=$PRODUCT['active'];?></td>
    </tr>
    <tr>
    	<td style="height:35px; text-align:left; width:120px;">Tax Rate</td>
        <td style="height:35px; text-align:left;"><?=$PRODUCT['taxRate'];?></td>
    </tr>
    <tr>
    	<td style="height:35px; text-align:left; width:120px;">Total Doses</td>
        <td style="height:35px; text-align:left;"><?=$PRODUCT['total_doses'];?></td>
    </tr>
    <tr>
    	<td style="height:35px; text-align:left; width:120px;">mg Dose</td>
        <td style="height:35px; text-align:left;"><?=$PRODUCT['mg_dose'];?></td>
    </tr>
    <tr>
    	<td style="height:35px; text-align:left; width:120px;">cbd Ratio</td>
        <td style="height:35px; text-align:left;"><?=$PRODUCT['cbd_ratio'];?></td>
    </tr>
    <tr>
    	<td style="height:35px; text-align:left; width:120px;">Total Cannabinoids Percentage</td>
        <td style="height:35px; text-align:left;"><?=$PRODUCT['total_cannabinoids_percentage'];?></td>
    </tr>
    <tr>
    	<td style="height:35px; text-align:left; width:120px;">thc Percentage</td>
        <td style="height:35px; text-align:left;"><?=$PRODUCT['thc_percentage'];?></td>
    </tr>
    <tr>
    	<td style="height:35px; text-align:left; width:120px;">cbd Percentage</td>
        <td style="height:35px; text-align:left;"><?=$PRODUCT['cbd_percentage'];?></td>
    </tr>
    <tr>
    	<td style="height:35px; text-align:left; width:120px;">terpenes Percentage</td>
        <td style="height:35px; text-align:left;"><?=$PRODUCT['terpenes_percentage'];?></td>
    </tr>
    <tr>
    	<td style="height:35px; text-align:left; width:120px;">Size</td>
        <td style="height:35px; text-align:left;"><?=$PRODUCT['size'];?></td>
    </tr>
    <tr>
    	<td style="height:35px; text-align:left; width:120px;">Medium</td>
        <td style="height:35px; text-align:left;"><?=$PRODUCT['medium'];?></td>
    </tr>
    <tr>
    	<td style="height:35px; text-align:left; width:120px;">Large Image</td>
        <td style="height:35px; text-align:left;"><?=$PRODUCT['large_image'];?></td>
    </tr>    
    <tr>
    	<td style="height:35px; text-align:left; width:120px;">Cropped Image</td>
        <td style="height:35px; text-align:left;"><?=$PRODUCT['cropped_image'];?></td>
    </tr>
    <tr>
    	<td style="height:35px; text-align:left; width:120px;">Menu Title</td>
        <td style="height:35px; text-align:left;"><?=$PRODUCT['menu_title'];?></td>
    </tr>
    <tr>
    	<td style="height:35px; text-align:left; width:120px;">Back Stock Inventory Quantity</td>
        <td style="height:35px; text-align:left;"><?=$PRODUCT['back_stock_inventory_quantity'];?></td>
    </tr>
    <tr>
    	<td style="height:35px; text-align:left; width:120px;">Live Inventory Quantity</td>
        <td style="height:35px; text-align:left;"><?=$PRODUCT['live_inventory_quantity'];?></td>
    </tr>    
  </table>
  <br /><br />
  <strong>Product Size : </strong>
  <table cellpadding="5" cellspacing="5" width="90%" align="center" class="table table-bordered">
    <tr>
      <th class="stat">Barcodes</th>
      <th class="stat">Type</th>
      <th class="stat">Size Id</th>  
      <th class="stat">Size</th> 
      <th class="stat">Live Inventory Quantity</th>  
      <th class="stat">Product Size Name</th>  
      <th class="stat">Product Unit</th>   
      <th class="stat">Primary Tax Rate</th>           
      <th class="stat">Price Sell</th>
    </tr>
    <?php	
	$query=mysql_query("SELECT * FROM `tbl_products_size_treez` WHERE  product_id = ".$PRODUCT['pid']);
	if(mysql_num_rows($query) > 0)
	{
	$cnt=0;
	while($data=mysql_fetch_array($query))
	{	
	$cnt++;	
	?>
    <tr>
	  <td class="stat"><?php echo $data['barcodes']; ?></td>
	  <td class="stat"><?php echo $data['type']; ?></td>
	  <td class="stat"><?php echo $data['size_id']; ?></td> 
	  <td class="stat"><?php echo $data['size']; ?></td> 
	  <td class="stat"><?php echo $data['live_inventory_quantity']; ?></td> 
	  <td class="stat"><?php echo $data['product_size_name']; ?></td> 
	  <td class="stat"><?php echo $data['product_unit']; ?></td> 
	  <td class="stat"><?php echo $data['primary_tax_rate']; ?></td>  
	  <td class="stat"><?php echo $data['price_sell']; ?></td>
    </tr>
    <?php
	}
	}
	else
	{
		?>
        <tr>
          <td class="stat" colspan="10">No record found.</td>
        </tr>
        <?php
	}
	?>
  </table>
</div>
