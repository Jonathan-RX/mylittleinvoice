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
           <i class="fa fa-crosshairs"></i> <?php echo $lang['your_coordinated']; ?>
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $lang['home']; ?></a></li>
            <li><a href="#"><i class="fa fa-gears"></i> <?php echo $lang['settings']; ?></a></li>
            <li class="active"><i class="fa fa-crosshairs"></i><?php echo $lang['coordinated']; ?></li>
          </ol>
        </section>
        <!-- Main content -->
        <form action="options-contact.php" method="post">
        	<section class="content">
	        	<?php
				if(isset($_POST['edit_contact']) AND $_POST['edit_contact'] == 'true'){
					$update_contact =array(
					'civility'=>$_POST['civility'],
					'name'=>$_POST['name'],
					'namecomplet'=>$_POST['namecomplet'],
					'adressnumber'=>$_POST['adressnumber'],
					'adress'=>$_POST['adress'],
					'adresscomplet'=>$_POST['adresscomplet'],
					'postalcode'=>$_POST['postalcode'],
					'city'=>$_POST['city'],
					'country'=>$_POST['country'],
					'phone'=>$_POST['phone'],
					'mobile'=>$_POST['mobile'],
					'fax'=>$_POST['fax'],
					'mail'=>$_POST['mail'],
					'website'=>$_POST['website'],
					'divers'=>$_POST['divers'],
					'rcs'=>$_POST['rcs'],
					'taxe'=>$_POST['taxe']);
					$update_contact = serialize($update_contact);
					if($bd->set_option('entreprise_contact',$update_contact)){
						echo ' <div class="alert alert-success alert-dismissable" style="height:25px;padding:2px;padding-right:30px;">
	                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                    <h4>	<i class="icon fa fa-check"></i>' . $lang['option_coordinated_success'] . '</h4></div>';
					}else{
						echo ' <div class="alert alert-danger alert-dismissable" style="height:25px;padding:2px;padding-right:30px;">
	                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                    <h4>	<i class="icon fa fa-ban"></i> ' . $lang['option_coordinated_error'] . '</h4></div>';
					}
				}
	
		        	$contact = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'options WHERE option_name="entreprise_contact"');
	if(empty($contact[0])){
	$contact=array('civility'=>'','name'=>'','namecomplet'=>'','adressnumber'=>'','adress'=>'','adresscomplet'=>'','postalcode'=>'','city'=>'','country'=>'','phone'=>'','mobile'=>'','fax'=>'','mail'=>'','website'=>'','divers'=>'','rcs'=>'','taxe'=>'');
	}else{
		$contact = unserialize($contact[0]->option_value);
	}
		 ?>
          <div class="row">
	          
            <!-- left column -->
            <div class="col-md-6">
            
              <!-- Dénomination box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $lang['your_denomination']; ?></h3>
                </div>
                <div class="box-body">
	                <div class="input-group form-margin">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><span id="civility"><?php if(empty($contact['civility'])){echo 'Civilité';}else{echo $contact['civility'];} ?></span> <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu">
                        <li><a href="#" onclick="jQuery('input[name=civility]').val('<?php echo $lang['mr'] ?>');jQuery('#civility').text('<?php echo $lang['mr'] ?>');"><?php echo $lang['mr'] ?></a></li>
                        <li><a href="#" onclick="jQuery('input[name=civility]').val('<?php echo $lang['mrs'] ?>');jQuery('#civility').text('<?php echo $lang['mrs'] ?>');"><?php echo $lang['mrs'] ?></a></li>
                        <li><a href="#" onclick="jQuery('input[name=civility]').val('<?php echo $lang['miss'] ?>');jQuery('#civility').text('<?php echo $lang['miss'] ?>');"><?php echo $lang['miss'] ?></a></li>
                        <li class="divider"></li>
                        <li><a href="#" onclick="jQuery('input[name=civility]').val('<?php echo $lang['association'] ?>');jQuery('#civility').text('<?php echo $lang['association'] ?>');"><?php echo $lang['association'] ?></a></li>
                        <li><a href="#" onclick="jQuery('input[name=civility]').val('<?php echo $lang['compagny'] ?>');jQuery('#civility').text('<?php echo $lang['compagny'] ?>');"><?php echo $lang['compagny'] ?></a></li>
                        <li><a href="#" onclick="jQuery('input[name=civility]').val('<?php echo $lang['business'] ?>');jQuery('#civility').text('<?php echo $lang['business'] ?>');"><?php echo $lang['business'] ?></a></li>
                      </ul>
                      <input type="hidden" name="civility" value="<?php echo $contact['civility']; ?>" />
                      <input type="hidden" name="edit_contact" value="true" />
                      </div><!-- /btn-group -->
                    <input type="text" class="form-control" placeholder="<?php echo $lang['name_first_name'] ?>" name="name" value="<?php echo $contact['name']; ?>" />
                  </div><!-- /input-group -->
                  <input class="form-control form-margin" type="text" placeholder="<?php echo $lang['name_complet'] ?>" name="namecomplet" value="<?php echo $contact['namecomplet']; ?>" />
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              
              <!-- Contact box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $lang['your_coordinated']; ?></h3>
                </div>
                <div class="box-body">
                  <div class="input-group form-margin">
	                    <div class="input-group-btn" style="width:46%;padding-right:5px;">
		                    <input type="text" class="form-control" placeholder="<?php echo $lang['phone'] ?>" name="phone" value="<?php echo $contact['phone']; ?>" /> </div>
		                	<input type="text" class="form-control" placeholder="Mobile" name="<?php echo $lang['phone'] ?>" value="<?php echo $contact['mobile']; ?>" />
	                  
					</div><!-- /input-group -->
                  <input type="text" class="form-control form-margin" placeholder="<?php echo $lang['fax'] ?>" name="fax" value="<?php echo $contact['fax']; ?>" />
                  <input type="text" class="form-control form-margin" placeholder="<?php echo $lang['email'] ?>" name="mail" value="<?php echo $contact['mail']; ?>" />
                  <input type="text" class="form-control form-margin" placeholder="<?php echo $lang['website'] ?>" name="website" value="<?php echo $contact['website']; ?>" />
                  <input class="form-control form-margin" type="text" placeholder="<?php echo $lang['infos_div'] ?>" name="divers" value="<?php echo $contact['divers']; ?>" />
                </div><!-- /.box-body -->
              </div><!-- /.box -->
			  
            </div><!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">
	             <!-- Dénomination box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $lang['legal_mentions']; ?> <i style="font-size:0.8em;color:grey;text-align: right;"> <?php echo $lang['optionnal_mention']; ?></i></h3>
                </div>
                <div class="box-body">                    
                    <input type="text" class="form-control form-margin" placeholder="<?php echo $lang['rcs_number']; ?>" name="rcs" value="<?php echo $contact['rcs']; ?>" />
					<input class="form-control form-margin" type="text" placeholder="<?php echo $lang['taxes_number']; ?>" name="taxe" value="<?php echo $contact['taxe']; ?>" />
                </div><!-- /.box-body -->
              </div><!-- /.box -->
	            <!-- Adresse box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $lang['postal_adress']; ?></h3>
                </div>
                <div class="box-body">
	                <div class="form-margin">
                    <div class="input-group form-margin">
	                    <div class="input-group-btn" style="width:18%;padding-right:5px;">
		                    <input type="text" class="form-control" placeholder="<?php echo $lang['adressnumber'] ?>" name="adressnumber" value="<?php echo $contact['adressnumber']; ?>"> </div>
		                	<input type="text" class="form-control" placeholder="<?php echo $lang['adress_1'] ?>" name="adress" value="<?php echo $contact['adress']; ?>" />
	                    </div>
					</div><!-- /input-group -->
                  <input class="form-control form-margin" type="text" placeholder="<?php echo $lang['adress_2'] ?>" name="adresscomplet" value="<?php echo $contact['adresscomplet']; ?>">
                  <div class="input-group form-margin">
	                    <div class="input-group-btn" style="width:30%;padding-right:5px;">
		                    <input type="text" class="form-control" placeholder="<?php echo $lang['postalcode'] ?>" name="postalcode" value="<?php echo $contact['postalcode']; ?>" /> </div>
		                	<input type="text" class="form-control" placeholder="<?php echo $lang['city'] ?>" name="city" value="<?php echo $contact['city']; ?>" />
	                    </div>
	                  <input class="form-control form-margin" type="text" placeholder="<?php echo $lang['country'] ?>" name="country" value="<?php echo $contact['country']; ?>" />
	                  
                    <button type="submit" class="btn btn-info pull-right"><?php echo $lang['save']; ?></button>
					</div><!-- /input-group -->
					
                </div><!-- /.box-body -->
                
              </div><!-- /.box -->
            </div><!--/.col (right) -->
          </div>   <!-- /.row -->
        </section><!-- /.content -->
        </form>
     <?php include('include/footer.php'); ?>