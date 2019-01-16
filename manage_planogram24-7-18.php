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
?>

<div class="" id="container" style="margin-top:20px;">
  <div class="page-header">
    <h1> Manage Planogram </h1>
  </div>
  
  <table cellpadding="5" cellspacing="5" width="90%" align="center" class="table table-bordered">
    <tr>
      <th class="stat">Id</th>
      <th class="stat">Terminal Id</th>
      <th class="stat">Planogram Metrix</th>
      <th class="value">Action</th>
    </tr>
    <?php	
	$query=mysql_query("SELECT id, terminal_id, planogram FROM `tbl_terminal` WHERE customer_id = ".$_SESSION['user_id']);
	$cnt=0;
	while($data=mysql_fetch_array($query))
	{	
	$cnt++;	
	?>
    <tr>
	  <td class="stat"><em> <?php echo $cnt; ?></em></td>
	  <td class="stat"><em><?php echo $data['terminal_id']; ?></em></td> 
      <td class="stat"><em><?php echo $data['planogram']; ?></em></td>   
      <td> <a href="index.php?action=update_planogram&id=<?=$data['id'];?>">Update Planogram</a></td>
    </tr>
    <?php
	}
	?>
  </table>
</div>
