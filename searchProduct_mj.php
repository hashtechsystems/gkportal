
<?php
//get the q parameter from URL
$q=trim($_GET["q"]);

//lookup all links from the xml file if length of q>0
if (strlen($q)>0) {
  $hint="";
  require_once('DatabaseControl/dbConnect.php');
  $sql = mysql_query("SELECT name FROM `mj_freeway_products` WHERE LOWER(name) LIKE '%".mysql_real_escape_string(strtolower($q))."%'");
  if(mysql_num_rows($sql) > 0){
	 while($row = mysql_fetch_array($sql)){
		if($hint == ''){
			$hint = "<span class='search_ele' onclick='addInSearch(this)'>".$row['name']."</span>";
		}
		else{
			$hint .= "<br><span class='search_ele' onclick='addInSearch(this)'>".$row['name']."</span>";
		}
	 } 
  }
}

// Set output to "no suggestion" if no hint was found
// or to the correct values
if ($hint=="") {
  $response="no suggestion";
} else {
  $response=$hint;
}

//output the response
echo $response;
?> 