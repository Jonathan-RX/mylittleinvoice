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
	<style type="text/css">
		body{
			height:auto;
			width : 7.2cm;
			font-family: Arial,Verdana;
		}
		.total,.doc_infos{text-align:right;}
		.table, .table tr{width:100%;}
		.table td{width:50px;}
		.table-responsive{text-align:right;width:100%;}
		.invoice_footer{text-align: center;}
	</style>
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
		  	<div class="col-sm-4 invoice-col doc_infos">
              <b><?php if($type_doc == 'quote'){echo 'Devis';}else{echo 'Facture';} ?> n°<i style="color:grey;"><?php echo $results->id; ?></i></b>
              <br />
              <b>Date:</b> <?php echo $results->date; ?>
              <br/>
              <b>N° de commande:</b> <span class="command_number editable line"><?php echo $results->order_number; ?></span><br/>
              <b>Echéance <?php if($type_doc == 'quote'){echo 'du devis';}else{echo 'de règlement';} ?>:</b><span class="editable line date_end"><?php echo $results->date_end; ?></span><br/>
              <b>Compte client:</b> <span class="customer_id"><?php echo $results->customer_id; ?></span>
            </div><!-- /.col -->

        </div><!-- /.row -->
<hr />
        <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped products">
                <thead>
                  <tr>
                    <th style="width:5%;">Qty</th>
                    <th style="width:15%;">Ref</th>
                    <th style="width:40%;">Description</th>
                    <th style="width:15%;">Sous total</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
	                    $total_products = 0;
	                    $total_taxes = 0;
	                    $count = 1;
	                    foreach(unserialize($results->products) as $p){
		                    	$taxes = $p['price']*($p['taxes']/100);
		                    	$total = ($taxes+$p['price'])*$p['qty'];
		                    	$total_products += $p['price']*$p['qty'];
		                    	$total_taxes += $taxes*$p['qty'];
	                    		echo ' <tr><td class="qty">' . $p['qty'] . '</td><td class="ref">' . $p['ref'] . '</td><td class="description">' . $p['description'] . '</td><td class="total">' . number_format($taxes,2) . '</td></tr>';
	                    		$count++;
	                    }
	                     ?>
                </tbody>
              </table>
              
            </div><!-- /.col -->
          </div><!-- /.row -->
          
         

        </section><!-- /.content -->
       
          
        </div><!-- /.row -->
        <hr />
        <div class="bottom">
	       <div class="row">
          <!-- accepted payments column --><div class="col-xs-6">
           
            
          </div><!-- /.col -->
          <div class="col-xs-6">
            <div class="table-responsive">
              <table class="table">
                  <tr>
                    <th style="width:80%">Sous-total HT:</th>
                    <td class="subtotal"><?php echo number_format($total_products,2); ?>€</td>
                  </tr>
                  <tr>
                    <th>TVA :</th>
                    <td class="total_taxes"><?php echo number_format($total_taxes,2); ?>€</td>
                  </tr>
                  <tr>
                    <th>Total:</th>
                    <td class="totals"><?php echo number_format($total_products+$total_taxes,2); ?>€</td>
                  </tr>
                </table>
            </div>
            <div class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
             <?php echo $results->infos; ?>
            </div>
          </div><!-- /.col -->
              <hr /><span class="invoice_footer editable text"><?php echo $results->footer_infos; ?></span>
              
		</div>
    </div>
	  </div>
  </body>
</html>
