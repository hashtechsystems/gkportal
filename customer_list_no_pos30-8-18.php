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

$where = "";
if(isset($_REQUEST['Search']))
{
	if($_REQUEST['search_name']!="")
	{
		$name = $_REQUEST['search_name'];
		$where .= " AND LOWER(ConsumerName) LIKE '%".mysql_real_escape_string(strtolower(trim($name)))."%'"; 
	}
}

$orderBy = " ORDER BY id DESC";
if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] != 'default')
{
	if($_REQUEST['order_by'] == 'recent'){
		$orderBy=" ORDER BY id DESC";
	}
	elseif($_REQUEST['order_by'] == 'cname_asc'){
		$orderBy=" ORDER BY ConsumerName ASC";
	}
	elseif($_REQUEST['order_by'] == 'cname_desc'){
		$orderBy=" ORDER BY ConsumerName DESC";
	}	
}
?>
<script>
function showResult(str) {
  if (str.length==0) {
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.border="0px";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("livesearch").innerHTML=this.responseText;
      document.getElementById("livesearch").style.border="1px solid #A5ACB2";
    }
  }
  xmlhttp.open("GET","searchConsumer_nopos.php?q="+str,true);
  xmlhttp.send();
}

function addInSearch(ele){
	var str = ele.innerHTML;
	document.getElementById("search_name").value = str;
	document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.border="0px";
}
</script>
<style>
#livesearch{
   background:white;
   z-index: 1;
 position: relative;
}
.search_ele:hover{
	color:#337ab7;
	cursor:pointer;
}
.search_ele{
	font-size:15px;
	padding-left:5px;
}

</style>
<div class="" id="container" style="margin-top:20px;">
<?php
 $check_limit = mysql_fetch_array(mysql_query("SELECT daily_gm_limit, daily_tch_limit From tbl_customers WHERE id = '".$_SESSION['user_id']."'"));

?>
<div class="grybox" style="display: -webkit-box; width:99%; padding:4% 0;">
  <div class="col-md-4">
  <span class="emplo-font1"> Consumer total daily limit Gm </span>
  <div class="clearfix"></div>
  <span class="emplo-font2"> <?= $check_limit['daily_gm_limit'] ?> grams concentrates </span>
  
  </div>
  <div class="col-md-5">
  <span class="emplo-font1"> Consumer Total Daily Limit tch</span>
  <div class="clearfix"></div>
  <span class="emplo-font2"> <?= $check_limit['daily_tch_limit'] ?> thc </span>
  
  </div>
  </div>



  <div class="row grybox" style="max-width:99% !important; padding:1%;display: -webkit-box; min-height:200px; ">
  
  
   <div class="clearfix" style="display: -webkit-box;"></div>
  
   <div class="row" style="max-width:99% !important; padding:1%; display: -webkit-box; margin:0;  ">
    
    <div class="col-md-7">
	<form name="search_form" action="index.php?action=customer_list_no_pos" method="post" autocomplete="off">
	<div class="input-group">
																	<input name="search_name" id="search_name" type="text" class="form-control search-query" placeholder="search for someone"  style="padding:25px; background:#edf9f5; color:#215b5d; font-size:20px;" value="<?php if(isset($_REQUEST['search_name'])) echo $_REQUEST['search_name'] ?>" onkeyup="showResult(this.value)">
																	<div id="livesearch"></div>
																	<span class="input-group-btn" style="vertical-align:top;">
																	<input type="hidden" name="Search">
																	<img src="images/search-icon.jpg" alt="" onClick="javascript: search_form.submit();" style="cursor:pointer"/> </span>
																	
																</div></form> </div>
                                                                
                                                                <div class="col-md-2">
																<form name="frmOrder" id="frmOrder" action="index.php?action=customer_list_no_pos" method="post">
																<select id="order_by" name="order_by" class="form-control" id="form-field-select-1"  style="border:solid 4px #1dc19c;color:#1dc19c;height: 51px; text-transform:uppercase; font-weight:bold;" onchange="javascript: form.submit();">
																<option value="default" >Default</option>
																<option value="recent" <?php if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == "recent") { echo "SELECTED";} ?>>Recent</option>
                                                                <option value="cname_asc" <?php if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == "cname_asc") { echo "SELECTED";} ?>>A-Z</option>
																<option value="cname_desc" <?php if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == "cname_desc") { echo "SELECTED";} ?>>Z-A</option>
																</select>
																</form>
																</div>
                                                            
                                                            <div class="col-md-3"><a href="index.php?action=add_customer_no_pos" style="float:right;"> <img src="images/plus.jpg" width= alt=""/> </a></div>
    
    </div>
  
  </div>
 <div class="" style="display: -webkit-box; width:97%; position:relative; margin:-80px auto 0 auto;">
  <table cellpadding="0" cellspacing="0"  align="center" class="table">
    <tr>
	 <th class="stat">Id</th>  
      <th class="stat">Name</th>
      <th class="stat">Email</th>
      <th class="stat">Driver License Mag Stripe Data</th>
	  <th class="stat">Driver License Bar Code Data</th>
	  <th class="stat">Driver Licnese Data Stripped</th>
	  <th class="stat">Total Daily Limit GM</th>
      <th class="stat">Daily Limit Used GM</th>    
	  <th class="value"></th>
    </tr>
    <?php	
 function short($in){
	 $out = strlen($in) > 20 ? substr($in,0,20)."..." : $in;
	 return $out;
 }	
	$query=mysql_query("SELECT * FROM `tbl_customers_no_pos` WHERE customer_id = '".$_SESSION['user_id']."' $where $orderBy");
	$cnt=0;
	while($data=mysql_fetch_array($query))
	{	
	$cnt++;	
	?>
    <tr>
	  <td class="stat"><em> <?php echo $cnt; ?></em></td>
	  <td class="stat"><? echo $data['ConsumerName'];?></td>      
	  <td class="stat"><? echo $data['email'];?></td>      
	  <td class="stat"><em><?php echo short($data['ConsumerDriverLicenseMagStripeData']) ?></em></td> 
	  <td class="stat"><em><?php echo short($data['ConsumerDriverLicenseBarCodeData']) ?></em></td> 
	  <td class="stat"><em><?php echo short($data['ConsumerDriverLicneseDataStripped']); ?></em></td> 
	  <td class="stat"><em><?php echo $data['ConsumerTotalDailyLimitGM']; ?></em></td> 
      <td class="stat"><em><?php echo $data['ConsumerDailyLimitUsedGM']; ?></em></td>  	  
      <td> <a href="index.php?action=edit_customer_no_pos&id=<?=$data['id'];?>"><img src="images/edit-icon.jpg" width="30"  alt=""/></a></td>
    </tr>
    <?php
	}
	?>
  </table>
</div>
</div>
