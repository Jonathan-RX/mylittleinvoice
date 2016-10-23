<?php
	/*
		This file is part of MyLittleInvoice.

    MyLittleInvoice is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License.

    MyLittleInvoice is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>
		*/
	?><header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>M</b>LI</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>MyLittle</b>Invoice</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
	          <li class="change_lang">
              	<a href="#" onclick="jQuery('.lang_list').slideToggle();"><?php
	              	switch ($_SESSION['lang']) {
							case 'french':
								echo '<img src="dist/img/flags/fr.png" /> Français';
							break;
							case 'english':
								echo '<img src="dist/img/flags/gb.png" /> English';
							break;
					}
	              	?></a>
              	<ul class="lang_list">
	              	<li><a href="index.php?change_lang=french"><img src="dist/img/flags/fr.png" /> Français</a></li>
	              	<li><a href="index.php?change_lang=english"><img src="dist/img/flags/gb.png" /> English</a></li>
              	</ul>
              </li>
              <!-- Messages: style can be found in dropdown.less-->
                            <!-- Control Sidebar Toggle Button -->
                            <?php 
	              	global $bd;
	              	if(!empty($horizontal_menu)){echo $horizontal_menu;}
	              	$test_date = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'quotes WHERE archived="false"');
	              	$cdate = 0;
	              	foreach($test_date as $td){
		              	if(strtotime(str_replace('/', '-', $td->date_end)) < strtotime(date('Y-m-d'))){$cdate ++;}
	              	}
	              	if($cdate > 0){echo '
               <li> <a href="quotes.php?select=ended" title="Devis expirés"><i class="fa fa-file-text-o"></i><span class="label label-danger">' . $cdate . '</span></a></li>';}
	              	$test_date = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'invoices WHERE archived="false"');
	              	$cdate = 0;
	              	foreach($test_date as $td){
		              	if(strtotime(str_replace('/', '-', $td->date_end)) < strtotime(date('Y-m-d'))){$cdate ++;}
	              	}
	              	if($cdate > 0){echo '
               <li> <a href="invoices.php?select=ended" title="Facture en attente de règlement"><i class="fa fa-file-text"></i><span class="label label-danger">' . $cdate . '</span></a></li>';}
              	?>
              <li>
              	
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
              <li class="user" style="min-width:30px;cursor:pointer;">
              	<span style="color:white;display:block;text-align:center;vertical-align: middle;padding-top:15px;"><i class="fa fa-user" onclick="jQuery('.user_name_display').slideToggle();"></i><b class="user_name_display" style="display:none;"> : <?php echo $_SESSION['session_login']; ?></b></span>
              </li>
              <li>
                <a href="index.php?kill_session=true"><i class="fa fa-power-off" style="color:red;"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>