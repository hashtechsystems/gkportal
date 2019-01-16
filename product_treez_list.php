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



if(isset($_REQUEST['del_product'])){

	$check = mysql_query("SELECT pl.id FROM tbl_planogram pl INNER JOIN tbl_terminal t ON t.id = pl.terminal_id INNER JOIN  tbl_customers c ON c.id = t.customer_id WHERE c.pos_assigned = 'Treez' AND pl.product_id = '".mysql_real_escape_string($_REQUEST['del_product'])."'");

	if(mysql_num_rows($check) > 0){

		echo "<script>alert('This product is assigned to planogram. Please remove from planogram then delete from here')</script>";

	}

	else{

		mysql_query("UPDATE tbl_products_treez SET isDeleted = '1' WHERE pid = '".mysql_real_escape_string($_REQUEST['del_product'])."'");

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



$orderBy = " ORDER BY pid ASC";

if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] != 'default')

{

	if($_REQUEST['order_by'] == 'recent'){

		$orderBy=" ORDER BY pid DESC";

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

  xmlhttp.open("GET","searchProduct_treez.php?q="+str,true);

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



<div class="" id="" style="margin-top:20px;">

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

	</div>

	</form>

	</div>

                                                                

	<div class="col-md-2">

	<form name="sortForm" id="sortForm" action="" method="post">

	<select id="order_by" name="order_by" class="form-control" id="form-field-select-1"  style="border:solid 4px #1dc19c;color:#1dc19c;height: 51px; text-transform:uppercase; font-weight:bold;" onchange="javascript: sortForm.submit();">

	<option value="default">Default</option>

	<option value="recent" <?php if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == "recent") { echo "SELECTED";} ?>>Recent</option>

	<option value="prname_asc" <?php if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == "prname_asc") { echo "SELECTED";} ?>>A - Z</option>

	<option value="prname_desc" <?php if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == "prname_desc") { echo "SELECTED";} ?>>Z - A</option>

	</select>

	</form>

	</div>

    <div class="col-md-1">

	<form method="POST" action="download_product_treez_list.php">

	 <input type="submit" name="downloadExcel" class="search" value="Excel" />

	  </form>

	</div>                                                     

     <div class="col-md-1">

	<form method="POST" action="UpdateProduct_Treez.php">

	 <input type="submit" name="UpdateProduct" class="search" value="Update Product" />

	  </form>

	</div>                                                   

    

    </div>

  

  </div>

  

  

   <div class="" style="display: -webkit-box; width:97%; position:relative; margin:-50px auto 0 auto;overflow-x:scroll">

  <table cellpadding="" cellspacing="" width="100%" align="center" class="table">

    <tr>

      <th class="stat">Id</th>  

      <th class="stat">Image</th>

      <th class="stat">Name</th>
<!--
      <th class="stat">Row</th>

	  <th class="stat">Col</th>
-->
	  <th class="stat">Location</th>
	  
	  <th class="stat">Category</th>

      <th class="stat">Strain Name</th> 

	  <th class="stat">Product Price</th> 

	 <th class="stat">Live Quantity</th> 
	 
	 <th class="stat">GK Quantity</th> 
<!--
	  <th class="stat">Discount</th> 
-->
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
	$query=mysql_query("SELECT * FROM `tbl_products_treez` WHERE isDeleted = 0 $orderBy");

	$cnt=0;

	while($data=mysql_fetch_array($query))

	{	

	$cnt++;	

	?>

    <tr>

	  <td class="stat"><?php echo $cnt; ?></td>

	  <td class="stat"><em><? if( $data['orignal_image']!=""){ ?> <img src="product_images/<?php echo $data['orignal_image'];?>" height="50" /> <? } ?></em></td>      

	  <td class="stat"><?php echo $data['product_name']; ?></td> 
<?php
		$location = '';
		$locSql = mysql_query("SELECT p.location FROM tbl_planogram p INNER JOIN tbl_terminal t ON t.id = p.terminal_id WHERE t.customer_id = '".$_SESSION['user_id']."' AND p.product_id = '".$data['pid']."'");
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
	
	  <td class="stat"><?php echo $data['product_type']; ?></td> 

	  <td class="stat"><em><?php echo $data['strain_name'];?></em></td>

	   <td class="stat"><em><?php echo $data['default_price']; if($data['default_price']!=""){ echo "$"; }?></em></td>      

	 <td class="stat"><em><?php echo $data['live_inventory_quantity'];?></em></td> 
	 
	 <td class="stat"><em><?php echo $data['gk_inventory_quantity'];?></em></td> 
<!--
	  <td class="stat"><em><?php echo $data['discount'];?></em></td>      
-->
	  <td class="stat"><em><?php echo $data['gm'];?></em></td>      

	  <td class="stat"><em><?php echo $data['ounce'];?></em></td>      

	  <td class="stat"><em><?php echo $data['thc_percentage'];?></em></td>

	 <td class="stat" style="text-align:center;"><?= ($data['featured'] == 1)? 'Y' : 'N' ?></td> 

	  <td class="stat" style="text-align:center;"><?= ($data['new'] == 1)? 'Y' : 'N' ?></td>

	  <td class="stat" style="text-align:center;"><?= ($data['popular'] == 1)? 'Y' : 'N' ?></td>

       <td> <a href="index.php?action=edit_treez_product&id=<?=$data['pid'];?>"><img src="images/edit-icon.jpg" width="30"  alt=""/></a></td>

	   <td>

	     <input type="button" class="search" value="Delete" onclick="ConfirmDelete(<?=$data['pid'];?>)"/>

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