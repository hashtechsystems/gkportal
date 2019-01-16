<!DOCTYPE html>
<html lang="en">
<head>
<title>dprwholesalers</title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<!--css links-->
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<!--bootstrap-->
<link href="css/font-awesome.css" rel="stylesheet">
<!--font-awesome-->
<link rel="stylesheet" href="css/chocolat.css" type="text/css" media="screen">
<!--chocolat-->
<link href="css/style1.css" rel="stylesheet" type="text/css" media="all" />
<!--stylesheet-->
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
<!--//css links-->
<!--fonts-->
<!--//fonts-->
</head>
<body>
<div class="header-nav">
  
  <div class="col-md-3 marlr">
    <div class="navbar-header logo">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <h1> <a class="" href="index.php?action=home"> <img src="images/logo.png" class="img-responsive" alt=""></a> </h1>
    </div>
    </div>
    <div class="col-md-3 marlr w20">
    <form action="index.php?action=search_result" method="post" class="top-search">
            <button type="submit" class="btn btn-default search" aria-label="Left Align" style="float:right; position:absolute; right:6px;  border:0; padding: 10px; background:#1f7ab2;"> <i class="fa fa-search" aria-hidden="true"> </i> </button>
            <input type="text" name="txtSearch" placeholder="Search for a Product..." class="searchw searchb">
          </form>
    
    </div>
   
    <div class="col-md-3 topmar5 " style="text-align:center;">
    <a href="index.php?action=locations" style="color:#00274d;font-size: 12px;
"> <strong>Location &amp; Hours</strong></a>|
   

    <a href="index.php?action=page&amp;id=1" style="color:#00274d;font-size: 12px;
"><strong>About Us</strong></a>|
    <a href="index.php?action=login" style="color:#00274d;font-size: 12px;"><strong>login</strong></a>|
    <a href="index.php?action=register" style="color:#00274d;font-size: 12px;"><strong>Sign Up</strong></a>
    </div>
    <div class="col-md-2 rightalig topmar6 marlr">
    <a href="#" style="font-size: 20px; font-weight: 600; color:#000;">020 3583 5200</a><br>
        <a href="mailto:sales@DPRwholesaler.com" style="font-size:13px;color:#000;font-size: 15px;">sales@DPRwholesaler.com</a>
    </div>
    
    <div class="col-md-1 topmar5 marlr">
      
      
      
       
                
      
       
                <a href="index.php?action=view_cart" style="text-align:center;display:block; "><img src="images/cart.png" width="30" alt=""> (
        			0                        )</a> 
             
      
  </div>
    
    
    <div class="clearfix"> </div>
  
  <div class="clearfix"> </div>
</div>





<div class="header-nav">
  <nav class="navbar navbar-default">
    <div class="navbar-header logo">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <h1> <a class="" href="index.php?action=home"> <img src="images/logo.png" width="200" height="57" alt=""/></a> </h1>
    </div>
    <!-- navbar-header -->
    
    <div class="contact-bnr-w3-agile">
      <ul style="float:left; margin-top:0;">
      <li style="vertical-align: top; line-height:25px;  font-weight:300;"> </li>
      <li class="location1"> <a href="index.php?action=locations" > Location & Hours</a></li>
       <li class="location1"> <a href="index.php?action=contact_us" style="color:#002663;"> Contact Us</a></li>
        <li class="location1" style="margin-right: 74px;"> <a href="index.php?action=page&id=1" style="color:#002663;">About Us</a><br/>
        <form action="index.php?action=search_result" method="post" class="top-search">
            <button type="submit" class="btn btn-default search" aria-label="Left Align" style="float:right; position:absolute; right:0px;  border:0; padding: 6px; background:#1f7ab2;"> <i class="fa fa-search" aria-hidden="true"> </i> </button>
            <input type="text" name="txtSearch" placeholder="Search for a Product..." class="searchw searchb">
          </form>
        </li>
        <?php
		if(isset($_SESSION['DPR_UserLoggedIn']) && $_SESSION['DPR_UserLoggedIn'] == "login")
		{	
		?>
        <li style="vertical-align: top; line-height:43px;  font-weight:600;padding-top: 26px;"> Welcome <a href="index.php?action=my_orders" style="color:#002663;"><?php echo $_SESSION['DPR_UserName'];?></a> <!--| <a href="http://www.hashtech.us/dprwholesalers/index.php?action=my_orders" style="color:#002663;">My Account</a>--> | <a href="logout.php">Logout</a></li>
        <?php
		}
		else
		{
		?>        
        <li style="vertical-align: top; line-height:25px;  font-weight:600;padding-top: 26px;"> <a href="index.php?action=login" style="color:#002663;  line-height: 43px; ">LOGIN</a></li>
        <li style="vertical-align: top; line-height: 25px; color:#002663; font-weight:600;padding-top: 26px; "> <a href="index.php?action=register" style="color:#002663;  line-height: 43px; " >SIGN UP</a> </li>
        <?php
		}
		?>
        <li style="vertical-align: top; line-height: 25px; color:#002663; font-weight:600; border-right:solid 1px #ccc; margin-right:10px;  line-height: 43px; padding-top: 26px;padding-bottom: 9px; "> <a href="index.php?action=view_cart" style="text-align:center;display:block; "><img src="images/cart.png" width="20"  alt=""/> (
        			<?php
					$SQL_CART_TOTAL = mysql_query("SELECT * FROM `tbl_basket_details` WHERE `session_id` = '".$_SESSION['SessionId']."' ");
					echo mysql_num_rows($SQL_CART_TOTAL);
					$FREE_RESULT = mysql_free_result($SQL_CART_TOTAL);
					?>
                        )</a> </li>
              </ul>
      <div style="float:left; text-align:center; padding-top: 10px;"> <a href="#" style="font-size: 27px; font-weight: 600; color:;"><i class="fa fa-phone" aria-hidden="true"></i>020 3583 5200 </a><br>
        <i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:sales@DPRwholesaler.com" style="font-size:13px;">sales@DPRwholesaler.com</a></div>
    </div>
    <div class="clearfix"> </div>
  </nav>
  <div class="clearfix"> </div>
</div>
<div class="w100" style="background:#feca00;"> <nav class="navbar navbar-default" style="float:left; background:none;">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse menu--shylock" id="bs-example-navbar-collapse-1" style="float:left;">
          <ul class="nav navbar-nav menu__list">
           <?php
			  $SQL_CATEGORIES = mysql_query("SELECT * FROM `tbl_category` WHERE `parent_cat_id` = 0 LIMIT 0, 13");
			  
			  while($DATA_CATEGORY = mysql_fetch_assoc($SQL_CATEGORIES))
			  {
				  
					?>
                    <li class=" menu__item"><a class="menu__link" href="index.php?action=products&cid=<?php echo $DATA_CATEGORY['id']; ?>"><?php echo $DATA_CATEGORY['category_name'];?></a></li>
                    <?php
			  }
			  ?>
              <li class="dropdown menu__item"> <a href="#" class="dropdown-toggle menu__link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">More <span class="caret"></span></a>
              <ul class="dropdown-menu multi-column columns-8" style="left:-446px;">
              <div class="row">
              <div class="col-sm-6 multi-gd-img">
              <ul class="multi-column-dropdown">
              <?php
			  $SQL_CATEGORIES_MORE = mysql_query("SELECT * FROM `tbl_category` WHERE `parent_cat_id` = 0 LIMIT 13, 100");
			  
			  $TotalRecords = mysql_num_rows($SQL_CATEGORIES_MORE);					  
			  $ModVal = ceil($TotalRecords / 2);
			  $CntCat=0;	
			  while($DATA_CATEGORY_MORE = mysql_fetch_assoc($SQL_CATEGORIES_MORE))
			  {
				 if($CntCat > 0 && ($CntCat % $ModVal) == 0)
				 { 
				 ?>
                 </ul>
                 </div>
                 <div class="col-sm-6 multi-gd-img">
                 <ul class="multi-column-dropdown">
                 <?php
				 }
			     ?>
                 <li ><a href="index.php?action=products&cid=<?php echo $DATA_CATEGORY_MORE['id']; ?>"> <?php echo "&#8250; ".$DATA_CATEGORY_MORE['category_name'];?> </a></li>
                 <?php
				 $CntCat=$CntCat + 1;
			  }
			  ?>
               </ul>
                      </div>
                      <div class="clearfix"></div>
                	  </div>
              		  </ul>
                      </li>
				                
          </ul>
        </div>
      </div>
    </nav> <div class="clearfix"> </div></div>
    <div class="clearfix"></div>