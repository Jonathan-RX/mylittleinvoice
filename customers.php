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
	include('include/head.php');
	global $bd;
	global $lang;
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
           <i class="fa fa-users"></i> <?php echo $lang['customers_list']; ?>
                <small></small>   <a href="new-customer.php" class="btn btn-success btn-xs"><i class="fa fa-user-plus"></i> <?php echo $lang['add']; ?></a>
<a href="#" class="btn btn-info btn-xs newquote" style="opacity: 0.4;"><i class="fa fa-plus-square-o"></i> <?php echo $lang['quote']; ?></a>
<a href="#" class="btn btn-warning btn-xs newinvoice" style="opacity: 0.4;"><i class="fa fa-plus-square"></i> <?php echo $lang['invoice']; ?></a>
            
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $lang['home']; ?></a></li>
            <li class="active"><i class="fa fa-user"></i> <?php echo $lang['customers']; ?></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
	    <?php 
		  	/* Trainement du formulaire */
		    if(isset($_POST['new_customer']) && $_POST['new_customer'] == 'true'){
			    $insert = array(
				    'civility'=>$_POST['civility'],
				    'name'=>$_POST['name'],
				    'namecomplet'=>$_POST['namecomplet'],
				    'adressnumber'=>$_POST['adressnumber'],
				    'adress'=>$_POST['adress'],
				    'adresscomplet'=>$_POST['adresscomplet'],
				    'postalcode'=>$_POST['postalcode'],
				    'city'=>$_POST['city'],
				    'country'=>$_POST['country'],
				    'adressdivers'=>$_POST['adressdivers'],
				    'phone'=>$_POST['phone'],
				    'mobile'=>$_POST['mobile'],
				    'fax'=>$_POST['fax'],
				    'mail'=>$_POST['mail'],
				    'website'=>$_POST['website'],
				    'divers'=>$_POST['divers'],
				    'date_add'=>date('d/m/Y'));
				if($bd->insert($bd->prefix . 'customers', $insert)){
					echo ' <div class="alert alert-success alert-dismissable" style="height:25px;padding:2px;padding-right:30px;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4>	<i class="icon fa fa-check"></i> ' . $lang['add_customer_success'] . '</h4></div>';
				}else{
					echo ' <div class="alert alert-danger alert-dismissable" style="height:25px;padding:2px;padding-right:30px;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4>	<i class="icon fa fa-ban"></i> ' . $lang['option_coordinated_error'] . '</h4></div>';
				}
			    
		    }
		    if(isset($_POST['edit_customer'])){
			    $update = array(
				    'civility'=>$_POST['civility'],
				    'name'=>$_POST['name'],
				    'namecomplet'=>$_POST['namecomplet'],
				    'adressnumber'=>$_POST['adressnumber'],
				    'adress'=>$_POST['adress'],
				    'adresscomplet'=>$_POST['adresscomplet'],
				    'postalcode'=>$_POST['postalcode'],
				    'city'=>$_POST['city'],
				    'country'=>$_POST['country'],
				    'adressdivers'=>$_POST['adressdivers'],
				    'phone'=>$_POST['phone'],
				    'mobile'=>$_POST['mobile'],
				    'fax'=>$_POST['fax'],
				    'mail'=>$_POST['mail'],
				    'website'=>$_POST['website'],
				    'divers'=>$_POST['divers']);
				if($bd->update($bd->prefix . 'customers', $update, array('id'=>$_POST['edit_customer']))){
					echo ' <div class="alert alert-success alert-dismissable" style="height:25px;padding:2px;padding-right:30px;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4>	<i class="icon fa fa-check"></i> ' . $lang['edit_customer_success'] . '</h4></div>';
				}else{
					echo ' <div class="alert alert-danger alert-dismissable" style="height:25px;padding:2px;padding-right:30px;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4>	<i class="icon fa fa-ban"></i> ' . $lang['option_coordinated_error'] . '</h4></div>';
				}
			    
		    }

		?>
              <div class="box">
                <div class="box-body">
	              <?php
		              $results = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'customers');
		              if(isset($results[0]->id)){
			              ?>
			              <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><?php echo $lang['adressnumber']; ?></th>
                        <th><?php echo $lang['name']; ?></th>
                        <th><?php echo $lang['phones']; ?></th>
                        <th><?php echo $lang['email']; ?></th>
                        <th><?php echo $lang['city']; ?></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
	                    foreach($results as $r){
		                   echo '
						   <tr id="' . $r->id . '">
	                        <td onclick="selection(' . $r->id . ');">' . $r->id . '</td>
	                        <td onclick="selection(' . $r->id . ');">' . $r->name . '</td>
	                        <td>' . $r->phone . ', ' . $r->mobile . '</td>
	                        <td><a href="mailto:' . $r->mail . '">' . $r->mail . '</a></td>
	                        <td onclick="selection(' . $r->id . ');">' . $r->city . '</td>
	                      </tr>
                      '; 
	                    }
	                    ?>
                    </tfoot>
                  </table>

			              <?php
		              }else{
			              echo '<div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-info"></i> ' . $lang['customers_empty_title'] . '</h4>
                    ' . $lang['customers_empty_text'] . '
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
	     function selection(id){
		    if(jQuery('#'+id).hasClass('selected')){
			    document.location.href="edit-customer.php?id="+id;
			}else{
			    jQuery('tr').removeClass('selected');
			    jQuery('#'+id).addClass('selected');
			    jQuery('.newquote').css('opacity','1').attr('href','new-quote.php?id_customer='+id);
			    jQuery('.newinvoice').css('opacity','1').attr('href','new-invoice.php?id_customer='+id);
			}
	     }
     </script>