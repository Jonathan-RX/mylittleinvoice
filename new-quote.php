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
	// Chargement du fichier CSS s'il s'agit d'un user agent smartphones
			$insert_in_head = '<style type="text/css">.pull-right{margin-left:5px;}.total{font-weight:bold;}
			.customers_box{
				position:absolute;
				width:70%;
				height: 400px;
				margin: auto;
				border:1px solid #eee;
				background:#fff;
				z-index:100;
				padding:20px;
				display:none;
			}
			.products td{border-right:1px solid #ccc}
			.customers_box h4{margin:0;padding:0;margin-bottom:10px;}
			.customers_list{font-size:12px;}
			.customers_list_box{overflow:scroll;height:275px;overflow : -moz-scrollbars-vertical;}
			.editable{min-width:70px;height:15px;display:inline-block;}
			.close{float:right;font-weight:bold;font-familly:Arial;}
			.selected{background:#eee;}
			.editable,.qty,.ref,.description,.price,.tva{cursor: pointer;}
			.products_type{position:absolute;width:60%;height:420px;background:#fff;border:1px solid grey;padding:20px;z-index:100;margin-left:30%;display: none;}
			.products_type table{width:100%;overflow-y: scroll;height:80%;display:block;}
			.products_type textarea{display:none;}
			.btn-xl{text-align: center;}
			</style>';
			$ua = $_SERVER['HTTP_USER_AGENT'];
			if (preg_match('/iphone/i',$ua) || preg_match('/android/i',$ua) || preg_match('/blackberry/i',$ua) || preg_match('/symb/i',$ua) || preg_match('/ipod/i',$ua) || preg_match('/phone/i',$ua)){
				$insert_in_head .= '<link rel="stylesheet" type="text/css" href="dist/css/smartphones.css" />';
			}
	include('include/head.php');
	?>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">
      
      <?php 
	      $horizontal_menu = '<li><a href="#" onclick="print_pt();return false;">' . $lang['product_type'] . '</a></li>';
	      include('include/header.php'); ?>
      <!-- Left side column. contains the logo and sidebar -->
      <?php include('include/left.php'); ?>
       
       <?php
			
	     global $bd;
	     // Chargement des infos du devis de base pour la duplication
	     if(isset($_GET['duplicate_quote'])){
		     $p = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'quotes WHERE id="' . $_GET['duplicate_quote'] . '"');
		     $p = $p[0];
		     $p->customer = unserialize($p->customer);
		     $products = unserialize($p->products);
		     $_GET['id_customer'] = $p->customer_id;
		     $order_number = $p->order_number;
		     $date = $p->date;
		     $date_end = $p->date_end;
		     $infos = $p->infos;
		     $footer_infos = $p->footer_infos;
	     }else{
		     $products = array(array('qty'=>'0','ref'=>'Ref','description'=>'Description','price'=>'0','taxes'=>0));
		     $order_number = '00000000';
		     $date = date('d/m/Y');
		     $end = $bd->get_option('default_quote_validity');
		     $date_end = date('d/m/Y',strtotime(date('Y-m-d') . ' +' . $end . 'days'));
		     $infos = $bd->get_option('default_invoice_informations');
		     $footer_infos = $bd->get_option('default_invoice_footer');
	     }
	     // Chargement des infos clients si communiqué, ou ajout des infos par défaut
	     if(isset($_GET['id_customer'])){
		     $results = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'customers where id="' . $_GET['id_customer'] . '"');
		     $results = $results[0];
		     $customer = array($results->name,$results->adressnumber . ' ' . $results->adress,$results->adresscomplet,$results->postalcode . ' ' . $results->city,$results->phone,$results->mail);
	     }else{
		     $customer = array($lang['name_first_name'],
						     $lang['adress_1'],
						     $lang['adress_2'],
						     $lang['postalcode'] .  ', ' . $lang['city'],
						     $lang['phone'],
						     $lang['email']);
						     $results = new stdClass;
						     $results->id = '00000';
	     } 
	     // Chargement des infos vendeur
	     $entreprise = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'options WHERE option_name = "entreprise_contact"');
	     $entreprise = unserialize($entreprise[0]->option_value);
	     ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
	        <div class="products_type"><h4><?php echo $lang['product_type']; ?></h4>
	        	<table class="table table-hover">
		        	<thead>
			        	<tr><th><?php echo $lang['reference']; ?></th><th><?php echo $lang['name']; ?></th><th></th></tr>
		        	</thead>
					<tbody>
						<?php
							$pt = unserialize($bd->get_option('products_type'));
							foreach($pt as $key => $p){
								$taxes = $p['price']*($p['taxes']/100);           
								$total = ($taxes+$p['price'])*$p['qty'];
								echo '<tr id="pt_' . $key . '"><td>' . $p['ref'] . '</td><td>' . $p['description'] . '</td><td><a href="#" class="btn-xs btn-success pull-right" onclick="insert_product_type(' . $key . ');return false;"><i class="fa fa-plus"> ' . $lang['add'] . '
								<textarea class="qty">' . $p['qty'] . '</textarea>
								<textarea class="ref">' . $p['ref'] . '</textarea>
								<textarea class="description">' . $p['description'] . '</textarea>
								<textarea class="price">' . $p['price'] . '</textarea>
								<textarea class="taxes">' . $p['taxes'] . '</textarea>
								<textarea class="total">' . number_format($total,2) . $bd->get_option('money_symbole') . '</textarea>
								</a></td></tr>';
							}
							 ?>
					</tbody>
	        	</table>
				<a href="#" class="btn btn-default btn-xl pull-right" onclick="jQuery('.products_type').slideUp();"><?php echo $lang['close']; ?></a>
	        </div>
          <h1>
           <i class="fa fa-file-text-o"></i> <?php echo $lang['quotes']; ?>
		<a href="#" class="btn btn-info btn-xs newinvoice" onclick="jQuery('.customers_box').fadeIn();"><i class="fa fa-user"></i> <?php echo $lang['change_customer']; ?></a>
		</h1>
<div class="customers_box">
	<a href="#" class="close" onclick="jQuery('.customers_box').fadeOut();">X</a>
	<h4><?php echo $lang['customers_list']; ?></h4>
	<div class="col-xs-4">
		        <input type="text" name="search" class="search_cmp search_what form-control" placeholder="<?php echo $lang['search']; ?>" class="form-margin" style="height:22px;" />
	        </div>
	        <div class="col-xs-4">
	            <select class="search_where search_cmp form-control col-xs-3" style="height:22px;">
		            <option value=""><?php echo $lang['search_in']; ?>...</option>
		            <option value="id"><?php echo $lang['search_in_customer']; ?></option>
		            <option value="name"><?php echo $lang['name']; ?></option>
		            <option value="adress"><?php echo $lang['adress_1']; ?></option>
		            <option value="postalcode"><?php echo $lang['postalcode']; ?></option>
		            <option value="city"><?php echo $lang['city']; ?></option>
		            <option value="phone"><?php echo $lang['phone']; ?></option>
		            <option value="mail"><?php echo $lang['email']; ?></option>
	            </select>
	        </div>
	        <br />
	        <br />
			<div class="customers_list_box">
				<table class="table table-bordered table-hover customers_list">
					<thead>
	                      <tr>
	                        <th><?php echo $lang['adressnumber']; ?></th>
	                        <th><?php echo $lang['name']; ?></th>
	                        <th><?php echo $lang['phones']; ?></th>
	                        <th><?php echo $lang['email']; ?></th>
	                        <th><?php echo $lang['city']; ?></th>
	                      </tr>
	                    </thead>
						<tbody></tbody>
				</table>
			</div>
			<a href="#" class="btn btn-success btn-xs valid_customer" style="float:right;margin-top:5px;"><?php echo $lang['validate']; ?></a>
			<a href="#" class="btn btn-default btn-xs newinvoice" onclick="jQuery('.customers_box').fadeOut();"><?php echo $lang['cancel']; ?></a>
		</div>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $lang['home']; ?></a></li>
            <li><a href="quotes.php"><?php echo $lang['quotes']; ?></a></li>
            <li class="active"><?php echo $lang['new_quote']; ?></li>
          </ol>
        </section>

        <div class="pad margin no-print">
          <div class="callout callout-info" style="margin-bottom: 0!important;">												
            <h4><i class="fa fa-info"></i> <?php echo $lang['edit_quote_title']; ?>:</h4>
            <?php echo $lang['edit_quote_text']; ?>
          </div>
        </div>

       
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
                <small class="pull-right"><?php echo $lang['date']; ?>: <span class="editable date"><?php echo date('d/m/Y'); ?></span></small>
              </h2>
            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-7 invoice-col">
              <address>
                <?php
	                foreach($customer as $c){
		                if($c != ''){echo '<span class="editable line customer_infos">' . $c . '</span><br />';}
	                }
	                 ?>
              </address>
              <a href="#" onclick="customer_add_line();return false;" class="btn-xs btn-success"><i class="fa fa-plus"></i> <?php echo $lang['add_line']; ?></a>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <b><?php echo $lang['quote_number']; ?><i style="color:grey;"> <?php echo $lang['save_for_nbr']; ?></i></b><br/>
              <br/>
              <b><?php echo $lang['command_number']; ?>:</b> <span class="command_number editable line"><?php echo $order_number; ?></span><br/>
              <b><?php echo $lang['quote_end']; ?>:</b> <span class="editable line date_end"><?php echo $date_end; ?></span><br/>
              <b><?php echo $lang['customer_number']; ?>:</b> <span class="customer_id"><?php echo $results->id; ?></span>
            </div><!-- /.col -->
          </div><!-- /.row -->

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped products">
                <thead>
                  <tr>
                    <th style="width:5%"><?php echo $lang['quantity']; ?></th>
                    <th style="width:15%"><?php echo $lang['product_ref']; ?></th>
                    <th style="width:40%"><?php echo $lang['description']; ?></th>
                    <th style="width:15%"><?php echo $lang['price']; ?></th>
                    <th style="width:10%"><?php echo $lang['product_taxes']; ?></th>
                    <th style="width:15%"><?php echo $lang['little_total']; ?></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                     <?php 
	                    $total_products = 0;
	                    $total_taxes = 0;
	                    foreach($products as $p){
		                    	$taxes = $p['price']*($p['taxes']/100);
		                    	$total = ($taxes+$p['price'])*$p['qty'];
		                    	$total_products += $p['price']*$p['qty'];
		                    	$total_taxes += $taxes*$p['qty'];
	                    		echo ' <tr><td class="qty">' . $p['qty'] . '</td><td class="ref">' . $p['ref'] . '</td><td class="description">' . $p['description'] . '</td><td class="price">' . $p['price'] . '</td><td class="taxes">' . $p['taxes'] . '</td><td class="total">' . number_format($total,2) . $bd->get_option('money_symbole') . '</td><td class="delete"><a href="#" class="btn-xs btn-danger"><i class="fa  fa-trash"></i></a></td></tr>';
	                    }
	                     ?>                </tbody>
              </table>
              <a href="#" class="btn-xs btn-success" style="float:right;margin:5px;" onclick="addLine();return false;"><i class="fa fa-plus"> <?php echo $lang['add_line']; ?></i></a>
            </div><!-- /.col -->
          </div><!-- /.row -->

          <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6 infos">
              <p class="lead"><?php echo $lang['payment_methods']; ?>:</p>
              <img src="../../dist/img/credit/visa.png" alt="Visa"/>
              <img src="../../dist/img/credit/mastercard.png" alt="Mastercard"/>
              <img src="../../dist/img/credit/american-express.png" alt="American Express"/>
              <img src="../../dist/img/credit/paypal2.png" alt="Paypal"/>
              <div class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                <span class="editable invoice_informations text" style="overflow: hidden;display:inline-block;min-height:50px;height: auto;"><?php echo $infos; ?></span>        
                </div>
            </div><!-- /.col -->
            <div class="col-xs-6" total_box>
              <p class="lead"><?php echo $lang['total_amount']; ?> :</p>
              <div class="table-responsive">
                <table class="table">
                  <tr>
                    <th style="width:50%"><?php echo $lang['ltotal']; ?>:</th>
                    <td class="subtotal">0.00<?php echo $bd->get_option('money_symbole'); ?></td>
                  </tr>
                  <tr>
                    <th><?php echo $lang['taxes']; ?></th>
                    <td class="total_taxes">0.00<?php echo $bd->get_option('money_symbole'); ?></td>
                  </tr>
                  <tr>
                    <th><?php echo $lang['total']; ?>:</th>
                    <td class="totals">0.00<?php echo $bd->get_option('money_symbole'); ?></td>
                  </tr>
                </table>
              </div>
            </div><!-- /.col -->
          </div><!-- /.row -->
          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-xs-12 button_box">
              <form action="edit-quote.php" method="post" class="form">
              	<a href="#" target="_blank" class="btn btn-default print" style="opacity:0.5;" onclick="return false;"><i class="fa fa-print"></i> <?php echo $lang['print']; ?></a>
	            <input type="hidden" name="new_quote" value="true" />
              	<a href="#" class="btn btn-success pull-right valid_form" ><i class="fa fa-hdd-o"></i> <?php echo $lang['save']; ?> </a>
			  	<a href="#" class="btn btn-primary pull-right" style="opacity:0.5;" onclick="return false;"><i class="fa fa-download"></i> <?php echo $lang['create_pdf']; ?></a>
			  </form>
              <hr /><span class="invoice_footer editable text" style="overflow: hidden;display:inline-block;min-height:50px;height: auto;"><?php echo $footer_infos; ?></span>
            </div>
          </div>
        </section><!-- /.content -->
        <div class="clearfix"></div>
      </div><!-- /.content-wrapper -->
       <?php include('include/footer.php'); ?>
	   <script language="JavaScript">
			   (function($){
				   $('.products tbody').sortable();
					calcul_total();
			    	// Gestion des éditions
			    	$(document).on('click','.editable',function(e){
				    	if(!$(e.target).is('textarea') && !$(e.target).is('input') && !$(e.target).is('.wysihtml5-toolbar') && !$(e.target).is('a') && !$(e.target).is('.edit') && !$(e.target).is('.datepicker-days')){
					    	$('.edit').parent('td').html($('.edit').val());
							$('.edit').parent('span').html($('.edit').val());
							calcul_total();
				    		var content = $(this).html();
				    		if($(this).hasClass('text')){
					    		$(this).html('<textarea class="edit textedit" style="width:' + $(this).parent('div').width() + 'px;">' + content + '</textarea>');
					    	}else{
					    		$(this).html('<input type="text" class="edit" style="width:' + $(this).width()*2 + 'px;" />');
					    		$('.edit').val(content);
					    	}
					    	$(this).children('input').select();
					    	$('.textedit').wysihtml5();
							jQuery('.btn-group').hide();jQuery('.dropdown').hide();jQuery('.glyphicon-quote').parent('a').hide();jQuery('.glyphicon-list').parent('a').parent('div').hide();jQuery('.glyphicon-share').parent('a').parent('li').hide();jQuery('.glyphicon-picture').parent('a').parent('li').hide();jQuery('a[data-wysihtml5-command=bold]').text('Gras');jQuery('a[data-wysihtml5-command=italic]').text('Italique');jQuery('a[data-wysihtml5-command=underline]').text('Souligné');jQuery('a[data-wysihtml5-command=small]').text('Petit');
					    	e.stopPropagation();
					    }
			    	});
			    	// Déclenchement de l'édition d'une des balises de la liste des produits
			    	$(document).on('click','.products td',function(e){
				    	if(!$(e.target).is('textarea') && !$(e.target).is('input')){
					    		$('.edit').parent('td').html($('.edit').val());
							    $('.edit').parent('span').html($('.edit').val());
								calcul_total();
					    	if($(this).hasClass('total') || $(this).hasClass('delete')){}else{var content = $(this).text();
						    	$(this).html('<input type="text" class="edit" style="width:' + $(this).width() + 'px;" />');
					    		$('.edit').val(content);
						    	$(this).children('input').select();
						    	e.stopPropagation(); 
					    	}
					    }
			    	});
			    	// Suppresion d'une des lignes de la liste des produits
			    	$(document).on('click','.delete a',function(e){
				    	if (confirm('<?php echo $lang['confirm_line_delete']; ?>')) {
					    	$(this).parent('td').parent('tr').remove();
					    	return false;
					    }
			    	});
			    	// Gestion de la touche "Tab" et "Entrer" dans la liste des produits
			    	$(document).on('keydown','.edit',function(event){
				    	// Touche Tab
				    	if(event.keyCode == '9'){
					    	if(event.shiftKey){
					    		if($(objet).hasClass('qty')){
						    		objet = $('.edit').parent('td').parent('tr').prev('tr').children('.taxes');
					    		}else{
					    			objet = $('.edit').parent('td').prev('td');
					    		}
					    	}else{
					    		objet = $('.edit').parent('td').next('td');
					    	}
					    	$('.edit').parent('span').html($('.edit').val());	
					    	$('.edit').parent('td').html($('.edit').val());
					    	if($(objet).hasClass('total') || $(objet).hasClass('delete') || $(objet).hasClass('delete')){
						    	objet = $(objet).parent('tr').next('tr').children('.qty');
					    	}
							calcul_total();
				    		var content = $(objet).text();
					    	$(objet).html('<input type="text" class="edit" name="edit" style="position:absolute;width:' + $(objet).width() + 'px;" />');
					    	$('.edit').val(content);
					    	$(objet).children('input').select();
					    	event.stopPropagation(); 
					    	return false;
				    	}
				    	// Touche entré
				    	if(event.keyCode == '13'){
					    	objet = $('.edit').parent('td').next('td');
					    	edit = $('.edit').parent('td');
					    	$('.edit').parent('span').html($('.edit').val());	
					    	$('.edit').parent('td').html($('.edit').val());
							calcul_total();
				    		var content = $(objet).text();
				    		nextline = $(objet).parent('tr');
				    		if($(edit).hasClass('description')){
					    		jQuery('<tr><td class="qty"></td><td class="ref"></td><td class="description"><input type="text" class="edit" name="edit" style="position:absolute;width:' + $(objet).width() + 'px;" /></td><td class="price"></td><td class="taxes"></td><td class="total"></td><td class="delete"><a href="#" class="btn-xs btn-danger"><i class="fa  fa-trash"></i></a></td></tr>').insertAfter(nextline);
					    	}else{
						    	jQuery('<tr><td class="qty"><input type="text" class="edit" name="edit" style="position:absolute;width:' + $(edit).width() + 'px;" /></td><td class="ref"></td><td class="description"></td><td class="price"></td><td class="taxes"></td><td class="total"></td><td class="delete"><a href="#" class="btn-xs btn-danger"><i class="fa  fa-trash"></i></a></td></tr>').insertAfter(nextline);
					    	}
					    	$('.edit').focus();
					    	event.stopPropagation(); 
					    	return false;
				    	}
				    });
				    // Sortie d'une balise en cours d'édition
			    	$(document).on('click', function(e){
				    		if(!$(e.target).is('textarea') && !$(e.target).is('input') && !$(e.target).is('.wysihtml5-toolbar') && !$(e.target).is('a')){
							    $('.edit').parent('td').html($('.edit').val().replace( /\r?\n/g, "<br>" ));
							    $('.edit').parent('span').html($('.edit').val());
								calcul_total();
							}
			    	});
			    	// Validation du formulaire
			    	$('.valid_form').click(function(){
				    	$('.edit').parent('td').html($('.edit').val());
					$('.edit').parent('span').html($('.edit').val());
					calcul_total();
					var counter = 0;
				    $('.customer_infos').each(function(){
					    	$('<textarea style="display:none;" name="customer[' + counter + ']">' + $(this).html() + '</textarea>').appendTo('.form');
					    	counter++;
				    	});
					    $('<textarea style="display:none;" name="customer_id">' + $('.customer_id').html() + '</textarea>').appendTo('.form');
					    $('<textarea style="display:none;" name="order_number">' + $('.command_number').html() + '</textarea>').appendTo('.form');
					    $('<textarea style="display:none;" name="date">' + $('.date').html() + '</textarea>').appendTo('.form');
					    $('<textarea style="display:none;" name="date_end">' + $('.date_end').html() + '</textarea>').appendTo('.form');
					    var counter = 0;
				    	$('.products tbody tr').each(function(){
					    	$('<textarea style="display:none;" name="products[' + counter + '][qty]">' + $(this).children('.qty').text() + '</textarea>').appendTo('.form');
					    	$('<textarea style="display:none;" name="products[' + counter + '][ref]">' + $(this).children('.ref').text() + '</textarea>').appendTo('.form');
					    	$('<textarea style="display:none;" name="products[' + counter + '][description]">' + $(this).children('.description').text() + '</textarea>').appendTo('.form');
					    	$('<textarea style="display:none;" name="products[' + counter + '][price]">' + $(this).children('.price').text() + '</textarea>').appendTo('.form');
					    	$('<textarea style="display:none;" name="products[' + counter + '][taxes]">' + $(this).children('.taxes').text() + '</textarea>').appendTo('.form');
					    	counter++;
				    	});
					    $('<textarea style="display:none;" name="infos">' + $('.invoice_informations').html() + '</textarea>').appendTo('.form');
					    $('<textarea style="display:none;" name="footer_infos">' + $('.invoice_footer').html() + '</textarea>').appendTo('.form');
					    $('.form').submit();
			    	});
				})(jQuery);
				function addLine(){
					jQuery('<tr><td class="qty"></td><td class="ref"></td><td class="description"></td><td class="price"></td><td class="taxes"></td><td class="total"></td><td class="delete"><a href="#" class="btn-xs btn-danger"><i class="fa  fa-trash"></i></a></td></tr>').appendTo('.products tbody');
				}
				function calcul_total(){
					var total = 0;
			    	var total_taxes = 0;
			    	$('.qty').parent('tr').each(function(){
				    	var qty = parseFloat($(this).children('.qty').text());
				    	var taxe = parseFloat($(this).children('.taxes').text());
				    	taxe = parseFloat(taxe/100);
				    	var price = parseFloat($(this).children('.price').text());
				    	t = qty*price;
				    	if(isNaN(t)){
				    		$(this).children('.total').text('');
			    		}else{
				    		total += t;
					    	total_taxes += t*taxe;
					    	t += taxe*t;
				    		$(this).children('.total').text(t.toFixed(2) + '<?php echo $bd->get_option('money_symbole'); ?>');
				    	}
			    	});
			    	$('.subtotal').text(total.toFixed(2) + '<?php echo $bd->get_option('money_symbole'); ?>');
			    	$('.total_taxes').text(total_taxes.toFixed(2) + '<?php echo $bd->get_option('money_symbole'); ?>');
			    	total += total_taxes;
			    	$('.totals').text(total.toFixed(2) + '<?php echo $bd->get_option('money_symbole'); ?>');
			    	
				}
				function print_pt(){
					jQuery('.products_type').slideDown();
				}
				function refresh_customers(){
					var search_what = jQuery('.search_what').val();
				    var search_where = jQuery('.search_where').val();
				    $.get('ajax.php',
				   { get_customers_list: 'true',
					 search_what: search_what,
					 search_where: search_where
				   },
				   function(data){
				     jQuery('.customers_list tbody').html('');
				     jQuery(data).appendTo('.customers_list tbody');
				   });
				}
				// Ajout d'une ligne dans les coordonnées du client
			    	function customer_add_line(){
				    	jQuery('<span class="editable line customer_infos"><?php echo $lang['new_line'];?></span><br />').appendTo('address');
			    	}
				function selection(id){
					jQuery('.selected').removeClass('selected');
					jQuery('#' + id).addClass('selected');
				}
				function insert_product_type(id){
					var qty = jQuery('#pt_'+id+' .qty').val();
					var ref = jQuery('#pt_'+id+' .ref').val();
					var description = jQuery('#pt_'+id+' .description').val();
					var price = jQuery('#pt_'+id+' .price').val();
					var taxes = jQuery('#pt_'+id+' .taxes').val();
					var total = jQuery('#pt_'+id+' .total').val();
					jQuery('<tr><td class=qty>' + qty + '</td><td class=ref>'+ref+'</td><td class=description>'+description+'</td><td class=price>'+price+'</td><td class=taxes>'+taxes+'</td><td class=total>'+total+'</td><td class=delete><a href="#" class="btn-xs btn-danger"><i class="fa  fa-trash"></i></a></td></tr>').appendTo('.products');
				}
			
				(function($){
					refresh_customers();
					$('.search_where,.search_what').change(function(){
					    refresh_customers();
					});
					$('.valid_customer').click(function(){
						var id_customer = $('.selected').attr('id');
						$('.customer_id').text(id_customer);
						$.get('ajax.php',
						   { get_customers_infos: id_customer
						   },
						   function(data){
						     jQuery('address').html('');
						     jQuery(data).appendTo('address');
						   });
						jQuery('.customers_box').fadeOut();
					});
				})(jQuery);
       </script>
