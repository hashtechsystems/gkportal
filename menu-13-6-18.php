<ul class="nav nav-list">
  <li class="<? if($_SERVER['QUERY_STRING']=="action=dashboard"){ ?> active <? } ?> hover"> <a href="index.php?action=dashboard"> <i class="menu-icon fa"> <img src="images/Network.png"  alt=""/></i> <span class="menu-text"> Dashboard</span> </a> </li>
  <li class="<? if($_SERVER['QUERY_STRING']=="action=customers_list"){ ?> active <? } ?> hover"> <a href="index.php?action=customers_list"> <i class="menu-icon fa"> <img src="images/account.png"  alt=""/></i> <span class="menu-text"> My profile</span> </a> </li>
   <li class="<? if($_SERVER['QUERY_STRING']=="action=employee_list"){ ?> active <? } ?> hover"> <a href="index.php?action=employee_list"> <i class="menu-icon fa"> <img src="images/account.png"  alt=""/></i> <span class="menu-text"> Manage Employee</span> </a> </li>
   
   <?php
   if($_SESSION['AssignedPOS'] == "MJ Freeway")
   {
   ?>
   <li class="<? if($_SERVER['QUERY_STRING']=="action=product_mj_freeway_list"){ ?> active <? } ?> hover"> <a href="index.php?action=product_mj_freeway_list"> <i class="menu-icon fa"> <img src="images/account.png"  alt=""/></i> <span class="menu-text"> Products</span> </a> </li>
   <li class="<? if($_SERVER['QUERY_STRING']=="action=consumer_list_mjfreeway"){ ?> active <? } ?> hover"> <a href="index.php?action=consumer_list_mjfreeway"> <i class="menu-icon fa"> <img src="images/account.png"  alt=""/></i> <span class="menu-text"> Consumers</span> </a> </li>
   <?php
   }
   else
   if($_SESSION['AssignedPOS'] == "Treez")
   {
	?>
   <li class="<? if($_SERVER['QUERY_STRING']=="action=product_treez_list"){ ?> active <? } ?> hover"> <a href="index.php?action=product_treez_list"> <i class="menu-icon fa"> <img src="images/account.png"  alt=""/></i> <span class="menu-text"> Products</span> </a> </li>
   <?php
   }
   else
   {
   }
   ?>
   <li class="<? if($_SERVER['QUERY_STRING']=="action=manage_planogram"){ ?> active <? } ?> hover"> <a href="index.php?action=manage_planogram"> <i class="menu-icon fa"> <img src="images/sites.png"  alt=""/></i> <span class="menu-text"> Manage Planogram</span> </a> </li>
   
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
