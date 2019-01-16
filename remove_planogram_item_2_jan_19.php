<?php
ob_start();
include('DatabaseControl/dbConnect.php');

$row = '';
$col = '';
$rcSql = mysql_query("SELECT location FROM tbl_planogram WHERE `terminal_id`='".$_REQUEST['id']."' AND product_id='".$_REQUEST['pid']."'");
if(mysql_num_rows($rcSql) > 0){
	$rcRow = mysql_fetch_assoc($rcSql);
	$loc = $rcRow['location'];
	list($rw,$cl) = explode('_',$loc);
	if($row == ''){
		$row = $rw;
	}
	else{
		$row .= ",$rw";
	}
	
	if($col == ''){
		$col = $cl;
	}
	else{
		$col .= ",$cl";
	}
}
$posSql = mysql_query("SELECT c.pos_assigned FROM tbl_customers c INNER JOIN tbl_terminal t ON t.customer_id = c.id WHERE t.id = '".mysql_real_escape_string($_REQUEST['id'])."'");
$posRow = mysql_fetch_assoc($posSql);
$pos = $posRow['pos_assigned'];
if($pos == 'MJ Freeway'){
	mysql_query("UPDATE `mj_freeway_products` SET `row`='$row',`col`='$col' WHERE id='".mysql_real_escape_string($_REQUEST['pid'])."'");
}

if($pos == 'No Pos'){
	mysql_query("UPDATE `tbl_products` SET `row`='$row',`col`='$col' WHERE product_id='".mysql_real_escape_string($_REQUEST['pid'])."'");	
}

if($pos == 'Treez'){
	mysql_query("UPDATE `tbl_products_treez` SET `row`='$row',`col`='$col' WHERE pid='".mysql_real_escape_string($_REQUEST['pid'])."'");	
}

mysql_query("DELETE FROM `tbl_planogram` WHERE `terminal_id`='".$_REQUEST['id']."' AND product_id='".$_REQUEST['pid']."' AND location='".$_REQUEST['location']."'");

echo "<script type='text/javascript'>document.location.href='index.php?action=update_planogram&id=".$_REQUEST['id']."';</script>";

?>