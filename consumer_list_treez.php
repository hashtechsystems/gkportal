<?php 
session_start();
if($_SESSION['islogin']=="")
{
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

$where = " Where 1 ";
if(isset($_REQUEST['Search']))
{
	if($_REQUEST['search_name']!="")
	{
		list($first_name, $last_name) = explode(" ",trim($_REQUEST['search_name']));
	
		if(!empty($last_name)){
			$where .= " AND LOWER(first_name) LIKE '%".mysql_real_escape_string(strtolower(trim($first_name)))."%' OR LOWER(last_name) LIKE '%".mysql_real_escape_string(strtolower(trim($last_name)))."%' "; 
		}
		else{
			$where .= " AND LOWER(first_name) LIKE '%".mysql_real_escape_string(strtolower(trim($first_name)))."%' OR LOWER(last_name) LIKE '%".mysql_real_escape_string(strtolower(trim($first_name)))."%' "; 
		}
	
	}
}

$orderBy = " ORDER BY customer_id DESC";
if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] != 'default')
{
	if($_REQUEST['order_by'] == 'recent'){
		$orderBy=" ORDER BY customer_id DESC";
	}
	elseif($_REQUEST['order_by'] == 'cname_asc'){
		$orderBy=" ORDER BY first_name ASC";
	}
	elseif($_REQUEST['order_by'] == 'cname_desc'){
		$orderBy=" ORDER BY first_name DESC";
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
  xmlhttp.open("GET","searchConsumer_treez.php?q="+str,true);
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
  position: absolute;
 margin-top:50px;
 width:80%;
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

<div class="grybox" style="max-width:98% !important; padding:1%;display: -webkit-box; ">
  
  
   <div class="clearfix" style="display: -webkit-box;"></div>
  
   <div class="row" style="max-width:99% !important; padding:1%; display: -webkit-box; margin:0;  ">
    
    <div class="col-md-7">
	<form name="search_form" action="index.php?action=consumer_list_treez" method="post" autocomplete="off">
	<div class="input-group">
																	

																	<input name="search_name" id="search_name" type="text" class="form-control search-query" placeholder="search for someone"  style="padding:25px; background:#edf9f5; color:#215b5d; text-transform:uppercase; font-size:20px;" value="<?php if(isset($_REQUEST['search_name'])) echo $_REQUEST['search_name'] ?>" onkeyup="showResult(this.value)">
																	<div id="livesearch"></div>
																	<span class="input-group-btn" style="vertical-align:top;">
																	<input type="hidden" name="Search">
																	<img src="images/search-icon.jpg" alt="" onClick="javascript: search_form.submit();" style="cursor:pointer"/> </span>
																</div></form></div>
                                                                
                                                                <div class="col-md-2">
																<form name="sortForm" id="sortForm" action="index.php?action=consumer_list_treez" method="post">
																<select id="order_by" name="order_by" class="form-control" id="form-field-select-1"  style="border:solid 4px #1dc19c;color:#1dc19c;height: 51px; text-transform:uppercase; font-weight:bold;" onchange="javascript: sortForm.submit();">
																<option value="default">Default</option>
																<option value="recent" <?php if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == "recent") { echo "SELECTED";} ?>>Recent</option>
																<option value="cname_asc" <?php if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == "cname_asc") { echo "SELECTED";} ?>>A - Z</option>
																<option value="cname_desc" <?php if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == "cname_desc") { echo "SELECTED";} ?>>Z - A</option>
																</select>
																</form>
																</div>
                                                            
                                                           
    
    </div>
  
  </div>
   <div class="" style="display: -webkit-box; width:97%; position:relative; margin:-50px auto 0 auto;overflow: auto;">
  
  <table cellpadding="0" cellspacing="0" width="100%" align="center" class="table">
    <tr>
      <th class="stat">Id</th>
      <th class="stat">Customer Id</th>
      <th class="stat">First Name</th>
      <th class="stat">Middle Name</th>
	  <th class="stat">Last Name</th>
      <th class="stat">Birth date</th>
      <th class="stat">Drivers License</th>
      <th class="stat">Drivers License Expiration</th>
      <th class="stat">State Medical Id</th>
      <th class="stat">Email</th>
      <th class="value">Phone</th>
<!--
	  <th class="value">Phone</th>
-->
    </tr>
    <?php	
	$query=mysql_query("SELECT customer_id, first_name, middle_name, last_name, birthday, drivers_license, drivers_license_expiration, state_medical_id, email, phone FROM `tbl_customers_treez` $where $orderBy");
	$cnt=0;
	while($data=mysql_fetch_array($query))
	{	
	$cnt++;	
	?>
    <tr>
      <td class="stat"><?php echo $cnt; ?></td>
	  <td class="stat"><?php echo $data['customer_id']; ?></td>
	  <td class="stat"><?php echo $data['first_name']; ?></td>
	  <td class="stat"><?php echo $data['middle_name']; ?></td>
	  <td class="stat"><?php echo $data['last_name']; ?></td>
      <td class="stat"><?php echo $data['birthday']; ?></td>
      <td class="stat"><?php echo $data['drivers_license']; ?></td>
      <td class="stat"><?php echo $data['drivers_license_expiration']; ?></td>
      <td class="stat"><?php echo $data['state_medical_id']; ?></td>
      <td class="stat"><?php echo $data['email']; ?></td>
      <td class="stat"><?php echo $data['phone']; ?></td>
<!--
      <td><a href="index.php?action=consumer_list_mjfreeway_detail&id=<?=$data['consumer_id'];?>"><img src="images/edit-icon.jpg" width="30"  alt=""/></a></td>
-->
    </tr>
    <?php
	}
	?>
  </table>
</div>
</div>
