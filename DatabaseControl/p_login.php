<?
session_start();
ob_start();
$shost=$_SERVER['HTTP_HOST'];
include("DatabaseControl/dbConnect.php");
//echo "Select * From admin Where username='$_REQUEST[Username]' And password='$_REQUEST[Password]'";
$sql=mysql_query("SELECT * FROM User WHERE username='$_REQUEST[Username]' AND password='$_REQUEST[Password]' and site like '$shost'");
$num=mysql_num_rows($sql);

if($num==0)
{
	header("Location:login.php?wrong=1");
}
else
{
	$_SESSION['islogin']=1;
	if($_REQUEST['Username']=="cadmin")
	{
		$_SESSION['userType']="cadmin";	
	}
	else
	if($_REQUEST['Username']=="admin1")
	{
		$_SESSION['userType']="admin1";	
	}
	else
	if($_REQUEST['Username']=="admin2")
	{
		$_SESSION['userType']="admin2";	
	}
	else
	{
		$_SESSION['userType']="normal";	
	}
	
	header("Location:index.php");
}

?>