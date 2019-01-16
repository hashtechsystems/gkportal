<?
session_start();
ob_start();
include("DatabaseControl/dbConnect.php");
#echo "Select * From admin Where username='$_REQUEST[Username]' And password='$_REQUEST[Password]'";

$sql=mysql_query("SELECT * FROM tbl_customers WHERE username='$_REQUEST[Username]' AND password='$_REQUEST[Password]'");
$num=mysql_num_rows($sql);

if($num==0)
{
	header("Location:login.php?wrong=1");
}
else
{
	$data=mysql_fetch_array($sql);
	$_SESSION['Username']=$_REQUEST['Username'];
	if($_REQUEST['Username']=="sadmin")
	{	
		$_SESSION['sadmin']=1;
		$_SESSION['islogin']=1;
	
	}
	else
	{
		$_SESSION['user_id']=$data['id'];
		$_SESSION['AssignedPOS']=$data['pos_assigned'];
		#exit();
		$_SESSION['islogin']=1;
	}
	header("Location:index.php?action=dashboard");
}

?>