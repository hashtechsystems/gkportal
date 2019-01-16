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

$CONSUMER = mysql_fetch_assoc(mysql_query("SELECT * FROM `tbl_greenbits_customers` WHERE c_id = ".$_REQUEST['id']));
?>
<style>
.textbox6{
	min-height:50px
}
</style>

<div class="" id="container" style="margin-top:20px;">
<div class="page-header tbg2">
	<div class="col-md-8">
    <h1> Consumer Detail</h1>
	</div>
	<div class="col-md-4" style="text-align:right;"> <a href="index.php?action=consumer_list_greenbits" class="greenbtn1">Previous Page</a> </div>
  </div>
  
  <div class="col-md-8">
							<div class="w100">
                                <div class="col-md-12"> <label class="flebal"> Consumer Id </label></div>
                                <div class="col-md-12 textbox6"><?= $CONSUMER['c_id'] ?></div>
                              </div>
							  
							  <div class="clearfix gap1"> </div>
							  <div class="w100">
                                <div class="col-md-12"> <label class="flebal"> Consumer Name </label></div>
                                <div class="col-md-12 textbox6"><?=$CONSUMER['first_name']." ".$CONSUMER['last_name'];?></div>
                              </div>
							  
							  <div class="clearfix gap1"> </div>
							  <div class="w100">
                                <div class="col-md-12"> <label class="flebal"> Driver License </label></div>
                                <div class="col-md-12 textbox6"><?=$CONSUMER['driver_license_number']?></div>
                              </div>
							  
							  <div class="clearfix gap1"> </div>
							  <div class="w100">
                                <div class="col-md-12"> <label class="flebal">Driver License Expiry Date </label></div>
                                <div class="col-md-12 textbox6"><?=$CONSUMER['driver_license_expiration_date']?></div>
                              </div>
							  
							  <div class="clearfix gap1"> </div>
							  <div class="w100">
                                <div class="col-md-12"> <label class="flebal"> Email </label></div>
                                <div class="col-md-12 textbox6"><?= $CONSUMER['email']; ?></div>
                              </div>
							  
							  <div class="clearfix gap1"> </div>
							  <div class="w100">
                                <div class="col-md-12"> <label class="flebal"> Gender </label></div>
                                <div class="col-md-12 textbox6"><?= $CONSUMER['gender']; ?></div>
                              </div>
							  
							  <div class="clearfix gap1"> </div>
							  <div class="w100">
                                <div class="col-md-12"> <label class="flebal"> Birth Date </label></div>
                                <div class="col-md-12 textbox6"><?= $CONSUMER['birth_date'] ?></div>
                              </div>
							  
							  <div class="clearfix gap1"> </div> 
							   <div class="w100">
                                <div class="col-md-12"> <label class="flebal"> Phone </label></div>
                                <div class="col-md-12 textbox6"><?= $CONSUMER['phone'] ?></div>
                              </div>
							   
							   <div class="clearfix gap1"> </div>
							   <div class="w100">
                                <div class="col-md-12"> <label class="flebal"> Physician Name </label></div>
                                <div class="col-md-12 textbox6"><?= $CONSUMER['physician_name'] ?></div>
                              </div>
							   
							   <div class="clearfix gap1"> </div>
							   <div class="w100">
                                <div class="col-md-12"> <label class="flebal"> Type </label></div>
                                <div class="col-md-12 textbox6"><?= $CONSUMER['type'] ?></div>
                              </div>

</div>
</div>
