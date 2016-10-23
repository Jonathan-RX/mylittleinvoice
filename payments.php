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
	$insert_in_head = '<style type="text/css">select{height:15px;}
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
			.payment_box h4{margin:0;padding:0;margin-bottom:10px;}
			.payment_box table,.payment_box select{width:100%;}
			.payment_box th{width:50%;}
			.payment_box input{height:20px;padding:2px;}
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
      
      <?php include('include/header.php'); ?>
      <!-- Left side column. contains the logo and sidebar -->
      <?php include('include/left.php'); ?>
        <!-- Main content -->
        <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
          <i class="fa fa-credit-card"></i>  <?php echo $lang['payments_list']; ?>
                <small></small>   <a href="new-payment.php" class="btn btn-success btn-xs "><i class="fa fa-credit-card"></i> <?php echo $lang['add']; ?></a>
           </h1>
            
          
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $lang['home']; ?></a></li>
            <li class="active"><?php echo $lang['payments']; ?></li>
          </ol>
        </section>
        <!-- Box d'encaissement -->
		<div class="payment_box">
			<h4><?php echo $lang['edit_payment']; ?></h4>
			<table>
				<tr>
					<th><?php echo $lang['invoice_nbr']; ?> :</th>
					<td><input type="text" name="id_invoice" class="form-control payment_id" /></td>
				</tr>
				<tr>
					<th><?php echo $lang['payment_date']; ?> :</th>
					<td><input type="text" name="date" class="form-control payment_date" /></td>
				</tr>
				<tr>
					<th><?php echo $lang['payment_mode']; ?> :</th>
					<td>
						<select name="mode" class="payment_mode">
							<option value="species"><?php echo $lang['species']; ?></option>
							<option value="check"><?php echo $lang['check']; ?></option>
							<option value="transfer"><?php echo $lang['transfer']; ?></option>
							<option value="paypal"><?php echo $lang['paypal']; ?></option>
							<option value="creditcard"><?php echo $lang['credit_card']; ?></option>
							<option value="mandate"><?php echo $lang['money_order']; ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<th><?php echo $lang['amount']; ?> :</th>
					<td><input type="text" name="amount" class="form-control payment_amount" /></td>
				</tr>
			</table>
			<a href="#" class="btn btn-success btn-xs valid_customer" style="float:right;margin-top:5px;" onclick="valid_payment();"><?php echo $lang['validate']; ?></a>
			<a href="#" class="btn btn-default btn-xs" onclick="jQuery('.payment_box').fadeOut();"><?php echo $lang['cancel']; ?></a>
		</div>
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
	          <div class="box">
                 <div class="box-body">
	        
	              <?php
		              $results = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'payments');
		              if(isset($results[0]->id)){
			              ?>
			              <div class="col-xs-2 legend"><?php echo $lang['display']; ?> : </div>
	           
	        <div class="col-xs-2">
		        <input type="text" name="search" class="search_cmp search_what form-control" placeholder="<?php echo $lang['search']; ?>" class="form-margin" style="height:22px;" />
	        </div>
	        <div class="col-xs-2">
	            <select class="search_where search_cmp form-control col-xs-3" style="height:22px;">
		            <option value=""><?php echo $lang['search_in']; ?>...</option>
		            <option value="id_invoice"><?php echo $lang['invoice_nbr']; ?></option>
		            <option value="date"><?php echo $lang['payment_date']; ?></option>
		            <option value="mode"><?php echo $lang['payment_mode']; ?></option>
		            <option value="amount"><?php echo $lang['amount']; ?></option>
	            </select>
	        </div>
	        	
	        <div style="display:block;padding-top: 30px;">
			              <table class="table table-bordered table-hover payments_list">
                    <thead>
                      <tr>
                        <th><?php echo $lang['adressnumber']; ?></th>
                        <th><?php echo $lang['date']; ?></th>
                        <th><?php echo $lang['invoice_nbr']; ?></th>
                        <th><?php echo $lang['mode']; ?></th>
                        <th><?php echo $lang['amount']; ?></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
	                    foreach($results as $r){
		                   echo '
						   <tr id="' . $r->id . '">
	                        <td onclick="selection(' . $r->id . ');">' . $r->id . '</td>
	                        <td onclick="selection(' . $r->id . ');" class="date">' . $r->date . '</td>
	                        <td onclick="selection(' . $r->id . ');">' . $r->id_invoice . '</td>
	                        <td class="mode">'; 
	                       // Calcul du solde
	                       switch ($r->mode) {
							case 'species':
								echo $lang['species'];
								break;
							case 'check':
								echo $lang['check'];
								break;
							case 'transfer':
								echo $lang['transfer'];
								break;
							case 'paypal':
								echo $lang['paypal'];
								break;
							case 'creditcard':
								echo $lang['credit_card'];
								break;
							case 'mandate':
								echo $lang['money_order'];
								break;
							}
	                       echo '</td><td onclick="selection(' . $r->id . ');">' . $r->amount . $bd->get_option('money_symbole') . '</td>
	                      </tr>'; 
	                    }
	                    ?>
                    </tbody>
                  </table>
</div>
			              <?php
		              }else{
			              echo '<div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-info"></i> ' . $lang['payment_info_title'] . '</h4>
                    ' . $lang['payment_info_text'] . '
                  </div>';
		              }
		              ?>
                                  </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
     <?php include('include/footer.php'); ?>
     <script language="JavaScript">
	     function refresh_payment(){
		     var search_what = $('.search_what').val();
		     var search_where = $('.search_where').val();
		     jQuery.get('ajax.php',
			   { refresh_payment: 'true',
				 search_what: search_what,
				 search_where: search_where
			   },
			   function(data){
			     jQuery('.payments_list TBODY').html('');
			     jQuery(data).appendTo('.payments_list tbody');
			   });
	     }
	     function edit_payment(id){
		     $.get('ajax.php',
			   { load_payment: 'true',
				 id: id
			   },
			   function(data){
			     $('.payment_box').html('');
			     $(data).appendTo('.payment_box');
			     $('.payment_box').fadeIn();
			   });
	     }
	     function valid_edit(){
		     var id = $('input[name=id]').val();
		     var id_invoice = $('input[name=id_invoice]').val();
		     var date = $('input[name=date]').val();
		     var mode = $('select option:selected').val();
		     var amount = $('input[name=amount]').val();
		     $.get('ajax.php',
			   { edit_payment: 'true',
				 id: id,
				 id_invoice: id_invoice,
				 date: date,
				 mode: mode,
				 amount: amount
			   },
			   function(data){
			     $('.payment_box').fadeOut();
			     refresh_payment();
			   });
	     }
	     function selection(id){
		    if(jQuery('#'+id).hasClass('selected')){
			    edit_payment(id);
			}else{
			    jQuery('tr').removeClass('selected');
			    jQuery('#'+id).addClass('selected');
			}
	     }
	    (function($){
		    refresh_payment();
		    $('.search_what,.search_where').change(function(){
			    refresh_payment();
			});
		})(jQuery);
     </script>