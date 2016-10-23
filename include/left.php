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
		global $lang;
	?><aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel 
          <div class="user-panel">
            <div class="pull-left image">
              <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p>Alexander Pierce</p>

              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          -->
          <!-- search form
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form> -->
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
	      	<li>
              <a href="index.php">
                <i class="fa fa-dashboard"></i> <span><?php echo $lang['dashboard']; ?></span>    
              </a>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-users"></i>
                <span><?php echo $lang['customers']; ?></span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="new-customer.php"><i class="fa ion-ios-plus-empty"></i> <?php echo $lang['new_customer']; ?></a></li>
                <li><a href="customers.php"><i class="fa ion-ios-arrow-forward"></i> <?php echo $lang['customers_list']; ?></a></li>
              </ul>
            </li>
            
             <li class="treeview">
              <a href="#">
                <i class="fa fa-file-text-o"></i>
                <span>Devis</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="new-quote.php"><i class="fa ion-ios-plus-empty"></i> <?php echo $lang['new_quote']; ?></a></li>
                <li><a href="quotes.php"><i class="fa ion-ios-arrow-forward"></i> <?php echo $lang['quotes_list']; ?></a></li>
              </ul>
            </li>
            
             <li class="treeview">
              <a href="#">
                <i class="fa  fa-file-text"></i>
                <span><?php echo $lang['invoices']; ?></span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="new-invoice.php"><i class="fa ion-ios-plus-empty"></i> <?php echo $lang['new_invoice']; ?></a></li>
                <li><a href="invoices.php"><i class="fa ion-ios-arrow-forward"></i> <?php echo $lang['invoices_list']; ?></a></li>
              </ul>
            </li>
            
             <li class="treeview">
              <a href="#">
                <i class="fa  fa-credit-card"></i>
                <span><?php echo $lang['payments']; ?></span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="new-payment.php"><i class="fa ion-ios-plus-empty"></i> <?php echo $lang['new_payment']; ?></a></li>
                <li><a href="payments.php"><i class="fa ion-ios-arrow-forward"></i> <?php echo $lang['payments_list']; ?></a></li>
              </ul>
            </li>
            
             <li class="treeview">
              <a href="#">
                <i class="fa fa-bar-chart-o"></i>
                <span><?php echo $lang['reports']; ?></span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="reports-month.php"><i class="fa ion-ios-plus-empty"></i> <?php echo $lang['report_month']; ?></a></li>
                <li><a href="reports-year.php"><i class="fa ion-ios-plus-empty"></i> <?php echo $lang['report_year']; ?></a></li>
              </ul>
            </li>
            
            <?php
	            /* <li class="header">LABELS</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
            */ ?>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>