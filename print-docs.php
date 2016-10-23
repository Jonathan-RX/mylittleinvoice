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
	include('config.php');	
	
?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>MyLittleInvoice | Impression</title>
    <!-- Bootstrap 3.3.4 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
    <!-- FontAwesome 4.3.0 -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />    
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <!-- Date Picker -->
    <link href="plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="dist/css/print.css" />
  </head>
<!-- onload="window.print();" -->
  <body >
	  <div class="page">
	   <?php
	     global $bd;
	     // Enregistrement d'un nouveau devis
	     if(!empty($_GET['id_quote'])){$type_doc = 'quote';$id_doc = $_GET['id_quote'];}
		 if(!empty($_GET['id_invoice'])){$type_doc = 'invoice';$id_doc = $_GET['id_invoice'];}
	     if(!empty($_GET['id_quote']) OR !empty($_GET['id_invoice'])){
		     $results = $bd->get_results('SELECT * FROM ' . $bd->prefix . $type_doc . 's where id="' . $id_doc . '"');
		     $results = $results[0];
		     $customer = unserialize($results->customer);
	     } 
	     
	     // Chargement des infos vendeur
	     $entreprise = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'options WHERE option_name = "entreprise_contact"');
	     $entreprise = unserialize($entreprise[0]->option_value);
	     ?>
	     
    <div class="wrapper">
      <!-- Main content -->
      <section class="invoice">
        <!-- title row -->
        <div class="row">
          <div class="col-xs-12">
            <h2 class="page-header">
              <?php 
	                $logo = $bd->get_option('logo');
	                if(!empty($logo) AND $logo != '1'){
		                echo '<img src="' . $logo .'" style="max-height:48px;max-width:48px;width:auto;height:auto;" />';
	                }else{
		                echo '<i class="fa fa-globe"></i>';
	                }
	                 ?> <?php echo $entreprise['name']; ?>
              <small class="pull-right">Date: <?php echo $results->date; ?></small>
            </h2>
          </div><!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            <address>
              <?php
	                foreach($customer as $c){
		                if($c != ''){echo '<span class="editable line customer_infos">' . $c . '</span><br />';}
	                }
	                 ?>
            </address>
          </div><!-- /.col -->
          
            <div class="col-sm-4 invoice-col">
              
            </div><!-- /.col -->
		  	<div class="col-sm-4 invoice-col">
              <b><?php if($type_doc == 'quote'){echo 'Devis';}else{echo 'Facture';} ?> n°<i style="color:grey;"><?php echo $results->id; ?></i></b><br/>
              <br/>
              <b>N° de commande:</b> <span class="command_number editable line"><?php echo $results->order_number; ?></span><br/>
              <b>Echéance <?php if($type_doc == 'quote'){echo 'du devis';}else{echo 'de règlement';} ?>:</b><span class="editable line date_end"><?php echo $results->date_end; ?></span><br/>
              <b>Compte client:</b> <span class="customer_id"><?php echo $results->customer_id; ?></span>
            </div><!-- /.col -->

        </div><!-- /.row -->

        <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped products">
                <thead>
                  <tr>
                    <th style="width:5%">Qty</th>
                    <th style="width:15%">Référence</th>
                    <th style="width:40%">Description</th>
                    <th style="width:15%">Prix unit.</th>
                    <th style="width:10%">TVA (%)</th>
                    <th style="width:15%">Sous total</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
	                    $total_products = 0;
	                    $total_taxes = 0;
	                    $count = 1;
	                    foreach(unserialize($results->products) as $p){
		                    	if($count > 15){
			                    	?>
			                    	</tbody></table></div></div></section><div class="bottom"><div class="row"><div class="col-xs-6"><p class="lead">Méthodes de règlement :</p><img src="../../dist/img/credit/visa.png" alt="Visa"/><img src="../../dist/img/credit/mastercard.png" alt="Mastercard"/><img src="../../dist/img/credit/american-express.png" alt="American Express"/><img src="../../dist/img/credit/paypal2.png" alt="Paypal"/><div class="text-muted well well-sm no-shadow" style="margin-top: 10px;"><?php echo $results->infos; ?></div></div><div class="col-xs-6"><p class="lead">Montant total :</p><div class="table-responsive"><table class="table"><tr><th style="width:50%">Sous-total HT:</th><td class="subtotal"></td></tr><tr><th>TVA</th><td class="total_taxes"></td></tr><tr><th>Total:</th><td class="totals"></td></tr></table></div></div></div><hr /><span class="invoice_footer editable text"><?php echo $results->footer_infos; ?></span></div></div></div><div class="page"><div class="wrapper"><section class="invoice"><div class="row"><div class="col-xs-12">
            <h2 class="page-header">
              <?php 
	                $logo = $bd->get_option('logo');
	                if(!empty($logo) AND $logo != '1'){
		                echo '<img src="' . $logo .'" style="max-height:48px;max-width:48px;width:auto;height:auto;" />';
	                }else{
		                echo '<i class="fa fa-globe"></i>';
	                }
	                 ?> <?php echo $entreprise['name']; ?>
              <small class="pull-right">Date: <?php echo $results->date; ?></small>
            </h2>
          </div><!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            <address>
              <?php
	                foreach($customer as $c){
		                if($c != ''){echo '<span class="editable line customer_infos">' . $c . '</span><br />';}
	                }
	                 ?>
            </address>
          </div><!-- /.col -->
          
            <div class="col-sm-4 invoice-col">
              
            </div><!-- /.col -->
		  	<div class="col-sm-4 invoice-col">
              <b>Devis n°<i style="color:grey;"><?php echo $results->id; ?></i></b><br/>
              <br/>
              <b>N° de commande:</b> <span class="command_number editable line"><?php echo $results->order_number; ?></span><br/>
              <b>Echéance du devis:</b> <span class="editable line date_end"><?php echo $results->date_end; ?></span><br/>
              <b>Compte client:</b> <span class="customer_id"><?php echo $results->customer_id; ?></span>
            </div><!-- /.col -->

        </div><!-- /.row -->

        <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped products">
                <thead>
                  <tr>
                    <th style="width:5%">Qty</th>
                    <th style="width:15%">Référence</th>
                    <th style="width:40%">Description</th>
                    <th style="width:15%">Prix unit.</th>
                    <th style="width:10%">TVA (%)</th>
                    <th style="width:15%">Sous total</th>
                  </tr>
                </thead>
                <tbody>
			                    	<?php
				                    	$count=1;
		                    	}
		                    	$taxes = $p['price']*($p['taxes']/100);
		                    	$total = ($taxes+$p['price'])*$p['qty'];
		                    	$total_products += $p['price']*$p['qty'];
		                    	$total_taxes += $taxes*$p['qty'];
		                    	if($p['qty'] == ''){$total = '';}else{$total = number_format($total,2) . '€';}
	                    		echo ' <tr><td class="qty">' . $p['qty'] . '</td><td class="ref">' . $p['ref'] . '</td><td class="description">' . $p['description'] . '</td><td class="price">' . $p['price'] . '</td><td class="taxes">' . $p['taxes'] . '</td><td class="total">' . $total . '</td></tr>';
	                    		$count++;
	                    }
	                     ?>
                </tbody>
              </table>
              
            </div><!-- /.col -->
          </div><!-- /.row -->
          
         

        </section><!-- /.content -->
       <div class="bottom">
	       <div class="row">
          <!-- accepted payments column --><div class="col-xs-6">
            <p class="lead">Méthodes de règlement :</p>
            <img src="../../dist/img/credit/visa.png" alt="Visa"/>
            <img src="../../dist/img/credit/mastercard.png" alt="Mastercard"/>
            <img src="../../dist/img/credit/american-express.png" alt="American Express"/>
            <img src="../../dist/img/credit/paypal2.png" alt="Paypal"/>
            <div class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
             <?php echo $results->infos; ?>
            </div>
          </div><!-- /.col -->
          <div class="col-xs-6">
            <p class="lead">Montant total :</p>
            <div class="table-responsive">
              <table class="table">
                  <tr>
                    <th style="width:50%">Sous-total HT:</th>
                    <td class="subtotal"><?php echo number_format($total_products,2); ?>€</td>
                  </tr>
                  <tr>
                    <th>TVA</th>
                    <td class="total_taxes"><?php echo number_format($total_taxes,2); ?>€</td>
                  </tr>
                  <tr>
                    <th>Total:</th>
                    <td class="totals"><?php echo number_format($total_products+$total_taxes,2); ?>€</td>
                  </tr>
                </table>
            </div>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
        
              <hr /><span class="invoice_footer editable text"><?php echo $results->footer_infos; ?></span>
		</div>
    </div><!-- ./wrapper -->
    <!-- AdminLTE App -->
    
    <script src="../../dist/js/app.min.js" type="text/javascript"></script>
	  </div>
  </body>
</html>
