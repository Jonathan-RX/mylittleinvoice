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
	$insert_in_head = '<style type="text/css">select{height:15px;padding:0;}.dates{width:10%;}.quote_list tbody td{cursor:pointer;}</style>';
	$ua = $_SERVER['HTTP_USER_AGENT'];
			if (preg_match('/iphone/i',$ua) || preg_match('/android/i',$ua) || preg_match('/blackberry/i',$ua) || preg_match('/symb/i',$ua) || preg_match('/ipod/i',$ua) || preg_match('/phone/i',$ua)){
				$insert_in_head .= '<link rel="stylesheet" type="text/css" href="dist/css/smartphones.css" />';
			}

	include('include/head.php');
	global $bd;
	global $lang;
	if(isset($_GET['archive'])){
		$archive = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'quotes WHERE id="' . $_GET['archive'] . '"');
		if($archive['0']->archived == 'true'){$ar = 'false';}else{$ar = 'true';}
		$bd->update($bd->prefix.'quotes',array('archived'=>$ar),array('id'=>$_GET['archive']));
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
            <i class="fa fa-file-text-o"></i> <?php echo $lang['quotes_list']; ?>
                <small></small>   
           </h1>
            <br />
          <a href="new-quote.php" class="btn btn-success btn-xs"><i class="fa fa-file-text-o"></i> <?php echo $lang['add']; ?></a>
<a href="#" class="btn btn-primary btn-xs duplicate" style="opacity: 0.4;"><i class="fa fa-plus-square-o"></i> <?php echo $lang['duplicate']; ?></a>
<a href="#" class="btn btn-default btn-xs archive" style="opacity: 0.4;"><i class="fa fa-plus-square-o"></i> <?php echo $lang['archive']; ?></a>
<a href="#" class="btn btn-info btn-xs newinvoice" style="opacity: 0.4;"><i class="fa fa-plus-square"></i> <?php echo $lang['invoice']; ?></a>
<a href="#" class="btn btn-warning btn-xs print" target="_blank" style="opacity: 0.4;"><i class="fa fa-print"></i></i> <?php echo $lang['print']; ?></a>
<a href="#" class="btn btn-success btn-xs export" target="_blank" style="opacity: 0.4;"><i class="fa fa-download"></i><?php echo $lang['pdf_button']; ?></a>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $lang['home']; ?></a></li>
            <li class="active"><?php echo $lang['quotes']; ?></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
	          <div class="box">
                 <div class="box-body">
	              
	        <div class="col-xs-2 legend"><?php echo $lang['display']; ?> : </div>
	            <div class="col-xs-2">
                    <select class="get_archived search_cmp form-control col-xs-3" style="height:22px;padding:0;">
		                <option value="current"><?php echo $lang['archive_current']; ?></option>
		                <option value="archived"><?php echo $lang['archive_archived']; ?></option>
		                <option value="all"><?php echo $lang['archive_all']; ?></option>
	                </select>
	            </div>
	        <div class="col-xs-2">
		        <input type="text" name="search" class="search_cmp search_what form-control" placeholder="<?php echo $lang['search']; ?>" class="form-margin" style="height:22px;padding:0;" />
	        </div>
	        <div class="col-xs-2">
	            <select class="search_where search_cmp form-control col-xs-3" style="height:22px;padding:0;">
		            <option value=""><?php echo $lang['search_in']; ?>...</option>
		            <option value="customer"><?php echo $lang['search_in_customer']; ?></option>
		            <option value="id"><?php echo $lang['search_in_nbr_quote']; ?></option>
		            <option value="oder_number"><?php echo $lang['search_in_nbr_command']; ?></option>
		            <option value="customer_id"><?php echo $lang['search_in_nbr_customer']; ?></option>
		            <option value="date"><?php echo $lang['search_in_quote_date']; ?></option>
		            <option value="date_end"><?php echo $lang['search_in_quote_end']; ?></option>
	            </select>
	        </div>
			              <table id="quotes" class="table table-bordered table-hover quote_list">
                    <thead>
                      <tr>
                        <th><?php echo $lang['adressnumber']; ?></th>
                        <th><?php echo $lang['customer_name']; ?></th>
                        <th class="dates"><?php echo $lang['date']; ?></th>
                        <th class="smart_hidden dates"><?php echo $lang['date_end']; ?></th>
                        <th><i class="fa fa-archive" title="<?php echo $lang['quotes']; ?> <?php echo $lang['archive_archived']; ?>"></i></th>
                        <th><i class="fa fa-file-text" title="<?php echo $lang['quote_to_invoice']; ?>"></i></th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
		              $results = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'quotes WHERE archived="false"');
		              if(isset($results[0]->id)){
			              
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
	                        <td onclick="selection(' . $r->id . ');">' . $r->date . '</td>
	                        <td onclick="selection(' . $r->id . ');" class="smart_hidden"';
							if(strtotime(str_replace('/', '-', $r->date_end)) < strtotime(date('Y-m-d'))){echo ' style="color:red;"';}
	                        echo '>' . $r->date_end . '</td><td>';
	                        if($r->archived == 'true'){echo '<i class="fa fa-archive"></i>';}
	                        echo '
	                       </td><td>';
	                       if($r->invoice == 'true'){echo '<a href="edit-invoice.php?id_invoice=' . $r->invoice_number . '">' . $r->invoice_number . '</a>';}
	                       echo '</td><td onclick="selection(' . $r->id . ');">' . $t .  $bd->get_option('money_symbole') . '</td>
	                      </tr>
                      '; 
	                    }
	                    ?>

			              <?php
		              }else{
			              echo '<br /><br /><div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-info"></i> ' . $lang['quotes_empty_title'] . '</h4>
                    ' . $lang['quotes_empty_text'] . '
                  </div>';
		              }
		              ?>
                                 
                    </tbody>
                  </table> </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
     <?php include('include/footer.php'); ?>
     <script language="JavaScript">
	     function selection(id){
		    if(jQuery('#'+id).hasClass('selected')){
			    document.location.href="edit-quote.php?id_quote="+id;
			}else{
			    jQuery('tr').removeClass('selected');
			    jQuery('#'+id).addClass('selected');
			    jQuery('.newquote').css('opacity','1').attr('href','new-quote.php?id_customer='+id);
			    jQuery('.archive').css('opacity','1').attr('href','quotes.php?archive='+id);
			    jQuery('.duplicate').css('opacity','1').attr('href','new-quote.php?duplicate_quote='+id);
			    jQuery('.newinvoice').css('opacity','1').attr('href','new-invoice.php?convert_quote='+id);
			    jQuery('.print').css('opacity','1').attr('href','print-docs.php?id_quote='+id);
			    jQuery('.export').css('opacity','1').attr('href','export-docs.php?id_quote='+id);
			}
	     }
	     function refresh_quote(){
	    	var statut = $('.get_archived').val();
		    var search_what = $('.search_what').val();
		    var search_where = $('.search_where').val();
		    $.get('ajax.php',
			   { get_quote: statut,
				 search_what: search_what,
				 search_where: search_where
			   },
			   function(data){
				 $('.alert').hide();
			     $('.quote_list tbody').html('');
			     $(data).appendTo('.quote_list tbody');
			   });
	     }
	    (function($){
		    $('.get_archived').change(function(){
			    refresh_quote();
			});
			$('.search_what').change(function(){
			    refresh_quote();
			});
			$('.search_where').change(function(){
			    refresh_quote();
			});
		})(jQuery);
     </script>
