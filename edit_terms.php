<?
ob_start();
$terminal = mysql_fetch_array(mysql_query("SELECT terminal_id FROM `tbl_terminal` WHERE `id`='".mysql_real_escape_string($_REQUEST['tid'])."'"));
$terminal_id = $terminal['terminal_id'];
if($_REQUEST['submit'])
{
	$Error = 0;
	$title= $_REQUEST['title'];
	$terms= $_REQUEST['terms'];
		
	if($title == ''){
		$Error = 1;
		$Err_title = 'Please enter the title.';
	}
	
	if($terms == ''){
		$Error = 1;
		$Err_terms = 'Please enter the terms.';
	}
	
		
	if($Error == 0)
	{
		$update_terms = mysql_query("UPDATE `tbl_terms` SET `title`='".mysql_real_escape_string($title)."',`terms`='".mysql_real_escape_string($terms)."' WHERE terminal_id='".$terminal_id."'");

		if(mysql_affected_rows($update_terms) == 0){
			mysql_query("INSERT INTO `tbl_terms` (terminal_id, title, terms) VALUES ('".$terminal_id."', '".mysql_real_escape_string($title)."','".mysql_real_escape_string($terms)."')");
		}
		
		echo "<script> document.location.href='index.php?action=customers_list'</script>";		
	}
}
$data=mysql_fetch_array(mysql_query("SELECT * FROM `tbl_terms` WHERE `terminal_id`='".$terminal_id."'"));
?>

<div class="page-header tbg2 heauto" style="margin-top:20px;">
  <div class="col-md-8 p40">
  <h1> Edit Terms For Terminal Id - <?= $terminal_id ?></h1>
  </div>
   <div class="col-md-4 textleft" style="text-align:right;"> <a href="index.php?action=customers_list" class="greenbtn1">Previous Page</a> </div>
</div>
<form action="" name="kiosk"  method="post"  enctype="multipart/form-data">
<div class="col-md-8">
                 
                              <div class="w100">
                                <div class="col-md-12"> <label class="flebal"> Title </label></div>
                                <div class="col-md-12">
									<input class="textbox6" type="text" name="title" value="<?=$data['title'];?>">
									<?php if(isset($Err_title) && $Err_title != "") { echo "<span style='color: #ff0000;'>".$Err_title."</span>";}?>
                                </div>
                              </div>
							  
							  <div class="clearfix gap1"> </div>
							  <div class="w100">
                                <div class="col-md-12"> <label class="flebal"> Terms </label></div>
                                <div class="col-md-12">
									<textarea rows="10" class="textbox6" name="terms" ><?=$data['terms'];?></textarea>
									<?php if(isset($Err_terms) && $Err_terms != "") { echo "<span style='color: #ff0000;'>".$Err_terms."</span>";}?>
                                </div>
                              </div>
							  
							  <div class="clearfix gap1"> </div>
							  <div class="w100">
                                <div class="col-md-12 p40"><input id="cmdCheck" name="submit" value="Update" type="submit" class="greenbtn2"/>
                                  &nbsp;&nbsp;<a href="index.php?action=customers_list" >
                                  <input type="button" value="Cancel" class="greenbtn2"/>
                                  </a>
								  </div>
                              </div>
</div>					  
  </form>
