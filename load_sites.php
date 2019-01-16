<?
include('DatabaseControl/dbConnect.php');
?>
<table cellpadding="0" cellspacing="0" align="center" width="100%">
  <tr>
    <td width="410" align="left" class="form-t"><span style="color:#F00;">*</span>&nbsp;Site</td>
    <td width="21">:</td>
    <td width="625" height="40" align="left" class="textbox-bg2"><select name="site" id="site">
        <? 
		$query=mysql_query("SELECT * FROM `tbl_sites` WHERE `account_id`='".$_REQUEST['account_id']."'");
		while($data=mysql_fetch_array($query))
		{
			?>
            <option value="<?=$data['id'];?>">
            <?=$data['name'];?>
            </option>
            <?
		}
		?>
      </select></td>
  </tr>
</table>
