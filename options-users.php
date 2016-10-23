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
	$insert_in_head = '<style type="text/css">
	.new_user, .edit_user{
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
			.new_user h4, .edit_user h4{margin:0;padding:0;margin-bottom:10px;}
			.new_user table,.new_user select, .edit_user table, , .edit_user select{width:100%;}
			.new_user th, .edit_user th{width:50%;}
			.new_user tr, .edit_user tr{height:22px;}
			.new_user input, .edit_user input{height:20px;padding:2px;}
			.close_box{position:absolute;margin-top : 200px;}
			</style>';
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
	        <div class="new_user">
		        <form action="options-users.php" method="POST" id="new_user">
			    	<h4><?php echo $lang['add_user']; ?></h4>
			        <table>
				        <tr><th><?php echo $lang['users_mail']; ?> :</th><td><input type="text" name="mail" placeholder="<?php echo $lang['users_mail']; ?>" /></td></tr>
				        <tr><th><?php echo $lang['user_password']; ?> :</th><td><input type="password" name="password" placeholder="<?php echo $lang['user_password']; ?>" /></td></tr>
				        <tr><th><?php echo $lang['users_rank']; ?> :</th><td><input type="text" name="rank" placeholder="<?php echo $lang['user_rank_em']; ?>" /></td></tr>
			        </table><br />
			        <a href="#" type="submit" class="btn btn-success btn-xs pull-right" onclick="jQuery('#new_user').submit();"><i class="fa fa-save"></i> <?php echo $lang['save']; ?></a>
			<a href="#" class="btn btn-default btn-xs" onclick="jQuery('.new_user').fadeOut();"><i class="fa fa-close"></i> <?php echo $lang['cancel']; ?></a>
		        </form>
	        </div>
	        <div class="edit_user">
		        <form action="options-users.php" method="POST" id="edit_user">
			    	<h4><?php echo $lang['edit_user']; ?></h4>
			        <table>
			        </table><br />
			        <a href="#" type="submit" class="btn btn-success btn-xs pull-right" onclick="jQuery('#edit_user').submit();"><i class="fa fa-save"></i> <?php echo $lang['save']; ?></a>
			<a href="#" class="btn btn-default btn-xs" onclick="jQuery('.edit_user').fadeOut();"><i class="fa fa-close"></i> <?php echo $lang['cancel']; ?></a>
		        </form>
	        </div>
          <h1>
           <i class="fa fa-users"></i> <?php echo $lang['users']; ?>
            <small></small>
			<a href="#" class="btn btn-success btn-xs" onclick="jQuery('.new_user').fadeIn();"><i class="fa fa-user-plus"></i> <?php echo $lang['new_user']; ?></a>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $lang['home']; ?></a></li>
            <li><a href="#"><i class="fa fa-gears"></i> <?php echo $lang['settings']; ?></a></li>
            <li class="active"><i class="fa fa-users"></i> <?php echo $lang['users']; ?></li>
          </ol>
        </section>
        <!-- Main content -->
        <!-- Main content -->
        	<section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-10">
            
              <!-- Dénomination box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $lang['users_list']; ?></h3>
                </div>
                <div class="box-body">
	                <?php 
		                if(!empty($_POST['mail']) AND !empty($_POST['password']) AND !empty($_POST['rank'])){
			                if($bd->insert($bd->prefix . 'users',array('mail'=>$_POST['mail'],'password'=>sha1($_POST['mail'].$_POST['password']),'rank'=>$_POST['rank'],'date_add'=>date('d/m/Y')))){
				                echo '<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="icon fa fa-check"></i> ' . $lang['new_user_success'] . '
                  </div>';
			                }
		                }
		                if(!empty($_POST['edit_mail']) AND !empty($_POST['id_user']) AND !empty($_POST['edit_rank'])){
			                if(!empty($_POST['edit_password'])){
				                $bd->update($bd->prefix . 'users',array('mail'=>$_POST['edit_mail'],'password'=>sha1($_POST['edit_mail'].$_POST['edit_password']),'rank'=>$_POST['edit_rank']),array('id'=>$_POST['id_user']));
				                echo '<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="icon fa fa-check"></i> ' . $lang['edit_user_success'] . '
                  </div>';
			                }else{
				                $bd->update($bd->prefix . 'users',array('mail'=>$_POST['edit_mail'],'rank'=>$_POST['edit_rank']),array('id'=>$_POST['id_user']));
				                echo '<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="icon fa fa-check"></i> ' . $lang['edit_user_success'] . '
                  </div>';

			                }
		                }
	                ?>
	                <table class="table table-bordered table-hover">
		                <thead>
			                <tr>
				                <th><?php echo $lang['users_mail']; ?></th>
				                <th><?php echo $lang['users_rank']; ?></th>
				                <th><?php echo $lang['users_date']; ?></th>
			                </tr>
		                </thead>
		                <tbody>
			                <?php 
				                $users = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'users');
				                foreach($users as $user){
					                echo '<tr id="' . $user->id . '" onclick="selection(' . $user->id . ');"><td>' . $user->mail . '</td><td>' . $user->rank . '</td><td>' . $user->date_add . '</td></tr>';
				                }
			                ?>
		                </tbody>
	                </table>
	                
                </div>
              </div>
            </div>
          </div>
        </div>
     <?php include('include/footer.php'); ?>
 <script type="text/javascript">
	 function selection(id){
		    if(jQuery('#'+id).hasClass('selected')){
			    $.get('ajax.php',
			   { edit_user: 'true',
				 id: id
			   },
			   function(data){
	 		     $('.edit_user table').html('');
			     $(data).appendTo('.edit_user table');
			     $('.edit_user').fadeIn();
			   });
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
			    (function($){

				})(jQuery);
</script>