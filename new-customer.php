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
           <i class="fa fa-user-plus"></i> <?php echo $lang['add_customer_title']; ?>
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $lang['home']; ?></a></li>
            <li><a href="customers.php"><i class="fa fa-user"></i> <?php echo $lang['customers']; ?></a></li>
            <li class="active"><?php echo $lang['add_customer']; ?></li>
          </ol>
        </section>

        <!-- Main content -->
        <form action="customers.php" method="post">
        	<section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-6">
            
              <!-- Dénomination box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $lang['denomination']; ?></h3>
                </div>
                <div class="box-body">
	                <div class="input-group form-margin">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><span id="civility"><?php echo $lang['civility']; ?></span> <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu">
                        <li><a href="#" onclick="jQuery('input[name=civility]').val('<?php echo $lang['mr']; ?>');jQuery('#civility').text('<?php echo $lang['mr']; ?>');"><?php echo $lang['mr']; ?></a></li>
                        <li><a href="#" onclick="jQuery('input[name=civility]').val('<?php echo $lang['mrs']; ?>');jQuery('#civility').text('<?php echo $lang['mrs']; ?>');"><?php echo $lang['mrs']; ?></a></li>
                        <li><a href="#" onclick="jQuery('input[name=civility]').val('<?php echo $lang['miss']; ?>');jQuery('#civility').text('<?php echo $lang['miss']; ?>');"><?php echo $lang['miss']; ?></a></li>
                        <li class="divider"></li>
                        <li><a href="#" onclick="jQuery('input[name=civility]').val('<?php echo $lang['association']; ?>');jQuery('#civility').text('<?php echo $lang['association']; ?>');"><?php echo $lang['association']; ?></a></li>
                        <li><a href="#" onclick="jQuery('input[name=civility]').val('<?php echo $lang['compagny']; ?>');jQuery('#civility').text('<?php echo $lang['compagny']; ?>');"><?php echo $lang['compagny']; ?></a></li>
                        <li><a href="#" onclick="jQuery('input[name=civility]').val('<?php echo $lang['business']; ?>');jQuery('#civility').text('<?php echo $lang['business']; ?>');"><?php echo $lang['business']; ?></a></li>
                      </ul>
                      <input type="hidden" name="civility" value="" />
                      <input type="hidden" name="new_customer" value="true" />
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control" placeholder="<?php echo $lang['name_first_name']; ?>" name="name" />
                  </div><!-- /input-group -->
                  <input class="form-control form-margin" type="text" placeholder="<?php echo $lang['name_complet']; ?>" name="namecomplet" />
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              
              <!-- Contact box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $lang['customer_contact']; ?></h3>
                </div>
                <div class="box-body">
                  <div class="input-group form-margin">
	                    <div class="input-group-btn" style="width:46%;padding-right:5px;">
		                    <input type="text" class="form-control" placeholder="<?php echo $lang['phone']; ?>" name="phone" /> </div>
		                	<input type="text" class="form-control" placeholder="<?php echo $lang['mobile_phone']; ?>" name="mobile" />
	                  
					</div><!-- /input-group -->
                  <input type="text" class="form-control form-margin" placeholder="<?php echo $lang['fax']; ?>" name="fax" />
                  <input type="text" class="form-control form-margin" placeholder="<?php echo $lang['email']; ?>" name="mail" />
                  <input type="text" class="form-control form-margin" placeholder="<?php echo $lang['website']; ?>" name="website" />
                  <input class="form-control form-margin" type="text" placeholder="<?php echo $lang['infos_div']; ?>" name="divers" />
                </div><!-- /.box-body -->
              </div><!-- /.box -->
			  
            </div><!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">
	            <!-- Adresse box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $lang['postal_adress']; ?></h3>
                </div>
                <div class="box-body">
	                <div class="form-margin">
                    <div class="input-group form-margin">
	                    <div class="input-group-btn" style="width:18%;padding-right:5px;">
		                    <input type="text" class="form-control" placeholder="<?php echo $lang['adressnumber']; ?>" name="adressnumber"> </div>
		                	<input type="text" class="form-control" placeholder="<?php echo $lang['adress_1']; ?>" name="adress" />
	                    </div>
					</div><!-- /input-group -->
                  <input class="form-control form-margin" type="text" placeholder="<?php echo $lang['adress_2']; ?>" name="adresscomplet">
                  <div class="input-group form-margin">
	                    <div class="input-group-btn" style="width:30%;padding-right:5px;">
		                    <input type="text" class="form-control" placeholder="<?php echo $lang['postalcode']; ?>" name="postalcode" /> </div>
		                	<input type="text" class="form-control" placeholder="<?php echo $lang['city']; ?>" name="city" />
	                    </div>
	                  <input class="form-control form-margin" type="text" placeholder="<?php echo $lang['country']; ?>" name="country" />
	                  <input class="form-control form-margin" type="text" placeholder="<?php echo $lang['infos_div']; ?>" name="adressdivers" />
					</div><!-- /input-group -->
					<div class="box-footer">
                    <a href="customers.php" class="btn btn-default"><?php echo $lang['cancel']; ?></a>
                    <button type="submit" class="btn btn-info pull-right"><?php echo $lang['save']; ?></button>
                  </div><!-- /.box-footer -->
                </div><!-- /.box-body -->
                
              </div><!-- /.box -->
            </div><!--/.col (right) -->
          </div>   <!-- /.row -->
        </section><!-- /.content -->
        </form>
     <?php include('include/footer.php'); ?>