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

if(isset($_REQUEST['del_product'])){
	$check = mysql_query("SELECT pl.id FROM tbl_planogram pl INNER JOIN tbl_terminal t ON t.id = pl.terminal_id INNER JOIN  tbl_customers c ON c.id = t.customer_id WHERE c.pos_assigned = 'No Pos' AND pl.product_id = '".mysql_real_escape_string($_REQUEST['del_product'])."'");
	if(mysql_num_rows($check) > 0){
		echo "<script>alert('This product is assigned to planogram. Please remove from planogram then delete from here')</script>";
	}
	else{
		mysql_query("UPDATE tbl_products SET isDeleted = '1' WHERE product_id = '".mysql_real_escape_string($_REQUEST['del_product'])."'");
	}
}

$where = "";
if(isset($_REQUEST['Search']))
{
	if($_REQUEST['search_name']!="")
	{
		$name = $_REQUEST['search_name'];
		$where .= " AND LOWER(product_name) LIKE '%".mysql_real_escape_string(strtolower(trim($name)))."%'"; 
	}
}

$orderBy = " ORDER BY product_id DESC";
if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] != 'default')
{
	if($_REQUEST['order_by'] == 'recent'){
		$orderBy=" ORDER BY product_id DESC";
	}
	elseif($_REQUEST['order_by'] == 'prname_asc'){
		$orderBy=" ORDER BY product_name ASC";
	}
	elseif($_REQUEST['order_by'] == 'prname_desc'){
		$orderBy=" ORDER BY product_name DESC";
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
  xmlhttp.open("GET","searchProduct_nopos.php?q="+str,true);
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
<div class="" style="max-width:100% !important; display: -webkit-box; ">
  
  
   <div class="clearfix" style="display: -webkit-box;"></div>
  
   <div class="row rwebkit" style="width:100% !important; display: -webkit-box; margin:0;  ">
    
    <div class="col-md-7 b20">
	<form name="search_form" action="index.php?action=product_list" method="post" autocomplete="off">
	<div class="input-group">
																	

																	<input name="search_name" id="search_name" type="text" class="form-control search-query" placeholder="search for someone"  style="padding:25px; background:#edf9f5; color:#215b5d; font-size:20px;" value="<?php if(isset($_REQUEST['search_name'])) echo $_REQUEST['search_name'] ?>" onkeyup="showResult(this.value)">
																	<div id="livesearch"></div>
																	<span class="input-group-btn" style="vertical-align:top;">
																	<input type="hidden" name="Search">
																	<img src="images/search-icon.jpg" alt="" onClick="javascript: search_form.submit();"  /> </span>
																</div></form></div>
                                                                
                                                                <div class="col-md-3 b20">
																<form name="frmOrder" id="frmOrder" action="index.php?action=product_list" method="post">
																<select id="order_by form-field-select-1" name="order_by" class="form-control"   style="border:solid 4px #1dc19c;color:#1dc19c;height: 51px; text-transform:uppercase; font-weight:bold;" onchange="javascript: form.submit();">
																<option value="default" >Default</option>
																<option value="recent" <?php if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == "recent") { echo "SELECTED";} ?>>Recent</option>
                                                                <option value="prname_asc" <?php if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == "prname_asc") { echo "SELECTED";} ?>>A-Z</option>
																<option value="prname_desc" <?php if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == "prname_desc") { echo "SELECTED";} ?>>Z-A</option>
															</select>
															</form>
															</div>
                                                            
                                                            <div class="col-md-1"><a href="index.php?action=add_product" style="float:right;"> <img src="images/plus.jpg" width= alt=""/> </a></div>
															<div class="col-md-1">
															<form method="POST" action="download_product_list.php">
															 <input type="submit" name="downloadExcel" class="search" value="Excel" />
															  </form>
															</div>
    
    </div>
  
  </div>
 <div class="tpos" style="display: -webkit-box; width:100%; position:relative; margin-top:; margin:;">
  <table cellpadding="0" cellspacing="0"  align="center" class="table " width="100%">
    <tr class="tbg">
	 <th class="stat">Id</th>  
      <th class="stat">Image</th>
      <th class="stat">Name</th>
 <!--   
		<th class="stat">Row</th>
	  <th class="stat">Column</th>
-->
	  <th class="stat">Location</th>
	  <th class="stat">Live Quantity</th> 
	 <th class="stat">GK Quantity</th> 
	  <th class="stat">Category</th>
	  <th class="stat">Strain Name</th>
      <th class="stat">Price</th>
	  <th class="stat">Featured</th> 
	  <th class="stat">New</th> 
	  <th class="stat">Popular</th> 
      <th class="value">Action</th>
	  <th class="value">Delete</th>
    </tr>
    <?php	
	$query=mysql_query("SELECT * FROM `tbl_products` WHERE customer_id = ".$_SESSION['user_id']." AND isDeleted = 0 $where $orderBy");
	$cnt=0;
	while($data=mysql_fetch_array($query))
	{	
	$cnt++;	
	?>
    <tr style="border-bottom:solid 1px #ccc;">
	  <td class="stat"> <?php echo $cnt; ?></td>
	  <td class="stat"><? if( $data['product_img']!=""){ ?> <img src="<?php echo $data['product_img'];?>" height="70" /> <? } ?></td>      
	  <td class="stat"><?php echo $data['product_name']; ?></td> 
<?php
		$location = '';
		$locSql = mysql_query("SELECT p.location FROM tbl_planogram p INNER JOIN tbl_terminal t ON t.id = p.terminal_id WHERE t.customer_id = '".$_SESSION['user_id']."' AND p.product_id = '".$data['product_id']."'");
		if(mysql_num_rows($locSql) > 0){
			while($locrw = mysql_fetch_assoc($locSql)){
				if($location == ''){
					$location = $locrw['location'];
				}
				else{
					$location .= ','.$locrw['location'];
				}
			}
		}
?>
<!--
      <td class="stat"><?php echo $data['row']; ?></td>
	  <td class="stat"><?php echo $data['col']; ?></td>
-->
	  <td class="stat"><?php echo $location; ?></td>
	  <td class="stat"><?php echo $data['live_inventory_quantity']; ?></td>
	  <td class="stat"><?php echo $data['gk_inventory_quantity']; ?></td>  
	  <td class="stat"><?php echo $data['product_category']; ?></td>
	  <td class="stat"><?php echo $data['strain_name']; ?></td>
      <td class="stat">$<?php echo $data['price'];?></td>
	  <td class="stat" style="text-align:center;"><?= ($data['featured'] == 1)? 'Y' : 'N' ?></td> 
	  <td class="stat" style="text-align:center;"><?= ($data['new'] == 1)? 'Y' : 'N' ?></td>
	  <td class="stat" style="text-align:center;"><?= ($data['popular'] == 1)? 'Y' : 'N' ?></td>
      <td style="text-align:right;"> <a href="index.php?action=edit_product&id=<?=$data['product_id'];?>"><img src="images/edit-icon.jpg" width="30"  alt=""/></a></td>
	  <td>
	     <input type="button" class="search" value="Delete" onclick="ConfirmDelete(<?=$data['product_id'];?>)"/>
	 </td>
    </tr>
    <?php
	}
	?>
  </table>
</div>
</div>
<script>
function ConfirmDelete(id)
{
  var x = confirm("Are you sure you want to delete?");
  if(x){
	  $('<form method="post"><input type="hidden" name="del_product" value="'+id+'"></form>').appendTo('body').submit().remove();
  }    
  else
    return false;
}
</script>

