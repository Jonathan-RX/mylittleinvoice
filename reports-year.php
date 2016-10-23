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
	$insert_in_head = '<style type="text/css">
	.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}
	.graph{display:block;width:440px;height:210px;border:1px solid grey;padding:20px;font-family:verdana;font-size:10px;}
	.graph ul{list-style-type: none;padding:0;margin:0;}
	.graph li{padding: 0;margin:0;}
	.graph .title li{display:block;border-top:1px solid #eee;height:20px;margin-bottom:17px;margin-left:-15px;}
	.graph .content{margin-top:-17px;}
	.graph .content li{float:left;margin-left:35px;position:relative;}
	.graph .content li hr{width:1px;height:180px;position:absolute;background:#eee;top:0;left:-5px;;margin-top:-180px;}
	.graph .content li i{display:block;position:absolute;width:10px;border:1px solid #888;background:#eee;bottom:15px;left:8px;}
	.graph .content li i b{display:none;}
	.graph .content li i:hover b{display:block;padding:3px;background:#eee;border:1px solid #000;margin-top:-30px;width:30px;margin-left:-5px;}
			</style>';
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
            <?php echo $lang['annual_report']; ?>
            <small><?php echo $lang['annual_report_for']; ?> : 
            <?php 
	            if(!empty($_POST['year'])){
		            $year = $_POST['year'];
	            }else{
                    $year = date('Y');
	            }
	            echo $year;
	            ?>
	            </small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> <?php echo $lang['home']; ?></a></li>
            <li class="active"><?php echo $lang['annual_report']; ?></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
         <div class="box box-solid">
                <div class="box-header">
                  <i class="fa fa-bar-chart-o"></i>
                  <h3 class="box-title"><?php echo $lang['results']; ?></h3>
                  
                </div><!-- /.box-header -->
                <div class="box-body">
	                <form action="reports-year.php" method="POST">
		            
		            <input type="text" name="year" placeholder="<?php echo $lang['selected_year']; ?>" class="form-control payment_date" style="width:120px;float:left;height:20px;padding:0;margin-right:5px;" />
		            <input type="submit" value="<?php echo $lang['change']; ?>" class="btn btn-default btn-s" style="width:120px;margin-top:-3px;height:20px;padding:0;" />
	            </form><br />
                  
	                    <?php
		                    $nbr_customers = $bd->get_results('SELECT COUNT(*) AS nbr FROM ' . $bd->prefix . 'customers WHERE date_add LIKE "%/' . $year . '"');
		                    $nbr_customers = $nbr_customers[0]->nbr;
		                    $total_customers = $bd->get_results('SELECT COUNT(*) AS nbr FROM ' . $bd->prefix . 'customers WHERE date_add LIKE "%/' . $year . '"');
		                    $total_customers = $total_customers[0]->nbr;
		                    $nbr_quotes = $bd->get_results('SELECT COUNT(*) AS nbr FROM ' . $bd->prefix . 'quotes WHERE date LIKE "%/' . $year . '"');
		                    $nbr_quotes = $nbr_quotes[0]->nbr;
		                    $total_quotes = $bd->get_results('SELECT COUNT(*) AS nbr FROM ' . $bd->prefix . 'quotes WHERE date LIKE "%/' . $year . '"');
		                    $total_quotes = $total_quotes[0]->nbr;
		                    $nbr_convert_quotes = $bd->get_results('SELECT COUNT(*) AS nbr FROM ' . $bd->prefix . 'quotes WHERE date LIKE "%/' . $year . '" AND invoice="true"');
		                    $nbr_convert_quotes = $nbr_convert_quotes[0]->nbr;
		                    $nbr_invoices = $bd->get_results('SELECT COUNT(*) AS nbr FROM ' . $bd->prefix . 'invoices WHERE date LIKE "%/' . $year . '"');
		                    $nbr_invoices = $nbr_invoices[0]->nbr;
		                    $total_invoices = $bd->get_results('SELECT COUNT(*) AS nbr FROM ' . $bd->prefix . 'invoices WHERE date LIKE "%/' . $year . '"');
		                    $total_invoices = $total_invoices[0]->nbr;
		                    $payments = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'payments WHERE date LIKE "%/' . $year . '"');
		                    $total_payments = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'payments');
		                    $nbr_payments = 0;
		                    foreach($payments as $p){
			                    $nbr_payments += $p->amount;
		                    }
		                    $all_payments = 0;
		                    foreach($total_payments as $p){
			                    $all_payments += $p->amount;
		                    }
		                    $invoices = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'invoices WHERE date LIKE "%/' . $year . '"');
		                    $total_taxes = 0;
		                    $total = 0;
		                    foreach($invoices as $r){
			                    foreach(unserialize($r->products) as $p){
				                    $total += $p['qty']*$p['price'];
				                    $total_taxes += $p['qty']*($p['price']*$p['taxes']/100);
		                    	}
		                    }
		                     ?>
                      <div class="row">
	                  
                    <div class="col-md-3 col-sm-6 col-xs-6 text-center"><div style="display: inline; width: 90px; height: 90px;">
	                      <canvas width="90" height="90"></canvas>
	                      <input type="text" class="knob" data-readOnly=true value="<?php echo $nbr_customers; ?>" data-max="<?php echo $total_customers; ?>" data-width="90" data-height="90" data-fgcolor="#3c8dbc" style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; font-weight: bold; font-style: normal; font-variant: normal; font-stretch: normal; font-size: 18px; line-height: normal; font-family: Arial; text-align: center; color: rgb(60, 141, 188); padding: 0px; -webkit-appearance: none; background: none;">
	                   </div>
                      <div class="knob-label"><?php echo $lang['report_new_customers']; ?></div>
                    </div><!-- ./col -->
                    <div class="col-md-3 col-sm-6 col-xs-6 text-center">
                      <div style="display: inline; width: 90px; height: 90px;"><canvas width="90" height="90"></canvas><input type="text" class="knob" data-readOnly=true value="<?php echo $nbr_convert_quotes; ?>" data-max="<?php echo $total_quotes; ?>" data-width="90" data-height="90" data-fgcolor="#f56954" style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; font-weight: bold; font-style: normal; font-variant: normal; font-stretch: normal; font-size: 18px; line-height: normal; font-family: Arial; text-align: center; color: rgb(245, 105, 84); padding: 0px; -webkit-appearance: none; background: none;"></div>
                      <div class="knob-label"><?php echo $lang['report_converted_quotes']; ?></div>
                    </div><!-- ./col -->
                    <div class="col-md-3 col-sm-6 col-xs-6 text-center">
                      <div style="display: inline; width: 90px; height: 90px;"><canvas width="90" height="90"></canvas><input type="text" class="knob" data-readOnly=true value="<?php echo $nbr_invoices; ?>" data-max="<?php echo $total_invoices; ?>" data-width="90" data-height="90" data-fgcolor="#00a65a" style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; font-weight: bold; font-style: normal; font-variant: normal; font-stretch: normal; font-size: 18px; line-height: normal; font-family: Arial; text-align: center; color: rgb(0, 166, 90); padding: 0px; -webkit-appearance: none; background: none;"></div>
                      <div class="knob-label"><?php echo $lang['report_new_invoices']; ?></div>
                    </div><!-- ./col -->
                    <div class="col-md-3 col-sm-6 col-xs-6 text-center">
                      <div style="display: inline; width: 90px; height: 90px;"><canvas width="90" height="90"></canvas><input type="text" class="knob" data-readOnly=true value="<?php echo $nbr_payments;?>" data-max="<?php echo $all_payments; ?>" data-width="90" data-height="90" data-fgcolor="#00c0ef" style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; font-weight: bold; font-style: normal; font-variant: normal; font-stretch: normal; font-size: 18px; line-height: normal; font-family: Arial; text-align: center; color: rgb(0, 192, 239); padding: 0px; -webkit-appearance: none; background: none;"></div>
                      <div class="knob-label"><?php echo $lang['report_new_payments']; ?> (<?php echo $bd->get_option('money_symbole'); ?>)</div>
                    </div><!-- ./col -->
                  </div><!-- /.row -->

                  <div class="row">
                    <div class="col-xs-6 text-center">
                      <div style="display: inline; width: 90px; height: 90px;"><canvas width="90" height="90"></canvas><input type="text" class="knob" data-readOnly=true value="<?php echo $nbr_quotes; ?>" data-max="<?php echo $total_quotes; ?>"  data-width="90" data-height="90" data-fgcolor="#932ab6" style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; font-weight: bold; font-style: normal; font-variant: normal; font-stretch: normal; font-size: 18px; line-height: normal; font-family: Arial; text-align: center; color: rgb(147, 42, 182); padding: 0px; -webkit-appearance: none; background: none;"></div>
                      <div class="knob-label"><?php echo $lang['report_new_quotes']; ?></div>
                    </div><!-- ./col -->
                    
                    <div class="col-xs-6 text-center">
                      <div style="display: inline; width: 90px; height: 90px;"><canvas width="90" height="90"></canvas><input type="text" class="knob" data-readOnly=true value="<?php echo $total_taxes; ?>" data-max="<?php echo $total; ?>" data-width="90" data-height="90" data-fgcolor="#39CCCC" style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; font-weight: bold; font-style: normal; font-variant: normal; font-stretch: normal; font-size: 18px; line-height: normal; font-family: Arial; text-align: center; color: rgb(57, 204, 204); padding: 0px; -webkit-appearance: none; background: none;"></div>
                      <div class="knob-label"><?php echo $lang['report_taxes']; ?> (<?php echo $bd->get_option('money_symbole'); ?>)</div>
                    </div><!-- ./col -->
                  </div><!-- /.row -->
                </div><!-- /.box-body -->
              </div>
              
              <div class="box box-solid">
                <div class="box-header">
                  <i class="fa fa-bar-chart-o"></i>
                  <h3 class="box-title"><?php echo $lang['stats']; ?></h3>
                  
                </div><!-- /.box-header -->
                <div class="box-body">
	                
	                <?php echo $lang['invoices_nbr']; ?> :
                  <div class="graph evol_invoice">
	                <?php 
		                $date = $year . '-1-1';
		                $date_1 = date('Y',strtotime($date . ' -1 year'));
		                $date_2 = date('Y',strtotime($date . ' -2 year'));
		                $date_3 = date('Y',strtotime($date . ' -3 year'));
		                $date_4 = date('Y',strtotime($date . ' -4 year'));
		                $date_5 = date('Y',strtotime($date . ' -5 year'));
		                
	                ?>
	                  <ul class="title">
		                  <?php 
			                  $t0 = $bd->get_results('SELECT COUNT(*) AS nbr FROM ' . $bd->prefix . 'invoices WHERE date LIKE "%/' . $year . '"');
			                  $t0 = $t0[0]->nbr;
			                  $t1 = $bd->get_results('SELECT COUNT(*) AS nbr FROM ' . $bd->prefix . 'invoices WHERE date LIKE "%/' . $date_1 . '"');
			                  $t1 = $t1[0]->nbr;
			                  $t2 = $bd->get_results('SELECT COUNT(*) AS nbr FROM ' . $bd->prefix . 'invoices WHERE date LIKE "%/' . $date_2 . '"');
			                  $t2 = $t2[0]->nbr;
			                  $t3 = $bd->get_results('SELECT COUNT(*) AS nbr FROM ' . $bd->prefix . 'invoices WHERE date LIKE "%/' . $date_3 . '"');
			                  $t3 = $t3[0]->nbr;
			                  $t4 = $bd->get_results('SELECT COUNT(*) AS nbr FROM ' . $bd->prefix . 'invoices WHERE date LIKE "%/' . $date_4 . '"');
			                  $t4 = $t4[0]->nbr;
			                  $t5 = $bd->get_results('SELECT COUNT(*) AS nbr FROM ' . $bd->prefix . 'invoices WHERE date LIKE "%/' . $date_5 . '"');
			                  $t5 = $t5[0]->nbr;
			                  $tmax = round(max($t0,$t1,$t2,$t3,$t4,$t5)+2);
			                  if($tmax > 4){$c = $tmax;}else{$c = 6;}
			                  if($tmax > 4){$count = $tmax/5;}else{$count = 1;}
			                  while($c > 1){
				                  echo '<li>' .round($c). '</li>';
				                  $c -= $count;
			                  }		
			                  if($tmax < 1){$tmax = 1;}	                  
			                  ?>
	                  </ul>
	                  <ul class="content">
		                  <?php
				                echo '<li title="' . $date_5 . '">' . $date_5 . '<hr /><i style="height:' . ((180*$t5/$tmax)-15) . 'px;"><b>' . $t5 .'</b></i></li>';
				                echo '<li title="' . $date_4 . '">' . $date_4 . '<hr /><i style="height:' . ((180*$t4/$tmax)-15) . 'px;"><b>' . $t4 .'</b></i></li>';
				                echo '<li title="' . $date_3 . '">' . $date_3 . '<hr /><i style="height:' . ((180*$t3/$tmax)-15) . 'px;"><b>' . $t3 .'</b></i></li>';
				                echo '<li title="' . $date_2 . '">' . $date_2 . '<hr /><i style="height:' . ((180*$t2/$tmax)-15) . 'px;"><b>' . $t2 .'</b></i></li>';
			                 	echo '<li title="' . $date_1 . '">' . $date_1 . '<hr /><i style="height:' . ((180*$t1/$tmax)-15) . 'px;"><b>' . $t1 .'</b></i></li>';
				                echo '<li title="' . $year . '">' . $year . '<hr /><i style="height:' . ((180*$t0/$tmax)-15) . 'px;"><b>' . $t0 .'</b></i></li>';
			                   ?>
	                  </ul>
                  </div><!-- Stop Graph -->
                  <br />
                     <?php echo $lang['turnover']; ?> :
                  <div class="graph evol_invoice">
	                <?php 
		                $date = $year . '-1-1';
		                $date_1 = date('Y',strtotime($date . ' -1 year'));
		                $date_2 = date('Y',strtotime($date . ' -2 year'));
		                $date_3 = date('Y',strtotime($date . ' -3 year'));
		                $date_4 = date('Y',strtotime($date . ' -4 year'));
		                $date_5 = date('Y',strtotime($date . ' -5 year'));
		                
	                ?>
	                  <ul class="title">
		                  <?php 
			                  $tp0 = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'invoices WHERE date LIKE "%/' . $year . '"');
			                  $t0 = 0;
			                  foreach($tp0 as $r){
				                  $total_taxes = 0;
			                    foreach(unserialize($r->products) as $p){
				                    $total_taxes += $p['qty']*($p['price']*($p['taxes']/100+1));
		                    	}
		                    	$t0 += $total_taxes;
							  }
			                  $tp1 = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'invoices WHERE date LIKE "%/' . $date_1 . '"');
			                  $t1 = 0;
			                  foreach($tp1 as $r){
				                  $total_taxes = 0;
			                    foreach(unserialize($r->products) as $p){
				                    $total_taxes += $p['qty']*($p['price']*($p['taxes']/100+1));
		                    	}
		                    	$t1 += $total_taxes;
							  }
			                  $tp2 = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'invoices WHERE date LIKE "%/' . $date_2 . '"');
			                  $t2 = 0;
			                  foreach($tp2 as $r){
				                  $total_taxes = 0;
			                    foreach(unserialize($r->products) as $p){
				                    $total_taxes += $p['qty']*($p['price']*($p['taxes']/100+1));
		                    	}
		                    	$t2 += $total_taxes;
							  }
			                  $tp3 = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'invoices WHERE date LIKE "%/' . $date_3 . '"');
			                  $t3 = 0;
			                  foreach($tp3 as $r){
				                  $total_taxes = 0;
			                    foreach(unserialize($r->products) as $p){
				                    $total_taxes += $p['qty']*($p['price']*($p['taxes']/100+1));
		                    	}
		                    	$t3 += $total_taxes;
							  }
			                  $tp4 = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'invoices WHERE date LIKE "%/' . $date_4 . '"');
			                  $t4 = 0;
			                  foreach($tp4 as $r){
				                  $total_taxes = 0;
			                    foreach(unserialize($r->products) as $p){
				                    $total_taxes += $p['qty']*($p['price']*($p['taxes']/100+1));
		                    	}
		                    	$t4 += $total_taxes;
							  }
			                  $tp5 = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'invoices WHERE date LIKE "%/' . $date_5 . '"');
			                  $t5 = 0;
			                  foreach($tp5 as $r){
				                  $total_taxes = 0;
			                    foreach(unserialize($r->products) as $p){
				                    $total_taxes += $p['qty']*($p['price']*($p['taxes']/100+1));
		                    	}
		                    	$t5 += $total_taxes;
							  }
			                  $tmax = round(max($t0,$t1,$t2,$t3,$t4,$t5));
			                  if($tmax > 4){$c = $tmax;}else{$c = 6;}
			                  if($tmax > 4){$count = $tmax/5;}else{$count = 1;}
			                  while($c > 1){
				                  echo '<li>' .round($c). '</li>';
				                  $c -= $count;
			                  }
			                  if($tmax < 1){$tmax = 1;}		
			                                    
			                  ?>
	                  </ul>
	                  <ul class="content">
		                  <?php
				                echo '<li title="' . $date_5 . '">' . $date_5 . '<hr /><i style="height:' . ((180*$t5/$tmax)-15) . 'px;"><b>' . $t5 .'</b></i></li>';
				                echo '<li title="' . $date_4 . '">' . $date_4 . '<hr /><i style="height:' . ((180*$t4/$tmax)-15) . 'px;"><b>' . $t4 .'</b></i></li>';
				                echo '<li title="' . $date_3 . '">' . $date_3 . '<hr /><i style="height:' . ((180*$t3/$tmax)-15) . 'px;"><b>' . $t3 .'</b></i></li>';
				                echo '<li title="' . $date_2 . '">' . $date_2 . '<hr /><i style="height:' . ((180*$t2/$tmax)-15) . 'px;"><b>' . $t2 .'</b></i></li>';
			                 	echo '<li title="' . $date_1 . '">' . $date_1 . '<hr /><i style="height:' . ((180*$t1/$tmax)-15) . 'px;"><b>' . $t1 .'</b></i></li>';
				                echo '<li title="' . $year . '">' . $year . '<hr /><i style="height:' . ((180*$t0/$tmax)-15) . 'px;"><b>' . $t0 .'</b></i></li>';
			                   ?>
	                  </ul>
                  </div><!-- Stop Graph -->
                </div>
              </div>
          <!-- Main row -->
          

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
     <?php include('include/footer.php'); ?>
