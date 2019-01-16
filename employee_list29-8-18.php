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
	if(trim($_REQUEST['search_name'])!="")
	{
		list($first_name, $last_name) = explode(" ",trim($_REQUEST['search_name']));
	
		if(!empty($last_name)){
			$where .= " AND LOWER(first_name) LIKE '%".mysql_real_escape_string(strtolower(trim($first_name)))."%' OR LOWER(last_name) LIKE '%".mysql_real_escape_string(strtolower(trim($last_name)))."%' "; 
		}
		else{
			$where .= " AND LOWER(first_name) LIKE '%".mysql_real_escape_string(strtolower(trim($first_name)))."%' OR LOWER(last_name) = '%".mysql_real_escape_string(strtolower(trim($first_name)))."%' "; 
		}
	
	}
}

$orderBy = " ORDER BY id DESC";
if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] != 'default')
{
	if($_REQUEST['order_by'] == 'recent'){
		$orderBy=" ORDER BY id DESC";
	}
	elseif($_REQUEST['order_by'] == 'ename_asc'){
		$orderBy=" ORDER BY first_name ASC";
	}
	elseif($_REQUEST['order_by'] == 'ename_desc'){
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
  xmlhttp.open("GET","searchEmployee.php?q="+str,true);
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
<div class="row grybox" style="max-width:99% !important; padding:1%;display: -webkit-box; ">
  
  
   <div class="clearfix" style="display: -webkit-box;"></div>
  
   <div class="row" style="max-width:99% !important; padding:1%; display: -webkit-box; margin:0;  ">
    
    <div class="col-md-7">
	<form name="search_form" action="index.php?action=employee_list" method="post" autocomplete="off">
	<div class="input-group">
																	

																	<input name="search_name" id="search_name" type="text" class="form-control search-query" placeholder="search for someone"  style="padding:25px; background:#edf9f5; color:#215b5d; font-size:20px;" value="<?php if(isset($_REQUEST['search_name'])) echo $_REQUEST['search_name'] ?>" onkeyup="showResult(this.value)">
																	<div id="livesearch"></div>
																	<span class="input-group-btn" style="vertical-align:top;">
																	<input type="hidden" name="Search">
																	<img src="images/search-icon.jpg" alt="" onClick="javascript: search_form.submit();" style="cursor:pointer"/> </span>
																</div></form></div>
                                                                
                                                                <div class="col-md-2">
																<form name="sortForm" id="sortForm" action="index.php?action=employee_list" method="post">
																<select id="order_by" name="order_by" class="form-control" id="form-field-select-1"  style="border:solid 4px #1dc19c;color:#1dc19c;height: 51px; text-transform:uppercase; font-weight:bold;" onchange="javascript: sortForm.submit();">
																<option value="default" >Default</option>
																<option value="recent" <?php if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == "recent") { echo "SELECTED";} ?>>Recent</option>
                                                                <option value="ename_asc" <?php if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == "ename_asc") { echo "SELECTED";} ?>>A-Z</option>
																<option value="ename_desc" <?php if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == "ename_desc") { echo "SELECTED";} ?>>Z-A</option>		
															</select>
															</form>
															</div>
                                                            
                                                            <div class="col-md-3"><a href="index.php?action=add_employee" style="float:right;"> <img src="images/plus.jpg" width= alt=""/> </a></div>
    
    </div>
  
  </div>
  
  <div class="" style="display: -webkit-box; width:97%; position:relative; margin-top:; margin:-30px auto 0 auto;">
  <table cellpadding="0" cellspacing="0"  align="center" class="table ">
    <tr>
      <th class="stat">Id</th>
      <th class="stat">Name</th>
      <th class="stat">Email</th>
      <th class="stat">Birth Date</th>     
      <th class="value">&nbsp;</th>
    </tr>
    <?php	
	$query=mysql_query("SELECT * FROM `tbl_emploee` WHERE customer_id = '".$_SESSION['user_id']."' $where $orderBy");
	$cnt=0;
	while($data=mysql_fetch_array($query))
	{	
	$cnt++;	
	?>
    <tr>
	  <td class="stat"><em> <?php echo $cnt; ?></em></td>
	  <td class="stat"><em><?php echo $data['first_name']." ".$data['last_name']; ?></em></td> 
      <td class="stat"><em><?php echo $data['email_address']; ?></em></td>
      <td class="stat"><em><?php echo $data['birth_date'];?></em></td>      
      <td> <a href="index.php?action=edit_employee&id=<?=$data['id'];?>"><img src="images/edit-icon.jpg" width="30"  alt=""/></a></td>
    </tr>
    <?php
	}
	?>
  </table>
  </div>
</div>
