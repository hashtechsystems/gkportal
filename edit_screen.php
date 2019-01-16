<?
ob_start();
if($_REQUEST['submit'])
{
	$Error = 0;
	$terminal_id= $_REQUEST['terminal_id'];
	if($terminal_id == "")
	{
		$Error = 1;
		$Err_terminalId = 'Terminal Id should not be blank';
	}
		
	if(is_uploaded_file($_FILES['screenImg']['tmp_name']))
	{	
		if($_FILES['screenImg']["type"] != "image/png")
		{
			$Error = 1;
			$Err_Img = "This file format is not allowed";
		}
	}

	if(is_uploaded_file($_FILES['screenVid']['tmp_name']))
	{	
		if($_FILES['screenVid']["type"] != "video/mp4")
		{
			$Error = 1;
			$Err_Vid = "This file format is not allowed";
		}
	}
	
	if($_FILES['screenImg']['tmp_name'] == "" && $_FILES['screenVid']['tmp_name'] == ""){
		$Error = 1;
	}
		
	if($Error != 1)
	{	
		if($_FILES['screenImg']['tmp_name'] != "")
		{
			$screenImg = "screen_ImgVid/".$_SESSION['user_id']."_ScreenImg_".trim($_FILES['screenImg']['name']);
			//move_uploaded_file($_FILES['screenImg']['tmp_name'],$screenImg);
			move_uploaded_file($_FILES['screenImg']['tmp_name'],"../admin/".$screenImg);
			mysql_query("UPDATE `tbl_terminal` SET  `screenImage` = '".mysql_real_escape_string($screenImg)."' WHERE terminal_id = '".$terminal_id."'");
		}
		
		if($_FILES['screenVid']['tmp_name'] != "")
		{
			$screenVid = "screen_ImgVid/".$_SESSION['user_id']."_ScreenVid_".trim($_FILES['screenVid']['name']);
			//move_uploaded_file($_FILES['screenVid']['tmp_name'],$screenVid);
			move_uploaded_file($_FILES['screenVid']['tmp_name'],"../admin/".$screenVid);
			mysql_query("UPDATE `tbl_terminal` SET  `screenVideo` = '".mysql_real_escape_string($screenVid)."' WHERE terminal_id = '".$terminal_id."'");
		}
				
		echo "<script> document.location.href='index.php?action=manage_screen'</script>";		
	}
}

$query=mysql_query("SELECT * FROM `tbl_terminal` WHERE id = ".$_REQUEST['id']);
$data=mysql_fetch_array($query);

$terminal_id = $data['terminal_id'];
$screenImg = $data['screenImage'];
$screenVid = $data['screenVideo'];	
?>
<script>
function showfilename(img){
	var img_path = document.getElementById(img);
	var img_name = img_path.files[0].name;
    document.getElementById(img+"name").innerHTML = img_name;
}
</script>
<div class="page-header tbg2  heauto" style="margin-top:20px;">
<div class="col-md-8 p40">
  <h1> Add Screen Details </h1> </div>
  <div class="col-md-4 textleft" style="text-align:right;"><a href="index.php?action=manage_screen&<?=$_REQUEST['page'];?>&ipp=<?=$_REQUEST['ipp'];?>" class="greenbtn1">Previous Page</a> </div>
  <div class="clearfix" style="display: -webkit-box;"></div>
</div>
<div class="" id="">
  <form action="" name="kiosk"  method="post" enctype="multipart/form-data" >
  <div class="col-md-8">
                              <div class="w100">
								<div class="col-md-12"> <label class="flebal"> Terminal Id </label></div>
                                <div class="col-md-12 textbox6">
                                <?= $terminal_id ?>
								<input type="hidden" name="terminal_id" value="<?= $terminal_id ?>">
                                </div>
                              </div>
							  
							  <div class="clearfix gap1"> </div> 
                              <div class="w100">
								<div class="col-md-12"> <label class="flebal"> Screen Image </label></div>
                                <div class="col-md-8">
                                	<label for="screenImg"><img src="images/upload.jpg" alt=""/></label>
									<br>
									<?php if(isset($Err_Img) && $Err_Img != "") { echo "<span style='color: #ff0000;'>".$Err_Img."</span><br>";}?>
									<span style="font-size:10px;">
									Required Image Size : 1080 x 1920 , Accept only .png file.</span>
									<br><span id="screenImgname"></span>
									<input type="file" id="screenImg" name="screenImg" style="display:none" onchange="showfilename('screenImg')">
                                </div>
								<div class="col-md-4">
									<?php
										if( $screenImg!=""){ ?><img src="../admin/<?php echo $screenImg;?>" height="200" /> <? } 
									?>
								</div>
                              </div>
							  
							  <div class="clearfix gap1"> </div> 
                              <div class="w100">
								<div class="col-md-12"> <label class="flebal"> Screen Video </label></div>     
								<div class="col-md-8">
                                	<label for="screenVid"><img src="images/upload-video.jpg" alt=""/></label>
									<br>
									<?php if(isset($Err_Vid) && $Err_Vid != "") { echo "<span style='color: #ff0000;'>".$Err_Vid."</span><br>";}?>
									<span style="font-size:10px;">
									Accept only .mp4 file.</span>
									<br><span id="screenVidname"></span>
									<input type="file" id="screenVid" name="screenVid" style="display:none" onchange="showfilename('screenVid')">
                                </div>
								<? if( $screenVid!=""){ ?>
								<div class="col-md-4">
									<video width="320" height="240" controls>
										<source src="../admin/<?php echo $screenVid;?>" type="video/mp4">
									</video> 
								</div>
								<? } ?>
                              </div>     
                             
							<div class="clearfix gap1"> </div> 							 
                             <div class="w100">
                                <div class="col-md-12"><input id="cmdCheck" name="submit" value="Update" type="submit" class="greenbtn2"/>
                                  &nbsp;&nbsp;<a href="index.php?action=manage_screen" >
                                  <input type="button" value="Cancel" class="greenbtn2"/>
                                  </a>
                              </div>
							</div>
               
</div>
 </form>
