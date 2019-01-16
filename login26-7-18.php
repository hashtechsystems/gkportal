<?php
session_start();
include('DatabaseControl/dbConnect.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Grasshopper - Customer</title>

		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.css" />
		<link rel="stylesheet" href="assets/css/font-awesome.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/ace-fonts.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.css" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.css" />
		<![endif]-->
		<link rel="stylesheet" href="assets/css/ace-rtl.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.css" />
		<![endif]-->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="assets/js/html5shiv.js"></script>
		<script src="assets/js/respond.js"></script>
		<![endif]-->
	</head>

	<body class="login-layout" style="background-color:#1d93d1;">
    
    <div class="col-md-12" style="border-bottom:solid 1px #fff; background-color: #fff;"> <div class="col-md-4">
								<img src="images/logo.png" style="height: 80px;
    padding-top: 0px;">
								
						  </div> 
                          
                          <div class="col-md-8" style="text-align:right; line-height:100px; font-size:30px; text-transform:uppercase; color:#000;">Admin Panel&nbsp;&nbsp; </div>
                          
                          </div>
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
					  <div class="login-container">
							

						  <div class="space-6"></div>

						<div class="position-relative" style="margin-top:60px; border-radius:10px;">
								<div id="login-box" class="login-box visible widget-box no-border" style="margin:0; background:#2c77bb !important; padding:0;">
									<div class="widget-body" style="background:#2c77bb !important;">
										<div class="widget-main" style="padding:40px;background:#fff !important;" >
                                        <?
				if(isset($_REQUEST['wrong']))
				  {
				  ?>			  
					<span style="color:#F00; font-family:Arial, Helvetica, sans-serif;">Invalid username and password	</span>
				   <?
				  }
				  ?>
											
<h4 class="header blue lighter bigger">
												
												Please Enter Your Information
											</h4>
											

											<form action="p_login.php" method="post" onSubmit="return validate_login()">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" name="Username" placeholder="Username"  onFocus="this.value = '';" onBlur="if (this.value == '') {this.value = 'Email address:';}" />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" name="Password" placeholder="Password" />
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>
													<div class="clearfix">
														

														<button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
															<i class="ace-icon fa fa-key"></i>
															<span class="bigger-110">Login</span>
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											</form>

											

											<div class="space-6"></div>

											
										</div><!-- /.widget-main -->

										
									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->

								<!-- /.forgot-box -->

								<!-- /.signup-box -->
							</div>
							<div class="space"></div>
							<!-- /.position-relative -->

							
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.main-content -->
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='assets/js/jquery.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery1x.js'>"+"<"+"/script>");
</script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.js'>"+"<"+"/script>");
		</script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
			 $(document).on('click', '.toolbar a[data-target]', function(e) {
				e.preventDefault();
				var target = $(this).data('target');
				$('.widget-box.visible').removeClass('visible');//hide others
				$(target).addClass('visible');//show target
			 });
			});
			
			
			
			//you don't need this, just used for changing background
			jQuery(function($) {
			 $('#btn-login-dark').on('click', function(e) {
				$('body').attr('class', 'login-layout');
				$('#id-text2').attr('class', 'white');
				$('#id-company-text').attr('class', 'blue');
				
				e.preventDefault();
			 });
			 $('#btn-login-light').on('click', function(e) {
				$('body').attr('class', 'login-layout light-login');
				$('#id-text2').attr('class', 'grey');
				$('#id-company-text').attr('class', 'blue');
				
				e.preventDefault();
			 });
			 $('#btn-login-blur').on('click', function(e) {
				$('body').attr('class', 'login-layout blur-login');
				$('#id-text2').attr('class', 'white');
				$('#id-company-text').attr('class', 'light-blue');
				
				e.preventDefault();
			 });
			 
			});
		</script>
	</body>
</html>
