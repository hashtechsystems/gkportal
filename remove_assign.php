<?php
ob_start();
error_reporting(E_ALL);
mysql_query("DELETE FROM `tbl_assigned_products` WHERE `id`='".$_REQUEST['id']."'");
echo '<script type="text/javascript">document.location.href="index.php?action=assigned_products"</script>';
?>