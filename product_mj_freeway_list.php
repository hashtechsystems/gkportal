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
	$check = mysql_query("SELECT pl.id FROM tbl_planogram pl INNER JOIN tbl_terminal t ON t.id = pl.terminal_id INNER JOIN  tbl_customers c ON c.id = t.customer_id WHERE c.pos_assigned = 'MJ Freeway' AND pl.product_id = '".mysql_real_escape_string($_REQUEST['del_product'])."'");
	if(mysql_num_rows($check) > 0){
		echo "<script>alert('This product is assigned to planogram. Please remove from planogram then delete from here')</script>";
	}
	else{
		mysql_query("UPDATE mj_freeway_products SET isDeleted = '1' WHERE id = '".mysql_real_escape_string($_REQUEST['del_product'])."'");
	}
}
	
$where = "";
if(isset($_REQUEST['Search']))
{
	if($_REQUEST['search_name']!="")
	{
		$name = $_REQUEST['search_name'];
		$where .= " AND LOWER(name) LIKE '%".mysql_real_escape_string(strtolower(trim($name)))."%'"; 
	}
}

$orderBy = " ORDER BY id ASC";
if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] != 'default')
{
	if($_REQUEST['order_by'] == 'recent'){
		$orderBy=" ORDER BY id DESC";
	}
	elseif($_REQUEST['order_by'] == 'prname_asc'){
		$orderBy=" ORDER BY name ASC";
	}
	elseif($_REQUEST['order_by'] == 'prname_desc'){
		$orderBy=" ORDER BY name DESC";
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
  xmlhttp.open("GET","searchProduct_mj.php?q="+str,true);
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
	<form name="search_form" action="" method="post" autocomplete="off">
	<div class="input-group">
																	

																	<input name="search_name" id="search_name" type="text" class="form-control search-query" placeholder="search for someone"  style="padding:25px; background:#edf9f5; color:#215b5d; text-transform:uppercase; font-size:20px;" value="<?php if(isset($_REQUEST['search_name'])) echo $_REQUEST['search_name'] ?>" onkeyup="showResult(this.value)">
																	<div id="livesearch"></div>
																	<span class="input-group-btn" style="vertical-align:top;">
																	<input type="hidden" name="Search">
																	<img src="images/search-icon.jpg" alt="" onClick="javascript: search_form.submit();" style="cursor:pointer"/> </span>
																</div></form></div>
                                                                
                                                                <div class="col-md-2">
																<form name="sortForm" id="sortForm" action="" method="post">
																<select id="order_by" name="order_by" class="form-control" id="form-field-select-1"  style="border:solid 4px #1dc19c;color:#1dc19c;height: 51px; text-transform:uppercase; font-weight:bold;" onchange="javascript: sortForm.submit();">
																<option value="default">Default</option>
																<option value="recent" <?php if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == "recent") { echo "SELECTED";} ?>>Recent</option>
																<option value="prname_asc" <?php if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == "prname_asc") { echo "SELECTED";} ?>>A - Z</option>
																<option value="prname_desc" <?php if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == "prname_desc") { echo "SELECTED";} ?>>Z - A</option>
															</select></form></div>
															<div class="col-md-1">
															<form method="POST" action="download_product_mj_freeway_list.php">
															 <input type="submit" name="downloadExcel" class="search" value="Excel" />
															  </form>
															</div>
															<!--
															<div class="col-md-1">
															<form method="POST" action="UpdateProduct_MJFreeWay.php">
															<input type="submit" name="UpdateProduct" class="search" value="Update Product" />
															</form>
															</div> 
															-->
                                                            
                                                           
    
    </div>
  
  </div>
  
  
  <!--<a href="index.php?action=add_employee" style="float:right; cursor:pointer; text-decoration:none; padding:4px 7px; background-color:#1473B8; color:#FFFFFF;">Add New Employee</a>-->
  
   <div class="" style="display: -webkit-box; width:97%; position:relative; margin:-50px auto 0 auto;overflow-x:scroll">
  <table cellpadding="0" cellspacing="0" width="100%" align="center" class="table">
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
	  <th class="stat">Featured</th> 
	  <th class="stat">New</th> 
	  <th class="stat">Popular</th>
      <th class="value">Action</th>
	  <th class="value">Delete</th>
    </tr>
    <?php	
	$query=mysql_query("SELECT * FROM `mj_freeway_products` WHERE isDeleted = 0 $orderBy");
	$cnt=0;
	while($data=mysql_fetch_array($query))
	{	
	$cnt++;	
	?>
    <tr>
	  <td class="stat"> <?php echo $cnt; ?></td>
	  <td class="stat"><? if( $data['orignal_image']!=""){ ?> <img src="product_images/<?php echo $data['orignal_image'];?>" height="50" /> <? } ?></td>      
	  <td class="stat"><?php echo $data['name']; ?></td> 
      <td class="stat"><?php echo $data['row'];?></td>      
	  <td class="stat"><?php echo $data['col'];?></td>      
	  <td class="stat"><?php echo $data['category_name'];?></td>      
	  <td class="stat"><?php echo $data['strain_name'];?></td>      
	  <td class="stat"><?php echo $data['default_price'];?> $</td>      
	  <td class="stat"><?php echo $data['discount'];?></td>      
	  <td class="stat"><?php echo $data['gm'];?></td>      
	  <td class="stat"><?php echo $data['ounce'];?></td>      
	  <td class="stat"><?php echo $data['thc'];?></td> 
	  <td class="stat" style="text-align:center;"><?= ($data['featured'] == 1)? 'Y' : 'N' ?></td> 
	  <td class="stat" style="text-align:center;"><?= ($data['new'] == 1)? 'Y' : 'N' ?></td>
	  <td class="stat" style="text-align:center;"><?= ($data['popular'] == 1)? 'Y' : 'N' ?></td>
      <td style="text-align:center;"> <a href="index.php?action=edit_mj_free_way_product&id=<?=$data['id'];?>"><img src="images/edit-icon.jpg" width="30"  alt=""/></a></td>
	  <td>
	     <input type="button" class="search" value="Delete" onclick="ConfirmDelete(<?=$data['id'];?>)"/>
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