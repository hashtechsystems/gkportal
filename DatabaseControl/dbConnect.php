<?php 
error_reporting(0);
$con=mysql_connect("portaldb.ckookwbkwle5.us-east-2.rds.amazonaws.com:3306","portaldbuser","wDPgpRmG3ZjTLFPq");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}
else
{

$db=mysql_select_db("grasshopper_new",$con);
if($db!="")
{
	#echo "Success";
}
else
{
	#echo "Error";
}
}
?>
