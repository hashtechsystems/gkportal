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
/*
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
*/
?>
<!--
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
-->
<div class="" id="container" style="margin-top:20px;">
<div class="row " style="display: -webkit-box; ">
<!--
   <div class="clearfix" style="display: -webkit-box;"></div>
  
   <div class="row" style="max-width:99% !important; padding:1%; display: -webkit-box; margin:0;  ">
    
    <div class="col-md-7">
	<form name="search_form" action="index.php?action=product_list" method="post" autocomplete="off">
	<div class="input-group">
																	

																	<input name="search_name" id="search_name" type="text" class="form-control search-query" placeholder="search for someone"  style="padding:25px; background:#edf9f5; color:#215b5d; font-size:20px;" value="<?php if(isset($_REQUEST['search_name'])) echo $_REQUEST['search_name'] ?>" onkeyup="showResult(this.value)">
																	<div id="livesearch"></div>
																	<span class="input-group-btn" style="vertical-align:top;">
																	<input type="hidden" name="Search">
																	<img src="images/search-icon.jpg" alt="" onClick="javascript: search_form.submit();"  /> </span>
																</div></form></div>
                                                                
                                                                <div class="col-md-2">
																<form name="frmOrder" id="frmOrder" action="index.php?action=product_list" method="post">
																<select id="order_by" name="order_by" class="form-control" id="form-field-select-1"  style="border:solid 4px #1dc19c;color:#1dc19c;height: 51px; text-transform:uppercase; font-weight:bold;" onchange="javascript: form.submit();">
																<option value="default" >Default</option>
																<option value="recent" <?php if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == "recent") { echo "SELECTED";} ?>>Recent</option>
                                                                <option value="prname_asc" <?php if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == "prname_asc") { echo "SELECTED";} ?>>A-Z</option>
																<option value="prname_desc" <?php if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == "prname_desc") { echo "SELECTED";} ?>>Z-A</option>
															</select>
															</form>
															</div>
                                                      
                                                            <div class="col-md-3"><a href="index.php?action=add_screen" style="float:right;"> <img src="images/plus.jpg" width= alt=""/> </a></div>
    
    </div>
 --> 
  </div>
 <div class="rwebkit tpos" style="display: -webkit-box; width:100%; position:relative; margin-top:; margin:auto;">
  <table cellpadding="0" cellspacing="0"  align="center" class="table " width="100%">
    <tr class="tbg">
	 <th class="stat">Id</th>  
      <th class="stat">Terminal Id</th>
      <th class="stat">Screen Image</th> 
	  <th class="stat">Screen Video</th>
      <th class="value">Action</th>
    </tr>
    <?php	
	$query=mysql_query("SELECT * FROM `tbl_terminal` WHERE customer_id = ".$_SESSION['user_id']);
	$cnt=0;
	while($data=mysql_fetch_array($query))
	{	
	$cnt++;	
	?>
    <tr style="border-bottom:solid 1px #ccc;">
	  <td class="stat"> <?php echo $cnt; ?></td>
	  <td class="stat"><?php echo $data['terminal_id']; ?></td> 
	  <td class="stat"><? if( $data['screenImage']!=""){ ?> <img src="<?php echo $data['screenImage'];?>" height="70" /> <? } ?></td>   	  
      <td><? if( $data['screenVideo']!=""){ ?>
		<video width="320" height="240" controls>
			<source src="<?php echo $data['screenVideo'];?>" type="video/mp4">
	   </video> 
	  <? } ?></td>
	  <td> <a href="index.php?action=edit_screen&id=<?=$data['id'];?>"><img src="images/edit-icon.jpg" width="30"  alt=""/></a></td>
    </tr>
    <?php
	}
	?>
  </table>
</div>
</div>

