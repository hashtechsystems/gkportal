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

$CONSUMER = mysql_fetch_assoc(mysql_query("SELECT * FROM `tbl_consumer_mjfreeway` WHERE consumer_id = ".$_REQUEST['id']));
?>
<style>
.textbox6{
	min-height:50px;
}
</style>
<div class="page-header tbg2" style="margin-top:20px;">
<div class="col-md-8">
  <h1> Consumer Detail</h1> </div>
  <div class="col-md-4" style="text-align:right;"><a href="index.php?action=consumer_list_mjfreeway" class="greenbtn1">Previous Page</a> </div>
</div>

<div>
  <div class="row">
  <div class="col-md-8">
  	<div class="w100">
        <div class="col-md-12"><label class="flebal">Consumer Id</label></div>
		<div class="col-md-12 textbox6">
		<?=$CONSUMER['consumer_id'];?>
		</div>
	</div>
	
    <div class="clearfix gap1"> </div>
	<div class="w100">
        <div class="col-md-12"><label class="flebal">Consumer Name</label></div>
		<div class="col-md-12 textbox6">
		<?=$CONSUMER['first_name']." ".$CONSUMER['last_name'];?>
		</div>
	</div>
	
	<div class="clearfix gap1"> </div>
    <div class="w100">
        <div class="col-md-12"><label class="flebal">Email</label></div>
		<div class="col-md-12 textbox6">
		<?=$CONSUMER['email_address'];?>
		</div>
   </div>
	
	<div class="clearfix gap1"> </div>
    <div class="w100">
        <div class="col-md-12"><label class="flebal">Gender</label></div>
		<div class="col-md-12 textbox6">
    	<?=$CONSUMER['gender'];?>
		</div>
    </div>
    
	<div class="clearfix gap1"> </div>
	<div class="w100">
        <div class="col-md-12"><label class="flebal">Birth Date</label></div>
		<div class="col-md-12 textbox6">
    	<?=$CONSUMER['birth_date'];?>
		</div>
   </div>
    
	<div class="clearfix gap1"> </div>
	<div class="w100">
        <div class="col-md-12"><label class="flebal">Active</label></div>
		<div class="col-md-12 textbox6">
    	<?=$CONSUMER['active'];?>
		</div>
    </div>
	
	<div class="clearfix gap1"> </div>
    <div class="w100">
        <div class="col-md-12"><label class="flebal">Total Points</label></div>
		<div class="col-md-12 textbox6">
    	<?=$CONSUMER['total_points'];?>
		</div>
    </div>
    
	<div class="clearfix gap1"> </div>
	<div class="w100">
        <div class="col-md-12"><label class="flebal">Preferred Contact</label></div>
		<div class="col-md-12 textbox6">
    	<?=$CONSUMER['preferred_contact'];?>
		</div>
    </div>
    
	<div class="clearfix gap1"> </div>
	<div class="w100">
        <div class="col-md-12"><label class="flebal">Diagnosis</label></div>
		<div class="col-md-12 textbox6">
    	<?=$CONSUMER['diagnosis'];?>
		</div>
    </div>
    
	<div class="clearfix gap1"> </div>
	<div class="w100">
        <div class="col-md-12"><label class="flebal">Physician Name</label></div>
		<div class="col-md-12 textbox6">
    	<?=$CONSUMER['physician_name'];?>
		</div>
    </div>
	
	<div class="clearfix gap1"> </div>
    <div class="w100">
        <div class="col-md-12"><label class="flebal">Physician License</label></div>
		<div class="col-md-12 textbox6">
    	<?=$CONSUMER['physician_license'];?>
		</div>
    </div>
	
	<div class="clearfix gap1"> </div>
    <div class="w100">
        <div class="col-md-12"><label class="flebal">Physician Address</label></div>
		<div class="col-md-12 textbox6">
    	<?=$CONSUMER['physician_address'];?>
		</div>
	</div>
	
	<div class="clearfix gap1"> </div>
    <div class="w100">
        <div class="col-md-12"><label class="flebal">Total Orders</label></div>
		<div class="col-md-12 textbox6">
    	<?=$CONSUMER['total_orders'];?>
		</div>
    </div>
	
	<div class="clearfix gap1"> </div>
    <div class="w100">
        <div class="col-md-12"><label class="flebal">Total Spent</label></div>
		<div class="col-md-12 textbox6">
    	<?=$CONSUMER['total_spent'];?>
		</div>
    </div>
	
	<div class="clearfix gap1"> </div>
    <div class="w100">
        <div class="col-md-12"><label class="flebal">Type</label></div>
		<div class="col-md-12 textbox6">
    	<?=$CONSUMER['type'];?>
		</div>  
    </div>
  </div>
  </div>
  <div class="row" style="margin:20px">
  <h3>Address</h3>
  <table cellpadding="5" cellspacing="5" width="90%" align="center" class="table table-bordered">
    <tr>
      <th class="stat">address_id</th>
      <th class="stat">street_address_1</th>
      <th class="stat">street_address_2</th>  
      <th class="stat">city</th> 
      <th class="stat">province_code</th>  
      <th class="stat">postal_code</th>  
      <th class="stat">country_code</th>   
      <th class="stat">Primary </th>           
      <th class="stat">active</th>
    </tr>
    <?php	
	$query=mysql_query("SELECT * FROM `tbl_consumer_mjfreeway_addresses` WHERE consumer_id = ".$CONSUMER['consumer_id']);
	if(mysql_num_rows($query) > 0)
	{
	$cnt=0;
	while($data=mysql_fetch_array($query))
	{	
	$cnt++;	
	?>
    <tr>
	  <td class="stat"><?php echo $data['address_id']; ?></td>
	  <td class="stat"><?php echo $data['street_address_1']; ?></td>
	  <td class="stat"><?php echo $data['street_address_2']; ?></td> 
	  <td class="stat"><?php echo $data['city']; ?></td> 
	  <td class="stat"><?php echo $data['province_code']; ?></td> 
	  <td class="stat"><?php echo $data['postal_code']; ?></td> 
	  <td class="stat"><?php echo $data['country_code']; ?></td> 
	  <td class="stat"><?php echo $data['primary']; ?></td>  
	  <td class="stat"><?php echo $data['active']; ?></td>
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
  <div class="row" style="margin:20px">
  <h3>Ids : </h3>
  <table cellpadding="5" cellspacing="5" width="90%" align="center" class="table table-bordered">
    <tr>
      <th class="stat">ids_id</th>
      <th class="stat">type</th>
      <th class="stat">identification_number</th>  
      <th class="stat">state</th> 
      <th class="stat">active</th>  
      <th class="stat">expired_at</th> 
    </tr>
    <?php	
	$query=mysql_query("SELECT * FROM `tbl_consumer_mjfreeway_ids` WHERE consumer_id = ".$CONSUMER['consumer_id']);
	if(mysql_num_rows($query) > 0)
	{
	$cnt=0;
	while($data=mysql_fetch_array($query))
	{	
	$cnt++;	
	?>
    <tr>
	  <td class="stat"><?php echo $data['ids_id']; ?></td>
	  <td class="stat"><?php echo $data['type']; ?></td>
	  <td class="stat"><?php echo $data['identification_number']; ?></td> 
	  <td class="stat"><?php echo $data['state']; ?></td> 
	  <td class="stat"><?php echo $data['active']; ?></td> 
	  <td class="stat"><?php echo $data['expired_at']; ?></td> 
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
  
</div>
