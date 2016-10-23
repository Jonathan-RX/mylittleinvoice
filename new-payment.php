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
				height: 250px;
				border:1px solid #888;
				background:#fff;
			}
			.payment_box h4{margin:0;padding:0;margin-bottom:10px;}
			.payment_box table,.payment_box select{width:100%;}
			.payment_box th{width:50%;}
			.payment_box input{height:22px;padding:2px;}
			.close_box{position:absolute;margin-top : 200px;}
			.payment_mode, .payment_mode *{padding:0;height:22px;}
	</style>';
	include('include/head.php');
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
           <i class="fa fa-credit-card"></i> <?php echo $lang['new_payment']; ?>
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $lang['home']; ?></a></li>
            <li><a href="customers.php"><?php echo $lang['payments']; ?></a></li>
            <li class="active"><?php echo $lang['new_payment']; ?></li>
          </ol>
        </section>

        <!-- Main content -->
        <form action="payments.php" method="post">
        	<section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-6">
            
              <!-- Dénomination box -->
          
              
              <!-- Payment box -->
              <div class="box box-primary payment_box">
                <div class="box-body">
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
						<select name="mode" class="payment_mode form-control">
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
			<br />
                  <a href="payments.php" class="btn btn-default"><?php echo $lang['cancel']; ?></a>
                  <button type="submit" class="btn btn-info pull-right"><?php echo $lang['save']; ?></button>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
			  
            </div><!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">
	            <!-- Adresse box -->
            </div>
            </div><!--/.col (right) -->
          </div>   <!-- /.row -->
        </section><!-- /.content -->
        </form>
     <?php include('include/footer.php'); ?>