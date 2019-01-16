<?php 
session_start();
if($_SESSION['islogin']=="")
{
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
    <h1> Consumers </h1>
  </div>
  <table cellpadding="5" cellspacing="5" width="90%" align="center" class="table table-bordered">
    <tr>
      <th class="stat">Id</th>
      <th class="stat">Consumer Name</th>
      <th class="stat">Email</th>
      <th class="stat">Gender</th>
      <th class="stat">Birth date</th>
      <th class="stat">Active</th>
      <th class="stat">Total Points</th>
      <th class="stat">Total Orders</th>
      <th class="stat">Total Spent</th>
      <th class="value">Action</th>
    </tr>
    <?php	
	$query=mysql_query("SELECT consumer_id, first_name, middle_name, last_name, email_address, gender, birth_date, active, total_points, total_orders, total_spent FROM `tbl_consumer_mjfreeway` ORDER BY cid DESC");
	$cnt=0;
	while($data=mysql_fetch_array($query))
	{	
	$cnt++;	
	?>
    <tr>
      <td class="stat"><?php echo $cnt; ?></td>
      <td class="stat"><?php echo $data['first_name']." ".$data['last_name']; ?></td>
      <td class="stat"><?php echo $data['email_address']; ?></td>
      <td class="stat"><?php echo $data['gender']; ?></td>
      <td class="stat"><?php echo $data['birth_date']; ?></td>
      <td class="stat"><?php echo $data['active']; ?></td>
      <td class="stat"><?php echo $data['total_points']; ?></td>
      <td class="stat"><?php echo $data['total_orders']; ?></td>
      <td class="stat"><?php echo $data['total_spent']; ?></td>
      <td><a href="index.php?action=consumer_list_mjfreeway_detail&id=<?=$data['consumer_id'];?>">View Detail</a></td>
    </tr>
    <?php
	}
	?>
  </table>
</div>
