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
	$insert_in_head = '<style type="text/css">select{height:15px;}.dates{width:10%;}
	.payment_box{
				position:absolute;
				width:400px;
				height: 170px;
				margin: 0 30px 0;
				border:1px solid #888;
				background:#fff;
				z-index:100;
				padding:20px;
				display:none;
			}
			.payments_box{
				position:absolute;
				width:400px;
				height: 300px;
				margin: 0 30px 0;
				border:1px solid #888;
				background:#fff;
				z-index:100;
				padding:20px;
				display:none;
			}
			.payment_box h4{margin:0;padding:0;margin-bottom:10px;}
			.payment_box table,.payment_box select{width:100%;}
			.payment_box th{width:50%;}
			.payment_box input{height:20px;padding:2px;}
			.payment_box tbody td{cursor:pointer;}
			.close_box{position:absolute;margin-top : 200px;}
	</style>';
	$ua = $_SERVER['HTTP_USER_AGENT'];
			if (preg_match('/iphone/i',$ua) || preg_match('/android/i',$ua) || preg_match('/blackberry/i',$ua) || preg_match('/symb/i',$ua) || preg_match('/ipod/i',$ua) || preg_match('/phone/i',$ua)){
				$insert_in_head .= '<link rel="stylesheet" type="text/css" href="dist/css/smartphones.css" />';
			}

	include('include/head.php');
	global $bd;
	global $lang;
	if(isset($_GET['archive'])){
		$archive = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'invoices WHERE id="' . $_GET['archive'] . '"');
		if($archive['0']->archived == 'true'){$ar = 'false';}else{$ar = 'true';}
		$bd->update($bd->prefix.'invoices',array('archived'=>$ar),array('id'=>$_GET['archive']));
	}
	?>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">
      
      <?php 
	     
	     
	      include('include/header.php'); ?>
      <!-- Left side column. contains the logo and sidebar -->
      <?php include('include/left.php'); ?>
        <!-- Main content -->
        <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <i class="fa fa-file-text"></i> <?php echo $lang['invoices_list'];?>
                <small></small>   
           </h1><br />
            <a href="new-invoice.php" class="btn btn-success btn-xs"><i class="fa fa-file-text-o"></i> <?php echo $lang['add'];?></a>
<a href="#" class="btn btn-primary btn-xs duplicate" style="opacity: 0.4;"><i class="fa fa-plus-square-o"></i> <?php echo $lang['duplicate'];?></a>
<a href="#" class="btn btn-default btn-xs archive" style="opacity: 0.4;"><i class="fa fa-plus-square-o"></i> <?php echo $lang['archive'];?></a>
<a href="#" class="btn btn-success btn-xs new_payment" style="opacity: 0.4;"><i class="fa  fa-credit-card"></i> <?php echo $lang['collect'];?></a>
<a href="#" class="btn btn-warning btn-xs print" target="_blank" style="opacity: 0.4;"><i class="fa fa-print"></i></i> <?php echo $lang['print'];?></a>
<a href="#" class="btn btn-primary btn-xs ticket" target="_blank" style="opacity: 0.4;"><i class="fa fa-ticket"></i></i> <?php echo $lang['ticket'];?></a>
<a href="#" class="btn btn-success btn-xs export" target="_blank" style="opacity: 0.4;"><i class="fa fa-download"></i><?php echo $lang['pdf_button'];?></a>
          
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $lang['home'];?></a></li>
            <li class="active"><?php echo $lang['invoices'];?></li>
          </ol>
        </section>
        <!-- Box d'encaissement -->
		<div class="payment_box">
			<h4><?php echo $lang['new_payment'];?></h4>
			<table>
				<tr>
					<th><?php echo $lang['invoice_nbr'];?> :</th>
					<td><input type="text" name="id_invoice" class="form-control payment_id" /></td>
				</tr>
				<tr>
					<th><?php echo $lang['payment_date'];?> :</th>
					<td><input type="text" name="date" class="form-control payment_date" /></td>
				</tr>
				<tr>
					<th><?php echo $lang['payment_mode'];?> :</th>
					<td>
						<select name="mode" class="payment_mode">
							<option value="species"><?php echo $lang['species'];?></option>
							<option value="check"><?php echo $lang['check'];?></option>
							<option value="transfer"><?php echo $lang['transfer'];?></option>
							<option value="paypal"><?php echo $lang['paypal'];?></option>
							<option value="creditcard"><?php echo $lang['credit_card'];?></option>
							<option value="mandate"><?php echo $lang['money_order'];?></option>
						</select>
					</td>
				</tr>
				<tr>
					<th><?php echo $lang['amount'];?> :</th>
					<td><input type="text" name="amount" class="form-control payment_amount" /></td>
				</tr>
			</table>
			<a href="#" class="btn btn-success btn-xs valid_customer" style="float:right;margin-top:5px;" onclick="valid_payment();"><?php echo $lang['validate'];?></a>
			<a href="#" class="btn btn-default btn-xs" onclick="jQuery('.payment_box').fadeOut();"><?php echo $lang['cancel'];?></a>
		</div>
		<!-- Liste des encaissements -->
		<div class="payments_box">
			<h4><?php echo $lang['payments_list'];?></h4>
			<a href="#" class="btn btn-default btn-xs close_box" onclick="jQuery('.payments_box').fadeOut();"><?php echo $lang['close'];?></a>
			<table class="table table-bordered table-hover payments_list">
				<thead>
					<tr><th><?php echo $lang['date'];?></th><th><?php echo $lang['mode'];?></th><th><?php echo $lang['amount'];?></th></tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
		</div>
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
	          <div class="box">
                 <div class="box-body">
	        <div class="col-xs-2 legend"><?php echo $lang['display'];?> : </div>
	            <div class="col-xs-2">
                    <select class="get_archived search_cmp form-control col-xs-3" style="height:22px;">
		                <option value="current"><?php echo $lang['archive_current'];?></option>
		                <option value="archived"><?php echo $lang['archive_archived'];?></option>
		                <option value="all"><?php echo $lang['archive_all'];?></option>
	                </select>
	            </div>
	        <div class="col-xs-2">
		        <input type="text" name="search" class="search_cmp search_what form-control" placeholder="<?php echo $lang['search']; ?>" class="form-margin" style="height:22px;" />
	        </div>
	        <div class="col-xs-2">
	            <select class="search_where search_cmp form-control col-xs-3" style="height:22px;">
		            <option value=""><?php echo $lang['search_in']; ?>...</option>
		            <option value="customer"><?php echo $lang['search_in_customer']; ?></option>
		            <option value="id"><?php echo $lang['search_in_nbr_quote']; ?></option>
		            <option value="oder_number"><?php echo $lang['search_in_nbr_command']; ?></option>
		            <option value="customer_id"><?php echo $lang['search_in_nbr_customer']; ?></option>
		            <option value="date"><?php echo $lang['search_in_quote_date']; ?></option>
		            <option value="date_end"><?php echo $lang['search_in_quote_end']; ?></option>
	            </select>
	        </div>
	        	
	        <div style="display:block;padding-top: 30px;">
			              <table id="example2" class="table table-bordered table-hover invoice_list">
                    <thead>
                      <tr>
                        <th><?php echo $lang['adressnumber']; ?></th>
                        <th><?php echo $lang['customer_name']; ?></th>
                        <th class="dates"><?php echo $lang['date']; ?></th>
                        <th class="smart_hidden dates"><?php echo $lang['date_end']; ?></th>
                        <th><i class="fa fa-archive" title="<?php echo $lang['archived_invoices']; ?>"></i></th>
                        <th class="amount_title"><?php echo $lang['balance']; ?></th>
                        <th><?php echo $lang['total']; ?></th>
                      </tr>
                    </thead>
                    <tbody>

	              <?php
		              $results = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'invoices WHERE archived="false"');
		              if(isset($results[0]->id)){
			              ?>
			                                  <?php
	                    foreach($results as $r){
		                    $customer = unserialize($r->customer);
		                    $total = 0;
		                    $taxes = 0;
		                    foreach(unserialize($r->products) as $p){
			                    $total += $p['qty']*$p['price'];
			                    $taxes += $p['qty']*($p['price']*$p['taxes']/100);
		                    }
		                    $t = $total + $taxes;
		                   echo '
						   <tr id="' . $r->id . '">
	                        <td onclick="selection(' . $r->id . ');">' . $r->id . '</td>
	                        <td onclick="selection(' . $r->id . ');">' . $customer[0] . '</td>
	                        <td onclick="selection(' . $r->id . ');" class="date">' . $r->date . '</td>
	                         <td onclick="selection(' . $r->id . ');" class="smart_hidden"';
							if(strtotime(str_replace('/', '-', $r->date_end)) < strtotime(date('Y-m-d'))){echo ' style="color:red;"';}
	                        echo '>' . $r->date_end . '</td>
	                        <td onclick="selection(' . $r->id . ');">';
	                        if($r->archived == 'true'){echo '<i class="fa fa-archive"></i>';}
	                        echo '
	                       </td>
	                       <td class="amount"><a href="#" onclick="list_payments(' . $r->id . ');return false;">'; 
	                       // Calcul du solde
	                       $solde = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'payments WHERE id_invoice="' . $r->id . '" ');
	                       $solde_total = 0;
	                       foreach($solde as $s){$solde_total += $s->amount;}
	                       echo $t - $solde_total . $bd->get_option('money_symbole');
	                       echo '</a></td><td onclick="selection(' . $r->id . ');">' . $t . $bd->get_option('money_symbole') . '</td>
	                      </tr>
                      '; 
	                    }
	                    ?>
			              <?php
		              }else{
			              echo '<div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-info"></i> ' . $lang['invoice_empty_title'] . '</h4>
                    ' . $lang['invoice_empty_text'] . '
                  </div>
                    ';
		              }
		              ?>
                    </tbody>
                    </tfoot>
                  </table>
</div>
                                  </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
     <?php include('include/footer.php'); ?>
     <script language="JavaScript">
	     function selection(id){
		    if(jQuery('#'+id).hasClass('selected')){
			    document.location.href="edit-invoice.php?id_invoice="+id;
			}else{
			    jQuery('tr').removeClass('selected');
			    jQuery('#'+id).addClass('selected');
			    jQuery('.newinvoice').css('opacity','1').attr('href','new-invoice.php?id_customer='+id);
			    jQuery('.archive').css('opacity','1').attr('href','invoices.php?archive='+id);
			    jQuery('.duplicate').css('opacity','1').attr('href','new-invoice.php?duplicate_invoice='+id);
			    jQuery('.newinvoice').css('opacity','1').attr('href','new-invoice.php?id_customer='+id);
			    jQuery('.print').css('opacity','1').attr('href','print-docs.php?id_invoice='+id);
			    jQuery('.ticket').css('opacity','1').attr('href','print-docs-ticket.php?id_invoice='+id);
			    jQuery('.export').css('opacity','1').attr('href','export-docs.php?id_invoice='+id);
			    jQuery('.new_payment').css('opacity','1').attr('onclick','new_payment('+id+');');
			}
	     }
	     function refresh_invoice(){
	    	var statut = $('.get_archived').val();
		    var search_what = $('.search_what').val();
		    var search_where = $('.search_where').val();
		    $.get('ajax.php',
			   { get_invoice: statut,
				 search_what: search_what,
				 search_where: search_where
			   },
			   function(data){
				 $('.alert').hide();
			     $('.invoice_list tbody').html('');
			     $(data).appendTo('.invoice_list tbody');
			   });
	     }
	     function new_payment(id){
		    $('.payment_id').val(id);
		    var amount = $('#'+id).children('.amount').text();
		    var date = $('#'+id).children('.date').text();
		    amount = amount.replace('<?php echo $bd->get_option('money_symbole'); ?>','');
		    $('.payment_amount').val(amount);
		    $('.payment_date').val(date);
		    $('.payment_box').fadeIn();
	     }
	     function valid_payment(){
		     var id = $('.payment_id').val();
		     var date = $('.payment_date').val();
		     var mode = $('.payment_mode').val();
		     var amount = $('.payment_amount').val();
		     $.get('ajax.php',
			   { submit_payment: 'true',
				 id: id,
				 date: date,
				 mode: mode,
				 amount: amount
			   },
			   function(data){
			     $('.payment_box').fadeOut();
			     refresh_invoice();
			   });
	     }
	     function list_payments(id){
			     $('.payments_box').hide();
				 $('.payments_list tbody').html('');
		     $.get('ajax.php',
			   { list_payment: 'true',
				 id: id
			   },
			   function(data){
			     $(data).appendTo('.payments_list tbody');
			     $('.payments_box').fadeIn();
			   });
	     }
	    (function($){
		    $('.get_archived,.search_what,.search_where').change(function(){
			    refresh_invoice();
			});
		})(jQuery);
     </script>
