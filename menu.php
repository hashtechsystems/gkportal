<ul class="nav nav-list">
  <li class="<? if($_SERVER['QUERY_STRING']=="action=dashboard"){ ?> active  <? } ?> open "> <a href="index.php?action=dashboard" class="dashboard1"> <i class="menu-icon ace-icon fa  "> </i> <span class="menu-text"> Dashboard</span> </a> </li>
  <li class="<? if($_SERVER['QUERY_STRING']=="action=manage_screen"){ ?> active  <? } ?> open "> <a href="index.php?action=manage_screen" class="dashboard1"> <i class="menu-icon ace-icon fa  "> </i> <span class="menu-text"> Manage Screen</span> </a> </li>
  <!--<li class="<? if($_SERVER['QUERY_STRING']=="action=customers_list"){ ?> active <? } ?> open"> <a href="index.php?action=customers_list"> <i class="menu-icon ace-icon fa fa-user"></i> <span class="menu-text"> My profile</span> </a> </li>-->
   <li class="<? if($_SERVER['QUERY_STRING']=="action=employee_list"){ ?> active <? } ?> open"> <a href="index.php?action=employee_list" class="manepo"><i class="menu-icon ace-icon fa"> </i> <span class="menu-text"> Manage Employee</span> </a> </li>
   
   <?php
   if($_SESSION['AssignedPOS'] == "MJ Freeway")
   {
   ?>
   <li class="<? if($_SERVER['QUERY_STRING']=="action=product_mj_freeway_list"){ ?> active <? } ?> open"> <a href="index.php?action=product_mj_freeway_list" class="product"> <i class="menu-icon fa"></i><span class="menu-text"> Products</span> </a> </li>
   <li class="<? if($_SERVER['QUERY_STRING']=="action=consumer_list_mjfreeway"){ ?> active <? } ?> open"> <a href="index.php?action=consumer_list_mjfreeway" class="consumer"> <i class="menu-icon fa"></i><span class="menu-text"> Consumers</span> </a> </li>
   <?php
   }
   else
   if($_SESSION['AssignedPOS'] == "Treez")
   {
	?>
   <li class="<? if($_SERVER['QUERY_STRING']=="action=product_treez_list"){ ?> active <? } ?> open"> <a href="index.php?action=product_treez_list" class="product"> <i class="menu-icon fa"></i> <span class="menu-text"> Products</span> </a> </li>
   <li class="<? if($_SERVER['QUERY_STRING']=="action=consumer_list_treez"){ ?> active <? } ?> open"> <a href="index.php?action=consumer_list_treez" class="consumer"> <i class="menu-icon fa"></i><span class="menu-text"> Consumers</span> </a> </li>
   <?php
   }
   else
   if($_SESSION['AssignedPOS'] == "No Pos")
   {
	?>
   <li class="<? if($_SERVER['QUERY_STRING']=="action=product_list"){ ?> active <? } ?> "> <a href="index.php?action=product_list" class="product"> <i class="menu-icon ace-icon fa "> </i>  <span class="menu-text"> Products</span> </a> </li>
   <li class="<? if($_SERVER['QUERY_STRING']=="action=customer_list_no_pos"){ ?> active <? } ?> "> <a href="index.php?action=customer_list_no_pos" class="consumer"> <i class="menu-icon fa"> </i> <span class="menu-text"> Consumers</span> </a> </li>
   <?php
   }
   else
   if($_SESSION['AssignedPOS'] == "Green Bits")
   {
   ?>
   <li class="<? if($_SERVER['QUERY_STRING']=="action=product_greenbits_list"){ ?> active <? } ?> "> <a href="index.php?action=product_greenbits_list" class="product"> <i class="menu-icon fa"> </i> <span class="menu-text"> Products</span> </a> </li>
   <li class="<? if($_SERVER['QUERY_STRING']=="action=consumer_list_greenbits"){ ?> active <? } ?> "> <a href="index.php?action=consumer_list_greenbits" class="consumer"> <i class="menu-icon fa"> </i> <span class="menu-text"> Consumers</span> </a> </li>
   <?php
   }
   ?>
   <li class="<? if($_SERVER['QUERY_STRING']=="action=manage_planogram"){ ?> active <? } ?> "> <a href="index.php?action=manage_planogram" class="manplan"> <i class="menu-icon fa"> </i> <span class="menu-text"> Manage Planogram</span> </a> </li>
   
   <li class=""> <a class="dropdown-toggle report" href="#"> <i class="menu-icon fa"> </i> <span class="menu-text"> Reports </span>  </a> 
    <ul class="submenu can-scroll ace-scroll scroll-disabled" style="">
      <li class=""> <a href="index.php?action=sales_report">  Sales Summary Report </a>  </li>
      <li class=""> <a href="index.php?action=product_sales_report">  Product Sales Report </a>  </li>
	  <li class=""> <a href="index.php?action=order_transactions_report">  Transactions Report </a>  </li>
	  <li class=""> <a href="index.php?action=sales_time_order_report">  View Sales By Time </a>  </li>
	  <li class=""> <a href="index.php?action=uptime_report">  Uptime / Usage Report </a>  </li>
	  <li class=""> <a href="index.php?action=total_tax_report">  Total Tax Report </a>  </li>
	  <?php
	   if($_SESSION['AssignedPOS'] == "Green Bits")
	   {
	   ?>
	   <li class=""> <a href="index.php?action=non_gbpos_order_report">  Unpushed Orders </a>  </li>
	   <?php
	   }
	   ?>
    </ul>        
  </li>
  
  <!--<li class="<? if($_SERVER['QUERY_STRING']=="action=site_list"){ ?> active <? } ?> hover"> <a href="index.php?action=site_list"> <i class="menu-icon fa"> <img src="images/sites.png"  alt=""/></i> <span class="menu-text"> Sites</span> </a> </li>
  <li class="<? if($_SERVER['QUERY_STRING']=="action=terminal_list"){ ?> active <? } ?> hover"> <a href="index.php?action=terminal_list"> <i class="menu-icon fa"> <img src="images/terminal.png"  alt=""/></i> <span class="menu-text"> Terminal</span> </a> </li>
  <li class="<? if($_SERVER['QUERY_STRING']=="action=product_list"){ ?> active <? } ?> hover"> <a href="index.php?action=product_list"> <i class="menu-icon fa"> <img src="images/product.png"  alt=""/></i> <span class="menu-text"> Products</span> </a> </li>
  <li class="<? if($_SERVER['QUERY_STRING']=="action=group_list"){ ?> active <? } ?> hover"> <a href="index.php?action=group_list"> <i class="menu-icon fa"> <img src="images/group.png"  alt=""/></i> <span class="menu-text"> Groups</span> </a> </li>
  <li class="<? if($_SERVER['QUERY_STRING']=="action=user_list"){ ?> active <? } ?> hover"> <a href="index.php?action=user_list"> <i class="menu-icon fa"> <img src="images/users.png"  alt=""/></i> <span class="menu-text"> Users</span> </a> </li>
  <li class="<? if($_SERVER['QUERY_STRING']=="action=assigned_products"){ ?> active <? } ?> hover"> <a href="index.php?action=assigned_products"> <i class="menu-icon fa"> <img src="images/a-products.png"  alt=""/></i> <span class="menu-text"> Assigned products</span> </a> </li>
  
  <li class="hover"> <a class="dropdown-toggle" href="#"> <i class="menu-icon fa"> <img src="images/sites.png" alt=""></i> <span class="menu-text"> Reports </span> <b class="arrow fa fa-angle-down"></b> </a> <b class="arrow"></b>
    <ul class="submenu can-scroll ace-scroll scroll-disabled" style="">
      <li class="hover"> <a href="index.php?action=transaction_report"> <i class="menu-icon fa fa-caret-right"></i> Transaction Report </a> <b class="arrow"></b> </li>
      
    </ul>        
  </li>-->
</ul>

<div class="sidebar-toggle sidebar-collapse show991" id="sidebar-collapse " >
					<i id="sidebar-toggle-icon" class="ace-save-state ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
