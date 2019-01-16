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

if(isset($_REQUEST['submit']))
{
	#echo"<pre>";print_r($_REQUEST);exit;
	$campagianid=$_REQUEST['campagianid'];
	$statId=$_REQUEST['statId'];
	$network=$_REQUEST['network'];
	$ListName=$_REQUEST['ListName'];
	if($network=="novadash")
	{
		$getOfferDetails=mysql_fetch_array(mysql_query("SELECT * FROM tbl_novadash WHERE `campaign_id`='".$campagianid."'"));
		mysql_query("INSERT INTO `match_table`(`stat_id`,`network`,`campaignid`, `list_name`,`offer_number`,`offer_name`)VALUES('".$statId."','".$network."','".$campagianid."','".$ListName."','".$getOfferDetails['offer_id']."','".$getOfferDetails['offer_name']."')");
	}
	else
	{
		mysql_query("INSERT INTO `match_table`(`stat_id`,`network`,`campaignid`, `list_name`)VALUES('".$statId."','".$network."','".$campagianid."','".$ListName."')");
	}
	mysql_query("UPDATE `stats` SET campagian_assined=1 WHERE `id`='".$statId."'");
}
	
$result = " where 1";
if(isset($_REQUEST['Search']))
{
	
	$from="";
	$to="";
	if($_REQUEST['fromdate']!="")
	{
		$from=$_REQUEST['fromdate'];	
	}
	else
	{
		$from=date('d/m/Y');
	}
	
	if($_REQUEST['todate']!="")
	{
		$to=$_REQUEST['todate'];	
	}
	else
	{
		$to=date('d/m/Y');
	}
$result = " where sent_date BETWEEN '".$from."' AND '".$to."' "; 
}
if(isset($_REQUEST['order_by']))
{
	$orderBy=" ORDER BY ".$_REQUEST['field']." ".$_REQUEST['order_by'];
	$result .=$orderBy;
}
?>

<div class="" id="container" style="margin-top:20px;">
  <div class="page-header">
    <h1> Inventory Products </h1>
  </div>
  <!--<a href="index.php?action=add_employee" style="float:right; cursor:pointer; text-decoration:none; padding:4px 7px; background-color:#1473B8; color:#FFFFFF;">Add New Employee</a>-->
  <table cellpadding="5" cellspacing="5" width="90%" align="center" class="table table-bordered">
    <tr>
	 <th class="stat">Id</th>  
      <th class="stat">Image</th>
      <th class="stat">Name</th>
      <th class="stat">Row</th>
	  <th class="stat">Col</th>
	  <th class="stat">Category</th>
      <th class="stat">Strain Name</th> 
	  <th class="stat">Product Price</th> 
	  <th class="stat">Discount</th> 
	  <th class="stat">Gm</th> 
	  <th class="stat">Ounce</th> 
	  <th class="stat">THC</th>	   
      <th class="value">Action</th>
    </tr>
    <?php	
	$query=mysql_query("SELECT * FROM `mj_freeway_products`". $result);
	$cnt=0;
	while($data=mysql_fetch_array($query))
	{	
	$cnt++;	
	?>
    <tr>
	  <td class="stat"><em> <?php echo $cnt; ?></em></td>
	  <td class="stat"><em><? if( $data['orignal_image']!=""){ ?> <img src="product_images/<?php echo $data['orignal_image'];?>" height="50" /> <? } ?></em></td>      
	  <td class="stat"><em><?php echo $data['name']; ?></em></td> 
      <td class="stat"><em><?php echo $data['row'];?></em></td>      
	  <td class="stat"><em><?php echo $data['col'];?></em></td>      
	  <td class="stat"><em><?php echo $data['category_name'];?></em></td>      
	  <td class="stat"><em><?php echo $data['strain_name'];?></em></td>      
	  <td class="stat"><em><?php echo $data['default_price'];?> $</em></td>      
	  <td class="stat"><em><?php echo $data['discount'];?></em></td>      
	  <td class="stat"><em><?php echo $data['gm'];?></em></td>      
	  <td class="stat"><em><?php echo $data['ounce'];?></em></td>      
	  <td class="stat"><em><?php echo $data['thc'];?></em></td>           	  
      <td> <a href="index.php?action=edit_mj_free_way_product&id=<?=$data['id'];?>">Edit</a></td>
    </tr>
    <?php
	}
	?>
  </table>
</div>
