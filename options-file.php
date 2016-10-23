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
           <i class="fa fa-file"></i> <?php echo $lang['options_documents'] ?>
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $lang['home'] ?></a></li>
            <li><a href="#"><i class="fa fa-gears"></i> <?php echo $lang['settings'] ?></a></li>
            <li class="active"><i class="fa fa-file"></i> <?php echo $lang['documents'] ?></li>
          </ol>
        </section>
        <!-- Main content -->
        <form action="options-file.php" method="post">
	        <input type="hidden" name="update_file" value="true" />
        	<section class="content">
	        	<?php
					if(isset($_POST['update_file'])){
						if($bd->set_option('money_symbole',$_POST['money_symbole']) AND $bd->set_option('default_taxs',$_POST['default_taxs']) AND $bd->set_option('default_invoice_informations',$_POST['default_invoice_informations']) AND $bd->set_option('default_quote_validity',$_POST['default_quote_validity']) AND $bd->set_option('default_invoice_term',$_POST['default_invoice_term']) AND $bd->set_option('default_invoice_footer',$_POST['default_invoice_footer'])){
							echo ' <div class="alert alert-success alert-dismissable" style="height:25px;padding:2px;padding-right:30px;">
	                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                    <h4>	<i class="icon fa fa-check"></i> ' . $lang['option_coordinated_success'] . '</h4></div>';
					}else{
						echo ' <div class="alert alert-danger alert-dismissable" style="height:25px;padding:2px;padding-right:30px;">
	                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                    <h4>	<i class="icon fa fa-ban"></i> ' . $lang['option_coordinated_error'] . '</h4></div>';
					}					}
				?>
          <div class="row">
	          
            <!-- left column -->
            <div class="col-md-6">
            
              <!-- Dénomination box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $lang['option_money'] ?></h3>
                </div>
                <div class="box-body">
                      <table  class="table table-bordered" style="width:100%">
	                     <tbody>
		                      <tr>
		                      <th><?php echo $lang['money_sing'] ?> :</th>
		                      <td><input type="text" name="money_symbole" class="form-control form-margin pull-right" placeholder="<?php echo $lang['money_sing'] ?>" value="<?php echo $bd->get_option('money_symbole'); ?>" /></td>
	                      </tr>
	                      <tr>
		                      <th><?php echo $lang['taxes_default_amount'] ?> :</th>
		                      <td><input type="text" name="default_taxs" class="form-control form-margin pull-right" placeholder="<?php echo $lang['taxes_default_input'] ?>" value="<?php echo $bd->get_option('default_taxs'); ?>" /></td>
	                      </tr>
	                     </tbody>
                      </table>
                  </div><!-- /.box-body -->
              </div><!-- /.box -->
              
              <!-- Contact box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $lang['default_infobox_title'] ?></h3><br />
                  <i><?php echo $lang['default_infobox_em'] ?> </i>
                </div>
                <div class="box-body">
                  <textarea name="default_invoice_informations" style="width:100%;" placeholder="<?php echo $lang['default_infobox_textarea'] ?>"><?php echo $bd->get_option('default_invoice_informations'); ?></textarea>
                
                </div><!-- /.box-body -->
              </div><!-- /.box -->
			  
            </div><!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">
	             <!-- Dénomination box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $lang['dates'] ?></h3>
                </div>
                <div class="box-body">    
	                <table  class="table table-bordered" style="width:100%">
	                     <tbody>
		                      <tr>
		                      <th><?php echo $lang['default_quotes_delay'] ?></th>
		                      <td> <input type="text" class="form-control form-margin" placeholder="<?php echo $lang['default_quotes_delay_input'] ?>" name="default_quote_validity" value="<?php echo $bd->get_option('default_quote_validity'); ?>" /></td>
	                      </tr>
	                      <tr>
		                      <th><?php echo $lang['default_invoice_delay'] ?></th>
		                      <td><input class="form-control form-margin" type="text" placeholder="<?php echo $lang['default_invoice_delay_input'] ?>" name="default_invoice_term" value="<?php echo $bd->get_option('default_invoice_term'); ?>" /></td>
	                      </tr>
	                     </tbody>
                      </table>
                
                   
					
                </div><!-- /.box-body -->
              </div><!-- /.box -->
	            <!-- Adresse box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $lang['default_footer_title'] ?></h3><br />
                  <i><?php echo $lang['default_footer_em'] ?></i>
                </div>
                <div class="box-body">
	                <div class="form-margin">
                    <div class="box-body">
	                  <textarea name="default_invoice_footer" style="width:100%;" placeholder="<?php echo $lang['default_footer_textarea'] ?>"><?php echo $bd->get_option('default_invoice_footer'); ?></textarea><br />
                    <button type="submit" class="btn btn-info pull-right"><?php echo $lang['save']; ?></button>
					</div><!-- /input-group -->
	                </div></div>
                </div><!-- /.box-body -->
                
              </div><!-- /.box -->
            </div><!--/.col (right) -->
          </div>   <!-- /.row -->
        </section><!-- /.content -->
        </form>
     <?php include('include/footer.php'); ?>
 <script type="text/javascript">
			    (function($){
			        jQuery('textarea').wysihtml5();
					jQuery('.btn-group').hide();jQuery('.dropdown').hide();jQuery('.glyphicon-quote').parent('a').hide();jQuery('.glyphicon-list').parent('a').parent('div').hide();jQuery('.glyphicon-share').parent('a').parent('li').hide();jQuery('.glyphicon-picture').parent('a').parent('li').hide();jQuery('a[data-wysihtml5-command=bold]').text('Gras');jQuery('a[data-wysihtml5-command=italic]').text('Italique');jQuery('a[data-wysihtml5-command=underline]').text('Souligné');jQuery('a[data-wysihtml5-command=small]').text('Petit');

				})(jQuery);
</script>