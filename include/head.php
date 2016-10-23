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
	include('config.php');	
	
?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>MyLittleInvoice | Tableau de bord</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
    <!-- FontAwesome 4.3.0 -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />    
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Date Picker -->
    <link href="plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php if(isset($insert_in_head)){echo $insert_in_head;} ?>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
    <script type="text/javascript">
	    jQuery(function(){
		    jQuery(document).keydown(function (event){
		        // Raccourci Devis
		        if ((event.ctrlKey || event.metaKey) && event.shiftKey && event.which == 68){
			        window.open('quotes.php');
			        event.preventDefault();
			        return false;
		        }
		        if ((event.ctrlKey || event.metaKey) && event.which == 68){
			        window.open('new-quote.php');
			        event.preventDefault();
			        return false;
		        }
		        // Raccourci Factures
		        if ((event.ctrlKey || event.metaKey) && event.shiftKey && event.which == 70){
			        window.open('invoices.php');
			        event.preventDefault();
			        return false;
		        }
		        if ((event.ctrlKey || event.metaKey) && event.which == 70){
			        window.open('new-invoice.php');
			        event.preventDefault();
			        return false;
		        }
		        // Raccourci clients
		        if ((event.ctrlKey || event.metaKey) && event.shiftKey && event.which == 67){
			        window.open('customers.php');
			        event.preventDefault();
			        return false;
		        }
		        if ((event.ctrlKey || event.metaKey) && event.which == 67){
			        window.open('new-customer.php');
			        event.preventDefault();
			        return false;
		        }
	        });
	        
	    });
    </script>
  </head>
