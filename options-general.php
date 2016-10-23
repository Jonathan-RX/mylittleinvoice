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
           <i class="fa fa-sliders"></i> <?php echo $lang['options_generals'] ?>
            <small> <?php echo $lang['options_generals_em'] ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $lang['home'] ?></a></li>
            <li><a href="customers.php"><i class="fa fa-gears"></i> <?php echo $lang['settings'] ?></a></li>
            <li class="active"><i class="fa fa-sliders"></i> <?php echo $lang['options_generals'] ?></li>
          </ol>
        </section>

        <!-- Main content -->
        	<section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-10">
            
              <!-- Dénomination box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $lang['logo'] ?></h3>
                </div>
                <div class="box-body">
	               <em><?php echo $lang['logo_em'] ?></em><br />
	                <?php
		               if ((isset($_FILES['logo']['tmp_name'])&&($_FILES['logo']['error'] == '0'))) { 
							$chemin_destination = './uploads/';     
							$tabExt = array('jpg','gif','png','jpeg');  
							$infosImg = getimagesize($_FILES['logo']['tmp_name']);
							if($infosImg[2] >= 1 && $infosImg[2] <= 14){
								if(($infosImg[0] <= 400) && ($infosImg[1] <= 400)){
									if(move_uploaded_file($_FILES['logo']['tmp_name'], $chemin_destination.$_FILES['logo']['name'])){
										$bd->set_option('logo', $chemin_destination . $_FILES['logo']['name']);
										echo '<div class="alert alert-success alert-dismissable">
		                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                    <h4>	<i class="icon fa fa-check"></i> ' . $lang['logo_success'] . '</h4>
		                    
		                  </div>';
									}else{
										echo '<div class="alert alert-danger alert-dismissable">
					                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					                    <h4><i class="icon fa fa-ban"></i> Erreur!</h4>
					                    ' . $lang['logo_error1'] . '
					                  </div>';
									}     
								}else{
									echo '<div class="alert alert-danger alert-dismissable">
				                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				                    <h4><i class="icon fa fa-ban"></i> Erreur!</h4>
				                    ' . $lang['logo_error2'] . '
				                  </div>';
								}
							}else{
								echo '<div class="alert alert-danger alert-dismissable">
				                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				                    <h4><i class="icon fa fa-ban"></i> Erreur!</h4>
				                    ' . $lang['logo_error3'] . '
				                  </div>';
							}
						}  
		                ?>
	               <?php echo $lang['logo_actual'] ?> :
	               <?php
		               $logo = $bd->get_option('logo');
		               if(!empty($logo) and $logo != '1'){
			               echo '<img src="' . $logo . '" class="pull-right" style="vertical-align:middle;" />';
		               }else{
			               echo '<span class="pull-right">' . $lang['no_logo'] . '</span>';
		               }
		                ?>
		                <br /><br style="clear:both;" />
	               <form method="post" action="options-general.php" enctype="multipart/form-data">     
					<input type="hidden" name="MAX_FILE_SIZE" value="2097152">     
					<input type="file" name="logo">    
					<input type="submit" value="<?php echo $lang['send'] ?>" class="pull-right">    
					</form>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              
              <!-- Contact box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $lang['product_type'] ?></h3>
                </div>
                <div class="box-body">
	                <em><?php echo $lang['product_type_em'] ?></em>
	                <?php
		                if(!empty($_POST['qty'])){
			                $products_type = array();
			                foreach($_POST['qty'] as $key=>$value){
				                $products_type[] = array('qty'=>$_POST['qty'][$key],'ref'=>$_POST['ref'][$key],'description'=>$_POST['description'][$key],'price'=>$_POST['price'][$key],'taxes'=>$_POST['taxes'][$key]);
			                }
			                $bd->set_option('products_type',serialize($products_type));
		                }
		                 ?>
                  <form action="options-general.php" method="POST" class="form">
	                  <table class="table table-bordered products_type">
	                  <thead>
		                  <tr>
			                  <th style="width:20%;"><?php echo $lang['quantity'] ?></th>
			                  <th style="width:20%;"><?php echo $lang['reference'] ?></th>
			                  <th style="width:20%;"><?php echo $lang['description'] ?></th>
			                  <th style="width:20%;"><?php echo $lang['price'] ?></th>
			                  <th style="width:20%;"><?php echo $lang['taxes'] ?></th>
			              </tr>
	                  </thead>
	                  <tbody>
		                  <?php
			                  @$pt = unserialize($bd->get_option('products_type'));
			                  if(!empty($pt) AND is_array($pt)){
				                  foreach($pt as $p){
					                  echo '<tr><td><input type="text" name="qty[]" placeholder="' . $lang['quantity'] . '" value="' . $p['qty'] . '"></td><td><input type="text" name="ref[]" placeholder="' . $lang['reference'] . '" value="' . $p['ref'] . '"></td><td><input type="text" name="description[]" placeholder="' . $lang['description'] . '" value="' . $p['description'] . '"></td><td><input type="text" name="price[]" placeholder="' . $lang['price'] . '" value="' . $p['price'] . '"></td><td><input type="text" name="taxes[]" placeholder="' . $lang['taxes'] . '" value="' . $p['taxes'] . '"></td></tr>';
				                  }
			                  }
			                   ?>
	                  </tbody>
                  </table>
                  <a href="#" class="btn btn-success btn-xs" onclick="add_line();return false;"><?php echo $lang['add_line'] ?></a>
                  <a href="#" class="btn btn-success btn-xs pull-right" onclick="jQuery('.form').submit();return false;"><?php echo $lang['save'] ?></a>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
			  </div>
            </div><!--/.col (left) -->
            <!-- right column -->
                      </div>   <!-- /.row -->
        </section><!-- /.content -->
     <?php include('include/footer.php'); ?>
     <script type="text/javascript">
	     function add_line(){
		     jQuery('<tr><td><input type="text" name="qty[]" placeholder="Qty"></td><td><input type="text" name="ref[]" placeholder="Ref"></td><td><input type="text" name="description[]" placeholder="Description"></td><td><input type="text" name="price[]" placeholder="Prix unitaire"></td><td><input type="text" name="taxes[]" placeholder="Taxes"></td></tr>').appendTo('.products_type tbody');
	     }
     </script>