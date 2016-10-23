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
	if(!file_exists('config.php')){header('Location: install.php');exit();}
	include('include/head.php');
	global $bd;
	global $lang;
	?>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">
      
      <?php include('include/header.php'); ?>
      <!-- Left side column. contains the logo and sidebar -->
      <?php include('include/left.php'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
      <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $lang['dashboard']; ?>
            <small><?php echo $lang['preview']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> <?php echo $lang['home']; ?></a></li>
            <li class="active"><?php echo $lang['dashboard']; ?></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua" onclick="window.location = 'quotes.php';">
                <div class="inner">
                  <h3><?php 
	                  $count = $bd->get_results('SELECT COUNT(*) AS nbr FROM ' . $bd->prefix . 'quotes');
	                  echo $count[0]->nbr;
	                   ?></h3>
                  <p><?php echo $lang['saved_quotes']; ?></p>
                </div>
                <div class="icon">
                  <i class="ion ion-clipboard"></i>
                </div>
                <a href="quotes.php" class="small-box-footer"><?php echo $lang['go_to_page']; ?> <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green" onclick="window.location = 'quotes.php';">
                <div class="inner">
                  <h3><?php 
	                  $count = $bd->get_results('SELECT COUNT(*) AS nbr FROM ' . $bd->prefix . 'quotes');
	                  $count2 = $bd->get_results('SELECT COUNT(*) AS nbr FROM ' . $bd->prefix . 'quotes WHERE invoice="true"');
	                  if($count2[0]->nbr > 0 AND $count[0]->nbr > 0){echo round($count2[0]->nbr*100/$count[0]->nbr);}else{echo '0';}
	                   ?><sup style="font-size: 20px">%</sup></h3>
                  <p><?php echo $lang['converted_quotes']; ?></p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="quotes.php" class="small-box-footer"><?php echo $lang['go_to_page']; ?> <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow" onclick="window.location = 'customers.php';">
                <div class="inner">
                  <h3><?php 
	                  $count = $bd->get_results('SELECT COUNT(*) AS nbr FROM ' . $bd->prefix . 'customers');
	                  echo $count[0]->nbr;
	                   ?></h3>
	               <p><?php echo $lang['saved_customers']; ?></p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="customers.php" class="small-box-footer"><?php echo $lang['go_to_page']; ?> <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red" onclick="window.location = 'payments.php';">
                <div class="inner">
                  <h3><?php 
	                  $count = $bd->get_results('SELECT COUNT(*) AS nbr FROM ' . $bd->prefix . 'payments');
	                  echo $count[0]->nbr;
	                   ?></h3>
                  <p><?php echo $lang['dashboard_payments']; ?> </p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="payments.php" class="small-box-footer"><?php echo $lang['go_to_page']; ?> <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          </div><!-- /.row -->
          <!-- Main row -->
          

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
     <?php include('include/footer.php'); ?>